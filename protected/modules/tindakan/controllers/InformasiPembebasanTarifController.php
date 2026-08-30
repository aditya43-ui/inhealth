<?php

class InformasiPembebasanTarifController extends MyAuthController
{
  public $path_view = "rawatJalan.views.informasiPembebasanTarif.";

  public function actionIndex($linkHalaman = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pembebasan Tarif";
    $model = new RJLaporanpembebasantarifV('searchInformasi');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->tgl_awal = date("d M Y");
    $model->tgl_akhir = date("d M Y");
    $model->tgldaftar_awal = date("d M Y");
    $model->tgldaftar_akhir = date("d M Y");

    if (isset($_GET['RJLaporanpembebasantarifV'])) {
      $model->attributes = $_GET['RJLaporanpembebasantarifV'];
      $model->ceklistdaftar = $_GET['RJLaporanpembebasantarifV']['ceklistdaftar'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporanpembebasantarifV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporanpembebasantarifV']['tgl_akhir']);
      $model->tgldaftar_awal = $format->formatDateTimeForDb($_GET['RJLaporanpembebasantarifV']['tgldaftar_awal']);
      $model->tgldaftar_akhir = $format->formatDateTimeForDb($_GET['RJLaporanpembebasantarifV']['tgldaftar_akhir']);
    }

    if($linkHalaman == null) $linkHalaman = CustomFunction::getUrlByMenuID(3493);

    $this->render($this->path_view . 'index', array('model' => $model, 'linkHalaman' => $linkHalaman));
  }
}
