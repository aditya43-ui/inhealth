<?php
/**
 * Controller untuk Informasi Pengiriman Spesimen
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.mikrobiologiKlinik
 * @subpackage controllers
 * @category controller
 */
class InformasiPengirimanSpesimenController extends MyAuthController{
    
    /**
     * Load data informasi pengiriman spesimen
     */
    public function actionIndex(){
        $model = new InfopengirimanspesimenV();
        $model->tgl_awal= date("Y-m-d");
        $model->tgl_akhir= date("Y-m-d");        
        if (isset($_GET['InfopengirimanspesimenV'])){
            $model->attributes = $_GET['InfopengirimanspesimenV'];    
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['InfopengirimanspesimenV']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['InfopengirimanspesimenV']['tgl_akhir']);
        }
        $this->render('index', array('model' => $model));
    }
    
    /**
     * Fungsi pembatalan pengiriman
     * Input data ke batalpengirimanspesimen_t dan update id pembatalan ke pengirimanspesimen_t
     */
    public function actionBatalKirim() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $id = $_POST['id'];
        $modDet = PengirimanspesimendetT::model()->findByPk($id);
        $modDet->is_batalpengiriman = true;
        if($modDet->save()){
            $ok = 1;
            $msg = "Pengiriman spesimen berhasil dibatalkan";
        }else{
            $ok = 0;
            $msg = "Pengiriman spesimen gagal dibatalkan";
        }
        
        echo CJSON::encode(array('ok'=>$ok, 'msg'=>$msg));
        Yii::app()->end();
    }
    
    /**
     * Detail Informasi Pengiriman Spesimen
     * @param type $id
     */
    public function actionDetail($id){
        $this->layout = '//layouts/iframe';
        $model = PengirimanspesimenT::model()->findByPk($id);
        //Ruangan
        $modRuangan = RuanganM::model()->findByPk($model->ruangan_id);
        $model->ruangankirim_nama = $modRuangan->ruangan_nama;
        $model->instalasikirim_nama = $modRuangan->instalasi->instalasi_nama;
        $this->render('detail', array('model' => $model));
    }
        
}