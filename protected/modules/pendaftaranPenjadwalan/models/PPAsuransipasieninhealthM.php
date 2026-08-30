<?php

/**
 * Class model tabel asuransipasienm khusus untuk penjamin Inhealth
 * 
 * @author Tantowi J <tantowijaya@.com>
 * @package application.modules.pendaftaranPenjadwalan
 * @subpackage models
 */
class PPAsuransipasieninhealthM extends PPAsuransipasienM {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AsuransipasienM the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
