<?php
class RKDokumenpasienrmlamaV extends DokumenpasienrmlamaV {

	public $tgl_awal,$ids,$tgl_akhir;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchPeminjaman()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $format = new MyFormatter();
//		$criteria->with = array('subrak', 'pendaftaran', 'pengiriman');
		//$criteria->addCondition('t.peminjamanrm_id is null or (t.peminjamanrm_id is not null and t.kembalirm_id is not null)');
		if (!empty($this->no_rekam_medik_akhir)){
			$criteria->addCondition("CAST(t.no_rekam_medik as integer) between ".$this->no_rekam_medik." and ".$this->no_rekam_medik_akhir);
		} else {
			$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		}
                
                if (!empty($this->tgl_pendaftaran)){
                    $criteria->addBetweenCondition('tgl_pendaftaran', $format->formatDateTimeForDb($this->tgl_pendaftaran).' 00:00:00', $format->formatDateTimeForDb($this->tgl_pendaftaran).' 23:59:59');
                }

		$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
		
//		if (!empty($this->tgl_rekam_medik_akhir)){
//			$criteria->addBetweenCondition('DATE(t.tgl_rekam_medik)', $this->tgl_rekam_medik, $this->tgl_rekam_medik_akhir);
//		}
//		else{
//			$criteria->compare('DATE(t.tgl_rekam_medik)',$this->tgl_rekam_medik);    
//		}
		
		//$criteria->addBetweenCondition('DATE(t.tgl_rekam_medik)',$this->tgl_awal,$this->tgl_akhir);
		
		$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(t.statusrekammedis)',strtolower($this->statusrekammedis),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("t.ruangan_id = ".$this->ruangan_id);			
		}
		$criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition("t.instalasi_id = ".$this->instalasi_id);			
		}
		if(!empty($this->subrak_id)){
			$criteria->addCondition("t.subrak_id = ".$this->subrak_id);			
		}
		if(!empty($this->lokasirak_id)){
			$criteria->addCondition("t.lokasirak_id = ".$this->lokasirak_id);			
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("t.pendaftaran_id = ".$this->pendaftaran_id);			
		}
		
		$criteria->limit = 10;
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
	
    public function searchDialogPeminjaman()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addCondition('t.peminjamanrm_id is null or (t.peminjamanrm_id is not null and t.kembalirm_id is not null)');
		if (!empty($this->no_rekam_medik_akhir)){
			$criteria->addCondition("CAST(t.no_rekam_medik as integer) between ".$this->no_rekam_medik." and ".$this->no_rekam_medik_akhir);
		} else {
			$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		}

		$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
		
		$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(t.statusrekammedis)',strtolower($this->statusrekammedis),true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("t.ruangan_id = ".$this->ruangan_id);			
		}
		$criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition("t.instalasi_id = ".$this->instalasi_id);			
		}
		if(!empty($this->subrak_id)){
			$criteria->addCondition("t.subrak_id = ".$this->subrak_id);			
		}
		if(!empty($this->lokasirak_id)){
			$criteria->addCondition("t.lokasirak_id = ".$this->lokasirak_id);			
		}
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("t.pendaftaran_id = ".$this->pendaftaran_id);			
		}
		
		$criteria->limit = 10;
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}
        
	public function searchPengiriman()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

//		$criteria->with = array('subrak', 'pendaftaran', 'pengiriman');
//		$criteria->addCondition('t.pengirimanrm_id is null');
//		$criteria->addCondition('t.peminjamanrm_id is not null');

		if (!empty($this->no_rekam_medik_akhir)){
			$criteria->addCondition("CAST(t.no_rekam_medik as integer) between ".$this->no_rekam_medik." and ".$this->no_rekam_medik_akhir);
		} else {
			$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		}
                
		$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
		if (!empty($this->tgl_rekam_medik_akhir)){
			$criteria->join = "join pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id";
                        $criteria->order = "p.tgl_pendaftaran desc";
                        $criteria->addBetweenCondition('date(t.tgl_pendaftaran)', $this->tgl_rekam_medik, $this->tgl_rekam_medik_akhir);
                        $criteria->addCondition('p.pengirimanrm_id is null');
                }
		else{
			$criteria->compare('DATE(t.tgl_rekam_medik)',$this->tgl_rekam_medik);    
		}
		$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(t.no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		
		if(!empty($this->instalasi_id)){
			if (is_array($this->instalasi_id)){
				$criteria->addInCondition("t.instalasi_id",$this->instalasi_id);			
			}else{
				$criteria->addCondition("t.instalasi_id = ".$this->instalasi_id);			
			}
		}
		if(!empty($this->ruangan_id)){
			//$criteria->addCondition("t.ruangan_id = ".$this->ruangan_id);			
			if (is_array($this->ruangan_id)){
				$criteria->addInCondition("t.ruangan_id",$this->ruangan_id);			
			}else{
				$criteria->addCondition("t.ruangan_id = ".$this->ruangan_id);			
			}
		}
                
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
	}

}