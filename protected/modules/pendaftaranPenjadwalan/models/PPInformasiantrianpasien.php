<?php

class PPInformasiantrianpasien extends InformasiantrianpasienV {

    public $tgl_awal,$tgl_akhir;
    public $noantrian_loket;
    public $prefix_pendaftaran;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function searchTable($loketOnly = false) {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria($loketOnly);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    protected function functionCriteria($loketOnly = false) {

        $criteria = new CDbCriteria();
        
        
        $criteria->addBetweenCondition('DATE(t.tglantrian)', $this->tgl_awal, $this->tgl_akhir);
        /*
		if(!empty($this->pasien_id)){
			$criteria->addCondition("t.pasien_id' = ".$this->pasien_id);			
		}
        */
        $criteria->compare('LOWER(t.jenisidentitas)', strtolower($this->jenisidentitas), true);
        $criteria->compare('LOWER(t.no_identitas_pasien)', strtolower($this->no_identitas_pasien), true);
        $criteria->compare('LOWER(t.namadepan)', strtolower($this->namadepan), true);
        $criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(t.nama_bin)', strtolower($this->nama_bin), true);
        $criteria->compare('LOWER(t.jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(t.tempat_lahir)', strtolower($this->tempat_lahir), true);
        $criteria->compare('LOWER(t.tanggal_lahir)', strtolower($this->tanggal_lahir), true);
        $criteria->compare('LOWER(t.alamat_pasien)', strtolower($this->alamat_pasien), true);
        $criteria->compare('t.rt', $this->rt);
        $criteria->compare('t.rw', $this->rw);
        $criteria->compare('LOWER(t.agama)', strtolower($this->agama), true);
        $criteria->compare('LOWER(t.golongandarah)', strtolower($this->golongandarah), true);
        $criteria->compare('LOWER(t.photopasien)', strtolower($this->photopasien), true);
        $criteria->compare('LOWER(t.alamatemail)', strtolower($this->alamatemail), true);
        $criteria->compare('LOWER(t.statusrekammedis)', strtolower($this->statusrekammedis), true);
        $criteria->compare('LOWER(t.statusperkawinan)', strtolower($this->statusperkawinan), true);
        $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(t.tgl_rekam_medik)', strtolower($this->tgl_rekam_medik), true);

		if(!empty($this->propinsi_id)){
			$criteria->addCondition("t.propinsi_id' = ".$this->propinsi_id);			
		}
        $criteria->compare('LOWER(t.propinsi_nama)', strtolower($this->propinsi_nama), true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition("t.kabupaten_id' = ".$this->kabupaten_id);			
		}
        $criteria->compare('LOWER(t.kabupaten_nama)', strtolower($this->kabupaten_nama), true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition("t.kelurahan_id' = ".$this->kelurahan_id);			
		}
        $criteria->compare('LOWER(t.kelurahan_nama)', strtolower($this->kelurahan_nama), true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition("t.kecamatan_id' = ".$this->kecamatan_id);			
		}
        $criteria->compare('LOWER(t.kecamatan_nama)', strtolower($this->kecamatan_nama), true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("t.pendaftaran_id' = ".$this->pendaftaran_id);			
		}        
        $criteria->compare('LOWER(t.noantrian_loket)', strtolower($this->noantrian_loket), true);
        $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($this->prefix_pendaftaran.$this->no_pendaftaran), true);
        $criteria->compare('LOWER(t.no_urutantri)', strtolower($this->no_urutantri), true);
        $criteria->compare('LOWER(t.transportasi)', strtolower($this->transportasi), true);
        $criteria->compare('LOWER(t.keadaanmasuk)', strtolower($this->keadaanmasuk), true);
        $criteria->compare('LOWER(t.statusperiksa)', strtolower($this->statusperiksa), true);
        $criteria->compare('LOWER(t.statuspasien)', strtolower($this->statuspasien), true);
        $criteria->compare('LOWER(t.kunjungan)', strtolower($this->kunjungan), true);
        $criteria->compare('t.alihstatus', $this->alihstatus);
        $criteria->compare('t.byphone', $this->byphone);
        $criteria->compare('t.kunjunganrumah', $this->kunjunganrumah);
        $criteria->compare('LOWER(t.statusmasuk)', strtolower($this->statusmasuk), true);
        $criteria->compare('LOWER(t.umur)', strtolower($this->umur), true);
        $criteria->compare('LOWER(t.no_asuransi)', strtolower($this->no_asuransi), true);
        $criteria->compare('LOWER(t.namapemilik_asuransi)', strtolower($this->namapemilik_asuransi), true);
        $criteria->compare('LOWER(t.nopokokperusahaan)', strtolower($this->nopokokperusahaan), true);
        $criteria->compare('LOWER(t.create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(t.create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
        $criteria->compare('LOWER(t.create_ruangan)', strtolower($this->create_ruangan), true);
        
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("t.carabayar_id = ".$this->carabayar_id);			
		}
        $criteria->compare('LOWER(t.carabayar_nama)', strtolower($this->carabayar_nama), true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("t.penjamin_id = ".$this->penjamin_id);			
		}
        $criteria->compare('LOWER(t.penjamin_nama)', strtolower($this->penjamin_nama), true);
		if(!empty($this->shift_id)){
			$criteria->addCondition("t.shift_id = ".$this->shift_id);			
		}
		if(!empty($this->ruangan_id)){
			if(is_array($this->ruangan_id)){
				$criteria->addInCondition('t.ruangan_id',$this->ruangan_id); 			
			}
		}
        $criteria->compare('LOWER(t.ruangan_nama)', strtolower($this->ruangan_nama), true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition("t.instalasi_id = ".$this->instalasi_id);			
		}
        $criteria->compare('LOWER(t.instalasi_nama)', strtolower($this->instalasi_nama), true);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition("t.jeniskasuspenyakit_id = ".$this->jeniskasuspenyakit_id);			
		}
        $criteria->compare('LOWER(t.jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
	$criteria->compare('a.loket_id', $this->loket_id);
        $criteria->compare('t.ruangan_id', $this->ruangan_id);
        
        if ($this->statusdaftar == 1) {
            $criteria->addCondition("t.ruangan_nama is null");
        } else if ($this->statusdaftar == 2) {
            $criteria->addCondition("t.ruangan_nama is not null");
        }
        
        $criteria->join = 'join antrian_t a on a.antrian_id = t.antrian_id';
        
        
        /*
        if ($loketOnly) {
            $criteria->join = 'left join pendaftaran_t p on p.pendaftaran_id = t.pendaftaran_id '
                    . 'join antrian_t a on a.antrian_id = p.antrian_id';
        }*/
        
        //$criteria->addCondition('t.antrian_id is not null');
        
        $criteria->order = 't.tglantrian DESC';
        
        return $criteria;
    }

    public function getNamaModel() {
        return __CLASS__;
    }

}