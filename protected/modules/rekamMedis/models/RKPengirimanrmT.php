<?php

class RKPengirimanrmT extends PengirimanrmT {

	public $cekList,$kelengkapan;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchPenyimpanan()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                
                // $criteria->with = array('pendaftaran', 'dokrekammedis','pasien');
                $criteria->join = "left join pendaftaran_t pendaftaran on pendaftaran.pendaftaran_id = t.pendaftaran_id "
                        . "left join dokrekammedis_m dokrekammedis on dokrekammedis.dokrekammedis_id = t.dokrekammedis_id "
                        . "left join pasien_m pasien on pasien.pasien_id = t.pasien_id";
                $criteria->addCondition('t.peminjamanrm_id is null');                
                $criteria->addCondition('dokrekammedis.subrak_id is null and dokrekammedis.lokasirak_id is null');
                
                $criteria->group = "t.dokrekammedis_id, t.pasien_id, pasien.no_rekam_medik, t.pendaftaran_id, pendaftaran.tgl_pendaftaran,
                                    pendaftaran.no_pendaftaran, pasien.nama_pasien, pasien.tanggal_lahir,
                                    pasien.jeniskelamin, pendaftaran.instalasi_id, pendaftaran.ruangan_id";
                $criteria->select = $criteria->group;
                
		if (!empty($this->no_rekam_medik_akhir)){
                    $criteria->addCondition("CAST(pasien.no_rekam_medik as integer) between ".$this->no_rekam_medik." and ".$this->no_rekam_medik_akhir);
                } else {
                    $criteria->compare('LOWER(pasien.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
                }
                if (!empty($this->tgl_rekam_medik_akhir)){
                    $this->tgl_rekam_medik = MyFormatter::formatDateTimeForDb($this->tgl_rekam_medik);
                    $this->tgl_rekam_medik_akhir = MyFormatter::formatDateTimeForDb($this->tgl_rekam_medik_akhir);
                    $criteria->addBetweenCondition('DATE(dokrekammedis.tglrekammedis)', $this->tgl_rekam_medik, $this->tgl_rekam_medik_akhir);
                }
                else{
                    $this->tgl_rekam_medik = MyFormatter::formatDateTimeForDb($this->tgl_rekam_medik);
                    $criteria->compare('DATE(dokrekammedis.tglrekammedis)',$this->tgl_rekam_medik);    
                }
		$criteria->compare('LOWER(pasien.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(dokrekammedis.statusrekammedis)',strtolower($this->statusrekammedis),true);
		if(!empty($this->instalasi_id)){
			//$criteria->addCondition("pendaftaran.ruangan_id = ".$this->ruangan_id);			
		}
		$criteria->compare('LOWER(pendaftaran.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		if(!empty($this->instalasi_id)){
			if (is_array($this->instalasi_id)){
				$criteria->addInCondition("pendaftaran.instalasi_id",$this->instalasi_id);			
			}else{
				$criteria->addCondition("pendaftaran.instalasi_id = ".$this->instalasi_id);			
			}
		}
		
		if(!empty($this->ruangan_id)){
			if (is_array($this->instalasi_id)){
				$criteria->addInCondition("pendaftaran.ruangan_id",$this->ruangan_id);			
			}else{
				$criteria->addCondition("pendaftaran.ruangan_id = ".$this->ruangan_id);			
			}
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}