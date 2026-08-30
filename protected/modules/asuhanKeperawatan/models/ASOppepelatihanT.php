<?php

/**
 * Model untuk tabel oppepelatihan_t hanya untuk modul asuhanKeperawatan
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.asuhanKeperawatan
 * @subpackage models
 */
class ASOppepelatihanT extends OppepelatihanT {

    public $namaunitkerja, $indikatoroppekeperawatan_nama; 
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return OppepelatihanT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
