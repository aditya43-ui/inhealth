<?php
/**
 * Model untuk tabel implementasiaskepdet_t pada module asuhan keperawatan
 * 
 * @author Elham Budianto <elhambudianto@.com>
 * @subpackage application.modules.asuhanKeperawatan
 * @subpackage models
 * @category model
 */
class ASImplementasiaskepdetT extends ImplementasiaskepdetT {

    public $diagnosakep_nama, $iskolaborasi, $rencanaaskepdet_ketkolaborasi, $rencanaaskep_id, $isdiagnosa, $intervensi_id, $intervensi_nama
            , $indikatorimplkepdet_id, $evaluasiaskepdet_subjektif, $evaluasiaskepdet_implementasi, $evaluasiaskepdet_objektif, $evaluasiaskepdet_assessment, $evaluasiaskepdet_planning, $evaluasiaskepdet_hasil,
            $evaluasiaskep_id, $alternatifdx_id;
    public $diagnosisaskepdet_id, $detail;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ImplementasiaskepdetT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
