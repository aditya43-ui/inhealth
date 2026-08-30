<?php

    class FATindakanPelayanan extends TindakanpelayananT
    {
        public $jumlahtarif, $daftartindakan_kode, $daftartindakan_nama;

        public static function model($className=__CLASS__)
        {
            return parent::model($className);
        }
    }
    
?>