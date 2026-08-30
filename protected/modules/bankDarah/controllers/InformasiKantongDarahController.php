<?php
/**
 * Menampilkan halaman Informasi Kantong Darah di modul Bank Darah
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 */
class InformasiKantongDarahController extends MyAuthController
{    
    public $path_view = 'bankDarah.views.informasiKantongDarah'; 
    public $path_tips = 'bankDarah.views.informasiKantongDarah.tips';
    
    /**
     * load data seluruh kantong darah
     */
    public function actionIndex(){
        $model = new BDInfokantongdarahV('searchInformasiKantongDarah');
        $model->tgl_awal= date("Y-m-d");
        $model->tgl_akhir= date("Y-m-d");   
        if (isset($_GET['BDInfokantongdarahV'])){
            $model->attributes = $_GET['BDInfokantongdarahV']; 
            $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['BDInfokantongdarahV']['tgl_awal']);
            $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['BDInfokantongdarahV']['tgl_akhir']);
            $model->no_kantongdarah=isset($_GET['BDInfokantongdarahV']['no_kantongdarah'])?$_GET['BDInfokantongdarahV']['no_kantongdarah']:null;
            $model->gol_darah =isset($_GET['BDInfokantongdarahV']['gol_darah'])?$_GET['BDInfokantongdarahV']['gol_darah']:null;
            $model->rhesus=isset($_GET['BDInfokantongdarahV']['rhesus'])?$_GET['BDInfokantongdarahV']['rhesus']:null;
            $model->nama_jenis=isset($_GET['BDInfokantongdarahV']['nama_jenis'])?$_GET['BDInfokantongdarahV']['nama_jenis']:null;
            $model->statuspelulusan=isset($_GET['BDInfokantongdarahV']['statuspelulusan'])?$_GET['BDInfokantongdarahV']['statuspelulusan']:null;
            $model->nomorbarcode_utama=isset($_GET['BDInfokantongdarahV']['nomorbarcode_utama'])?$_GET['BDInfokantongdarahV']['nomorbarcode_utama']:null;
        }
        $this->render('index',
            array(
                'model'=>$model,
            )
        );
    }
    
    /**
     * Load form pembuangan kantong darah
     * @param type $id
     */
    public function actionBuang($id){
        $this->layout = '//layouts/iframe';
        $kantong = KantongdarahT::model()->findByPk($id);
        $model = new BatalkantongdarahT;
        
        $this->render('_buangkantongdarah', array('kantong' => $kantong, 'model' => $model));
    }
    
    /**
     * Fungsi ajax untuk buang kantong darah 
     * Update batalkantongdarah_id ke kantongdarah_t dan memasukkan data ke tabel batalkantongdarah_t
     * @throws CHttpException
     */
    public function actionAjaxBuang(){
            if(Yii::app()->request->isPostRequest)
            {
                $id = $_POST['id']; 
                $alasan = $_POST['alasan'];
                $modelBuang = new BatalkantongdarahT;
                $modelBuang->kantongdarah_id = $id;
                $modelBuang->alasan_pembatalan = $alasan;
                $modelBuang->pegawai_id = Yii::app()->user->getState('pegawai_id');
                $modelBuang->create_time = date('Y-m-d H:i:s');
                $modelBuang->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
                $modelBuang->create_ruangan = Yii::app()->user->getState('ruangan_id');
                $modelBuang->validate();
                if($modelBuang->save()){
                    $mod = BatalkantongdarahT::model()->findByAttributes(array('kantongdarah_id' => $id));
                    KantongdarahT::model()->updateByPk($id, array('batalkantongdarah_id' => $mod->batalkantongdarah_id));//, 'pendonor_id'=>null, 'daftarpendonor_id'=>null
                    if (Yii::app()->request->isAjaxRequest)
                    {
                        echo CJSON::encode(array(
                            'status'=>'proses_form', 
                            'div'=>"<div class='flash-success'>Pembuangan berhasil disimpan.</div>",
                            ));
                        exit;
                    }
                } else{
                    if (Yii::app()->request->isAjaxRequest)
                    {
                        echo CJSON::encode(array(
                            'status'=>'gagal_form', 
                            'div'=>"<div class='flash-danger'>Pembuangan gagal disimpan.</div>",
                            ));
                        exit;
                    }
                }
            }
            else{
                    throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
            }
        }
}