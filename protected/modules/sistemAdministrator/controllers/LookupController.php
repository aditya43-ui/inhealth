<?php

class LookupController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $lookupTersimpan = true;
  public $path_tips = 'sistemAdministrator.views.tips.';
  public $path_view = 'sistemAdministrator.views.lookup.';

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
    $model = new SALookupM;
    $modDetail = new SALookupM;
    if (isset($_POST['SALookupM'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $this->simpanLookup($_POST['lookup_type'], $_POST['SALookupM']);
        if ($this->lookupTersimpan) {
          $transaction->commit();
          $this->redirect(array('admin', 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!');
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!' . MyExceptionMessage::getMessage($exc));
      }
    }
    $this->render($this->path_view . 'create', array(
      'model' => $model,
      'modDetail' => $modDetail
    ));
  }

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    $model = $this->loadModel($id);
    $modDetail = new SALookupM;
    if (isset($_POST['SALookupM'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $this->updateLookup($_POST['lookup_type'], $_POST['SALookupM']);
        //                echo "<pre>";
        //				print_r($_POST['SALookupM']);exit;
        if ($this->lookupTersimpan) {
          $transaction->commit();
          $this->redirect(array('admin', 'sukses' => 1));
        } else {
          $transaction->rollback();
          echo "hahah";
          exit();
          Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!');
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        echo "string";
        exit();
        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!' . MyExceptionMessage::getMessage($exc));
      }
    }

    $this->render($this->path_view . 'update', array(
      'model' => $model,
      'modDetail' => $modDetail
    ));
  }

  /**
   * Memanggil dan menonaktifkan status 
   */
  public function actionNonActive($id)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['sukses'] = 0;
      $model = $this->loadModel($id);
      // set non-active this
      // example: 
      $model->lookup_aktif = 0;
      if ($model->save()) {
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
  public function actionDelete($id)
  {
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      $data['sukses'] = 0;
      $data['pesan'] = "Data gagal dihapus!";
      $transaction = Yii::app()->db->beginTransaction();
      try {
        if ($this->loadModel($id)->delete()) {
          $data['sukses'] = 1;
          $data['pesan'] = "Data berhasil dihapus!";
          $transaction->commit();
        } else {
          $transaction->rollback();
          $data['sukses'] = 0;
          $data['pesan'] = "Data gagal dihapus karna sudah digunakan di tabel lain!";
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $data['sukses'] = 0;
        $data['pesan'] = "Data gagal dihapus karna sudah digunakan di tabel lain!";
      }
      echo CJSON::encode($data);
      Yii::app()->end();

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
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
    $this->pageTitle = Yii::app()->name . " - Master Lookup";
    $model = new SALookupM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SALookupM']))
      $model->attributes = $_GET['SALookupM'];

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

  public function simpanLookup($lookup_type, $post)
  {
    foreach ($post as $i => $lookup) {
      if (empty($lookup['lookup_id'])) {
        $model = new SALookupM;
        $model->attributes = $lookup;
        $model->lookup_type = $lookup_type;

        if (!$model->save()) {
          $this->lookupTersimpan &= false;
        }
      }
    }
  }

  public function updateLookup($lookup_type, $post)
  {
    foreach ($post as $i => $lookup) {

      if (!empty($lookup['lookup_id'])) {
        $model = new SALookupM;
        $model->attributes = $lookup;
        $model->lookup_type = $lookup_type;
        SALookupM::model()->updateByPk($lookup['lookup_id'], array(
          'lookup_name' => $model->lookup_name,
          'lookup_value' => $model->lookup_value,
          'lookup_kode' => $model->lookup_kode,
          'lookup_urutan' => $model->lookup_urutan,
          'lookup_aktif' => $model->lookup_aktif
        ));
      } else {
        $model = new SALookupM;
        $model->attributes = $lookup;
        $model->lookup_type = $lookup_type;
        $model->lookup_aktif = true;
        $model->save();
      }
    }
  }

  public function actionPrint()
  {
    $model = new SALookupM;
    $model->attributes = $_REQUEST['SALookupM'];
    if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_APOTEK) {
      $judulLaporan = 'Data Etiket';
    } else {
      $judulLaporan = 'Data SALookupM';
    }
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
      $mpdf->Output();
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
          $data['form'] .= $this->renderPartial($this->path_view . '_rowLookup', array('model' => $model), true);
        }
      } else {
        $data['form'] .= $this->renderPartial($this->path_view . '_rowLookup', array('model' => $model), true);
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    }
  }

  private function loadModelByType($lookup_type)
  {
    $model = SALookupM::model()->findAllByAttributes(array('lookup_type' => $lookup_type), array('order' => 'lookup_urutan'));
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }
}
