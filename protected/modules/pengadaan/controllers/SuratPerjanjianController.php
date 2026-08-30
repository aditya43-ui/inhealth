<?php
/**
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.pengadaan
 * @subpackage controllers
 * @category controller
 */
class SuratPerjanjianController extends MyAuthController{
    
    /**
     * Load Surat Perjanjian Kerja dan tab menu
     */
    public function actionIndex(){
        $model = new InformasipersiapanpengadaanV();
        $this->render('index', array('model' => $model));
    }
    
    /**
     * URL untuk ke transaksi penetapan pemenang
     * @return type
     */
    public function getUrlPenetapanPemenang(){
        return $this->module->id.'/PenetapanPemenangT/index';
    }
    
    /**
     * URL untuk ke transaksi pengumuman pemenang
     * @return type
     */
    public function getUrlPengumumanPemenang(){
        return $this->module->id.'/PengumumanPemenangT/index';
    }
    
    /**
     * URL untuk ke transaksi SPPBJ
     * @return type
     */
    public function getUrlSPPBJ(){
        return $this->module->id.'/PenunjukanPenyediaT/index';
    }
    
    /**
     * URL untuk ke transaksi Perjanjian Kerja
     * @return type
     */
    public function getUrlPerjanjianKerja(){
        return $this->module->id.'/SuratPerjanjianKerja/index';
    }
    
    /**
     * URL untuk ke transaksi surat perintah mulai kerja
     * @return type
     */
    public function getUrlSuratPerintahMulaiKerja(){
        return $this->module->id.'/SuratPerintahMulaiKerja/index';
    }
    
    /**
     * URL untuk ke transaksi SSKK
     * @return type
     */
    public function getUrlSSKK(){
        return $this->module->id.'/suratPerjanjianSSKK/index';
    }
    
    /**
     * URL untuk ke transaksi Informasi Umum
     * @return type
     */
    public function getUrlInformasiUmumT(){
        return $this->module->id.'/InformasiUmumT/index';
    }
    
    /**
     * URL untuk ke transaksi Nota Dinas Pejabat Pengadaan
     * @return type
     */
    public function getUrlNotaDinas(){
        return $this->module->id.'/NotaDinasPejabatPengadaan/index';
    }
    
    /**
     * URL untuk ke transaksi Negosiasi/Klarifikasi
     * @return type
     */
    public function getUrlBANegosiasi(){
        return $this->module->id.'/BANegosiasi/index';
    }
    
    /**
     * URL untuk ke transaksi Pengadaan Langsung
     * @return type
     */
    public function getUrlBAPengadaanLangsung(){
        return $this->module->id.'/BAPengadaanLangsung/index';
    }
    
    
    /**
     * URL untuk ke transaksi surat denda
     * @return type
     */
    public function getUrlSuratDenda(){
        return $this->module->id.'/suratDenda/index';
    }
    
    /**
     * URL untuk ke transaksi evaluasi penawaran
     * @return type
     */
    public function getUrlEvaluasipenawaran(){
        return $this->module->id.'/evaluasiPenawaran/index';
    }

    /**
     * URL untuk ke transaksi pembukaan penawaran
     * @return type
     */
    public function getUrlPembukaanPenawaran(){
        return $this->module->id.'/pembukaanpenawaranT/index';
    }
    
}
