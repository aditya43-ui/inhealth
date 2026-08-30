<?php
/**
 * digunakan sebagai Informasi penerimaan darah kembali
 * @author  Elham Budianto <elhambudianto1@gmail.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 * */
class InformasiReturDarahController extends MyAuthController {

    public $layout = '//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'bankDarah.views.informasiReturDarah.';

    /**
     * Menampilkan halaman informasi penerimaan darah kembali
     */
    public function actionIndex() {

        $model = new BDReturdarahT('searchInformasi');

        $model->tgl_awal = date("Y-m-d");
        $model->tgl_akhir = date("Y-m-d");
        if (isset($_GET['BDReturdarahT'])) {
            $model->attributes = $_GET['BDReturdarahT'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['BDReturdarahT']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['BDReturdarahT']['tgl_akhir']);
            if (!empty($_GET['BDReturdarahT']['nama_pasien'])) {
                $model->nama_pasien = $_GET['BDReturdarahT']['nama_pasien'];
            }
            if (!empty($_GET['BDReturdarahT']['no_rekam_medik'])) {
                $model->no_rekam_medik = $_GET['BDReturdarahT']['no_rekam_medik'];
            }
            if (!empty($_GET['BDReturdarahT']['petugas_penerima_nama'])) {
                $model->petugas_penerima_nama = $_GET['BDReturdarahT']['petugas_penerima_nama'];
            }
            if (!empty($_GET['BDReturdarahT']['ruangan_id'])) {
                $model->ruangan_id = $_GET['BDReturdarahT']['ruangan_id'];
            }
            if (!empty($_GET['BDReturdarahT']['no_kantongdarah'])) {
                $model->no_kantongdarah = $_GET['BDReturdarahT']['no_kantongdarah'];
            }
            if (!empty($_GET['BDReturdarahT']['gol_darah'])) {
                $model->gol_darah = $_GET['BDReturdarahT']['gol_darah'];
            }
            if (!empty($_GET['BDReturdarahT']['jenis_komponen_darah'])) {
                $model->jenis_komponen_darah = $_GET['BDReturdarahT']['jenis_komponen_darah'];
            }
            if (!empty($_GET['BDReturdarahT']['gol_darah'])) {
                $model->gol_darah = $_GET['BDReturdarahT']['gol_darah'];
            }
            if (!empty($_GET['BDReturdarahT']['asaldarah'])) {
                $model->asaldarah = $_GET['BDReturdarahT']['asaldarah'];
            }
        }

        $this->render($this->path_view . 'index', array('model' => $model));
    }

    /**
     * Menampilkan detail analisa darah kembali
     * @param type $returdarah_id
     */
    public function actionDetail($returdarah_id) {
        $this->layout = '//layouts/iframe';
        $model = BDReturdarahT::model()->findByPk($returdarah_id);
        $model->returdarah_id = $model->returdarah_id;
        $model->tgl_retur_darah = MyFormatter::formatDateTimeForUser($model->tgl_retur_darah);
        $model->tgl_analisa = MyFormatter::formatDateTimeForUser($model->tgl_analisa);
        $kompat = UjikompatibilitasT::model()->findByPk($model->ujikompatibilitas_id);

        //data pasien
        $pasien = PasienM::model()->findByPk($kompat->pasien_id);
        $pendaftaran = PendaftaranT::model()->findByPk($kompat->pendaftaran_id);
        $ruangan = RuanganM::model()->findByPk($pendaftaran->ruangan_id);

        //data darah
        $stokkantongdarah = StokkantongdarahT::model()->findByPk($kompat->stokkantongdarah_id);
        $kantongdarah = KantongdarahT::model()->findByPk($stokkantongdarah->kantongdarah_id);
        $komponendarah = KomponendarahM::model()->findByPk($kantongdarah->komponendarah_id);
        $pendonor = PendonorM::model()->findByPk($kantongdarah->pendonor_id);

        //petugas penerima
        $pegawai = PegawaiM::model()->findByPk($model->petugas_penerima_id);
        
        //petugas analisa
        $pegawaiAnalisa = PegawaiM::model()->findByPk($model->petugas_analisa_id);
        
        if ($model->is_ruangan == true) {
            $model->asal_darah = 'Ruangan';
        } else if ($model->is_bdt == true) {
            $model->asal_darah = 'BDT';
        } else if ($model->is_itd == true) {
            $model->asal_darah = 'IDT';
        }
        
        if ($model->is_kadaluarsa == true) {
            $model->is_kadaluarsa = 1;
        }else{
            $model->is_kadaluarsa = 2;
        } 
        if ($model->is_sealer_habis == true) {
            $model->is_sealer_habis = 1;
        }else{
            $model->is_sealer_habis = 2;
        } 
        if ($model->is_bocor == true) {
            $model->is_bocor = 1;
        }else{
            $model->is_bocor = 2;
        } 
        if ($model->is_tabung_terbuka == true) {
            $model->is_tabung_terbuka = 1;
        }else{
            $model->is_tabung_terbuka = 2;
        } 
        if ($model->is_gumpalan_plasma == true) {
            $model->is_gumpalan_plasma = 1;
        }else{
            $model->is_gumpalan_plasma = 2;
        } 
        if ($model->is_hemolisis == true) {
            $model->is_hemolisis = 1;
        }else{
            $model->is_hemolisis = 2;
        } 
        if ($model->is_endapan == true) {
            $model->is_endapan = 1;
        }else{
            $model->is_endapan = 2;
        } 

        $model->no_kantongdarah = $kompat->nomorbarcode;
        $model->nama_pasien = $pasien->nama_pasien;
        $model->no_rekam_medik = $pasien->no_rekam_medik;
        $model->ruangan_nama = $ruangan->ruangan_nama;
        $model->jenis_komponen_darah = $komponendarah->singkatan_komp;
        $model->golongan_darah = $pendonor->gol_darah;
        $model->petugas_penerima_nama = $pegawai->nama_pegawai;
        $model->petugas_analisa_nama = $pegawaiAnalisa->nama_pegawai;
        $this->render($this->path_view . '_detail', array(
            'model' => $model,
        ));
    }

}
