<?php

class InformasiUmurUtangController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $path_view = 'akuntansi.views.informasiUmurUtang.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Umur Utang";
    $model = new AKInformasiumurhutangV;
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['AKInformasiumurhutangV'])) {
      $model->attributes = $_GET['AKInformasiumurhutangV'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['AKInformasiumurhutangV']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['AKInformasiumurhutangV']['tgl_akhir']);
      $model->supplier_nama = $_GET['AKInformasiumurhutangV']['supplier_nama'];
    }

    $this->render('index', array('model' => $model));
  }
}
