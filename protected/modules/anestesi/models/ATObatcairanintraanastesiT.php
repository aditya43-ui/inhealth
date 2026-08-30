<?php
/**
 * model yang digunakan untuk mengambil data tabel obat cairan anestesi, hanya untuk di modul anestesi
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.modules.anestesi
 * @subpackage models  
 */
class ATObatcairanintraanastesiT extends ObatcairanintraanastesiT {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return IntraanestesiT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
