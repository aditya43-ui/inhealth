<?php
class InformasiRJController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'rawatJalan.views.informasi.';

  public function actionInformasiBatalPeriksa()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Batal Periksa";
    $model = new RJInfopasienbatalperiksaV('search');
    $format = new MyFormatter;
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    if (isset($_GET['RJInfopasienbatalperiksaV'])) {
      $model->attributes = $_GET['RJInfopasienbatalperiksaV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJInfopasienbatalperiksaV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJInfopasienbatalperiksaV']['tgl_akhir']);
      $model->nama_pegawai = $_GET['RJInfopasienbatalperiksaV']['nama_pegawai'];
    }

    $this->render($this->path_view . 'batalPeriksaPasien/index', array(
      'model' => $model, 'format' => $format
    ));
  }
}
