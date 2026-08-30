<?php

class KPPegawaiV extends PegawaiV{
	public $kategoripegawaiasal, $npwp, $kodeptkp, $jmltanggunan, $suku_id, $warganegara_pegawai;
	public $kelompokpegawai_nama, $jenistenagamedis_id, $kelompokjabatan, $jeniswaktukerja, $masa_str;
	public $surattandaregistrasi, $masa_sip, $suratizinpraktek, $masa_tenagasehat, $masa_medis;
	public $no_rekening, $bank_no_rekening;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	public function searchPegawaiPelatihan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->order = 'nama_pegawai';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchPegawaiMengetahui()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('pegawai_id = '.$this->pegawai_id);
		}
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->compare('jabatan_id',$this->jabatan_id);
		$criteria->order = 'nama_pegawai';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    
    public function searchPegawaiPemberiTugasPelatihan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('t.pegawai_id = '.$this->pegawai_id);
		}
//        $criteria->join = 'left join jabatan_m j on j.jabatan_id = t.jabatan_id';
//        $criteria->addCondition("j.jabatan_nama ilike '%kepala%' and jabatan_aktif = true"); RSPMC-2108
		$criteria->compare('LOWER(t.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(t.gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(t.gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(t.alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->compare('t.jabatan_id',$this->jabatan_id);
		$criteria->order = 't.nama_pegawai';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function searchPegawaiMengathuiPelatihan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('t.pegawai_id = '.$this->pegawai_id);
		}
        $criteria->join = 'left join jabatan_m j on j.jabatan_id = t.jabatan_id';
        $criteria->addCondition("j.jabatan_nama ilike '%manager%' and jabatan_aktif = true");
		$criteria->compare('LOWER(t.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(t.gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(t.gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(t.alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->compare('t.jabatan_id',$this->jabatan_id);
		$criteria->order = 't.nama_pegawai';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function searchPegawaiMenyetujuiPelatihan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		if(!empty($this->pegawai_id)){
			$criteria->addCondition('t.pegawai_id = '.$this->pegawai_id);
		}
        $criteria->join = 'left join jabatan_m j on j.jabatan_id = t.jabatan_id';
        $criteria->addCondition("j.jabatan_nama ilike '%direktur%' and jabatan_aktif = true");
		$criteria->compare('LOWER(t.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(t.gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(t.gelarbelakang_nama)',strtolower($this->gelarbelakang_nama),true);
		$criteria->compare('LOWER(t.alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->compare('t.jabatan_id',Params::JABATAN_ID_DIREKTUR);
		$criteria->order = 't.nama_pegawai';
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
}