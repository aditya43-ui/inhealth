<?php
/**
 * @author  Andyka <andykaputra@.com>
 * @website	   <.com>
 * RSST-196
 * @package application.modules.rekamMedis
 * @subpackage models
 * -Digunakan untuk mengextend dari model utama
 */

class RKPemusnahanrekammedisT extends PemusnahanrekammedisT
{
    public $pegawai_nama, $penanggungjawab_nama;
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

}
?>