<?php

Yii::import('application.modules.billingKasir.models.*');

/**
 * digunakan untuk fungsi laporan bedah central
 * BMB-198
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * @package         application.modules.bedahSentral
 * @subpackage      controllers
 * 
 */
class LaporanController extends MyAuthController
{
  public $path_view = 'bedahSentral.views.laporan.';

  /**
   * digunakan untuk menampilkan informasi laporan sensus harian
   */
  public function actionLaporanSensusHarian()
  {
    $this->pageTitle = Yii::app()->name . " - Sensus Harian";
    $model = new BSLaporansensuspenunjangV('search');
    $format = new MyFormatter();
    $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $kunjungan = BSLaporansensuspenunjangV::getKunjungan('kunjungan');
    $model->kunjungan = $kunjungan;
    if (isset($_GET['BSLaporansensuspenunjangV'])) {
      $model->attributes = $_GET['BSLaporansensuspenunjangV'];
      $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['BSLaporansensuspenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSLaporansensuspenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSLaporansensuspenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BSLaporansensuspenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BSLaporansensuspenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['BSLaporansensuspenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['BSLaporansensuspenunjangV']['thn_akhir'];
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
      'model' => $model,
    ));
  }

  /**
   * digunakan untuk cetak laporan sesnsus harian
   */
  public function actionPrintLaporanSensusHarian()
  {
    $model = new BSLaporansensuspenunjangV('search');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Sensus Harian Bedah Sentral';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Sensus Harian';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['BSLaporansensuspenunjangV'])) {
      $model->attributes = $_REQUEST['BSLaporansensuspenunjangV'];
      $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['BSLaporansensuspenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSLaporansensuspenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSLaporansensuspenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BSLaporansensuspenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BSLaporansensuspenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['BSLaporansensuspenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['BSLaporansensuspenunjangV']['thn_akhir'];
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

  /**
   * digunakan untuk menampilkan grafik sensus harian
   */
  public function actionFrameGrafikSensusHarian()
  {
    $this->layout = '//layouts/iframe';
    $model = new BSLaporansensuspenunjangV('search');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Sensus Harian';
    $data['type'] = $_GET['type'];

    if (isset($_GET['BSLaporansensuspenunjangV'])) {
      $model->attributes = $_GET['BSLaporansensuspenunjangV'];
      $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['BSLaporansensuspenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSLaporansensuspenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSLaporansensuspenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BSLaporansensuspenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BSLaporansensuspenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['BSLaporansensuspenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['BSLaporansensuspenunjangV']['thn_akhir'];
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

  /**
   * digunakan untuk menampilkan informasi laporan kunjungan
   */
  public function actionLaporanKunjungan()
  {
    $this->pageTitle = Yii::app()->name . " - Kunjungan Pasien";
    $model = new BSLaporanpasienpenunjangV('search');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->kunjungan = BSLaporanpasienpenunjangV::getKunjungan('kunjungan');
    if (isset($_GET['BSLaporanpasienpenunjangV'])) {
      $model->attributes = $_GET['BSLaporanpasienpenunjangV'];
      $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['BSLaporanpasienpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSLaporanpasienpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSLaporanpasienpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BSLaporanpasienpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BSLaporanpasienpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['BSLaporanpasienpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['BSLaporanpasienpenunjangV']['thn_akhir'];
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
      'model' => $model,
    ));
  }

  /**
   * digunakan untuk cetak laporan kunjungan
   */
  public function actionPrintLaporanKunjungan()
  {
    $model = new BSLaporanpasienpenunjangV('search');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Bedah Sentral';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Bedah Sentral';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['BSLaporanpasienpenunjangV'])) {
      $model->attributes = $_REQUEST['BSLaporanpasienpenunjangV'];
      $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['BSLaporanpasienpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSLaporanpasienpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSLaporanpasienpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BSLaporanpasienpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BSLaporanpasienpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['BSLaporanpasienpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['BSLaporanpasienpenunjangV']['thn_akhir'];
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
    $target = 'kunjungan/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  /**
   * digunkan untuk menampilkan grafik kunjungan
   */
  public function actionFrameGrafikKunjungan()
  {
    $this->layout = '//layouts/iframe';
    $model = new BSLaporanpasienpenunjangV('search');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Sensus Harian';
    $data['type'] = $_GET['type'];

    if (isset($_GET['BSLaporanpasienpenunjangV'])) {
      $model->attributes = $_GET['BSLaporanpasienpenunjangV'];
      $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['BSLaporanpasienpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSLaporanpasienpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSLaporanpasienpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BSLaporanpasienpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BSLaporanpasienpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['BSLaporanpasienpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['BSLaporanpasienpenunjangV']['thn_akhir'];
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

  /**
   * digunakan untuk menampilkan informasi laporan 10 besar penyakit
   */
  public function actionLaporan10BesarPenyakit()
  {
    $this->pageTitle = Yii::app()->name . " - 10 Besar Penyakit";
    $model = new BSLaporan10besarpenyakit('search');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->jumlahTampil = 10;

    if (isset($_GET['BSLaporan10besarpenyakit'])) {
      $model->attributes = $_GET['BSLaporan10besarpenyakit'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['BSLaporan10besarpenyakit']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSLaporan10besarpenyakit']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSLaporan10besarpenyakit']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BSLaporan10besarpenyakit']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BSLaporan10besarpenyakit']['bln_akhir']);
      $model->thn_awal = $_GET['BSLaporan10besarpenyakit']['thn_awal'];
      $model->thn_akhir = $_GET['BSLaporan10besarpenyakit']['thn_akhir'];
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
      'model' => $model,
    ));
  }

  /**
   * digunakan untuk cetak laporan 10 besar penyakit
   */
  public function actionPrintLaporan10BesarPenyakit()
  {
    $model = new BSLaporan10besarpenyakit('search');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan 10 Besar Penyakit Pasien Bedah Sentral';

    //Data Grafik
    $data['title'] = 'Grafik Laporan 10 Besar Penyakit Pasien Bedah Sentral';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['BSLaporan10besarpenyakit'])) {
      $model->attributes = $_REQUEST['BSLaporan10besarpenyakit'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['BSLaporan10besarpenyakit']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSLaporan10besarpenyakit']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSLaporan10besarpenyakit']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BSLaporan10besarpenyakit']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BSLaporan10besarpenyakit']['bln_akhir']);
      $model->thn_awal = $_GET['BSLaporan10besarpenyakit']['thn_awal'];
      $model->thn_akhir = $_GET['BSLaporan10besarpenyakit']['thn_akhir'];
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

  /**
   * digunakan untuk menampilkan grafik 10 besar penyakit
   */
  public function actionFrameGrafik10BesarPenyakit()
  {
    $this->layout = '//layouts/iframe';
    $model = new BSLaporan10besarpenyakit('search');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan 10 Besar Penyakit Bedah Sentral';
    $data['type'] = $_GET['type'];
    if (isset($_GET['BSLaporan10besarpenyakit'])) {
      $model->attributes = $_GET['BSLaporan10besarpenyakit'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['BSLaporan10besarpenyakit']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSLaporan10besarpenyakit']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSLaporan10besarpenyakit']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BSLaporan10besarpenyakit']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BSLaporan10besarpenyakit']['bln_akhir']);
      $model->thn_awal = $_GET['BSLaporan10besarpenyakit']['thn_awal'];
      $model->thn_akhir = $_GET['BSLaporan10besarpenyakit']['thn_akhir'];
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

  /**
   * digunakan untuk menampilkan informasi laporan pemakai obat alkes
   */
  public function actionLaporanPemakaiObatAlkes()
  {
    $this->pageTitle = Yii::app()->name . " - Pemakaian Obat Alkes Ruangan";
    $model = new BSLaporanpemakaiobatalkesruanganV;
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $jenisObat = CHtml::listData(JenisobatalkesM::model()->findAll('jenisobatalkes_aktif = true'), 'jenisobatalkes_id', 'jenisobatalkes_id');
    $model->jenisobatalkes_id = $jenisObat;
    if (isset($_GET['BSLaporanpemakaiobatalkesruanganV'])) {
      $model->attributes = $_GET['BSLaporanpemakaiobatalkesruanganV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['BSLaporanpemakaiobatalkesruanganV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSLaporanpemakaiobatalkesruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSLaporanpemakaiobatalkesruanganV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BSLaporanpemakaiobatalkesruanganV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BSLaporanpemakaiobatalkesruanganV']['bln_akhir']);
      $model->thn_awal = $_GET['BSLaporanpemakaiobatalkesruanganV']['thn_awal'];
      $model->thn_akhir = $_GET['BSLaporanpemakaiobatalkesruanganV']['thn_akhir'];
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
    $this->render('pemakaiObatAlkes/index', array('model' => $model));
  }

  /**
   * digunakan untuk cetaki laporan pemakai obat alkes
   */
  public function actionPrintLaporanPemakaiObatAlkes()
  {
    $model = new BSLaporanpemakaiobatalkesruanganV('search');
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Pemakaian Obat dan Alkes Bedah Sentral';

    //Data Grafik       
    $data['title'] = 'Grafik Laporan Pemakaian Obat dan Alkes Bedah Sentral';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['BSLaporanpemakaiobatalkesruanganV'])) {
      $model->attributes = $_REQUEST['BSLaporanpemakaiobatalkesruanganV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['BSLaporanpemakaiobatalkesruanganV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSLaporanpemakaiobatalkesruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSLaporanpemakaiobatalkesruanganV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BSLaporanpemakaiobatalkesruanganV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BSLaporanpemakaiobatalkesruanganV']['bln_akhir']);
      $model->thn_awal = $_GET['BSLaporanpemakaiobatalkesruanganV']['thn_awal'];
      $model->thn_akhir = $_GET['BSLaporanpemakaiobatalkesruanganV']['thn_akhir'];
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

  /**
   * digunakan untuk menampilkan grafik laporan pemakai obat alkes
   */
  public function actionFrameGrafikLaporanPemakaiObatAlkes()
  {
    $this->layout = '//layouts/iframe';
    $model = new BSLaporanpemakaiobatalkesruanganV('search');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Pemakaian Obat dan Alkes Bedah Sentral';
    $data['type'] = $_GET['type'];
    if (isset($_GET['BSLaporanpemakaiobatalkesruanganV'])) {
      $model->attributes = $_GET['BSLaporanpemakaiobatalkesruanganV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['BSLaporanpemakaiobatalkesruanganV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSLaporanpemakaiobatalkesruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSLaporanpemakaiobatalkesruanganV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BSLaporanpemakaiobatalkesruanganV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BSLaporanpemakaiobatalkesruanganV']['bln_akhir']);
      $model->thn_awal = $_GET['BSLaporanpemakaiobatalkesruanganV']['thn_awal'];
      $model->thn_akhir = $_GET['BSLaporanpemakaiobatalkesruanganV']['thn_akhir'];
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

  /**
   * digunakan untuk menampilkan informasi laporan jasa instalasi
   */
  public function actionLaporanJasaInstalasi()
  {
    $model = new BSLaporanjasainstalasi('search');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    //  $penjamin = CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_id');
    // $model->penjamin_id = $penjamin;
    $tindakan = array('sudah', 'belum');
    $model->tindakansudahbayar_id = $tindakan;

    if (isset($_GET['BSLaporanjasainstalasi'])) {
      $model->attributes = $_GET['BSLaporanjasainstalasi'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['BSLaporanjasainstalasi']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSLaporanjasainstalasi']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSLaporanjasainstalasi']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BSLaporanjasainstalasi']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BSLaporanjasainstalasi']['bln_akhir']);
      $model->thn_awal = $_GET['BSLaporanjasainstalasi']['thn_awal'];
      $model->thn_akhir = $_GET['BSLaporanjasainstalasi']['thn_akhir'];
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
      'model' => $model,
      'format' => $format
    ));
  }

  /**
   * digunakan untuk cetak laporan jasa instalasi
   */
  public function actionPrintLaporanJasaInstalasi()
  {
    $model = new BSLaporanjasainstalasi('search');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Jasa Instalasi Bedah Sentral';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Jasa Instalasi';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['BSLaporanjasainstalasi'])) {
      $model->attributes = $_REQUEST['BSLaporanjasainstalasi'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['BSLaporanjasainstalasi']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSLaporanjasainstalasi']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSLaporanjasainstalasi']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BSLaporanjasainstalasi']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BSLaporanjasainstalasi']['bln_akhir']);
      $model->thn_awal = $_GET['BSLaporanjasainstalasi']['thn_awal'];
      $model->thn_akhir = $_GET['BSLaporanjasainstalasi']['thn_akhir'];
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
    $target = 'jasaInstalasi/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  /**
   * digunakan untuk menampilkan grafik jasa instalasi
   */
  public function actionFrameGrafikLaporanJasaInstalasi()
  {
    $this->layout = '//layouts/iframe';
    $model = new BSLaporanjasainstalasi('search');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Jasa Instalasi';
    $data['type'] = $_GET['type'];
    if (isset($_GET['BSLaporanjasainstalasi'])) {
      $model->attributes = $_GET['BSLaporanjasainstalasi'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['BSLaporanjasainstalasi']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSLaporanjasainstalasi']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSLaporanjasainstalasi']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BSLaporanjasainstalasi']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BSLaporanjasainstalasi']['bln_akhir']);
      $model->thn_awal = $_GET['BSLaporanjasainstalasi']['thn_awal'];
      $model->thn_akhir = $_GET['BSLaporanjasainstalasi']['thn_akhir'];
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

  /**
   * digunakan untuk menampilkan informasi biaya pelayanan
   */
  public function actionLaporanBiayaPelayanan()
  {
    $model = new BSLaporanbiayapelayanan('search');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    //  $penjamin = CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif=TRUE'),'penjamin_id', 'penjamin_id');
    //$model->penjamin_id = $penjamin;
    $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
    $model->kelaspelayanan_id = $kelas;
    if (isset($_GET['BSLaporanbiayapelayanan'])) {
      $model->attributes = $_GET['BSLaporanbiayapelayanan'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      //$model->jns_periode = $_GET['BSLaporanbiayapelayanan']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSLaporanbiayapelayanan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSLaporanbiayapelayanan']['tgl_akhir']);
      //            $model->bln_awal = $format->formatMonthForDb($_GET['BSLaporanbiayapelayanan']['bln_awal']);
      //            $model->bln_akhir = $format->formatMonthForDb($_GET['BSLaporanbiayapelayanan']['bln_akhir']);
      //            $model->thn_awal = $_GET['BSLaporanbiayapelayanan']['thn_awal'];
      //            $model->thn_akhir = $_GET['BSLaporanbiayapelayanan']['thn_akhir'];
      //            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
      //            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
      //            switch($model->jns_periode){
      //                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
      //                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
      //                default : null;
      //            }
      //            $model->tgl_awal = $model->tgl_awal." 00:00:00";
      //            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
    }

    $this->render('biayaPelayanan/index', array(
      'model' => $model
    ));
  }

  /**
   * digunakan untuk cetak laporan biaya pelayanan
   */
  public function actionPrintLaporanBiayaPelayanan()
  {
    $model = new BSLaporanbiayapelayanan('search');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $penjamin = CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif=TRUE'), 'penjamin_id', 'penjamin_id');
    $model->penjamin_id = $penjamin;
    $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
    $model->kelaspelayanan_id = $kelas;
    $judulLaporan = 'Laporan Biaya Pelayanan Bedah Sentral';

    //Data Grafik        
    $data['title'] = 'Grafik Laporan Biaya Pelayanan Bedah Sentral';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['BSLaporanbiayapelayanan'])) {
      $model->attributes = $_GET['BSLaporanbiayapelayanan'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      //$model->jns_periode = $_GET['BSLaporanbiayapelayanan']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSLaporanbiayapelayanan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSLaporanbiayapelayanan']['tgl_akhir']);
      //            $model->bln_awal = $format->formatMonthForDb($_GET['BSLaporanbiayapelayanan']['bln_awal']);
      //            $model->bln_akhir = $format->formatMonthForDb($_GET['BSLaporanbiayapelayanan']['bln_akhir']);
      //            $model->thn_awal = $_GET['BSLaporanbiayapelayanan']['thn_awal'];
      //            $model->thn_akhir = $_GET['BSLaporanbiayapelayanan']['thn_akhir'];
      //            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
      //            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
      //            switch($model->jns_periode){
      //                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
      //                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
      //                default : null;
      //            }
      //            $model->tgl_awal = $model->tgl_awal." 00:00:00";
      //            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'biayaPelayanan/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  /**
   * digunakan untuk menampilkan grafik laporan biaya pelayanan
   */
  public function actionFrameGrafikLaporanBiayaPelayanan()
  {
    $this->layout = '//layouts/iframe';
    $model = new BSLaporanbiayapelayanan('search');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Biaya Pelayanan Bedah Sentral';
    $data['type'] = $_GET['type'];
    if (isset($_GET['BSLaporanbiayapelayanan'])) {
      $model->attributes = $_GET['BSLaporanbiayapelayanan'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      //$model->jns_periode = $_GET['BSLaporanbiayapelayanan']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSLaporanbiayapelayanan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSLaporanbiayapelayanan']['tgl_akhir']);
      //            $model->bln_awal = $format->formatMonthForDb($_GET['BSLaporanbiayapelayanan']['bln_awal']);
      //            $model->bln_akhir = $format->formatMonthForDb($_GET['BSLaporanbiayapelayanan']['bln_akhir']);
      //            $model->thn_awal = $_GET['BSLaporanbiayapelayanan']['thn_awal'];
      //            $model->thn_akhir = $_GET['BSLaporanbiayapelayanan']['thn_akhir'];
      //            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
      //            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
      //            switch($model->jns_periode){
      //                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
      //                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
      //                default : null;
      //            }
      //            $model->tgl_awal = $model->tgl_awal." 00:00:00";
      //            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  /**
   * digunakan untuk menampilkan informasi laporan pendapatan ruangan
   */
  public function actionLaporanPendapatanRuangan()
  {
    $model = new BSLaporanpendapatanruanganV('search');
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    // $penjamin = CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_id');
    //$model->penjamin_id = $penjamin;
    $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
    $model->kelaspelayanan_id = $kelas;
    if (isset($_GET['BSLaporanpendapatanruanganV'])) {
      $model->attributes = $_GET['BSLaporanpendapatanruanganV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['BSLaporanpendapatanruanganV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSLaporanpendapatanruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSLaporanpendapatanruanganV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BSLaporanpendapatanruanganV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BSLaporanpendapatanruanganV']['bln_akhir']);
      $model->thn_awal = $_GET['BSLaporanpendapatanruanganV']['thn_awal'];
      $model->thn_akhir = $_GET['BSLaporanpendapatanruanganV']['thn_akhir'];
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
      'model' => $model
    ));
  }

  /**
   * digunakan untuk cetak laporan pendapatan ruangan
   */
  public function actionPrintLaporanPendapatanRuangan()
  {
    $model = new BSLaporanpendapatanruanganV('search');
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Pendapatan Ruangan Bedah Sentral';

    //Data Grafik        
    $data['title'] = 'Grafik Laporan Pendapatan Ruangan';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['BSLaporanpendapatanruanganV'])) {
      $model->attributes = $_REQUEST['BSLaporanpendapatanruanganV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['BSLaporanpendapatanruanganV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSLaporanpendapatanruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSLaporanpendapatanruanganV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BSLaporanpendapatanruanganV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BSLaporanpendapatanruanganV']['bln_akhir']);
      $model->thn_awal = $_GET['BSLaporanpendapatanruanganV']['thn_awal'];
      $model->thn_akhir = $_GET['BSLaporanpendapatanruanganV']['thn_akhir'];
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

  /**
   * digunakan untuk menampilkan grafik laporan pendapatan ruangan
   */
  public function actionFrameGrafikLaporanPendapatanRuangan()
  {
    $this->layout = '//layouts/iframe';
    $model = new BSLaporanpendapatanruanganV('search');
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Pendapatan Ruangan';
    $data['type'] = $_GET['type'];
    if (isset($_GET['BSLaporanpendapatanruanganV'])) {
      $model->attributes = $_GET['BSLaporanpendapatanruanganV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['BSLaporanpendapatanruanganV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSLaporanpendapatanruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSLaporanpendapatanruanganV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BSLaporanpendapatanruanganV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BSLaporanpendapatanruanganV']['bln_akhir']);
      $model->thn_awal = $_GET['BSLaporanpendapatanruanganV']['thn_awal'];
      $model->thn_akhir = $_GET['BSLaporanpendapatanruanganV']['thn_akhir'];
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

  /**
   * digunakan untuk menampilkan informasi laporan buku register
   */
  public function actionLaporanBukuRegister()
  {
    $this->pageTitle = Yii::app()->name . " - Buku Register";
    $model = new BSBukuregisterpenunjangV('search');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['BSBukuregisterpenunjangV'])) {
      $model->attributes = $_GET['BSBukuregisterpenunjangV'];
      $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['BSBukuregisterpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSBukuregisterpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSBukuregisterpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BSBukuregisterpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BSBukuregisterpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['BSBukuregisterpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['BSBukuregisterpenunjangV']['thn_akhir'];
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

  /**
   * digunakan untuk cetak buku register
   */
  public function actionPrintLaporanBukuRegister()
  {
    $model = new BSBukuregisterpenunjangV('search');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Buku Register Pasien Bedah Sentral';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Buku Register Pasien Bedah Sentral';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['BSBukuregisterpenunjangV'])) {
      $model->attributes = $_REQUEST['BSBukuregisterpenunjangV'];
      $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_REQUEST['BSBukuregisterpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BSBukuregisterpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BSBukuregisterpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['BSBukuregisterpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['BSBukuregisterpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['BSBukuregisterpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['BSBukuregisterpenunjangV']['thn_akhir'];
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

  /**
   * digunakan untuk menampilkan grafik buku register
   */
  public function actionFrameGrafikBukuRegister()
  {
    $this->layout = '//layouts/iframe';
    $model = new BSBukuregisterpenunjangV('search');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Buku Register Pasien Bedah Sentral';
    $data['type'] = $_GET['type'];
    if (isset($_GET['BSBukuregisterpenunjangV'])) {
      $model->attributes = $_GET['BSBukuregisterpenunjangV'];
      $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['BSBukuregisterpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSBukuregisterpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSBukuregisterpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BSBukuregisterpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BSBukuregisterpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['BSBukuregisterpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['BSBukuregisterpenunjangV']['thn_akhir'];
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

  /**
   * digunakan untuk menampilkan informasi laporan cara masuk pasien 
   */
  public function actionLaporanCaraMasukPasien()
  {
    $this->pageTitle = Yii::app()->name . " - Cara Masuk";
    $model = new BSLaporancaramasukpenunjangV('search');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->pilihan = 'instalasi';
    $asalrujukan = CHtml::listData(AsalrujukanM::model()->findAll('asalrujukan_aktif = true'), 'asalrujukan_id', 'asalrujukan_id');
    $model->asalrujukan_id = $asalrujukan;
    $ruanganasal = CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true'), 'ruangan_id', 'ruangan_id');
    $model->ruanganasal_id = $ruanganasal;
    if (isset($_GET['BSLaporancaramasukpenunjangV'])) {
      $model->attributes = $_GET['BSLaporancaramasukpenunjangV'];
      $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['BSLaporancaramasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSLaporancaramasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSLaporancaramasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BSLaporancaramasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BSLaporancaramasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['BSLaporancaramasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['BSLaporancaramasukpenunjangV']['thn_akhir'];
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
    if (empty($filter)) {
      $filter = null;
    }
    $this->render('caraMasuk/index', array(
      'model' => $model, 'filter' => $filter
    ));
  }

  /**
   * digunakan untuk cetak laporan cara masuk pasien
   */
  public function actionPrintLaporanCaraMasukPasien()
  {
    $model = new BSLaporancaramasukpenunjangV('search');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Cara Masuk Pasien Bedah Sentral';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Cara Masuk Pasien';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['BSLaporancaramasukpenunjangV'])) {
      $model->attributes = $_REQUEST['BSLaporancaramasukpenunjangV'];
      $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['BSLaporancaramasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSLaporancaramasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSLaporancaramasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BSLaporancaramasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BSLaporancaramasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['BSLaporancaramasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['BSLaporancaramasukpenunjangV']['thn_akhir'];
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

  /**
   * digunakan untuk menampilkan grafik laporan cara masuk pasien
   */
  public function actionFrameGrafikLaporanCaraMasukPasien()
  {
    $this->layout = '//layouts/iframe';
    $model = new BSLaporancaramasukpenunjangV('search');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
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
    if (isset($_GET['BSLaporancaramasukpenunjangV'])) {
      $model->attributes = $_GET['BSLaporancaramasukpenunjangV'];
      $model->ruanganpenunj_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['BSLaporancaramasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSLaporancaramasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSLaporancaramasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BSLaporancaramasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BSLaporancaramasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['BSLaporancaramasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['BSLaporancaramasukpenunjangV']['thn_akhir'];
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

  /**
   * digunakan sebagai fungsi print global untuk bedah sentral
   * @param object $model menampung data yang dikirim  
   * @param array $data menampung data informasi grafik
   * @param string $caraPrint digunakan untuk seleksi jenis print
   * @param string $judulLaporan menampung jul halaman cetak
   * @param string $target menampung halaman tujuan
   */
  protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target, $tab = 'rekap')
  {
    $format = new MyFormatter();
    $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
    if (empty($model->tgl_awal)) {
      $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
    }

    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'tab' => $tab), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }

  /*
     * BillingKasir->LaporanRekapTransaksi
     */
  public function actionLaporanTransaksiBedahSentral()
  {
    $this->pageTitle = Yii::app()->name . " - Transaksi Bedah Sentral";
    $model = new BKLaporanrekaptransaksiV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $modDaftarTindakan = DaftartindakanM::model()->findAll();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->instalasi_id = Yii::app()->user->getState('instalasi_id');
    $filter = isset($_GET['filter']) ? $_GET['filter'] : null;
    if (isset($_GET['BKLaporanrekaptransaksiV'])) {
      $model->attributes = $_GET['BKLaporanrekaptransaksiV'];
      // $model->instalasi = isset($_GET['BKLaporanrekaptransaksiV']['instalasi'])?($_GET['BKLaporanrekaptransaksiV']['instalasi']):"null";
      $model->jns_periode = $_REQUEST['BKLaporanrekaptransaksiV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BKLaporanrekaptransaksiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BKLaporanrekaptransaksiV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BKLaporanrekaptransaksiV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BKLaporanrekaptransaksiV']['bln_akhir']);
      $model->thn_awal = $_GET['BKLaporanrekaptransaksiV']['thn_awal'];
      $model->thn_akhir = $_GET['BKLaporanrekaptransaksiV']['thn_akhir'];
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

    $this->render('rekapTransaksiBedah/index', array(
      'model' => $model,
      'filter' => $filter
    ));
  }

  public function actionPrintLaporanRekapTransaksi()
  {
    $model = new BKLaporanrekaptransaksiV('searchPrintOpt');
    $judulLaporan = 'Laporan Rekap Transaksi Pasien';

    $model->unsetAttributes();
    $model->instalasi_id = Yii::app()->user->getState('instalasi_id');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Rekap Transaksi Pasien';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['BKLaporanrekaptransaksiV'])) {
      $model->attributes = $_REQUEST['BKLaporanrekaptransaksiV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BKLaporanrekaptransaksiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BKLaporanrekaptransaksiV']['tgl_akhir']);
      // $model->instalasi = $_GET['BKLaporanrekaptransaksiV']['instalasi'];
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'rekapTransaksiBedah/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  //DIPINDAHKAN KE BILLING KASIR

  //    public function actionLaporanTransaksiBedahSentral() {
  //        $this->pageTitle = Yii::app()->name . " - Laporan Transaksi Bedah Sentral";
  //        $model = new BSTindakandanoasudahbayarV('search');
  //        $format = new MyFormatter();
  //        $model->unsetAttributes();
  //        $model->jns_periode = "hari";
  //        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
  //        $model->tgl_akhir = date('Y-m-d');
  //        $model->bln_awal = date('Y-m', strtotime('first day of january'));
  //        $model->bln_akhir = date('Y-m');
  //        $model->thn_awal = date('Y');
  //        $model->thn_akhir = date('Y');
  //        if (isset($_GET['BSTindakandanoasudahbayarV'])) {
  //            $model->attributes = $_GET['BSTindakandanoasudahbayarV'];
  //            $model->jns_periode = $_GET['BSTindakandanoasudahbayarV']['jns_periode'];
  //            $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSTindakandanoasudahbayarV']['tgl_awal']);
  //            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSTindakandanoasudahbayarV']['tgl_akhir']);
  //            $model->bln_awal = $format->formatMonthForDb($_GET['BSTindakandanoasudahbayarV']['bln_awal']);
  //            $model->bln_akhir = $format->formatMonthForDb($_GET['BSTindakandanoasudahbayarV']['bln_akhir']);
  //            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
  //            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
  //            switch($model->jns_periode){
  //                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
  //                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
  //                default : null;
  //            }
  //            $model->tgl_awal = $model->tgl_awal." 00:00:00";
  //            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
  //        }
  //       
  //        $this->render('rekapTransaksiBedah/index', array(
  //            'model' => $model, 'format' => $format
  //        ));
  //    }
  //    public function actionPrintLaporanRekapTransaksiBedahSentral() {
  //        $model = new BSTindakandanoasudahbayarV('search');
  //        $format = new MyFormatter();
  //        $model->unsetAttributes();
  //        $model->jns_periode = "hari";
  //        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
  //        $model->tgl_akhir = date('Y-m-d');
  //        $model->bln_awal = date('Y-m', strtotime('first day of january'));
  //        $model->bln_akhir = date('Y-m');
  //        $model->thn_awal = date('Y');
  //        $model->thn_akhir = date('Y');
  //        $judulLaporan = 'Laporan Transaksi Pasien Bedah Sentral';
  //
  //        //Data Grafik
  //        $data['title'] = 'Grafik Laporan Transaksi Pasien Bedah Sentral';
  //        $format = new MyFormatter();
  //        $model->unsetAttributes();
  //       
  //        $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
  //        $model->tgl_akhir = date('Y-m-d');
  //       
  //        if (isset($_REQUEST['BSTindakandanoasudahbayarV'])) {
  //            $model->attributes = $_REQUEST['BSTindakandanoasudahbayarV'];
  //            $model->jns_periode = $_GET['BSTindakandanoasudahbayarV']['jns_periode'];
  //            $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSTindakandanoasudahbayarV']['tgl_awal']);
  //            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSTindakandanoasudahbayarV']['tgl_akhir']);
  //            $model->bln_awal = $format->formatMonthForDb($_GET['BSTindakandanoasudahbayarV']['bln_awal']);
  //            $model->bln_akhir = $format->formatMonthForDb($_GET['BSTindakandanoasudahbayarV']['bln_akhir']);
  //            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
  //            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
  //            switch($model->jns_periode){
  //                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
  //                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
  //                default : null;
  //            }
  //            $model->tgl_awal = $model->tgl_awal." 00:00:00";
  //            $model->tgl_akhir = $model->tgl_akhir." 23:59:59";
  //        }
  //
  //        $caraPrint = $_REQUEST['caraPrint'];
  //        $target = 'rekapTransaksiBedah/_print';
  //
  //        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  //    }

  /**
   * digunakan untuk menampilkan grafik laporan transaksi bedah sentral
   */
  public function actionFrameGrafikLaporanTransaksiBedahSentral()
  {
    $this->layout = '//layouts/iframe';
    $model = new BSTindakandanoasudahbayarV('search');
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
    $data['title'] = 'Grafik Laporan Transaksi Pasien Bedah Sentral';
    $data['type'] = $_GET['type'];
    if (isset($_GET['BSTindakandanoasudahbayarV'])) {
      $model->attributes = $_GET['BSTindakandanoasudahbayarV'];
      $model->jns_periode = $_GET['BSTindakandanoasudahbayarV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSTindakandanoasudahbayarV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSTindakandanoasudahbayarV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BSTindakandanoasudahbayarV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BSTindakandanoasudahbayarV']['bln_akhir']);
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
  // END //
  /*
     * actionLaporanRekapJasaDokter
     */

  /**
   * digunakan untuk menampilkan informasi laporan rekap jasa dokter
   */
  public function actionLaporanRekapJasaDokter()
  {
    $this->pageTitle = Yii::app()->name . " - Rekapitulasi Jasa Dokter";
    $model = new BSLaporantindakankomponenV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['BSLaporantindakankomponenV'])) {
      $model->attributes = $_GET['BSLaporantindakankomponenV'];

      $model->jns_periode = $_GET['BSLaporantindakankomponenV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSLaporantindakankomponenV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSLaporantindakankomponenV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BSLaporantindakankomponenV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BSLaporantindakankomponenV']['bln_akhir']);
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

    $this->render('rekapJasaDokter/index', array(
      'model' => $model, 'format' => $format,
    ));
  }

  /**
   * digunakan untuk menampilkan informasi laporan rekap jd
   * @param string $filterruangan kriteria filter 
   */
  public function actionLaporanRekapJD($filterruangan = null)
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Rekap Jasa Dokter";
    $model = new BSLaporantindakankomponenV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    if ($filterruangan == true) {
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    }

    if (isset($_GET['BSLaporantindakankomponenV'])) {
      $model->attributes = $_GET['BSLaporantindakankomponenV'];
      if ($filterruangan == true) {
        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      }
      $model->jns_periode = $_GET['BSLaporantindakankomponenV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSLaporantindakankomponenV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSLaporantindakankomponenV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BSLaporantindakankomponenV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BSLaporantindakankomponenV']['bln_akhir']);
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
    $this->render('rekapJasaDokter/_adminRekapBaru', array(
      'model' => $model, 'format' => $format,
    ));
  }

  /**
   * digunakan untuk menampilkan informasi laporan rekap jd detail
   * @param string $filterruangan kriteria filter 
   */
  public function actionLaporanDetailRekapJD($filterruangan = null)
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Rekap Jasa Dokter";
    $model = new BSLaporantindakankomponenV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if ($filterruangan) $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

    if (isset($_GET['BSLaporantindakankomponenV'])) {
      $model->attributes = $_GET['BSLaporantindakankomponenV'];

      $model->jns_periode = $_GET['BSLaporantindakankomponenV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSLaporantindakankomponenV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSLaporantindakankomponenV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BSLaporantindakankomponenV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BSLaporantindakankomponenV']['bln_akhir']);
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
    $this->render('rekapJasaDokter/_adminDetailRekapBaru', array(
      'model' => $model, 'format' => $format,
    ));
  }

  /**
   * digunakan untuk cetak laporan rekap jasa dokter
   * @param string $filterruangan kriteria filter 
   */
  public function actionPrintLaporanRekapJasaDokter($filterruangan = null)
  {
    $model = new BSLaporantindakankomponenV();
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

    if ($filterruangan == true) {
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    }

    //Data Grafik
    $data['title'] = 'GRAFIK LAPORAN REKAP JASA DOKTER';
    $data['type'] = (isset($REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['BSLaporantindakankomponenV'])) {
      $model->attributes = $_REQUEST['BSLaporantindakankomponenV'];
      $model->jns_periode = $_GET['BSLaporantindakankomponenV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSLaporantindakankomponenV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSLaporantindakankomponenV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BSLaporantindakankomponenV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BSLaporantindakankomponenV']['bln_akhir']);
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

  /**
   * digunakan untuk cetak laporan rekap jasa dokter detail 
   * @param string $filterruangan kriteria filter 
   */
  public function actionPrintLaporanDetailRekapJasaDokter($filterruangan = null)
  {
    $model = new BSLaporantindakankomponenV();
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

    if ($filterruangan) $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

    //Data Grafik
    $data['title'] = 'GRAFIK LAPORAN DETAIL REKAP JASA DOKTER';
    $data['type'] = (isset($REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['BSLaporantindakankomponenV'])) {
      $model->attributes = $_REQUEST['BSLaporantindakankomponenV'];
      $model->jns_periode = $_REQUEST['BSLaporantindakankomponenV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSLaporantindakankomponenV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSLaporantindakankomponenV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BSLaporantindakankomponenV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BSLaporantindakankomponenV']['bln_akhir']);
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
    $target = 'rekapJasaDokter/_printDetail';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, $tab);
  }

  /**
   * digunakan untuk menampilkan grafik laporan rekap jasa dokter
   * @param string $filterruangan kriteria filter 
   */
  public function actionFrameGrafikLaporanRekapJasaDokter($filterruangan = null)
  {
    $this->layout = '//layouts/iframe';
    $model = new BSLaporantindakankomponenV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if ($filterruangan) $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Rekap Jasa Dokter';
    $data['type'] = $_GET['type'];
    if (isset($_GET['BSLaporantindakankomponenV'])) {
      $model->attributes = $_GET['BSLaporantindakankomponenV'];
      $model->jns_periode = $_GET['BSLaporantindakankomponenV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSLaporantindakankomponenV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSLaporantindakankomponenV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['BSLaporantindakankomponenV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['BSLaporantindakankomponenV']['bln_akhir']);
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

  /**
   * start laporan jumlah tindakan operasi 
   */
  public function actionJumlahTindakanOperasi()
  {
    $this->pageTitle = Yii::app()->name . " - Jumlah Tindakan Operasi";
    $model = new BSLaporanjumlahpemeriksaandokterV('search');
    $model->tgl_awal = date('01 F Y');
    $model->tgl_akhir = date('t F Y');

    if (isset($_GET['BSLaporanjumlahpemeriksaandokterV'])) {
      $model->attributes = $_GET['BSLaporanjumlahpemeriksaandokterV'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['BSLaporanjumlahpemeriksaandokterV']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['BSLaporanjumlahpemeriksaandokterV']['tgl_akhir']);
    }

    $this->render($this->path_view . 'jumlahTindakanOperasi/admin', array(
      'model' => $model,
    ));
  }

  /**
   * digunakan untuk cetak jumlah tindakan operasi
   */
  public function actionPrintJumlahTindakanOperasi()
  {
    $model = new BSLaporanjumlahpemeriksaandokterV('search');
    $model->tgl_awal = date('01 F Y');
    $model->tgl_akhir = date('t F Y');
    $judulLaporan = 'Laporan Jumlah Tindakan Operasi';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Jumlah Tindakan Operasi';

    //var_dump($data);die;
    if (isset($_REQUEST['BSLaporanjumlahpemeriksaandokterV'])) {
      $model->attributes = $_REQUEST['BSLaporanjumlahpemeriksaandokterV'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['BSLaporanjumlahpemeriksaandokterV']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['BSLaporanjumlahpemeriksaandokterV']['tgl_akhir']);
    }
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view . 'jumlahTindakanOperasi/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  /**
   * digunakan untuk menampilkan grafik jumlah tindakan operasi
   */
  public function actionFrameGrafikJumlahTindakanOperasi()
  {
    $this->layout = '//layouts/frameDialog';

    $model = new BSLaporanjumlahpemeriksaandokterV('search');
    $model->bulan = date('m');
    $model->tahun = date('Y');


    $data['title'] = 'Grafik Laporan Jumlah Tindakan Operasi';
    $data['type'] = $_REQUEST['type'];

    if (isset($_GET['BSLaporanjumlahpemeriksaandokterV'])) {
      $model->attributes = $_GET['BSLaporanjumlahpemeriksaandokterV'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['BSLaporanjumlahpemeriksaandokterV']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['BSLaporanjumlahpemeriksaandokterV']['tgl_akhir']);
    }
    $this->render($this->path_view . 'jumlahTindakanOperasi._grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }
  /**
   * end laporan jumlah tindakan operasi 
   */

  /**
   * start laporan jumlah tindakan operasi oleh dokter operator
   */
  public function actionJumlahTindakanOperasiOperator()
  {
    $this->pageTitle = Yii::app()->name . " - Jumlah Tindakan Operasi Dr Operator";
    $model = new BSLaporanjumlahpemeriksaandokterV('search');
    $model->tgl_awal = date('01 F Y');
    $model->tgl_akhir = date('t F Y');

    if (isset($_GET['BSLaporanjumlahpemeriksaandokterV'])) {
      $model->attributes = $_GET['BSLaporanjumlahpemeriksaandokterV'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['BSLaporanjumlahpemeriksaandokterV']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['BSLaporanjumlahpemeriksaandokterV']['tgl_akhir']);
      $model->dokterpelaksana1_id = isset($_GET['BSLaporanjumlahpemeriksaandokterV']['dokterpelaksana1_id']) ? $_GET['BSLaporanjumlahpemeriksaandokterV']['dokterpelaksana1_id'] : null;
    }

    $this->render($this->path_view . 'jumlahTindakanOperasiOperator/admin', array(
      'model' => $model,
    ));
  }

  /**
   * digunakan untuk cetak jumlah tindakan operasi operator
   */
  public function actionPrintJumlahTindakanOperasiOperator()
  {
    $model = new BSLaporanjumlahpemeriksaandokterV('search');
    $model->tgl_awal = date('01 F Y');
    $model->tgl_akhir = date('t F Y');
    $judulLaporan = strtoupper('Laporan Jumlah Tindakan Operasi DR Operator');

    //Data Grafik
    $data['title'] = strtoupper('Grafik Laporan Jumlah Tindakan Operasi DR Operator');

    //var_dump($data);die;
    if (isset($_REQUEST['BSLaporanjumlahpemeriksaandokterV'])) {
      $model->attributes = $_REQUEST['BSLaporanjumlahpemeriksaandokterV'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['BSLaporanjumlahpemeriksaandokterV']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['BSLaporanjumlahpemeriksaandokterV']['tgl_akhir']);
      $model->dokterpelaksana1_id = isset($_GET['BSLaporanjumlahpemeriksaandokterV']['dokterpelaksana1_id']) ? $_GET['BSLaporanjumlahpemeriksaandokterV']['dokterpelaksana1_id'] : null;
    }
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view . 'jumlahTindakanOperasiOperator/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  /**
   * digunakan untuk menampilkan grafik jumlah tindakan operasi operator
   */
  public function actionGrafikJumlahTindakanOperasiOperator()
  {
    $this->layout = '//layouts/frameDialog';

    $model = new BSLaporanjumlahpemeriksaandokterV('search');
    $model->bulan = date('m');
    $model->tahun = date('Y');


    $data['title'] = strtoupper('Grafik Laporan Jumlah Tindakan Operasi DR Operator');
    $data['type'] = $_REQUEST['type'];

    if (isset($_GET['BSLaporanjumlahpemeriksaandokterV'])) {
      $model->attributes = $_GET['BSLaporanjumlahpemeriksaandokterV'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['BSLaporanjumlahpemeriksaandokterV']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['BSLaporanjumlahpemeriksaandokterV']['tgl_akhir']);
      $model->dokterpelaksana1_id = isset($_GET['BSLaporanjumlahpemeriksaandokterV']['dokterpelaksana1_id']) ? $_GET['BSLaporanjumlahpemeriksaandokterV']['dokterpelaksana1_id'] : null;
    }
    $this->render($this->path_view . 'jumlahTindakanOperasiOperator._grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }
  /**
   * end laporan jumlah tindakan operasi oleh dokter operator
   */

  /**
   * start laporan jumlah tindakan operasi oleh dokter anestesi
   */
  public function actionJumlahTindakanOperasiAnestesi()
  {
    $this->pageTitle = Yii::app()->name . " - Jumlah Tindakan Operasi Dr Anestesi";
    $model = new BSLaporanjumlahpemeriksaandokterV('search');
    $model->tgl_awal = date('01 F Y');
    $model->tgl_akhir = date('t F Y');

    if (isset($_GET['BSLaporanjumlahpemeriksaandokterV'])) {
      $model->attributes = $_GET['BSLaporanjumlahpemeriksaandokterV'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['BSLaporanjumlahpemeriksaandokterV']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['BSLaporanjumlahpemeriksaandokterV']['tgl_akhir']);
      $model->dokterpelaksana1_id = isset($_GET['BSLaporanjumlahpemeriksaandokterV']['dokterpelaksana1_id']) ? $_GET['BSLaporanjumlahpemeriksaandokterV']['dokterpelaksana1_id'] : null;
    }

    $this->render($this->path_view . 'jumlahTindakanOperasiAnestesi/admin', array(
      'model' => $model,
    ));
  }

  /**
   * digunakan untuk cetak jumlah tindakan operasi anestesi
   */
  public function actionPrintJumlahTindakanOperasiAnestesi()
  {
    $model = new BSLaporanjumlahpemeriksaandokterV('search');
    $model->tgl_awal = date('01 F Y');
    $model->tgl_akhir = date('t F Y');
    $judulLaporan = strtoupper('Laporan Jumlah Tindakan Operasi DR Anestesi');

    //Data Grafik
    $data['title'] = strtoupper('Grafik Laporan Jumlah Tindakan Operasi DR Anestesi');

    //var_dump($data);die;
    if (isset($_REQUEST['BSLaporanjumlahpemeriksaandokterV'])) {
      $model->attributes = $_REQUEST['BSLaporanjumlahpemeriksaandokterV'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['BSLaporanjumlahpemeriksaandokterV']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['BSLaporanjumlahpemeriksaandokterV']['tgl_akhir']);
      $model->dokteranastesi_id = isset($_GET['BSLaporanjumlahpemeriksaandokterV']['dokteranastesi_id']) ? $_GET['BSLaporanjumlahpemeriksaandokterV']['dokteranastesi_id'] : null;
    }
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view . 'jumlahTindakanOperasiAnestesi/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  /**
   * digunakan untuk menampilkan grafik jumlah tindakan operasi anestesi
   */
  public function actionGrafikJumlahTindakanOperasiAnestesi()
  {
    $this->layout = '//layouts/frameDialog';

    $model = new BSLaporanjumlahpemeriksaandokterV('search');
    $model->bulan = date('m');
    $model->tahun = date('Y');


    $data['title'] = strtoupper('Grafik Laporan Jumlah Tindakan Operasi DR Anestesi');
    $data['type'] = $_REQUEST['type'];

    if (isset($_GET['BSLaporanjumlahpemeriksaandokterV'])) {
      $model->attributes = $_GET['BSLaporanjumlahpemeriksaandokterV'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['BSLaporanjumlahpemeriksaandokterV']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['BSLaporanjumlahpemeriksaandokterV']['tgl_akhir']);
      $model->dokteranastesi_id = isset($_GET['BSLaporanjumlahpemeriksaandokterV']['dokteranastesi_id']) ? $_GET['BSLaporanjumlahpemeriksaandokterV']['dokteranastesi_id'] : null;
    }
    $this->render($this->path_view . 'jumlahTindakanOperasiAnestesi._grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }
  /**
   * end laporan jumlah tindakan operasi oleh dokter anastesi
   */

  /** end actionLaporanRekapJasaDokter **/
  //    public function getTabularFormTabs($form, $model)
  //    {
  //        $tabs = array();
  //        $count = 0;
  //        foreach (array('en'=>'English', 'fi'=>'Finnish', 'sv'=>'Swedish') as $locale => $language)
  //        {
  //            $tabs[] = array(
  //                'active'=>$count++ === 0,
  //                'label'=>$language,
  //                'content'=>$this->renderPartial('rekapTransaksiBedah/_table', array('form'=>$form, 'model'=>$model, 'locale'=>$locale, 'language'=>$language), true),
  //            );
  //        }
  //        return $tabs;
  //    }



/*
     * ======================== Tindakan Ruangan ===============================
     */
    public function actionLaporanTindakanRuangan()
    {
      $this->pageTitle = Yii::app()->name . " - Tindakan Ruangan";
      $model = new BSLaporantindakanruangan('search');
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
  
      if (isset($_GET['BSLaporantindakanruangan'])) {
        $model->attributes = $_GET['BSLaporantindakanruangan'];
        $model->jns_periode = $_GET['BSLaporantindakanruangan']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSLaporantindakanruangan']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSLaporantindakanruangan']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['BSLaporantindakanruangan']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['BSLaporantindakanruangan']['bln_akhir']);
        $model->thn_awal = $_GET['BSLaporantindakanruangan']['thn_awal'];
        $model->thn_akhir = $_GET['BSLaporantindakanruangan']['thn_akhir'];
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
      $model = new BSLaporantindakanruangan('search');
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m', strtotime('first day of january'));
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');
      $judulLaporan = 'Laporan Grafik Tindakan Ruangan Bedah Sentral';
      $format = new MyFormatter();
      //Data Grafik        
      $data['title'] = 'Grafik Laporan Tindakan Ruangan';
      $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
      if (isset($_REQUEST['BSLaporantindakanruangan'])) {
        $model->attributes = $_REQUEST['BSLaporantindakanruangan'];
        $model->jns_periode = $_REQUEST['BSLaporantindakanruangan']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['BSLaporantindakanruangan']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['BSLaporantindakanruangan']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['BSLaporantindakanruangan']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['BSLaporantindakanruangan']['bln_akhir']);
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
      $model = new BSLaporantindakanruangan('search');
      $model->tgl_awal = date('d M Y H:i:s');
      $model->tgl_akhir = date('d M Y H:i:s');
  
      //Data Grafik
      $data['title'] = 'Grafik Laporan Tindakan Ruangan Bedah Sentral';
      $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
      if (isset($_GET['BSLaporantindakanruangan'])) {
        $model->attributes = $_GET['BSLaporantindakanruangan'];
        $format = new MyFormatter();
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSLaporantindakanruangan']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSLaporantindakanruangan']['tgl_akhir']);
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
