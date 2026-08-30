<?php
/**
 * model yang digunakan untuk mengambil data tabel Praanestesi_induksi_t, hanya untuk di modul anestesi
 * @package application.modules.anestesi
 * @subpackage models  
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
class ATPraanestesiInduksiT extends PraanestesiInduksiT
{    
    /**
     * untuk mengenerate fungsi - fungsi activeprovider yii
     * @param type $className
     * @return type
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }    
}