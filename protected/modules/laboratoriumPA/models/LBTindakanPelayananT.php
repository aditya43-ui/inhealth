<?php
/**
 * Model extend untuk tabel tindakanpelayanan_t di modul Lab PA
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.laboratoriumPA
 * @subpackage models
 * @category model
 */
class LBTindakanPelayananT extends TindakanpelayananT {

    public $pegawai_verifikasi_ppds_nama, $pegawai_verifikasi_ppds_id;
    public $pemeriksaanlab_id; //untuk form daftar tindakan pemeriksaan
    public $jenistarif_id; //untuk form daftar tindakan pemeriksaan
    public $totaltariftindakan; //di print status

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TindakanpelayananT the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * menampilkan pemeriksaan lab berdasarkan daftartindakan_id
     * @return type
     */
    public function getPemeriksaanLab() {
        return LBPemeriksaanlabM::model()->findByAttributes(array('daftartindakan_id' => $this->daftartindakan_id));
    }
}