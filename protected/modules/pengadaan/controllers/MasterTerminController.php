<?php
/**
* digunakan untuk Master termin
* @author Yudhit Widy Wicaksono <yudhitwicaksono@.com>
* @package application.modules.pengadaan
* @subpackage controllers
**/
class MasterTerminController extends MyAuthController {
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $defaultAction = 'admin';
    public $path_view = 'pengadaan.views.masterTermin.';
    public $path_tips = 'pengadaan.views.tips.';
    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $this->render($this->path_view.'view',array(
            'model'=>$this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                                             
        $model=new LookupM;
        $model->lookup_type = 'jenistermin';

        if (isset($_POST['LookupM'])) {

            $valid = true;
            foreach ($_POST['LookupM'] as $i => $item) {
                if (is_integer($i)) {
                    $model = new LookupM;
                    if (isset($_POST['LookupM'][$i])){
                        $model->attributes = $_POST['LookupM'][$i];
                        $model->create_ruangan	= Yii::app()->user->getState('ruangan_id');
                        $model->create_loginpemakai_id = Yii::app()->user->id;
                        $model->create_time = date('Y-m-d H:i:s');
                    }
                    $model->lookup_type = $_POST['LookupM']['lookup_type'];
                    $model->lookup_aktif = true;
                    $valid = $model->validate() && $valid;

                    if ($valid) {
                        $model->save();
                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    } else {
                        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data tidak valid.');
                    }
                }
            }
            $this->redirect(array('admin'));
        }   

        $this->render($this->path_view.'create',array(
                'model'=>$model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
  //   public function actionUpdate($id)
  //   {
  //               //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                                                        
		// $model=$this->loadModel($id);
  //               $model->lookup_type = Satuanbarang::namaType();

		// // Uncomment the following line if AJAX validation is needed
		// 

		// if(isset($_POST['SALookupM']))
  //                   {
  //                       $valid=true;
  //                       foreach($_POST['SALookupM'] as $i=>$item)
  //                       {
  //                           if(is_integer($i)) {
  //                               $model=new LookupM;
  //                               if(isset($_POST['SALookupM'][$i]))
  //                                   if ($_POST['SALookupM'][$i]['lookup_id'] == 0){
  //                                       $_POST['SALookupM'][$i]['lookup_id'] = null;
  //                                   }
  //                                   $model->attributes=$_POST['SALookupM'][$i];
  //                                   if ((!empty($_POST['SALookupM'][$i]['lookup_id']))||(($_POST['SALookupM'][$i]['lookup_id']) != 0)){
  //                                       LookupM::model()->deleteByPk($_POST['SALookupM'][$i]['lookup_id']);
  //                                       $model->lookup_id = $_POST['SALookupM'][$i]['lookup_id'];
  //                                   }
                                    
  //                                   //$model->lookup_id = $_POST['LookupM']['lookup_id'];
  //                                   $model->lookup_type = $_POST['SALookupM']['lookup_type'];
  //                                   $model->lookup_aktif = true;
  //                                   $valid=$model->validate() && $valid;
  //                                   echo $i;
  //                               if($valid) {
  //                                   $model->save();
  //                                       Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
  //                               } else {
  //                                       Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data tidak valid.');
  //                               }
  //                           }
  //                       }
  //                       $this->redirect(array('admin'));
  //                     }   

		// $this->render('update',array(
		// 	'model'=>$model,
		// ));
  //   }
    private function validasiTabular($postarray,$insert){
        $models = null;
        if(empty($insert)){     
            if (count($postarray) > 0){
                foreach ($postarray as $key => $value) {
                    if (is_integer($key)){
                        $models[$key] = new LookupM();
                        $models[$key]->attributes = $value;
                        $models[$key]->lookup_type = $postarray['lookup_type'];
                        $models[$key]->validate();
                    }
                }
            }
        }else{
            if(count($postarray > 0)){ 
                foreach ($postarray as $key => $value) {
                    //if(is_integer($key)){
//                        $models[$key] = new LookupM('update'); ini juga bisa
                        if (empty($postarray['lookup_id'])){
                            $models[$key] = new LookupM();
                            $models[$key]->attributes = $value;
                            $models[$key]->lookup_id = null;
                            $models[$key]->lookup_type = $_POST['ADLookupM']['lookup_type'];
                            $models[$key]->validate();
                        }else{
                            $models[$key] = LookupM::model()->findByPk($postarray['lookup_id']);
                            $models[$key]->lookup_type = $postarray['lookup_type'];
                            $models[$key]->attributes = $value;
                        }
                    //}
                }
            }
        }
        return $models;
    }
    
    /**
     * Memanggil dan Mengubah sebagian data.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                                                        
        $model=$this->loadModel($id);
                
                $modLookup = LookupM::model()->findAllByAttributes(array('lookup_type'=>$model->lookup_type));
        // Uncomment the following line if AJAX validation is needed
        
                
        if(isset($_POST['ADLookupM']))
        { 
			$insert = 1;
            $transaction = Yii::app()->db->beginTransaction();
            try {
				$model->attributes = $_POST['ADLookupM'];
                if($model->validate()){
					$model->save();
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                    $this->redirect(array('admin'));
                }else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data tidak valid.');
                }

            }  catch (Exception $exc){
                $transaction->rollback();
                 Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data tidak valid.'.MyExceptionMessage::getMessage($exc));
            }
        }

        $this->render($this->path_view.'update',array(
            'model'=>$model,
            'modLookup'=>$modLookup
        ));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider=new CActiveDataProvider('ADLookupM');
        $this->render($this->path_view.'index',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new ADLookupM('search');
        $model->lookup_type = 'jenistermin';
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['ADLookupM']))
            $model->attributes=$_GET['ADLookupM'];

        $this->render($this->path_view.'admin',array(
            'model'=>$model,
        ));
    }

    

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model=ADLookupM::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='adlookup-m-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    if(Yii::app()->request->isPostRequest)
    {
      $id = $_POST['id'];
            $this->loadModel($id)->delete();
            if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        'div'=>"<div class='flash-success'>Data berhasil dihapus.</div>",
                        ));
                    exit;
                }
                      
      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if(!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }
    else
      throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
  }

     /**
     *Mengubah status aktif
     * @param type $id 
     */
    public function actionRemoveTemporary()
    {
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
//                    SAPropinsiM::model()->updateByPk($id, array('propinsi_aktif'=>false));
//                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
              
        
        $id = $_POST['id'];   
        if(isset($_POST['id']))
        {
           $update = LookupM::model()->updateByPk($id,array('lookup_aktif'=>false));
           if($update)
            {
                if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        ));
                    exit;               
                }
             }
        } else {
                if (Yii::app()->request->isAjaxRequest)
                {
                    echo CJSON::encode(array(
                        'status'=>'proses_form', 
                        ));
                    exit;               
                }
        }

    }
    /**
     * Mencetak data
     */
        public function actionPrint()
        {
            $model= new ADLookupM;
            $model->attributes=$_REQUEST['ADLookupM'];
            $judulLaporan='Data Termin';
            $caraPrint=$_REQUEST['caraPrint'];
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
                $this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($caraPrint=='EXCEL') {
                $this->layout='//layouts/printExcel';
                $this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($_REQUEST['caraPrint']=='PDF') {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF('',$ukuranKertasPDF); 
                $mpdf->useOddEven = 2;  
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet,1);  
                $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan,  'periode'=> "", 'colspan'=>10),true));
                $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 55, 20, 15, 15);
                $mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
                $mpdf->Output($judulLaporan.'-'.date("Y/m/d").'.pdf', 'I');
            }                       
        }
}