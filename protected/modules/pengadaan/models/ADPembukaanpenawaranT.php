<?php
/**
 * Model extend untuk pembukaanpenawaran-t
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.pengadaan
 * @subpackage models
 * @category model
 */
class ADPembukaanpenawaranT extends PembukaanpenawaranT {

    public $supplier_nama, $supplier_alamat, $cek_informasi, $dasar; 
    public $pejabatpengadaan_nama, $pejabatpengadaan_nip, $pejabatpengadaan_jabatan; 
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PembukaanpenawaranT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
