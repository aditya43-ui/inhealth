<?php
class InformasiPettyCashController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'billingKasir.views.informasiPettyCash.';
  public $saveDetail = true;

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Penerimaan Petty Cash";
    $model  = new BKInfopengajuanpettyV;
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['BKInfopengajuanpettyV'])) {
      $model->attributes = $_GET['BKInfopengajuanpettyV'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['BKInfopengajuanpettyV']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['BKInfopengajuanpettyV']['tgl_akhir']);
    }

    $this->render($this->path_view . 'index', array('model' => $model));
  }
}
