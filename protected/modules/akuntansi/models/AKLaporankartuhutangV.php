<?php
/**
* - digunakan untuk memanggil view Laporankartuhutang_v, hanya untuk modul akuntansi
*
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
*/

class AKLaporankartuhutangV extends LaporankartuhutangV
{
	public $tp;
	public $tgljatuhtempo;
	public $adatglbayar;

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

		$criteria->order = " det.tgltransaksi ASC, det.debitkredit DESC ";




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
		$criteria->order = " det.tgltransaksi ASC, det.debitkredit DESC ";
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
		if (!empty($this->supplier_id)){
			if (is_array($this->supplier_id)){
				$criteria->addInCondition(" t.supplier_id ", $this->supplier_id);
			}else{
				$criteria->addCondition(" t.supplier_id = ". $this->supplier_id);
			}
		}
		//$criteria->addBetweenCondition('DATE(t.tgltransaksi)', $this->tgl_awal, $this->tgl_akhir,'OR');
		//$criteria->addBetweenCondition('DATE(det.adatglbayar)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->addCondition(" ( (DATE(det.adatglbayar) BETWEEN  '".$this->tgl_awal."' AND '".$this->tgl_akhir."') OR (DATE(det.tgltransaksi) BETWEEN  '".$this->tgl_awal."' AND '".$this->tgl_akhir."')) ");
		//$criteria->addCondition("DATE(det.adatglbayar) IS NULL OR DATE(det.adatglbayar) BETWEEN '".$this->tgl_awal."' AND  '".$this->tgl_akhir."' ");


		$criteria->select = " det.* ";
		$criteria->join = " JOIN (select * from (select
					t.*,(CASE WHEN (split_part(ref_id,'.',1) = 'OA')
						THEN
							(SELECT tbk.tglkaskeluar::text FROM bayarkesupplier_t bks JOIN tandabuktikeluar_t tbk ON tbk.tandabuktikeluar_id = bks.tandabuktikeluar_id WHERE bks.fakturpembelian_id::text = split_part(t.ref_id,'.',2) ORDER BY tbk.tglkaskeluar DESC LIMIT 1)
						ELSE
							(SELECT tbk.tglkaskeluar::text FROM bayarkesupplier_t bks JOIN tandabuktikeluar_t tbk ON tbk.tandabuktikeluar_id = bks.tandabuktikeluar_id WHERE bks.terimapersediaan_id::text = split_part(t.ref_id,'.',2)  ORDER BY tbk.tglkaskeluar DESC LIMIT 1)
					END
					) as adatglbayar
					from
						laporankartuhutang_v t) as ab) det ON det.ref_id = t.ref_id ";
		$criteria->group = "det.ref_id, det.notransaksi, det.supplier_id, det.supplier_nama, det.nilaitransaksi, det.debitkredit, det.adatglbayar, det.tgltransaksi, det.tgljatuhtempo, det.jenistransaksi";

		return $criteria;
	}

}

?>
