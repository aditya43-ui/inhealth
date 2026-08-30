<?php

class ROPegawaiM extends PegawaiM
{
	public $tgl_awal;
	public $tgl_akhir;
	public $kelompokpegawai_nama;
        
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
	public function searchPegawai()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->pegawai_id)){
			$criteria->addCondition("pegawai_id = ".$this->pegawai_id);					
		}
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id);					
		}
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id);					
		}
		if(!empty($this->profilrs_id)){
			$criteria->addCondition("profilrs_id = ".$this->profilrs_id);					
		}
		if(!empty($this->gelarbelakang_id)){
			$criteria->addCondition("gelarbelakang_id = ".$this->gelarbelakang_id);					
		}
		if(!empty($this->suku_id)){
			$criteria->addCondition("suku_id = ".$this->suku_id);					
		}
		if(!empty($this->kelompokpegawai_id)){
			$criteria->addCondition("kelompokpegawai_id = ".$this->kelompokpegawai_id);					
		}
		if(!empty($this->pendkualifikasi_id)){
			$criteria->addCondition("pendkualifikasi_id = ".$this->pendkualifikasi_id);					
		}
		if(!empty($this->jabatan_id)){
			$criteria->addCondition("jabatan_id = ".$this->jabatan_id);					
		}
		if(!empty($this->pendidikan_id)){
			$criteria->addCondition("pendidikan_id = ".$this->pendidikan_id);					
		}
		if(!empty($this->propinsi_id)){
			$criteria->addCondition("propinsi_id = ".$this->propinsi_id);					
		}
		if(!empty($this->pangkat_id)){
			$criteria->addCondition("pangkat_id = ".$this->pangkat_id);					
		}
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id);					
		}
		$criteria->compare('LOWER(nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(no_kartupegawainegerisipil)',strtolower($this->no_kartupegawainegerisipil),true);
		$criteria->compare('LOWER(no_karis_karsu)',strtolower($this->no_karis_karsu),true);
		$criteria->compare('LOWER(no_taspen)',strtolower($this->no_taspen),true);
		$criteria->compare('LOWER(no_askes)',strtolower($this->no_askes),true);
		$criteria->compare('LOWER(gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(nama_keluarga)',strtolower($this->nama_keluarga),true);
		$criteria->compare('LOWER(tempatlahir_pegawai)',strtolower($this->tempatlahir_pegawai),true);
		$criteria->compare('LOWER(tgl_lahirpegawai)',strtolower($this->tgl_lahirpegawai),true);
		$criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
		$criteria->compare('LOWER(statusperkawinan)',strtolower($this->statusperkawinan),true);
		$criteria->compare('LOWER(alamat_pegawai)',strtolower($this->alamat_pegawai),true);
		$criteria->compare('LOWER(agama)',strtolower($this->agama),true);
		$criteria->compare('LOWER(golongandarah)',strtolower($this->golongandarah),true);
		$criteria->compare('LOWER(rhesus)',strtolower($this->rhesus),true);
		$criteria->compare('LOWER(alamatemail)',strtolower($this->alamatemail),true);
		$criteria->compare('LOWER(notelp_pegawai)',strtolower($this->notelp_pegawai),true);
		$criteria->compare('LOWER(nomobile_pegawai)',strtolower($this->nomobile_pegawai),true);
		$criteria->compare('LOWER(warganegara_pegawai)',strtolower($this->warganegara_pegawai),true);
		$criteria->compare('LOWER(jeniswaktukerja)',strtolower($this->jeniswaktukerja),true);
		$criteria->compare('LOWER(kelompokjabatan)',strtolower($this->kelompokjabatan),true);
		$criteria->compare('LOWER(kategoripegawai)',strtolower($this->kategoripegawai),true);
		$criteria->compare('LOWER(kategoripegawaiasal)',strtolower($this->kategoripegawaiasal),true);
//		$criteria->compare('pegawai_aktif',$this->pegawai_aktif);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function searchKaryawanRuangan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with = array('kelompokpegawai');
		if(!empty($this->pegawai_id)){
			$criteria->addCondition("t.pegawai_id = ".$this->pegawai_id);					
		}
		
		$criteria->compare('LOWER(t.nomorindukpegawai)',strtolower($this->nomorindukpegawai),true);
		$criteria->compare('LOWER(t.no_kartupegawainegerisipil)',strtolower($this->no_kartupegawainegerisipil),true);
		$criteria->compare('LOWER(t.gelardepan)',strtolower($this->gelardepan),true);
		$criteria->compare('LOWER(t.nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(kelompokpegawai.kelompokpegawai_nama)',strtolower($this->kelompokpegawai_nama),true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	

	/**
	 * menampilkan tenaga laboratorium
	 * @param type $ruangan_id
	 */
	public function searchPegawaiRuangan($ruangan_id = null){
		$criteria = new CDbCriteria();
//		$criteria->addCondition("kelompokpegawai_id = ".Params::KELOMPOKPEGAWAI_ID_TENAGA_RAD); RSPMC-1242
                if(!empty($ruangan_id)){
			$criteria->join = "JOIN ruanganpegawai_m ON ruanganpegawai_m.pegawai_id = t.pegawai_id";
			$criteria->addCondition("ruanganpegawai_m.ruangan_id = ".$ruangan_id);
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));

	}

	public function getPPDS()
	{
		return PpdsM::model()->findAllByAttributes(array('ppds_aktif'=>true),array('order'=>'ppds_nama ASC'));
	}
	
	/**
	 * menampilkan tenaga laboratorium
	 * @param type $ruangan_id
	 */
	public function getTenagaRads($ruangan_id = null){
		$criteria = new CDbCriteria();
//		$criteria->addCondition("kelompokpegawai_id = ".Params::KELOMPOKPEGAWAI_ID_TENAGA_RAD); RSPMC-1242
		$criteria->addCondition("jabatan_id = ".Params::JABATAN_ID_RADIOGRAPHER);
                if(!empty($ruangan_id)){
			$criteria->join = "JOIN ruanganpegawai_m ON ruanganpegawai_m.pegawai_id = t.pegawai_id";
			$criteria->addCondition("ruanganpegawai_m.ruangan_id = ".$ruangan_id);
		}
		$models = self::model()->findAll($criteria);
		if(count((array)$models) > 0){
			return $models;
		}else{
			return array();
		}
	}

}
