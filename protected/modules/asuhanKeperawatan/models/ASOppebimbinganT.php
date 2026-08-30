<?php

/**
 * Model untuk tabel oppebimbingan_t hanya untuk modul asuhanKeperawatan
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.modules.asuhanKeperawatan
 * @subpackage models
 */
class ASOppebimbinganT extends OppebimbinganT {

    public $namaunitkerja, $indikatoroppekeperawatan_nama, $standar_nilai;  
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return OppeasesmenT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
