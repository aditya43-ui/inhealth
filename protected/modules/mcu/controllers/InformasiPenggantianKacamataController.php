<?php
class InformasiPenggantianKacamataController extends MyAuthController
{
  public $defaultAction = 'index';

  public function actionIndex()
  {
    $model = new MCGantikacamataT('searchInformasi');
    $model->unsetAttributes();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    if (isset($_GET['MCGantikacamataT'])) {
      $model->attributes = $_GET['MCGantikacamataT'];
      $format = new MyFormatter();
      $model->tgl_awal  = $format->formatDateTimeForDb($_REQUEST['MCGantikacamataT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['MCGantikacamataT']['tgl_akhir']);
      $model->no_pengajuan = $_REQUEST['MCGantikacamataT']['no_pengajuan'];
      $model->status = $_REQUEST['MCGantikacamataT']['status'];
    }

    $this->render('index', array('model' => $model));
  }
}
