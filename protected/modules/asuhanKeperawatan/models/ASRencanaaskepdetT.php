<?php
/**
 * Model extend untuk rencanaaskepdet_t
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.asuhanKeperawatan
 * @subpackage models
 * @category model
 */
class ASRencanaaskepdetT extends RencanaaskepdetT {

    public $diagnosakep_nama, $tandagejala_id, $diagnosakep_kode,
            $iskriteria, $kriteriahasildet_id, $intervensidet_id,
            $rencanaaskep_ir, $rencanaaskep_er, $istandagejala,
            $kriteriadet_id, $isintervensi, $tujuan_nama, $kriteriahasil_nama, $intervensi_nama, $isdiagnosa, $implementasikep_id,
            $indikatorimplkepdet_id, $alternatifdx_id, $pegawai_id, $hasildiagnosa_id;
    public $detail;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return RencanaaskepT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
