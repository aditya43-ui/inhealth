<?php
/**
 * Controller untuk informasi batal donor darah
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 * @category controller
 */
class InformasiBatalDonorDarahController extends MyAuthController{
    
    /**
     * Load halaman informasi batal donor darah
     */
    public function actionIndex(){
        $model = new BDDaftardonasiT();
        $model->tgl_awal = date("Y-m-d");
        $model->tgl_akhir = date("Y-m-d");
        if (isset($_GET['BDDaftardonasiT'])) {
            $model->attributes = $_GET['BDDaftardonasiT'];
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['BDDaftardonasiT']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['BDDaftardonasiT']['tgl_akhir']);
            $model->no_pendonor = isset($_GET['BDDaftardonasiT']['no_pendonor']) ? $_GET['BDDaftardonasiT']['no_pendonor'] : null;
            $model->no_formulir = isset($_GET['BDDaftardonasiT']['no_formulir']) ? $_GET['BDDaftardonasiT']['no_formulir'] : null;
            $model->nama_lengkap = isset($_GET['BDDaftardonasiT']['nama_lengkap']) ? $_GET['BDDaftardonasiT']['nama_lengkap'] : null;
            $model->jenis_kelamin = isset($_GET['BDDaftardonasiT']['jenis_kelamin']) ? $_GET['BDDaftardonasiT']['jenis_kelamin'] : null;
            $model->gol_darah = isset($_GET['BDDaftardonasiT']['gol_darah']) ? $_GET['BDDaftardonasiT']['gol_darah'] : null;
            $model->rhesus = isset($_GET['BDDaftardonasiT']['rhesus']) ? $_GET['BDDaftardonasiT']['rhesus'] : null;
        }
        $this->render('index', array('model' => $model));
    }
}
