<?php
/**
 * digunakan untuk laporan RL
 * @author Rusdiyanto <rusdiyanto@.com>
 * @package application.modules.rekamMedis
 * @subpackage models
 */
class RKRl310KegiatanpelayanankhususV extends Rl310KegiatanpelayanankhususV
{
    public $tahun;
    
    /**
    * Returns the static model of the specified AR class.
    * @param string $className active record class name.
    * @return Rl310KegiatanpelayanankhususV the static model class
    */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
}