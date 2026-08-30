<?php
/**
 * Model untuk InsidenrsSelainpasienT di modul pelayanan kesehatan masyarakat
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.yankesMasyarakat
 * @subpackage models
 * @category model
 */
class YKMInsidenrsSelainpasienT extends InsidenrsSelainpasienT{
    public $unitkerja_pelapor_nama, $pelapor_nama, $pegawai_mengetahuikejadian_nama,
           $pegawai_mengetahui1_nama, $pegawai_mengetahui2_nama;
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InsidenrsSelainpasienT the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
}
