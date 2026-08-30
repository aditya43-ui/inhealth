<?php

class BankLookupController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe'; //diakses dari tab menu master - master obat
  //    public $layout='//layouts/column1';
  public $defaultAction = 'admin';
  public $lookupTersimpan = true;
  public $path_view = 'keuangan.views.bankLookup.';

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
    	$model=new KULookupM;
        $model->lookup_type ="bank";
        $model->lookup_kode = MyGenerator::lookupkodebankpasien();

        if(isset($_POST['KULookupM']))
        {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $this->simpanLookup($_POST['lookup_type'],$_POST['KULookupM']);
                if ($this->lookupTersimpan){
                    $transaction->commit();
                   Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                    $this->redirect(array('admin','sukses'=>1));
                }else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!');
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!'.MyExceptionMessage::getMessage($exc));
            }
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
    public function actionUpdate($id)
    {
		$model=$this->loadModel($id);
        $modDetail=new KULookupM;
        if(isset($_POST['KULookupM']))
        {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $model->attributes = $_POST['KULookupM'];

		if ($model->save()){
                    $transaction->commit();
                    Yii::app()->user->setFlash('success', "Data berhasil disimpan");
                    $this->redirect(array('admin','sukses'=>1));
                }else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!');
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!'.MyExceptionMessage::getMessage($exc));
            }
        }

		$this->render($this->path_view.'update',array(
			'model'=>$model,
            'modDetail'=>$modDetail
		));
    }

    /**
     * Memanggil dan menonaktifkan status
     */
    public function actionNonActive($id)
    {
            if(Yii::app()->request->isAjaxRequest)
            {
                    $data['sukses'] = 0;
                    $model = $this->loadModel($id);
                    // set non-active this
                    // example:
                     $model->lookup_aktif = 0;
                     if($model->save()){
                            $data['sukses'] = 1;
                     }
                    echo CJSON::encode($data);
            }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    // public function actionDelete()
    // {
    //         //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //   if(Yii::app()->request->isPostRequest)
    //   {
    //     $id = $_POST['id'];
    //     $this->loadModel($id)->delete();
    //     if (Yii::app()->request->isAjaxRequest)
    //         {
    //             echo CJSON::encode(array(
    //                 'status'=>'proses_form',
    //                 'div'=>"<div class='flash-success'>Data berhasil dihapus.</div>",
    //                 ));
    //             exit;
    //         }

    //     if ($model->save()) {
    //       // $transaction->commit();
    //       Yii::app()->user->setFlash('success', "Data " . $model->lookup_name . " berhasil disimpan");
    //       $this->redirect(array('admin', 'sukses' => 1));
    //     } else {
    //       // $transaction->rollback();
    //       Yii::app()->user->setFlash('error', 'Data gagal disimpan!');
    //     }
    //   } 
    // }
    

    /**
     * Manages all models.
     */
    // public function actionAdmin()
    // {

    //     $model=new KULookupM('search');
    //     $model->lookup_type = 'bank';
    //     $model->unsetAttributes();  // clear any default values
    //     if(isset($_GET['KULookupM']))
    //         $model->attributes=$_GET['KULookupM'];

    //     $this->render($this->path_view.'admin',array(
    //         'model'=>$model,
    //     ));
    // }
  

  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    if (Yii::app()->request->isPostRequest) {
      $id = $_POST['id'];
      $this->loadModel($id)->delete();
      if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(array(
          'status' => 'proses_form',
          'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
        ));
        exit;
      }

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new KULookupM('search');
    $model->lookup_type = 'bank';
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['KULookupM']))
      $model->attributes = $_GET['KULookupM'];

    $this->render('admin', array(
      'model' => $model,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = KULookupM::model()->findByPk($id);
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'salookup-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

    public function simpanLookup($lookup_type, $post){
        foreach ($post as $i => $lookup) {
            if(empty($lookup['lookup_id'])){
                $model= new KULookupM;
                $model->attributes = $lookup;
                $model->lookup_type = $lookup_type;

                if(!$model->save()){
                    $this->lookupTersimpan &= false;
                }
            }
        }
      }
    

    public function updateLookup($lookup_type, $post){
        foreach ($post as $i => $lookup) {

            if(!empty($lookup['lookup_id'])){
                $model= new KULookupM;
                $model->attributes = $lookup;
                $model->lookup_type = $lookup_type;
                KULookupM::model()->updateByPk($lookup['lookup_id'],array(
                    'lookup_name'=>$model->lookup_name,
                    'lookup_value'=>$model->lookup_value,
                    'lookup_kode'=>$model->lookup_kode,
                    'lookup_urutan'=>$model->lookup_urutan,
                    'lookup_aktif'=>$model->lookup_aktif
                ));
            } else {
                $model= new KULookupM;
                $model->attributes = $lookup;
                $model->lookup_type = $lookup_type;
                $model->lookup_aktif = true;
                $model->save();
            }
        }
    }

    public function actionPrint()
    {
        $model= new KULookupM;

        if(isset($_REQUEST['KULookupM'])){
            $model->attributes=$_REQUEST['KULookupM'];
            $judulLaporan='Data Bank Pasien';
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
                $mpdf = new MyPDF60('',$ukuranKertasPDF);
                ////$mpdf->useOddEven = 2;
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet,1);
                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                $mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
                $mpdf->Output();
            }
        }
    }

  public function actionGetLookup()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $model = new SALookupM;
      $data['form'] = "";
      $models = $this->loadModelByType($_POST['lookup_type']);
      if (count((array)$models) > 0) {
        foreach ($models as $i => $model) {
          $data['form'] .= $this->renderPartial('_rowLookup', array('model' => $model), true);
        }
      } else {
        $data['form'] .= $this->renderPartial('_rowLookup', array('model' => $model), true);
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    }
  }

    private function loadModelByType($lookup_type){
        $model = SALookupM::model()->findAllByAttributes(array('lookup_type'=>$lookup_type),array('order'=>'lookup_urutan'));
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    // public function actionRemoveTemporary()
    // {
    //             //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //             //SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
    //             //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		// 	 $id = $_POST['id'];
    //     if(isset($_POST['id']))
    //     {
    //        $update = KULookupM::model()->updateByPk($id,array('lookup_aktif'=>false));
    //        if($update)
    //         {
    //             if (Yii::app()->request->isAjaxRequest)
    //             {
    //                 echo CJSON::encode(array(
    //                     'status'=>'proses_form',
    //                     ));
    //                 exit;
    //             }
    //          }
    //     } else {
    //             if (Yii::app()->request->isAjaxRequest)
    //             {
    //                 echo CJSON::encode(array(
    //                     'status'=>'proses_form',
    //                     ));
    //                 exit;
    //             }
    //     }
    //   }

  public function actionRemoveTemporary()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
    //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    $id = $_POST['id'];
    if (isset($_POST['id'])) {
      $update = KULookupM::model()->updateByPk($id, array('lookup_aktif' => false));
      if ($update) {
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
          ));
          exit;
        }
      }
    } else {
      if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(array(
          'status' => 'proses_form',
        ));
        exit;
      }
    }
  }
}
