<?php

class MonitoringController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';

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
    $model = new RKMonitoringrawatjalanV;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['RKMonitoringrawatjalanV'])) {
      $model->attributes = $_POST['RKMonitoringrawatjalanV'];
      if ($model->save())
        $this->redirect(array('view', 'id' => $model->pasien_id));
    }

    $this->render('create', array(
      'model' => $model,
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

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['RKMonitoringrawatjalanV'])) {
      $model->attributes = $_POST['RKMonitoringrawatjalanV'];
      if ($model->save())
        $this->redirect(array('view', 'id' => $model->pasien_id));
    }

    $this->render('update', array(
      'model' => $model,
    ));
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
      $this->loadModel($id)->delete();

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * Lists all models.
   */
  public function actionRawatjalan()
  {
    $this->pageTitle = Yii::app()->name . " - Monitoring Rawat Jalan";
    $model = new RKMonitoringrawatjalanV('search');
    $model->unsetAttributes();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    if (isset($_GET['RKMonitoringrawatjalanV'])) {
      $format = new MyFormatter();
      $model->tgl_awal  = $format->formatDateTimeForDb($_REQUEST['RKMonitoringrawatjalanV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RKMonitoringrawatjalanV']['tgl_akhir']);
      $model->attributes = $_GET['RKMonitoringrawatjalanV'];
      $model->pegawai_id = $_GET['RKMonitoringrawatjalanV']['pegawai_id'];
    }
    $this->render('indexRawatjalan', array(
      'model' => $model,
    ));
  }

  public function actionRawatdarurat()
  {
    $this->pageTitle = Yii::app()->name . " - Monitoring Rawat Darurat";
    $model = new RKMonitoringrawatdaruratV('search');
    $model->unsetAttributes();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    if (isset($_GET['RKMonitoringrawatdaruratV'])) {
      $format = new MyFormatter();
      $model->attributes = $_GET['RKMonitoringrawatdaruratV'];
      $model->tgl_awal  = $format->formatDateTimeForDb($_REQUEST['RKMonitoringrawatdaruratV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RKMonitoringrawatdaruratV']['tgl_akhir']);
      $model->pegawai_id = $_GET['RKMonitoringrawatdaruratV']['pegawai_id'];
    }

    if(Yii::app()->request->isAjaxRequest){
      if(isset($_GET['ajax']) && $_GET['ajax'] == 'monitoring-v-grid') {
        $this->renderPartial('_tableRawatdarurat', array('model' => $model));
        Yii::app()->end();
      }
    }
    $this->render('indexRawatdarurat', array(
      'model' => $model,
    ));
  }

  public function actionRawatinap()
  {
    $this->pageTitle = Yii::app()->name . " - Monitoring Rawat Inap";
    $model = new RKMonitoringrawatinapV('search');
    $model->unsetAttributes();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->tglmasukkamar = null;
    if (isset($_GET['RKMonitoringrawatinapV'])) {
      $model->attributes = $_GET['RKMonitoringrawatinapV'];
      $format = new MyFormatter();
      $model->tgl_awal  = $format->formatDateTimeForDb($_REQUEST['RKMonitoringrawatinapV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RKMonitoringrawatinapV']['tgl_akhir']);
      $model->pegawai_id = $_GET['RKMonitoringrawatinapV']['pegawai_id'];
      if ($_GET['RKMonitoringrawatinapV']['tglmasukkamar'] > 0) {
        $model->tglmasukkamar = $format->formatDateTimeForDb($_REQUEST['RKMonitoringrawatinapV']['tglmasukkamar']);
      } else {
        $model->tglmasukkamar = null;
      }
    }
    $this->render('indexRawatinap', array(
      'model' => $model,
    ));
  }

  public function actionPenunjang()
  {
    $this->pageTitle = Yii::app()->name . " - Monitoring Penunjang";
    $model = new RKMonitoringpenunjangV('search');
    $model->unsetAttributes();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    if (isset($_GET['RKMonitoringpenunjangV'])) {
      $format = new MyFormatter();
      $model->attributes = $_GET['RKMonitoringpenunjangV'];
      $model->tgl_awal  = $format->formatDateTimeForDb($_GET['RKMonitoringpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RKMonitoringpenunjangV']['tgl_akhir']);
      $model->pegawai_id = $_GET['RKMonitoringpenunjangV']['pegawai_id'];
    }

    $this->render('indexPenunjang', array(
      'model' => $model,
    ));
  }
  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $model = new RKMonitoringrawatjalanV('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['RKMonitoringrawatjalanV'])) {
      $model->attributes = $_GET['RKMonitoringrawatjalanV'];
      $model->pegawai_id = $_GET['RKMonitoringrawatjalanV']['pegawai_id'];
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
    $model = RKMonitoringrawatjalanV::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'monitoringrawatjalan-v-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
}
