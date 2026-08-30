<?php
/**
 * Digunakan sebagai informasi pengiriman kantong darah
 * @author  Elham Budianto <elhambudianto1@gmail.com>
 * @author  Andyka Putra <andykaputra@.com>
 * @author  Deni Hamdani <denihamdani@piindonesia.co.id>
 * @author  Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 * RSST-1538
 */
class InformasiPengirimanDarahController extends MyAuthController
{    
    /**
     * Digunakan untuk load halaman informasi pengiriman kantong darah
     */
    public function actionIndex(){
        
        $model = new BDInfokirimkantongdarahV('searchInformasi');
        $model->tgl_awal= date("Y-m-d");
        $model->tgl_akhir= date("Y-m-d");        
        
        if (isset($_GET['BDInfokirimkantongdarahV'])){
            $model->attributes = $_GET['BDInfokirimkantongdarahV'];    
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['BDInfokirimkantongdarahV']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['BDInfokirimkantongdarahV']['tgl_akhir']);
        }

        $this->render('index',
            array(
                'model'=>$model,
            )
        );
    }
    
    /**
     * Membatalkan pengiriman kantong darah.
     * 
     * Sebelum dilakukan pembatalan, terlebih dahulu diperiksa apakah
     * sudah dilakukan penerimaan.
     * 
     * Jika belum, maka bisa dibatalkan. Begitu juga sebaliknya.
     */
    public function actionBatalKirim() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $ok = 1;
        $msg = "Pengiriman kantong darah berhasil dibatalkan";
        
        $model = KirimkantongdarahT::model()->findByPk($_POST['id']);
        
        if (empty($model)) {
            $ok = 0;
            $msg = "Data pengiriman tidak ditemukan";
            echo CJSON::encode(array('ok'=>$ok, 'msg'=>$msg));
            Yii::app()->end();
        }   
        
        $terima = TerimakantongdarahT::model()->findByAttributes(array(
            'kirimkantongdarah_id'=>$model->kirimkantongdarah_id,
        ));
        
        if (!empty($terima)) {
            $ok = 0;
            $msg = "Batal pengiriman kantong darah tidak dapat dilakukan.<br/>"
                . "Kantong darah sudah diterima.";
            echo CJSON::encode(array('ok'=>$ok, 'msg'=>$msg));
            Yii::app()->end();
        }
        
        // hapus kirim kantong darah
        try {
            KirimkantongdetT::model()->deleteAllByAttributes(array(
                'kirimkantongdarah_id'=>$model->kirimkantongdarah_id
            ));
            MonitoringkantongT::model()->deleteAllByAttributes(array(
                'kirimkantongdarah_id'=>$model->kirimkantongdarah_id
            ));
            $model->delete();
        } catch (Exception $ex) {
            $ok = 0;
            $msg = "Batal pengiriman kantong darah tidak dapat dilakukan.<br/>"
                . $ex->getMessage();
            echo CJSON::encode(array('ok'=>$ok, 'msg'=>$msg));
            Yii::app()->end();
        }
        
        
        echo CJSON::encode(array('ok'=>$ok, 'msg'=>$msg));
        Yii::app()->end();
        
    }
    
    /**
     * Detail Pengiriman Kantong Darah
     * @param type $id
     */
    public function actionDetail($id){
        $this->layout = '//layouts/iframe';
        $model = BDInfokirimkantongdarahV::model()->findByAttributes(array('kirimkantongdarah_id' => $id));
        $modKantong = KirimkantongdarahT::model()->findByPk($id);
        $cekPegawai = PegawaiM::model()->findByPk($modKantong->petugastransporter_id);
        if (!empty($cekPegawai)) {
            $modKantong->petugaskirim_nama = $cekPegawai->nama_pegawai;
        }
        $modDetail = new BDKirimkantongdetT();
        $this->render('detail', array('model' => $model, 'modDetail' => $modDetail,'modKantong'=>$modKantong));
    }

}