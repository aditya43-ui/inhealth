<?php

/**
 * This is the model class for table "notadinaskpa_t".
 * 
 * @author Tantowi J <tantowijaya@.com>
 * @package application.modules.pengadaan
 * @subpackage models
 * @category model
 */
class ADNotadinaskpaT extends NotadinaskpaT {

    public $terminke, $termin_ke, $total_termin, $termin_persen, $isi_surat;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return NotadinaskpaT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
}
