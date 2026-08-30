<?php

class RKDokumenpasienrmbaruV extends DokumenpasienrmbaruV {
    
    
    public $nodokumenrm;
    public $tglrekammedis;
    public $tglmasukrak;
    public $statusrekammedis;
    public $tglkeluarakhir;
    public $tglmasukakhir;
    public $nomortertier;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchPengiriman()
    {
            // Warning: Please modify the following code to remove attributes that
            // should not be searched.

            $criteria=new CDbCriteria;
            
            if (!empty($this->no_rekam_medik_akhir)){
                    $criteria->addCondition("CAST(t.no_rekam_medik as integer) between ".$this->no_rekam_medik." and ".$this->no_rekam_medik_akhir);
                } else {
                    $criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
                }
		
                $criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
                if (!empty($this->tgl_rekam_medik_akhir)){
                    $criteria->addBetweenCondition('date(t.tgl_rekam_medik)', $this->tgl_rekam_medik, $this->tgl_rekam_medik_akhir);
                } else{
                    $criteria->compare('DATE(t.tgl_rekam_medik)',$this->tgl_rekam_medik);    
                }
		$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(t.statusrekammedis)',strtolower($this->statusrekammedis),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("t.ruangan_id = ".$this->ruangan_id);			
		}
		$criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition("t.instalasi_id = ".$this->instalasi_id);			
		}
		$criteria->compare('LOWER(t.statuspasien)',strtolower(Params::statusPasien(lama)),true);
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
    }

}