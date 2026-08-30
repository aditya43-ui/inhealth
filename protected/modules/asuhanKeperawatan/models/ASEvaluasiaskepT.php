<?php
class ASEvaluasiaskepT extends EvaluasiaskepT
{
	public $nama_pegawai,$no_pengkajian,$ruangan_nama;
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'evaluasiaskep_id' => 'ID',
			'pegawai_id' => 'Pegawai',
			'implementasiaskep_id' => 'Implementasi Askep',
			'ruangan_id' => 'Ruangan',
			'no_evaluasi' => 'No. Evaluasi',
			'evaluasiaskep_tgl' => 'Tgl. Evaluasi',
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
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->with = array('pegawai','implementasiaskep');
		$criteria->compare('evaluasiaskep_id',$this->evaluasiaskep_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('implementasiaskep_id',$this->implementasiaskep_id);
		$criteria->compare('ruangan_id',$this->ruangan_id);
		$criteria->compare('no_evaluasi',$this->no_evaluasi,true);
		$criteria->compare('evaluasiaskep_tgl',$this->evaluasiaskep_tgl,true);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
		$criteria->compare('create_ruangan',$this->create_ruangan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
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
			if (!empty($kamar)) {
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
			if (!empty($kamar)) {
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
			if (!empty($kelas)) {
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
			if (!empty($diagnosa)) {
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
		if (!empty($dokter)) {
			$nama = (isset($dokter->gelardepan) ? $dokter->gelardepan : "") . (isset($dokter->nama_pegawai) ? $dokter->nama_pegawai : "") . (isset($dokter->gelarbelakang_nama) ? $dokter->gelarbelakang_nama : "");
		}
		return $nama;
	}
}