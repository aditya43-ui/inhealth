<?php

/**
 * Digunakan untuk mengambil data tabel penggunaan_coolboxdet_t, hanya untuk di modul bank darah
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.bankDarah
 * @subpackage models 
 * @category model
 */
class BDPenggunaanCoolboxdetT extends PenggunaanCoolboxdetT {
    public $no_kantongpabrik;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PenggunaanCoolboxdetT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
