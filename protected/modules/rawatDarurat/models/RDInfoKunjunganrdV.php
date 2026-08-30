<?php

class RDInfoKunjunganrdV extends InfokunjunganrdV {

    public $tgl_awal;
    public $tgl_awall;
    public $tgl_akhir;
    public $tgl_akhirl, $AlergiObat, $linkPeriksaPasienRD;
    public $data;
    public $jumlah;
    public $tick;
	public $ceklis = false;

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

        $criteria->addBetweenCondition('t.tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(t.no_identitas_pasien)', strtolower($this->no_identitas_pasien), true);
        $criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(t.statusperiksa)', strtolower($this->statusperiksa), true);
        $criteria->addCondition('t.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->with = array('pendaftaran');
        //$criteria->condition = 'pasienpulang.pendaftaran_id = t.pendaftaran_id';
        $criteria->order = 't.tgl_pendaftaran DESC';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }
	
	public function searchDialogKunjungan() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(no_identitas_pegawai)', strtolower($this->no_identitas_pegawai), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(statusperiksa)', strtolower($this->statusperiksa), true);
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
        $criteria->compare('LOWER(statusperiksa)', strtolower($this->statusperiksa), true);
        $criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->order = 'tgl_pendaftaran ASC';
        $criteria->limit = 10;
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false,
                ));
    }
    public function getStatusDokumen($pengirimanrm_id, $status, $pendaftaran_id) {
        $status_dokumen = '';
        $statusruangan = '';
        $tombol = '';
        $status_dok = $status;
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        if (empty($status) && empty($pengirimanrm_id)) {
            $status = 'BELUM DIKIRIM';
        } else if (empty($status) || !empty($pengirimanrm_id)) {
            $status = 'SUDAH DIKIRIM';
        }

        if (!empty($pengirimanrm_id)) {
            $modPengiriman = PengirimanrmT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'pengirimanrm_id desc'));
            $ruanganpenerima_id = $modPengiriman->ruanganpenerima_id;
            if (!empty($modPengiriman)) {
                if (!empty($modPengiriman->ruangan_id) && $modPengiriman->ruangan_id == Yii::app()->user->getState('ruangan_id')) {
                    $statusruangan = " DARI " . strtoupper($modPengiriman->ruanganpengirim->ruangan_nama);
                    $status = 'SUDAH DIKIRIM' . $statusruangan;
                    $status_dokumen = '<button id="red" class="btn btn-primary" name="yt1" onclick="penerimaanDokumen(this,' . $pengirimanrm_id . ',\'' . $status_dok . '\',' . $pendaftaran_id . ')">' . $status . '</button>';
                    $tombol = "";
                } else if (!empty($modPengiriman->ruangan_id) && $modPengiriman->ruangan_id != Yii::app()->user->getState('ruangan_id')) {
                    $statusruangan = " KE- " . strtoupper($modPengiriman->ruangantujuan->ruangan_nama);
                    $status = 'SUDAH DIKIRIM' . $statusruangan;
                    if (empty($ruanganpenerimaan_id)) {
                        $ruanganpenerima_id = 99;
                    }
                    $status_dokumen = '<button id="red" class="btn btn-success" name="yt1" onclick="setPenerimaan(this,' . $pengirimanrm_id . ',' . $ruanganpenerima_id . ',\'' . $status_dok . '\',' . $pendaftaran_id . ')">' . $status . '</button>';
                }
            }
        }

        if (!empty($modPendaftaran)) {
            if (!empty($modPendaftaran->pengirimanrm_id)) {
//				$status_dokumen = '<button id="red" class="btn btn-primary" name="yt1" onclick="setStatusDokumen(this,'.$pengirimanrm_id.',\''.$status.'\','.$pendaftaran_id.')">'.$status.'</button>';
                $status_dokumen = $status_dokumen;
            } else {
                $status_dokumen = '<button id="green" class="btn btn-danger" name="yt1">' . $status . '</button>';
            }
        }
        return $status_dokumen;
    }



    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            //'pasienpulang'=> array(self::HAS_ONE, 'PasienpulangT', 'pendaftaran_id'),
            'pendaftaran' => array(self::BELONGS_TO, 'RDPendaftaranT', 'pendaftaran_id'),
                //'operasi'=>array(self::BELONGS_TO, 'OperasiM', 'operasi_id'),
        );
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

		if(!empty($this->pasien_id)){
			$criteria->addCondition("pasien_id = ".$this->pasien_id);				
		}
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
		if(!empty($this->propinsi_id)){
			$criteria->addCondition("propinsi_id = ".$this->propinsi_id);				
		}
        $criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id);				
		}
        $criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id);				
		}
        $criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id);				
		}
        $criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);				
		}
		if(!empty($this->pekerjaan_id)){
			$criteria->addCondition("pekerjaan_id = ".$this->pekerjaan_id);				
		}
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
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("carabayar_id = ".$this->carabayar_id);				
		}
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id);				
		}
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
		if(!empty($this->caramasuk_id)){
			$criteria->addCondition("caramasuk_id = ".$this->caramasuk_id);				
		}
        $criteria->compare('LOWER(caramasuk_nama)', strtolower($this->caramasuk_nama), true);
		if(!empty($this->shift_id)){
			$criteria->addCondition("shift_id = ".$this->shift_id);				
		}
		if(!empty($this->golonganumur_id)){
			$criteria->addCondition("golonganumur_id = ".$this->golonganumur_id);				
		}
        $criteria->compare('LOWER(golonganumur_nama)', strtolower($this->golonganumur_nama), true);
        $criteria->compare('LOWER(no_rujukan)', strtolower($this->no_rujukan), true);
        $criteria->compare('LOWER(nama_perujuk)', strtolower($this->nama_perujuk), true);
        $criteria->compare('LOWER(tanggal_rujukan)', strtolower($this->tanggal_rujukan), true);
        $criteria->compare('LOWER(diagnosa_rujukan)', strtolower($this->diagnosa_rujukan), true);
		if(!empty($this->asalrujukan_id)){
			$criteria->addCondition("asalrujukan_id = ".$this->asalrujukan_id);				
		}
        $criteria->compare('LOWER(asalrujukan_nama)', strtolower($this->asalrujukan_nama), true);
		if(!empty($this->penanggungjawab_id)){
			$criteria->addCondition("penanggungjawab_id = ".$this->penanggungjawab_id);				
		}
        $criteria->compare('LOWER(pengantar)', strtolower($this->pengantar), true);
        $criteria->compare('LOWER(hubungankeluarga)', strtolower($this->hubungankeluarga), true);
        $criteria->compare('LOWER(nama_pj)', strtolower($this->nama_pj), true);
        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition("instalasi_id = ".$this->instalasi_id);				
		}
        $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition("jeniskasuspenyakit_id = ".$this->jeniskasuspenyakit_id);				
		}
        $criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id);				
		}
        $criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
        $criteria->order = 'tgl_pendaftaran DESC';

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
        if (!empty($criteria->group) &&(!empty($this->pilihanx))){
            $criteria->group .=',';
        }
        if ($this->pilihanx == 'pengunjung') {
            $criteria->select .= ', statuspasien as data';
            $criteria->group .= ' statuspasien';
        } else if ($this->pilihanx == 'kunjungan') {
            $criteria->select .= ', kunjungan as data';
            $criteria->group .= ' kunjungan';
        }
        else if ($this->pilihanx == 'rujukan'){
            $criteria->select .= ', statusmasuk as data';
            $criteria->group .= ' statusmasuk';
        }
        
        if (empty($this->pilihanx)){
            $criteria = $this->criteriaGrafik($this, 'data');
        }

        $criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
		if(!empty($this->propinsi_id)){
			$criteria->addCondition("propinsi_id = ".$this->propinsi_id);				
		}
        $criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id);				
		}
        $criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id);				
		}
        $criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id);				
		}
        $criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("carabayar_id = ".$this->carabayar_id);				
		}
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id);				
		}
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->order = 'tgl_pendaftaran DESC';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function searchPrint() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->addCondition('tgl_pendaftaran BETWEEN \'' . $this->tgl_awal . '\' AND \'' . $this->tgl_akhir . '\'');
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
        $criteria->compare('LOWER(no_identitas_pasien)', strtolower($this->no_identitas_pasien), true);
        $criteria->compare('LOWER(tgl_rekam_medik)', strtolower($this->tgl_rekam_medik), true);
		if(!empty($this->propinsi_id)){
			$criteria->addCondition("propinsi_id = ".$this->propinsi_id);				
		}
        $criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id);				
		}
        $criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id);				
		}
        $criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id);				
		}
        $criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);				
		}
		if(!empty($this->pekerjaan_id)){
			$criteria->addCondition("pekerjaan_id = ".$this->pekerjaan_id);				
		}
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
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("carabayar_id = ".$this->carabayar_id);				
		}
        $criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id);				
		}
        $criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
		if(!empty($this->caramasuk_id)){
			$criteria->addCondition("caramasuk_id = ".$this->caramasuk_id);				
		}
        $criteria->compare('LOWER(caramasuk_nama)', strtolower($this->caramasuk_nama), true);
		if(!empty($this->shift_id)){
			$criteria->addCondition("shift_id = ".$this->shift_id);				
		}
		if(!empty($this->golonganumur_id)){
			$criteria->addCondition("golonganumur_id = ".$this->golonganumur_id);				
		}
        $criteria->compare('LOWER(golonganumur_nama)', strtolower($this->golonganumur_nama), true);
        $criteria->compare('LOWER(no_rujukan)', strtolower($this->no_rujukan), true);
        $criteria->compare('LOWER(nama_perujuk)', strtolower($this->nama_perujuk), true);
        $criteria->compare('LOWER(tanggal_rujukan)', strtolower($this->tanggal_rujukan), true);
        $criteria->compare('LOWER(diagnosa_rujukan)', strtolower($this->diagnosa_rujukan), true);
		if(!empty($this->asalrujukan_id)){
			$criteria->addCondition("asalrujukan_id = ".$this->asalrujukan_id);				
		}
        $criteria->compare('LOWER(asalrujukan_nama)', strtolower($this->asalrujukan_nama), true);
		if(!empty($this->penanggungjawab_id)){
			$criteria->addCondition("penanggungjawab_id = ".$this->penanggungjawab_id);				
		}
        $criteria->compare('LOWER(pengantar)', strtolower($this->pengantar), true);
        $criteria->compare('LOWER(hubungankeluarga)', strtolower($this->hubungankeluarga), true);
        $criteria->compare('LOWER(nama_pj)', strtolower($this->nama_pj), true);
        $criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition("instalasi_id = ".$this->instalasi_id);				
		}
        $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
		if(!empty($this->jeniskasuspenyakit_id)){
			$criteria->addCondition("jeniskasuspenyakit_id = ".$this->jeniskasuspenyakit_id);				
		}
        $criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
		if(!empty($this->kelaspelayanan_id)){
			$criteria->addCondition("kelaspelayanan_id = ".$this->kelaspelayanan_id);				
		}
        $criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
        $criteria->order = 'tgl_pendaftaran DESC';
        // Klo limit lebih kecil dari nol itu berarti ga ada limit 
        $criteria->limit = -1;

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    'pagination' => false,
                ));
    }
    
    public function getTotaltagihan(){
        $criteria = new CDbCriteria();
        $criteria->select = 'sum(tarif_satuan * qty_tindakan) as tarif_satuan';
		if(!empty($this->pendaftaran_id)){
			$criteria->addCondition("pendaftaran_id = ".$this->pendaftaran_id);				
		}
        $jumlah = RincianbelumbayarrdV::model()->find($criteria)->tarif_satuan;
        if (empty($jumlah)){
            $jumlah = 0;
        }
        return $jumlah;
    }
    
    public function searchDaftarPasienRincian() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

		//RND-7180
		$criteria->select = "pembayaranpelayanan_t.pembayaranpelayanan_id, t.pendaftaran_id, "
				. "t.nama_pegawai, t.kelaspelayanan_nama, t.jeniskasuspenyakit_nama, "
				. "t.carabayar_id, t.penjamin_id, t.carabayar_nama, t.penjamin_nama, t.nama_pasien, t.nama_bin, "
				. "t.no_pendaftaran, t.no_rekam_medik, t.tgl_pendaftaran, t.ruangan_id, t.instalasi_id,"
				. "t.ruangan_nama, t.instalasi_nama, t.pasien_id";
		$criteria->group = "pembayaranpelayanan_t.pembayaranpelayanan_id, t.pendaftaran_id, "
				. "t.nama_pegawai, t.kelaspelayanan_nama, t.jeniskasuspenyakit_nama, "
				. "t.carabayar_id, t.penjamin_id,t.carabayar_nama, t.penjamin_nama,t.nama_pasien, t.nama_bin, "
				. "t.no_pendaftaran, t.no_rekam_medik, t.tgl_pendaftaran, t.ruangan_id, t.instalasi_id,"
				. "t.ruangan_nama, t.instalasi_nama, t.pasien_id";
        $criteria->addBetweenCondition('DATE(t.tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($this->prefix_pendaftaran.$this->no_pendaftaran), true);
        $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(t.statusperiksa)', strtolower($this->statusperiksa), true);
        $criteria->compare('t.pegawai_id', $this->pegawai_id);
        $criteria->addCondition('t.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->order = 't.tgl_pendaftaran DESC';
        if ($this->statusBayar == 'LUNAS'){
            
            $criteria->addCondition('pembayaranpelayanan_t.pembayaranpelayanan_id is not null');
        }else if ($this->statusBayar == 'BELUM LUNAS'){
            $criteria->addCondition('pembayaranpelayanan_t.pembayaranpelayanan_id is null');
        }
        
//        echo $this->statusBayar;
//        $criteria->with = array('pendaftaran');
		$criteria->join = 'LEFT JOIN pembayaranpelayanan_t ON pembayaranpelayanan_t.pendaftaran_id = t.pendaftaran_id';
        //$criteria->condition = 'pasienpulang.pendaftaran_id = t.pendaftaran_id';
        //$criteria->order = 'no_urutantri';

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

	public function searchRD()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;


        // $criteria->compare('LOWER(tgl_pendaftaran)',strtolower($this->tgl_pendaftaran),true);
        $criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(no_pendaftaran)',strtolower($this->no_pendaftaran),true);
		$criteria->compare('LOWER(statusperiksa)',strtolower($this->statusperiksa),true);
		$criteria->compare('LOWER(statusmasuk)',strtolower($this->statusmasuk),true);
		$criteria->compare('LOWER(no_rekam_medik)',strtolower($this->no_rekam_medik),true);
        $criteria->compare('LOWER(no_identitas_pasien)',strtolower($this->no_identitas_pasien),true);
		$criteria->compare('LOWER(nama_pasien)',strtolower($this->nama_pasien),true);
		$criteria->compare('LOWER(nama_bin)',strtolower($this->nama_bin),true);
		$criteria->compare('LOWER(alamat_pasien)',strtolower($this->alamat_pasien),true);
		if(!empty($this->propinsi_id)){
			$criteria->addCondition("propinsi_id = ".$this->propinsi_id);				
		}
		$criteria->compare('LOWER(propinsi_nama)',strtolower($this->propinsi_nama),true);
		if(!empty($this->kabupaten_id)){
			$criteria->addCondition("kabupaten_id = ".$this->kabupaten_id);				
		}
		$criteria->compare('LOWER(kabupaten_nama)',strtolower($this->kabupaten_nama),true);
		if(!empty($this->kecamatan_id)){
			$criteria->addCondition("kecamatan_id = ".$this->kecamatan_id);				
		}                
		if($this->ceklis)
		{
			$criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
		}                
		$criteria->compare('LOWER(kecamatan_nama)',strtolower($this->kecamatan_nama),true);
		if(!empty($this->kelurahan_id)){
			$criteria->addCondition("kelurahan_id = ".$this->kelurahan_id);				
		}
		$criteria->compare('LOWER(kelurahan_nama)',strtolower($this->kelurahan_nama),true);
		if(!empty($this->instalasi_id)){
			$criteria->addCondition("instalasi_id = ".$this->instalasi_id);				
		}
		$criteria->compare('LOWER(ruangan_nama)',strtolower($this->ruangan_nama),true);
		if(!empty($this->carabayar_id)){
			$criteria->addCondition("carabayar_id = ".$this->carabayar_id);				
		}
		$criteria->compare('LOWER(carabayar_nama)',strtolower($this->carabayar_nama),true);
		if(!empty($this->penjamin_id)){
			$criteria->addCondition("penjamin_id = ".$this->penjamin_id);				
		}
		$criteria->compare('LOWER(penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)',strtolower($this->jeniskasuspenyakit_nama),true);
		if(!empty($this->rujukan_id)){
			$criteria->addCondition("rujukan_id = ".$this->rujukan_id);				
		}
		$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
        $criteria->order = 'tgl_pendaftaran DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
	protected function afterFind(){
		foreach($this->metadata->tableSchema->columns as $columnName => $column){

			if (!strlen($this->$columnName)) continue;

			if ($column->dbType == 'date'){                         
					$this->$columnName = Yii::app()->dateFormatter->formatDateTime(
									CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
					}elseif ($column->dbType == 'timestamp without time zone'){
							$this->$columnName = Yii::app()->dateFormatter->formatDateTime(
									CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss','medium',null));
					}
		}
		return true;
	}
        
        
	function getNamaPasienNamaBin()
	{
		return $this->nama_pasien.' bin '.$this->nama_bin;
	}
	
	
	public function getInsatalasiRuangan()
	{
		   
		return $this->instalasi_nama.' / '.$this->ruangan_nama;
	}
        
        public function getStatus($status,$id){
            $status = trim($status);
            if($status == "ANTRIAN"){
                $status = '<button id="red" class="btn btn-primary" name="yt1">'.$status.'</button>';

            }else if($status == "SEDANG PERIKSA"){
                $status = '<button id="green" class="btn btn-danger" name="yt1" onclick="setStatus(this,\''.$status.'\','.$id.')">'.$status.'</button>';
            }else if($status == "SUDAH PULANG"){
                $status = '<button id="blue" class="btn btn-danger-yellow" name="yt1" onclick="setStatus(this,\''.$status.'\','.$id.')">'.$status.'</button>';
            }else if($status == "SUDAH DI PERIKSA"){
                $status = '<button id="red" class="btn btn-danger-red" name="yt1" onclick="setStatus(this,\''.$status.'\','.$id.')">'.$status.'</button>';
            }else{
                $status = '<button id="orange" class="btn btn-danger-blue"  name="yt1">'.$status.'</button>';
            }
            return $status;
        }
        
        public function searchPasienPembebasanTarif() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->join = "LEFT JOIN pembayaranpelayanan_t pp ON pp.pembayaranpelayanan_id = t.pembayaranpelayanan_id";
//        $criteria->addBetweenCondition('t.tgl_pendaftaran', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
        $criteria->compare('LOWER(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
        $criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);
        $criteria->compare('LOWER(t.statusperiksa)', strtolower($this->statusperiksa), true);
        $criteria->compare('LOWER(t.ruangan_nama)', strtolower($this->ruangan_nama), true);
        $criteria->compare('LOWER(t.nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('LOWER(t.penjamin_nama)', strtolower($this->penjamin_nama), true);
        $criteria->compare('LOWER(t.carabayar_nama)', strtolower($this->carabayar_nama), true);
        if (isset($this->tgl_pendaftaran)){  
            //$criteria->addBetweenCondition('DATE(t.tgl_pendaftaran)', $this->tgl_pendaftaran." 00:00:00", $this->tgl_pendaftaran." 23:59:59");
        }
        
        $criteria->compare('LOWER(t.jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
       // $criteria->compare('LOWER(t.statusperiksa)', strtolower($this->statusperiksa), true);
        $criteria->addCondition('t.instalasi_id = '.Yii::app()->user->getState('instalasi_id'));        
        $criteria->addCondition('t.ruangan_id = '.Yii::app()->user->getState('ruangan_id')); 
        $criteria->addCondition(" t.statusperiksa = '".Params::STATUSPERIKSA_SUDAH_DIPERIKSA."' ");
//        $criteria->addBetweenCondition("t.tgl_pendaftaran", date('Y-m-d').' 00:00:00', date('Y-m-d').' 23:59:59');
        $criteria->addCondition(" t.penjamin_id = '".Params::PENJAMIN_ID_UMUM."' ");//pembayaranpelayanan_id        
        $criteria->addCondition(" (LOWER(pp.statusbayar) ilike  '%".Params::STATUSBAYAR_BELUM_LUNAS."%') OR (t.pembayaranpelayanan_id IS NULL) ");
        $criteria->with = array('pendaftaran');

        //$criteria->condition = 'pasienpulang.pendaftaran_id = t.pendaftaran_id';
        $criteria->order = 't.tgl_pendaftaran DESC';
        $criteria->limit = 10;
        
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    //'pagination' => false,
                ));
    }
}


?>
