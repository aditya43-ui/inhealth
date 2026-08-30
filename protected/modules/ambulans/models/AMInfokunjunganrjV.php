<?php

class AMInfokunjunganrjV extends InfokunjunganrjV {

    public $tgl_awal;
    public $tgl_akhir;
    public $data;
    public $jumlah;
    public $tick;
    public $ceklis = false;
    public $tglselesaiperiksa;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienM the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchDaftarPasien() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        
        if($this->ceklis)
            $criteria->addBetweenCondition('DATE(t.tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(t.statusperiksa)', strtolower($this->statusperiksa), true);
        //$criteria->compare('t.ruangan_id', Yii::app()->user->getState('ruangan_id'));
        //$criteria->condition = 'pasienpulang.pendaftaran_id = t.pendaftaran_id';
        //$criteria->order = 'no_urutantri';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function primaryKey() {
        return 'pendaftaran_id';
    }

    public static function berdasarkanStatus() {
        $status = array('pengunjung' => 'Berdasarkan Pengunjung',
            'kunjungan' => 'Berdasarkan Kunjungan',
            'rujukan' => 'Berdasarkan Rujukan'
        );
        return $status;
    }

    public function getNamaModel() {
        return __CLASS__;
    }

    public function searchTable() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('pasien_id', $this->pasien_id);
        $criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
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
        $criteria->compare('propinsi_id', $this->propinsi_id);
        $criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
        $criteria->compare('kabupaten_id', $this->kabupaten_id);
        $criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
        $criteria->compare('kelurahan_id', $this->kelurahan_id);
        $criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
        $criteria->compare('kecamatan_id', $this->kecamatan_id);
        $criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->compare('pekerjaan_id', $this->pekerjaan_id);
        $criteria->compare('LOWER(pekerjaan_nama)', strtolower($this->pekerjaan_nama), true);
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
        $criteria->compare('LOWER(gelardepan)', strtolower($this->gelardepan), true);
        $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('LOWER(gelarbelakang_nama)', strtolower($this->gelarbelakang_nama), true);
        $criteria->compare('carabayar_id', $this->carabayar_id);
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
        $criteria->compare('penjamin_id', $this->penjamin_id);
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
        $criteria->compare('caramasuk_id', $this->caramasuk_id);
        $criteria->compare('LOWER(caramasuk_nama)', strtolower($this->caramasuk_nama), true);
        $criteria->compare('shift_id', $this->shift_id);
        $criteria->compare('golonganumur_id', $this->golonganumur_id);
        $criteria->compare('LOWER(golonganumur_nama)', strtolower($this->golonganumur_nama), true);
        $criteria->compare('LOWER(no_rujukan)', strtolower($this->no_rujukan), true);
        $criteria->compare('LOWER(nama_perujuk)', strtolower($this->nama_perujuk), true);
        $criteria->compare('LOWER(tanggal_rujukan)', strtolower($this->tanggal_rujukan), true);
        $criteria->compare('LOWER(diagnosa_rujukan)', strtolower($this->diagnosa_rujukan), true);
        $criteria->compare('asalrujukan_id', $this->asalrujukan_id);
        $criteria->compare('LOWER(asalrujukan_nama)', strtolower($this->asalrujukan_nama), true);
        $criteria->compare('penanggungjawab_id', $this->penanggungjawab_id);
        $criteria->compare('LOWER(pengantar)', strtolower($this->pengantar), true);
        $criteria->compare('LOWER(hubungankeluarga)', strtolower($this->hubungankeluarga), true);
        $criteria->compare('LOWER(nama_pj)', strtolower($this->nama_pj), true);
        $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('instalasi_id', $this->instalasi_id);
        $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
        $criteria->compare('jeniskasuspenyakit_id', $this->jeniskasuspenyakit_id);
        $criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
        $criteria->compare('kelaspelayanan_id', $this->kelaspelayanan_id);
        $criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
    
    /** fungsi untuk generate filter / criteria pada model untuk grafik
    * $model adalah model yang akan digunakan untuk grafik
    * $type adalah filter akan digunakan sebagai x-axis('data') atau group('tick'), default type sebagai x-axis('data')
    * $addCols variable untuk column tmbahan, typenya mix, diantaranya untuk order dll,
    */
    public static function criteriaGrafik($model, $type='data', $addCols = array()){
        $criteria = new CDbCriteria;
        $criteria->select = 'count(pendaftaran_id) as jumlah';
        if ($_GET['filter'] == 'carabayar') {
            if (!empty($model->penjamin_id)) {
                $criteria->select .= ', penjamin_nama as '.$type;
                $criteria->group .= 'penjamin_nama';
            } else if (!empty($model->carabayar_id)) {
                $criteria->select .= ', penjamin_nama as '.$type;
                $criteria->group = 'penjamin_nama';
            } else {
                $criteria->select .= ', carabayar_nama as '.$type;
                $criteria->group = 'carabayar_nama';
            }
        } else if ($_GET['filter'] == 'wilayah') {
            if (!empty($model->kelurahan_id)) {
                $criteria->select .= ', kelurahan_nama as '.$type;
                $criteria->group .= 'kelurahan_nama';
            } else if (!empty($model->kecamatan_id)) {
                $criteria->select .= ', kelurahan_nama as '.$type;
                $criteria->group .= 'kelurahan_nama';
            } else if (!empty($model->kabupaten_id)) {
                $criteria->select .= ', kecamatan_nama as '.$type;
                $criteria->group .= 'kecamatan_nama';
            } else if (!empty($model->propinsi_id)) {
                $criteria->select .= ', kabupaten_nama as '.$type;
                $criteria->group .= 'kabupaten_nama';
            } else {
                $criteria->select .= ', propinsi_nama as '.$type;
                $criteria->group .= 'propinsi_nama';
            }
        }

        if (!isset($_GET['filter'])){
            $criteria->select .= ', propinsi_nama as '.$type;
            $criteria->group .= 'propinsi_nama';
        }

        if (is_array($addCols) && count((array)$addCols) > 0){
            foreach ($addCols as $i => $v){
                $criteria->group .= ','.$v;
                $criteria->select .= ','.$v.' as '.$i;
            }        
        }

        return $criteria;
    }

    public function searchGrafik() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        
        
        $criteria = $this->criteriaGrafik($this, 'tick');
        
        if ($this->pilihanx == 'pengunjung') {
            $criteria->select .= ', statuspasien as data';
            $criteria->group .= ', statuspasien';
        } else if ($this->pilihanx == 'kunjungan') {
            $criteria->select .= ', kunjungan as data';
            $criteria->group .= ', kunjungan';
        }
        else if ($this->pilihanx == 'rujukan'){
            $criteria->select .= ', statusmasuk as data';
            $criteria->group .= ', statusmasuk';
        }
        else{
            if ($_GET['filter'] == 'wilayah'){
                $criteria->select = 'count(pendaftaran_id) as jumlah, propinsi_nama as data';
                $criteria->group = 'propinsi_nama';
            }else{
                $criteria->select = 'count(pendaftaran_id) as jumlah, carabayar_nama as data';
                $criteria->group = 'carabayar_nama';
            }
        }

        $criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('propinsi_id', $this->propinsi_id);
        $criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
        $criteria->compare('kabupaten_id', $this->kabupaten_id);
        $criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
        $criteria->compare('kelurahan_id', $this->kelurahan_id);
        $criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
        $criteria->compare('kecamatan_id', $this->kecamatan_id);
        $criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
        $criteria->compare('carabayar_id', $this->carabayar_id);
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
        $criteria->compare('penjamin_id', $this->penjamin_id);
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
        $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->addCondition('tgl_pendaftaran BETWEEN \'' . $this->tgl_awal . '\' AND \'' . $this->tgl_akhir . '\'');
        $criteria->compare('pasien_id', $this->pasien_id);
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
        $criteria->compare('propinsi_id', $this->propinsi_id);
        $criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
        $criteria->compare('kabupaten_id', $this->kabupaten_id);
        $criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
        $criteria->compare('kelurahan_id', $this->kelurahan_id);
        $criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
        $criteria->compare('kecamatan_id', $this->kecamatan_id);
        $criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->compare('pekerjaan_id', $this->pekerjaan_id);
        $criteria->compare('LOWER(pekerjaan_nama)', strtolower($this->pekerjaan_nama), true);
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
        $criteria->compare('LOWER(gelardepan)', strtolower($this->gelardepan), true);
        $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('LOWER(gelarbelakang_nama)', strtolower($this->gelarbelakang_nama), true);
        $criteria->compare('carabayar_id', $this->carabayar_id);
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
        $criteria->compare('penjamin_id', $this->penjamin_id);
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
        $criteria->compare('caramasuk_id', $this->caramasuk_id);
        $criteria->compare('LOWER(caramasuk_nama)', strtolower($this->caramasuk_nama), true);
        $criteria->compare('shift_id', $this->shift_id);
        $criteria->compare('golonganumur_id', $this->golonganumur_id);
        $criteria->compare('LOWER(golonganumur_nama)', strtolower($this->golonganumur_nama), true);
        $criteria->compare('LOWER(no_rujukan)', strtolower($this->no_rujukan), true);
        $criteria->compare('LOWER(nama_perujuk)', strtolower($this->nama_perujuk), true);
        $criteria->compare('LOWER(tanggal_rujukan)', strtolower($this->tanggal_rujukan), true);
        $criteria->compare('LOWER(diagnosa_rujukan)', strtolower($this->diagnosa_rujukan), true);
        $criteria->compare('asalrujukan_id', $this->asalrujukan_id);
        $criteria->compare('LOWER(asalrujukan_nama)', strtolower($this->asalrujukan_nama), true);
        $criteria->compare('penanggungjawab_id', $this->penanggungjawab_id);
        $criteria->compare('LOWER(pengantar)', strtolower($this->pengantar), true);
        $criteria->compare('LOWER(hubungankeluarga)', strtolower($this->hubungankeluarga), true);
        $criteria->compare('LOWER(nama_pj)', strtolower($this->nama_pj), true);
        $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('instalasi_id', $this->instalasi_id);
        $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
        $criteria->compare('jeniskasuspenyakit_id', $this->jeniskasuspenyakit_id);
        $criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
        $criteria->compare('kelaspelayanan_id', $this->kelaspelayanan_id);
        $criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
        // Klo limit lebih kecil dari nol itu berarti ga ada limit 
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false,
                ));
    }

    function getNamaPasienNamaBin()
    {
        if(!empty($this->nama_bin)) {
            return $this->nama_pasien.' alias '.$this->nama_bin;
        }else{
            return $this->nama_pasien;
        }
    }
    
    /**
    * menampilkan data kunjungan pasien 
    * model & criteria harus sama dengan PemakaianAmbulanPasienRSController/AutocompleteKunjungan
    * @return \CActiveDataProvider
    */
    public function searchDialogKunjungan(){
        $criteria = new CDbCriteria();	
		$format = new MyFormatter();
//		$this->tgl_pendaftaran = empty($this->tgl_pendaftaran) ? date("Y-m-d") : $format->formatDateTimeForDb($this->tgl_pendaftaran); //filter grid
        //$tgl_pendaftaran = $this->getKonverviDateRange($this->tgl_pendaftaran);
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
        $criteria->compare('LOWER(statusperiksa)', strtolower($this->statusperiksa), true);
        $criteria->compare('carabayar_id', $this->carabayar_id);
        
        if($this->instalasi_id == Params::INSTALASI_ID_RJ){
//            $criteria->addBetweenCondition("DATE(tgl_pendaftaran)",$this->tgl_pendaftaran." 00:00:00",$this->tgl_pendaftaran." 23:59:59");
            //$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $tgl_pendaftaran[0]." 00:00:00", $tgl_pendaftaran[1]." 23:59:59");
			$model = new AMInfokunjunganrjV;
        }else if($this->instalasi_id == Params::INSTALASI_ID_RD){
//            $criteria->addBetweenCondition("DATE(tgl_pendaftaran)",$this->tgl_pendaftaran." 00:00:00",$this->tgl_pendaftaran." 23:59:59");
            //$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $tgl_pendaftaran[0]." 00:00:00", $tgl_pendaftaran[1]." 23:59:59");
            $model = new AMInfoKunjunganRDV;
        }else if($this->instalasi_id == Params::INSTALASI_ID_RI || $this->instalasi_id == Params::INSTALASI_ID_ICU){
//            $criteria->addBetweenCondition("DATE(tglmasukkamar)",$this->tgl_pendaftaran." 00:00:00",$this->tgl_pendaftaran." 23:59:59");
            //$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $tgl_pendaftaran[0]." 00:00:00", $tgl_pendaftaran[1]." 23:59:59");
            $model = new AMPasienrawatinapV;
        } else if ($this->instalasi_id == Params::INSTALASI_ID_HD) {
            $model = new InfokunjunganhdV;
        } else if ($this->instalasi_id == Params::INSTALASI_ID_JZ) {
            $model = new PasienmasukpenunjangV;
        } else if ($this->instalasi_id == Params::INSTALASI_ID_PERSALINAN) {
            $model = new InfokunjunganpersalinanV;
        }else{
            $model = $this;
        }
//		$this->tgl_pendaftaran = $format->formatDateTimeForUser($this->tgl_pendaftaran);
		$criteria->limit = 5;
        return new CActiveDataProvider($model, array(
                    'criteria'=>$criteria,
                    'pagination'=>array(
                        'pageSize'=>10
                    ),
            ));
    }
    
    public function getKonverviDateRange($tgl){
        $Tgl = (explode(" - ",$tgl));

        //harus di format date dulu karena hasil dri widget tidak sama seperti format DB
        $Tgl[0] = DateTime::createFromFormat('m/d/Y', $Tgl[0]);
        $Tgl[0] = $Tgl[0]->format('Y-m-d');
        $Tgl[1] = DateTime::createFromFormat('m/d/Y', $Tgl[1]);
        $Tgl[1] = $Tgl[1]->format('Y-m-d');
        return array($Tgl[0],$Tgl[1]);
    } 
    public function getStatus($status, $id)
    {
        $pendaftaran = PendaftaranT::model()->findByPk($id);
        $selisih = time() - strtotime($pendaftaran->tgl_pendaftaran);
        $selisih_waktuperiksa = time() - strtotime($pendaftaran->waktumulaiperiksa);
        $pulang = PasienpulangT::model()->findByAttributes(array(
            'pendaftaran_id'=>$id, 
            'pasienbatalpulang_id' => null,
        ));


        if (!empty($pulang)) {  
            $format = new MyFormatter();
            $tgl_pulang = $format->formatDateTimeForDb($pulang->tglpasienpulang);
            $selisih = time() - strtotime($tgl_pulang);
        }
        
        // untuk antrian di ambil dari tgl pendaftaran sampe tanggal antrian
        if ($selisih < 60) {
            $selisih = $selisih."d";
        } elseif ($selisih < 3600) {
            $selisih = floor($selisih/60)."m";
        } elseif ($selisih < (3600 * 24)) {
            $selisih = floor($selisih/3600)."j";
        } else {
            $selisih = floor($selisih/(3600 * 24))."h";
        }
        // end
   
        // untuk antrian di ambil dari tgl pendaftaran sampe tanggal antrian
        if ($selisih_waktuperiksa < 60) {
            $selisih_waktuperiksa = $selisih_waktuperiksa."d";
        } elseif ($selisih_waktuperiksa < 3600) {
            $selisih_waktuperiksa = floor($selisih_waktuperiksa/60)."m";
        } elseif ($selisih_waktuperiksa < (3600 * 24)) {
            $selisih_waktuperiksa = floor($selisih_waktuperiksa/3600)."j";
        } else {
            $selisih_waktuperiksa = floor($selisih_waktuperiksa/(3600 * 24))."h";
        }
        //end
        
        $status = trim($status);
        if ($status == "SEDANG PERIKSA") {
            $badge = '<span class="badge badge-info pull-right badge-status">'.$selisih_waktuperiksa.'</span>';
            $status = '<button id="red" class="btn btn-gold nohover btn-status" name="yt1">'.$status.'</button>';
            $status = '<div class="button-status">'.$badge.$status.'</div>';
        } elseif ($status == "ANTRIAN") {
            $badge = '<span class="badge badge-info pull-right badge-status">'.$selisih.'</span>';
            $status = '<button id="green" class="btn btn-black nohover btn-status" name="yt1">'.$status.'</button>';
            $status = '<div class="button-status">'.$badge.$status.'</div>';
        } elseif ($status == "SUDAH PULANG") {
            $status = '<button id="blue" class="btn btn-green nohover btn-status" name="yt1" >'.$status.'</button>';
        } elseif ($status == "SUDAH DI PERIKSA") {
            $status = '<button id="orange" class="btn btn-blue nohover btn-status"  name="yt1">'.$status.'</button>';
        } elseif ($status == "SEDANG DIRAWAT INAP") {
            $admisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$id));
            $selisih = ceil((time() - strtotime($admisi->tgladmisi)) / (3600 * 24))."h";
            $badge = '<span class="badge badge-info pull-right badge-status">'.$selisih.'</span>';
            $status = '<button id="orange" class="btn btn-purple nohover btn-status"  name="yt1">'.$status.'</button>';
            $status = '<div class="button-status">'.$badge.$status.'</div>';
        } elseif ($status == "MENUNGGU ADMISI PASIEN") {
            $badge = '<span class="badge badge-info pull-right badge-status">'.$selisih.'</span>';
            $status = '<button id="orange" class="btn btn-orange nohover btn-status"  name="yt1">'.$status.'</button>';
            $status = '<div class="button-status">'.$badge.$status.'</div>';
        } else {
            $status = '<button id="orange" class="btn btn-blue nohover btn-status"  name="yt1">'.$status.'</button>';
        }
        return $status;
    }
}

?>
