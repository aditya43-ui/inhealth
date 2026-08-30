<?php

class PemeriksaanRadMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $this->render('view', array(
      'model' => $this->loadModel($id),
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = new SAPemeriksaanRadM;
    $modReferensiHasil = new SAReferensiHasilRadM;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SAPemeriksaanRadM'])) {
      $transaction = Yii::app()->db->beginTransaction();

      $model->attributes = $_POST['SAPemeriksaanRadM'];
      $modReferensiHasil->attributes = $_POST['SAReferensiHasilRadM'];
      $validModel = $model->validate();
      $validReferensi = $modReferensiHasil->validate();
      if ($validModel && $validReferensi) {
        try {

          if ($model->save()) {

            $modReferensiHasil->save();
          }
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Pemeriksaan " . $model->pemeriksaanrad_nama . " berhasil disimpan");
          $this->redirect(array('admin', 'id' => $model->pemeriksaanrad_id));
        } catch (Exception $e) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan");
        }
      }
    }

    $this->render('create', array(
      'model' => $model,
      'modReferensiHasil' => $modReferensiHasil,
    ));
  }

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = $this->loadModel($id);
    $modReferensiHasil = SAReferensiHasilRadM::model()->findByAttributes(array('pemeriksaanrad_id' => $model->pemeriksaanrad_id, 'refhasilrad_aktif' => true));
    if (empty($modReferensiHasil))
      $modReferensiHasil = new SAReferensiHasilRadM;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SAPemeriksaanRadM'])) {
      $model->attributes = $_POST['SAPemeriksaanRadM'];
      $modReferensiHasil->attributes = $_POST['SAReferensiHasilRadM'];
      $modReferensiHasil->pemeriksaanrad_id = $model->pemeriksaanrad_id;
      $validModel = $model->validate();
      $validReferensi = $modReferensiHasil->validate();
      if ($validModel && $validReferensi) {
        $model->save();
        $modReferensiHasil->save();

        Yii::app()->user->setFlash('success', "Data Asesmen Gizi Item " . $model->pemeriksaanrad_nama . " berhasil disimpan");
        $this->redirect(array('admin', 'id' => $model->pemeriksaanrad_id));
      } else {
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
      }
    }

    $this->render('update', array(
      'model' => $model,
      'modReferensiHasil' => $modReferensiHasil,
    ));
  }

  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  // public function actionDelete($id)
  // {
  // 	if(Yii::app()->request->isPostRequest)
  // 	{
  // 		// we only allow deletion via POST request
  //                        //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator
  //                 $transaction = Yii::app()->db->beginTransaction();
  //                    try 
  //                    {
  //                        $mod = ReferensihasilradM::model()->findAllByAttributes(array('pemeriksaanrad_id'=>$id));
  //                        if(count((array)$mod)>0){
  //                        	$deleterad = ReferensihasilradM::model()->deleteAllByAttributes(array('pemeriksaanrad_id'=>$id));
  //                        }
  //                     $deletepem = PemeriksaanradM::model()->deleteByPk($id);
  //                     $transaction->commit();
  //                     echo "{aksi:sukses}";
  //                    }
  //                    catch (Exception $e)
  //                     {
  //                          $transaction->rollback();
  //                          echo "{aksi:gagal}";
  //                     }     
  // 		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
  // 		// if(!isset($_GET['ajax']))
  // 		// 	$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  // 	}
  // 	else
  // 		throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
  // }

  public function actionDelete()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    if (Yii::app()->request->isPostRequest) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $id = $_POST['id'];
        $this->loadModel($id)->delete();
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'sukses',
          ));
          $transaction->commit();
          exit;
        }

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
          $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
      } catch (Exception $e) {
        $transaction->rollback();
        echo CJSON::encode(array(
          'status' => 'gagal',
        ));
      }
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
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
    if (isset($_POST['id'])) {
      $update = PemeriksaanradM::model()->updateByPk($id, array('pemeriksaanrad_aktif' => false));
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

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('SAPemeriksaanRadM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $this->pageTitle = Yii::app()->name . " - Pemeriksaan Radiologi";
    $model = new SAPemeriksaanRadM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SAPemeriksaanRadM'])) {
      $model->attributes = $_GET['SAPemeriksaanRadM'];
      $model->daftartindakan_nama = $_GET['SAPemeriksaanRadM']['daftartindakan_nama'];
    }
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
    $model = SAPemeriksaanRadM::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sapemeriksaan-rad-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   *Mengubah status aktif
   * @param type $id 
   */
  //         public function actionRemoveTemporary($id)
  // 	{
  //                 //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
  //                 SAPemeriksaanRadM::model()->updateByPk($id, array('pemeriksaanrad_aktif'=>false));               
  // //SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
  //                 $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  // 	}

  public function actionPrint()
  {
    $model = new SAPemeriksaanRadM;
    $model->unsetAttributes();  // clear any default values

    // $model->attributes=$_REQUEST['PemeriksaanradM'];
    if (isset($_GET['SAPemeriksaanRadM']))
      $model->attributes = $_GET['SAPemeriksaanRadM'];
    $model->daftartindakan_nama = $_GET['SAPemeriksaanRadM']['daftartindakan_nama'];
    $judulLaporan = 'Data Pemeriksaan Radiologi';
    $caraPrint = $_REQUEST['caraPrint'];
    if (isset($_GET['SAPemeriksaanRadM']))
      $model->attributes = $_GET['SAPemeriksaanRadM'];
    $model->daftartindakan_nama = $_GET['SAPemeriksaanRadM']['daftartindakan_nama'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
