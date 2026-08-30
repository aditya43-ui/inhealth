<?php

/**
 * This is the model class for table "staining_gambar_t".
 *
 * @author Tantowi J <tantowijaya@.com>
 * @package application.modules.mikrobiologiKlinik
 * @subpackage models
 * @category model
 */
class MKStainingGambarT extends StainingGambarT {

    public $pemeriksaanlab_nama, $ppds_nama, $ppds_nim, $dpjtm_nama, $dpjtm_nip, $temp_file, $analis_nip, $analis_nama;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return StainingGambarT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
}
