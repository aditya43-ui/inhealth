<?php

class RKLaporankunjunganrjV extends LaporankunjunganrjV
{
    public $tgl_awal;
    public $tgl_akhir;
    
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
}