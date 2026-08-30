<?php

class GFPenghargaoadetailT extends PenghargaoadetailT
{
    public $satuanobat, $ppn_persen;
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
}