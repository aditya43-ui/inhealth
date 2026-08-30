<?php
class LaporanPelayananController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'mcu.views.laporanPelayanan.';

  public function actionIndex()
  {
    $format = new MyFormatter();
    $model = new MCLaporanpelayananmcuV('search');
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $this->render($this->path_view . 'index', array('model' => $model));
  }

  public function getUrlPelayananPaket()
  {
    return $this->module->id . '/laporanPelayananPaket/index';
  }

  public function getUrlPelayananNonPaket()
  {
    return $this->module->id . '/laporanPelayananNonPaket/index';
  }
}
