<?php

class PIInfopasienmasukkamarV extends InfopasienmasukkamarV {

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PasienrawatinapV the static model class
	 */
    public $totaltagihan;
	public $ceklis = false;
        public $ceklisAdmisi = false;
        public $carakeluar;
	public $is_dokter = 0;
	public $pegawai_id;
	public $pilih, $daftartindakan_id, $ceklist;
	public $jenisVisite,$tanggalVisite;
	public $is_nursestation;
        public $tanggalVisite_akhir;
        public $pindahkamar_id;
        public $statusdokrm;
        public $pengirimanrm_id;
	public $tgl_awall, $tgl_akhirl;

	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function searchPI() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$pegawai_id_login = Yii::app()->user->getState('pegawai_id');
		if($this->is_nursestation == 1 && Yii::app()->user->getState('nursestation_id') != null){ //RSKG-864
			$ruangan = array();
			$modNurseRuangan = NursestationruanganM::model()->findAll('nursestation_id='.Yii::app()->user->getState('nursestation_id'));
			if(count((array)$modNurseRuangan)>0){
				foreach ($modNurseRuangan as $value) {
					$ruangan[] = $value->ruangan_id;
				}
			}
			$criteria->addInCondition('ruangan_id', $ruangan);
		}else{
			$criteria->addCondition("(
				ruangan_id = ".Yii::app()->user->getState('ruangan_id')." and is_konsul = false
			) or (is_konsul = true and dpjp1_id = ".$pegawai_id_login.")");
		}
		
		if (!empty($this->penjamin_id)) {
			$criteria->addCondition("penjamin_id = " . $this->penjamin_id);
		}
		if (!empty($this->carabayar_id)) {
			$criteria->addCondition("carabayar_id = " . $this->carabayar_id);
		}
		if (!empty($this->caramasuk_id)) {
			$criteria->addCondition("caramasuk_id = " . $this->caramasuk_id);
		}
		if($this->ceklis == 1)
		{
			$criteria->addBetweenCondition('DATE(tanggal_lahir)', $this->tgl_awall, $this->tgl_akhirl);
		}
		$criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
		$criteria->compare('LOWER(no_identitas_pasien)', strtolower($this->no_identitas_pasien), true);
		$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
		$criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin), true);
		$criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
		$criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
		if(!empty($this->shift_id)){
			$criteria->addCondition("shift_id = ".$this->shift_id);			
		}
		if ($this->ceklisAdmisi == 1) {
			$this->tgl_awal = $this->tgl_awal;
			$this->tgl_akhir = $this->tgl_akhir;

			$criteria->addBetweenCondition('tgladmisi', $this->tgl_awal.' 00:00:00', $this->tgl_akhir.' 23:59:59'); //tambah waktu, karena berpengaruh saat pencarian
		}

		$criteria->order = "urutan_konsul desc, tgl_pendaftaran DESC";

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	public function searchPIDialog() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$format = new MyFormatter();
		$criteria = new CDbCriteria;
//		$this->tgl_pendaftaran = empty($this->tgl_pendaftaran) ? date("Y-m-d") : $format->formatDateTimeForDb($this->tgl_pendaftaran); //filter grid
		$tgl_pendaftaran = $this->getKonverviDateRange($this->tgl_pendaftaran);
		// $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $tgl_pendaftaran[0]." 00:00:00", $tgl_pendaftaran[1]." 23:59:59");
		$criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
		if (!empty($this->penjamin_id)) {
			$criteria->addCondition("penjamin_id = " . $this->penjamin_id);
		}
		if (!empty($this->carabayar_id)) {
			$criteria->addCondition("carabayar_id = " . $this->carabayar_id);
		}
		if (!empty($this->caramasuk_id)) {
			$criteria->addCondition("caramasuk_id = " . $this->caramasuk_id);
		}
		$criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
		$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
		$criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin), true);
		$criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
		$criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
		$criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
		$criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
//		$criteria->addBetweenCondition("DATE(tgl_pendaftaran)",$this->tgl_pendaftaran." 00:00:00",$this->tgl_pendaftaran." 23:59:59");
		if ($this->ceklis == 1) {
			$this->tgl_awal = $this->tgl_awal . " 00:00:00";
			$this->tgl_akhir = $this->tgl_akhir . " 23:59:59";

			$criteria->addBetweenCondition('tgladmisi', $this->tgl_awal, $this->tgl_akhir);
		}
//		$this->tgl_pendaftaran = $format->formatDateTimeForUser($this->tgl_pendaftaran);
		$criteria->limit = 5;
		return new CActiveDataProvider($this, array(
			'criteria'	 => $criteria,
			'pagination' => array(
                            'pageSize'=>5
                        ),
		));
	}

	public function getLamaRawat() {
		return CustomFunction::hitungHari($this->tglmasukkamar);
	}

	public function searchPILagi() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;


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
		if (!empty($this->propinsi_id)) {
			$criteria->addCondition("propinsi_id = " . $this->propinsi_id);
		}
		$criteria->compare('LOWER(propinsi_nama)', strtolower($this->propinsi_nama), true);
		if (!empty($this->kabupaten_id)) {
			$criteria->addCondition("kabupaten_id = " . $this->kabupaten_id);
		}
		$criteria->compare('LOWER(kabupaten_nama)', strtolower($this->kabupaten_nama), true);
		if (!empty($this->kelurahan_id)) {
			$criteria->addCondition("kelurahan_id = " . $this->kelurahan_id);
		}
		$criteria->compare('LOWER(kelurahan_nama)', strtolower($this->kelurahan_nama), true);
		if (!empty($this->kecamatan_id)) {
			$criteria->addCondition("kecamatan_id = " . $this->kecamatan_id);
		}
		$criteria->compare('LOWER(kecamatan_nama)', strtolower($this->kecamatan_nama), true);
		if (!empty($this->pendaftaran_id)) {
			$criteria->addCondition("pendaftaran_id = " . $this->pendaftaran_id);
		}
		if (!empty($this->pekerjaan_id)) {
			$criteria->addCondition("pekerjaan_id = " . $this->pekerjaan_id);
		}
		$criteria->compare('LOWER(pekerjaan_nama)', strtolower($this->pekerjaan_nama), true);
		$criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
		$criteria->compare('tgl_pendaftaran', $this->tgl_pendaftaran);
		$criteria->compare('LOWER(no_urutantri)', strtolower($this->no_urutantri), true);
		$criteria->compare('LOWER(transportasi)', strtolower($this->transportasi), true);
		$criteria->compare('LOWER(keadaanmasuk)', strtolower($this->keadaanmasuk), true);
		$criteria->compare('LOWER(statusperiksa)', strtolower($this->statusperiksa), true);
		$criteria->compare('LOWER(statuspasien)', strtolower($this->statuspasien), true);
		$criteria->compare('alihstatus', $this->alihstatus);
		$criteria->compare('byphone', $this->byphone);
		$criteria->compare('kunjunganrumah', $this->kunjunganrumah);
		$criteria->compare('LOWER(statusmasuk)', strtolower($this->statusmasuk), true);
		$criteria->compare('LOWER(umur)', strtolower($this->umur), true);
		$criteria->compare('LOWER(no_asuransi)', strtolower($this->no_asuransi), true);
		$criteria->compare('LOWER(namapemilik_asuransi)', strtolower($this->namapemilik_asuransi), true);
		$criteria->compare('LOWER(nopokokperusahaan)', strtolower($this->nopokokperusahaan), true);
		if (!empty($this->carabayar_id)) {
			$criteria->addCondition("carabayar_id = " . $this->carabayar_id);
		}
		$criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
		if (!empty($this->penjamin_id)) {
			$criteria->addCondition("penjamin_id = " . $this->penjamin_id);
		}
		$criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
		if (!empty($this->caramasuk_id)) {
			$criteria->addCondition("caramasuk_id = " . $this->caramasuk_id);
		}
		$criteria->compare('LOWER(caramasuk_nama)', strtolower($this->caramasuk_nama), true);
		if (!empty($this->shift_id)) {
			$criteria->addCondition("shift_id = " . $this->shift_id);
		}
		if (!empty($this->golonganumur_id)) {
			$criteria->addCondition("golonganumur_id = " . $this->golonganumur_id);
		}
		$criteria->compare('LOWER(golonganumur_nama)', strtolower($this->golonganumur_nama), true);
		$criteria->compare('LOWER(no_rujukan)', strtolower($this->no_rujukan), true);
		$criteria->compare('LOWER(nama_perujuk)', strtolower($this->nama_perujuk), true);
		$criteria->compare('LOWER(tanggal_rujukan)', strtolower($this->tanggal_rujukan), true);
		$criteria->compare('LOWER(diagnosa_rujukan)', strtolower($this->diagnosa_rujukan), true);
		if (!empty($this->asalrujukan_id)) {
			$criteria->addCondition("asalrujukan_id = " . $this->asalrujukan_id);
		}
		$criteria->compare('LOWER(asalrujukan_nama)', strtolower($this->asalrujukan_nama), true);
		if (!empty($this->penanggungjawab_id)) {
			$criteria->addCondition("penanggungjawab_id = " . $this->penanggungjawab_id);
		}
		$criteria->compare('LOWER(pengantar)', strtolower($this->pengantar), true);
		$criteria->compare('LOWER(hubungankeluarga)', strtolower($this->hubungankeluarga), true);
		$criteria->compare('LOWER(nama_pj)', strtolower($this->nama_pj), true);

		$criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));

		$criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
		if (!empty($this->instalasi_id)) {
			$criteria->addCondition("instalasi_id = " . $this->instalasi_id);
		}
		$criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
		if (!empty($this->jeniskasuspenyakit_id)) {
			$criteria->addCondition("jeniskasuspenyakit_id = " . $this->jeniskasuspenyakit_id);
		}
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);
		if (!empty($this->kelaspelayanan_id)) {
			$criteria->addCondition("kelaspelayanan_id = " . $this->kelaspelayanan_id);
		}
		$criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
		if (!empty($this->pasienadmisi_id)) {
			$criteria->addCondition("pasienadmisi_id = " . $this->pasienadmisi_id);
		}
		if ($this->ceklis) {
			$criteria->addBetweenCondition('tgladmisi', $this->tgl_awal, $this->tgl_akhir);
		}
		$criteria->compare('LOWER(tglpulang)', strtolower($this->tglpulang), true);
		$criteria->compare('LOWER(kunjungan)', strtolower($this->kunjungan), true);
		$criteria->compare('statuskeluar', $this->statuskeluar);
		$criteria->compare('rawatgabung', $this->rawatgabung);
		$criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
		$criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
		$criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
		$criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
		$criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
		if (!empty($this->kamarruangan_id)) {
			$criteria->addCondition("kamarruangan_id = " . $this->kamarruangan_id);
		}
		$criteria->compare('LOWER(kamarruangan_nokamar)', strtolower($this->kamarruangan_nokamar), true);
		$criteria->compare('LOWER(kamarruangan_nobed)', strtolower($this->kamarruangan_nobed), true);
		$criteria->compare('LOWER(gelardepan)', strtolower($this->gelardepan), true);
		$criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
		$criteria->compare('LOWER(gelarbelakang_nama)', strtolower($this->gelarbelakang_nama), true);
		$criteria->compare('LOWER(nomasukkamar)', strtolower($this->nomasukkamar), true);
		$criteria->compare('LOWER(tglmasukkamar)', strtolower($this->tglmasukkamar), true);
		$criteria->compare('LOWER(jammasukkamar)', strtolower($this->jammasukkamar), true);
		$criteria->compare('LOWER(tglkeluarkamar)', strtolower($this->tglkeluarkamar), true);
		$criteria->compare('LOWER(jamkeluarkamar)', strtolower($this->jamkeluarkamar), true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	public function searchPIVisiteDokter() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;


		$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
		$criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
		$criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
		if (!empty($this->pegawai_id)) {
			$criteria->addCondition('pegawai_id = ' . $this->pegawai_id);
		}
		$criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
		$kelaspelayananruangan = Yii::app()->user->getState('kelaspelayananruangan');
		if (!empty($kelaspelayananruangan)) {
			$criteria->addInCondition("kelaspelayanan_id", $kelaspelayananruangan);
			if (is_array($kelaspelayananruangan)) {
				$criteria->addInCondition("kelaspelayanan_id", $kelaspelayananruangan);
			} else {
				$criteria->addCondition("kelaspelayanan_id = " . $kelaspelayananruangan);
			}
		}


		return new CActiveDataProvider($this, array(
			'criteria'	 => $criteria,
			'pagination' => false,
		));
	}

	public function searchRincianTagihan() {
		$criteria = new CDbCriteria();

		$criteria->with = array('pendaftaran');
		$criteria->addBetweenCondition('date(t.tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('LOWER(t.no_rekam_medik)', strtolower($this->no_rekam_medik), true);
		$criteria->compare('LOWER(t.namadepan)', strtolower($this->namadepan), true);
		$criteria->compare('LOWER(t.nama_pasien)', strtolower($this->nama_pasien), true);
		$criteria->compare('LOWER(t.nama_bin)', strtolower($this->nama_bin), true);
		$criteria->compare('LOWER(t.no_pendaftaran)', strtolower($this->no_pendaftaran), true);
		$criteria->addCondition('t.ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
		if ($this->statusBayar == 'LUNAS') {
			$criteria->addCondition('pendaftaran.pembayaranpelayanan_id is not null');
		} else if ($this->statusBayar == 'BELUM LUNAS') {
			$criteria->addCondition('pendaftaran.pembayaranpelayanan_id is null');
		}

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	/**
	 * Untuk menampilkan informasi pindahan dari
	 */
	public function getPindahanDari() {
		$modMasukkamarlama = PIMasukKamarT::model()->findByAttributes(array('pindahkamar_id' => $this->pindahkamar_id));
		if (!$modMasukkamarlama)
			$modMasukkamarlama = new PIMasukKamarT;
		return $modMasukkamarlama;
	}

	/**
	 * Untuk mengecek tindakan dan obat dari pasienadmisi
	 */
	public function getTindakanDanObat() {
		$retVal = array();
		$retVal['ada'] = 0;
		$retVal['jmltindakan'] = 0;
		$retVal['jmlobat'] = 0;
		$retVal['msg'] = "";
		$modTindakan = TindakanpelayananT::model()->findAllByAttributes(array('pasienadmisi_id'	 => $this->pasienadmisi_id,
			'ruangan_id'		 => Yii::app()->user->getState('ruangan_id')));
		$retVal['jmltindakan'] = count((array)$modTindakan);
		if ($retVal['jmltindakan'] > 0)
			$retVal['msg'] .= $retVal['jmltindakan'] . " tindakan ";
		$modObatalkes = ObatalkespasienT::model()->findAllByAttributes(array('pasienadmisi_id' => $this->pasienadmisi_id));
		$retVal['jmlobat'] = count((array)$modObatalkes);
		if ($retVal['jmlobat'] > 0)
			$retVal['msg'] .= $retVal['jmlobat'] . " obat ";
		$retVal['ada'] = $retVal['jmltindakan'] + $retVal['jmlobat'];
		return $retVal;
	}

	public function searchDialogKunjungan() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;
		$format = new MyFormatter();
		// $this->tglmasukkamar = empty($this->tglmasukkamar) ? date("Y-m-d") : $format->formatDateTimeForDb($this->tglmasukkamar); //filter grid
		// $criteria->addBetweenCondition("DATE(tglmasukkamar)",$this->tglmasukkamar." 00:00:00",$this->tglmasukkamar." 23:59:59");
                
        // if (!empty($this->tglmasukkamar)) {        
        //     $tglmasukkamar = $this->getKonverviDateRange($this->tglmasukkamar);
        //     $criteria->addBetweenCondition('DATE(tglmasukkamar)', $tglmasukkamar[0]." 00:00:00", $tglmasukkamar[1]." 23:59:59");
		// }
		// $criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir);
		// $criteria->addBetweenCondition('DATE(tglmasukkamar)', $this->$tglmasukkamar);
		$criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
		$criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
		$criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
		$criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
		$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
		if (!empty($this->carabayar_id)) {
			$criteria->addCondition("carabayar_id = " . $this->carabayar_id);
		}
		if (!empty($this->ruangan_id)){
			$criteria->addCondition("ruangan_id = " . $this->ruangan_id);
		}
		$criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
		$criteria->limit = 5;
//		$this->tglmasukkamar = $format->formatDateTimeForUser($this->tglmasukkamar);
		return new CActiveDataProvider($this, array(
			'criteria'	 => $criteria,
			'pagination' => array(
                            'pageSize'=>5
                        ),
		));
	}

	/**
	 * untuk status dokumen rekam medis
	 */
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
			$modPengiriman = PengirimanrmT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id), array(
				'order' => 'pengirimanrm_id desc'));
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
					$status_dokumen = '<button id="red" class="btn btn-primary" name="yt1" onclick="setPenerimaan(this,' . $pengirimanrm_id . ',' . $ruanganpenerima_id . ',\'' . $status_dok . '\',' . $pendaftaran_id . ')">' . $status . '</button>';
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

	/**
	 * Untuk cek rencanatindakan
	 */
	public function cekRencana($pendaftaran_id = null) {

		$modRencana = PIRencanatindakanT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
		if (!empty($modRencana)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Untuk cek verifikasi rencana
	 */
	public function cekVerifikasi($pendaftaran_id = null) {

		$modRencana = PIRencanatindakanT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id,
			'verifrenctindakan_id' => null));
		if (!empty($modRencana)) {
			return true;
		} else {
			return false;
		}
	}
        
        public function getKonverviDateRange($tgl){
            
            if (empty($tgl)) return "";
            
            $Tgl = (explode(" - ",$tgl));
            

            //harus di format date dulu karena hasil dri widget tidak sama seperti format DB
            $Tgl[0] = DateTime::createFromFormat('m/d/Y', $Tgl[0]);
            $Tgl[0] = $Tgl[0]->format('Y-m-d');
            $Tgl[1] = DateTime::createFromFormat('m/d/Y', $Tgl[1]);
            $Tgl[1] = $Tgl[1]->format('Y-m-d');
            return array($Tgl[0],$Tgl[1]);
        }
        
    public function getAlergiObat() {
        $nama = ''; 
        $modAnamnesa = AnamnesaT::model()->findAllByAttributes(array('pendaftaran_id' => $this->pendaftaran_id));
        
        if (count((array)$modAnamnesa)) {
            $no = 1;
            $checkAlergi = 0;
            foreach ($modAnamnesa as $anamnesa => $val) {
                if(!empty(trim($val->riwayatalergiobat))){
                    $val->riwayatalergiobat = preg_replace('/\s+/', '', $val->riwayatalergiobat);
                    $datatable = explode(',', trim($val->riwayatalergiobat));
                    if(!empty($datatable)){
                        foreach ($datatable as $key => $value) {
                            $nama .=' ' . $no . '.' . $value . '<br>';
                            $no++;
                        }
                    }
                    $checkAlergi++;
                }else{
                    if($checkAlergi > 1){
                        $checkAlergi--;
                    }
                }
            }    
            if($checkAlergi == 0){
                $nama = 'TIDAK ADA'; 
            }
        }else{
            $nama = 'TIDAK ADA'; 
        }
        return $nama;
    }
}

?>
