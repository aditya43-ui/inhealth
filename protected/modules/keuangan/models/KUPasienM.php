<?php

class KUPasienM extends PasienM {

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AnamnesaT the static model class
	 */
	public $idInstalasi, $ruangan_nama, $carabayar_nama, $tgl_pendaftaran_cari, $instalasi_nama;
	public $pembayaranpelayanan_id, $instalasi_id;
	public $no_pendaftaran;

	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function searchPembayaranKlaim() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('pasien_id', $this->pasien_id);
		$criteria->compare('pekerjaan_id', $this->pekerjaan_id);
		$criteria->compare('kelurahan_id', $this->kelurahan_id);
		$criteria->compare('pendidikan_id', $this->pendidikan_id);
		$criteria->compare('propinsi_id', $this->propinsi_id);
		$criteria->compare('kecamatan_id', $this->kecamatan_id);
		$criteria->compare('suku_id', $this->suku_id);
		$criteria->compare('profilrs_id', $this->profilrs_id);
		$criteria->compare('kabupaten_id', $this->kabupaten_id);
		$criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
		$criteria->compare('LOWER(tgl_rekam_medik)', strtolower($this->tgl_rekam_medik), true);
		$criteria->compare('LOWER(jenisidentitas)', strtolower($this->jenisidentitas), true);
		$criteria->compare('LOWER(no_identitas_pasien)', strtolower($this->no_identitas_pasien), true);
		$criteria->compare('LOWER(namadepan)', strtolower($this->namadepan), true);
		$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
		$criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin), true);
		$criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
		$criteria->compare('kelompokumur_id', $this->kelompokumur_id);
		$criteria->compare('LOWER(tempat_lahir)', strtolower($this->tempat_lahir), true);
		$criteria->compare('LOWER(tanggal_lahir)', strtolower($this->tanggal_lahir), true);
		$criteria->compare('LOWER(alamat_pasien)', strtolower($this->alamat_pasien), true);
		$criteria->compare('rt', $this->rt);
		$criteria->compare('rw', $this->rw);
		$criteria->compare('LOWER(statusperkawinan)', strtolower($this->statusperkawinan), true);
		$criteria->compare('LOWER(agama)', strtolower($this->agama), true);
		$criteria->compare('LOWER(golongandarah)', strtolower($this->golongandarah), true);
		$criteria->compare('LOWER(rhesus)', strtolower($this->rhesus), true);
		$criteria->compare('anakke', $this->anakke);
		$criteria->compare('jumlah_bersaudara', $this->jumlah_bersaudara);
		$criteria->compare('LOWER(no_telepon_pasien)', strtolower($this->no_telepon_pasien), true);
		$criteria->compare('LOWER(no_mobile_pasien)', strtolower($this->no_mobile_pasien), true);
		$criteria->compare('LOWER(warga_negara)', strtolower($this->warga_negara), true);
		$criteria->compare('LOWER(photopasien)', strtolower($this->photopasien), true);
		$criteria->compare('LOWER(alamatemail)', strtolower($this->alamatemail), true);
		$criteria->compare('LOWER(statusrekammedis)', strtolower($this->statusrekammedis), true);
		$criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
		$criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
		$criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
		$criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
		$criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
		$criteria->compare('LOWER(tgl_meninggal)', strtolower($this->tgl_meninggal), true);
		$criteria->compare('LOWER(nama_ibu)', strtolower($this->nama_ibu), true);
		$criteria->compare('LOWER(nama_ayah)', strtolower($this->nama_ayah), true);
		$criteria->with = array('pendaftaran');
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	public function searchPasienRumahsakitV() {
		$format = new MyFormatter();
		$model = null;
		$criteria = new CDbCriteria();
		if ($this->idInstalasi == Params::INSTALASI_ID_LAB) {
			$criteria->select = 'no_rekam_medik, no_pendaftaran, pendaftaran_id, nama_pasien, jeniskelamin, tgl_pendaftaran, instalasi_id, 
							   instalasi_nama, carabayar_nama, jeniskasuspenyakit_nama, umur, nama_bin';

			$criteria->group = $criteria->select;

			$criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
			if (!empty($this->tgl_pendaftaran_cari)) {
				$this->tgl_pendaftaran_cari = $format->formatDateTimeForDb($this->tgl_pendaftaran_cari);
				$criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_pendaftaran_cari . " 00:00:00", $this->tgl_pendaftaran_cari . " 23:59:59");
			}
			$criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
			$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
			$criteria->compare('instalasi_id', $this->idInstalasi);

			// $criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
			$criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
			$criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
			$criteria->addCondition('pembayaranpelayanan_id is null');
			$criteria->limit = 50;
			$criteria->order = 'tgl_pendaftaran DESC';
		} elseif ($this->idInstalasi != Params::INSTALASI_ID_LAB) {

			$criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
			if (!empty($this->tgl_pendaftaran_cari)) {
				$this->tgl_pendaftaran_cari = $format->formatDateTimeForDb($this->tgl_pendaftaran_cari);
				$criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_pendaftaran_cari . " 00:00:00", $this->tgl_pendaftaran_cari . " 23:59:59");
			}
			$criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
			$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
			$criteria->compare('instalasi_id', $this->idInstalasi);

			$criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
			$criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
			$criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
			$criteria->addCondition('pembayaranpelayanan_id is null');
			$criteria->limit = 50;
			$criteria->order = 'tgl_pendaftaran DESC';
		}
		//kembalikan format
		$this->tgl_pendaftaran_cari = empty($this->tgl_pendaftaran_cari) ? null : date('d M Y', strtotime($this->tgl_pendaftaran_cari));
		if ($this->idInstalasi == Params::INSTALASI_ID_RD) {
			$model = new KUInfokunjunganrdV;
		} else if ($this->idInstalasi == Params::INSTALASI_ID_RJ) {
			$model = new KUInfokunjunganrjV;
		} else if ($this->idInstalasi == Params::INSTALASI_ID_LAB) {
			$model = new KURinciantagihanpasienpenunjangV;
		} else {// if($this->idInstalasi == Params::INSTALASI_ID_RI)
			$model = new KUInfopasienmasukkamarV;
		}
		return new CActiveDataProvider($model, array(
			'criteria' => $criteria,
		));
	}

	public function searchTagihanPasien() {
		$format = new MyFormatter();
		$model = null;
		$criteria = new CDbCriteria();
		$criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
		if (!empty($this->tgl_pendaftaran_cari)) {
			$this->tgl_pendaftaran_cari = $format->formatDateTimeForDb($this->tgl_pendaftaran_cari);
			$criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_pendaftaran_cari . " 00:00:00", $this->tgl_pendaftaran_cari . " 23:59:59");
		}
		$criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
		$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
		$criteria->compare('instalasi_id', $this->idInstalasi);
//            $criteria->compare('LOWER(instalasi_nama)', strtolower($this->namaInstalasi), true);
		$criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
		$criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
		$criteria->limit = 50;
		$criteria->order = 'tgl_pendaftaran DESC';
		//kembalikan format
		$this->tgl_pendaftaran_cari = empty($this->tgl_pendaftaran_cari) ? null : date('d M Y', strtotime($this->tgl_pendaftaran_cari));
		if ($this->idInstalasi == Params::INSTALASI_ID_RD) {
			$criteria->addCondition('pembayaranpelayanan_id IS NULL');
			$model = new KUInfokunjunganrdV;
		} else if ($this->idInstalasi == Params::INSTALASI_ID_RJ) {
			$criteria->addCondition('pembayaranpelayanan_id IS NULL');
			$model = new KUInfokunjunganrjV;
		} else if ($this->idInstalasi == Params::INSTALASI_ID_LAB) {
			$model = new KURinciantagihanpasienpenunjangV;
		} else {
			$criteria->addCondition('pembayaranpelayanan_id IS NULL');
			$model = new KUInfopasienmasukkamarV; //default
		}
		return new CActiveDataProvider($model, array(
			'criteria' => $criteria,
		));
	}

	public function searchPasienVerifikasiMcu() {

		$format = new MyFormatter();
		$model = null;
		$criteria = new CDbCriteria();

		$criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
		if (!empty($this->tgl_pendaftaran_cari)) {
			$this->tgl_pendaftaran_cari = $format->formatDateTimeForDb($this->tgl_pendaftaran_cari);
			$criteria->addBetweenCondition('tgl_pendaftaran', $this->tgl_pendaftaran_cari . " 00:00:00", $this->tgl_pendaftaran_cari . " 23:59:59");
		}

		$criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);
		$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
		$criteria->compare('instalasi_id', $this->idInstalasi);
		$criteria->addCondition('ruangan_id = ' . Params::RUANGAN_ID_KLINIK_MCU);
		$criteria->addCondition('pendaftaran_id IN (' . $this->getArrayPendVerBerMcu() . ')');
		$criteria->compare('LOWER(instalasi_nama)', strtolower($this->instalasi_nama), true);
		$criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
		$criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
		$criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
		$criteria->addCondition('pembayaranpelayanan_id is null');
		$criteria->limit = 50;
		$criteria->order = 'tgl_pendaftaran DESC';

		//kembalikan format
		$this->tgl_pendaftaran_cari = empty($this->tgl_pendaftaran_cari) ? null : date('d M Y', strtotime($this->tgl_pendaftaran_cari));

		if ($this->idInstalasi == Params::INSTALASI_ID_RD) {
			$model = new KUInfokunjunganrdV;
		} else if ($this->idInstalasi == Params::INSTALASI_ID_RJ) {
			$model = new KUInfokunjunganrjV;
		} else if ($this->idInstalasi == Params::INSTALASI_ID_LAB) {
			$model = new KURinciantagihanpasienpenunjangV;
		} else {// if($this->idInstalasi == Params::INSTALASI_ID_RI)
			$model = new KUInfopasienmasukkamarV;
		}
		return new CActiveDataProvider($model, array(
			'criteria' => $criteria,
		));
	}

	public function getKabupatenItems($propinsi_id = null) {
		$criteria = new CDbCriteria();
		if (!empty($propinsi_id)) {
			$criteria->addCondition("propinsi_id = " . $propinsi_id);
		}
		$criteria->compare('kabupaten_aktif', true);
		$criteria->order = 'kabupaten_nama';
		$models = KabupatenM::model()->findAll($criteria);
		return $models;
	}

	public function getArrayPendVerBerMcu() {
		$criteria2 = new CDbCriteria();
		$stringPend = '';
		$separator = '';
		$criteria2->addCondition('tglverifikasiberkasmcu IS NULL');
		$modVerBerMCUs = KUVerifikasiberkasmcuV::model()->findAll($criteria2);
		if (count((array)$modVerBerMCUs) > 0) {
			foreach ($modVerBerMCUs as $key => $modVerBerMCU) {
				if (($key + 1) != count((array)$modVerBerMCUs)) {
					$separator = ',';
				} else {
					$separator = '';
				}
				$stringPend .= $modVerBerMCU->pendaftaran_id . $separator;
			}
		}
		if (empty($stringPend)) {
			return $stringPend = 0;
		} else {
			return $stringPend;
		}
	}

}
