<?php

class BKInfromasipasiensudahbayarV extends InfromasipasiensudahbayarV
{
    public $tgl_awal;
    public $tgl_akhir;
    public $no_rekam_medik;
    public $no_pendaftaran;
    public $nama_pasien;
    public $nama_bin;
    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}

?>
