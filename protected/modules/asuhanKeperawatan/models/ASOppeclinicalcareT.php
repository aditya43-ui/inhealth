<?php

/**
 * Model untuk tabel oppeclinicalcare_t hanya untuk modul asuhanKeperawatan
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.modules.asuhanKeperawatan
 * @subpackage models
 */
class ASOppeclinicalcareT extends OppeclinicalcareT {

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
