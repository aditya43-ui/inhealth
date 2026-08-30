<?php
class InfoPasienBlacklistController extends MyAuthController
{
  public $path_view = 'rekamMedis.views.infoPasienBlacklist.';

  public function actionIndex()
  {
    $format = new MyFormatter();
    $model = new RKInfopasienblacklistV('search');
    $model->tgl_awal = date("Y-m-d");
    $model->tgl_akhir = date("Y-m-d");
    //		$model->instalasi_id = Params::INSTALASI_ID_RI;

    if (isset($_GET['RKInfopasienblacklistV'])) {
      $model->attributes = $_GET['RKInfopasienblacklistV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RKInfopasienblacklistV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RKInfopasienblacklistV']['tgl_akhir']);
    }

    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'model' => $model
    ));
  }
}
