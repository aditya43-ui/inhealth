<?php

class GZPesanmenudetailT extends PesanmenudetailT
{
    public $ruangan_id, $ruangan_nama;
    public $kirimmenudiet_id, $bahandiet_id, $jenispesanmenu, $nopesanmenu, $tglpesanmenu;
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
