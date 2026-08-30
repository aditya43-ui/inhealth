<?php

/**
 * Model untuk tabel oppekehadiran_t hanya untuk modul asuhanKeperawatan
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.asuhanKeperawatan
 * @subpackage models
 */
class ASOppekehadiranT extends OppekehadiranT {

    public $namaunitkerja, $indikatoroppekeperawatan_nama; 
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return OppekehadiranT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
