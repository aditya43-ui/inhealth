<?php

class LaporanController extends MyAuthController
{
  public function actionLaporanSensusHarian()
  {
    $this->pageTitle = Yii::app()->name . " - Sensus Harian";
    $model = new PSLaporansensusharian('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    if (isset($_GET['PSLaporansensusharian'])) {
      $model->attributes = $_GET['PSLaporansensusharian'];
      $model->jns_periode = $_GET['PSLaporansensusharian']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PSLaporansensusharian']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PSLaporansensusharian']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PSLaporansensusharian']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PSLaporansensusharian']['bln_akhir']);
      $model->thn_awal = $_GET['PSLaporansensusharian']['thn_awal'];
      $model->thn_akhir = $_GET['PSLaporansensusharian']['thn_akhir'];
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
    if (Yii::app()->request->isAjaxRequest) {
      echo $this->renderPartial('persalinan.views.laporan.sensus._table', array('model' => $model, 'format' => $format), true);
    } else {
      $this->render('sensus/adminSensus', array(
        'model' => $model, 'format' => $format
      ));
    }
  }

  public function actionPrintLaporanSensusHarian()
  {
    $model = new PSLaporansensusharian('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Sensus Harian Persalinan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Sensus Harian';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['PSLaporansensusharian'])) {
      $model->attributes = $_REQUEST['PSLaporansensusharian'];
      $model->jns_periode = $_REQUEST['PSLaporansensusharian']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PSLaporansensusharian']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PSLaporansensusharian']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PSLaporansensusharian']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PSLaporansensusharian']['bln_akhir']);
      $model->thn_awal = $_GET['PSLaporansensusharian']['thn_awal'];
      $model->thn_akhir = $_GET['PSLaporansensusharian']['thn_akhir'];
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

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'sensus/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikSensusHarian()
  {
    $this->layout = '//layouts/iframe';
    $model = new PSLaporansensusharian('search');
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
    $data['title'] = 'Grafik Laporan Sensus Harian';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PSLaporansensusharian'])) {
      $model->attributes = $_GET['PSLaporansensusharian'];
      $model->jns_periode = $_GET['PSLaporansensusharian']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PSLaporansensusharian']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PSLaporansensusharian']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PSLaporansensusharian']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PSLaporansensusharian']['bln_akhir']);
      $model->thn_awal = $_GET['PSLaporansensusharian']['thn_awal'];
      $model->thn_akhir = $_GET['PSLaporansensusharian']['thn_akhir'];
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

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }


  public function actionLaporanKunjungan()
  {
    $this->pageTitle = Yii::app()->name . " - Kunjungan";
    $model = new PSInfokunjunganpersalinanV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PSInfokunjunganpersalinanV'])) {
      $model->attributes = $_GET['PSInfokunjunganpersalinanV'];
      $model->jns_periode = $_GET['PSInfokunjunganpersalinanV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PSInfokunjunganpersalinanV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PSInfokunjunganpersalinanV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PSInfokunjunganpersalinanV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PSInfokunjunganpersalinanV']['bln_akhir']);
      $model->thn_awal = $_GET['PSInfokunjunganpersalinanV']['thn_awal'];
      $model->thn_akhir = $_GET['PSInfokunjunganpersalinanV']['thn_akhir'];
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

    if (Yii::app()->request->isAjaxRequest) {
      echo $this->renderPartial('persalinan.views.laporan.kunjungan._tableKunjungan', array('model' => $model, 'format' => $format), true);
    } else {
      $this->render('kunjungan/adminKunjungan', array(
        'model' => $model, 'format' => $format
      ));
    }
  }

  public function actionPrintLaporanKunjungan()
  {
    $model = new PSInfokunjunganpersalinanV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Info Kunjungan Pasien Persalinan';

    //Data Grafik       
    $data['title'] = 'Grafik Laporan Info Kunjungan';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['PSInfokunjunganpersalinanV'])) {
      $model->attributes = $_REQUEST['PSInfokunjunganpersalinanV'];
      $model->jns_periode = $_REQUEST['PSInfokunjunganpersalinanV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PSInfokunjunganpersalinanV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PSInfokunjunganpersalinanV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PSInfokunjunganpersalinanV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PSInfokunjunganpersalinanV']['bln_akhir']);
      $model->thn_awal = $_GET['PSInfokunjunganpersalinanV']['thn_awal'];
      $model->thn_akhir = $_GET['PSInfokunjunganpersalinanV']['thn_akhir'];
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

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'kunjungan/_printKunjungan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikKunjungan()
  {
    $this->layout = '//layouts/iframe';
    $model = new PSInfokunjunganpersalinanV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Info Kunjungan';
    $data['type'] = $_GET['type'];
    if (isset($_GET['PSInfokunjunganpersalinanV'])) {
      $model->attributes = $_GET['PSInfokunjunganpersalinanV'];
      $model->jns_periode = $_GET['PSInfokunjunganpersalinanV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PSInfokunjunganpersalinanV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PSInfokunjunganpersalinanV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PSInfokunjunganpersalinanV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PSInfokunjunganpersalinanV']['bln_akhir']);
      $model->thn_awal = $_GET['PSInfokunjunganpersalinanV']['thn_awal'];
      $model->thn_akhir = $_GET['PSInfokunjunganpersalinanV']['thn_akhir'];
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

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporan10BesarPenyakit()
  {
    $this->pageTitle = Yii::app()->name . " - 10 Besar Penyakit";
    $model = new PSLaporan10besarpenyakit('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->jumlahTampil = 10;

    if (isset($_GET['PSLaporan10besarpenyakit'])) {
      $model->attributes = $_GET['PSLaporan10besarpenyakit'];
      $model->jns_periode = $_GET['PSLaporan10besarpenyakit']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PSLaporan10besarpenyakit']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PSLaporan10besarpenyakit']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PSLaporan10besarpenyakit']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PSLaporan10besarpenyakit']['bln_akhir']);
      $model->thn_awal = $_GET['PSLaporan10besarpenyakit']['thn_awal'];
      $model->thn_akhir = $_GET['PSLaporan10besarpenyakit']['thn_akhir'];
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

    $this->render('10Besar/index', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintLaporan10BesarPenyakit()
  {
    $model = new PSLaporan10besarpenyakit('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan 10 Besar Penyakit Pasien Persalinan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan 10 Besar Penyakit Pasien Persalinan';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['PSLaporan10besarpenyakit'])) {
      $model->attributes = $_REQUEST['PSLaporan10besarpenyakit'];
      $model->jns_periode = $_REQUEST['PSLaporan10besarpenyakit']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PSLaporan10besarpenyakit']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PSLaporan10besarpenyakit']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PSLaporan10besarpenyakit']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PSLaporan10besarpenyakit']['bln_akhir']);
      $model->thn_awal = $_GET['PSLaporan10besarpenyakit']['thn_awal'];
      $model->thn_akhir = $_GET['PSLaporan10besarpenyakit']['thn_akhir'];
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

    $caraPrint = $_REQUEST['caraPrint'];
    $target = '10Besar/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafik10BesarPenyakit()
  {
    $this->layout = '//layouts/iframe';
    $model = new PSLaporan10besarpenyakit('search');
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
    $data['title'] = 'Grafik Laporan 10 Besar Penyakit Persalinan';
    $data['type'] = $_GET['type'];
    if (isset($_GET['PSLaporan10besarpenyakit'])) {
      $model->attributes = $_GET['PSLaporan10besarpenyakit'];
      $model->jns_periode = $_GET['PSLaporan10besarpenyakit']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PSLaporan10besarpenyakit']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PSLaporan10besarpenyakit']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PSLaporan10besarpenyakit']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PSLaporan10besarpenyakit']['bln_akhir']);
      $model->thn_awal = $_GET['PSLaporan10besarpenyakit']['thn_awal'];
      $model->thn_akhir = $_GET['PSLaporan10besarpenyakit']['thn_akhir'];
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

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanPemakaiObatAlkes()
  {
    $this->pageTitle = Yii::app()->name . " - Pemakaian Obat Alkes Ruangan";
    $model = new PSLaporanpemakaiobatalkesruanganV;
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    
    if (isset($_GET['PSLaporanpemakaiobatalkesruanganV'])) {
      $model->attributes = $_GET['PSLaporanpemakaiobatalkesruanganV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['PSLaporanpemakaiobatalkesruanganV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PSLaporanpemakaiobatalkesruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PSLaporanpemakaiobatalkesruanganV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PSLaporanpemakaiobatalkesruanganV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PSLaporanpemakaiobatalkesruanganV']['bln_akhir']);
      $model->thn_awal = $_GET['PSLaporanpemakaiobatalkesruanganV']['thn_awal'];
      $model->thn_akhir = $_GET['PSLaporanpemakaiobatalkesruanganV']['thn_akhir'];
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
    $this->render('pemakaiObatAlkes/index', array('model' => $model, 'format' => $format));
  }

  public function actionPrintLaporanPemakaiObatAlkes()
  {
    $model = new PSLaporanpemakaiobatalkesruanganV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Info Pemakai Obat Alkes Persalinan';

    //Data Grafik       
    $data['title'] = 'Grafik Laporan Pemakai Obat Alkes Persalinan';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['PSLaporanpemakaiobatalkesruanganV'])) {
      $model->attributes = $_REQUEST['PSLaporanpemakaiobatalkesruanganV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_REQUEST['PSLaporanpemakaiobatalkesruanganV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PSLaporanpemakaiobatalkesruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PSLaporanpemakaiobatalkesruanganV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PSLaporanpemakaiobatalkesruanganV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PSLaporanpemakaiobatalkesruanganV']['bln_akhir']);
      $model->thn_awal = $_GET['PSLaporanpemakaiobatalkesruanganV']['thn_awal'];
      $model->thn_akhir = $_GET['PSLaporanpemakaiobatalkesruanganV']['thn_akhir'];
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

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'pemakaiObatAlkes/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }


  public function actionFrameGrafikLaporanPemakaiObatAlkes()
  {
    $this->layout = '//layouts/iframe';
    $model = new PSLaporanpemakaiobatalkesruanganV('search');
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
    $data['title'] = 'Grafik Laporan Pemakai Obat Alkes Persalinan';
    $data['type'] = $_GET['type'];
    if (isset($_GET['PSLaporanpemakaiobatalkesruanganV'])) {
      $model->attributes = $_GET['PSLaporanpemakaiobatalkesruanganV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['PSLaporanpemakaiobatalkesruanganV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PSLaporanpemakaiobatalkesruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PSLaporanpemakaiobatalkesruanganV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PSLaporanpemakaiobatalkesruanganV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PSLaporanpemakaiobatalkesruanganV']['bln_akhir']);
      $model->thn_awal = $_GET['PSLaporanpemakaiobatalkesruanganV']['thn_awal'];
      $model->thn_akhir = $_GET['PSLaporanpemakaiobatalkesruanganV']['thn_akhir'];
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

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanJasaInstalasi()
  {
    $model = new PSLaporanjasainstalasi('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $penjamin = CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_id');
    $model->penjamin_id = $penjamin;
    $tindakan = array('sudah', 'belum');
    $model->tindakansudahbayar_id = $tindakan;
    $filter = (isset($_GET['filter']) ? $_GET['filter'] : null);
    if (isset($_GET['PSLaporanjasainstalasi'])) {
      $model->attributes = $_GET['PSLaporanjasainstalasi'];
      $model->jns_periode = $_GET['PSLaporanjasainstalasi']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PSLaporanjasainstalasi']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PSLaporanjasainstalasi']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PSLaporanjasainstalasi']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PSLaporanjasainstalasi']['bln_akhir']);
      $model->thn_awal = $_GET['PSLaporanjasainstalasi']['thn_awal'];
      $model->thn_akhir = $_GET['PSLaporanjasainstalasi']['thn_akhir'];
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
      $model->nama_pegawai = $_GET['PSLaporanjasainstalasi']['nama_pegawai'];
    }

    $this->render('jasaInstalasi/index', array(
      'model' => $model, 'filter' => $filter, 'format' => $format
    ));
  }

  public function actionPrintLaporanJasaInstalasi()
  {
    $model = new PSLaporanjasainstalasi('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Jasa Instalasi Persalinan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Jasa Instalasi';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['PSLaporanjasainstalasi'])) {
      $model->attributes = $_REQUEST['PSLaporanjasainstalasi'];
      $model->jns_periode = $_REQUEST['PSLaporanjasainstalasi']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PSLaporanjasainstalasi']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PSLaporanjasainstalasi']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PSLaporanjasainstalasi']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PSLaporanjasainstalasi']['bln_akhir']);
      $model->thn_awal = $_GET['PSLaporanjasainstalasi']['thn_awal'];
      $model->thn_akhir = $_GET['PSLaporanjasainstalasi']['thn_akhir'];
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
      $model->nama_pegawai = $_GET['PSLaporanjasainstalasi']['nama_pegawai'];
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'jasaInstalasi/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanJasaInstalasi()
  {
    $this->layout = '//layouts/iframe';
    $model = new PSLaporanjasainstalasi('search');
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
    $data['title'] = 'Grafik Laporan Jasa Instalasi';
    $data['type'] = $_GET['type'];
    if (isset($_GET['PSLaporanjasainstalasi'])) {
      $model->attributes = $_GET['PSLaporanjasainstalasi'];
      $model->jns_periode = $_GET['PSLaporanjasainstalasi']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PSLaporanjasainstalasi']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PSLaporanjasainstalasi']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PSLaporanjasainstalasi']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PSLaporanjasainstalasi']['bln_akhir']);
      $model->thn_awal = $_GET['PSLaporanjasainstalasi']['thn_awal'];
      $model->thn_akhir = $_GET['PSLaporanjasainstalasi']['thn_akhir'];
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
      $model->nama_pegawai = $_GET['PSLaporanjasainstalasi']['nama_pegawai'];
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanBiayaPelayanan()
  {
    $model = new PSLaporanbiayapelayanan('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $penjamin = CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif=TRUE'), 'penjamin_id', 'penjamin_id');
    $model->penjamin_id = $penjamin;
    $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
    $model->kelaspelayanan_id = $kelas;
    $filter = (isset($_GET['filter']) ? $_GET['filter'] : null);
    if (isset($_GET['PSLaporanbiayapelayanan'])) {
      $model->attributes = $_GET['PSLaporanbiayapelayanan'];
      $model->jns_periode = $_GET['PSLaporanbiayapelayanan']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PSLaporanbiayapelayanan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PSLaporanbiayapelayanan']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PSLaporanbiayapelayanan']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PSLaporanbiayapelayanan']['bln_akhir']);
      $model->thn_awal = $_GET['PSLaporanbiayapelayanan']['thn_awal'];
      $model->thn_akhir = $_GET['PSLaporanbiayapelayanan']['thn_akhir'];
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


    $this->render('biayaPelayanan/index', array(
      'model' => $model, 'format' => $format, 'filter' => $filter
    ));
  }

  public function actionPrintLaporanBiayaPelayanan()
  {
    $model = new PSLaporanbiayapelayanan('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Biaya Pelayanan Persalinan';

    //Data Grafik        
    $data['title'] = 'Grafik Laporan Biaya Pelayanan Persalinan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['PSLaporanbiayapelayanan'])) {
      $model->attributes = $_REQUEST['PSLaporanbiayapelayanan'];
      $model->jns_periode = $_REQUEST['PSLaporanbiayapelayanan']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PSLaporanbiayapelayanan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PSLaporanbiayapelayanan']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PSLaporanbiayapelayanan']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PSLaporanbiayapelayanan']['bln_akhir']);
      $model->thn_awal = $_GET['PSLaporanbiayapelayanan']['thn_awal'];
      $model->thn_akhir = $_GET['PSLaporanbiayapelayanan']['thn_akhir'];
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

    $caraPrint = (isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null);
    $target = 'biayaPelayanan/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanBiayaPelayanan()
  {
    $this->layout = '//layouts/iframe';
    $model = new PSLaporanbiayapelayanan('search');
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
    $data['title'] = 'Grafik Laporan Biaya Pelayanan Persalinan';
    $data['type'] = $_GET['type'];
    if (isset($_GET['PSLaporanbiayapelayanan'])) {
      $model->attributes = $_GET['PSLaporanbiayapelayanan'];
      $model->jns_periode = $_GET['PSLaporanbiayapelayanan']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PSLaporanbiayapelayanan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PSLaporanbiayapelayanan']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PSLaporanbiayapelayanan']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PSLaporanbiayapelayanan']['bln_akhir']);
      $model->thn_awal = $_GET['PSLaporanbiayapelayanan']['thn_awal'];
      $model->thn_akhir = $_GET['PSLaporanbiayapelayanan']['thn_akhir'];
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

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanPendapatanRuangan()
  {
    $model = new PSLaporanpendapatanruanganV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $penjamin = CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_id');
    $model->penjamin_id = $penjamin;
    $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
    $model->kelaspelayanan_id = $kelas;
    $filter = (isset($_GET['filter']) ? $_GET['filter'] : null);
    if (isset($_GET['PSLaporanpendapatanruanganV'])) {
      $model->attributes = $_GET['PSLaporanpendapatanruanganV'];
      $model->jns_periode = $_GET['PSLaporanpendapatanruanganV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PSLaporanpendapatanruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PSLaporanpendapatanruanganV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PSLaporanpendapatanruanganV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PSLaporanpendapatanruanganV']['bln_akhir']);
      $model->thn_awal = $_GET['PSLaporanpendapatanruanganV']['thn_awal'];
      $model->thn_akhir = $_GET['PSLaporanpendapatanruanganV']['thn_akhir'];
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

    $this->render('pendapatanRuangan/index', array(
      'model' => $model, 'filter' => $filter, 'format' => $format
    ));
  }

  public function actionPrintLaporanPendapatanRuangan()
  {
    $model = new PSLaporanpendapatanruanganV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Grafik Pendapatan Ruangan Persalinan';

    //Data Grafik        
    $data['title'] = 'Grafik Laporan Pendapatan Ruangan';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['PSLaporanpendapatanruanganV'])) {
      $model->attributes = $_REQUEST['PSLaporanpendapatanruanganV'];
      $model->jns_periode = $_REQUEST['PSLaporanpendapatanruanganV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PSLaporanpendapatanruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PSLaporanpendapatanruanganV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PSLaporanpendapatanruanganV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PSLaporanpendapatanruanganV']['bln_akhir']);
      $model->thn_awal = $_GET['PSLaporanpendapatanruanganV']['thn_awal'];
      $model->thn_akhir = $_GET['PSLaporanpendapatanruanganV']['thn_akhir'];
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

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'pendapatanRuangan/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanPendapatanRuangan()
  {
    $this->layout = '//layouts/iframe';
    $model = new PSLaporanpendapatanruanganV('search');
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
    $data['title'] = 'Grafik Laporan Pendapatan Ruangan';
    $data['type'] = $_GET['type'];
    if (isset($_GET['PSLaporanpendapatanruanganV'])) {
      $model->attributes = $_GET['PSLaporanpendapatanruanganV'];
      $model->jns_periode = $_GET['PSLaporanpendapatanruanganV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PSLaporanpendapatanruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PSLaporanpendapatanruanganV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PSLaporanpendapatanruanganV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PSLaporanpendapatanruanganV']['bln_akhir']);
      $model->thn_awal = $_GET['PSLaporanpendapatanruanganV']['thn_awal'];
      $model->thn_akhir = $_GET['PSLaporanpendapatanruanganV']['thn_akhir'];
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

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanBukuRegister()
  {
    $this->pageTitle = Yii::app()->name . " - Buku Register";
    $model = new PSBukuregisterpasien('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PSBukuregisterpasien'])) {
      $model->attributes = $_GET['PSBukuregisterpasien'];
      $model->jns_periode = $_GET['PSBukuregisterpasien']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PSBukuregisterpasien']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PSBukuregisterpasien']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PSBukuregisterpasien']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PSBukuregisterpasien']['bln_akhir']);
      $model->thn_awal = $_GET['PSBukuregisterpasien']['thn_awal'];
      $model->thn_akhir = $_GET['PSBukuregisterpasien']['thn_akhir'];
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
    if (Yii::app()->request->isAjaxRequest) {
      echo $this->renderPartial('persalinan.views.laporan.bukuRegister._tableBukuRegister', array('model' => $model, 'format' => $format), true);
    } else {
      $this->render('bukuRegister/adminBukuRegister', array(
        'model' => $model, 'format' => $format
      ));
    }
  }

  public function actionPrintLaporanBukuRegister()
  {
    $model = new PSBukuregisterpasien('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Buku Register Persalinan';

    //Data Grafik   
    $data['title'] = 'Grafik Laporan Buku Register Persalinan';
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
    if (isset($_REQUEST['PSBukuregisterpasien'])) {
      $model->attributes = $_REQUEST['PSBukuregisterpasien'];
      $model->jns_periode = $_REQUEST['PSBukuregisterpasien']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PSBukuregisterpasien']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PSBukuregisterpasien']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PSBukuregisterpasien']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PSBukuregisterpasien']['bln_akhir']);
      $model->thn_awal = $_GET['PSBukuregisterpasien']['thn_awal'];
      $model->thn_akhir = $_GET['PSBukuregisterpasien']['thn_akhir'];
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

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'bukuRegister/_printBukuRegister';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikBukuRegister()
  {
    $this->layout = '//layouts/iframe';
    $model = new PSBukuregisterpasien('search');
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
    $data['title'] = 'Grafik Laporan Buku Register Pasien Rawat Jalan';
    $data['type'] = $_GET['type'];
    if (isset($_GET['PSBukuregisterpasien'])) {
      $model->attributes = $_GET['PSBukuregisterpasien'];
      $model->jns_periode = $_GET['PSBukuregisterpasien']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PSBukuregisterpasien']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PSBukuregisterpasien']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PSBukuregisterpasien']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PSBukuregisterpasien']['bln_akhir']);
      $model->thn_awal = $_GET['PSBukuregisterpasien']['thn_awal'];
      $model->thn_akhir = $_GET['PSBukuregisterpasien']['thn_akhir'];
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

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanCaraMasukPasien()
  {
    $this->pageTitle = Yii::app()->name . " - Cara Masuk";
    $model = new PSLaporancaramasukpasienV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $asalrujukan = CHtml::listData(AsalrujukanM::model()->findAll('asalrujukan_aktif = true'), 'asalrujukan_id', 'asalrujukan_id');
    //        $model->asalrujukan_id = $asalrujukan;
    // $ruanganasal = CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true'),'ruangan_id','ruangan_id');
    //  $model->ruanganasal_id = $ruanganasal;
    if (isset($_GET['PSLaporancaramasukpasienV'])) {
      $model->attributes = $_GET['PSLaporancaramasukpasienV'];
      $model->jns_periode = $_GET['PSLaporancaramasukpasienV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PSLaporancaramasukpasienV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PSLaporancaramasukpasienV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PSLaporancaramasukpasienV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PSLaporancaramasukpasienV']['bln_akhir']);
      $model->thn_awal = $_GET['PSLaporancaramasukpasienV']['thn_awal'];
      $model->thn_akhir = $_GET['PSLaporancaramasukpasienV']['thn_akhir'];
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

    $this->render('caraMasuk/index', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintLaporanCaraMasukPasien()
  {
    $model = new PSLaporancaramasukpasienV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Cara Masuk Pasien Persalinan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Cara Masuk Pasien';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['PSLaporancaramasukpasienV'])) {
      $model->attributes = $_REQUEST['PSLaporancaramasukpasienV'];
      $model->jns_periode = $_REQUEST['PSLaporancaramasukpasienV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PSLaporancaramasukpasienV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PSLaporancaramasukpasienV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PSLaporancaramasukpasienV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PSLaporancaramasukpasienV']['bln_akhir']);
      $model->thn_awal = $_GET['PSLaporancaramasukpasienV']['thn_awal'];
      $model->thn_akhir = $_GET['PSLaporancaramasukpasienV']['thn_akhir'];
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

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'caraMasuk/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanCaraMasukPasien()
  {
    $this->layout = '//layouts/iframe';
    $model = new PSLaporancaramasukpasienV('search');
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
    $data['title'] = 'Grafik Laporan Cara Masuk Pasien';
    $data['type'] = $_GET['type'];
    if (isset($_GET['PSLaporancaramasukpasienV'])) {
      $model->attributes = $_GET['PSLaporancaramasukpasienV'];
      $model->jns_periode = $_GET['PSLaporancaramasukpasienV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PSLaporancaramasukpasienV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PSLaporancaramasukpasienV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PSLaporancaramasukpasienV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PSLaporancaramasukpasienV']['bln_akhir']);
      $model->thn_awal = $_GET['PSLaporancaramasukpasienV']['thn_awal'];
      $model->thn_akhir = $_GET['PSLaporancaramasukpasienV']['thn_akhir'];
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

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target)
  {
    $format = new MyFormatter();
    $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);

    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }
}
