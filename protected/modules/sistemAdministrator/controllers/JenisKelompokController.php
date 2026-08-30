<?php

class JenisKelompokController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.jenisKelompok.';
  public $path_tips = 'sistemAdministrator.views.tips.';

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $this->render($this->path_view . 'view', array(
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
    $model = new SALookupM();
    $model->lookup_type = 'jnskelompok';
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SALookupM'])) {
      // var_dump($_POST['GZLookupM']);die;
      $valid = true;
      foreach ($_POST['SALookupM'] as $i => $item) {

        if (is_integer($i)) {
          $model = new SALookupM;
          if (isset($_POST['SALookupM'][$i]))

            $model->attributes = $_POST['SALookupM'][$i];
          $model->lookup_type = $_POST['SALookupM']['lookup_type'];
          $model->lookup_aktif = true;
          $valid = $model->validate() && $valid;
          echo $i;
          if ($valid) {
            $model->save();
            Yii::app()->user->setFlash('success', ' Data ' . $model->lookup_name . ' berhasil disimpan.');
          } else {
            Yii::app()->user->setFlash('error', ' Data gagal disimpan.');
          }
        }
      }
      $this->redirect(array('admin'));
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model,
    ));
  }


  private function validasiTabular($postarray, $insert)
  {
    $models = null;
    if (empty($insert)) {
      if (count((array)$postarray) > 0) {
        foreach ($postarray as $key => $value) {
          if (is_integer($key)) {
            $models[$key] = new SALookupM();
            $models[$key]->attributes = $value;
            $models[$key]->lookup_type = $postarray['lookup_type'];
            $models[$key]->validate();
          }
        }
      }
    } else {
      if (count((array)$postarray > 0)) {
        foreach ($postarray as $key => $value) {
          //if(is_integer($key)){
          //                        $models[$key] = new LookupM('update'); ini juga bisa
          if (empty($postarray['lookup_id'])) {
            $models[$key] = new SALookupM();
            $models[$key]->attributes = $value;
            $models[$key]->lookup_id = null;
            $models[$key]->lookup_type = $_POST['SALookupM']['lookup_type'];
            $models[$key]->validate();
          } else {
            $models[$key] = SALookupM::model()->findByPk($postarray['lookup_id']);
            $models[$key]->lookup_type = $postarray['lookup_type'];
            $models[$key]->attributes = $value;
          }
          //}
        }
      }
    }
    return $models;
  }

  public function actionUpdate($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                                                        
    $model = $this->loadModel($id);

    $modLookup = SALookupM::model()->findAllByAttributes(array('lookup_type' => $model->lookup_type));
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SALookupM'])) {
      $insert = 1;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['SALookupM'];
        if ($model->validate()) {
          $model->save();
          $transaction->commit();
          Yii::app()->user->setFlash('success', 'Data ' . $model->lookup_name . ' berhasil disimpan');
          $this->redirect(array('admin'));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', 'Data gagal disimpan');
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', 'Data gagal disimpan ' . MyExceptionMessage::getMessage($exc));
      }
    }

    $this->render($this->path_view . 'update', array(
      'model' => $model,
      'modLookup' => $modLookup
    ));
  }

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('SALookupM');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $model = new SALookupM('search');
    $model->lookup_type = 'jnskelompok';
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SALookupM']))
      $model->attributes = $_GET['SALookupM'];
    $model->lookup_type = 'jnskelompok';

    $this->render($this->path_view . 'admin', array(
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
    $model = SALookupM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'salookup-m-form') {
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
      $update = SALookupM::model()->updateByPk($id, array('lookup_aktif' => false));
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

  public function actionPrint()
  {
    $model = new SALookupM;
    $model->attributes = $_REQUEST['SALookupM'];
    $judulLaporan = 'Data Jenis Kelompok';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      ////$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 45, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '-' . date("Y/m/d") . '.pdf', 'I');
    }
  }
}
