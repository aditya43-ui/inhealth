<?php

class PPDokumenpasienrmbaruV extends DokumenpasienrmbaruV {
    
    
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

//			if(!empty($this->pasien_id)){
//				$criteria->addCondition("pasien_id = ".$this->pasien_id); 			
//			}
//            $criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
//            $criteria->compare('LOWER(tgl_rekam_medik)',strtolower($this->tgl_rekam_medik),true);
//            $criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
//            $criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
//            $criteria->compare('LOWER(jeniskelamin)',strtolower($this->jeniskelamin),true);
//            $criteria->compare('LOWER(tanggal_lahir)',strtolower($this->tanggal_lahir),true);
//            $criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
//            $criteria->compare('LOWER(tempat_lahir)',strtolower($this->tempat_lahir),true);
//            if(!empty($this->ruangan_id)){
	//				$criteria->addCondition("ruangan_id = ".$this->ruangan_id); 			
	//			}
//            $criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
//            $criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
//				 if(!empty($this->pendaftaran_id)){
//					$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id); 			
//				}
//            $criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
//            $criteria->compare('LOWER(no_urutantri)',strtolower($this->no_urutantri),true);
//            if(!empty($this->instalasi_id)){
//					$criteria->addCondition("instalasi_id = ".$this->instalasi_id); 			
//				}
//            $criteria->compare('LOWER(instalasi_nama)',strtolower($this->instalasi_nama),true);
//            $criteria->compare('LOWER(statuspasien)',strtolower($this->statuspasien),true);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }

}