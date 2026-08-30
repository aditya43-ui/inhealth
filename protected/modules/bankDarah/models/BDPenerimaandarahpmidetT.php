<?php

/**
 * Model tabel penerimaandarahpmidet_t pada module bank darah.
 * 
 * @author Tantowi J <tantowijaya@.com>
 * @package application.modules.bankDarah
 * @subpackage models
 */
class BDPenerimaandarahpmidetT extends PenerimaandarahpmidetT {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PenerimaandarahpmiT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
