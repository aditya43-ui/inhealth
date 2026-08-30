<?php

class JenisBahanMakananController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public $defaultAction = 'admin';
  public $path_view = 'gizi.views.lookupM.';
  public $path_tips = 'gizi.views.tips.';

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
    $model = new GZLookupM;
    $model->lookup_type = 'jenisbahanmakanan';
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['GZLookupM'])) {
      // var_dump($_POST['GZLookupM']);die;
      $valid = true;
      foreach ($_POST['GZLookupM'] as $i => $item) {

        if (is_integer($i)) {
          $model = new GZLookupM;
          if (isset($_POST['GZLookupM'][$i]))

            $model->attributes = $_POST['GZLookupM'][$i];
          $model->lookup_type = $_POST['GZLookupM']['lookup_type'];
          $model->lookup_aktif = true;
          $valid = $model->validate() && $valid;
          echo $i;
          if ($valid) {
            $model->save();
            Yii::app()->user->setFlash('success', 'Data berhasil disimpan.');
          } else {
            Yii::app()->user->setFlash('error', "Data gagal disimpan");
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
            $models[$key] = new GZLookupM();
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
            $models[$key] = new GZookupM();
            $models[$key]->attributes = $value;
            $models[$key]->lookup_id = null;
            $models[$key]->lookup_type = $_POST['GZLookupM']['lookup_type'];
            $models[$key]->validate();
          } else {
            $models[$key] = GZLookupM::model()->findByPk($postarray['lookup_id']);
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

    $modLookup = GZLookupM::model()->findAllByAttributes(array('lookup_type' => $model->lookup_type));
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['GZLookupM'])) {
      $insert = 1;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['GZLookupM'];
        if ($model->validate()) {
          $model->save();
          $transaction->commit();
          Yii::app()->user->setFlash('success', 'Data berhasil ' . $model->lookup_name . ' disimpan.');
          $this->redirect(array('admin'));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', 'Data gagal disimpan.' . MyExceptionMessage::getMessage($exc));
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
    $dataProvider = new CActiveDataProvider('GZLookupM');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $model = new GZLookupM('search');
    $model->lookup_type = 'jenisbahanmakanan';
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['GZLookupM']))
      $model->attributes = $_GET['GZLookupM'];
    $model->lookup_type = 'jenisbahanmakanan';

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
    $model = GZLookupM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'gzlookup-m-form') {
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
      $update = GZLookupM::model()->updateByPk($id, array('lookup_aktif' => false));
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
    $model = new GZLookupM;
    $model->attributes = $_REQUEST['GZLookupM'];
    $judulLaporan = 'Data Lookup Jenis Bahan Makanan';
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

      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 45, 30, 15, 15);

      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '-' . date("Y/m/d") . '.pdf', 'I');
    }
  }
}
