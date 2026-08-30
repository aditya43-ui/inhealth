<?php

/**
 * Model extend untuk pilihdiagnosisaskep_t
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.asuhanKeperawatan
 * @subpackage models
 * @category model
 */
class ASPilihdiagnosisaskepT extends PilihdiagnosisaskepT {

    public $iskriteria, $tandagejala_indikator, $kriteriahasildet_indikator, $intervensidet_indikator, $alternatifdx_nama;
    public $diagnosisaskep_id, $diagnosisaskep_nama, $iskolaborasi, $diagnosisaskepdet_ketkolaborasi, $diagnosakep_id, $kelompoktandagejaladaftar_id, $kelompokfaktorrisikodaftar_id;
    public $pilih_data_tandagejala, $pilih_data_faktorrisiko, $tandagejala_indikator_mayorsubjektif, $tandagejala_indikator_mayorobjektif, $tandagejala_indikator_minorsubjektif, $tandagejala_indikator_minorobjektif, $faktorrisikodet_indikator, $diagnosakep_nama;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PilihdiagnosisaskepT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
