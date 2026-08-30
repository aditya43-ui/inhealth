<?php
/**
 * - digunakan untuk memanggil view Laporankartupiutang_v, hanya untuk modul akuntansi
 *
 * @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @author       Deni Hamdani    <denihamdani@piindonesia.co.id>
 * @website      <piindonesia.co.id>
 * @wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
 * @package      application.modules.akuntansi
 * @subpackage   models
 * @category     model
 */

class AKLaporankartupiutangV extends LaporankartupiutangV
{
	public $tp;
	public $tgljatuhtempo;
	public $adatglbayar;
	public $totalseluruh;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BankM the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * - digunakan untuk mengenerate data di tabel  kartu hutang
	 * @return \CActiveDataProvider
	 */
	public function searchTable(){
		$criteria = $this->searchCriteria();
		//$criteria->order = " det.ref_id ASC, det.tgltransaksi ASC";
		$criteria->order = "t.penjamin_nama, t.tgltransaksi ASC, debitkredit ASC";
		return new CActiveDataProvider($this, array(
			   'criteria'=>$criteria,
		));
	}

	/**
	 * - digunakan untuk mengenerate data di tabel  kartu hutang  pada prinout
	 * @return \CActiveDataProvider
	 */
	public function searchPrint(){
		$criteria = $this->searchCriteria();
		//$criteria->order = " det.ref_id ASC, det.tgltransaksi ASC";
		$criteria->order = "t.penjamin_nama, t.tgltransaksi ASC, debitkredit ASC";
		return new CActiveDataProvider($this, array(
			   'criteria'=>$criteria,
			   'pagination' => false
		));
	}

	/**
	 * - digunakan untuk mengenerate data target bep dalam bentuk grafik
	 * @return \CActiveDataProvider
	 */
	public function searchGrafik(){
		$criteria = $this->searchCriteria();
		$criteria->select = " count(daftartindakan_id) as jumlah, instalasi_nama as data ";
		$criteria->group = " data ";
		$criteria->order = " jumlah DESC ";
		//if ($_GET['tampilGrafik'] == 'wilayah'){

		 return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

	/**
	 * - digunakan untuk memfilter datanya berdasarkan pencarian yang ada
	 * @return \CActiveDataProvider
	 */
	public function searchCriteria(){
		$criteria = new CDbCriteria();
		//$criteria->addBetweenCondition('DATE(t.tgltransaksi)', $this->tgl_awal, $this->tgl_akhir);

		if (!empty($this->penjamin_id)){
			if (is_array($this->penjamin_id)){
				$criteria->addInCondition(" t.penjamin_id ", $this->penjamin_id);
			}else{
				$criteria->addCondition(" t.penjamin_id = ". $this->penjamin_id);
			}
		}

		$criteria->addCondition("((DATE(bayar.adatglbayar) BETWEEN  '".$this->tgl_awal."' AND '".$this->tgl_akhir."') OR (DATE(t.tgltransaksi) BETWEEN  '".$this->tgl_awal."' AND '".$this->tgl_akhir."')) ");

		$criteria->select = "t.ref_id, t.notransaksi, t.tgltransaksi, t.penjamin_id, t.penjamin_nama, t.debitkredit, t.tgljatuhtempo, bayar.adatglbayar, sum(t.nilaitransaksi) as nilaitransaksi";
		$criteria->join = "left join (
            SELECT distinct on (lapbayar.pengajuanklaimpiutang_id::text) lapbayar.pengajuanklaimpiutang_id::text, lapbayar.tglpembayaranklaim::text as adatglbayar
            FROM lappembayaranklaimpiutang_v lapbayar
            JOIN pengajuanklaimpiutang_t pengajuan ON lapbayar.pengajuanklaimpiutang_id = pengajuan.pengajuanklaimpiutang_id
            order by lapbayar.pengajuanklaimpiutang_id::text, lapbayar.tglpembayaranklaim DESC
        ) bayar on bayar.pengajuanklaimpiutang_id = split_part(t.ref_id,'.',2)";
		$criteria->group = "t.ref_id, t.notransaksi, t.tgltransaksi, t.penjamin_id, t.penjamin_nama, t.debitkredit, t.tgljatuhtempo, bayar.adatglbayar";

		return $criteria;
	}

    /**
     * Laporan List Penjamin
     *
     * @return type
     */
    public function getLaporanPenjaminList() {
        // tanggal sebelumnya

        if (empty($this->tgl_awal) || empty($this->tgl_akhir)) {
            return $res;
        }

        $cr = new CDbCriteria;
        $cr->select = 't.ref_id, t.penjamin_id, t.penjamin_nama';
        $cr->group = 't.ref_id, t.penjamin_id, t.penjamin_nama, k.nilaitransaksi';
        $cr->order = 't.penjamin_nama';
        $cr->addCondition("t.debitkredit = 'D' and t.tgltransaksi::date <= '".$this->tgl_akhir."'::date "
            . "and t.tgltransaksi::date >= '".$this->tgl_awal."'::date");
        $cr->compare("t.penjamin_id", $this->penjamin_id);

        $cr->having = "(sum(t.nilaitransaksi) - (case when k.nilaitransaksi is null then 0 else k.nilaitransaksi end)) > 0";

        $cr->join = "left join (
        select ref_id, sum(nilaitransaksi) as nilaitransaksi
        from laporankartupiutang_v where debitkredit = 'K' and tgltransaksi::date < '".$this->tgl_awal."'::date
        group by ref_id
        ) k on k.ref_id = t.ref_id";

        $res = array();
        $res_debit = CHtml::listData(self::model()->findAll($cr), 'penjamin_id', 'penjamin_nama');
				
        foreach ($res_debit as $penjamin_id => $penjamin_nama) {
            $res[] = array(
                'penjamin_id'=>$penjamin_id,
                'penjamin_nama'=>$penjamin_nama,
            );
        }

        return $res;
    }

    /**
     * List Penjamin untuk Laporan Kartu Piutang
     *
     * @return type
     */
    public function getLaporanKartuPiutangPenjamin() {


        // tanggal sebelumnya

        if (empty($this->tgl_awal) || empty($this->tgl_akhir)) {
            return $res;
        }

        $cr = new CDbCriteria;
        $cr->select = 't.ref_id, t.notransaksi, t.tgltransaksi, t.penjamin_id, t.penjamin_nama, t.debitkredit,
                        sum(t.nilaitransaksi) as nilaitransaksi,
                        (case when k.nilaitransaksi is null then 0 else k.nilaitransaksi end) as terbayar';
        $cr->group = 't.ref_id, t.notransaksi, t.tgltransaksi, t.penjamin_id, t.penjamin_nama, k.nilaitransaksi, '
            . 't.debitkredit';
        $cr->order = 't.penjamin_nama, t.tgltransaksi';
        $cr->addCondition("t.debitkredit = 'D' and t.tgltransaksi::date <= '".$this->tgl_akhir."'::date "
            . "and t.tgltransaksi::date >= '2018-04-01'::date");
        $cr->compare("t.penjamin_id", $this->penjamin_id);

        $cr->having = "(sum(t.nilaitransaksi) - (case when k.nilaitransaksi is null then 0 else k.nilaitransaksi end)) > 0";

        $cr->join = "left join (
        select ref_id, sum(nilaitransaksi) as nilaitransaksi
        from laporankartupiutang_v where debitkredit = 'K' and tgltransaksi::date < '".$this->tgl_awal."'::date
        group by ref_id
        ) k on k.ref_id = t.ref_id";



        // tanggal awal dan akhir

        $crk = new CDbCriteria();
        $crk->select = "t.ref_id, t.notransaksi, t.tgltransaksi, t.penjamin_id, t.penjamin_nama, t.debitkredit,
                        sum(t.nilaitransaksi) as nilaitransaksi";
        $crk->group = "t.ref_id, t.notransaksi, t.tgltransaksi, t.penjamin_id, t.penjamin_nama, t.debitkredit";
        $crk->compare('t.penjamin_id', $this->penjamin_id);
        $crk->addCondition("t.ref_id = :ref_id");
        $crk->addCondition("t.debitkredit = 'K' and t.tgltransaksi::date <= '".$this->tgl_akhir."'::date");
        $crk->order = "t.tgltransaksi";


        $res = array();
        $res_debit = self::model()->findAll($cr);
        $res_final = array();

        foreach ($res_debit as $item) {
            $res[$item->ref_id] = array(
                'd'=>$item,
                'k'=>array()
            );

            $crk->params[':ref_id'] = $item->ref_id;
            $kredit = self::model()->findAll($crk);

            if (count((array)$kredit) > 0) {
                $res[$item->ref_id]['k'] = $kredit;
            }

        }

        foreach ($res as $item) {
            $res_final[] = $item['d'];
            $res_final = array_merge($res_final, $item['k']);
        }

        //$res = $res_debit;

        return $res_final;

    }

}

?>
