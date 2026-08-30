<?php

class PPInfopasienbatalperiksaV extends InfopasienbatalperiksaV {

	public $tgl_awal, $tgl_akhir;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return InfopasienbatalperiksaV the static model class
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	public function searchInformasiBatalPeriksaPasien() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;
		
		$criteria->addBetweenCondition('DATE(tgl_pendaftaran)', $this->tgl_awal, $this->tgl_akhir, true);
		
		if (!empty($this->pasien_id)) {
			$criteria->addCondition("pasien_id = " . $this->pasien_id);
		}

		$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
		$criteria->compare('LOWER(nama_bin)', strtolower($this->nama_bin), true);

		$criteria->compare('LOWER(no_rekam_medik)', strtolower($this->no_rekam_medik), true);

		$criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran), true);
		if (!empty($this->carabayar_id)) {
			$criteria->addCondition("carabayar_id = " . $this->carabayar_id);
		}
		$criteria->compare('LOWER(carabayar_nama)', strtolower($this->carabayar_nama), true);
		if (!empty($this->penjamin_id)) {
			$criteria->addCondition("penjamin_id = " . $this->penjamin_id);
		}
		$criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);
		if (!empty($this->jeniskasuspenyakit_id)) {
			$criteria->addCondition("jeniskasuspenyakit_id = " . $this->jeniskasuspenyakit_id);
		}
		$criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($this->jeniskasuspenyakit_nama), true);

		$criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
		if (!empty($this->pasienbatalperiksa_id)) {
			$criteria->addCondition("pasienbatalperiksa_id = " . $this->pasienbatalperiksa_id);
		}
		$criteria->compare('LOWER(tglbatal)', strtolower($this->tglbatal), true);
		$criteria->compare('LOWER(keterangan_batal)', strtolower($this->keterangan_batal), true);
		$criteria->compare('LOWER(nama_pemakai)', strtolower($this->nama_pemakai), true);
		if (!empty($this->ruangan_id)) {
			$criteria->addCondition("ruangan_id = " . $this->ruangan_id);
		}
		if (!empty($this->instalasi)) {
			$criteria->addCondition("instalasi = " . $this->instalasi);
		}
		
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

}
