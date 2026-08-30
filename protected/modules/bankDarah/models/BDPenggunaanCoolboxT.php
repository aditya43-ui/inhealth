<?php

/**
 * Digunakan untuk mengambil data tabel penggunaan_coolbox_t, hanya untuk di modul bank darah
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.bankDarah
 * @subpackage models 
 * @category model
 */
class BDPenggunaanCoolboxT extends PenggunaanCoolboxT {

    public $tgl_awal, $tgl_akhir, $coolboxdarah_nama, $ruangan_nama, $tglmonitoring;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PenggunaanCoolboxT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * Digunakan sebagai pencarian data untuk halaman Informasi Monitoring Suhu Coolbox
     * @return \CActiveDataProvider
     */
    public function searchInformasiMonitoring() {
        $criteria = new CDbCriteria;
        $criteria->addBetweenCondition('DATE(tgl_penggunaan_coolbox)', $this->tgl_awal, $this->tgl_akhir);

        if (!empty($this->coolboxdarah_id)) {
            $criteria->addCondition(" coolboxdarah_id = '" . $this->coolboxdarah_id . "' ");
        }
        $criteria->compare('LOWER(no_penggunaan_coolbox)', strtolower($this->no_penggunaan_coolbox), true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
