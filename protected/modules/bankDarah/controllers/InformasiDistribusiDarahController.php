<?php

/**
 * Informasi distribusi darah
 * RSST-3709
 * @author Yusuf Putra Anugrah <yusufputra@.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 */
class InformasiDistribusiDarahController extends MyAuthController
{ 
    /**
     * Default menu informasi distribusi darah
     */
    public function actionIndex(){
        $model = new BDDistribusidarahT();
        
        $model->tgl_awal= date("Y-m-d");
        $model->tgl_akhir= date("Y-m-d");        
        if (isset($_GET['BDDistribusidarahT'])){
            $model->attributes = $_GET['BDDistribusidarahT'];      
            $model->nama_pegawai = $_GET['BDDistribusidarahT']['nama_pegawai'];
             $model->status = $_GET['BDDistribusidarahT']['status'];    
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['BDDistribusidarahT']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['BDDistribusidarahT']['tgl_akhir']);
        }
        
        $this->render('index',
            array(
                'model'=>$model,
            )
        );
    }
    
    /**
     * Batal distribusi darah
     */
    public function actionBatalDistribusi(){
        if (!Yii::app()->request->isAjaxRequest) {
            Yii::app()->end();
        }
        
        $res = array();
        $distribusidarah_id = $_POST['distribusidarah_id'];
        
        try {
            $trans = Yii::app()->db->beginTransaction();
            $hapusDetail = DistribusidarahdetT::model()->deleteAllByAttributes(array('distribusidarah_id' => $distribusidarah_id));
            $hapusTerima = DistribusidarahT::model()->deleteByPk($distribusidarah_id);
            if($hapusDetail && $hapusTerima){
                $trans->commit();
                $res['sukses'] = 1;
            }else{
                $trans->rollback();
                $res['sukses'] = 1;
            }
        } catch (Exception $ex) {
            $trans->rollback();
            $res['sukses'] = 1;
        }
        
        echo CJSON::encode($res);
    }
}