<?php
/**
 * Model untuk Insidentumpahanb3T di modul pelayanan kesehatan masyarakat
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
 * @package application.modules.yankesMasyarakat
 * @subpackage models
 * @category model
 */
class YKMInsidentumpahanb3T extends Insidentumpahanb3T{
    public $pelapor_nama, $mengetahuipegawai_nama, $unitkerja_kejadian_nama, 
            $tanggal_awal, $tanggal_akhir, $tanggal_awal2, $tanggal_akhir2, 
            $status_verifikasi, $tipeLapor, $tipeInsiden, $namaLengkap, $namaunitkerja, $mengetahuipegawai;
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}

