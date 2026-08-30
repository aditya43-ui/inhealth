<?php
/**
 * model ini digunakan untuk mengakses tabel Inaktifrekammedisdet_t
 * 
 * @package application.modules.rekamMedis
 * @subpackage models  
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 */
class RKInaktifrekammedisdetT extends InaktifrekammedisdetT
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

