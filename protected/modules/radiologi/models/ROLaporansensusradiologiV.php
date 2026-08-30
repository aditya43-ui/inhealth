<?php

class ROLaporansensusradiologiV extends LaporansensusradiologiV {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria = $this->functionCriteria();
       /* $criteria->select = 'count(tglmasukpenunjang) as jumlah, kunjungan as data';
        $criteria->group = 'kunjungan';
        if ($this->pilihan == 'carabayar'){
            if (!empty($this->penjamin_id)) {
                $criteria->select .= ', penjamin_nama as tick';
                $criteria->group .= ', penjamin_nama';
            } else if (!empty($this->carabayar_id)) {
                $criteria->select .= ', penjamin_nama as tick';
                $criteria->group .= ', penjamin_nama';
            } else {
                $criteria->select .= ', carabayar_nama as tick';
                $criteria->group .= ', carabayar_nama';
            }
        }
        else{
            $criteria->select .= ', pemeriksaanrad_nama as tick';
            $criteria->group .= ', pemeriksaanrad_nama';
        }*/
         if ($_GET['tampilGrafik'] == 'kunjungan'){
            $criteria->select = 'count(pendaftaran_id) as jumlah, kunjungan as data';
            $criteria->group = 'kunjungan';
        }elseif ($_GET['tampilGrafik'] == 'carabayar'){            
            $criteria->select = 'count(pendaftaran_id) as jumlah, carabayar_nama as data';
            $criteria->group = 'carabayar_nama';
        }elseif ($_GET['tampilGrafik'] == 'jenispemeriksaan'){            
            $criteria->select = 'count(pendaftaran_id) as jumlah, jenispemeriksaanlab_nama as data';
            $criteria->group = 'jenispemeriksaanlab_nama';
        }elseif ($_GET['tampilGrafik'] == 'instalasiasal'){            
            $criteria->select = 'count(pendaftaran_id) as jumlah, instalasiasal_nama as data';
            $criteria->group = 'instalasiasal_nama';
        }elseif ($_GET['tampilGrafik'] == 'ruanganasal'){            
            $criteria->select = 'count(pendaftaran_id) as jumlah, ruanganasal_nama as data';
            $criteria->group = 'ruanganasal_nama';
        }
        
        $criteria->order = 'jumlah DESC';
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchTable() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria = $this->functionCriteria();

        return new CActiveDataProvider($this, array(
                    'pagination' => false,
                    'criteria' => $criteria,
                ));
    }

    protected function functionCriteria() {
        $criteria = new CDbCriteria();
        $format = new MyFormatter();
		
        if (!is_array($this->kunjungan)){
            $this->kunjungan = 0;
        }else{
            $data = array();
            foreach(  $this->kunjungan as $i => $values ){
                                
                if( $values == "KUNJUNGAN ULANG"){
                    $data[]="KUNJUNGAN LAMA";
                } else{
                    $data[]=$values;
                }
            }                                            
            $criteria->addInCondition('kunjungan', $data);
        }
        
        if ($this->pilihan == 'jenis'){
            if (!is_array($this->jenispemeriksaanrad_id)){
                $this->pemeriksaanrad_id = 0;
            }
        }
        $this->tgl_awal = $format->formatDateTimeForDb($this->tgl_awal);
        $this->tgl_akhir = $format->formatDateTimeForDb($this->tgl_akhir);
        $criteria->addBetweenCondition('date(tglmasukpenunjang)', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id = ".$this->pasien_id);					
		}
        $criteria->compare('LOWER(jenisidentitas)', strtolower($this->jenisidentitas), true);
        $criteria->compare('LOWER(no_identitas_pasien)', strtolower($this->no_identitas_pasien), true);
        $criteria->compare('LOWER(namadepan)', strtolower($this->namadepan), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(tempat_lahir)', strtolower($this->tempat_lahir), true);
        $criteria->compare('LOWER(tanggal_lahir)', strtolower($this->tanggal_lahir), true);
        $criteria->compare('LOWER(alamat_pasien)', strtolower($this->alamat_pasien), true);
        $criteria->compare('rt', $this->rt);
        $criteria->compare('rw', $this->rw);
        $criteria->compare('LOWER(agama)', strtolower($this->agama), true);
        $criteria->compare('LOWER(golongandarah)', strtolower($this->golongandarah), true);
        $criteria->compare('LOWER(photopasien)', strtolower($this->photopasien), true);
        $criteria->compare('LOWER(alamatemail)', strtolower($this->alamatemail), true);
        $criteria->compare('LOWER(statusrekammedis)', strtolower($this->statusrekammedis), true);
        $criteria->compare('LOWER(statusperkawinan)', strtolower($this->statusperkawinan), true);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(tgl_rekam_medik)', strtolower($this->tgl_rekam_medik), true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);					
		}
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(tgl_pendaftaran)', strtolower($this->tgl_pendaftaran), true);
        $criteria->compare('LOWER(no_urutantri)', strtolower($this->no_urutantri), true);
        $criteria->compare('LOWER(transportasi)', strtolower($this->transportasi), true);
        $criteria->compare('LOWER(keadaanmasuk)', strtolower($this->keadaanmasuk), true);
        $criteria->compare('LOWER(statuspasien)', strtolower($this->statuspasien), true);
        $criteria->compare('alihstatus', $this->alihstatus);
        $criteria->compare('byphone', $this->byphone);
        $criteria->compare('kunjunganrumah', $this->kunjunganrumah);
        $criteria->compare('LOWER(statusmasuk)', strtolower($this->statusmasuk), true);
        $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
        $criteria->compare('LOWER(no_asuransi)', strtolower($this->no_asuransi), true);
        $criteria->compare('LOWER(namapemilik_asuransi)', strtolower($this->namapemilik_asuransi), true);
        $criteria->compare('LOWER(nopokokperusahaan)', strtolower($this->nopokokperusahaan), true);
		if(!empty($this->shift_id)){
			$criteria->addCondition("shift_id = ".$this->shift_id);					
		}
		if(!empty($this->ruanganasal_id)){
			$criteria->addInCondition("ruanganasal_id",$this->ruanganasal_id);					
		}
        $criteria->compare('LOWER(ruanganasal_nama)', strtolower($this->ruanganasal_nama), true);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition("jeniskasuspenyakit_id = ".$this->jeniskasuspenyakit_id);					
		}
        $criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id);					
		}
        $criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
        $criteria->compare('LOWER(no_masukpenunjang)', strtolower($this->no_masukpenunjang), true);
        $criteria->compare('LOWER(tglmasukpenunjang)', strtolower($this->tglmasukpenunjang), true);
        $criteria->compare('LOWER(no_urutperiksa)', strtolower($this->no_urutperiksa), true);
        $criteria->compare('LOWER(statusperiksa)', strtolower($this->statusperiksa), true);
        $criteria->addCondition('ruanganpenunj_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(ruanganpenunj_nama)', strtolower($this->ruanganpenunj_nama), true);
		if(!empty($this->instalasiasal_id)){
			$criteria->addInCondition("instalasiasal_id", $this->instalasiasal_id);					
		}
        $criteria->compare('LOWER(instalasiasal_nama)', strtolower($this->instalasiasal_nama), true);
		if(!empty($this->pasienadmisi_id)){
			$criteria->addCondition("pasienadmisi_id = ".$this->pasienadmisi_id);					
		}
		
        $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
        $criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
        $criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
        $criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
		if(!empty($this->pasienkirimkeunitlain_id)){
			$criteria->addCondition("pasienkirimkeunitlain_id = ".$this->pasienkirimkeunitlain_id);					
		}
		if(!empty($this->carabayar_id)){
			$criteria->addInCondition("carabayar_id", $this->carabayar_id);					
		}
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
        if(!empty($this->penjamin_id)){
                $criteria->addInCondition("penjamin_id",$this->penjamin_id);					
        }
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
		if(!empty($this->daftartindakan_id)){
			$criteria->addCondition("daftartindakan_id = ".$this->daftartindakan_id);					
		}
        $criteria->compare('LOWER(daftartindakan_nama)', strtolower($this->daftartindakan_nama), true);
		if(!empty($this->tindakanpelayanan_id)){
			$criteria->addCondition("tindakanpelayanan_id = ".$this->tindakanpelayanan_id);					
		}
        $criteria->compare('LOWER(tgl_tindakan)', strtolower($this->tgl_tindakan), true);
        $criteria->compare('qty_tindakan', $this->qty_tindakan);
		if(!empty($this->pemeriksaanrad_id)){
			$criteria->addInCondition("pemeriksaanrad_id ",$this->pemeriksaanrad_id);					
		}
        $criteria->compare('LOWER(jenispemeriksaanrad_nama)', strtolower($this->jenispemeriksaanrad_nama), true);
        $criteria->compare('LOWER(pemeriksaanrad_nama)', strtolower($this->pemeriksaanrad_nama), true);
        $criteria->compare('LOWER(pemeriksaanrad_namalainnya)', strtolower($this->pemeriksaanrad_namalainnya), true);

        return $criteria;
    }

        public function getNamaModel(){
            return __CLASS__;
        }
}

?>
