<?php

class InformasiUmurPiutangPenjaminController extends MyAuthController
{
  public $path_view = 'akuntansi.views.informasiUmurPiutangPenjamin.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Umur Piutang Penjamin";
    $model = new AKInformasiumurpiutangpenjaminV();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['AKInformasiumurpiutangpenjaminV'])) {
      $model->attributes = $_GET['AKInformasiumurpiutangpenjaminV'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['AKInformasiumurpiutangpenjaminV']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['AKInformasiumurpiutangpenjaminV']['tgl_akhir']);
    }

    $this->render($this->path_view . 'index', array('model' => $model));
  }
}
