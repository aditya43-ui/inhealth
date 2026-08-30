<?php
class PIPasienapachescoreT extends PasienapachescoreT {
    public $diagnosa_id;
    public $paramedis_nama;
    public $pegawai_nama;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function attributeLabels()
	{
		return array(
			'pasienapachescore_id' => 'Pasien Apache Score',
			'pasien_id' => 'Pasien',
			'apachescore_id' => 'Apache Score',
			'pasienadmisi_id' => 'Pasien Admisi',
			'ruangan_id' => 'Ruangan',
			'pegawai_id' => 'Pegawai',
			'pendaftaran_id' => 'Pendaftaran',
			'tglscoring' => 'Tanggal Scoring',
			'gagalginjalakut' => 'Gagal Ginjal Akut',
			'point_nama' => 'Point Nama',
			'point_nilai' => 'Point Nilai',
			'point_score' => 'Point Score',
			'paramedis_id' => 'Paramedis',
			'catatanapachescore' => 'Catatan Apache Score',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'paramedis_nama' => 'Nama Paramedis',
			'pegawai_nama' => 'Nama Dokter',
		);
	}
        
        public function searchDetailHasil($data)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		if(!empty($this->pasienapachescore_id)){
			$criteria->addCondition("pasienapachescore_id = ".$this->pasienapachescore_id); 	
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id = ".$this->pasien_id); 	
		}
		if(!empty($this->apachescore_id)){
			$criteria->addCondition("apachescore_id = ".$this->apachescore_id); 	
		}
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition("pasienadmisi_id = ".$this->pasienadmisi_id); 	
		}
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("ruangan_id = ".$this->ruangan_id); 	
		}
		if(!empty($this->pegawai_id)){
			$criteria->addCondition("pegawai_id = ".$this->pegawai_id); 	
		}
		if(!empty($data)){
			$criteria->addCondition("pendaftaran_id = ".$data); 	
		}
		$criteria->with = array('apachescore');
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}