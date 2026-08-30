<?php

class GZPemeriksaanFisikT extends PemeriksaanfisikT {

    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
        
    public function getDokterItemsKonsul()
    {
            return DokterV::model()->findAll();
    }
}
