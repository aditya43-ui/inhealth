<?php

class RKPeminjamandokumenrmV extends PeminjamandokumenrmV {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchPeminjaman()
    {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addCondition('t.pengirimanrm_id is null');
		$criteria->addCondition('t.peminjamanrm_id is not null');

		$criteria->with = array('instalasi','pendaftaran','subrak','dokumenrekammedis', 'peminjaman', 'pengiriman');
		if (!empty($this->no_rekam_medik_akhir)){
			$criteria->addCondition("CAST(t.no_rekam_medik as integer) between ".$this->no_rekam_medik." and ".$this->no_rekam_medik_akhir);
			//$criteria->addBetweenCondition('LOWER(t.no_rekam_medik)', $this->no_rekam_medik, $this->no_rekam_medik_akhir);
		} else {
			$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		}

		$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);

		if (!empty($this->tgl_rekam_medik_akhir)){
			$this->tgl_rekam_medik = MyFormatter::formatDateTimeForDb($this->tgl_rekam_medik);
			$this->tgl_rekam_medik_akhir = MyFormatter::formatDateTimeForDb($this->tgl_rekam_medik_akhir);
			$criteria->addBetweenCondition('DATE(t.tglrekammedis)', $this->tgl_rekam_medik, $this->tgl_rekam_medik_akhir,true);
		}
		else{
			$this->tgl_rekam_medik = MyFormatter::formatDateTimeForDb($this->tgl_rekam_medik);
			$criteria->compare('DATE(t.tglrekammedis)',$this->tgl_rekam_medik);    
		}
		$criteria->compare('DATE(tglpeminjamanrm)',$this->tglpeminjamanrm,true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("t.ruangan_id = ".$this->ruangan_id);			
		}
		if(!empty($this->instalasi_id)){
			$criteria->addCondition("instalasi.instalasi_id = ".$this->instalasi_id);			
		}
		$criteria->compare('LOWER(t.no_pendaftaran)',  strtolower($this->no_pendaftaran), true);

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
    }
    
    public function searchPengiriman()
    {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with = array('instalasi','pendaftaran','subrak','dokumenrekammedis', 'peminjaman', 'pengiriman');
		if (!empty($this->no_rekam_medik_akhir)){
			$criteria->addCondition("CAST(t.no_rekam_medik as integer) between ".$this->no_rekam_medik." and ".$this->no_rekam_medik_akhir);
		} else {
			$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		}
		
		$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
		if (!empty($this->tgl_rekam_medik_akhir)){
			$criteria->addBetweenCondition('DATE(t.tgl_rekam_medik)', $this->tgl_rekam_medik, $this->tgl_rekam_medik_akhir);
		}
		else{
			$criteria->compare('DATE(t.tgl_rekam_medik)',$this->tgl_rekam_medik);    
		}
		if (!empty($this->tglpeminjamanrm_akhir)){
			$criteria->addBetweenCondition('DATE(t.tglpeminjamanrm)', $this->tglpeminjamanrm, $this->tglpeminjamanrm_akhir);
		}
		else{
			$criteria->compare('DATE(t.tglpeminjamanrm)',$this->tglpeminjamanrm);    
		}
		if(!empty($this->ruangan_id)){
			if (is_array($this->ruangan_id)){
				$criteria->addInCondition("t.ruangan_id",$this->ruangan_id);
			}else{
				$criteria->addCondition("t.ruangan_id = ".$this->ruangan_id);			
			}
		}
		if(!empty($this->instalasi_id)){
			if (is_array($this->instalasi_id)){
				$criteria->addInCondition("t.instalasi_id",$this->instalasi_id);
			}else{
				$criteria->addCondition("t.instalasi_id = ".$this->instalasi_id);
			}
			//$criteria->addCondition("instalasi.instalasi_id = ".$this->instalasi_id);			
		}
		$criteria->compare('LOWER(t.no_pendaftaran)',  strtolower($this->no_pendaftaran), true);
		
		$criteria->addCondition('t.pengirimanrm_id is not null');
		$criteria->addCondition('t.peminjamanrm_id is not null');
		$criteria->addCondition('t.kembalirm_id is null');
        
        // var_dump($criteria); die;
		
		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
    }
    
    public function searchPenyimpanan()
    {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->addCondition('t.pengirimanrm_id is not null');
		$criteria->addCondition('t.peminjamanrm_id is null');
		$criteria->addCondition('t.kembalirm_id is null');

//		$criteria->with = array('instalasi','pendaftaran','subrak','dokumenrekammedis', 'peminjaman', 'pengiriman');
		if (!empty($this->no_rekam_medik_akhir)){
			$criteria->addCondition("CAST(t.no_rekam_medik as integer) between ".$this->no_rekam_medik." and ".$this->no_rekam_medik_akhir);
		} else {
			$criteria->compare('LOWER(t.no_rekam_medik)',strtolower($this->no_rekam_medik),true);
		}

		$criteria->compare('LOWER(t.nama_pasien)',strtolower($this->nama_pasien),true);
		if (!empty($this->tgl_rekam_medik_akhir)){
			$criteria->addBetweenCondition('date(t.tgl_rekam_medik)', $this->tgl_rekam_medik, $this->tgl_rekam_medik_akhir);
		}
		else{
			$criteria->compare('DATE(t.tgl_rekam_medik)',$this->tgl_rekam_medik);    
		}
		$criteria->compare('DATE(tglpeminjamanrm)',$this->tglpeminjamanrm,true);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition("t.ruangan_id = ".$this->ruangan_id);			
		}
		if(!empty($this->instalasi_id)){
			$criteria->addCondition("t.instalasi_id = ".$this->instalasi_id);			
		}
		$criteria->compare('LOWER(t.no_pendaftaran)',  strtolower($this->no_pendaftaran), true);

		return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
		));
    }

}