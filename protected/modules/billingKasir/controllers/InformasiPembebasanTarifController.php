<?php

class InformasiPembebasanTarifController extends MyAuthController
{
  public function actionIndex()
  {
    $model = new BKInformasipembebasantarifV('searchInformasi');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->tgl_awal = date("d M Y");
    $model->tgl_akhir = date("d M Y");
    if (isset($_GET['BKInformasipembebasantarifV'])) {
      $model->attributes = $_GET['BKInformasipembebasantarifV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKInformasipembebasantarifV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKInformasipembebasantarifV']['tgl_akhir']);
    }
    $model->tgl_awal = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_awal, 'yyyy-MM-dd'), 'medium', null);
    $model->tgl_akhir = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_akhir, 'yyyy-MM-dd'), 'medium', null);

    $this->render('index', array('model' => $model));
  }
}
