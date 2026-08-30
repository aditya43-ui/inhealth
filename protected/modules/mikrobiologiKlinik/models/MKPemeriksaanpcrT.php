<?php


class MKPemeriksaanpcrT extends PemeriksaanpcrT {

    public $jenis_pemeriksaan;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PemeriksaanpcrT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
}
