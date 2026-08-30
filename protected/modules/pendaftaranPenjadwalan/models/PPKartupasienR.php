<?php

class PPKartupasienR extends KartupasienR {

    public $tgl_awal, $tgl_akhir, $nama_pasien, $no_rekam_medik, $no_pendaftaran, $alamat_pasien, $rt, $rw, $statusprintkartu, $umur;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function relations(){
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'pasien'=>array(self::BELONGS_TO, 'PasienM','pasien_id'),
        );
    }

    public function searchTable() {

        $criteria = $this->functionCriteria(true);
        $criteria->with = array('pasien');
        $criteria->compare('pasien.no_rekam_medik',$this->no_rekam_medik);
        $criteria->compare('LOWER(pasien.nama_pasien)',strtolower($this->nama_pasien),true);
        $criteria->order = 'tglprintkartu';
        
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        )); 
    }

    protected function functionCriteria() {

        $criteria = new CDbCriteria;
        
        $criteria->with = array('pasien');
        $criteria->addBetweenCondition('tglprintkartu', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->kartupasien_id)){
			$criteria->addCondition("kartupasien_id' = ".$this->kartupasien_id);			
		}
		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id' = ".$this->pasien_id);			
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id' = ".$this->pendaftaran_id);			
		}
        $criteria->compare('statusprintkartu',$this->statusprintkartu);
        $criteria->compare('keteranganprint',$this->keteranganprint);
        $criteria->compare('create_time',$this->create_time);
        $criteria->compare('update_time',$this->update_time);
		if(!empty($this->create_loginpemakai_id)){
			$criteria->addCondition("create_loginpemakai_id' = ".$this->create_loginpemakai_id);			
		}
		if(!empty($this->update_loginpemakai_id)){
			$criteria->addCondition("update_loginpemakai_id' = ".$this->update_loginpemakai_id);			
		}
        $criteria->compare('LOWER(pasien.no_rekam_medik)',  strtolower($this->no_rekam_medik),true);
        $criteria->compare('LOWER(pasien.nama_pasien)',  strtolower($this->nama_pasien),true);
        $criteria->compare('LOWER(pasien.alamat_pasien)',  strtolower($this->alamat_pasien),true);
        $criteria->compare('pasien.rt',  $this->rt);
        $criteria->compare('pasien.rw',  $this->rw);
        return $criteria;
    }

    public function getNamaModel() {
        return __CLASS__;
    }

}