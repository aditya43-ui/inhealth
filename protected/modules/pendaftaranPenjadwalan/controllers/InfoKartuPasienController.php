<?php

class InfoKartuPasienController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';

  public function actionUpdate()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $kartupasien_id = $_POST['kartupasien_id'];
      $transaction = Yii::app()->db->beginTransaction();
      try {
        PPKartupasienR::model()->updateByPk($kartupasien_id, array('statusprintkartu' => true));
        $transaction->commit();
        $data['success'] = true;
      } catch (Exception $exc) {
        $transaction->rollback();
      }

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionIndex()
  {
    //                if(!Yii::app()->user->checkAccess(Params::)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = new PPKartupasienR('search');
    $model->tgl_awal = date('d M Y 00:00:00');
    $model->tgl_akhir = date('d M Y H:i:s');
    if (isset($_GET['PPKartupasienR'])) {
      $model->attributes = $_GET['PPKartupasienR'];
      $model->no_rekam_medik = $_GET['PPKartupasienR']['no_rekam_medik'];
      $model->nama_pasien = $_GET['PPKartupasienR']['nama_pasien'];
      $model->alamat_pasien = $_GET['PPKartupasienR']['alamat_pasien'];
      $model->no_pendaftaran = $_GET['PPKartupasienR']['no_pendaftaran'];
      $model->rt = $_GET['PPKartupasienR']['rt'];
      $model->rw = $_GET['PPKartupasienR']['rw'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPKartupasienR']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPKartupasienR']['tgl_akhir']);
      echo $model->tgl_awal;
      echo $model->tgl_akhir;
    }

    $this->render('index', array(
      'model' => $model,
    ));
  }

  public function loadModel($id)
  {
    $model = PPKartupasienR::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'ppinfokartupasien-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
}
