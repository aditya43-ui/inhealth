<?php

Yii::import('informasi.models.*');
Yii::import('informasi.controllers.InformasiRawatInapController');

class InformasiRawatInapPIController extends InformasiRawatInapController
{
  protected $path_view = 'informasi.views.informasiRawatInap.';

  public function actionIndex()
  {
    $format = new MyFormatter();
    $modRawatInap = new INRawatInap('searchRI');
    $modRawatInap->tgl_awal = date('Y-m-d');
    $modRawatInap->tgl_akhir = date('Y-m-d');
    $modRawatInap->unsetAttributes();
    if (isset($_GET['INRawatInap'])) {
      $modRawatInap->attributes = $_GET['INRawatInap'];
      $modRawatInap->tgl_awal = isset($_GET['INRawatInap']['tgl_awal']) ? $format->formatDateTimeForDb($_GET['INRawatInap']['tgl_awal']) : NULL;
      $modRawatInap->tgl_akhir = isset($_GET['INRawatInap']['tgl_akhir']) ? $format->formatDateTimeForDb($_GET['INRawatInap']['tgl_akhir']) : NULL;
    }
    $this->render($this->path_view . 'index', array(
      'modRawatInap' => $modRawatInap,
      'format' => $format
    ));
  }
}
