<?php

/**
 * Model extend untuk diagnosisaskep_t
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.asuhanKeperawatan
 * @subpackage models
 * @category model
 */
class ASDiagnosisaskepT extends DiagnosisaskepT {

    public $nama_pegawai, $no_pengkajian, $ruangan_nama, $nama_pasien, $diagnosisaskep_nama, $iskeperawatan;
    public $tgl_awal, $tgl_akhir, $no_pendaftaran, $jeniskelamin, $kelaspelayanan_nama, $instalasi_id;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return DiagnosisaskepT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'diagnosisaskep_id' => 'Diagnosisaskep',
            'pengkajianaskep_id' => 'Pengkajianaskep',
            'pegawai_id' => 'Pegawai',
            'ruangan_id' => 'Ruangan',
            'no_diagnosisaskep' => 'Data Penegakan Diagnosis',
            'diagnosisaskep_tgl' => 'Tanggal Penegakan',
            'create_time' => 'Waktu Create',
            'update_time' => 'Waktu Update',
            'create_loginpemakai_id' => 'Create Login Pemakai',
            'update_loginpemakai_id' => 'Update Login Pemakai',
            'create_ruangan_id' => 'Create Ruangan',
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
        $criteria->with = array('pegawai', 'pengkajianaskep');
        $criteria->compare('diagnosisaskep_id', $this->diagnosisaskep_id);
        $criteria->compare('pengkajianaskep_id', $this->pengkajianaskep_id);
        $criteria->compare('pegawai_id', $this->pegawai_id);
        $criteria->compare('ruangan_id', $this->ruangan_id);
        $criteria->compare('no_diagnosisaskep', $this->no_diagnosisaskep, true);
        $criteria->compare('diagnosisaskep_tgl', $this->diagnosisaskep_tgl, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id, true);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id, true);
        $criteria->compare('create_ruangan_id', $this->create_ruangan_id, true);

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
        $criteria->with = array('pegawai', 'pengkajianaskep');
        $criteria->compare('diagnosisaskep_id', $this->diagnosisaskep_id);
        $criteria->compare('pengkajianaskep_id', $this->pengkajianaskep_id);
        $criteria->compare('pegawai_id', $this->pegawai_id);
        $criteria->compare('t.ruangan_id', $this->ruangan_id);
        $criteria->compare('LOWER(no_diagnosisaskep)', strtolower($this->no_diagnosisaskep), true);
        $criteria->compare('LOWER(pengkajianaskep.no_pengkajian)', strtolower($this->no_pengkajian), true);
        $criteria->compare('LOWER(pegawai.nama_pegawai)', strtolower($this->nama_pegawai), true);

        if (!empty($this->diagnosisaskep_tgl)) {
            $criteria->addCondition("DATE(diagnosisaskep_tgl) = '" . MyFormatter::formatDateTimeForDb($this->diagnosisaskep_tgl) . "'");
        }
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('create_loginpemakai_id', $this->create_loginpemakai_id, true);
        $criteria->compare('update_loginpemakai_id', $this->update_loginpemakai_id, true);
        $criteria->compare('create_ruangan_id', $this->create_ruangan_id, true);
        $criteria->limit = 5;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false
        ));
    }

    /**
     * kriteria pencarian untuk dashboard
     * @return \CActiveDataProvider
     */
    public function searchDashboard() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('DATE(diagnosisaskep_tgl)', date("Y-m-d"));
        $criteria->order = 'diagnosisaskep_tgl ASC';
        $criteria->limit = 10;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false
        ));
    }

    /**
     * Search dashboard RS
     * @return \CActiveDataProvider
     */
    public function searchDashboardAS() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select = 't.no_diagnosisaskep,t.diagnosisaskep_tgl, pasien.nama_pasien, diagnosisaskep.diagnosisaskep_nama';
        $criteria->join = 'JOIN diagnosisaskepdet_t AS diagnosisaskepdet ON diagnosisaskepdet.diagnosisaskep_id= t.diagnosisaskep_id
								JOIN diagnosisaskep_m AS diagnosisaskep ON diagnosisaskep.diagnosisaskep_id = diagnosisaskepdet.diagnosisaskep_id
								JOIN pengkajianaskep_t AS pengkajianaskep ON pengkajianaskep.pengkajianaskep_id = t.pengkajianaskep_id
								JOIN pendaftaran_t AS pendaftaran ON pendaftaran.pendaftaran_id = pengkajianaskep.pendaftaran_id
								JOIN pasien_m AS pasien ON pasien.pasien_id = pendaftaran.pasien_id';
        $criteria->group = 'diagnosisaskep.diagnosisaskep_nama,pasien.nama_pasien,no_diagnosisaskep,t.diagnosisaskep_tgl';
        $criteria->order = 't.diagnosisaskep_tgl desc';
        $criteria->limit = 10;
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false
        ));
    }

    /**
     * Load nomor kamar
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
     * Load nomor bed
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
     * Load kelas pelayanan
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
     * Load diagnosa medis
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
     * Load nama dokter
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
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchInformasi() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->select = 't.*, pendaftaran_t.no_pendaftaran, ruangan_m.ruangan_nama, kelaspelayanan_m.kelaspelayanan_nama, pasien_m.nama_pasien, pasien_m.jeniskelamin, pegawai_m.nama_pegawai';
        $criteria->join = ' LEFT JOIN pengkajianaskep_t ON t.pengkajianaskep_id = pengkajianaskep_t.pengkajianaskep_id
                            LEFT JOIN pendaftaran_t ON pengkajianaskep_t.pendaftaran_id = pendaftaran_t.pendaftaran_id
                            LEFT JOIN pasien_m ON pendaftaran_t.pasien_id = pasien_m.pasien_id
                            LEFT JOIN penanggungjawab_m ON pendaftaran_t.penanggungjawab_id = penanggungjawab_m.penanggungjawab_id
                            LEFT JOIN pasienadmisi_t ON pendaftaran_t.pendaftaran_id = pasienadmisi_t.pendaftaran_id AND pendaftaran_t.pasienadmisi_id = pasienadmisi_t.pasienadmisi_id
                            LEFT JOIN ruangan_m ON ruangan_m.ruangan_id = pasienadmisi_t.ruangan_id
                            LEFT JOIN instalasi_m ON ruangan_m.instalasi_id = instalasi_m.instalasi_id
                            LEFT JOIN masukkamar_t ON pasienadmisi_t.pasienadmisi_id = masukkamar_t.pasienadmisi_id AND masukkamar_t.ruangan_id = ruangan_m.ruangan_id
                            LEFT JOIN kamarruangan_m ON masukkamar_t.kamarruangan_id = kamarruangan_m.kamarruangan_id
                            LEFT JOIN kelaspelayanan_m ON masukkamar_t.kelaspelayanan_id = kelaspelayanan_m.kelaspelayanan_id
                            LEFT JOIN pegawai_m ON t.pegawai_id = pegawai_m.pegawai_id';
        $criteria->addBetweenCondition('DATE(diagnosisaskep_tgl)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(pegawai_m.nama_pegawai)', strtolower($this->nama_pegawai), true);
        $criteria->compare('LOWER(t.no_diagnosisaskep)', strtolower($this->no_diagnosisaskep), true);
        $criteria->compare('ruangan_m.ruangan_id', $this->ruangan_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => [
                'defaultOrder' => 'diagnosisaskep_tgl DESC'
            ]
        ));
    }

    /**
     * Get data instalasi
     * @return type
     */
    public function getInstalasiItems() {
        return InstalasiM::model()->findAll('instalasi_aktif=TRUE  ORDER BY instalasi_nama');
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
