<?php
/**
    * @author          YusufPutraAnugrah<yusufputra@.com>
    * @version         2.0.0
    * @documentation   http://kbase..com
    * @issue           RSST-1341
    * - digunakan inv tab kalibrasi  
    */

class InfoKalibrasiTController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/iframe';
	public $defaultAction = 'index';
	public $path_view = 'manajemenAset.views.infoKalibrasiT.';
        public $init = '';          
    
        public function actionIndex($id)
        {   
            $model = new MAInvkalibarasiT();
            $model->tglkalibrasi = date('Y-m-d H:i:s');
            $model->berlaku_sdtgl = date('Y-m-d');
            $format = new MyFormatter();
            $modRiwayatKalibarasi = new MAInvkalibarasiT;
            $modRiwayatKalibarasi->invperalatan_id=$id;
            
            if(isset($_POST['MAInvkalibarasiT']))
            {
                 $ok = true;
                $transaction = Yii::app()->db->beginTransaction();
                try {                    
                    $model->attributes = $_POST['MAInvkalibarasiT'];
                    $model->invperalatan_id=$id;
                    $model->tglkalibrasi = $format->formatDateTimeForDb($_POST['MAInvkalibarasiT']['tglkalibrasi']);
                    $model->berlaku_sdtgl = $format->formatDateTimeForDb($_POST['MAInvkalibarasiT']['berlaku_sdtgl']);
                    $model->create_time = date('Y-m-d H:i:s');
                    $model->supplier_id =intval($_POST['MAInvkalibarasiT']['supplier_id']);
		    $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
		    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                    $model->lampiran_berkas = CUploadedFile::getInstance($model, 'lampiran_berkas');
                    $random = date('YmdHis');
                    $file = $model->lampiran_berkas;
                    $model->lampiran_berkas = strtolower(str_replace(" ","_",$random .$model->lampiran_berkas));
                   
                        if (!empty($model->lampiran_berkas)){											
                          
                          $fileName = $model->lampiran_berkas;   
                          $filePath = Params::pathPegawaiFileDirectory().$fileName;
                          
                          $file->saveAs($filePath);
                        }
                   
                    $ok = $ok && $model->save();                                                          
                    if($ok){
                        
                        $transaction->commit();
                        Yii::app()->user->setFlash('success',"Data Berhasil Disimpan");
                        $this->redirect(array('index','id'=>$id,'sukses'=>1));       
                    }else{
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data gagal disimpan ".CHtml::errorSummary($model));
                    }
                } catch (Exception $exc) {
                    var_dump($exc->getMessage());die;
                    $transaction->rollback();
                    
                    Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
                }
            }
            $this->render($this->path_view.'index',array(
                'model'=>$model,
                'modRiwayatKalibarasi'=>$modRiwayatKalibarasi,
                'format'=>$format, 
            ));
        }
         
         public function loadModel($id)
	{
		$model=InvkalibarasiT::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
        
        
       
      
}
