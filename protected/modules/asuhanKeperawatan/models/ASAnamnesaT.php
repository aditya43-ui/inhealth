<?php

class ASAnamnesaT extends AnamnesaT {

	public $isanamesa,$nama_pasien,$jeniskelamin,$gelar_depan,$gelar_belakang,$nama_pegawai
			,$umur,$nama_paramedis,$tgl_pendaftaran,$kelaspelayanan_nama,$no_pendaftaran;

	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CdbCriteria that can return criterias.
	 */
	public function criteriaSearch() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		if (!empty($this->anamesa_id)) {
			$criteria->addCondition('anamesa_id = ' . $this->anamesa_id);
		}
		if (!empty($this->pendaftaran_id)) {
			$criteria->addCondition('pendaftaran_id = ' . $this->pendaftaran_id);
		}
		if (!empty($this->pasien_id)) {
			$criteria->addCondition('pasien_id = ' . $this->pasien_id);
		}
		if (!empty($this->triase_id)) {
			$criteria->addCondition('triase_id = ' . $this->triase_id);
		}
		if (!empty($this->pasienadmisi_id)) {
			$criteria->addCondition('pasienadmisi_id = ' . $this->pasienadmisi_id);
		}
		if (!empty($this->pegawai_id)) {
			$criteria->addCondition('pegawai_id = ' . $this->pegawai_id);
		}


		$criteria->compare('LOWER(tglanamnesis)', strtolower($this->tglanamnesis), true);
		$criteria->compare('LOWER(keluhanutama)', strtolower($this->keluhanutama), true);
		$criteria->compare('LOWER(keluhantambahan)', strtolower($this->keluhantambahan), true);
		$criteria->compare('LOWER(riwayatpenyakitterdahulu)', strtolower($this->riwayatpenyakitterdahulu), true);
		$criteria->compare('LOWER(riwayatpenyakitkeluarga)', strtolower($this->riwayatpenyakitkeluarga), true);
		$criteria->compare('LOWER(lamasakit)', strtolower($this->lamasakit), true);
		$criteria->compare('LOWER(pengobatanygsudahdilakukan)', strtolower($this->pengobatanygsudahdilakukan), true);
		$criteria->compare('LOWER(riwayatalergiobat)', strtolower($this->riwayatalergiobat), true);
		$criteria->compare('LOWER(riwayatkelahiran)', strtolower($this->riwayatkelahiran), true);
		$criteria->compare('LOWER(riwayatmakanan)', strtolower($this->riwayatmakanan), true);
		$criteria->compare('LOWER(riwayatimunisasi)', strtolower($this->riwayatimunisasi), true);
		$criteria->compare('LOWER(paramedis_nama)', strtolower($this->paramedis_nama), true);
		$criteria->compare('LOWER(keterangananamesa)', strtolower($this->keterangananamesa), true);
		$criteria->compare('LOWER(create_time)', strtolower($this->create_time), true);
		$criteria->compare('LOWER(update_time)', strtolower($this->update_time), true);
		$criteria->compare('LOWER(create_loginpemakai_id)', strtolower($this->create_loginpemakai_id), true);
		$criteria->compare('LOWER(update_loginpemakai_id)', strtolower($this->update_loginpemakai_id), true);
		$criteria->compare('LOWER(create_ruangan)', strtolower($this->create_ruangan), true);
		$criteria->compare('LOWER(riwayatperjalananpasien)', strtolower($this->riwayatperjalananpasien), true);
		if (!empty($this->petugas_triase_id)) {
			$criteria->addCondition('petugas_triase_id = ' . $this->petugas_triase_id);
		}
		$criteria->compare('statusmerokok', $this->statusmerokok);
		if (!empty($this->jmlrokok_btg_hr)) {
			$criteria->addCondition('jmlrokok_btg_hr = ' . $this->jmlrokok_btg_hr);
		}
		$criteria->compare('LOWER(riwayatimunisasiblm)', strtolower($this->riwayatimunisasiblm), true);
		$criteria->compare('LOWER(riwayatobatygsering)', strtolower($this->riwayatobatygsering), true);
		$criteria->compare('LOWER(keb_olahraga)', strtolower($this->keb_olahraga), true);
		$criteria->compare('LOWER(keb_jnsolahraga)', strtolower($this->keb_jnsolahraga), true);
		if (!empty($this->keb_frekuensi_kaliminggu)) {
			$criteria->addCondition('keb_frekuensi_kaliminggu = ' . $this->keb_frekuensi_kaliminggu);
		}
		$criteria->compare('LOWER(keb_konsumsialkohol)', strtolower($this->keb_konsumsialkohol), true);
		$criteria->compare('LOWER(keb_minumkopi)', strtolower($this->keb_minumkopi), true);
		$criteria->compare('LOWER(riwayat_kecelakaan)', strtolower($this->riwayat_kecelakaan), true);
		$criteria->compare('LOWER(riwayat_operasi)', strtolower($this->riwayat_operasi), true);
//        $criteria->compare('LOWER(konsumsi_drug)',strtolower($this->konsumsi_drug),true);

		return $criteria;
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = $this->criteriaSearch();
		$criteria->limit = 10;

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	public function searchPrint() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = $this->criteriaSearch();
		$criteria->limit = -1;

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => false,
		));
	}

	public function searchRiwayat() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CdbCriteria();
		if (!empty($this->pasien_id)) {
			$criteria->addCondition('pasien_id = ' . $this->pasien_id);
		}
		$criteria->limit = 10;

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	public function getNamaDokter() {
		return (!empty($this->gelardepan) ? $this->gelardepan : "") . " " . (!empty($this->nama_pegawai) ? $this->nama_pegawai : "") . " " . (!empty($this->gelarbelakang_nama) ? $this->gelarbelakang_nama : "");
	}

}
