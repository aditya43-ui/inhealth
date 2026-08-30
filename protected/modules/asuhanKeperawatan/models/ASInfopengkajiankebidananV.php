<?php

class ASInfopengkajiankebidananV extends InfopengkajiankebidananV {

	public $tgl_awal, $tgl_akhir, $instalasi_id;

	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('pengkajianaskep_id', $this->pengkajianaskep_id);
		$criteria->addBetweenCondition('DATE(pengkajianaskep_tgl)', $this->tgl_awal, $this->tgl_akhir);
		$criteria->compare('pendaftaran_id', $this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran),true);
		$criteria->compare('pasien_id', $this->pasien_id);
		$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
		$criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
		$criteria->compare('pegawai_id', $this->pegawai_id);
		if(!empty($this->nama_pegawai)){
			$criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
		}
		$criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
		$criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
		$criteria->compare('LOWER(no_pengkajian)',strtolower($this->no_pengkajian),true);
		$criteria->compare('anamesa_id',$this->anamesa_id);
		$criteria->compare('pemeriksaanfisik_id',$this->pemeriksaanfisik_id);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id ='.$this->ruangan_id);
		}
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchInformasi() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('pengkajianaskep_id', $this->pengkajianaskep_id);
		$criteria->compare('pendaftaran_id', $this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran),true);
		$criteria->compare('pasien_id', $this->pasien_id);
		$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
		$criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
		$criteria->compare('pegawai_id', $this->pegawai_id);
		if(!empty($this->pengkajianaskep_tgl)){
			$criteria->addCondition("DATE(pengkajianaskep_tgl) = '" . $this->pengkajianaskep_tgl . "'");
		}
		if(!empty($this->nama_pegawai)){
			$criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
		}
		$criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
		$criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
		$criteria->compare('LOWER(no_pengkajian)',strtolower($this->no_pengkajian),true);
		$criteria->compare('anamesa_id',$this->anamesa_id);
		$criteria->compare('pemeriksaanfisik_id',$this->pemeriksaanfisik_id);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id ='.$this->ruangan_id);
		}
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchDialog() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;
		
		$criteria->compare('pengkajianaskep_id', $this->pengkajianaskep_id);
		$criteria->compare('pendaftaran_id', $this->pendaftaran_id);
		$criteria->compare('LOWER(no_pendaftaran)', strtolower($this->no_pendaftaran),true);
		$criteria->compare('pasien_id', $this->pasien_id);
		$criteria->compare('LOWER(nama_pasien)', strtolower($this->nama_pasien), true);
		$criteria->compare('LOWER(jeniskelamin)', strtolower($this->jeniskelamin), true);
		$criteria->compare('pegawai_id', $this->pegawai_id);
		if(!empty($this->pengkajianaskep_tgl)){
                    $pengkajianaskep_tgl = $this->getKonverviDateRange($this->pengkajianaskep_tgl);
                    $criteria->addBetweenCondition('DATE(pengkajianaskep_tgl)', $pengkajianaskep_tgl[0]." 00:00:00", $pengkajianaskep_tgl[1]." 23:59:59");
//			$criteria->addCondition("DATE(pengkajianaskep_tgl) = '" . MyFormatter::formatDateTimeForDb($this->pengkajianaskep_tgl) . "'");
		}
		if(!empty($this->nama_pegawai)){
			$criteria->compare('LOWER(nama_pegawai)', strtolower($this->nama_pegawai), true);
		}
		$criteria->compare('LOWER(ruangan_nama)', strtolower($this->ruangan_nama), true);
		$criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($this->kelaspelayanan_nama), true);
		$criteria->compare('LOWER(no_pengkajian)',strtolower($this->no_pengkajian),true);
		$criteria->compare('anamesa_id',$this->anamesa_id);
		$criteria->compare('pemeriksaanfisik_id',$this->pemeriksaanfisik_id);
		if(!empty($this->ruangan_id)){
			$criteria->addCondition('ruangan_id ='.$this->ruangan_id);
		}
		$criteria->compare('kelaspelayanan_id',$this->kelaspelayanan_id);
		$criteria->limit = 5;
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
		));
	}
	
	public function getNoKamar($pendaftaran_id) {
		$no_kamar = '-';
		if (!empty($pendaftaran_id)) {
			$kamar = KamarruanganM::model()->findBySql('
			SELECT kamarruangan_m.kamarruangan_nokamar
			FROM kamarruangan_m
			JOIN masukkamar_t ON kamarruangan_m.kamarruangan_id = masukkamar_t.kamarruangan_id
			JOIN pasienadmisi_t ON pasienadmisi_t.pasienadmisi_id = masukkamar_t.pasienadmisi_id
			JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = pasienadmisi_t.pendaftaran_id
			WHERE pendaftaran_t.pendaftaran_id = ' . $pendaftaran_id);
			if (count($kamar)) {
				$no_kamar = $kamar->kamarruangan_nokamar;
			}
		}
		return $no_kamar;
	}

	public function getNoBed($pendaftaran_id) {
		
		$no_bed = '-';
		if (!empty($pendaftaran_id)) {
			$kamar = KamarruanganM::model()->findBySql('
			SELECT kamarruangan_m.kamarruangan_nobed
			FROM kamarruangan_m
			JOIN masukkamar_t ON kamarruangan_m.kamarruangan_id = masukkamar_t.kamarruangan_id
			JOIN pasienadmisi_t ON pasienadmisi_t.pasienadmisi_id = masukkamar_t.pasienadmisi_id
			JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = pasienadmisi_t.pendaftaran_id
			WHERE pendaftaran_t.pendaftaran_id = ' . $pendaftaran_id);
			if (count($kamar)) {
				$no_bed = $kamar->kamarruangan_nobed;
			}
		}
		return $pendaftaran_id;
	}

	public function getKelasPelayanan($pendaftaran_id) {

		$pelayanan = '-';
		if (!empty($pendaftaran_id)) {
			$kelas = KelaspelayananM::model()->findBySql('
			SELECT kelaspelayanan_m.kelaspelayanan_nama
			FROM kelaspelayanan_m
			JOIN masukkamar_t ON kelaspelayanan_m.kelaspelayanan_id = masukkamar_t.kelaspelayanan_id
			JOIN pasienadmisi_t ON pasienadmisi_t.pasienadmisi_id = masukkamar_t.pasienadmisi_id
			JOIN pendaftaran_t ON pendaftaran_t.pendaftaran_id = pasienadmisi_t.pendaftaran_id
			WHERE pendaftaran_t.pendaftaran_id = ' . $pendaftaran_id);
			if (count($kelas)) {
				$pelayanan = $kelas->kelaspelayanan_nama;
			}
		}

		return $pelayanan;
	}

	public function getDiagnosaMedis($pasien_id, $pendaftaran_id) {
		$nama = '-';

		if (!empty($pasien_id) && !empty($pendaftaran_id)) {
			$diagnosa = ASDiagnosaM::model()->findBySql('
			SELECT diagnosa_m.diagnosa_nama
			FROM diagnosa_m
			JOIN pasienmorbiditas_t ON pasienmorbiditas_t.diagnosa_id = diagnosa_m.diagnosa_id
			WHERE pasienmorbiditas_t.pasien_id = ' . $pasien_id . ' AND pendaftaran_id =' . $pendaftaran_id);
			if (count($diagnosa)) {
				$nama = $diagnosa->diagnosa_nama;
			}
		}
		return $nama;
	}

	public function getNamaDokter($pendaftaran_id) {
		$nama = '-';
		$dokter = ASPegawaiM::model()->findBySql('
			SELECT pegawai_m.nama_pegawai,pegawai_m.gelardepan,gelarbelakang_m.gelarbelakang_nama
			FROM pendaftaran_t 
			JOIN pegawai_m ON pegawai_m.pegawai_id = pendaftaran_t.pegawai_id
			LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
			WHERE pendaftaran_id =' . $pendaftaran_id);
		if (count($dokter)) {
			$nama = (isset($dokter->gelardepan) ? $dokter->gelardepan : "") . (isset($dokter->nama_pegawai) ? $dokter->nama_pegawai : "") . (isset($dokter->gelarbelakang_nama) ? $dokter->gelarbelakang_nama : "");
		}
		return $nama;
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
}
