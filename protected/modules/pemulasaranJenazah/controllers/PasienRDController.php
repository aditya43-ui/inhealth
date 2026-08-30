<?php

class PasienRDController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Rawat Darurat";
    $format = new MyFormatter();
    $model = new PJInfoKunjunganRDV;
    $model->tgl_awal = date("Y-m-d");
    $model->tgl_akhir = date('Y-m-d');
    $model->ceklis = TRUE;
    if (isset($_GET['PJInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PJInfoKunjunganRDV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PJInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PJInfoKunjunganRDV']['tgl_akhir']);
      $model->ceklis = $_GET['PJInfoKunjunganRDV']['ceklis'];
    }

    $this->render('index', array('model' => $model, 'format' => $format));
  }
}
