<?php
class EarlyWarningScoreController extends MyAuthController
{
    public $layout='//layouts/column1';
    public $defaultAction = 'index';
    public $path_view = 'rawatDarurat.views.earlyWarningScore.';
    public $tersimpan = false;
    
    public function actionIndex($pendaftaran_id)
    {
        // if(!empty($_GET['frame'])){
            $this->layout = "//layouts/iframe";
        // }
        
        $modPendaftaran = RDPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
        $modPasien = RDPasienM::model()->findByPk($modPendaftaran->pasien_id);
        
        $model = new RDEwspasienT();
        $modDetail = new RDEwspasiendetT();
        $model->tanggalpengkajian = date('d M Y H:i:s');

        $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $model->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;
        $pegDpjp_id = $modPendaftaran->pegawai_id;
        
        if(!empty($modPendaftaran->pasienadmisi_id)){
            $modPasienadmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);
            
            if(isset($modPasienadmisi)){
                $pegDpjp_id = $modPasienadmisi->pegawai_id;
            }
        }
        $model->dpjp_id = $pegDpjp_id;
        
        
        if(isset($_POST['RDEwspasienT'])){
            $transaction = Yii::app()->db->beginTransaction();
           
            try {
                 $model->attributes = $_POST['RDEwspasienT'];
                 $model->tanggalpengkajian = MyFormatter::formatDateTimeForDb($_POST['RDEwspasienT']['tanggalpengkajian']);
                 $model->nilaikritik_laboratorium = isset($_POST['RDEwspasienT']['nilaikritik_laboratorium']) ? $_POST['RDEwspasienT']['nilaikritik_laboratorium'] : '' ;
                 $model->nilaikritik_radiologi = isset($_POST['RDEwspasienT']['nilaikritik_radiologi']) ? $_POST['RDEwspasienT']['nilaikritik_radiologi'] : '' ;
                 
                if(!empty($model->ewspasien_id)){
                    $model->update_time = date('Y-m-d H:i:s');
                    $model->update_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                }else{
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->create_loginpemakai = Yii::app()->user->getState("nama_pegawai");
                }
                $model->create_ruangan_id = Yii::app()->user->getState("ruangan_id");
                $model->create_petugaspengisi_id = Yii::app()->user->getState("pegawai_id");
                
                $tersimpandetail = true;
                
                if($model->save()){
                    $this->tersimpan = true;
                    
                    if(count($_POST['RDEwspasiendetT']) > 0){
                        foreach ($_POST['RDEwspasiendetT'] as $dataDet){
                            if(!empty($dataDet['hasipenilaian_text'])){
                                $modelDet = new RDEwspasiendetT();
                                $modelDet->ewspasien_id = $model->ewspasien_id;
                                $modelDet->hasipenilaian = $dataDet['hasipenilaian_text'];
                                $modelDet->skorpenilaian = $dataDet['skorpenilaian'];
                                $modelDet->nourut = $dataDet['nourut'];

                                if(!$modelDet->save()){
                                     $tersimpandetail = false;
                                }
                            }
                        }
                    }
                }else{
                    $this->tersimpan = false;
                }
                
               if($this->tersimpan == true && $tersimpandetail == true){
                    $transaction->commit();
                    $this->redirect(array('index','pendaftaran_id'=>$model->pendaftaran_id,'type'=>(!empty($_GET['type'])?$_GET['type']:""),'frame'=>(!empty($_GET['frame'])?$_GET['frame']:""),'sukses'=>1));
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
            'modDetail'=>$modDetail
        ));
    }
	
        
    public function actionHapusEws(){ 
        if(Yii::app()->request->isPostRequest)
        {
            $id = $_POST['id'];
            $pendaftaranId = $_POST['pendaftaran_id'];

                
            $deleteDetail = EwspasiendetT::model()->deleteAllByAttributes(array('ewspasien_id'=>$id));
            $deleteData = EwspasienT::model()->deleteByPk($id);
            
            $message = "";
            $sukses = 0;
            
            if($deleteDetail && $deleteData){
                $message = "Data Berhasil Dihapus!";
                $sukses = 1;
            }else{
                $message = "Data gagal Dihapus!";
                $sukses = 0;
            }
            
            echo CJSON::encode(array(
                    'sukses'=> $sukses, 
                    'msg'=>$message,
                    ));
            exit;   
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }    
        
    public function actionPrint($ewspasien_id, $pendaftaran_id) 
    {
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = EwspasienT::model()->findByPk($ewspasien_id);
        $modDetail = EwspasiendetT::model()->findAllByAttributes(array('ewspasien_id'=>$ewspasien_id));
        
            
        $this->layout='//layouts/printWindows';
        $this->render($this->path_view.'Print',array('model'=>$model,'modPendaftaran'=>$modPendaftaran,'modDetail'=>$modDetail,'modPasien'=>$modPasien)); 
    } 
    
    public function actionDetailEws($pendaftaran_id, $ewspasien_id) 
    {
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $model = EwspasienT::model()->findByPk($ewspasien_id);
        $modDetail = EwspasiendetT::model()->findAllByAttributes(array('ewspasien_id'=>$ewspasien_id));
            
        $this->layout='//layouts/iframe';
        $this->render($this->path_view.'_detailEws',array('model'=>$model,'modPendaftaran'=>$modPendaftaran,'modDetail'=>$modDetail)); 
    } 
}
