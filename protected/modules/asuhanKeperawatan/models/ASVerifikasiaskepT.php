<?php

/**
 * Model extend untuk verifikasiaskep_t
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.asuhanKeperawatan
 * @subpackage models
 * @category model
 */
class ASVerifikasiaskepT extends VerifikasiaskepT {

    public $instalasi_id;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return VerifikasiaskepT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'verifikasiaskep_id' => 'Verifikasiaskep',
            'pegawai_id' => 'Pegawai',
            'ruangan_id' => 'Ruangan',
            'verifikasiaskep_tgl' => 'Tgl. Verifikasi',
            'verifikasiaskep_no' => 'No Verifikasi',
            'verifikasiaskep_ket' => 'Keterangan',
            'petugasverifikasi_nama' => 'Petugas Verifikasi',
            'mengetahui_nama' => 'Mengetahui',
            'create_time' => 'Waktu Create',
            'update_time' => 'Waktu Update',
            'create_loginpemakai_id' => 'Create Login Pemakai',
            'update_loginpemakai_id' => 'Update Login Pemakai',
            'create_ruangan' => 'Create Ruangan',
            'verifikasiaskep_status' => 'Status',
            'pendaftaran_id' => 'Pendaftaran',
            'pengkajianaskep_id' => 'Pengkajianaskep',
            'rencanaaskep_id' => 'Rencanaaskep',
            'implementasiaskep_t' => 'Implementasiaskep T',
            'evaluasiaskep_t' => 'Evaluasiaskep T',
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

        $criteria->compare('verifikasiaskep_id', $this->verifikasiaskep_id);
        $criteria->compare('pegawai_id', $this->pegawai_id);
        $criteria->compare('ruangan_id', $this->ruangan_id);
        $criteria->compare('verifikasiaskep_tgl', $this->verifikasiaskep_tgl, true);
        $criteria->compare('verifikasiaskep_no', $this->verifikasiaskep_no, true);
        $criteria->compare('verifikasiaskep_ket', $this->verifikasiaskep_ket, true);
        $criteria->compare('petugasverifikasi_nama', $this->petugasverifikasi_nama, true);
        $criteria->compare('mengetahui_nama', $this->mengetahui_nama, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id, true);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id, true);
        $criteria->compare('create_ruangan', $this->create_ruangan, true);
        $criteria->compare('verifikasiaskep_status', $this->verifikasiaskep_status, true);
        $criteria->compare('pendaftaran_id', $this->pendaftaran_id);
        $criteria->compare('pengkajianaskep_id', $this->pengkajianaskep_id);
        $criteria->compare('rencanaaskep_id', $this->rencanaaskep_id);
        $criteria->compare('implementasiaskep_t', $this->implementasiaskep_t);
        $criteria->compare('evaluasiaskep_t', $this->evaluasiaskep_t);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchPrint($verifikasiaskep_id) {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->addCondition('verifikasiaskep_id =' . $verifikasiaskep_id);
//		$criteria->compare('pegawai_id',$this->pegawai_id);
//		$criteria->compare('ruangan_id',$this->ruangan_id);
//		$criteria->compare('verifikasiaskep_tgl',$this->verifikasiaskep_tgl,true);
//		$criteria->compare('verifikasiaskep_no',$this->verifikasiaskep_no,true);
//		$criteria->compare('verifikasiaskep_ket',$this->verifikasiaskep_ket,true);
//		$criteria->compare('petugasverifikasi_nama',$this->petugasverifikasi_nama,true);
//		$criteria->compare('mengetahui_nama',$this->mengetahui_nama,true);
//		$criteria->compare('create_time',$this->create_time,true);
//		$criteria->compare('update_time',$this->update_time,true);
//		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id,true);
//		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id,true);
//		$criteria->compare('create_ruangan',$this->create_ruangan,true);
//		$criteria->compare('verifikasiaskep_status',$this->verifikasiaskep_status,true);
//		$criteria->compare('pendaftaran_id',$this->pendaftaran_id);
//		$criteria->compare('pengkajianaskep_id',$this->pengkajianaskep_id);
//		$criteria->compare('rencanaaskep_id',$this->rencanaaskep_id);
//		$criteria->compare('implementasiaskep_t',$this->implementasiaskep_t);
//		$criteria->compare('evaluasiaskep_t',$this->evaluasiaskep_t);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Get data nomor kamar
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
     * Get data nomor kasur
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
     * get data kelas pelayanan pasien
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
     * Get data diagnosa pasien
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
     * Get nama dokter pasien
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

    /**
     * Get data instalasi
     * @return type
     */
    public function getInstalasiItems() {
        $values = array(Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_RD, Params::INSTALASI_ID_RI);
        $criteria = new CDbCriteria();
        $criteria->addInCondition('instalasi_id', $values);
        $criteria->addCondition('instalasi_aktif IS TRUE');
        $criteria->order = 'instalasi_nama ASC';
        return InstalasiM::model()->findAll($criteria);
    }

    /**
     * Get data ruangan berdasarkan instalasi
     * @param type $instalasi_id
     * @return type
     */
    public function getRuanganItems($instalasi_id = null) {
        $criteria = new CDbCriteria();
        if (!empty($instalasi_id)) {
            $criteria->addCondition("instalasi_id = " . $instalasi_id);
        }
        $criteria->addCondition('ruangan_aktif = true');
        $criteria->order = "ruangan_nama";
        return RuanganM::model()->findAll($criteria);
    }

}
