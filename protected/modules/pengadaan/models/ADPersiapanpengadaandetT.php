<?php
/**
* model yang digunakan untuk mengakses tabel Persiapanpengadaandet_t, pada modul pengadaan
* @package      application.modules.pengadaan
* @subpackage   models  
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @link      <http://piindonesia.co.id>
* @link      <http://172.9.1.15/simpp/docs/>
*/
class ADPersiapanpengadaandetT extends PersiapanpengadaandetT
{
    
    public $sisapagu_pengadaan, $jumlah_hargalama, $rencanaumumpengadaandet_id, $ongkos_kirim, $nama_dpa, $merk;
    
    /**
     * untuk mengenerate fungsi - fungsi activeprovide yii
     * @param type $className
     * @return type
     */    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }    
}