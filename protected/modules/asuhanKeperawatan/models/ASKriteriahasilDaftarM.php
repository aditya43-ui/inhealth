<?php
/**
 * Model untuk tabel evaluasiaskepdet_t pada module asuhan keperawatan
 * 
 * @author M Iqbal Laksana <iqballaksana@.com>
 * @subpackage application.modules.asuhanKeperawatan
 * @subpackage models
 * @category model
 */
class ASKriteriahasilDaftarM extends KriteriahasilDaftarM {

    public $isdiagnosa, $diagnosakep_nama;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return EvaluasiaskepdetT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }  
}
