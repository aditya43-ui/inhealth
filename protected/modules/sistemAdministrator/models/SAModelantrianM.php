<?php

/**
 * This is the model class for table "Modelantrian_m".
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.com>
 * @package application.modules.sistemAdministrator
 * @subpackage models 
 */
class SAModelantrianM extends ModelantrianM
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ModelantrianM the static model class
     */        
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
}