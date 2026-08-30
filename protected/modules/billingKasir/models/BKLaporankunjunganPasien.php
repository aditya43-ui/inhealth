<?php

class BKLaporankunjunganPasien extends LaporankunjunganrsV {
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function searchTable() {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();
        $criteria->order = 'instalasi_nama, ruangan_nama';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchGrafik() {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();

        $criteria->select = 'count(pendaftaran_id) as jumlah';

        if (!empty($this->ruangan_id)) {
            $criteria->select .= ', ruangan_nama as tick';
            $criteria->group .= 'ruangan_nama';
        } else if (!empty($this->instalasi_id)) {
            $criteria->select .= ', ruangan_nama as tick';
            $criteria->group .= 'ruangan_nama';
        } else {
            $criteria->select .= ', instalasi_nama as tick';
            $criteria->group .= 'instalasi_nama';
        }

        if ($this->pilihanx == 'pengunjung') {
            $criteria->select .= ', statuspasien as data';
            $criteria->group .= ', statuspasien';
        } else if ($this->pilihanx == 'kunjungan') {
            $criteria->select .= ', kunjungan as data';
            $criteria->group .= ', kunjungan';
        } else {
            if (!empty($this->ruangan_id)) {
                $criteria->select = 'count(pendaftaran_id) as jumlah, ruangan_nama as data';
                $criteria->group = 'ruangan_nama';
            }
            else if (!empty($this->instalasi_id)) {
                $criteria->select = 'count(pendaftaran_id) as jumlah, instalasi_nama as data';
                $criteria->group = 'instalasi_nama';
            }else{
                $criteria->select = 'count(pendaftaran_id) as jumlah, instalasi_nama as data';
                $criteria->group = 'instalasi_nama';
            }
        }
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchPrint()
    {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();
        $criteria->order = 'instalasi_nama, ruangan_nama';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false,
                ));
    }

    protected function functionCriteria() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->pasien_id)){
			$criteria->addCondition('pasien_id = '.$this->pasien_id);
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
			$criteria->addCondition('pendaftaran_id = '.$this->pendaftaran_id);
		}
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(tgl_pendaftaran)', strtolower($this->tgl_pendaftaran), true);
        $criteria->compare('LOWER(no_urutantri)', strtolower($this->no_urutantri), true);
        $criteria->compare('LOWER(transportasi)', strtolower($this->transportasi), true);
        $criteria->compare('LOWER(keadaanmasuk)', strtolower($this->keadaanmasuk), true);
        $criteria->compare('LOWER(statusperiksa)', strtolower($this->statusperiksa), true);
        $criteria->compare('LOWER(statuspasien)', strtolower($this->statuspasien), true);
        $criteria->compare('LOWER(kunjungan)', strtolower($this->kunjungan), true);
        $criteria->compare('alihstatus', $this->alihstatus);
        $criteria->compare('byphone', $this->byphone);
        $criteria->compare('kunjunganrumah', $this->kunjunganrumah);
        $criteria->compare('LOWER(statusmasuk)', strtolower($this->statusmasuk), true);
        $criteria->compare('LOWER(umur)', strtolower($this->umur), true);
        $criteria->compare('LOWER(no_asuransi)', strtolower($this->no_asuransi), true);
        $criteria->compare('LOWER(namapemilik_asuransi)', strtolower($this->namapemilik_asuransi), true);
        $criteria->compare('LOWER(nopokokperusahaan)', strtolower($this->nopokokperusahaan), true);
        $criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
        $criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
        $criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
		if(!empty($this->shift_id)){
			$criteria->addCondition('shift_id = '.$this->shift_id);
		}
		if(!empty($this->ruangan_id)){
                        if (is_array($this->ruangan_id)) {
                            $criteria->addInCondition('ruangan_id', $this->ruangan_id);
                        } else {
                            $criteria->addCondition('ruangan_id = '.$this->ruangan_id);
                        }
		}
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
		if(!empty($this->instalasi_id)){
			$criteria->addInCondition('instalasi_id', $this->instalasi_id);
		}
        $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition('jeniskasuspenyakit_id = '.$this->jeniskasuspenyakit_id);
		}
        $criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition('kelaspelayanan_id = '.$this->kelaspelayanan_id);
		}
        $criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
		if(!empty($this->rujukan_id)){
			$criteria->addCondition('rujukan_id = '.$this->rujukan_id);
		}
		if(!empty($this->pasienpulang_id)){
			$criteria->addCondition('pasienpulang_id = '.$this->pasienpulang_id);
		}
		if(!empty($this->profilrs_id)){
			$criteria->addCondition('profilrs_id = '.$this->profilrs_id);
		}

        return $criteria;
    }

    public function getNamaModel() {
        return __CLASS__;
    }

    public static function berdasarkanStatus() {
        $status = array(
            'pengunjung' => 'Berdasarkan Pengunjung',
            'kunjungan' => 'Berdasarkan Kunjungan',
        );
        return $status;
    }
    
    public function searchDashboard() {
        $criteria = new CDbCriteria();
        $criteria = $this->functionCriteria();

        $criteria->select = 'count(pendaftaran_id) as jumlah';

        if (!empty($this->ruangan_id)) {
            $criteria->select .= ', ruangan_nama as tick';
            $criteria->group .= 'ruangan_nama';
        } else if (!empty($this->instalasi_id)) {
            $criteria->select .= ', ruangan_nama as tick';
            $criteria->group .= 'ruangan_nama';
        } else {
            $criteria->select .= ', instalasi_nama as tick';
            $criteria->group .= 'instalasi_nama';
        }

        if ($this->pilihanx == 'pengunjung') {
            $criteria->select .= ', statuspasien as data';
            $criteria->group .= ', statuspasien';
        } else if ($this->pilihanx == 'kunjungan') {
            $criteria->select .= ', kunjungan as data';
            $criteria->group .= ', kunjungan';
        } else {
            if (!empty($this->ruangan_id)) {
                $criteria->select = 'count(pendaftaran_id) as jumlah, kecamatan_nama as data';
                $criteria->group = 'kecamatan_nama';
            }
            else if (!empty($this->instalasi_id)) {
                $criteria->select = 'count(pendaftaran_id) as jumlah, instalasi_nama as data';
                $criteria->group = 'instalasi_nama';
            }
        }

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
 
    public function getNamaDokter()
    {
        $query = "SELECT pegawai_m.nama_pegawai, pegawai_m.gelardepan, gelarbelakang_m.gelarbelakang_nama as gelarbelakang FROM pegawai_m
        JOIN pendaftaran_t ON pendaftaran_t.pegawai_id = pegawai_m.pegawai_id
        LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id 
        WHERE pendaftaran_id = '". $this->pendaftaran_id ."'
        ";
        $result = YII::app()->db->createCommand($query)->queryRow();
        return $result['gelardepan'].' '.$result['nama_pegawai'].' '.$result['gelarbelakang'];
    }

}