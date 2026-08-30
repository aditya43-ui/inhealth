<?php

class InfoPasienBatalPeriksaController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'pendaftaranPenjadwalan.views.infoPasienBatalPeriksa.';

  public function actionIndex()
  {
    $model = new PPInfopasienbatalperiksaV('search');
    $format = new MyFormatter;
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    if (isset($_GET['PPInfopasienbatalperiksaV'])) {
      $model->attributes = $_GET['PPInfopasienbatalperiksaV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfopasienbatalperiksaV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfopasienbatalperiksaV']['tgl_akhir']);
    }
    $this->render($this->path_view . 'index', array(
      'model' => $model, 'format' => $format
    ));
  }
}
