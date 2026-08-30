<?php
Yii::import('laboratorium.models.*');
Yii::import('laboratorium.controllers.RinciantagihanpasienpenunjangVController');
class RinciantagihanpasienpenunjangPSVController extends RinciantagihanpasienpenunjangVController
{
  public function actionIndex()
  {
    //                
    $model = new PSPasienMasukPenunjangV('searchRincian');
    $format = new MyFormatter();
    $model->tgl_awal = date("Y-m-d");
    $model->tgl_akhir = date("Y-m-d");
    $model->unsetAttributes();  // clear any default values

    if (isset($_GET['PSPasienMasukPenunjangV'])) {
      $model->attributes = $_GET['PSPasienMasukPenunjangV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PSPasienMasukPenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PSPasienMasukPenunjangV']['tgl_akhir']);
      $model->statusBayar = $_GET['PSPasienMasukPenunjangV']['statusBayar'];
    }

    $this->render('laboratorium.views.rinciantagihanpasienpenunjangV.index', array(
      'model' => $model, 'format' => $format
    ));
  }
}
