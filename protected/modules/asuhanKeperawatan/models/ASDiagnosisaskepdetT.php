<?php

/**
 * Model extend untuk diagnosisaskepdet_t
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.asuhanKeperawatan
 * @subpackage models
 * @category model
 */
class ASDiagnosisaskepdetT extends DiagnosisaskepdetT {

    public $diagnosisaskep_nama, $tandagejala_id, $diagnosisaskep_kode,
            $iskriteria, $kriteriahasildet_id, $intervensidet_id,
            $diagnosisaskep_ir, $diagnosisaskep_er, $istandagejala,
            $kriteriadet_id, $isintervensi, $tujuan_nama, $kriteriahasil_nama, $intervensi_nama, $isdiagnosa, $implementasikep_id,
            $indikatorimplkepdet_id, $alternatifdx_id, $pegawai_id;

    public $tandagejala_indikator, $faktorrisikodet_indikator, $diagnosakep_nama, $pilih_data;
    public $tandagejala_indikator_mayorobjektif, $tandagejala_indikator_mayorsubjektif, $tandagejala_indikator_minorobjektif, $tandagejala_indikator_minorsubjektif;
    public $pilih_data_tandagejala, $pilih_data_faktorrisiko;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return DiagnosisaskepT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
