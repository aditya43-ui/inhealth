<?php

/**
 * This is the model class for table "Suratdenda_t".
 *
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * 
 * @package application.modules.pengadaan
 * @subpackage models
 * @category model
 */
class ADSuratdendaT extends SuratdendaT {
    
    public $isi_surat;
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SuratdendaT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
}
