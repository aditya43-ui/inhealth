<?php

/**
 * Class model rujukan khusus untuk proses rujukan asuransi inhealth
 * 
 * @author Tantowi J <tantowijaya@.com>
 * @package application.modules.pendaftaranPenjadwalan
 * @subpackage models
 */
class PPRujukanInhealthT extends PPRujukanT
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KelompokmenuK the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
}
?>
