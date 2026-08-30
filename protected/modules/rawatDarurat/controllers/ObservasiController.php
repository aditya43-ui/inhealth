<?php
class ObservasiController extends MyAuthController
{
    public $layout='//layouts/iframe';
    public $defaultAction = 'index';
    public $path_view = 'rawatDarurat.views.observasi.';
    public $tersimpan = false;
    
    public function actionIndex($pendaftaran_id, $pasienadmisi_id = null, $observasipasienri_id = null)
    {
        $modPendaftaran = RDPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
        
        if(!empty($pasienadmisi_id)){
            $modPasienAdmisi = PasienadmisiT::model()->findByPk($pasienadmisi_id);
        }else {
            $modPasienAdmisi = new PasienadmisiT();
        }
        
        $modPasien = RDPasienM::model()->findByPk($modPendaftaran->pasien_id);
        
        if(!empty($observasipasienri_id)){
            $model = RDObservasipasienriT::model()->findByPk($observasipasienri_id);
            if($model->isobservasi_anakbayi == true){
                $model->isobservasi_anakbayi = 'anak';
            }else{
                $model->isobservasi_anakbayi = 'dewasa';
                $model->tgl_observasi_dewasa = $model->tgl_observasi;
                $model->jam_observasi_dewasa = $model->jam_observasi;
            }
        }else{
            $model = new RDObservasipasienriT();    
        }

        $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $model->pasienadmisi_id = $pasienadmisi_id;
        $model->pasien_id = $modPendaftaran->pasien_id;
        
        if(isset($_POST['RDObservasipasienriT'])){
            $transaction = Yii::app()->db->beginTransaction();
          
            try {
                $model->attributes = $_POST['RDObservasipasienriT'];
                if(!empty($_POST['RDObservasipasienriT']['tgl_observasi'])){
                    $model->tgl_observasi = MyFormatter::formatDateTimeForDb($_POST['RDObservasipasienriT']['tgl_observasi']);
                }
                
                if(isset($_POST['RDObservasipasienriT']['tgl_observasi_dewasa']) && !empty($_POST['RDObservasipasienriT']['tgl_observasi_dewasa'])){
                    $model->tgl_observasi = MyFormatter::formatDateTimeForDb($_POST['RDObservasipasienriT']['tgl_observasi_dewasa']);
                }
                
                if(isset($_POST['RDObservasipasienriT']['jam_observasi_dewasa']) && !empty($_POST['RDObservasipasienriT']['jam_observasi_dewasa'])){
                    $model->jam_observasi = $_POST['RDObservasipasienriT']['jam_observasi_dewasa'];
                }
                if($_POST['RDObservasipasienriT']['isobservasi_anakbayi']=='anak'){
                    $model->isobservasi_anakbayi = 1;
                }else{
                    $model->isobservasi_anakbayi = 0;
                }
                 
                if(!empty($model->observasipasienri_id)){
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                }else{
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                }
                $model->create_ruangan_id = Yii::app()->user->getState("ruangan_id");
                $model->create_petugaspengisi_id = Yii::app()->user->getState("pegawai_id");
                
                if($model->save()){
                    $this->tersimpan = true;
                }else{
                    $this->tersimpan = false;
                }
                
               if($this->tersimpan == true){
                    $transaction->commit();
                    $this->redirect(array('index','pendaftaran_id'=>$pendaftaran_id,'pasienadmisi_id'=>$pasienadmisi_id,'sukses'=>1,'type'=>(!empty($_GET['type'])?$_GET['type']:""),'frame'=>(!empty($_GET['frame'])?$_GET['frame']:"")));
                }else{
                    Yii::app()->user->setFlash('error',"Data gagal disimpan!");
                }  
            } catch (Exception $ex) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($ex,true));
            }
        }
        
        $this->render($this->path_view.'index',array(
            'modPendaftaran'=>$modPendaftaran,
            'modPasien'=>$modPasien,
            'model'=>$model,
            'modPasienAdmisi'=>$modPasienAdmisi
        ));
    }

    public function actionPrint($pendaftaran_id, $pasienadmisi_id = null) 
    {
        $pasienadmisi_id = (!empty($pasienadmisi_id) ? $pasienadmisi_id : null);
        $modPendaftaran = RDPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
        if(!empty($pasienadmisi_id)){
            $modPasienAdmisi = PasienadmisiT::model()->findByPk($pasienadmisi_id);
        }else{
            $modPasienAdmisi = new PasienadmisiT();
        }
        
        $modPasien = RDPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $jenisobservasi = (isset($_GET['jenisobservasi'])? (($_GET['jenisobservasi']=='anak')?true:false) : null);
        $model = ObservasipasienriT::model()->findAllByAttributes(array('isobservasi_anakbayi'=>$jenisobservasi,'pendaftaran_id'=>$pendaftaran_id,'pasienadmisi_id'=>$pasienadmisi_id));
        
        $caraPrint=$_REQUEST['caraPrint'];
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
            $this->render($this->path_view.'Print',array('model'=>$model,'modPendaftaran'=>$modPendaftaran,'modPasienAdmisi'=>$modPasienAdmisi,'modPasien'=>$modPasien,'jenisobservasi'=>$jenisobservasi,'caraPrint'=>$caraPrint));
        }
        else if($caraPrint=='EXCEL')    
        {
            $this->layout='//layouts/printExcel';
            $this->render($this->path_view.'Print',array('model'=>$model,'modPendaftaran'=>$modPendaftaran,'modPasienAdmisi'=>$modPasienAdmisi,'modPasien'=>$modPasien,'jenisobservasi'=>$jenisobservasi,'caraPrint'=>$caraPrint));
        }
        else if($_REQUEST['caraPrint']=='PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');
            $posisi = Yii::app()->user->getState('posisi_kertas');         
            $mpdf = new MyPDF60('', $ukuranKertasPDF);

            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
            $mpdf->WriteHTML($stylesheet,1);  
            $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 55, 20, 15, 15);
            $judulLaporan = "SURAT PERSETUJUAN UMUM";
            $mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('model'=>$model,'modPendaftaran'=>$modPendaftaran,'modPasienAdmisi'=>$modPasienAdmisi,'modPasien'=>$modPasien,'jenisobservasi'=>$jenisobservasi,'caraPrint'=>$caraPrint),true));
            $mpdf->Output($judulLaporan.'-'.date('Y/m/d').'.pdf','I');
        }  
    } 
    
        
    public function actionHapusObservasi(){ 
        if(Yii::app()->request->isPostRequest)
        {
            $observasipasienri_id = $_POST['observasipasienri_id'];
            $jenisobservasi = "";
                
           $model = ObservasipasienriT::model()->findByPk($observasipasienri_id);
            $deletesukses = false;
            
           if(isset($model)){
               if($model->isobservasi_anakbayi == true){
                    $jenisobservasi = 'anak';
                }else{
                    $jenisobservasi = 'dewasa';
                }
                $deletesukses = ObservasipasienriT::model()->deleteByPk($model->observasipasienri_id); 
           }
           
            $message = "";
            $sukses = 0;
            
            if($deletesukses){
                $message = "Data Berhasil Dihapus!";
                $sukses = 1;
            }else{
                $message = "Data gagal Dihapus!";
                $sukses = 0;
            }
            
            echo CJSON::encode(array(
                    'sukses'=> $sukses, 
                    'msg'=>$message,
                    'jenisobservasi'=>$jenisobservasi
                    ));
            exit;   
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }    
}
