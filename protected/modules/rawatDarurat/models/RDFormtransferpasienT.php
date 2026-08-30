<?php

class RDFormtransferpasienT extends FormtransferpasienT
{
    public $ruanganasal_nama, $diagnosamasukrs, $riwayatpenyakitterdahulu, $riwayatalergi, $ruangantujuan_nama;
    
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

}