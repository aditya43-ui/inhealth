<?php

/**
 * This is the model class for table "bapemeriksaanpekerjaan_t".
 *
 * @author Tantowi J <tantowijaya@.com>
 * 
 * @package application.modules.pengadaan
 * @subpackage models
 * @category model
 */
class ADBapemeriksaanpekerjaanT extends BapemeriksaanpekerjaanT {

    public $total_termin, $termin_ke;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return BapemeriksaanpekerjaanT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
}
