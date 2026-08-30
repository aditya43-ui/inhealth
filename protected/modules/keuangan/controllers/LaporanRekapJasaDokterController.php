<?php
class LaporanRekapJasaDokterController extends MyAuthController
{

  /**
   * actionLaporanRekapJasaDokter
   * modified : 
   */
  public function actionLaporanRekapJasaDokter()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Rekap Jasa Dokter";
    $model = new KULaporantindakankomponenV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['KULaporantindakankomponenV'])) {
      $model->attributes = $_GET['KULaporantindakankomponenV'];

      $model->jns_periode = $_GET['KULaporantindakankomponenV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KULaporantindakankomponenV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KULaporantindakankomponenV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['KULaporantindakankomponenV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['KULaporantindakankomponenV']['bln_akhir']);
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
      $model->tgl_awal = $model->tgl_awal;
      $model->tgl_akhir = $model->tgl_akhir;
    }

    $this->render('index', array(
      'model' => $model, 'format' => $format,
    ));
  }

  public function actionLaporanRekapJD()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Rekap Jasa Dokter";
    $model = new KULaporantindakankomponenV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['KULaporantindakankomponenV'])) {
      $model->attributes = $_GET['KULaporantindakankomponenV'];

      $model->jns_periode = $_GET['KULaporantindakankomponenV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KULaporantindakankomponenV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KULaporantindakankomponenV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['KULaporantindakankomponenV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['KULaporantindakankomponenV']['bln_akhir']);
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
      $model->tgl_awal = $model->tgl_awal;
      $model->tgl_akhir = $model->tgl_akhir;
    }

    $this->layout = "//layouts/iframe";
    $this->render('rekapJasaDokter/_table', array(
      'model' => $model, 'format' => $format,
    ));
  }

  public function actionLaporanDetailRekapJD()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Rekap Jasa Dokter";
    $model = new KULaporantindakankomponenV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['KULaporantindakankomponenV'])) {
      $model->attributes = $_GET['KULaporantindakankomponenV'];

      $model->jns_periode = $_GET['KULaporantindakankomponenV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KULaporantindakankomponenV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KULaporantindakankomponenV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['KULaporantindakankomponenV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['KULaporantindakankomponenV']['bln_akhir']);
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
      $model->tgl_awal = $model->tgl_awal;
      $model->tgl_akhir = $model->tgl_akhir;
    }

    $this->layout = "//layouts/iframe";
    $this->render('rekapJasaDokter/_table_detail', array(
      'model' => $model, 'format' => $format,
    ));
  }

  public function actionPrintLaporanRekapJasaDokter()
  {
    $model = new KULaporantindakankomponenV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Rekap Jasa Dokter';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Rekap Jasa Dokter';
    $data['type'] = (isset($REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['KULaporantindakankomponenV'])) {
      $model->attributes = $_REQUEST['KULaporantindakankomponenV'];
      $model->jns_periode = $_GET['KULaporantindakankomponenV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KULaporantindakankomponenV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KULaporantindakankomponenV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['KULaporantindakankomponenV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['KULaporantindakankomponenV']['bln_akhir']);
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
      $model->tgl_awal = $model->tgl_awal;
      $model->tgl_akhir = $model->tgl_akhir;
    }
    $tab = 'rekap';
    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'rekapJasaDokter/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, $tab);
  }

  public function actionPrintLaporanDetailRekapJasaDokter()
  {
    $model = new KULaporantindakankomponenV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Detail Rekap Jasa Dokter';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Detail Rekap Jasa Dokter';
    $data['type'] = (isset($REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['KULaporantindakankomponenV'])) {
      $model->attributes = $_REQUEST['KULaporantindakankomponenV'];
      $model->jns_periode = $_REQUEST['KULaporantindakankomponenV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KULaporantindakankomponenV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KULaporantindakankomponenV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['KULaporantindakankomponenV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['KULaporantindakankomponenV']['bln_akhir']);
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
      $model->tgl_awal = $model->tgl_awal;
      $model->tgl_akhir = $model->tgl_akhir;
    }
    $tab = 'detail';
    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'rekapJasaDokter/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, $tab);
  }

  public function actionFrameGrafikLaporanRekapJasaDokter()
  {
    $this->layout = '//layouts/iframe';
    $model = new KULaporantindakankomponenV();
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
    $data['title'] = 'Grafik Laporan Rekap Jasa Dokter';
    $data['type'] = $_GET['type'];
    if (isset($_GET['KULaporantindakankomponenV'])) {
      $model->attributes = $_GET['KULaporantindakankomponenV'];
      $model->jns_periode = $_GET['KULaporantindakankomponenV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KULaporantindakankomponenV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KULaporantindakankomponenV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['KULaporantindakankomponenV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['KULaporantindakankomponenV']['bln_akhir']);
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
      $model->tgl_awal = $model->tgl_awal;
      $model->tgl_akhir = $model->tgl_akhir;
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }
}
