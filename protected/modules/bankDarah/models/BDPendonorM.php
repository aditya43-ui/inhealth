<?php

/**
 * Model untuk pendonor_m hanya untuk modul bank darah
 * @author  Elham Budianto <elhambudianto1@gmail.com>
 * @author Andyka <andykaputra@.com>
 * @package application.modules.bankDarah
 * @subpackage models
 */
class BDPendonorM extends PendonorM {

    public $no_formulir;
    public $umur;
    public $gagal;
    public $pegawai_nama, $pekerjaan_nama, $waktu_observasi;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return BDPendonorM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /*
     * Load data dialog
     */
    public function searchDialog() {
        $criteria = $this->criteriaSearch();
        $criteria->limit = 10;

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Load data informasi Daftar Pendonor
     * @return \CActiveDataProvider
     */
    public function searchInformasi() {
        $criteria = new CDbCriteria;
        $criteria->addBetweenCondition('DATE(tgl_donor_terakhir)', $this->tgl_awal, $this->tgl_akhir);

        $criteria->compare('LOWER(no_identitas)', strtolower($this->no_identitas), true);
        $criteria->compare('LOWER(nama_lengkap)', strtolower($this->nama_lengkap), true);
        $criteria->compare('LOWER(gol_darah)', strtolower($this->gol_darah), true);
        $criteria->compare('LOWER(rhesus)', strtolower($this->rhesus), true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Load data Informasi Pendonor
     * @return \CActiveDataProvider
     */
    public function searchInformasiPendonor() {
        $criteria = new CDbCriteria;
//        $criteria->addBetweenCondition('DATE(create_time)', $this->tgl_awal, $this->tgl_akhir);
        $criteria->compare('LOWER(no_pendonor)', strtolower($this->no_pendonor), true);
        $criteria->compare('LOWER(nama_lengkap)', strtolower($this->nama_lengkap), true);
        $criteria->compare('LOWER(gol_darah)', strtolower($this->gol_darah), true);
        $criteria->compare('LOWER(rhesus)', strtolower($this->rhesus), true);
        $criteria->compare('LOWER(jenis_kelamin)', strtolower($this->jenis_kelamin), true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Digunakan untuk menampilkan seluruh data propinsi
     * @return type
     */
    public function getPropinsiItems() {
        return PropinsiM::model()->findAll('propinsi_aktif=TRUE order by propinsi_nama');
    }

    /**
     * Digunakan untuk mendapatkan data kabupaten berdasarkan propinsi yang dipilih
     * @return type
     */
    public function getKabupatenItems() {
        if (!empty($this->propinsi_id)) {
            return KabupatenM::model()->findAll('propinsi_id=' . $this->propinsi_id . ' order BY kabupaten_nama');
        } else {
            return array();
        }
    }
    
    /**
     * Digunakan untuk mendapatkan data kecamatan berdasarkan kabupaten yang dipilih
     * @return type
     */
    public function getKecamatanItems() {
        if (!empty($this->kabupaten_id)) {
            return KecamatanM::model()->findAll('kabupaten_id=' . $this->kabupaten_id . ' order BY kecamatan_nama');
        } else {
            return array();
        }
    }

    /**
     * Digunakan untuk mendapatkan data kelurahan berdasarkan kecamatan yang dipilih
     * @return type
     */
    public function getKelurahanItems() {
        if (!empty($this->kecamatan_id)) {
            return KelurahanM::model()->findAll('kecamatan_id=' . $this->kecamatan_id . ' order BY kelurahan_nama');
        } else {
            return array();
        }
    }
    
    /**
     * Digunakan untuk mendapatkan nama model
     * @return system
     */
    public function getNamaModel() {
        return __CLASS__;
    }
}
