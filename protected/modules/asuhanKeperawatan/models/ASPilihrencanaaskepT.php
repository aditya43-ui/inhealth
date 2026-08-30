<?php
/**
 * Model extend untuk pilihrencanaskep_t
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.asuhanKeperawatan
 * @subpackage models
 * @category model
 */
class ASPilihrencanaaskepT extends PilihrencanaaskepT {

    public $iskriteria, $tandagejala_indikator, $kriteriahasildet_indikator, $intervensidet_indikator, $alternatifdx_nama;
    public $diagnosakep_id, $diagnosakep_nama, $iskolaborasi, $rencanaaskepdet_ketkolaborasi, $intervensi_id;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PilihrencanaaskepT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
