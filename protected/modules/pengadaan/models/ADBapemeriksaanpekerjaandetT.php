<?php

/**
 * This is the model class for table "bapemeriksaanpekerjaandet_t".
 *
 * @author Tantowi J <tantowijaya@.com>
 * 
 * @package application.modules.pengadaan
 * @subpackage models
 * @category model
 */
class ADBapemeriksaanpekerjaandetT extends BapemeriksaanpekerjaandetT {

    public $barang_harga, $barang_total;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return BapemeriksaanpekerjaandetT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
}
