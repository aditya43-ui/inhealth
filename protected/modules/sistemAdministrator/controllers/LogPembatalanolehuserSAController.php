<?php

class LogPembatalanolehuserSAController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'sistemAdministrator.views.logPembatalanolehuserSA.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Log Pembatalan Oleh User";
    $model = new SALogpembatalanolehuserV('searchInformasi');
    $format = new MyFormatter();

    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['SALogpembatalanolehuserV'])) {
      $model->attributes = $_GET['SALogpembatalanolehuserV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['SALogpembatalanolehuserV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['SALogpembatalanolehuserV']['tgl_akhir']);
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'format' => $format
    ));
  }
}
