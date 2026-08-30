<?php
/**
* model yang digunakan untuk mengakses tabel Syaratkhususkontrak_t, pada modul pengadaan
* @package      application.modules.pengadaan
* @subpackage   models  
* @category     model
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @link      <http://piindonesia.co.id>
* @link      <http://172.9.1.15/simpp/docs/>
*/
class ADSyaratkhususkontrakT extends SyaratkhususkontrakT
{    
    /**
     * untuk mengenerate fungsi - fungsi active provider yii
     * @param type $className
     * @return type
     */    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }    
        
}