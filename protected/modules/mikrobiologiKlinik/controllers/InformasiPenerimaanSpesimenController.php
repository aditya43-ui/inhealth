<?php
/**
 * Controller untuk informasi Penerimaan Spesimen
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.mikrobiologiKlinik
 * @subpackage controllers
 * @category controller
 */
class InformasiPenerimaanSpesimenController extends MyAuthController{
    
    /**
     * Load halaman index penerimaan spesimen
     */
    public function actionIndex(){
        $model = new PenerimaanspesimenT();
        $model->tgl_awal = date('d M Y');
        $model->tgl_akhir = date('d M Y');
        if (isset($_GET['PenerimaanspesimenT'])){
            $model->attributes = $_GET['PenerimaanspesimenT'];    
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['PenerimaanspesimenT']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['PenerimaanspesimenT']['tgl_akhir']);
            $model->no_terimaspesimen = $_GET['PenerimaanspesimenT']['no_terimaspesimen'];
            $model->nama_pegawai = $_GET['PenerimaanspesimenT']['nama_pegawai'];
        }
        $this->render('index', array('model' => $model));
    }
    
    /**
     * Detail Penerimaan Spesimen
     * @param type $id
     */
    public function actionDetail($id){
        $this->layout = '//layouts/iframe';
        $model = PenerimaanspesimenT::model()->findByPk($id);        
        $model->ruangan_nama = !empty($model->ruangan_id)?$model->ruangan->ruangan_nama:'';                
        $model->nama_pegawai = !empty($model->petugasterima_id)?$model->pegawai->namaLengkap:'';
        $modDetail = PenerimaanspesimendetT::model()->findAllByAttributes(array('penerimaanspesimen_id' => $id));
        $model->tglterimaspesimen = MyFormatter::formatDateTimeForUser($model->tglterimaspesimen);
        $this->render('detail', array('model' => $model, 'modDetail' => $modDetail));
    }
    
    /**
     * Batal Penerimaan Spesimen
     * Update ke penerimaanspesimen_t dan insert ke batalpenerimaanspesimen_t
     */
    public function actionBatalTerima() {
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $ok = 1;
        $msg = "Penerimaan spesimen berhasil dibatalkan";
        $id = $_POST['id'];
        $model = PenerimaanspesimenT::model()->findByPk($id);
        
        $batal = new BatalpenerimaanspesimenT();
        $batal->tglbatalpenerimaan = date("d M Y H:i:s"); 
        $batal->petugas_id = Yii::app()->user->getState('pegawai_id');
        $batal->save();
        $update = PenerimaanspesimenT::model()->updateByPk($id, array('batalpenerimaanspesimen_id' => $batal->batalpenerimaanspesimen_id));
        
        $cekPenerimaanspesimendet = PenerimaanspesimendetT::model()->findByAttributes(array('penerimaanspesimen_id'=>$id));
        $updatePengirimandet = PengirimanspesimendetT::model()->findByAttributes(array('penerimaanspesimendet_id'=>$cekPenerimaanspesimendet->penerimaanspesimendet_id));
        $updatePengirimandet->penerimaanspesimendet_id = null;
        $updatePengirimandet->update();
        
        $updateSpesimen = SpesimenT::model()->findByAttributes(array('penerimaanspesimendet_id'=>$cekPenerimaanspesimendet->penerimaanspesimendet_id));
        $updateSpesimen->penerimaanspesimendet_id = null;
        $updateSpesimen->update();
        
        echo CJSON::encode(array('ok'=>$ok, 'msg'=>$msg));
        Yii::app()->end();
        
    }
}