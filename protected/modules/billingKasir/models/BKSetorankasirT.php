<?php

class BKSetorankasirT extends SetorankasirT {
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AntrianT the static model class
     */
    
    public $pegawai_nama, $bendahara_nama;
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
}
