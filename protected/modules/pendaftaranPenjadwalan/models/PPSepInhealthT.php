<?php

/**
 * Class model tabel sep_t khusus untuk penjamin Inhealth
 * 
 * @author Tantowi J <tantowijaya@.com>
 * @package application.modules.pendaftaranPenjadwalan
 * @subpackage models
 */
class PPSepInhealthT extends SepT {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SepT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
