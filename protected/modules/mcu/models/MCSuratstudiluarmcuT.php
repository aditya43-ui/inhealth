<?php
/**
* digunakan untuk surat studi luar mcu
* @author Elham Budianto <elhambudianto1@gmail.com>
* @package application.modules.mcu
* @subpackage models
**/
class MCSuratstudiluarmcuT extends SuratstudiluarmcuT
{
    public $jenis_surat;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KesimpulanmcuT the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
}