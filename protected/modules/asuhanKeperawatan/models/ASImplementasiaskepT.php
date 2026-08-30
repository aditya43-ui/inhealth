<?php
/**
 * model yang digunakan untuk mengakses tabel implementasiaskep_t, pada modul asuhan keperawatan
 * 
 * @package application.modules.asuhanKeperawatan
 * @subpackage models
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     1.0.0
 * @link    <http://piindonesia.co.id>
 */
class ASImplementasiaskepT extends ImplementasiaskepT {

	public $nama_pegawai, $no_pengkajian, $ruangan_nama, $no_rencana, $no_pendaftaran;
        public $implementasikeperawatan_id;

	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'implementasiaskep_id' => 'ID',
			'ruangan_id' => 'Ruangan',
			'rencanaaskep_id' => 'Rencana Askep',
			'pegawai_id' => 'Pegawai',
			'no_implementasi' => 'No. Implementasi',
			'implementasiaskep_tgl' => 'Tgl. Implementasi',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = new CDbCriteria;
		$criteria->with = array('pegawai', 'rencanaaskep');
		$criteria->compare('implementasiaskep_id', $this->implementasiaskep_id);
		$criteria->compare('ruangan_id', $this->ruangan_id);
		$criteria->compare('rencanaaskep_id', $this->rencanaaskep_id);
		$criteria->compare('pegawai_id', $this->pegawai_id);
		$criteria->compare('no_implementasi', $this->no_implementasi, true);
		$criteria->compare('implementasiaskep_tgl', $this->implementasiaskep_tgl, true);
		$criteria->compare('create_time', $this->create_time, true);
		$criteria->compare('update_time', $this->update_time, true);
		$criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id, true);
		$criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id, true);
		$criteria->compare('create_ruangan', $this->create_ruangan, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
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
		$criteria->with = array('pegawai', 'rencanaaskep');
		$criteria->compare('implementasiaskep_id', $this->implementasiaskep_id);
		$criteria->compare('t.ruangan_id', $this->ruangan_id);
		$criteria->compare('rencanaaskep_id', $this->rencanaaskep_id);
		$criteria->compare('pegawai_id', $this->pegawai_id);
		$criteria->compare('LOWER(pegawai.nama_pegawai)', strtolower($this->nama_pegawai), true);
		$criteria->compare('LOWER(no_implementasi)', strtolower($this->no_implementasi), true);
		$criteria->compare('LOWER(rencanaaskep.no_rencana)', strtolower($this->no_rencana), true);
		if (!empty($this->implementasiaskep_tgl)) {
			$criteria->addCondition("DATE(implementasiaskep_tgl) = '" . MyFormatter::formatDateTimeForDb($this->implementasiaskep_tgl) . "'");
		}
		$criteria->compare('create_time', $this->create_time, true);
		$criteria->compare('update_time', $this->update_time, true);
		$criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id, true);
		$criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id, true);
		$criteria->compare('create_ruangan', $this->create_ruangan, true);
		$criteria->limit = 5;
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'pagination' => false
		));
	}

        /**
         * load data no kamar
         * @param type $pendaftaran_id
         * @return type
         */
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
			if (!empty($kamar)) {
				$no_kamar = $kamar->kamarruangan_nokamar;
			}
		}
		return $no_kamar;
	}

        /**
         * load no bed
         * @param type $pendaftaran_id
         * @return type
         */
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
			if (!empty($kamar)) {
				$no_bed = $kamar->kamarruangan_nobed;
			}
		}
		return $pendaftaran_id;
	}

        /**
         * load kelas pelayanan
         * @param type $pendaftaran_id
         * @return type
         */
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
			if (!empty($kelas)) {
				$pelayanan = $kelas->kelaspelayanan_nama;
			}
		}

		return $pelayanan;
	}

        /**
         * load diagnosa medis
         * @param type $pasien_id
         * @param type $pendaftaran_id
         * @return type
         */
	public function getDiagnosaMedis($pasien_id, $pendaftaran_id) {
		$nama = '-';

		if (!empty($pasien_id) && !empty($pendaftaran_id)) {
			$diagnosa = ASDiagnosaM::model()->findBySql('
			SELECT diagnosa_m.diagnosa_nama
			FROM diagnosa_m
			JOIN pasienmorbiditas_t ON pasienmorbiditas_t.diagnosa_id = diagnosa_m.diagnosa_id
			WHERE pasienmorbiditas_t.pasien_id = ' . $pasien_id . ' AND pendaftaran_id =' . $pendaftaran_id);
			if (!empty($diagnosa)) {
				$nama = $diagnosa->diagnosa_nama;
			}
		}
		return $nama;
	}

        /**
         * load nama dokter
         * @param type $pendaftaran_id
         * @return string
         */
	public function getNamaDokter($pendaftaran_id) {
		$nama = '-';
		$dokter = ASPegawaiM::model()->findBySql('
			SELECT pegawai_m.nama_pegawai,pegawai_m.gelardepan,gelarbelakang_m.gelarbelakang_nama
			FROM pendaftaran_t 
			JOIN pegawai_m ON pegawai_m.pegawai_id = pendaftaran_t.pegawai_id
			LEFT JOIN gelarbelakang_m ON gelarbelakang_m.gelarbelakang_id = pegawai_m.gelarbelakang_id
			WHERE pendaftaran_id =' . $pendaftaran_id);
		if (!empty($dokter)) {
			$nama = (isset($dokter->gelardepan) ? $dokter->gelardepan : "") . (isset($dokter->nama_pegawai) ? $dokter->nama_pegawai : "") . (isset($dokter->gelarbelakang_nama) ? $dokter->gelarbelakang_nama : "");
		}
		return $nama;
	}
        
        

}
