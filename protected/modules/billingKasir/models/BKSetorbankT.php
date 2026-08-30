<?php

class BKSetorbankT extends SetorbankT
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return BatalbayarsupplierT the static model class
     */
    public $tgl_awal;
    public $tgl_akhir;
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
}