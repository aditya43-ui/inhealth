<?php
/**
 * model ini digunakan untuk mengakses tabel Inaktifrekammedis_t
 * 
 * @package application.modules.rekamMedis
 * @subpackage models  
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 */
class RKInaktifrekammedisT extends InaktifrekammedisT
{     
    /**
     * action ini untuk mengenerate fungsi AActiveProvider Yii, 
     * @param type $className
     * @return type
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }    
}

