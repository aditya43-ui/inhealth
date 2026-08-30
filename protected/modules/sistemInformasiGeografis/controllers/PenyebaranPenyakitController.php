<?php

class PenyebaranPenyakitController extends MyAuthController
{
  public $path_viewPP = 'pendaftaranPenjadwalan.views.laporan.';
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Penyebaran Penyakit";
    //$model = new PPLaporanindikatordokterV('search');
    $model = new PasienmorbiditasT();
    $format = new MyFormatter();
    $model->unsetAttributes();
    if (isset($_GET['PPLaporanindikatordokterV'])) {
      $model->attributes = $_GET['PPLaporanindikatordokterV'];
      $model->jns_periode = $_GET['PPLaporanindikatordokterV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPLaporanindikatordokterV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPLaporanindikatordokterV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPLaporanindikatordokterV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPLaporanindikatordokterV']['bln_akhir']);
      $model->thn_awal = $_GET['PPLaporanindikatordokterV']['thn_awal'];
      $model->thn_akhir = $_GET['PPLaporanindikatordokterV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $this->render('index', array(
      'model' => $model, 'format' => $format
    ));
    //        $this->render('index');
  }

  /**
   * menampilkan halaman dashboard (iframe)
   * beberapa menggunakan DAO (createCommand) agar lebih cepat
   */
  public function actionSetIFrameContent()
  {
    $this->layout = '//layouts/iframePolos';
    $this->render('iframeContent', array());
  }
}
