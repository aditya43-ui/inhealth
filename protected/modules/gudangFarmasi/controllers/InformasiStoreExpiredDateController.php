<?php

class InformasiStoreExpiredDateController extends MyAuthController
{
  public $defaultAction = 'index';

  public function actionIndex()
  {
    $model = new GFStoreeddetailT;
    $format = new MyFormatter();

    if (isset($_GET['GFStoreeddetailT'])) {
      $model->attributes = $_GET['GFStoreeddetailT'];
      $model->tglkadaluarsa  = $format->formatDateTimeForDb($_GET['GFStoreeddetailT']['tglkadaluarsa']);
    }
    $this->render('index', array('format' => $format, 'model' => $model));
  }
}
