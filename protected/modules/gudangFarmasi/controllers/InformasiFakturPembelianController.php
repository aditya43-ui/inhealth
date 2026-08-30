<?php

class InformasiFakturPembelianController extends MyAuthController
{
  public $defaultAction = 'index';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Faktur Pembelian Farmasi";
    $model = new GFInformasifakturpembelianV;
    $format = new MyFormatter();
    $model->tgl_awal  = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['GFInformasifakturpembelianV'])) {
      $model->attributes = $_GET['GFInformasifakturpembelianV'];
      $model->tgl_awal  = $format->formatDateTimeForDb($_GET['GFInformasifakturpembelianV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFInformasifakturpembelianV']['tgl_akhir']);
    }
    $this->render('index', array('format' => $format, 'model' => $model));
  }
}
