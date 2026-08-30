<?php

class RJPasiennapzaT extends PasiennapzaT {
    public $jenisnapza_id;
    public $napza_id;
    public $paramedis_nama;
    public $pegawai_nama;
    public $pegawai_id;
    public $jml_kunjungan;
    public $napza;
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}