<?php

/**
 * This is the model class for table "informasijurnaltransaksi_v".
 *
 * The followings are the available columns in table 'informasijurnaltransaksi_v':
 * @property integer $jenisjurnal_id
 * @property string $jenisjurnal_nama
 * @property integer $rekperiod_id
 * @property string $tglbuktijurnal
 * @property string $nobuktijurnal
 * @property string $kodejurnal
 * @property string $noreferensi
 * @property string $tglreferensi
 * @property integer $nobku
 * @property string $urianjurnal
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 * @property integer $jurnalposting_id
 * @property string $tgljurnalpost
 * @property string $keterangan
 * @property integer $rekening1_id
 * @property string $kdrekening1
 * @property string $nmrekening1
 * @property integer $rekening2_id
 * @property string $kdrekening2
 * @property string $nmrekening2
 * @property integer $rekening3_id
 * @property string $kdrekening3
 * @property string $nmrekening3
 * @property integer $rekening4_id
 * @property string $kdrekening4
 * @property string $nmrekening4
 * @property integer $rekening5_id
 * @property string $kdrekening5
 * @property string $nmrekening5
 * @property integer $tiperekening_id
 * @property string $nourut
 * @property string $uraiantransaksi
 * @property double $saldodebit
 * @property double $saldokredit
 * @property boolean $koreksi
 * @property string $catatan
 */
class AKInformasijurnaltransaksiV extends InformasijurnaltransaksiV
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InformasijurnaltransaksiV the static model class
	 */
	public $tgl_awal;
    public $tgl_akhir;
    public $is_posting;
	public $unitkerja_id;
	public $pegawai_id;
    public $create_loginpemakai_id, $jurnalrekening_id, $jurnalbalik_id, $ceklisAktif, $jeniskodejurnal, $chrow;

    public $cehk;
	public static function model($className=__CLASS__){
		return parent::model($className);
	}

	public function getKodeRekening(){
        if(!empty($this->kdrekening5)){
			$kode_rekening = $this->kdrekening1."-".$this->kdrekening2."-".$this->kdrekening3."-".$this->kdrekening4.'-'.$this->kdrekening5;
		}else if(!empty($this->kdrekening4)){
			$kode_rekening = $this->kdrekening1."-".$this->kdrekening2."-".$this->kdrekening3."-".$this->kdrekening4;
		}else if(!empty($this->kdrekening3)){
			$kode_rekening = $this->kdrekening1."-".$this->kdrekening2."-".$this->kdrekening3;
		}else if(!empty($this->kdrekening2)){
			$kode_rekening = $this->kdrekening1."-".$this->kdrekening2;
		}

        return $kode_rekening;
    }
	public function getNamaRekening(){
        if(!empty($this->rekening5_id)){
			$nama_rekening = $this->nmrekening5;
		}else if(!empty($this->rekening4_id)){
			$nama_rekening = $this->nmrekening4;
		}else if(!empty($this->rekening3_id)){
			$nama_rekening = $this->nmrekening3;
		}else if(!empty($this->rekening2_id)){
			$nama_rekening = $this->nmrekening2;
		}

        return $nama_rekening;
    }

	public function searchInfoPosting()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;
		$criteria->addBetweenCondition('DATE(tglbuktijurnal)', MyFormatter::formatDateTimeForDb($this->tgl_awal), MyFormatter::formatDateTimeForDb($this->tgl_akhir));
		$criteria->compare('LOWER(kodejurnal)', strtolower($this->kodejurnal));
		$criteria->compare('nobuktijurnal', $this->nobuktijurnal);
		$criteria->compare('jenisjurnal_id',$this->jenisjurnal_id);
		$criteria->addCondition('jurnalposting_id is null');
		$criteria->compare('LOWER(tglreferensi)',strtolower($this->tglreferensi),true);
		$criteria->compare('nobku',$this->nobku);
		$criteria->compare('LOWER(urianjurnal)',strtolower($this->urianjurnal),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(tgljurnalpost)',strtolower($this->tgljurnalpost),true);
		$criteria->compare('LOWER(keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('rekening1_id',$this->rekening1_id);
		$criteria->compare('LOWER(kdrekening1)',strtolower($this->kdrekening1),true);
		$criteria->compare('LOWER(nmrekening1)',strtolower($this->nmrekening1),true);
		$criteria->compare('rekening2_id',$this->rekening2_id);
		$criteria->compare('LOWER(kdrekening2)',strtolower($this->kdrekening2),true);
		$criteria->compare('LOWER(nmrekening2)',strtolower($this->nmrekening2),true);
		$criteria->compare('rekening3_id',$this->rekening3_id);
		$criteria->compare('LOWER(kdrekening3)',strtolower($this->kdrekening3),true);
		$criteria->compare('LOWER(nmrekening3)',strtolower($this->nmrekening3),true);
		$criteria->compare('rekening4_id',$this->rekening4_id);
		$criteria->compare('LOWER(kdrekening4)',strtolower($this->kdrekening4),true);
		$criteria->compare('LOWER(nmrekening4)',strtolower($this->nmrekening4),true);
		$criteria->compare('rekening5_id',$this->rekening5_id);
		$criteria->compare('LOWER(kdrekening5)',strtolower($this->kdrekening5),true);
		$criteria->compare('LOWER(nmrekening5)',strtolower($this->nmrekening5),true);
		$criteria->compare('tiperekening_id',$this->tiperekening_id);
		$criteria->compare('LOWER(nourut)',strtolower($this->nourut),true);
		$criteria->compare('LOWER(uraiantransaksi)',strtolower($this->uraiantransaksi),true);
		$criteria->compare('saldodebit',$this->saldodebit);
		$criteria->compare('saldokredit',$this->saldokredit);
		$criteria->compare('koreksi',$this->koreksi);
		$criteria->compare('LOWER(catatan)',strtolower($this->catatan),true);
		$criteria->compare('LOWER(jenisjurnal_nama)',strtolower($this->jenisjurnal_nama),true);
		$criteria->compare('rekperiod_id',$this->rekperiod_id);
		$criteria->compare('LOWER(noreferensi)',strtolower($this->noreferensi),true);

		$criteria->limit=-1;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}

	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->join = " JOIN jurnalrekening_t jr ON jr.nobuktijurnal = t.nobuktijurnal "
						. " LEFT JOIN loginpemakai_k lp ON lp.loginpemakai_id = jr.create_loginpemakai_id "
                        . " JOIN rekening5_m rek5 ON rek5.rekening5_id = t.rekening5_id";

        $criteria->group = 't.nourut, t.kodejurnal, t.tglbuktijurnal, t.tglreferensi, t.nobuktijurnal, '
            . 't.noreferensi, t.kdrekening5, t.nmrekening5, jr.urianjurnal, '
            . '(case when t.jurnalposting_id is null then 0 else 1 end), '
            . 'jr.jurnalrekening_id, jr.create_loginpemakai_id, t.uraiantransaksi, jr.jurnalbalik_id, t.jenisjurnal_nama, t.rekening5_id';

        $criteria->select = $criteria->group.', sum(t.saldodebit) as saldodebit, sum(t.saldokredit) as saldokredit,'
            . '(case when t.jurnalposting_id is null then 0 else 1 end) as is_posting';

		if(!empty($this->jenisjurnal_id)){
			$criteria->addCondition("t.jenisjurnal_id = ".$this->jenisjurnal_id);
		}
		$criteria->compare('t.noreferensi',$this->noreferensi);
		if(isset($this->is_posting) && ($this->is_posting != ''))
		{
			if($this->is_posting == 0)
			{
				$criteria->addCondition('t.jurnalposting_id IS NULL');
			}else if($this->is_posting == 1){
				$criteria->addCondition('t.jurnalposting_id IS NOT NULL');
			}
		}

		if (!empty($this->pegawai_id)){
			if (is_numeric($this->pegawai_id)){
				$criteria->addCondition(" lp.pegawai_id = ".$this->pegawai_id." ");
			}else{
				$criteria->addCondition(" lp.loginpemakai_id = ".Params::LOGINPEMAKAI_ID_ADMIN." ");
			}
		}

		$criteria->addBetweenCondition('DATE(t.tglbuktijurnal)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(t.jenisjurnal_nama)',strtolower($this->jenisjurnal_nama),true);
		$criteria->compare('t.rekperiod_id',$this->rekperiod_id);
		$criteria->compare('LOWER(t.kodejurnal)',strtolower($this->kodejurnal),true);
		$criteria->compare('LOWER(t.nobuktijurnal)', strtolower($this->nobuktijurnal), true);
		$criteria->compare('LOWER(t.tglreferensi)',strtolower($this->tglreferensi),true);
		$criteria->compare('t.nobku',$this->nobku);
		$criteria->compare('LOWER(t.urianjurnal)',strtolower($this->urianjurnal),true);
		$criteria->compare('LOWER(t.create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(t.update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(t.create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(t.update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(t.create_ruangan)',strtolower($this->create_ruangan),true);
		$criteria->compare('LOWER(t.tgljurnalpost)',strtolower($this->tgljurnalpost),true);
		$criteria->compare('LOWER(t.keterangan)',strtolower($this->keterangan),true);
		$criteria->compare('t.rekening5_id',$this->rekening5_id);
		$criteria->compare('LOWER(t.kdrekening5)',strtolower($this->kdrekening5),true);
		$criteria->compare('LOWER(t.nmrekening5)',strtolower($this->nmrekening5),true);
		$criteria->compare('t.tiperekening_id',$this->tiperekening_id);
		$criteria->compare('LOWER(t.nourut)',strtolower($this->nourut),true);
		$criteria->compare('LOWER(t.uraiantransaksi)',strtolower($this->uraiantransaksi),true);
		$criteria->compare('t.saldodebit',$this->saldodebit);
		$criteria->compare('t.saldokredit',$this->saldokredit);
		$criteria->compare('t.koreksi',$this->koreksi);
		$criteria->compare('LOWER(t.catatan)',strtolower($this->catatan),true);

                if($this->ceklisAktif){
                    $criteria->addCondition('rek5.rekening5_aktif = false');
                }


		$criteria->order = 't.tglbuktijurnal DESC, t.nobuktijurnal DESC ,t.nourut ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getNamaRekDebit()
    {
		$criteria = new CDbCriteria;
		if(!empty($this->rekening1_id)){
			$criteria->addCondition("rekening1_id = ".$this->rekening1_id);
		}
		if(!empty($this->rekening2_id)){
			$criteria->addCondition("rekening2_id = ".$this->rekening2_id);
		}
		if(!empty($this->rekening3_id)){
			$criteria->addCondition("rekening3_id = ".$this->rekening3_id);
		}
		if(!empty($this->rekening4_id)){
			$criteria->addCondition("rekening4_id = ".$this->rekening4_id);
		}
		if(!empty($this->rekening5_id)){
			$criteria->addCondition("rekening5_id = ".$this->rekening5_id);
		}
		$result = AKInformasijurnaltransaksiV::model()->find($criteria);

		if(isset($result['rekening5_id']))
		{
			$kode_rekening = $result->nmrekening5;
		}else{
			if(isset($result['rekening4_id']))
			{
				$kode_rekening = $result->nmrekening4;
			}else{
				$kode_rekening = $result->nmrekening3;
			}
		}
		return ($this->saldokredit == 0 ? $kode_rekening : "-") ;
    }

    public function getNamaRekKredit()
    {
		$criteria = new CDbCriteria;
		if(!empty($this->rekening1_id)){
			$criteria->addCondition("rekening1_id = ".$this->rekening1_id);
		}
		if(!empty($this->rekening2_id)){
			$criteria->addCondition("rekening2_id = ".$this->rekening2_id);
		}
		if(!empty($this->rekening3_id)){
			$criteria->addCondition("rekening3_id = ".$this->rekening3_id);
		}
		if(!empty($this->rekening4_id)){
			$criteria->addCondition("rekening4_id = ".$this->rekening4_id);
		}
		if(!empty($this->rekening5_id)){
			$criteria->addCondition("rekening5_id = ".$this->rekening5_id);
		}
		$result = AKInformasijurnaltransaksiV::model()->find($criteria);

		if(isset($result['rekening5_id']))
		{
			$kode_rekening = $result->nmrekening5;
		}else{
			if(isset($result['rekening4_id']))
			{
				$kode_rekening = $result->nmrekening4;
			}else{
				$kode_rekening = $result->nmrekening3;
			}
		}
		return ($this->saldodebit == 0 ? $kode_rekening : "-") ;
    }

    public function getRekDebit()
    {
		$criteria=new CDbCriteria;
		if(!empty($this->jurnalrekening_id)){
			$criteria->addCondition("jurnalrekening_id = ".$this->jurnalrekening_id);
		}
		$condition = "saldokredit = 0";
		$criteria->addCondition($condition);
		$result = $this->model()->find($criteria);
		return $result['saldodebit'];
    }

    public function getRekKredit()
    {
		$criteria=new CDbCriteria;
		if(!empty($this->jurnalrekening_id)){
			$criteria->addCondition("jurnalrekening_id = ".$this->jurnalrekening_id);
		}
		$condition = "saldodebit = 0";
		$criteria->addCondition($condition);
		$result = $this->model()->find($criteria);
		return $result['saldokredit'];
    }

    public function getRowColor()
    {
        $data = "odd";
//		$criteria=new CDbCriteria;
//		if(!empty($this->jurnalrekening_id)){
//			$criteria->addCondition("jurnalrekening_id = ".$this->jurnalrekening_id);
//		}
//		$condition = "saldodebit = 0";
//		$criteria->addCondition($condition);
//		$result = $this->model()->find($criteria);
		return $data;
    }

}
