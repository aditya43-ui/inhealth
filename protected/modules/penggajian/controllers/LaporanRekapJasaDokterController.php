<?php
class LaporanRekapJasaDokterController extends MyAuthController
{
  /**
   * actionLaporanRekapJasaDokter
   * modified : 
   */
  public $path_view = 'penggajian.views.laporanRekapJasaDokter.';
  public $filterRuangan = false;

  public function actionLaporanRekapJasaDokter()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Rekap Jasa Dokter";
    $model = new GJLaporantindakankomponenV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['GJLaporantindakankomponenV'])) {
      $model->attributes = $_GET['GJLaporantindakankomponenV'];

      $model->jns_periode = $_GET['GJLaporantindakankomponenV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GJLaporantindakankomponenV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GJLaporantindakankomponenV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['GJLaporantindakankomponenV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['GJLaporantindakankomponenV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      if ($this->filterRuangan) $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
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

    $this->render($this->path_view . 'index', array(
      'model' => $model, 'format' => $format,
    ));
  }

  public function actionLaporanRekapJD()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Rekap Jasa Dokter";
    $model = new GJLaporantindakankomponenV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['GJLaporantindakankomponenV'])) {
      $model->attributes = $_GET['GJLaporantindakankomponenV'];

      $model->jns_periode = $_GET['GJLaporantindakankomponenV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GJLaporantindakankomponenV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GJLaporantindakankomponenV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['GJLaporantindakankomponenV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['GJLaporantindakankomponenV']['bln_akhir']);
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

    $this->layout = "//layouts/iframe";
    $this->render($this->path_view . 'rekapJasaDokter/_table', array(
      'model' => $model, 'format' => $format,
    ));
  }

  public function actionLaporanDetailRekapJD()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Rekap Jasa Dokter";
    $model = new GJLaporantindakankomponenV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['GJLaporantindakankomponenV'])) {
      $model->attributes = $_GET['GJLaporantindakankomponenV'];

      $model->jns_periode = $_GET['GJLaporantindakankomponenV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GJLaporantindakankomponenV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GJLaporantindakankomponenV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['GJLaporantindakankomponenV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['GJLaporantindakankomponenV']['bln_akhir']);
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

    $this->layout = "//layouts/iframe";
    $this->render($this->path_view . 'rekapJasaDokter/_table_detail', array(
      'model' => $model, 'format' => $format,
    ));
  }

  public function actionPrintLaporanRekapJasaDokter()
  {
    $model = new GJLaporantindakankomponenV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'LAPORAN REKAP JASA DOKTER';

    //Data Grafik
    $data['title'] = 'GRAFIK LAPORAN REKAP JASA DOKTER';
    $data['type'] = (isset($REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['GJLaporantindakankomponenV'])) {
      $model->attributes = $_REQUEST['GJLaporantindakankomponenV'];
      $model->jns_periode = $_GET['GJLaporantindakankomponenV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GJLaporantindakankomponenV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GJLaporantindakankomponenV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['GJLaporantindakankomponenV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['GJLaporantindakankomponenV']['bln_akhir']);
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
    $tab = 'rekap';
    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'rekapJasaDokter/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, $tab);
  }

  public function actionPrintLaporanDetailRekapJasaDokter()
  {
    $model = new GJLaporantindakankomponenV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'LAPORAN DETAIL REKAP JASA DOKTER';

    //Data Grafik
    $data['title'] = 'GRAFIK LAPORAN DETAIL REKAP JASA DOKTER';
    $data['type'] = (isset($REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['GJLaporantindakankomponenV'])) {
      $model->attributes = $_REQUEST['GJLaporantindakankomponenV'];
      $model->jns_periode = $_REQUEST['GJLaporantindakankomponenV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GJLaporantindakankomponenV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GJLaporantindakankomponenV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['GJLaporantindakankomponenV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['GJLaporantindakankomponenV']['bln_akhir']);
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
    $tab = 'detail';
    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'rekapJasaDokter/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, $tab);
  }

  public function actionFrameGrafikLaporanRekapJasaDokter()
  {
    $this->layout = '//layouts/iframe';
    $model = new GJLaporantindakankomponenV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'GRAFIK LAPORAN REKAP JASA DOKTER';
    $data['type'] = $_GET['type'];
    if (isset($_GET['GJLaporantindakankomponenV'])) {
      $model->attributes = $_GET['GJLaporantindakankomponenV'];
      $model->jns_periode = $_GET['GJLaporantindakankomponenV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GJLaporantindakankomponenV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GJLaporantindakankomponenV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['GJLaporantindakankomponenV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['GJLaporantindakankomponenV']['bln_akhir']);
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

    $this->render($this->path_view . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }
}
