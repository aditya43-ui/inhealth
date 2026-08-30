<?php

/**
 * This is the model class for table "bapembelianlangsung_t".
 *
 * @author Tantowi J <tantowijaya@.com>
 * @package application.modules.pengadaan
 * @subpackage models
 * @category model
 */
class ADBapembelianlangsungT extends BapembelianlangsungT {

    public $pegpihakkesatu_nama, $pegpihakkesatu_nip, $pegpihakkesatu_alamat, 
           $pegpihakkedua_nama, $pegpihakkedua_nip, $pegpihakkedua_alamat;    
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return BapembelianlangsungT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
}
