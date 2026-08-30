<?php

class PasienRIController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Rawat Inap";
    $format = new MyFormatter();
    $model = new PJPasienrawatinapV;
    $model->tgl_awal = date("Y-m-d");
    $model->tgl_akhir = date('Y-m-d');
    $model->ceklis = TRUE;

    if (isset($_GET['PJPasienrawatinapV'])) {
      $model->attributes = $_GET['PJPasienrawatinapV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PJPasienrawatinapV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PJPasienrawatinapV']['tgl_akhir']);
      $model->ceklis = $_GET['PJPasienrawatinapV']['ceklis'];
    }

    $this->render('index', array('model' => $model, 'format' => $format));
  }
}
