<?php

/**
 * Class model tabel pasienmasukpenunjang_t pada modul mikrobiologi
 * 
 * @author Tantowi J <tantowijaya@.com>
 * @package application.modules.mikrobiologiKlinik
 * @subpackage models
 * @category model
 */
class MKPasienmasukpenunjangT extends PasienmasukpenunjangT{
    
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienmasukpenunjangT the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
}