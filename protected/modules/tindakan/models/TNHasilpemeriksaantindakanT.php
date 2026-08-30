<?php
/**
 * model yang digunakan untuk mengakses tabel infokunjunganrj_v, hanya pada modul rawat jalan
 * 
 * @package application.modules.tindakan
 * @subpackage application.modules.tindakan.models
 * @author muhhi73@comp
 */
class TNHasilpemeriksaantindakanT extends HasilpemeriksaantindakanT {

    public $tgl_awal;
    public $tgl_akhir;
 

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PasienM the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

}