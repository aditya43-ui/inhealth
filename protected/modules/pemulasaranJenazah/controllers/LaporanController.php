<?php

class LaporanController extends MyAuthController
{
  public function actionLaporanSensusHarian()
  {
    $this->pageTitle = Yii::app()->name . " - Sensus Harian";
    $model = new PJLaporansensuspenunjangV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $kunjungan = LookupM::getItems('kunjungan');
    $model->kunjungan = $kunjungan;
    if (isset($_GET['PJLaporansensuspenunjangV'])) {
      $model->attributes = $_GET['PJLaporansensuspenunjangV'];
      $model->jns_periode = $_GET['PJLaporansensuspenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PJLaporansensuspenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PJLaporansensuspenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PJLaporansensuspenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PJLaporansensuspenunjangV']['bln_akhir']);
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

    $this->render('sensus/index', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintLaporanSensusHarian()
  {
    $model = new PJLaporansensuspenunjangV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Sensus Harian Pemulasaran Jenazah';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Sensus Harian';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['PJLaporansensuspenunjangV'])) {
      $model->attributes = $_REQUEST['PJLaporansensuspenunjangV'];
      $model->jns_periode = $_REQUEST['PJLaporansensuspenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PJLaporansensuspenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PJLaporansensuspenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PJLaporansensuspenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PJLaporansensuspenunjangV']['bln_akhir']);
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
    $target = 'sensus/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikSensusHarian()
  {
    $this->layout = '//layouts/iframe';
    $model = new PJLaporansensuspenunjangV('search');
    $model->tgl_awal = date('Y-m-d 00:00:00');
    $model->tgl_akhir = date('Y-m-d H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Sensus Harian';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PJLaporansensuspenunjangV'])) {
      $model->attributes = $_GET['PJLaporansensuspenunjangV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PJLaporansensuspenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PJLaporansensuspenunjangV']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanKunjungan()
  {
    $model = new PJLaporanpasienpenunjangV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->kunjungan = LookupM::getItems('kunjungan');
    if (isset($_GET['PJLaporanpasienpenunjangV'])) {
      $model->attributes = $_GET['PJLaporanpasienpenunjangV'];
      $model->jns_periode = $_GET['PJLaporanpasienpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PJLaporanpasienpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PJLaporanpasienpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PJLaporanpasienpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PJLaporanpasienpenunjangV']['bln_akhir']);
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

    $this->render('kunjungan/index', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintLaporanKunjungan()
  {
    $model = new PJLaporanpasienpenunjangV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pemulasaran Jenazah';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pemulasaran Jenazah';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['PJLaporanpasienpenunjangV'])) {
      $model->attributes = $_REQUEST['PJLaporanpasienpenunjangV'];
      $model->jns_periode = $_REQUEST['PJLaporanpasienpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PJLaporanpasienpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PJLaporanpasienpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PJLaporanpasienpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PJLaporanpasienpenunjangV']['bln_akhir']);
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
    $target = 'kunjungan/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikKunjungan()
  {
    $this->layout = '//layouts/iframe';
    $model = new PJLaporanpasienpenunjangV('search');
    $model->tgl_awal = date('Y-m-d 00:00:00');
    $model->tgl_akhir = date('Y-m-d H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Sensus Harian';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PJLaporanpasienpenunjangV'])) {
      $model->attributes = $_GET['PJLaporanpasienpenunjangV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PJLaporanpasienpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PJLaporanpasienpenunjangV']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporan10BesarPenyakit()
  {
    $model = new PJLaporan10besarpenyakit('search');
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

    if (isset($_GET['PJLaporan10besarpenyakit'])) {
      $model->attributes = $_GET['PJLaporan10besarpenyakit'];
      $model->jns_periode = $_GET['PJLaporan10besarpenyakit']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PJLaporan10besarpenyakit']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PJLaporan10besarpenyakit']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PJLaporan10besarpenyakit']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PJLaporan10besarpenyakit']['bln_akhir']);
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
      echo $this->renderPartial('pemulasaranJenazah.views.laporan.10Besar._table', array('model' => $model, 'format' => $format), true);
    } else {
      $this->render('10Besar/index', array(
        'model' => $model, 'format' => $format
      ));
    }
  }

  public function actionPrintLaporan10BesarPenyakit()
  {
    $model = new PJLaporan10besarpenyakit('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan 10 Besar Penyakit Pasien Pemulasaran Jenazah';

    //Data Grafik
    $data['title'] = 'Grafik Laporan 10 Besar Penyakit Pasien Pemulasaran Jenazah';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['PJLaporan10besarpenyakit'])) {
      $model->attributes = $_REQUEST['PJLaporan10besarpenyakit'];
      $model->jns_periode = $_REQUEST['PJLaporan10besarpenyakit']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PJLaporan10besarpenyakit']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PJLaporan10besarpenyakit']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PJLaporan10besarpenyakit']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PJLaporan10besarpenyakit']['bln_akhir']);
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
    $model = new PJLaporan10besarpenyakit('searchGrafik');
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
    $data['title'] = 'Grafik Laporan 10 Besar Penyakit Pemulasaran Jenazah';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);
    if (isset($_GET['PJLaporan10besarpenyakit'])) {
      $model->attributes = $_GET['PJLaporan10besarpenyakit'];
      $model->jns_periode = $_GET['PJLaporan10besarpenyakit']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PJLaporan10besarpenyakit']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PJLaporan10besarpenyakit']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PJLaporan10besarpenyakit']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PJLaporan10besarpenyakit']['bln_akhir']);
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

    $this->render('10Besar/_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanPemakaiObatAlkes()
  {
    $this->pageTitle = Yii::app()->name . " - Pemakaian Obat Alkes Ruangan";
    $model = new PJLaporanpemakaiobatalkesruanganV;
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime("first day of this month"));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $jenisObat = CHtml::listData(JenisobatalkesM::model()->findAll('jenisobatalkes_aktif = true'), 'jenisobatalkes_id', 'jenisobatalkes_id');
    $model->jenisobatalkes_id = $jenisObat;
    if (isset($_GET['PJLaporanpemakaiobatalkesruanganV'])) {
      $model->attributes = $_GET['PJLaporanpemakaiobatalkesruanganV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['PJLaporanpemakaiobatalkesruanganV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PJLaporanpemakaiobatalkesruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PJLaporanpemakaiobatalkesruanganV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PJLaporanpemakaiobatalkesruanganV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PJLaporanpemakaiobatalkesruanganV']['bln_akhir']);
      $model->thn_awal = $_GET['PJLaporanpemakaiobatalkesruanganV']['thn_awal'];
      $model->thn_akhir = $_GET['PJLaporanpemakaiobatalkesruanganV']['thn_akhir'];
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
    $this->render('pemakaiObatAlkes/index', array('model' => $model, 'format' => $format));
  }

  public function actionPrintLaporanPemakaiObatAlkes()
  {
    $model = new PJLaporanpemakaiobatalkesruanganV('search');
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Info Pemakai Obat Alkes Radiologi';

    //Data Grafik       
    $data['title'] = 'Grafik Laporan Pemakai Obat Alkes Radiologi';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['PJLaporanpemakaiobatalkesruanganV'])) {
      $model->attributes = $_REQUEST['PJLaporanpemakaiobatalkesruanganV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['PJLaporanpemakaiobatalkesruanganV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PJLaporanpemakaiobatalkesruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PJLaporanpemakaiobatalkesruanganV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PJLaporanpemakaiobatalkesruanganV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PJLaporanpemakaiobatalkesruanganV']['bln_akhir']);
      $model->thn_awal = $_GET['PJLaporanpemakaiobatalkesruanganV']['thn_awal'];
      $model->thn_akhir = $_GET['PJLaporanpemakaiobatalkesruanganV']['thn_akhir'];
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

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'pemakaiObatAlkes/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }


  public function actionFrameGrafikLaporanPemakaiObatAlkes()
  {
    $this->layout = '//layouts/iframe';
    $model = new ROLaporanpemakaiobatalkesruanganV('search');
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Pemakai Obat Alkes Radiologi';
    $data['type'] = $_GET['type'];
    if (isset($_GET['PJLaporanpemakaiobatalkesruanganV'])) {
      $model->attributes = $_GET['PJLaporanpemakaiobatalkesruanganV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['PJLaporanpemakaiobatalkesruanganV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['ROLaporanpemakaiobatalkesruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PJLaporanpemakaiobatalkesruanganV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PJLaporanpemakaiobatalkesruanganV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PJLaporanpemakaiobatalkesruanganV']['bln_akhir']);
      $model->thn_awal = $_GET['PJLaporanpemakaiobatalkesruanganV']['thn_awal'];
      $model->thn_akhir = $_GET['PJLaporanpemakaiobatalkesruanganV']['thn_akhir'];
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

  public function actionLaporanJasaInstalasi()
  {
    $this->pageTitle = Yii::app()->name . " - Jasa Instalasi";
    $model = new PJLaporanjasainstalasi('search');
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
    $filter = (isset($_GET['filter_tab']) ? $_GET['filter_tab'] : null);
    if (isset($_GET['PJLaporanjasainstalasi'])) {
      $model->attributes = $_GET['PJLaporanjasainstalasi'];
      $model->jns_periode = $_GET['PJLaporanjasainstalasi']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PJLaporanjasainstalasi']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PJLaporanjasainstalasi']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PJLaporanjasainstalasi']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PJLaporanjasainstalasi']['bln_akhir']);
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

    $this->render('jasaInstalasi/index', array(
      'model' => $model, 'filter' => $filter, 'format' => $format
    ));
  }

  public function actionPrintLaporanJasaInstalasi()
  {
    $model = new PJLaporanjasainstalasi('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Jasa Instalasi Pemulasaran Jenazah';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Jasa Instalasi';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['PJLaporanjasainstalasi'])) {
      $model->attributes = $_REQUEST['PJLaporanjasainstalasi'];
      $model->jns_periode = $_REQUEST['PJLaporanjasainstalasi']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PJLaporanjasainstalasi']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PJLaporanjasainstalasi']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PJLaporanjasainstalasi']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PJLaporanjasainstalasi']['bln_akhir']);
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
    $target = 'jasaInstalasi/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanJasaInstalasi()
  {
    $this->layout = '//layouts/iframe';
    $model = new PJLaporanjasainstalasi('search');
    $model->tgl_awal = date('Y-m-d 00:00:00');
    $model->tgl_akhir = date('Y-m-d H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Jasa Instalasi';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);
    if (isset($_GET['PJLaporanjasainstalasi'])) {
      $model->attributes = $_GET['PJLaporanjasainstalasi'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PJLaporanjasainstalasi']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PJLaporanjasainstalasi']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanBiayaPelayanan()
  {
    $this->pageTitle = Yii::app()->name . " - Biaya Pelayanan";
    $model = new PJLaporanbiayapelayanan('search');
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
    if (isset($_GET['PJLaporanbiayapelayanan'])) {
      $model->attributes = $_GET['PJLaporanbiayapelayanan'];
      $model->jns_periode = $_GET['PJLaporanbiayapelayanan']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PJLaporanbiayapelayanan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PJLaporanbiayapelayanan']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PJLaporanbiayapelayanan']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PJLaporanbiayapelayanan']['bln_akhir']);
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

    $filter = (isset($_GET['filter_tab']) ? $_GET['filter_tab'] : null);
    $this->render('biayaPelayanan/index', array(
      'model' => $model, 'filter' => $filter, 'format' => $format
    ));
  }

  public function actionPrintLaporanBiayaPelayanan()
  {
    $model = new PJLaporanbiayapelayanan('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Biaya Pelayanan Pemulasaran Jenazah';

    //Data Grafik        
    $data['title'] = 'Grafik Laporan Biaya Pelayanan Pemulasaran Jenazah';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['PJLaporanbiayapelayanan'])) {
      $model->attributes = $_REQUEST['PJLaporanbiayapelayanan'];
      $model->jns_periode = $_REQUEST['PJLaporanbiayapelayanan']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PJLaporanbiayapelayanan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PJLaporanbiayapelayanan']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PJLaporanbiayapelayanan']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PJLaporanbiayapelayanan']['bln_akhir']);
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
    $target = 'biayaPelayanan/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanBiayaPelayanan()
  {
    $this->layout = '//layouts/iframe';
    $model = new PJLaporanbiayapelayanan('searchGrafik');
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
    $data['title'] = 'Grafik Laporan Biaya Pelayanan Pemulasaran Jenazah';
    $data['type'] = $_GET['type'];
    if (isset($_GET['PJLaporanbiayapelayanan'])) {
      $model->attributes = $_GET['PJLaporanbiayapelayanan'];
      $model->jns_periode = $_GET['PJLaporanbiayapelayanan']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PJLaporanbiayapelayanan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PJLaporanbiayapelayanan']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PJLaporanbiayapelayanan']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PJLaporanbiayapelayanan']['bln_akhir']);
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
    $this->pageTitle = Yii::app()->name . " - Pendapatan Ruangan";
    $model = new PJLaporanpendapatanruanganV('search');
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
    if (isset($_GET['PJLaporanpendapatanruanganV'])) {
      $model->attributes = $_GET['PJLaporanpendapatanruanganV'];
      $model->jns_periode = $_GET['PJLaporanpendapatanruanganV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PJLaporanpendapatanruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PJLaporanpendapatanruanganV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PJLaporanpendapatanruanganV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PJLaporanpendapatanruanganV']['bln_akhir']);
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
    $filter = (isset($_GET['filter_tab']) ? $_GET['filter_tab'] : null);
    $this->render('pendapatanRuangan/index', array(
      'model' => $model, 'filter' => $filter, 'format' => $format
    ));
  }

  public function actionPrintLaporanPendapatanRuangan()
  {
    $model = new PJLaporanpendapatanruanganV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Grafik Pendapatan Ruangan Pemulasaran Jenazah';

    //Data Grafik        
    $data['title'] = 'Grafik Laporan Pendapatan Ruangan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['PJLaporanpendapatanruanganV'])) {
      $model->attributes = $_REQUEST['PJLaporanpendapatanruanganV'];
      $model->jns_periode = $_REQUEST['PJLaporanpendapatanruanganV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PJLaporanpendapatanruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PJLaporanpendapatanruanganV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PJLaporanpendapatanruanganV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PJLaporanpendapatanruanganV']['bln_akhir']);
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
    $target = 'pendapatanRuangan/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanPendapatanRuangan()
  {
    $this->layout = '//layouts/iframe';
    $model = new PJLaporanpendapatanruanganV('search');
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
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);
    if (isset($_GET['PJLaporanpendapatanruanganV'])) {
      $model->attributes = $_GET['PJLaporanpendapatanruanganV'];
      $model->jns_periode = $_GET['PJLaporanpendapatanruanganV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PJLaporanpendapatanruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PJLaporanpendapatanruanganV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PJLaporanpendapatanruanganV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PJLaporanpendapatanruanganV']['bln_akhir']);
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
    $model = new PJBukuregisterpenunjangV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PJBukuregisterpenunjangV'])) {
      $model->attributes = $_GET['PJBukuregisterpenunjangV'];
      $model->jns_periode = $_GET['PJBukuregisterpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PJBukuregisterpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PJBukuregisterpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PJBukuregisterpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PJBukuregisterpenunjangV']['bln_akhir']);
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

    $this->render('bukuRegister/index', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintLaporanBukuRegister()
  {
    $model = new PJBukuregisterpenunjangV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Buku Register Pasien Pemulasaran Jenazah';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Buku Register Pasien Pemulasaran Jenazah';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['PJBukuregisterpenunjangV'])) {
      $model->attributes = $_REQUEST['PJBukuregisterpenunjangV'];
      $model->jns_periode = $_REQUEST['PJBukuregisterpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PJBukuregisterpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PJBukuregisterpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PJBukuregisterpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PJBukuregisterpenunjangV']['bln_akhir']);
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
    $target = 'bukuRegister/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikBukuRegister()
  {
    $this->layout = '//layouts/iframe';
    $model = new PJBukuregisterpenunjangV('searchGrafik');
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
    $data['title'] = 'Grafik Laporan Buku Register Pasien Pemulasaran Jenazah';
    $data['type'] = $_GET['type'];
    if (isset($_GET['PJBukuregisterpenunjangV'])) {
      $model->attributes = $_GET['PJBukuregisterpenunjangV'];
      $model->jns_periode = $_GET['PJBukuregisterpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PJBukuregisterpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PJBukuregisterpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PJBukuregisterpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PJBukuregisterpenunjangV']['bln_akhir']);
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
    $model = new PJLaporancaramasukpenunjangV('search');
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
    $model->asalrujukan_id = $asalrujukan;
    $ruanganasal = CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true'), 'ruangan_id', 'ruangan_id');
    $model->ruanganasal_id = $ruanganasal;
    if (isset($_GET['PJLaporancaramasukpenunjangV'])) {
      $model->attributes = $_GET['PJLaporancaramasukpenunjangV'];
      $model->jns_periode = $_GET['PJLaporancaramasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PJLaporancaramasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PJLaporancaramasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PJLaporancaramasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PJLaporancaramasukpenunjangV']['bln_akhir']);
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

    $filter = (isset($_GET['filter_tab']) ? $_GET['filter_tab'] : null);
    $this->render('caraMasuk/index', array(
      'model' => $model, 'filter' => $filter, 'format' => $format
    ));
  }

  public function actionPrintLaporanCaraMasukPasien()
  {
    $model = new PJLaporancaramasukpenunjangV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Cara Masuk Pasien Pemulasaran Jenazah';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Cara Masuk Pasien';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['PJLaporancaramasukpenunjangV'])) {
      $model->attributes = $_REQUEST['PJLaporancaramasukpenunjangV'];
      $model->jns_periode = $_REQUEST['PJLaporancaramasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PJLaporancaramasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PJLaporancaramasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PJLaporancaramasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PJLaporancaramasukpenunjangV']['bln_akhir']);
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
    $model = new PJLaporancaramasukpenunjangV('search');
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
    if (isset($_GET['PJLaporancaramasukpenunjangV'])) {
      $model->attributes = $_GET['PJLaporancaramasukpenunjangV'];
      $model->jns_periode = $_GET['PJLaporancaramasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PJLaporancaramasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PJLaporancaramasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PJLaporancaramasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PJLaporancaramasukpenunjangV']['bln_akhir']);
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
}
