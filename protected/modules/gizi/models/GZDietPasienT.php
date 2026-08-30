<?php

class GZDietPasienT extends DietpasienT {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
   
    public function getDokterItemsKonsul()
    {
            return DokterV::model()->findAll();
    }

}
