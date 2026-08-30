<?php

/**
 * Model untuk KelompokfaktorrisikodaftarM di Sistem Administrator
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.modules.sistemAdministrator
 * @subpackage models
 * @category model
 */
class ASKelompokFaktorResikoM extends KelompokfaktorrisikodaftarM {

    public $aktif, $faktorrisiko_daftar_nama, $jenisfaktorrisiko_nama;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * untuk mendapatkan data jenis faktor
     * @return type
     */
    public function getJenisFaktorItems() {
        return JenisfaktorrisikoM::model()->findAll('jenisfaktorrisiko_aktif=TRUE ORDER BY jenisfaktorrisiko_nama');
    }
    
    /**
     * untuk mendapatkan data faktor risiko
     * @return type
     */
    public function getFaktorRisikoItems() {
        return FaktorrisikoDaftarM::model()->findAll('faktorrisiko_daftar_aktif=TRUE ORDER BY faktorrisiko_daftar_nama');
    }

}

?>
