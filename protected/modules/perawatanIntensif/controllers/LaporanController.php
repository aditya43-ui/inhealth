<?php

Yii::import('billingKasir.models.*');
class LaporanController extends MyAuthController
{
  public $path_view = 'perawatanIntensif.views.laporan.';
  public function actionLaporanKunjungan()
  {
    $this->pageTitle = Yii::app()->name . " - Kunjungan Pasien";
    $model = new PIInfokunjunganriV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PIInfokunjunganriV'])) {
      $model->attributes = $_GET['PIInfokunjunganriV'];
      $model->jns_periode = $_GET['PIInfokunjunganriV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PIInfokunjunganriV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PIInfokunjunganriV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PIInfokunjunganriV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PIInfokunjunganriV']['bln_akhir']);
      $model->thn_awal = $_GET['PIInfokunjunganriV']['thn_awal'];
      $model->thn_akhir = $_GET['PIInfokunjunganriV']['thn_akhir'];
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


    $this->render('kunjungan/adminKunjungan', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintLaporanKunjungan()
  {
    $model = new PIInfokunjunganriV('search');
    $judulLaporan = 'Laporan Info Kunjungan Pasien Rawat Intensif';

    //Data Grafik       
    $data['title'] = 'Grafik Laporan Info Kunjungan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['PIInfokunjunganriV'])) {
      $model->attributes = $_REQUEST['PIInfokunjunganriV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PIInfokunjunganriV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PIInfokunjunganriV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'kunjungan/_printKunjungan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikKunjungan()
  {
    $this->layout = '//layouts/iframe';
    $model = new PIInfokunjunganriV('search');
    $model->tgl_awal = date('d M Y H:i:s');
    $model->tgl_akhir = date('d M Y H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Info Kunjungan';
    $data['type'] = $_GET['type'];
    if (isset($_GET['PIInfokunjunganriV'])) {
      $model->attributes = $_GET['PIInfokunjunganriV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PIInfokunjunganriV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PIInfokunjunganriV']['tgl_akhir']);
      $model->pilihanx = $format->formatDateTimeForDb($_GET['PIInfokunjunganriV']['pilihanx']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanSensusHarian()
  {
    $this->pageTitle = Yii::app()->name . " - Sensus Harian";
    $model = new PILaporansensusharian('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PILaporansensusharian'])) {
      $model->attributes = $_GET['PILaporansensusharian'];
      $model->jns_periode = $_GET['PILaporansensusharian']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PILaporansensusharian']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PILaporansensusharian']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PILaporansensusharian']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PILaporansensusharian']['bln_akhir']);
      $model->thn_awal = $_GET['PILaporansensusharian']['thn_awal'];
      $model->thn_akhir = $_GET['PILaporansensusharian']['thn_akhir'];
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

    $this->render('sensus/adminSensus', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintLaporanSensusHarian()
  {
    $model = new PILaporansensusharian('search');
    $judulLaporan = 'Laporan Sensus Harian Rawat Intensif';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Sensus Harian';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['PILaporansensusharian'])) {
      $model->attributes = $_REQUEST['PILaporansensusharian'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PILaporansensusharian']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PILaporansensusharian']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'sensus/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikSensusHarian()
  {
    $this->layout = '//layouts/iframe';
    $model = new PILaporansensusharian('search');
    $model->tgl_awal = date('d M Y H:i:s');
    $model->tgl_akhir = date('d M Y H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Sensus Harian';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);

    if (isset($_GET['PILaporansensusharian'])) {
      $model->attributes = $_GET['PILaporansensusharian'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PILaporansensusharian']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PILaporansensusharian']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanTindakLanjut()
  {
    $model = new PILaporantindaklanjutri('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $temp = array();
    foreach (LookupM::getItems('carakeluar') as $i => $data) {
      if (empty($i) || trim($i) == '') {
        continue;
      }
      $temp[] = strtoupper($data);
    }
    $model->carakeluar = $temp;

    if (isset($_GET['PILaporantindaklanjutri'])) {
      $model->attributes = $_GET['PILaporantindaklanjutri'];
      $model->jns_periode = $_GET['PILaporantindaklanjutri']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PILaporantindaklanjutri']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PILaporantindaklanjutri']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PILaporantindaklanjutri']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PILaporantindaklanjutri']['bln_akhir']);
      $model->thn_awal = $_GET['PILaporantindaklanjutri']['thn_awal'];
      $model->thn_akhir = $_GET['PILaporantindaklanjutri']['thn_akhir'];
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

    $this->render('tindakLanjut/adminTindakLanjut', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintLaporanTindakLanjut()
  {
    $model = new PILaporantindaklanjutri('search');
    $judulLaporan = 'Laporan Tindak Lanjut Pasien Rawat Intensif';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Tindak Lanjut Pasien';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['PILaporantindaklanjutri'])) {
      $model->attributes = $_REQUEST['PILaporantindaklanjutri'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PILaporantindaklanjutri']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PILaporantindaklanjutri']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'tindakLanjut/_printTindakLanjut';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanTindakLanjut()
  {
    $this->layout = '//layouts/iframe';
    $model = new PILaporantindaklanjutri('search');
    $model->tgl_awal = date('d M Y H:i:s');
    $model->tgl_akhir = date('d M Y H:i:s');

    //Data Grafik 
    $data['title'] = 'Grafik Laporan Tindak Lanjut Pasien';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_GET['PILaporantindaklanjutri'])) {
      $model->attributes = $_GET['PILaporantindaklanjutri'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PILaporantindaklanjutri']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PILaporantindaklanjutri']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanPasienMeninggal()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Meninggal";
    $model = new PILaporanpasienmeninggalriV('searchTable');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $caramasuk = CHtml::listData(CaramasukM::model()->findAll('caramasuk_aktif = true'), 'caramasuk_id', 'caramasuk_id');
    $model->caramasuk_id = $caramasuk;

    if (isset($_GET['PILaporanpasienmeninggalriV'])) {
      $model->attributes = $_GET['PILaporanpasienmeninggalriV'];
      $model->jns_periode = $_GET['PILaporanpasienmeninggalriV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PILaporanpasienmeninggalriV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PILaporanpasienmeninggalriV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PILaporanpasienmeninggalriV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PILaporanpasienmeninggalriV']['bln_akhir']);
      $model->thn_awal = $_GET['PILaporanpasienmeninggalriV']['thn_awal'];
      $model->thn_akhir = $_GET['PILaporanpasienmeninggalriV']['thn_akhir'];
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

    $this->render('pasienMeninggal/index', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintLaporanPasienMeninggal()
  {
    $model = new PILaporanpasienmeninggalriV('search');
    $judulLaporan = 'Laporan Pasien Meninggal';
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
    $data['title'] = 'Grafik Laporan Pasien Meninggal';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_REQUEST['PILaporanpasienmeninggalriV'])) {
      $model->attributes = $_REQUEST['PILaporanpasienmeninggalriV'];
      $model->jns_periode = $_REQUEST['PILaporanpasienmeninggalriV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PILaporanpasienmeninggalriV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PILaporanpasienmeninggalriV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PILaporanpasienmeninggalriV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PILaporanpasienmeninggalriV']['bln_akhir']);
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
    $target = 'pasienMeninggal/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikPasienMeninggal()
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = new PILaporanpasienmeninggalriV('search');
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Pasien Meninggal';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PILaporanpasienmeninggalriV'])) {
      $model->attributes = $_GET['PILaporanpasienmeninggalriV'];
      $model->jns_periode = $_GET['PILaporanpasienmeninggalriV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PILaporanpasienmeninggalriV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PILaporanpasienmeninggalriV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PILaporanpasienmeninggalriV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PILaporanpasienmeninggalriV']['bln_akhir']);
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
    $model = new PIBukuregisterriV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PIBukuregisterriV'])) {
      $model->attributes = $_GET['PIBukuregisterriV'];
      $model->jns_periode = $_GET['PIBukuregisterriV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PIBukuregisterriV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PIBukuregisterriV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PIBukuregisterriV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PIBukuregisterriV']['bln_akhir']);
      $model->thn_awal = $_GET['PIBukuregisterriV']['thn_awal'];
      $model->thn_akhir = $_GET['PIBukuregisterriV']['thn_akhir'];
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

    $this->render('bukuRegister/adminBukuRegister', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintLaporanBukuRegister()
  {
    $model = new PIBukuregisterriV('search');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Buku Register Rawat Intensif';
    $format = new MyFormatter();
    // Data untuk Grafik
    $data['title'] = 'Grafik Laporan Buku Register Rawat Intensif';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);

    if (isset($_REQUEST['PIBukuregisterriV'])) {
      $model->attributes = $_REQUEST['PIBukuregisterriV'];
      $model->jns_periode = $_REQUEST['PIBukuregisterriV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PIBukuregisterriV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PIBukuregisterriV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PIBukuregisterriV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PIBukuregisterriV']['bln_akhir']);
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
    $model = new PIBukuregisterriV('search');
    $model->tgl_awal = date('d M Y H:i:s');
    $model->tgl_akhir = date('d M Y H:i:s');

    // Data untuk Grafik
    $data['title'] = 'Grafik Laporan Buku Register Pasien Rawat Intensif';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);

    if (isset($_REQUEST['PIBukuregisterriV'])) {
      $model->attributes = $_GET['PIBukuregisterriV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PIBukuregisterriV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PIBukuregisterriV']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporan10BesarPenyakit()
  {
    $this->pageTitle = Yii::app()->name . " - 10 Besar Penyakit";
    $model = new PILaporan10besarpenyakit('search');
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
    //		$model->tgl_awal = $model->tgl_awal." 00:00:00";
    //		$model->tgl_akhir = $model->tgl_akhir." 23:59:59";

    if (isset($_GET['PILaporan10besarpenyakit'])) {
      $model->attributes = $_GET['PILaporan10besarpenyakit'];
      $model->jns_periode = $_GET['PILaporan10besarpenyakit']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PILaporan10besarpenyakit']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PILaporan10besarpenyakit']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PILaporan10besarpenyakit']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PILaporan10besarpenyakit']['bln_akhir']);
      $model->thn_awal = $_GET['PILaporan10besarpenyakit']['thn_awal'];
      $model->thn_akhir = $_GET['PILaporan10besarpenyakit']['thn_akhir'];
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

    $this->render('10Besar/admin10BesarPenyakit', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintLaporan10BesarPenyakit()
  {
    $model = new PILaporan10besarpenyakit('search');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan 10 Besar Penyakit Pasien Rawat Intensif';
    $format = new MyFormatter();

    //Data Grafik
    $data['title'] = 'Grafik Laporan 10 Besar Penyakit Pasien';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['PILaporan10besarpenyakit'])) {
      $model->attributes = $_REQUEST['PILaporan10besarpenyakit'];
      $model->jns_periode = $_GET['PILaporan10besarpenyakit']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PILaporan10besarpenyakit']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PILaporan10besarpenyakit']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PILaporan10besarpenyakit']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PILaporan10besarpenyakit']['bln_akhir']);
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
    $target = '10Besar/_print10Besar';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafik10BesarPenyakit()
  {
    $this->layout = '//layouts/iframe';
    $model = new PILaporan10besarpenyakit('search');
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan 10 Besar Penyakit';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_GET['PILaporan10besarpenyakit'])) {
      $model->attributes = $_GET['PILaporan10besarpenyakit'];
      $format = new MyFormatter();
      $model->attributes = $_REQUEST['PILaporan10besarpenyakit'];
      $model->jns_periode = $_GET['PILaporan10besarpenyakit']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PILaporan10besarpenyakit']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PILaporan10besarpenyakit']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PILaporan10besarpenyakit']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PILaporan10besarpenyakit']['bln_akhir']);
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

  public function actionLaporanBiayaPelayanan()
  {
    $this->pageTitle = Yii::app()->name . " - Biaya Pelayanan";
    $model = new PILaporanbiayapelayanan('search');
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
    if (isset($_GET['PILaporanbiayapelayanan'])) {
      $model->attributes = $_GET['PILaporanbiayapelayanan'];
      $model->jns_periode = $_GET['PILaporanbiayapelayanan']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PILaporanbiayapelayanan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PILaporanbiayapelayanan']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PILaporanbiayapelayanan']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PILaporanbiayapelayanan']['bln_akhir']);
      $model->thn_awal = $_GET['PILaporanbiayapelayanan']['thn_awal'];
      $model->thn_akhir = $_GET['PILaporanbiayapelayanan']['thn_akhir'];
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

    $this->render('biayaPelayanan/adminBiayaPelayanan', array(
      'model' => $model, 'filter' => $filter, 'format' => $format
    ));
  }

  public function actionPrintLaporanBiayaPelayanan()
  {
    $model = new PILaporanbiayapelayanan('search');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Biaya Pelayanan Rawat Intensif';
    $format = new MyFormatter();
    //Data Grafik        
    $data['title'] = 'Grafik Laporan Biaya Pelayanan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['PILaporanbiayapelayanan'])) {
      $model->attributes = $_REQUEST['PILaporanbiayapelayanan'];
      $model->jns_periode = $_REQUEST['PILaporanbiayapelayanan']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PILaporanbiayapelayanan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PILaporanbiayapelayanan']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PILaporanbiayapelayanan']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PILaporanbiayapelayanan']['bln_akhir']);
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
    $target = 'biayaPelayanan/_printBiayaPelayanan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanBiayaPelayanan()
  {
    $this->layout = '//layouts/iframe';
    $model = new PILaporanbiayapelayanan('search');
    $model->tgl_awal = date('d M Y H:i:s');
    $model->tgl_akhir = date('d M Y H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Biaya Pelayanan Rawat Intensif';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_GET['PILaporanbiayapelayanan'])) {
      $model->attributes = $_GET['PILaporanbiayapelayanan'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PILaporanbiayapelayanan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PILaporanbiayapelayanan']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanPendapatanRuangan()
  {
    $this->pageTitle = Yii::app()->name . " - Pendapatan Ruangan";
    $model = new PILaporanpendapatanruangan('search');
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

    if (isset($_GET['PILaporanpendapatanruangan'])) {
      $model->attributes = $_GET['PILaporanpendapatanruangan'];
      $model->jns_periode = $_GET['PILaporanpendapatanruangan']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PILaporanpendapatanruangan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PILaporanpendapatanruangan']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PILaporanpendapatanruangan']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PILaporanpendapatanruangan']['bln_akhir']);
      $model->thn_awal = $_GET['PILaporanpendapatanruangan']['thn_awal'];
      $model->thn_akhir = $_GET['PILaporanpendapatanruangan']['thn_akhir'];
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

    $this->render('pendapatanRuangan/adminPendapatanRuangan', array(
      'model' => $model, 'filter' => $filter, 'format' => $format
    ));
  }

  public function actionPrintLaporanPendapatanRuangan()
  {
    $model = new PILaporanpendapatanruangan('search');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Grafik Pendapatan Ruangan Rawat Intensif';
    $format = new MyFormatter();
    //Data Grafik        
    $data['title'] = 'Grafik Laporan Pendapatan Ruangan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['PILaporanpendapatanruangan'])) {
      $model->attributes = $_REQUEST['PILaporanpendapatanruangan'];
      $model->jns_periode = $_REQUEST['PILaporanpendapatanruangan']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PILaporanpendapatanruangan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PILaporanpendapatanruangan']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PILaporanpendapatanruangan']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PILaporanpendapatanruangan']['bln_akhir']);
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
    $target = 'pendapatanRuangan/_printPendapatanRuangan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanPendapatanRuangan()
  {
    $this->layout = '//layouts/iframe';
    $model = new PILaporanpendapatanruangan('search');
    $model->tgl_awal = date('d M Y H:i:s');
    $model->tgl_akhir = date('d M Y H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Pendapatan Ruangan Rawat Intensif';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_GET['PILaporanpendapatanruangan'])) {
      $model->attributes = $_GET['PILaporanpendapatanruangan'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PILaporanpendapatanruangan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PILaporanpendapatanruangan']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanPemakaiObatAlkes()
  {
    $this->pageTitle = Yii::app()->name . " - Pemakaian Obat Alkes Ruangan";
    $model = new PILaporanpemakaiobatalkesV('searchTable');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PILaporanpemakaiobatalkesV'])) {
      $model->attributes = $_GET['PILaporanpemakaiobatalkesV'];
      $model->jns_periode = $_GET['PILaporanpemakaiobatalkesV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PILaporanpemakaiobatalkesV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PILaporanpemakaiobatalkesV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PILaporanpemakaiobatalkesV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PILaporanpemakaiobatalkesV']['bln_akhir']);
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

    $this->render('pemakaiObatAlkes/adminPemakaiObatAlkes', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintLaporanPemakaiObatAlkes()
  {
    $model = new PILaporanpemakaiobatalkesV('searchTable');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Pemakai Obat Alkes Rawat Intensif';
    $format = new MyFormatter();

    //Data Grafik
    $data['title'] = 'Grafik Laporan Pemakai Obat Alkes Rawat Intensif';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);

    if (isset($_REQUEST['PILaporanpemakaiobatalkesV'])) {
      $model->attributes = $_REQUEST['PILaporanpemakaiobatalkesV'];
      $model->jns_periode = $_REQUEST['PILaporanpemakaiobatalkesV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PILaporanpemakaiobatalkesV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PILaporanpemakaiobatalkesV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PILaporanpemakaiobatalkesV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PILaporanpemakaiobatalkesV']['bln_akhir']);
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
    $target = 'pemakaiObatAlkes/_printPemakaiObatAlkes';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanPemakaiObatAlkes()
  {
    $this->layout = '//layouts/iframe';
    $model = new PILaporanpemakaiobatalkesV('searchGrafik');
    $model->tgl_awal = date('d M Y H:i:s');
    $model->tgl_akhir = date('d M Y H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Pemakai Obat Alkes Rawat Intensif';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_GET['PILaporanpemakaiobatalkesV'])) {
      $model->attributes = $_GET['PILaporanpemakaiobatalkesV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PILaporanpemakaiobatalkesV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PILaporanpemakaiobatalkesV']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanJasaInstalasi()
  {
    $this->pageTitle = Yii::app()->name . " - Jasa Instalasi";
    $model = new PILaporanjasainstalasi('searchTable');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PILaporanjasainstalasi'])) {
      $model->attributes = $_GET['PILaporanjasainstalasi'];
      $model->jns_periode = $_GET['PILaporanjasainstalasi']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PILaporanjasainstalasi']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PILaporanjasainstalasi']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PILaporanjasainstalasi']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PILaporanjasainstalasi']['bln_akhir']);
      $model->thn_awal = $_GET['PILaporanjasainstalasi']['thn_awal'];
      $model->thn_akhir = $_GET['PILaporanjasainstalasi']['thn_akhir'];
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
    $this->render('jasaInstalasi/adminJasaInstalasi', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintLaporanJasaInstalasi()
  {
    $model = new PILaporanjasainstalasi('searchTable');
    $judulLaporan = 'Laporan Jasa Instalasi Rawat Intensif';
    $format = new MyFormatter();

    //Data Grafik
    $data['title'] = 'Grafik Laporan Jasa Instalasi';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['PILaporanjasainstalasi'])) {
      $model->attributes = $_REQUEST['PILaporanjasainstalasi'];
      $model->jns_periode = $_REQUEST['PILaporanjasainstalasi']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PILaporanjasainstalasi']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PILaporanjasainstalasi']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PILaporanjasainstalasi']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PILaporanjasainstalasi']['bln_akhir']);
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
    $target = 'jasaInstalasi/_printJasaInstalasi';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanJasaInstalasi()
  {
    $this->layout = '//layouts/iframe';
    $model = new PILaporanjasainstalasi('searchGrafik');
    $model->tgl_awal = date('d M Y H:i:s');
    $model->tgl_akhir = date('d M Y H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Jasa Instalasi Rawat Intensif';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);
    if (isset($_GET['PILaporanjasainstalasi'])) {
      $model->attributes = $_GET['PILaporanjasainstalasi'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PILaporanjasainstalasi']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PILaporanjasainstalasi']['tgl_akhir']);
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
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  protected function parserTanggal($tgl)
  {
    $tgl = explode(' ', $tgl);
    $result = array();
    foreach ($tgl as $row) {
      if (!empty($row)) {
        $result[] = $row;
      }
    }
    return Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($result[0], 'yyyy-MM-dd'), 'medium', null) . ' ' . $result[1];
  }

  public function actionGetPenjaminPasienForCheckBox($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $carabayar_id = $_POST["$namaModel"]['carabayar_id'];

      if ($encode) {
        echo CJSON::encode($penjamin);
      } else {
        if (empty($carabayar_id)) {
          //                    $penjamin = PenjaminpasienM::model()->findAll();
          echo '<label>Data Tidak Ditemukan</label>';
        } else {
          $criteria = new CDbCriteria();
          $criteria->addCondition('carabayar_id = ' . $carabayar_id);
          $criteria->addCondition('penjamin_aktif is true');
          $criteria->order = 'penjamin_nama ASC';
          $penjamindata = PenjaminpasienM::model()->findAll($criteria);
          $penjamin = CHtml::listData($penjamindata, 'penjamin_id', 'penjamin_nama');
          echo CHtml::hiddenField('' . $namaModel . '[penjamin_id]');
          echo "<div style='margin-left:0px;'>" . CHtml::checkBox('checkAllCaraBayar', true, array(
            'onkeypress' => "return $(this).focusNextInputField(event)",
            'class' => 'checkbox-column', 'onclick' => 'checkAll()', 'checked' => 'checked'
          )) . " Pilih Semua";
          echo "</div><br/>";
          $i = 0;
          if (count((array)$penjamin) > 0) {
            foreach ($penjamin as $value => $name) {
              echo '<label class="checkbox">';
              echo CHtml::checkBox('' . $namaModel . '[penjamin_id][]', true, array('value' => $value));
              echo '<label for="' . $namaModel . '_penjamin_id_' . $i . '">' . $name . '</label></label>';

              $i++;
            }
          } else {
            echo '<label>Data Tidak Ditemukan</label>';
          }
        }
      }
    }
    Yii::app()->end();
  }

  //    public function actionLaporanKunjungan()
  //    {
  //        $model = new PILaporankunjunganriV('search');
  //        $model->tgl_awal = date('Y-m-d H:i:s');
  //        $model->tgl_akhir = date('Y-m-d H:i:s');
  //
  //        if (isset($_GET['PILaporankunjunganriV'])) {
  //            $model->attributes = $_GET['PILaporankunjunganriV'];
  //            $format = new MyFormatter();
  //            $model->tgl_awal = $format->formatDateTimeForDb($_GET['PILaporankunjunganriV']['tgl_awal']);
  //            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PILaporankunjunganriV']['tgl_akhir']);
  //        }
  //
  //
  //        $this->render('kunjungan/adminKunjungan', array(
  //            'model' => $model,
  //        ));
  //    }

  public function actionGetKabupaten($encode = false, $namaModel = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      if ($namaModel !== '' && $attr == '') {
        $propinsi_id = $_POST["$namaModel"]['propinsi_id'];
      } elseif ($namaModel == '' && $attr !== '') {
        $propinsi_id = $_POST["$attr"];
      } elseif ($namaModel !== '' && $attr !== '') {
        $propinsi_id = $_POST["$namaModel"]["$attr"];
      }
      $kabupaten = KabupatenM::model()->findAll('propinsi_id=' . $propinsi_id . ' and kabupaten_aktif = true ORDER BY kabupaten_nama asc');
      $kabupaten = CHtml::listData($kabupaten, 'kabupaten_id', 'kabupaten_nama');

      if ($encode) {
        echo CJSON::encode($kabupaten);
      } else {
        if (empty($kabupaten)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($kabupaten as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  public function actionGetKecamatan($encode = false, $namaModel = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      if ($namaModel !== '' && $attr == '') {
        $kabupaten_id = $_POST["$namaModel"]['kabupaten_id'];
      } elseif ($namaModel == '' && $attr !== '') {
        $kabupaten_id = $_POST["$attr"];
      } elseif ($namaModel !== '' && $attr !== '') {
        $kabupaten_id = $_POST["$namaModel"]["$attr"];
      }
      $kecamatan = KecamatanM::model()->findAll('kabupaten_id = ' . $kabupaten_id . ' ORDER BY kecamatan_nama asc');
      $kecamatan = CHtml::listData($kecamatan, 'kecamatan_id', 'kecamatan_nama');

      if ($encode) {
        echo CJSON::encode($kecamatan);
      } else {
        if (empty($kecamatan)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($kecamatan as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  public function actionGetKelurahan($encode = false, $namaModel = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      if ($namaModel !== '' && $attr == '') {
        $kecamatan_id = $_POST["$namaModel"]['kecamatan_id'];
      } elseif ($namaModel == '' && $attr !== '') {
        $kecamatan_id = $_POST["$attr"];
      } elseif ($namaModel !== '' && $attr !== '') {
        $kecamatan_id = $_POST["$namaModel"]["$attr"];
      }
      $kelurahan = KelurahanM::model()->findAll('kecamatan_id=' . $kecamatan_id . ' order by kelurahan_nama asc');
      $kelurahan = CHtml::listData($kelurahan, 'kelurahan_id', 'kelurahan_nama');

      if ($encode) {
        echo CJSON::encode($kelurahan);
      } else {
        if (empty($kelurahan)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($kelurahan as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  public function actionGetPenjaminPasien($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $carabayar_id = $_POST["$namaModel"]['carabayar_id'];

      if ($encode) {
        echo CJSON::encode($penjamin);
      } else {
        if (empty($carabayar_id)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $carabayar_id), array('order' => 'penjamin_nama ASC'));
          if (count((array)$penjamin) > 1) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          }
          $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
          foreach ($penjamin as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }


  public function actionLaporanCaraBayarDokter()
  {
    $model = new PILaporancarabayarriV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');

    //        $penjamin = CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif=TRUE'),'penjamin_id', 'penjamin_id');
    //        $model->penjamin_id = $penjamin;
    if (isset($_GET['PILaporancarabayarriV'])) {
      $model->attributes = $_GET['PILaporancarabayarriV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PILaporancarabayarriV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PILaporancarabayarriV']['tgl_akhir']);

      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $this->render('caraBayarDokter/adminCaraBayarDokter', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintLaporanCaraBayarDokter()
  {
    $model = new PILaporancarabayarriV('search');
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $judulLaporan = 'Laporan Jumlah Pasien Berdasarkan Penjamin';
    $format = new MyFormatter();
    //Data Grafik        
    $data['title'] = 'Grafik Laporan Jumlah Pasien Berdasarkan Penjamin';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['PILaporancarabayarriV'])) {
      $model->attributes = $_REQUEST['PILaporancarabayarriV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PILaporancarabayarriV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PILaporancarabayarriV']['tgl_akhir']);

      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'caraBayarDokter/_printCaraBayarDokter';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionLaporanPencapaianDokter()
  {
    $model = new PILaporanvisitedokterV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->nursestation_id = true;
    if (isset($_GET['PILaporanvisitedokterV'])) {
      $model->attributes = $_GET['PILaporanvisitedokterV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PILaporanvisitedokterV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PILaporanvisitedokterV']['tgl_akhir']);
      if (@$_GET['PILaporanvisitedokterV']['nursestation_id']) {
        $model->nursestation_id = $model->nursestation_id;
      } else {
        $model->nursestation_id = false;
      }
    }

    $this->render('pencapaianDokter/adminPencapaianDokter', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintLaporanPencapaianDokter()
  {
    $model = new PILaporanvisitedokterV('search');
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->nursestation_id = true;
    $judulLaporan = 'Laporan Pencapaian Dokter';
    $format = new MyFormatter();
    //Data Grafik        
    $data['title'] = 'Grafik Laporan Pencapaian Dokter';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['PILaporanvisitedokterV'])) {
      $model->attributes = $_REQUEST['PILaporanvisitedokterV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PILaporanvisitedokterV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PILaporanvisitedokterV']['tgl_akhir']);
      if (@$_GET['PILaporanvisitedokterV']['nursestation_id']) {
        $model->nursestation_id = $model->nursestation_id;
      } else {
        $model->nursestation_id = false;
      }
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'pencapaianDokter/_printPencapaianDokter';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionLaporanMorbiditasRuangan()
  {
    $format = new MyFormatter();
    $model = new PILaporanmorbiditasperruanganriV('search');
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    $models = array();

    if (isset($_GET['PILaporanmorbiditasperruanganriV'])) {
      $model->attributes = $_GET['PILaporanmorbiditasperruanganriV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PILaporanmorbiditasperruanganriV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PILaporanmorbiditasperruanganriV']['tgl_akhir']);
      $model->is_nursestation = $_GET['PILaporanmorbiditasperruanganriV']['is_nursestation'];
      $model->ruangan_id = isset($_GET['PILaporanmorbiditasperruanganriV']['ruangan_id']) ? $_GET['PILaporanmorbiditasperruanganriV']['ruangan_id'] : null;
    }

    $criteria = new CDbCriteria;
    $criteria->select = "diagnosa_kode,diagnosa_nama,sum(umur_0_6hr_lakilaki) as umur_0_6hr_lakilaki,
        sum(umur_0_6hr_perempuan) as umur_0_6hr_perempuan,
        sum(umur_6_28hr_lakilaki) as umur_6_28hr_lakilaki,
        sum(umur_6_28hr_perempuan) as umur_6_28hr_perempuan,
        sum(umur_28hr_1thn_lakilaki) as umur_28hr_1thn_lakilaki,
        sum(umur_28hr_1thn_perempuan) as umur_28hr_1thn_perempuan,
        sum(umur_1_4thn_lakilaki) as umur_1_4thn_lakilaki,
        sum(umur_1_4thn_perempuan) as umur_1_4thn_perempuan,
        sum(umur_5_14thn_lakilaki) as umur_5_14thn_lakilaki,
        sum(umur_5_14thn_perempuan) as umur_5_14thn_perempuan,
        sum(umur_15_24thn_lakilaki) as umur_15_24thn_lakilaki,
        sum(umur_15_24thn_perempuan) as umur_15_24thn_perempuan,
        sum(umur_25_44thn_lakilaki) as umur_25_44thn_lakilaki,
        sum(umur_25_44thn_perempuan) as umur_25_44thn_perempuan,
        sum(umur_45_64thn_lakilaki) as umur_45_64thn_lakilaki,
        sum(umur_45_64thn_perempuan) as umur_45_64thn_perempuan,
        sum(umur_65_lakilaki) as umur_65_lakilaki,
        sum(umur_65_perempuan) as umur_65_perempuan,
        sum(jml_lakilaki) AS jml_lakilaki, sum(jml_perempuan) AS jml_perempuan,
        sum(pasienkeluarhidup) AS pasienkeluarhidup, sum(pasienkeluarmati) AS pasienkeluarmati,
        ruangan_id,
        ruangan_nama";
    $criteria->addBetweenCondition('DATE(tglpulang)', $format->formatDateTimeForDb($model->tgl_awal), $format->formatDateTimeForDb($model->tgl_akhir));
    if ($model->is_nursestation) {
      if (empty($model->ruangan_id)) {
        $modRuangNurse = NursestationruanganM::model()->find('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
        $arayRuangan = array();
        if (isset($modRuangNurse->nursestation_id)) {
          $modNurse = NursestationruanganM::model()->findAll('nursestation_id = ' . $modRuangNurse->nursestation_id);
          foreach ($modNurse as $value) {
            $arayRuangan[] = $value->ruangan_id;
          }
        }
        $criteria->addInCondition('ruangan_id', $arayRuangan);
      } else {
        $criteria->addCondition('ruangan_id = ' . $model->ruangan_id);
      }
    } else {
      $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
    }
    $criteria->group = "diagnosa_kode, diagnosa_nama, ruangan_id, ruangan_nama";
    $models = PILaporanmorbiditasperruanganriV::model()->findAll($criteria);

    if (Yii::app()->request->isAjaxRequest) {
      echo $this->renderPartial($this->path_view . 'morbiditas._tablePencapaianDokter', array('model' => $model, 'models' => $models), true);
    } else {
      $this->render($this->path_view . 'morbiditas/adminMorbiditasRuangan', array(
        'model' => $model,
        'models' => $models,
      ));
    }
  }

  public function actionPrintLaporanMorbiditasRuangan()
  {
    $format = new MyFormatter();
    $model = new PILaporanmorbiditasperruanganriV('search');
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    $models = array();

    if (isset($_REQUEST['PILaporanmorbiditasperruanganriV'])) {
      $model->attributes = $_REQUEST['PILaporanmorbiditasperruanganriV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PILaporanmorbiditasperruanganriV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PILaporanmorbiditasperruanganriV']['tgl_akhir']);
      $model->is_nursestation = $_REQUEST['PILaporanmorbiditasperruanganriV']['is_nursestation'];
      $model->ruangan_id = isset($_REQUEST['PILaporanmorbiditasperruanganriV']['ruangan_id']) ? $_REQUEST['PILaporanmorbiditasperruanganriV']['ruangan_id'] : null;
    }

    $criteria = new CDbCriteria;
    $criteria->select = "diagnosa_kode,diagnosa_nama,sum(umur_0_6hr_lakilaki) as umur_0_6hr_lakilaki,
        sum(umur_0_6hr_perempuan) as umur_0_6hr_perempuan,
        sum(umur_6_28hr_lakilaki) as umur_6_28hr_lakilaki,
        sum(umur_6_28hr_perempuan) as umur_6_28hr_perempuan,
        sum(umur_28hr_1thn_lakilaki) as umur_28hr_1thn_lakilaki,
        sum(umur_28hr_1thn_perempuan) as umur_28hr_1thn_perempuan,
        sum(umur_1_4thn_lakilaki) as umur_1_4thn_lakilaki,
        sum(umur_1_4thn_perempuan) as umur_1_4thn_perempuan,
        sum(umur_5_14thn_lakilaki) as umur_5_14thn_lakilaki,
        sum(umur_5_14thn_perempuan) as umur_5_14thn_perempuan,
        sum(umur_15_24thn_lakilaki) as umur_15_24thn_lakilaki,
        sum(umur_15_24thn_perempuan) as umur_15_24thn_perempuan,
        sum(umur_25_44thn_lakilaki) as umur_25_44thn_lakilaki,
        sum(umur_25_44thn_perempuan) as umur_25_44thn_perempuan,
        sum(umur_45_64thn_lakilaki) as umur_45_64thn_lakilaki,
        sum(umur_45_64thn_perempuan) as umur_45_64thn_perempuan,
        sum(umur_65_lakilaki) as umur_65_lakilaki,
        sum(umur_65_perempuan) as umur_65_perempuan,
        sum(jml_lakilaki) AS jml_lakilaki, sum(jml_perempuan) AS jml_perempuan,
        sum(pasienkeluarhidup) AS pasienkeluarhidup, sum(pasienkeluarmati) AS pasienkeluarmati,
        ruangan_id,
        ruangan_nama";
    $criteria->addBetweenCondition('DATE(tglpulang)', $format->formatDateTimeForDb($model->tgl_awal), $format->formatDateTimeForDb($model->tgl_akhir));
    if ($model->is_nursestation) {
      if (empty($model->ruangan_id)) {
        $modRuangNurse = NursestationruanganM::model()->find('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
        $arayRuangan = array();
        if (isset($modRuangNurse->nursestation_id)) {
          $modNurse = NursestationruanganM::model()->findAll('nursestation_id = ' . $modRuangNurse->nursestation_id);
          foreach ($modNurse as $value) {
            $arayRuangan[] = $value->ruangan_id;
          }
        }
        $criteria->addInCondition('ruangan_id', $arayRuangan);
        $modRuangNurse = NursestationruanganM::model()->find('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
        $judulLaporan = 'Laporan Moriditas ' . NursestationM::model()->findByPk($modRuangNurse->nursestation_id)->nursestation_nama;
      } else {
        $criteria->addCondition('ruangan_id = ' . $model->ruangan_id);
        $judulLaporan = 'Laporan Moriditas Ruangan ' . RuanganM::model()->findByPk($model->ruangan_id)->ruangan_nama;
      }
    } else {
      $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
      $judulLaporan = 'Laporan Moriditas Ruangan ' . Yii::app()->user->getState('ruangan_nama');
    }
    $criteria->group = "diagnosa_kode, diagnosa_nama, ruangan_id, ruangan_nama";
    $models = PILaporanmorbiditasperruanganriV::model()->findAll($criteria);

    //Data Grafik
    $data['type'] = $_REQUEST['type'];
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view . 'morbiditas/_printMorbiditasRuangan';

    $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);

    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'models' => $models));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'models' => $models));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'models' => $models), true));
      $mpdf->Output();
    }
  }

  /*
     * ======================== PEMBEBASAN TARIF ===============================
     */

  public function actionLaporanPembebasanTarif()
  {
    $this->pageTitle = Yii::app()->name . " - Pembebasan Tarif";
    $model = new PILaporanpembebasantarifV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

    $filter = null;
    if (isset($_GET['PILaporanpembebasantarifV'])) {
      $model->attributes = $_GET['PILaporanpembebasantarifV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_REQUEST['PILaporanpembebasantarifV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PILaporanpembebasantarifV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PILaporanpembebasantarifV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PILaporanpembebasantarifV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PILaporanpembebasantarifV']['bln_akhir']);
      $model->thn_awal = $_GET['PILaporanpembebasantarifV']['thn_awal'];
      $model->thn_akhir = $_GET['PILaporanpembebasantarifV']['thn_akhir'];
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

    $this->render('pembebasanTarif/index', array(
      'model' => $model, 'filter' => $filter
    ));
  }

  public function actionPrintLaporanPembebasanTarif()
  {
    $model = new PILaporanpembebasantarifV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $judulLaporan = 'Laporan Pembebasan Tarif';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Pembebasan Tarif';
    $data['type'] = $_REQUEST['type'];
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
    if (isset($_REQUEST['PILaporanpembebasantarifV'])) {
      $model->attributes = $_REQUEST['PILaporanpembebasantarifV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_REQUEST['PILaporanpembebasantarifV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PILaporanpembebasantarifV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PILaporanpembebasantarifV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PILaporanpembebasantarifV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PILaporanpembebasantarifV']['bln_akhir']);
      $model->thn_awal = $_GET['PILaporanpembebasantarifV']['thn_awal'];
      $model->thn_akhir = $_GET['PILaporanpembebasantarifV']['thn_akhir'];
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
    $target = 'pembebasanTarif/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }


  public function actionFrameGrafikLaporanPembebasanTarif()
  {
    $this->layout = '//layouts/iframe';
    $model = new PILaporanpembebasantarifV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    //Data Grafik
    $data['title'] = 'Grafik Laporan Pembebasan Tarif';
    $data['type'] = $_GET['type'];
    if (isset($_GET['PILaporanpembebasantarifV'])) {
      $model->attributes = $_GET['PILaporanpembebasantarifV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_REQUEST['PILaporanpembebasantarifV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PILaporanpembebasantarifV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PILaporanpembebasantarifV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PILaporanpembebasantarifV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PILaporanpembebasantarifV']['bln_akhir']);
      $model->thn_awal = $_GET['PILaporanpembebasantarifV']['thn_awal'];
      $model->thn_akhir = $_GET['PILaporanpembebasantarifV']['thn_akhir'];
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

  /*
     * ======================== END PEMBEBASAN TARIF ===========================
     */



/*
     * ======================== Tindakan Ruangan ===============================
     */
  public function actionLaporanTindakanRuangan()
  {
    $this->pageTitle = Yii::app()->name . " - Tindakan Ruangan";
    $model = new PILaporantindakanruangan('search');
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
    $filter = (isset($_GET['filter']) ? $_GET['filter'] : null);

    if (isset($_GET['PILaporantindakanruangan'])) {
      $model->attributes = $_GET['PILaporantindakanruangan'];
      $model->jns_periode = $_GET['PILaporantindakanruangan']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PILaporantindakanruangan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PILaporantindakanruangan']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PILaporantindakanruangan']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PILaporantindakanruangan']['bln_akhir']);
      $model->thn_awal = $_GET['PILaporantindakanruangan']['thn_awal'];
      $model->thn_akhir = $_GET['PILaporantindakanruangan']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime(''.$model->bln_akhir));
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

    $this->render('tindakanRuangan/adminTindakanRuangan', array(
      'model' => $model, 'filter' => $filter, 'format' => $format
    ));
  }

  public function actionPrintLaporanTindakanRuangan()
  {
    $model = new PILaporantindakanruangan('search');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Grafik Tindakan Ruangan Rawat Intensif';
    $format = new MyFormatter();
    //Data Grafik        
    $data['title'] = 'Grafik Laporan Tindakan Ruangan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['PILaporantindakanruangan'])) {
      $model->attributes = $_REQUEST['PILaporantindakanruangan'];
      $model->jns_periode = $_REQUEST['PILaporantindakanruangan']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PILaporantindakanruangan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PILaporantindakanruangan']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PILaporantindakanruangan']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PILaporantindakanruangan']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime(''. $model->bln_akhir));
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
    $target = 'tindakanRuangan/_printTindakanRuangan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanTindakanRuangan()
  {
    $this->layout = '//layouts/iframe';
    $model = new PILaporantindakanruangan('search');
    $model->tgl_awal = date('d M Y H:i:s');
    $model->tgl_akhir = date('d M Y H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Tindakan Ruangan Rawat Intensif';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_GET['PILaporantindakanruangan'])) {
      $model->attributes = $_GET['PILaporantindakanruangan'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PILaporantindakanruangan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PILaporantindakanruangan']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  /*
     * ======================== END Tindakan Ruangan ===========================
     */
}
