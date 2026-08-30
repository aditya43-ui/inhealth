<?php

Yii::import('pendaftaranPenjadwalan.models.*');
Yii::import('sistemAdministrator.models.*');


class LaporanController extends MyAuthController
{
  public $pathViewPP = 'pendaftaranPenjadwalan.views.laporan.';
  public $pathViewRj = 'rawatJalan.views.laporan.';
  public $path_view = 'rekamMedis.views.laporan.';

  // -- Laporan Kunjungan --//
  // -- VIEW LAPORAN -- //
  public function actionLaporanKunjunganRJOld()
  {
    $this->pageTitle = Yii::app()->name . " - Kunjungan Rawat Jalan";
    $model = new PPInfoKunjunganRJV('searchRJ');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $format = new MyFormatter();
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      // //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      // //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatJalan/adminRJ', array(
      'model' => $model, 'format' => $format
    ));
  }


  public function actionLaporanKunjunganRJRD()
  {
    $this->pageTitle = Yii::app()->name . " - Kunjungan Rawat Jalan dan Rawat Darurat";

    //Kunjungan RJ
    $model = new LaporankunjunganrjglobalV('searchRJ');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');

    $model->sistem = 'Rawat Jalan';

    //Kunjungan RJ
    if (isset($_GET['LaporankunjunganrjglobalV'])) {
      $model->attributes = $_GET['LaporankunjunganrjglobalV'];
      $format = new MyFormatter();
      $model->jns_periode = $_GET['LaporankunjunganrjglobalV']['jns_periode'];
      $model->sistem = isset($_GET['LaporankunjunganrjglobalV']['sistem']) ? $_GET['LaporankunjunganrjglobalV']['sistem'] : null;
      $model->carakeluar_id = isset($_GET['LaporankunjunganrjglobalV']['carakeluar_id']) ? $_GET['LaporankunjunganrjglobalV']['carakeluar_id'] : null;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['LaporankunjunganrjglobalV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LaporankunjunganrjglobalV']['tgl_akhir']);

    }

    $this->render($this->pathViewPP . 'rawatJalan/globalRJRD', array(
      'model' => $model,
      'format' => $format
    ));
  }

  public function actionLaporanKunjunganRJ()
  {
    $this->pageTitle = Yii::app()->name . " - Kunjungan Rawat Jalan";
    $model = new LaporankunjunganrjglobalV('searchRJ');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['LaporankunjunganrjglobalV'])) {
      $model->attributes = $_GET['LaporankunjunganrjglobalV'];
      $format = new MyFormatter();
      $model->jns_periode = $_GET['LaporankunjunganrjglobalV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['LaporankunjunganrjglobalV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LaporankunjunganrjglobalV']['tgl_akhir']);

    }

    $this->render($this->pathViewPP . 'rawatJalan/globalRJ', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanKunjunganUmurRJ()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Jalan Berdasarkan Umur";
    $model = new PPInfoKunjunganRJV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      // //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      // //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatJalan/umurRJ', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanKunjunganJkRJ()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Jalan Berdasarkan Jenis Kelamin";
    $model = new PPInfoKunjunganRJV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      // //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      // //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatJalan/jkRJ', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanStatusKunjunganRJ()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Jalan Berdasarkan Kedatangan Lama / Baru";
    $model = new PPInfoKunjunganRJV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      // //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      // //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatJalan/statusRJ', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanAgamaKunjunganRJ()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Jalan Berdasarkan Agama";
    $model = new PPInfoKunjunganRJV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      // //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      // //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatJalan/agamaRJ', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintPekerjaanKunjunganRI()
  {
    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Inap';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      // //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      // //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printPekerjaan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionLaporanPekerjaanKunjunganRJ()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Jalan Berdasarkan Pekerjaan";
    $model = new PPInfoKunjunganRJV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      // //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      // //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatJalan/pekerjaanRJ', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanStatusPerkawinanKunjunganRJ()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Jalan Berdasarkan Status Perkawinan";
    $model = new PPInfoKunjunganRJV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      // //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      // //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatJalan/statusPerkawinanRJ', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanAlamatKunjunganRJ()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Jalan Berdasarkan Alamat";
    $model = new PPInfoKunjunganRJV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      // //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      // //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatJalan/alamatRJ', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanKecamatanKunjunganRJ()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Jalan Berdasarkan Kecamatan";
    $model = new PPInfoKunjunganRJV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      // //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      // //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatJalan/kecamatanRJ', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanKabKotaKunjunganRJ()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Jalan Berdasarkan Kabupaten / Kota";
    $model = new PPInfoKunjunganRJV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      // //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      // //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatJalan/kabupatenRJ', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanCaraMasukKunjunganRJ()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Jalan Berdasarkan Cara Masuk";
    $model = new PPInfoKunjunganRJV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      // //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      // //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatJalan/caraMasukRJ', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanRujukanKunjunganRJ()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Jalan Berdasarkan Rujukan";
    $model = new PPInfoKunjunganRJV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      // //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      // //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatJalan/rujukanRJ', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanPemeriksaanKunjunganRJ()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Jalan Berdasarkan Pemeriksaan";
    $model = new PPInfoKunjunganRJV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      // //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      // //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatJalan/pemeriksaanRJ', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanKetPulangKunjunganRJ()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Jalan Berdasarkan Keterangan Pulang";
    $model = new PPInfoKunjunganRJV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatJalan/ketPulangRJ', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanPenjaminKunjunganRJ()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Jalan Berdasarkan Penjamin";
    $model = new PPInfoKunjunganRJV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatJalan/penjaminRJ', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanDokterPemeriksaKunjunganRJ()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Jalan Berdasarkan Dokter Pemeriksa";
    $model = new PPInfoKunjunganRJV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatJalan/dokterPemeriksaRJ', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanUnitPelayananKunjunganRJ()
  {
    $model = new PPRuanganM('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->tipe = 'rawatjalan';

    if (isset($_GET['PPRuanganM'])) {
      $model->attributes = $_GET['PPRuanganM'];
      $model->jns_periode = $_GET['PPRuanganM']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPRuanganM']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPRuanganM']['bln_akhir']);
      $model->thn_awal = $_GET['PPRuanganM']['thn_awal'];
      $model->thn_akhir = $_GET['PPRuanganM']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      $model->tipe = 'rawatjalan';
    }

    $this->render($this->pathViewPP . 'rawatJalan/unitPelayananRJ', array(
      'model' => $model, 'format' => $format
    ));
  }

  // -- END VIEW LAPORAN --//
  // -- PRINT LAPORAN --//
  public function actionPrintKunjunganRJ()
  {
    $model = new LaporankunjunganrjglobalV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Jalan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_REQUEST['LaporankunjunganrjglobalV'])) {
      $model->attributes = $_REQUEST['LaporankunjunganrjglobalV'];
      $model->jns_periode = $_REQUEST['LaporankunjunganrjglobalV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['LaporankunjunganrjglobalV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['LaporankunjunganrjglobalV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['LaporankunjunganrjglobalV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['LaporankunjunganrjglobalV']['bln_akhir']);
      $model->thn_awal = $_GET['LaporankunjunganrjglobalV']['thn_awal'];
      $model->thn_akhir = $_GET['LaporankunjunganrjglobalV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));

      $model->sistem = isset($_GET['LaporankunjunganrjglobalV']['sistem']) ? $_GET['LaporankunjunganrjglobalV']['sistem'] : null;
      $model->carakeluar_id = isset($_GET['LaporankunjunganrjglobalV']['carakeluar_id']) ? $_GET['LaporankunjunganrjglobalV']['carakeluar_id'] : null;

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

    
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printTabGlobal';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintUmurKunjunganRJ()
  {
    $model = new PPInfoKunjunganRJV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Umur';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Umur';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRJV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      //            $model->bulan =DATE_PART('MONTH',$_REQUEST['PPInfoKunjunganRJV']['bulan']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printUmur';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintAgamaKunjunganRJ()
  {
    $model = new PPInfoKunjunganRJV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Agama';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Agama';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRJV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRJV'];
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      //            $model->bulan =DATE_PART('MONTH',$_REQUEST['PPInfoKunjunganRJV']['bulan']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printAgama';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintAlamatKunjunganRJ()
  {
    $model = new PPInfoKunjunganRJV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Alamat';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Alamat';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRJV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRJV'];
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      //            $model->bulan =DATE_PART('MONTH',$_REQUEST['PPInfoKunjunganRJV']['bulan']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printAlamat';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintJkKunjunganRJ()
  {
    $model = new PPInfoKunjunganRJV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Jenis Kelamin';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Jenis Kelamin';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRJV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRJV'];
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      //            $model->bulan =DATE_PART('MONTH',$_REQUEST['PPInfoKunjunganRJV']['bulan']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printJk';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintStatusKunjunganRJ()
  {
    $model = new PPInfoKunjunganRJV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Kedatangan Lama / Baru';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Kedatangan Lama / Baru';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRJV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRJV'];
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      //            $model->bulan =DATE_PART('MONTH',$_REQUEST['PPInfoKunjunganRJV']['bulan']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printStatus';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintStatusPerkawinanKunjunganRJ()
  {
    $model = new PPInfoKunjunganRJV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Status Perkawinan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Status Perkawinan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRJV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRJV'];
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      //            $model->bulan =DATE_PART('MONTH',$_REQUEST['PPInfoKunjunganRJV']['bulan']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printStatusPerkawinan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintRujukanKunjunganRJ()
  {
    $model = new PPInfoKunjunganRJV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Rujukan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Rujukan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRJV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRJV'];
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      //            $model->bulan =DATE_PART('MONTH',$_REQUEST['PPInfoKunjunganRJV']['bulan']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printRujukan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintCaraMasukKunjunganRJ()
  {
    $model = new PPInfoKunjunganRJV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Cara Masuk';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Cara Masuk';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRJV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRJV'];
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      //            $model->bulan =DATE_PART('MONTH',$_REQUEST['PPInfoKunjunganRJV']['bulan']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printCaraMasuk';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintKetPulangKunjunganRJ()
  {
    $model = new PPInfoKunjunganRJV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Keterangan Pulang';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Keterangan Pulang';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRJV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRJV'];
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      //            $model->bulan =DATE_PART('MONTH',$_REQUEST['PPInfoKunjunganRJV']['bulan']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printKetPulang';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintKabKotaKunjunganRJ()
  {
    $model = new PPInfoKunjunganRJV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Kabupaten / Kota';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Kabupaten / Kota';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRJV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRJV'];
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      //            $model->bulan =DATE_PART('MONTH',$_REQUEST['PPInfoKunjunganRJV']['bulan']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printKabupaten';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintKecamatanKunjunganRJ()
  {
    $model = new PPInfoKunjunganRJV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Kecamatan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Kecamatan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRJV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRJV'];
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      //            $model->bulan =DATE_PART('MONTH',$_REQUEST['PPInfoKunjunganRJV']['bulan']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printKecamatan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintPenjaminKunjunganRJ()
  {
    $model = new PPInfoKunjunganRJV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Penjamin';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Penjamin';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRJV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRJV'];
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      //            $model->bulan =DATE_PART('MONTH',$_REQUEST['PPInfoKunjunganRJV']['bulan']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printPenjamin';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintPemeriksaanKunjunganRJ()
  {
    $model = new PPInfoKunjunganRJV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Pemeriksaan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Pemeriksaan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRJV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRJV'];
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      //            $model->bulan =DATE_PART('MONTH',$_REQUEST['PPInfoKunjunganRJV']['bulan']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printPemeriksaan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintDokterPemeriksaKunjunganRJ()
  {
    $model = new PPInfoKunjunganRJV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Dokter Pemeriksa';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Dokter Pemeriksa';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRJV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRJV'];
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      //            $model->bulan =DATE_PART('MONTH',$_REQUEST['PPInfoKunjunganRJV']['bulan']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printDokterPemeriksa';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintUnitPelayananKunjunganRJ()
  {
    $model = new PPRuanganM();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->tipe = 'rawatjalan';

    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Unit Pelayanan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Unit Pelayanan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPRuanganM'])) {
      $model->attributes = $_REQUEST['PPRuanganM'];
      $model->jns_periode = $_REQUEST['PPRuanganM']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPRuanganM']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPRuanganM']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPRuanganM']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPRuanganM']['bln_akhir']);
      $model->thn_awal = $_GET['PPRuanganM']['thn_awal'];
      $model->thn_akhir = $_GET['PPRuanganM']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      $model->tipe = 'rawatjalan';
      //            $model->bulan =DATE_PART('MONTH',$_REQUEST['PPInfoKunjunganRJV']['bulan']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printUnitPelayanan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  // -- END PRINT LAPORAN -- //
  // -- GRAFIK LAPORAN -- //
  public function actionFrameGrafikRJ()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRJV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikAgamaRJ()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRJV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Agama';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikAgama', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikAlamatRJ()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRJV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Alamat';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikAlamat', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikCaraMasukRJ()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRJV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Cara Masuk';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikCaraMasuk', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikDokterPemeriksaRJ()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRJV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Dokter Pemeriksa';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikDokterPemeriksa', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikJkRJ()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRJV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Jenis Kelamin';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikJk', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikKabKotaRJ()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRJV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Kabupaten / Kota';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikKabupaten', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikKecamatanRJ()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRJV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Kecamatan';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikKecamatan', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikKetPulangRJ()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRJV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Keterangan Pulang';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikKetPulang', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikPekerjaanRJ()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRJV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Pekerjaan';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikPekerjaan', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikPemeriksaanRJ()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRJV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Pemeriksaan';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikPemeriksaan', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikPenjaminRJ()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRJV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Penjamin';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikPenjamin', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikRujukanRJ()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRJV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Rujukan';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikRujukan', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikStatusPerkawinanRJ()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRJV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Status Perkawinan';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikStatusPerkawinan', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikStatusRJ()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRJV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Kedatangan Lama / Baru';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikStatus', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikUmurRJ()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRJV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Umur';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikUmur', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikUnitPelayananRJ()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPRuanganM('searchGrafikUnitPelayanan');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->tipe = 'rawatjalan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Unit Pelayanan';
    $data['type'] = $_REQUEST['type'];

    if (isset($_REQUEST['PPRuanganM'])) {
      $model->attributes = $_REQUEST['PPRuanganM'];
      $model->jns_periode = $_REQUEST['PPRuanganM']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPRuanganM']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPRuanganM']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPRuanganM']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPRuanganM']['bln_akhir']);
      $model->thn_awal = $_REQUEST['PPRuanganM']['thn_awal'];
      $model->thn_akhir = $_REQUEST['PPRuanganM']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      $model->tipe = 'rawatjalan';
    }

    $this->render($this->pathViewPP . '_grafikUnitPelayanan', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  // -- END GRAFIK LAPORAN -- //
  // -- End Laporan Kunjungan --//    
  // -- Laporan Kunjungan RD -- //
  // -- VIEW LAPORAN --//
  public function actionLaporanKunjunganRD()
  {
    $this->pageTitle = Yii::app()->name . " - Kunjungan Rawat Darurat";
    $format = new MyFormatter();
    $model = new PPInfoKunjunganRDV('searchTableLaporan');
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->jenis_kunjungan = $_GET['PPInfoKunjunganRDV']['jenis_kunjungan'];
      $model->carakeluar_id = $_GET['PPInfoKunjunganRDV']['carakeluar_id'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatDarurat/adminRD', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanKunjunganUmurRD()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Darurat Berdasarkan Umur";
    $model = new PPInfoKunjunganRDV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatDarurat/umurRD', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanKunjunganJkRD()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Darurat Berdasarkan Jenis Kelamin";
    $model = new PPInfoKunjunganRDV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatDarurat/jkRD', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanStatusKunjunganRD()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Darurat Berdasarkan Kedatangan Lama / Baru";
    $model = new PPInfoKunjunganRDV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatDarurat/statusRD', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanAgamaKunjunganRD()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Darurat Berdasarkan Agama";
    $model = new PPInfoKunjunganRDV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatDarurat/agamaRD', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanPekerjaanKunjunganRD()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Darurat Berdasarkan Pekerjaan";
    $model = new PPInfoKunjunganRDV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatDarurat/pekerjaanRD', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanStatusPerkawinanKunjunganRD()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Darurat Berdasarkan Status Perkawinan";
    $model = new PPInfoKunjunganRDV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatDarurat/statusPerkawinanRD', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanAlamatKunjunganRD()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Darurat Berdasarkan Alamat";
    $model = new PPInfoKunjunganRDV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatDarurat/alamatRD', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanKecamatanKunjunganRD()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Darurat Berdasarkan Kecamatan";
    $model = new PPInfoKunjunganRDV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatDarurat/kecamatanRD', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanKabKotaKunjunganRD()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Darurat Berdasarkan Kabupaten / Kota";
    $model = new PPInfoKunjunganRDV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatDarurat/kabupatenRD', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanCaraMasukKunjunganRD()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Darurat Berdasarkan Cara Masuk";
    $model = new PPInfoKunjunganRDV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatDarurat/caraMasukRD', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanRujukanKunjunganRD()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Darurat Berdasarkan Rujukan";
    $model = new PPInfoKunjunganRDV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatDarurat/rujukanRD', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanPemeriksaanKunjunganRD()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Darurat Berdasarkan Pemeriksaan";
    $model = new PPInfoKunjunganRDV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatDarurat/pemeriksaanRD', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanKetPulangKunjunganRD()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Darurat Berdasarkan Keterangan Pulang";
    $model = new PPInfoKunjunganRDV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatDarurat/ketPulangRD', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanPenjaminKunjunganRD()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Darurat Berdasarkan Penjamin";
    $model = new PPInfoKunjunganRDV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatDarurat/penjaminRD', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanDokterPemeriksaKunjunganRD()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Darurat Berdasarkan Dokter Pemeriksa";
    $model = new PPInfoKunjunganRDV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatDarurat/dokterPemeriksaRD', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanUnitPelayananKunjunganRD()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Darurat Berdasarkan Unit Pelayanan";
    $model = new PPRuanganM('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->tipe = 'rawatdarurat';

    if (isset($_GET['PPRuanganM'])) {
      $model->attributes = $_GET['PPRuanganM'];
      $model->jns_periode = $_GET['PPRuanganM']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPRuanganM']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPRuanganM']['bln_akhir']);
      $model->thn_awal = $_GET['PPRuanganM']['thn_awal'];
      $model->thn_akhir = $_GET['PPRuanganM']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      $model->tipe = 'rawatdarurat';
    }

    $this->render($this->pathViewPP . 'rawatDarurat/unitPelayananRD', array(
      'model' => $model,
    ));
  }

  // -- END VIEW LAPORAN --//
  // -- PRINT LAPORAN -- //
  public function actionPrintKunjunganRD()
  {
    $model = new PPInfoKunjunganRDV('searchPrint');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Darurat';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printRD';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintPekerjaanKunjunganRD()
  {
    $model = new PPInfoKunjunganRDV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Darurat';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printPekerjaan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintUmurKunjunganRD()
  {
    $model = new PPInfoKunjunganRDV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Darurat';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printUmur';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintAgamaKunjunganRD()
  {
    $model = new PPInfoKunjunganRDV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Darurat';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printAgama';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintAlamatKunjunganRD()
  {
    $model = new PPInfoKunjunganRDV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Darurat';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printAlamat';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintJkKunjunganRD()
  {
    $model = new PPInfoKunjunganRDV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Darurat';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printJk';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintStatusKunjunganRD()
  {
    $model = new PPInfoKunjunganRDV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Darurat';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printStatus';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintStatusPerkawinanKunjunganRD()
  {
    $model = new PPInfoKunjunganRDV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Darurat';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printStatusPerkawinan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintRujukanKunjunganRD()
  {
    $model = new PPInfoKunjunganRDV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Darurat';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printRujukan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintCaraMasukKunjunganRD()
  {
    $model = new PPInfoKunjunganRDV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Darurat';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printCaraMasuk';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintKetPulangKunjunganRD()
  {
    $model = new PPInfoKunjunganRDV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Darurat';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printKetPulang';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintKabKotaKunjunganRD()
  {
    $model = new PPInfoKunjunganRDV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Darurat';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printKabupaten';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintKecamatanKunjunganRD()
  {
    $model = new PPInfoKunjunganRDV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Darurat';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printKecamatan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintPenjaminKunjunganRD()
  {
    $model = new PPInfoKunjunganRDV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Darurat';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printPenjamin';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintPemeriksaanKunjunganRD()
  {
    $model = new PPInfoKunjunganRDV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Darurat';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printPemeriksaan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintDokterPemeriksaKunjunganRD()
  {
    $model = new PPInfoKunjunganRDV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Darurat';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_REQUEST['PPInfoKunjunganRDV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRDV'];
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printDokterPemeriksa';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintUnitPelayananKunjunganRD()
  {
    $model = new PPRuanganM('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->tipe = 'rawatdarurat';
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Darurat Berdasarkan Unit Pelayanan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat Berdasarkan Unit Pelayanan';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['PPRuanganM'])) {
      $model->attributes = $_REQUEST['PPRuanganM'];
      $model->jns_periode = $_REQUEST['PPRuanganM']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPRuanganM']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPRuanganM']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPRuanganM']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPRuanganM']['bln_akhir']);
      $model->thn_awal = $_GET['PPRuanganM']['thn_awal'];
      $model->thn_akhir = $_GET['PPRuanganM']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      $model->tipe = 'rawatdarurat';
      //            $model->bulan =DATE_PART('MONTH',$_REQUEST['PPInfoKunjunganRJV']['bulan']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printUnitPelayanan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  // -- END PRINT LAPORAN -- //
  // --GRAFIK LAPORAN -- //
  public function actionFrameGrafikRD()
  {
    $this->layout = '//layouts/iframe';
    $model = new PPInfoKunjunganRDV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikAgamaRD()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRDV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat Berdasarkan Agama';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikAgama', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikAlamatRD()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRDV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat Berdasarkan Alamat';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikAlamat', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikCaraMasukRD()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRDV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat Berdasarkan Cara Masuk';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikCaraMasuk', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikDokterPemeriksaRD()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRDV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat Berdasarkan Dokter Pemeriksa';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikDokterPemeriksa', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikJkRD()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRDV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat Berdasarkan Jenis Kelamin';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikJk', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikKabKotaRD()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRDV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat Berdasarkan Kabupaten / Kota';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikKabupaten', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikKecamatanRD()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRDV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat Berdasarkan Kecamatan';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikKecamatan', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikKetPulangRD()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRDV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat Berdasarkan Keterangan Pulang';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikKetPulang', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikPekerjaanRD()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRDV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat Berdasarkan Pekerjaan';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikPekerjaan', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikPemeriksaanRD()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRDV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat Berdasarkan Pemeriksaan';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikPemeriksaan', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikPenjaminRD()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRDV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat Berdasarkan Penjamin';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikPenjamin', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikRujukanRD()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRDV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat Berdasarkan Rujukan';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikRujukan', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikStatusPerkawinanRD()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRDV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat Berdasarkan Status Perkawinan';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikStatusPerkawinan', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikStatusRD()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRDV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat Berdasarkan Kedatangan Lama / Baru';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikStatus', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikUmurRD()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRDV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat Berdasarkan Umur';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikUmur', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikUnitPelayananRD()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPRuanganM('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->tipe = 'rawatdarurat';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat Berdasarkan Unit Pelayanan';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPRuanganM'])) {
      $model->attributes = $_GET['PPRuanganM'];
      $model->jns_periode = $_GET['PPRuanganM']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPRuanganM']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPRuanganM']['bln_akhir']);
      $model->thn_awal = $_GET['PPRuanganM']['thn_awal'];
      $model->thn_akhir = $_GET['PPRuanganM']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      $model->tipe = 'rawatdarurat';
    }

    $this->render($this->pathViewPP . '_grafikUnitPelayanan', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  // -- END GRAFIK LAPORAN -- //
  // -- End Laporan Kunjungan RD -- //
  // -- Laporan Kunjungan RI -- //
  // -- VIEW LAPORAN --//
  public function actionLaporanKunjunganRI()
  {
    $this->pageTitle = Yii::app()->name . " - Kunjungan Rawat Inap";
    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatInap/adminRI', array(
      'model' => $model, 'format' => $format
    ));
  }

  // laporankunjungan ri global
  public function actionLaporanKunjunganRIGlobal()
  {
    $this->pageTitle = Yii::app()->name . " - Kunjungan Rawat Inap";
    $model = new PPInfokunjunganriglobalV('searchTable');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->pilihanPeriode = '1';

    if (isset($_GET['PPInfokunjunganriglobalV'])) {
      $model->attributes = $_GET['PPInfokunjunganriglobalV'];
      $model->jns_periode = $_GET['PPInfokunjunganriglobalV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfokunjunganriglobalV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfokunjunganriglobalV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfokunjunganriglobalV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfokunjunganriglobalV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfokunjunganriglobalV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfokunjunganriglobalV']['thn_akhir'];
      $model->pilihanPeriode = $_GET['PPInfokunjunganriglobalV']['pilihanPeriode'];
      $model->carakeluar_id = $_GET['PPInfokunjunganriglobalV']['carakeluar_id'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    if(Yii::app()->request->isAjaxRequest) {
      if(isset($_GET['ajax']) && $_GET['ajax'] == 'PPInfoKunjungan-v') {
        $this->renderPartial('pendaftaranPenjadwalan.views.laporan.rawatInap._tableGlobalRI', array('model' => $model));
        Yii::app()->end();
      }
    }

    $this->render($this->pathViewPP . 'rawatInap/adminRIGlobal', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanAlasanPulangKunjunganRI()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Inap Berdasarkan Alasan Pulang";
    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatInap/alasanPulangRI', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanKunjunganUmurRI()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Inap Berdasarkan Umur";
    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    //        $model->tgl_awal = date('Y-m-d 00:00:00');
    //        $model->tgl_akhir = date('Y-m-d H:i:s');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = ($_GET['PPInfoKunjunganRIV']['thn_awal']);
      $model->thn_akhir = ($_GET['PPInfoKunjunganRIV']['thn_akhir']);
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatInap/umurRI', array(
      'model' => $model,
    ));
  }

  public function actionLaporanKunjunganJkRI()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Inap Berdasarkan Jenis Kelamin";
    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatInap/jkRI', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanStatusKunjunganRI()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Inap Berdasarkan Kedatangan Lama / Baru";
    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatInap/statusRI', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanAgamaKunjunganRI()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Inap Berdasarkan Agama";
    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatInap/agamaRI', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanPekerjaanKunjunganRI()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Inap Berdasarkan Pekerjaan";
    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatInap/pekerjaanRI', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanStatusPerkawinanKunjunganRI()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Inap Berdasarkan Status Perkawinan";
    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter;
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatInap/statusPerkawinanRI', array(
      'model' => $model, 'format' => $format,
    ));
  }

  public function actionLaporanAlamatKunjunganRI()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Inap Berdasarkan Alamat";
    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatInap/alamatRI', array('model' => $model, 'format' => $format));
  }

  public function actionLaporanKecamatanKunjunganRI()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Inap Berdasarkan Kecamatan";
    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $format = new MyFormatter();
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatInap/kecamatanRI', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanKabKotaKunjunganRI()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Inap Berdasarkan Kabupaten / Kota";
    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatInap/kabupatenRI', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanCaraMasukKunjunganRI()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Inap Berdasarkan Cara Masuk";
    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatInap/caraMasukRI', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanRujukanKunjunganRI()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Inap Berdasarkan Rujukan";
    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $this->render($this->pathViewPP . 'rawatInap/rujukanRI', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanPemeriksaanKunjunganRI()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Inap Berdasarkan Pemeriksaan";
    $format = new MyFormatter();
    $model = new PPInfoKunjunganRIV('search');
    $model->tgl_awal = date('Y-m-d 00:00:00');
    $model->tgl_akhir = date('Y-m-d H:i:s');

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
    }

    $this->render($this->pathViewPP . 'rawatInap/pemeriksaanRI', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanKetPulangKunjunganRI()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Inap Berdasarkan Keterangan Pulang";
    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatInap/ketPulangRI', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanPenjaminKunjunganRI()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Inap Berdasarkan Penjamin";
    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatInap/penjaminRI', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanDokterPemeriksaKunjunganRI()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Inap Berdasarkan Dokter Pemeriksa";
    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatInap/dokterPemeriksaRI', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintPemeriksaKunjunganRI()
  {
    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->instalasi_id = Params::INSTALASI_ID_RI;
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Inap';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RI;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printPemeriksaan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionLaporanUnitPelayananKunjunganRI()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Inap Berdasarkan Unit Pelayanan";
    $model = new PPRuanganM('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->tipe = 'rawatinap';

    if (isset($_GET['PPRuanganM'])) {
      $model->attributes = $_GET['PPRuanganM'];
      $model->jns_periode = $_GET['PPRuanganM']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPRuanganM']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPRuanganM']['bln_akhir']);
      $model->thn_awal = $_GET['PPRuanganM']['thn_awal'];
      $model->thn_akhir = $_GET['PPRuanganM']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      $model->tipe = 'rawatinap';
    }

    $this->render($this->pathViewPP . 'rawatInap/unitPelayananRI', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanRKKunjunganRI()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Inap Berdasarkan Rekam Medik";
    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $this->render($this->pathViewPP . 'rawatInap/rmRI', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanKamarRuanganKunjunganRI()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Inap Berdasarkan Kamar Ruangan";
    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'rawatInap/kamarRuanganRI', array(
      'model' => $model, 'format' => $format
    ));
  }

  // -- END VIEW LAPORAN -- //
  // -- PRINT LAPORAN -- //
  public function actionPrintKunjunganRI()
  {
    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Inap';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printRI';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, 'RI');
  }

  public function actionPrintKunjunganRIGlobal()
  {
    $model = new PPInfokunjunganriglobalV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Inap';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfokunjunganriglobalV'])) {
      $model->attributes = $_GET['PPInfokunjunganriglobalV'];
      $model->jns_periode = $_GET['PPInfokunjunganriglobalV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfokunjunganriglobalV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfokunjunganriglobalV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfokunjunganriglobalV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfokunjunganriglobalV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfokunjunganriglobalV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfokunjunganriglobalV']['thn_akhir'];
      $model->pilihanPeriode = $_GET['PPInfokunjunganriglobalV']['pilihanPeriode'];
      $model->carakeluar_id = $_GET['PPInfokunjunganriglobalV']['carakeluar_id'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printRIGlobal';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, 'RI');
  }

  public function actionPrintAlasanPulangKunjunganRI()
  {
    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Inap Berdasarkan Alasan Pulang';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Alasan Pulang';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRIV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printAlasanPulang';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, 'RI');
  }

  public function actionPrintUmurKunjunganRI()
  {
    $model = new PPInfoKunjunganRIV('searchUmur');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Inap';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printUmur';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, 'RI');
  }

  public function actionPrintAgamaKunjunganRI()
  {
    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Inap Berdasarkan Agama';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Agama';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRIV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printAgama';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, 'RI');
  }

  public function actionPrintAlamatKunjunganRI()
  {
    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Inap';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printAlamat';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, 'RI');
  }

  public function actionPrintJkKunjunganRI()
  {
    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Inap Berdasarkan Jenis Kelamin';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Jenis Kelamin';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRIV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printJk';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, 'RI');
  }

  public function actionPrintStatusKunjunganRI()
  {
    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Inap';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printStatus';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, 'RI');
  }

  public function actionPrintStatusPerkawinanKunjunganRI()
  {
    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Inap';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printStatusPerkawinan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, 'RI');
  }

  public function actionPrintRujukanKunjunganRI()
  {
    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Inap';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printRujukan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, 'RI');
  }

  public function actionPrintCaraMasukKunjunganRI()
  {
    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Inap Berdasarkan Cara Masuk';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Cara Masuk';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printCaraMasuk';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, 'RI');
  }

  public function actionPrintKetPulangKunjunganRI()
  {
    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Inap Berdasarkan Keterangan Pulang';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Keterangan Pulang';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printKetPulang';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, 'RI');
  }

  public function actionPrintKabKotaKunjunganRI()
  {
    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Inap Berdasarkan Kabupaten / Kota';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Kabupaten / Kota';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printKabupaten';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, 'RI');
  }

  public function actionPrintKecamatanKunjunganRI()
  {
    $model = new PPInfoKunjunganRIV('search');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Inap Berdasarkan Kecamatan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Kecamatan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRIV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printKecamatan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, 'RI');
  }

  public function actionPrintPenjaminKunjunganRI()
  {
    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Inap';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printPenjamin';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, 'RI');
  }

  public function actionPrintPemeriksaanKunjunganRI()
  {
    $model = new PPInfoKunjunganRJV('search');
    $model->tgl_awal = date('Y-m-d') . ' 00:00:00';
    $model->tgl_akhir = date('Y-m-d H:i:s');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Inap Berdasarkan Pemeriksaan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Pemeriksaan';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['PPInfoKunjunganRIV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRIV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRIV']['tgl_akhir']);
      //            $model->bulan =DATE_PART('MONTH',$_REQUEST['PPInfoKunjunganRJV']['bulan']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printPemeriksaan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, 'RI');
  }

  public function actionPrintDokterPemeriksaKunjunganRI()
  {
    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Inap Berdasarkan Dokter Pemeriksa';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Dokter Pemeriksa';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printDokterPemeriksa';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, 'RI');
  }

  public function actionPrintUnitPelayananKunjunganRI()
  {
    $model = new PPRuanganM('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->tipe = 'rawatinap';
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Inap';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPRuanganM'])) {
      $model->attributes = $_GET['PPRuanganM'];
      $model->jns_periode = $_GET['PPRuanganM']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPRuanganM']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPRuanganM']['bln_akhir']);
      $model->thn_awal = $_GET['PPRuanganM']['thn_awal'];
      $model->thn_akhir = $_GET['PPRuanganM']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      $model->tipe = 'rawatinap';
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printUnitPelayanan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, 'RI');
  }

  public function actionPrintRKKunjunganRI()
  {
    $model = new PPInfoKunjunganRIV('search');
    $model->tgl_awal = date('Y-m-d') . ' 00:00:00';
    $model->tgl_akhir = date('Y-m-d H:i:s');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Inap Berdasarkan Rekam Medik';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Rekam Medik';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['PPInfoKunjunganRIV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRIV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRIV']['tgl_akhir']);
      //            $model->bulan =DATE_PART('MONTH',$_REQUEST['PPInfoKunjunganRJV']['bulan']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printrmRI';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, 'RI');
  }

  public function actionPrintKamarRuanganKunjunganRI()
  {
    $model = new PPInfoKunjunganRIV('search');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Inap Berdasarkan Kamar Ruangan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Kamar Ruangan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printKamarRuanganRI';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, 'RI');
  }

  // -- END PRINT LAPORAN --//
  // -- GRAFIK LAPORAN -- //
  public function actionFrameGrafikRI()
  {
    $this->layout = '//layouts/iframe';
    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikAlasanPulangRI()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Alasan Pulang';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikAlasanPulang', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikAgamaRI()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Agama';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikAgama', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikAlamatRI()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Alamat';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikAlamat', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikCaraMasukRI()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Cara Masuk';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikCaraMasuk', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikDokterPemeriksaRI()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Dokter Pemeriksa';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikDokterPemeriksa', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikJkRI()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Jenis Kelamin';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikJk', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikKabKotaRI()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Kabupaten / Kota';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikKabupaten', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikKecamatanRI()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Kecamatan';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikKecamatan', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikKetPulangRI()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Keterangan Pulang';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikKetPulang', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikPekerjaanRI()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Pekerjaan';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikPekerjaan', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikPemeriksaanRI()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Pemeriksaan';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikPemeriksaan', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikPenjaminRI()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Penjamin';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikPenjamin', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikRujukanRI()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Rujukan';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikRujukan', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikStatusPerkawinanRI()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Status Perkawinan';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikStatusPerkawinan', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikStatusRI()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Kedatangan Lama / Baru';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikStatus', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikUmurRI()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Umur';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikUmur', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikUnitPelayananRI()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPRuanganM('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->tipe = 'rawatinap';
    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Unit Pelayanan';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPRuanganM'])) {
      $model->attributes = $_GET['PPRuanganM'];
      $model->jns_periode = $_GET['PPRuanganM']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPRuanganM']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPRuanganM']['bln_akhir']);
      $model->thn_awal = $_GET['PPRuanganM']['thn_awal'];
      $model->thn_akhir = $_GET['PPRuanganM']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      $model->tipe = 'rawatinap';
    }

    $this->render($this->pathViewPP . '_grafikUnitPelayanan', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikRekamMedikRI()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Rekam Medik';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikrmRI', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikKamarRuanganRI()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRIV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Kamar Ruangan';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikKamarRuanganRI', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  // -- END GRAFIK LAPORAN --//
  // -- End Laporan Kunjungan RI --//
  public function actionLaporanBukuRegister()
  {
    $this->pageTitle = Yii::app()->name . " - Buku Register";
    $format = new MyFormatter();
    $model = new PPBukuregisterpasienV();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPBukuregisterpasienV'])) {
      $model->attributes = $_GET['PPBukuregisterpasienV'];
      $model->jns_periode = $_GET['PPBukuregisterpasienV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPBukuregisterpasienV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPBukuregisterpasienV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPBukuregisterpasienV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPBukuregisterpasienV']['bln_akhir']);
      $model->thn_awal = $_GET['PPBukuregisterpasienV']['thn_awal'];
      $model->thn_akhir = $_GET['PPBukuregisterpasienV']['thn_akhir'];
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
      // //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      // //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      $model->pegawai_id = isset($_GET['PPBukuregisterpasienV']['pegawai_id']) ? $_GET['PPBukuregisterpasienV']['pegawai_id'] : null;
    }

    $this->render($this->pathViewPP . 'bukuRegister/adminBukuRegister', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintBukuRegister()
  {
    $model = new PPBukuregisterpasienV('searchPrint');
    $judulLaporan = 'Laporan Buku Register';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Buku Register';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_REQUEST['PPBukuregisterpasienV'])) {
      $model->attributes = $_REQUEST['PPBukuregisterpasienV'];
      $model->jns_periode = $_REQUEST['PPBukuregisterpasienV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPBukuregisterpasienV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPBukuregisterpasienV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPBukuregisterpasienV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPBukuregisterpasienV']['bln_akhir']);
      $model->thn_awal = $_GET['PPBukuregisterpasienV']['thn_awal'];
      $model->thn_akhir = $_GET['PPBukuregisterpasienV']['thn_akhir'];
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
      // //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      // //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      $model->pegawai_id = isset($_GET['PPBukuregisterpasienV']['pegawai_id']) ? $_GET['PPBukuregisterpasienV']['pegawai_id'] : null;
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . 'bukuRegister/_printBukuRegister';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikBukuRegister()
  {
    $this->layout = '//layouts/iframe';
    $model = new PPBukuregisterpasienV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Grafik Buku Register';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPBukuregisterpasienV'])) {
      $model->attributes = $_GET['PPBukuregisterpasienV'];
      $model->jns_periode = $_REQUEST['PPBukuregisterpasienV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPBukuregisterpasienV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPBukuregisterpasienV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPBukuregisterpasienV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPBukuregisterpasienV']['bln_akhir']);
      $model->thn_awal = $_GET['PPBukuregisterpasienV']['thn_awal'];
      $model->thn_akhir = $_GET['PPBukuregisterpasienV']['thn_akhir'];
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
      // //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      // //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      $model->pegawai_id = isset($_GET['PPBukuregisterpasienV']['pegawai_id']) ? $_GET['PPBukuregisterpasienV']['pegawai_id'] : null;
    }

    $this->render($this->pathViewPP . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanBatalPeriksa()
  {
    $model = new PPPasienbatalperiksa('search');
    $model->tgl_awal = date('Y-m-d 00:00:00');
    $model->tgl_akhir = date('Y-m-d H:i:s');

    if (isset($_GET['PPPasienbatalperiksa'])) {
      $model->attributes = $_GET['PPPasienbatalperiksa'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienbatalperiksa']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienbatalperiksa']['tgl_akhir']);
    }

    $this->render($this->pathViewPP . 'batalPeriksa/adminBatalPeriksa', array(
      'model' => $model,
    ));
  }

  public function actionPrintBatalPeriksa()
  {
    $model = new PPPasienbatalperiksa('search');
    $judulLaporan = 'Laporan Pasien Batal Periksa';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Pasien Batal Periksa';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['PPPasienbatalperiksa'])) {
      $model->attributes = $_REQUEST['PPPasienbatalperiksa'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPPasienbatalperiksa']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPPasienbatalperiksa']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . 'batalPeriksa/_printBatalPeriksa';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikBatalPeriksa()
  {
    $this->layout = '//layouts/iframe';
    $model = new PPPasienbatalperiksa('search');
    $model->tgl_awal = date('Y-m-d 00:00:00');
    $model->tgl_akhir = date('Y-m-d H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Pasien Batal Periksa';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPPasienbatalperiksa'])) {
      $model->attributes = $_GET['PPPasienbatalperiksa'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienbatalperiksa']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienbatalperiksa']['tgl_akhir']);
    }

    $this->render($this->pathViewPP . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  //    public function actionLaporan10Besar() {
  //        $model = new PPLaporan10besarpenyakit('search');
  //        $model->tgl_awal = date('Y-m-d H:i:s');
  //        $model->tgl_akhir = date('Y-m-d H:i:s');
  //        $model->jumlahTampil = 10;
  //        if (isset($_GET['PPLaporan10besarpenyakit'])) {
  //            $model->attributes = $_GET['PPLaporan10besarpenyakit'];
  //            $format = new MyFormatter();
  //            $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPLaporan10besarpenyakit']['tgl_awal']);
  //            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPLaporan10besarpenyakit']['tgl_akhir']);
  //        }
  //
  //        $this->render($this->pathViewPP.'10Besar/admin10BesarPenyakit', array(
  //            'model' => $model,
  //        ));
  //    }
  //
  //    public function actionPrint10BesarPenyakit() {
  //        $model = new PPLaporan10besarpenyakit('search');
  //        $judulLaporan = 'Laporan 10 Besar Penyakit';
  //
  //        //Data Grafik
  //        $data['title'] = 'Grafik Laporan 10 Besar Penyakit';
  //        $data['type'] = $_REQUEST['type'];
  //        if (isset($_REQUEST['PPLaporan10besarpenyakit'])) {
  //            $model->attributes = $_REQUEST['PPLaporan10besarpenyakit'];
  //            $format = new MyFormatter();
  //            $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPLaporan10besarpenyakit']['tgl_awal']);
  //            $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPLaporan10besarpenyakit']['tgl_akhir']);
  //        }
  //        
  //        $caraPrint = $_REQUEST['caraPrint'];
  //        $target = $this->pathViewPP.'10Besar/_print10BesarPenyakit';
  //        
  //        $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  //    }
  //
  //    public function actionFrameGrafik10BesarPenyakit() {
  //        $this->layout = '//layouts/iframe';
  //        $model = new PPLaporan10besarpenyakit('search');
  //        $model->tgl_awal = date('Y-m-d H:i:s');
  //        $model->tgl_akhir = date('Y-m-d H:i:s');
  //
  //        //Data Grafik
  //        $data['title'] = 'Grafik Laporan 10 Besar Penyakit';
  //        $data['type'] = $_GET['type'];
  //        
  //        if (isset($_GET['PPLaporan10besarpenyakit'])) {
  //            $model->attributes = $_GET['PPLaporan10besarpenyakit'];
  //            $format = new MyFormatter();
  //            $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPLaporan10besarpenyakit']['tgl_awal']);
  //            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPLaporan10besarpenyakit']['tgl_akhir']);
  //        }
  //        
  //        $this->render($this->pathViewPP.'_grafik', array(
  //            'model' => $model,
  //            'data' => $data,
  //        ));
  //    }


  public function actionLaporanKarcis()
  {
    $model = new PPLaporankarcispasien('search');
    $model->tgl_awal = date('Y-m-d 00:00:00');
    $model->tgl_akhir = date('Y-m-d H:i:s');

    if (isset($_GET['PPLaporankarcispasien'])) {
      $model->attributes = $_GET['PPLaporankarcispasien'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPLaporankarcispasien']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPLaporankarcispasien']['tgl_akhir']);
    }

    $this->render($this->pathViewPP . 'karcis/adminKarcis', array(
      'model' => $model,
    ));
  }

  public function actionPrintLaporanKarcis()
  {
    $model = new PPLaporankarcispasien('search');
    $judulLaporan = 'Laporan Karcis Pasien';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Karcis Pasien';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['PPLaporankarcispasien'])) {
      $model->attributes = $_REQUEST['PPLaporankarcispasien'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPLaporankarcispasien']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPLaporankarcispasien']['tgl_akhir']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . 'karcis/_printLaporanKarcis';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameLaporanKarcis()
  {
    $this->layout = '//layouts/iframe';
    $model = new PPLaporankarcispasien('search');
    $model->tgl_awal = date('Y-m-d 00:00:00');
    $model->tgl_akhir = date('Y-m-d H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Karcis Pasien';
    $data['type'] = $_GET['type'];
    if (isset($_GET['PPLaporankarcispasien'])) {
      $model->attributes = $_GET['PPLaporankarcispasien'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPLaporankarcispasien']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPLaporankarcispasien']['tgl_akhir']);
    }

    $this->render($this->pathViewPP . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanKunjunganRS()
  {
    $this->pageTitle = Yii::app()->name . " - Kunjungan Rumah Sakit";
    $model = new PPLaporankunjunganrs('searchTable');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPLaporankunjunganrs'])) {
      $model->attributes = $_GET['PPLaporankunjunganrs'];
      $model->jns_periode = $_GET['PPLaporankunjunganrs']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPLaporankunjunganrs']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPLaporankunjunganrs']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPLaporankunjunganrs']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPLaporankunjunganrs']['bln_akhir']);
      $model->thn_awal = $_GET['PPLaporankunjunganrs']['thn_awal'];
      $model->thn_akhir = $_GET['PPLaporankunjunganrs']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'kunjunganRS/adminKunjunganRS', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionGetRuanganForCheckBox($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = $_POST["$namaModel"]['instalasi_id'];
      if ($encode) {
        echo CJSON::encode($ruangan);
      } else {
        if (empty($instalasi_id)) {
          $ruangan = RuanganM::model()->findAll('instalasi_id=9999  AND ruangan_aktif = true ORDER BY ruangan_nama ASC');
        } else {
          $ruangan = RuanganM::model()->findAll('instalasi_id=' . $instalasi_id . ' AND ruangan_aktif = true ORDER BY ruangan_nama ASC');
        }
        $ruangan = CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama');
        echo CHtml::hiddenField('' . $namaModel . '[ruangan_id]');
        $i = 0;
        if (count((array)$ruangan) > 0) {
          echo "<div style='margin-left:-10px'>" . CHtml::checkBox('checkAllRuangan', true, array(
            'onkeypress' => "return $(this).focusNextInputField(event)",
            'class' => 'checkbox-column', 'onclick' => 'checkAll()', 'checked' => 'checked'
          )) . "<label>Pilih Semua</label>";
          echo "</div><br>";
          foreach ($ruangan as $value => $name) {

            //                        echo '<label class="checkbox">';
            //                        echo CHtml::checkBox(''.$namaModel."[ruangan_id][]", true, array('value'=>$value));
            //                        echo '<label for="'.$namaModel.'_ruangan_id_'.$i.'">'.$name.'</label>';
            //                        echo '</label>';
            $selects[] = $value;
            $i++;
          }
          echo CHtml::checkBoxList('' . $namaModel . "[ruangan_id]", $selects, $ruangan);
        } else {
          echo '<label>Data Tidak Ditemukan</label>';
        }
      }
    }
    Yii::app()->end();
  }

  public function actionPrintLaporanKunjunganRS()
  {
    $model = new PPLaporankunjunganrs('searchPrint');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Rumah Sakit';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Rumah Sakit';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPLaporankunjunganrs'])) {
      $model->attributes = $_REQUEST['PPLaporankunjunganrs'];
      $model->jns_periode = $_GET['PPLaporankunjunganrs']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPLaporankunjunganrs']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPLaporankunjunganrs']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPLaporankunjunganrs']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPLaporankunjunganrs']['bln_akhir']);
      $model->thn_awal = $_GET['PPLaporankunjunganrs']['thn_awal'];
      $model->thn_akhir = $_GET['PPLaporankunjunganrs']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . 'kunjunganRS/_printKunjunganRS';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikKunjunganRS()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPLaporankunjunganrs('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Rumah Sakit';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPLaporankunjunganrs'])) {
      $model->attributes = $_GET['PPLaporankunjunganrs'];
      $model->jns_periode = $_GET['PPLaporankunjunganrs']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPLaporankunjunganrs']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPLaporankunjunganrs']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPLaporankunjunganrs']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPLaporankunjunganrs']['bln_akhir']);
      $model->thn_awal = $_GET['PPLaporankunjunganrs']['thn_awal'];
      $model->thn_akhir = $_GET['PPLaporankunjunganrs']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporan10Besar()
  {
    $this->pageTitle = Yii::app()->name . " - 10 Besar Penyakit";
    $model = new PPLaporan10besarpenyakit('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->jumlahTampil = 10;
    if (isset($_GET['PPLaporan10besarpenyakit'])) {
      $model->attributes = $_GET['PPLaporan10besarpenyakit'];
      $model->jns_periode = $_GET['PPLaporan10besarpenyakit']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPLaporan10besarpenyakit']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPLaporan10besarpenyakit']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPLaporan10besarpenyakit']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPLaporan10besarpenyakit']['bln_akhir']);
      $model->thn_awal = $_GET['PPLaporan10besarpenyakit']['thn_awal'];
      $model->thn_akhir = $_GET['PPLaporan10besarpenyakit']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      $model->jumlahTampil = $_GET['PPLaporan10besarpenyakit']['jumlahTampil'];
      $model->instalasi_id = !empty($_GET['PPLaporan10besarpenyakit']['instalasi_id']) ? $_GET['PPLaporan10besarpenyakit']['instalasi_id'] : null;
    }

    $this->render($this->pathViewPP . '10Besar/admin10BesarPenyakit', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrint10BesarPenyakit()
  {
    $model = new PPLaporan10besarpenyakit('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan 10 Besar Penyakit';

    //Data Grafik
    $data['title'] = 'Grafik Laporan 10 Besar Penyakit';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['PPLaporan10besarpenyakit'])) {
      $model->attributes = $_REQUEST['PPLaporan10besarpenyakit'];
      $model->jns_periode = $_GET['PPLaporan10besarpenyakit']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPLaporan10besarpenyakit']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPLaporan10besarpenyakit']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPLaporan10besarpenyakit']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPLaporan10besarpenyakit']['bln_akhir']);
      $model->thn_awal = $_GET['PPLaporan10besarpenyakit']['thn_awal'];
      $model->thn_akhir = $_GET['PPLaporan10besarpenyakit']['thn_akhir'];
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
      $model->jumlahTampil = $_GET['PPLaporan10besarpenyakit']['jumlahTampil'];
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '10Besar/_print10BesarPenyakit';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafik10BesarPenyakit()
  {
    $this->layout = '//layouts/iframe';
    $model = new PPLaporan10besarpenyakit('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan 10 Besar Penyakit';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPLaporan10besarpenyakit'])) {
      $model->attributes = $_GET['PPLaporan10besarpenyakit'];
      $model->jns_periode = $_GET['PPLaporan10besarpenyakit']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPLaporan10besarpenyakit']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPLaporan10besarpenyakit']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPLaporan10besarpenyakit']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPLaporan10besarpenyakit']['bln_akhir']);
      $model->thn_awal = $_GET['PPLaporan10besarpenyakit']['thn_awal'];
      $model->thn_akhir = $_GET['PPLaporan10besarpenyakit']['thn_akhir'];
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
      $model->jumlahTampil = $_GET['PPLaporan10besarpenyakit']['jumlahTampil'];
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanTindakLanjut()
  {
    $this->pageTitle = Yii::app()->name . " - Tindak Lanjut";
    $model = new RKLaporantindaklanjutV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $temp = array();

    foreach (CarakeluarM::model()->getCaraKeluar() as $i => $data) {
      $temp[] = strtoupper($data);
    }
    $model->carakeluar = $temp;

    if (isset($_GET['RKLaporantindaklanjutV'])) {
      $model->attributes = $_GET['RKLaporantindaklanjutV'];
      $model->jns_periode = $_GET['RKLaporantindaklanjutV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RKLaporantindaklanjutV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RKLaporantindaklanjutV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RKLaporantindaklanjutV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RKLaporantindaklanjutV']['bln_akhir']);
      $model->thn_awal = $_GET['RKLaporantindaklanjutV']['thn_awal'];
      $model->thn_akhir = $_GET['RKLaporantindaklanjutV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render('tindakLanjut/adminTindakLanjut', array(
      'model' => $model,
    ));
  }

  public function actionPrintLaporanTindakLanjut()
  {
    $model = new RKLaporantindaklanjutV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Tindak Lanjut Pasien Rawat Jalan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Tindak Lanjut Pasien';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['RKLaporantindaklanjutV'])) {
      $model->attributes = $_REQUEST['RKLaporantindaklanjutV'];
      $model->jns_periode = $_GET['RKLaporantindaklanjutV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RKLaporantindaklanjutV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RKLaporantindaklanjutV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RKLaporantindaklanjutV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RKLaporantindaklanjutV']['bln_akhir']);
      $model->thn_awal = $_GET['RKLaporantindaklanjutV']['thn_awal'];
      $model->thn_akhir = $_GET['RKLaporantindaklanjutV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'tindakLanjut/_printTindakLanjut';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanTindakLanjut()
  {
    $this->layout = '//layouts/iframe';
    $model = new RKLaporantindaklanjutV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik 
    $data['title'] = 'Grafik Laporan Tindak Lanjut Pasien';
    $data['type'] = $_GET['type'];
    if (isset($_GET['RKLaporantindaklanjutV'])) {
      $model->attributes = $_GET['RKLaporantindaklanjutV'];
      $model->jns_periode = $_GET['RKLaporantindaklanjutV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RKLaporantindaklanjutV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RKLaporantindaklanjutV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RKLaporantindaklanjutV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RKLaporantindaklanjutV']['bln_akhir']);
      $model->thn_awal = $_GET['RKLaporantindaklanjutV']['thn_awal'];
      $model->thn_akhir = $_GET['RKLaporantindaklanjutV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanCaraMasukPasien()
  {
    $this->pageTitle = Yii::app()->name . " - Cara Masuk";
    $model = new RKLaporancaramasukpasienV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $asalrujukan = CHtml::listData(AsalrujukanM::model()->findAll('asalrujukan_aktif = true'), 'asalrujukan_id', 'asalrujukan_id');
    $model->asalrujukan_id = $asalrujukan;
    $filter = array();
    if (isset($_GET['RKLaporancaramasukpasienV'])) {
      $model->attributes = $_GET['RKLaporancaramasukpasienV'];
      $model->jns_periode = $_GET['RKLaporancaramasukpasienV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RKLaporancaramasukpasienV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RKLaporancaramasukpasienV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RKLaporancaramasukpasienV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RKLaporancaramasukpasienV']['bln_akhir']);
      $model->thn_awal = $_GET['RKLaporancaramasukpasienV']['thn_awal'];
      $model->thn_akhir = $_GET['RKLaporancaramasukpasienV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render('caraMasuk/adminCaraMasukPasien', array(
      'model' => $model, 'filter' => $filter, 'format' => $format
    ));
  }

  public function actionPrintLaporanCaraMasukPasien()
  {
    $model = new RKLaporancaramasukpasienV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Cara Masuk Pasien Rawat Jalan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Cara Masuk Pasien';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['RKLaporancaramasukpasienV'])) {
      $model->attributes = $_REQUEST['RKLaporancaramasukpasienV'];
      $model->jns_periode = $_REQUEST['RKLaporancaramasukpasienV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RKLaporancaramasukpasienV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RKLaporancaramasukpasienV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['RKLaporancaramasukpasienV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['RKLaporancaramasukpasienV']['bln_akhir']);
      $model->thn_awal = $_GET['RKLaporancaramasukpasienV']['thn_awal'];
      $model->thn_akhir = $_GET['RKLaporancaramasukpasienV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'caraMasuk/_printCaraMasuk';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanCaraMasukPasien()
  {
    $this->layout = '//layouts/iframe';
    $model = new RKLaporancaramasukpasienV('searchGrafik');
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
    $data['title'] = 'Grafik Laporan Cara Masuk Pasien';
    $data['type'] = $_GET['type'];
    if (isset($_GET['RKLaporancaramasukpasienV'])) {
      $model->attributes = $_GET['RKLaporancaramasukpasienV'];
      $model->jns_periode = $_GET['RKLaporancaramasukpasienV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RKLaporancaramasukpasienV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RKLaporancaramasukpasienV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RKLaporancaramasukpasienV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RKLaporancaramasukpasienV']['bln_akhir']);
      $model->thn_awal = $_GET['RKLaporancaramasukpasienV']['thn_awal'];
      $model->thn_akhir = $_GET['RKLaporancaramasukpasienV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanMorbiditas()
  {
    $controller = Yii::app()->controller->action->id;
  
    $this->pageTitle = Yii::app()->name . " - Morbiditas";
    $model = new RKLaporanmorbiditasV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['RKLaporanmorbiditasV'])) {
      $model->attributes = $_GET['RKLaporanmorbiditasV'];
      $model->jns_periode = $_GET['RKLaporanmorbiditasV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RKLaporanmorbiditasV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RKLaporanmorbiditasV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RKLaporanmorbiditasV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RKLaporanmorbiditasV']['bln_akhir']);
      $model->thn_awal = $_GET['RKLaporanmorbiditasV']['thn_awal'];
      $model->thn_akhir = $_GET['RKLaporanmorbiditasV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      $model->instalasi_id = isset($_GET['RKLaporanmorbiditasV']['instalasi_id']) ? $_GET['RKLaporanmorbiditasV']['instalasi_id'] : null;
    }

    $this->render('morbiditas/admin', array(
      'model' => $model, 'format' => $format, 'controller' =>$controller
    ));
  }

  public function actionPrintLaporanMorbiditas()
  {
    
    $model = new RKLaporanmorbiditasV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Morbiditas Pasien';
    
    //Data Grafik
    $data['title'] = 'Grafik Laporan Morbiditas Pasien';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['RKLaporanmorbiditasV'])) {
      $model->attributes = $_REQUEST['RKLaporanmorbiditasV'];
      $model->jns_periode = $_REQUEST['RKLaporanmorbiditasV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RKLaporanmorbiditasV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RKLaporanmorbiditasV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['RKLaporanmorbiditasV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['RKLaporanmorbiditasV']['bln_akhir']);
      $model->thn_awal = $_GET['RKLaporanmorbiditasV']['thn_awal'];
      $model->thn_akhir = $_GET['RKLaporanmorbiditasV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      $model->instalasi_id = isset($_GET['RKLaporanmorbiditasV']['instalasi_id']) ? $_GET['RKLaporanmorbiditasV']['instalasi_id'] : null;
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'morbiditas/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanMorbiditas()
  {
    $this->layout = '//layouts/iframe';

    $model = new RKLaporanmorbiditasV();
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
    $data['title'] = 'Grafik Laporan Morbiditas Pasien';
    $data['type'] = $_GET['type'];

    if (isset($_GET['RKLaporanmorbiditasV'])) {
      $model->attributes = $_GET['RKLaporanmorbiditasV'];
      $model->jns_periode = $_GET['RKLaporanmorbiditasV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RKLaporanmorbiditasV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RKLaporanmorbiditasV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RKLaporanmorbiditasV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RKLaporanmorbiditasV']['bln_akhir']);
      $model->thn_awal = $_GET['RKLaporanmorbiditasV']['thn_awal'];
      $model->thn_akhir = $_GET['RKLaporanmorbiditasV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      $model->instalasi_id = isset($_GET['RKLaporanmorbiditasV']['instalasi_id']) ? $_GET['RKLaporanmorbiditasV']['instalasi_id'] : null;
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanMortalitas()
  {
    $this->pageTitle = Yii::app()->name . " - Mortalitas";
    $model = new RKLaporanmortalitaspasienV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['RKLaporanmortalitaspasienV'])) {
      $model->attributes = $_GET['RKLaporanmortalitaspasienV'];
      $model->jns_periode = $_GET['RKLaporanmortalitaspasienV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RKLaporanmortalitaspasienV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RKLaporanmortalitaspasienV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RKLaporanmortalitaspasienV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RKLaporanmortalitaspasienV']['bln_akhir']);
      $model->thn_awal = $_GET['RKLaporanmortalitaspasienV']['thn_awal'];
      $model->thn_akhir = $_GET['RKLaporanmortalitaspasienV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      $model->instalasi_id = isset($_GET['RKLaporanmortalitaspasienV']['instalasi_id']) ? $_GET['RKLaporanmortalitaspasienV']['instalasi_id'] : null;
    }

    $this->render('mortalitas/admin', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintLaporanMortalitas()
  {
    $model = new RKLaporanmortalitaspasienV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Mortalitas Pasien';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Mortalitas Pasien';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['RKLaporanmortalitaspasienV'])) {
      $model->attributes = $_REQUEST['RKLaporanmortalitaspasienV'];
      $model->jns_periode = $_REQUEST['RKLaporanmortalitaspasienV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RKLaporanmortalitaspasienV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RKLaporanmortalitaspasienV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['RKLaporanmortalitaspasienV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['RKLaporanmortalitaspasienV']['bln_akhir']);
      $model->thn_awal = $_GET['RKLaporanmortalitaspasienV']['thn_awal'];
      $model->thn_akhir = $_GET['RKLaporanmortalitaspasienV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      $model->instalasi_id = isset($_GET['RKLaporanmortalitaspasienV']['instalasi_id']) ? $_GET['RKLaporanmortalitaspasienV']['instalasi_id'] : null;
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'mortalitas/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanMortalitas()
  {
    $this->layout = '//layouts/iframe';

    $model = new RKLaporanmortalitaspasienV();
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
    $data['title'] = 'Grafik Laporan Mortalitas Pasien';
    $data['type'] = $_GET['type'];

    if (isset($_GET['RKLaporanmortalitaspasienV'])) {
      $model->attributes = $_GET['RKLaporanmortalitaspasienV'];
      $model->jns_periode = $_GET['RKLaporanmortalitaspasienV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RKLaporanmortalitaspasienV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RKLaporanmortalitaspasienV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RKLaporanmortalitaspasienV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RKLaporanmortalitaspasienV']['bln_akhir']);
      $model->thn_awal = $_GET['RKLaporanmortalitaspasienV']['thn_awal'];
      $model->thn_akhir = $_GET['RKLaporanmortalitaspasienV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      $model->instalasi_id = isset($_GET['RKLaporanmortalitaspasienV']['instalasi_id']) ? $_GET['RKLaporanmortalitaspasienV']['instalasi_id'] : null;
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanKunjunganDokter()
  {
    $this->pageTitle = Yii::app()->name . " - Kunjungan Oleh Dokter";
    $model = new PPLaporankunjunganbydokterV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPLaporankunjunganbydokterV'])) {
      $model->attributes = $_GET['PPLaporankunjunganbydokterV'];
      $model->jns_periode = $_GET['PPLaporankunjunganbydokterV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPLaporankunjunganbydokterV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPLaporankunjunganbydokterV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPLaporankunjunganbydokterV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPLaporankunjunganbydokterV']['bln_akhir']);
      $model->thn_awal = $_GET['PPLaporankunjunganbydokterV']['thn_awal'];
      $model->thn_akhir = $_GET['PPLaporankunjunganbydokterV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'kunjunganDokter/adminKunjunganDokter', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintLaporanKunjunganDokter()
  {
    $model = new PPLaporankunjunganbydokterV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Dokter';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Dokter';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['PPLaporankunjunganbydokterV'])) {
      $model->attributes = $_REQUEST['PPLaporankunjunganbydokterV'];
      $model->jns_periode = $_REQUEST['PPLaporankunjunganbydokterV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPLaporankunjunganbydokterV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPLaporankunjunganbydokterV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPLaporankunjunganbydokterV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPLaporankunjunganbydokterV']['bln_akhir']);
      $model->thn_awal = $_GET['PPLaporankunjunganbydokterV']['thn_awal'];
      $model->thn_akhir = $_GET['PPLaporankunjunganbydokterV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . 'kunjunganDokter/_printKunjunganDokter';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikKunjunganDokter()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPLaporankunjunganbydokterV();
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
    $data['title'] = 'Grafik Laporan Kunjungan Dokter';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPLaporankunjunganbydokterV'])) {
      $model->attributes = $_GET['PPLaporankunjunganbydokterV'];
      $model->jns_periode = $_GET['PPLaporankunjunganbydokterV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPLaporankunjunganbydokterV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPLaporankunjunganbydokterV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPLaporankunjunganbydokterV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPLaporankunjunganbydokterV']['bln_akhir']);
      $model->thn_awal = $_GET['PPLaporankunjunganbydokterV']['thn_awal'];
      $model->thn_akhir = $_GET['PPLaporankunjunganbydokterV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanPerUnitPelayanan()
  {
    $this->pageTitle = Yii::app()->name . " - Rekapitulasi Per Unit Pelayanan";
    $model = new PPRuanganM('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    if (isset($_GET['PPRuanganM'])) {
      $model->attributes = $_GET['PPRuanganM'];

      $model->jns_periode = $_GET['PPRuanganM']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPRuanganM']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPRuanganM']['bln_akhir']);
      $model->thn_awal = $_GET['PPRuanganM']['thn_awal'];
      $model->thn_akhir = $_GET['PPRuanganM']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      $model->dokter_nama = $_GET['PPRuanganM']['dokter_nama'];
    }

    $this->render($this->pathViewPP . 'unitPelayanan/adminUnitPelayanan', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintLaporanPerUnitPelayanan()
  {
    $model = new PPRuanganM();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Dokter';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Per Unit Pelayanan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPRuanganM'])) {
      $model->attributes = $_REQUEST['PPRuanganM'];
      $model->jns_periode = $_REQUEST['PPRuanganM']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPRuanganM']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPRuanganM']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPRuanganM']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPRuanganM']['bln_akhir']);
      $model->thn_awal = $_GET['PPRuanganM']['thn_awal'];
      $model->thn_akhir = $_GET['PPRuanganM']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      $model->dokter_nama = $_GET['PPRuanganM']['dokter_nama'];
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . 'unitPelayanan/_printUnitPelayanan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionLaporanPerPetugasRJ()
  {
    $this->pageTitle = Yii::app()->name . "- Laporan Kunjungan Rawat Jalan Berdasarakan Petugas Loket";
    $model = new PPInfoKunjunganRJV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
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

    $this->render($this->pathViewPP . 'rawatJalan/petugasRJ', array('model' => $model, 'format' => $format));
  }

  public function actionPrintPetugasRJ()
  {
    $model = new PPInfoKunjunganRJV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Jalan';
    $model->instalasi_id = Params::INSTALASI_ID_RJ;
    $model->create_loginpemakai_id = $_GET['PPInfoKunjunganRJV']['create_loginpemakai_id'];

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_REQUEST['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
      // $model->tipe = 'rawatjalan';
      $model->create_loginpemakai_id = $_GET['PPInfoKunjunganRJV']['create_loginpemakai_id'];

      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
    $target = $this->pathViewPP.'_printPetugas';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikPerUnitPelayanan()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPRuanganM();
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
    $data['title'] = 'Grafik Laporan Kunjungan Per Unit Pelayanan';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPRuanganM'])) {
      $model->attributes = $_GET['PPRuanganM'];
      $model->jns_periode = $_GET['PPRuanganM']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPRuanganM']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPRuanganM']['bln_akhir']);
      $model->thn_awal = $_GET['PPRuanganM']['thn_awal'];
      $model->thn_akhir = $_GET['PPRuanganM']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      $model->dokter_nama = $_GET['PPRuanganM']['dokter_nama'];
    }

    $this->render($this->pathViewPP . '_grafikUnitPelayanan', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanPasienPulang()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Pulang";
    $model = new RKLaporanpasienpulang('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['RKLaporanpasienpulang'])) {
      $model->attributes = $_GET['RKLaporanpasienpulang'];
      $model->jns_periode = $_GET['RKLaporanpasienpulang']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RKLaporanpasienpulang']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RKLaporanpasienpulang']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RKLaporanpasienpulang']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RKLaporanpasienpulang']['bln_akhir']);
      $model->thn_awal = $_GET['RKLaporanpasienpulang']['thn_awal'];
      $model->thn_akhir = $_GET['RKLaporanpasienpulang']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render('pasienPulang/admin', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintLaporanPasienPulang()
  {
    $model = new RKLaporanpasienpulang();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Pasien Pulang';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Pasien Pulang';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['RKLaporanpasienpulang'])) {
      $model->attributes = $_REQUEST['RKLaporanpasienpulang'];
      $model->jns_periode = $_REQUEST['RKLaporanpasienpulang']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RKLaporanpasienpulang']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RKLaporanpasienpulang']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['RKLaporanpasienpulang']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['RKLaporanpasienpulang']['bln_akhir']);
      $model->thn_awal = $_GET['RKLaporanpasienpulang']['thn_awal'];
      $model->thn_akhir = $_GET['RKLaporanpasienpulang']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'pasienPulang/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanPasienPulang()
  {
    $this->layout = '//layouts/iframe';

    $model = new RKLaporanpasienpulang();
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
    $data['title'] = 'Grafik Laporan Pasien Pulang';
    $data['type'] = $_GET['type'];

    if (isset($_GET['RKLaporanpasienpulang'])) {
      $model->attributes = $_GET['RKLaporanpasienpulang'];
      $model->jns_periode = $_GET['RKLaporanpasienpulang']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RKLaporanpasienpulang']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RKLaporanpasienpulang']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RKLaporanpasienpulang']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RKLaporanpasienpulang']['bln_akhir']);
      $model->thn_awal = $_GET['RKLaporanpasienpulang']['thn_awal'];
      $model->thn_akhir = $_GET['RKLaporanpasienpulang']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionPrintPemeriksaKunjunganRJ()
  {
    $model = new PPInfoKunjunganRJV('searchPemeriksaan');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Jalan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_REQUEST['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printPemeriksaan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintPekerjaanKunjunganRJ()
  {
    $model = new PPInfoKunjunganRJV('searchPekerjaan');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Jalan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_REQUEST['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRJV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRJV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRJV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printPekerjaan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target, $initial = '')
  {
    $format = new MyFormatter();
    $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' sampai dengan ' . $format->formatDateTimeForUser($model->tgl_akhir);

    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('initial' => $initial, 'model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('initial' => $initial, 'model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait                    
      $mpdf = new MyPDF60('', $ukuranKertasPDF);

      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      // $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan,  'periode'=> $periode, 'colspan'=>10),true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 20, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('initial' => $initial, 'model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '-' . date('Y_m_d') . '.pdf', 'I');
    }
  }

  protected function printFunction2($model, $data, $caraPrint, $judulLaporan, $target)
  {
    $format = new MyFormatter();
    $periode = $format->formatDateTimeForUser($model->tglAwal) . ' sampai dengan ' . $format->formatDateTimeForUser($model->tglAkhir);

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
      $mpdf->Output($judulLaporan . '-' . date('Y_m_d') . '.pdf', 'I');
    }
  }

  //        
  //    protected function parserTanggal($tgl){
  //    $tgl = explode(' ', $tgl);
  //    $result = array();
  //    foreach ($tgl as $row){
  //        if (!empty($row)){
  //            $result[] = $row;
  //        }
  //    }
  //    return Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($result[0], 'yyyy-MM-dd'),'medium',null).' '.$result[1];
  //        
  //    }

  /**
   * Mengatur dropdown ruangan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = null;
      if ($model_nama !== '' && $attr == '') {
        $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
      } else if ($model_nama == '' && $attr !== '') {
        $instalasi_id = $_POST["$attr"];
      } else if ($model_nama !== '' && $attr !== '') {
        $instalasi_id = $_POST["$model_nama"]["$attr"];
      }
      $models = null;
      $models = CHtml::listData(RuanganM::getRuanganByInstalasi($instalasi_id), 'ruangan_id', 'ruangan_nama');

      if ($encode) {
        echo CJSON::encode($models);
      } else {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        if (count((array)$models) > 0) {
          foreach ($models as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  public function actionLaporanJumlahPemeriksaanDokter()
  {
    $this->pageTitle = Yii::app()->name . " - Jumlah Pemeriksaan Dokter";
    $model = new PPLaporanJumlahPemeriksaanDokterV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPLaporanJumlahPemeriksaanDokterV'])) {
      $model->attributes = $_GET['PPLaporanJumlahPemeriksaanDokterV'];
      $model->jns_periode = $_GET['PPLaporanJumlahPemeriksaanDokterV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPLaporanJumlahPemeriksaanDokterV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPLaporanJumlahPemeriksaanDokterV']['tgl_akhir']);
      //            $model->bln_awal = $format->formatMonthForDb($_GET['PPLaporanJumlahPemeriksaanDokterV']['bln_awal']);
      //            $model->bln_akhir = $format->formatMonthForDb($_GET['PPLaporanJumlahPemeriksaanDokterV']['bln_akhir']);
      //            $model->thn_awal = $_GET['PPLaporanJumlahPemeriksaanDokterV']['thn_awal'];
      //            $model->thn_akhir = $_GET['PPLaporanJumlahPemeriksaanDokterV']['thn_akhir'];
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

    $this->render($this->pathViewPP . 'jumlahPemeriksaanDokter/admin', array(
      'model' => $model,
    ));
  }

  public function actionPrintLaporanJumlahPemeriksaanDokter()
  {
    $model = new PPLaporanJumlahPemeriksaanDokterV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Dokter';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Dokter';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['PPLaporanJumlahPemeriksaanDokterV'])) {
      $model->attributes = $_REQUEST['PPLaporanJumlahPemeriksaanDokterV'];
      $model->jns_periode = $_GET['PPLaporanJumlahPemeriksaanDokterV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPLaporanJumlahPemeriksaanDokterV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPLaporanJumlahPemeriksaanDokterV']['tgl_akhir']);
      //            $model->bln_awal = $format->formatMonthForDb($_GET['PPLaporanJumlahPemeriksaanDokterV']['bln_awal']);
      //            $model->bln_akhir = $format->formatMonthForDb($_GET['PPLaporanJumlahPemeriksaanDokterV']['bln_akhir']);
      //            $model->thn_awal = $_GET['PPLaporanJumlahPemeriksaanDokterV']['thn_awal'];
      //            $model->thn_akhir = $_GET['PPLaporanJumlahPemeriksaanDokterV']['thn_akhir'];
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
    $target = $this->pathViewPP . 'jumlahPemeriksaanDokter/_print';

    $this->printFunction2($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikJumlahPemeriksaanDokter()
  {
    $this->layout = '//layouts/frameDialog';

    $model = new PPLaporanJumlahPemeriksaanDokterV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Jumlah Pemeriksaan Dokter';
    $data['type'] = $_REQUEST['type'];

    if (isset($_GET['PPLaporanJumlahPemeriksaanDokterV'])) {
      $model->attributes = $_GET['PPLaporanJumlahPemeriksaanDokterV'];
      $model->jns_periode = $_GET['PPLaporanJumlahPemeriksaanDokterV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPLaporanJumlahPemeriksaanDokterV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPLaporanJumlahPemeriksaanDokterV']['tgl_akhir']);
      //            $model->bln_awal = $format->formatMonthForDb($_GET['PPLaporanJumlahPemeriksaanDokterV']['bln_awal']);
      //            $model->bln_akhir = $format->formatMonthForDb($_GET['PPLaporanJumlahPemeriksaanDokterV']['bln_akhir']);
      //            $model->thn_awal = $_GET['PPLaporanJumlahPemeriksaanDokterV']['thn_awal'];
      //            $model->thn_akhir = $_GET['PPLaporanJumlahPemeriksaanDokterV']['thn_akhir'];
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
    $this->render($this->pathViewPP . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  //Laporan Kunjungan Penunjang
  public function actionLaporanKunjunganPenunjang()
  {
    $this->pageTitle = Yii::app()->name . " - Kunjungan Penunjang";
    $model = new PPPasienmasukpenunjangV('search');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'penunjang/adminPenunjang', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanKunjunganUmurPenunjang()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Penunjang Berdasarkan Umur";
    $model = new PPPasienmasukpenunjangV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'penunjang/umurPenunjang', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanKunjunganJkPenunjang()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Penunjang Berdasarkan Jenis Kelamin";
    $model = new PPPasienmasukpenunjangV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'penunjang/jkPenunjang', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanStatusKunjunganPenunjang()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Penunjang Berdasarkan Kedatangan Lama / Baru";
    $model = new PPPasienmasukpenunjangV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'penunjang/statusPenunjang', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanAgamaKunjunganPenunjang()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Penunjang Berdasarkan Agama";
    $model = new PPPasienmasukpenunjangV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'penunjang/agamaPenunjang', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanPekerjaanKunjunganPenunjang()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Penunjang Berdasarkan Pekerjaan";
    $model = new PPPasienmasukpenunjangV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'penunjang/pekerjaanPenunjang', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanStatusPerkawinanKunjunganPenunjang()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Penunjang Berdasarkan Status Perkawinan";
    $model = new PPPasienmasukpenunjangV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'penunjang/statusPerkawinanPenunjang', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanAlamatKunjunganPenunjang()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Penunjang Berdasarkan Alamat";
    $model = new PPPasienmasukpenunjangV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'penunjang/alamatPenunjang', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanKecamatanKunjunganPenunjang()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Penunjang Berdasarkan Kecamatan";
    $model = new PPPasienmasukpenunjangV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'penunjang/kecamatanPenunjang', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanKabKotaKunjunganPenunjang()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Penunjang Berdasarkan Kabupaten / Kota";
    $model = new PPPasienmasukpenunjangV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'penunjang/kabupatenPenunjang', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanCaraMasukKunjunganPenunjang()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Penunjang Berdasarkan Cara Masuk";
    $model = new PPPasienmasukpenunjangV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'penunjang/caraMasukPenunjang', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanRujukanKunjunganPenunjang()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Penunjang Berdasarkan Rujukan";
    $model = new PPPasienmasukpenunjangV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'penunjang/rujukanPenunjang', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanPemeriksaanKunjunganPenunjang()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Penunjang Berdasarkan Pemeriksaan";
    $model = new PPPasienmasukpenunjangV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'penunjang/pemeriksaanPenunjang', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanKetPulangKunjunganPenunjang()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Penunjang Berdasarkan Keterangan Pulang";
    $model = new PPPasienmasukpenunjangV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PPPasienmasukpenunjangV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'penunjang/ketPulangPenunjang', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanPenjaminKunjunganPenunjang()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Penunjang Berdasarkan Penjamin";
    $model = new PPPasienmasukpenunjangV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'penunjang/penjaminPenunjang', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanDokterPemeriksaKunjunganPenunjang()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Penunjang Berdasarkan Dokter Pemeriksa";
    $model = new PPPasienmasukpenunjangV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . 'penunjang/dokterPemeriksaPenunjang', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanUnitPelayananKunjunganPenunjang()
  {
    $model = new PPRuanganM('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->tipe = 'penunjang';

    if (isset($_GET['PPRuanganM'])) {
      $model->attributes = $_GET['PPRuanganM'];
      $model->jns_periode = $_GET['PPRuanganM']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPRuanganM']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPRuanganM']['bln_akhir']);
      $model->thn_awal = $_GET['PPRuanganM']['thn_awal'];
      $model->thn_akhir = $_GET['PPRuanganM']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      $model->tipe = 'penunjang';
    }

    $this->render($this->pathViewPP . 'penunjang/unitPelayananPenunjang', array(
      'model' => $model, 'format' => $format
    ));
  }

  // -- END VIEW LAPORAN --//
  // -- PRINT LAPORAN --//
  public function actionPrintKunjunganPenunjang()
  {
    $model = new PPPasienmasukpenunjangV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Jalan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Penunjang';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_REQUEST['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_REQUEST['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_REQUEST['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintUmurKunjunganPenunjang()
  {
    $model = new PPPasienmasukpenunjangV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan Kunjungan Pasien Penunjang Berdasarkan Umur';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Penunjang Berdasarkan Umur';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_REQUEST['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      //            $model->bulan =DATE_PART('MONTH',$_REQUEST['PPInfoKunjunganRJV']['bulan']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printUmur';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintAgamaKunjunganPenunjang()
  {
    $model = new PPPasienmasukpenunjangV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan Kunjungan Pasien Penunjang Berdasarkan Agama';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Penunjang Berdasarkan Agama';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_REQUEST['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_REQUEST['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      //            $model->bulan =DATE_PART('MONTH',$_REQUEST['PPInfoKunjunganRJV']['bulan']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printAgama';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintAlamatKunjunganPenunjang()
  {
    $model = new PPPasienmasukpenunjangV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan Kunjungan Pasien Penunjang Berdasarkan Alamat';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Penunjang Berdasarkan Alamat';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_REQUEST['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_REQUEST['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      //            $model->bulan =DATE_PART('MONTH',$_REQUEST['PPInfoKunjunganRJV']['bulan']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printAlamat';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintJkKunjunganPenunjang()
  {
    $model = new PPPasienmasukpenunjangV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan Kunjungan Pasien Penunjang Berdasarkan Jenis Kelamin';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Penunjang Berdasarkan Jenis Kelamin';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_REQUEST['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_REQUEST['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      //            $model->bulan =DATE_PART('MONTH',$_REQUEST['PPInfoKunjunganRJV']['bulan']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printJk';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintStatusKunjunganPenunjang()
  {
    $model = new PPPasienmasukpenunjangV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan Kunjungan Pasien Penunjang Berdasarkan Kedatangan Lama / Baru';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Penunjang Berdasarkan Kedatangan Lama / Baru';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_REQUEST['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_REQUEST['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      //            $model->bulan =DATE_PART('MONTH',$_REQUEST['PPInfoKunjunganRJV']['bulan']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printStatus';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintStatusPerkawinanKunjunganPenunjang()
  {
    $model = new PPPasienmasukpenunjangV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan Kunjungan Pasien Penunjang Berdasarkan Status Perkawinan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Penunjang Berdasarkan Status Perkawinan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_REQUEST['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_REQUEST['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      //            $model->bulan =DATE_PART('MONTH',$_REQUEST['PPInfoKunjunganRJV']['bulan']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printStatusPerkawinan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintRujukanKunjunganPenunjang()
  {
    $model = new PPPasienmasukpenunjangV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan Kunjungan Pasien Penunjang Berdasarkan Rujukan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Penunjang Berdasarkan Rujukan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_REQUEST['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_REQUEST['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      //            $model->bulan =DATE_PART('MONTH',$_REQUEST['PPInfoKunjunganRJV']['bulan']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printRujukan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintCaraMasukKunjunganPenunjang()
  {
    $model = new PPPasienmasukpenunjangV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan Kunjungan Pasien Penunjang Berdasarkan Cara Masuk';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Penunjang Berdasarkan Cara Masuk';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_REQUEST['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_REQUEST['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      //            $model->bulan =DATE_PART('MONTH',$_REQUEST['PPInfoKunjunganRJV']['bulan']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printCaraMasuk';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintKetPulangKunjunganPenunjang()
  {
    $model = new PPPasienmasukpenunjangV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan Kunjungan Pasien Penunjang Berdasarkan Keterangan Pulang';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Penunjang Berdasarkan Keterangan Pulang';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_REQUEST['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_REQUEST['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      //            $model->bulan =DATE_PART('MONTH',$_REQUEST['PPInfoKunjunganRJV']['bulan']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printKetPulang';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintKabKotaKunjunganPenunjang()
  {
    $model = new PPPasienmasukpenunjangV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan Kunjungan Pasien Penunjang Berdasarkan Kabupaten / Kota';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Penunjang Berdasarkan Kabupaten / Kota';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_REQUEST['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_REQUEST['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      //            $model->bulan =DATE_PART('MONTH',$_REQUEST['PPInfoKunjunganRJV']['bulan']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printKabupaten';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintKecamatanKunjunganPenunjang()
  {
    $model = new PPPasienmasukpenunjangV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan Kunjungan Pasien Penunjang Berdasarkan Kecamatan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Penunjang Berdasarkan Kecamatan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_REQUEST['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_REQUEST['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      //            $model->bulan =DATE_PART('MONTH',$_REQUEST['PPInfoKunjunganRJV']['bulan']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printKecamatan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintPenjaminKunjunganPenunjang()
  {
    $model = new PPPasienmasukpenunjangV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan Kunjungan Pasien Penunjang Berdasarkan Penjamin';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Penunjang Berdasarkan Penjamin';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_REQUEST['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_REQUEST['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      //            $model->bulan =DATE_PART('MONTH',$_REQUEST['PPInfoKunjunganRJV']['bulan']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printPenjamin';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintPemeriksaanKunjunganPenunjang()
  {
    $model = new PPPasienmasukpenunjangV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan Kunjungan Pasien Penunjang Berdasarkan Pemeriksaan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Penunjang Berdasarkan Pemeriksaan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_REQUEST['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_REQUEST['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      //            $model->bulan =DATE_PART('MONTH',$_REQUEST['PPInfoKunjunganRJV']['bulan']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printPemeriksaan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintDokterPemeriksaKunjunganPenunjang()
  {
    $model = new PPPasienmasukpenunjangV();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->bulan = date('m');
    $judulLaporan = 'Laporan Kunjungan Pasien Penunjang Berdasarkan Dokter Pemeriksa';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Penunjang Berdasarkan Dokter Pemeriksa';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_REQUEST['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_REQUEST['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      //            $model->bulan =DATE_PART('MONTH',$_REQUEST['PPInfoKunjunganRJV']['bulan']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printDokterPemeriksa';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintUnitPelayananKunjunganPenunjang()
  {
    $model = new PPRuanganM();
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->bulan = date('m');
    $model->tipe = 'penunjang';
    $judulLaporan = 'Laporan Kunjungan Pasien Penunjang Berdasarkan Unit Pelayanan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Penunjang Berdasarkan Unit Pelayanan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPRuanganM'])) {
      $model->attributes = $_REQUEST['PPRuanganM'];
      $model->jns_periode = $_REQUEST['PPRuanganM']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPRuanganM']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPRuanganM']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPRuanganM']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPRuanganM']['bln_akhir']);
      $model->thn_awal = $_GET['PPRuanganM']['thn_awal'];
      $model->thn_akhir = $_GET['PPRuanganM']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      $model->tipe = 'penunjang';
      //            $model->bulan =DATE_PART('MONTH',$_REQUEST['PPInfoKunjunganRJV']['bulan']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printUnitPelayanan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  // -- END PRINT LAPORAN -- //
  // -- GRAFIK LAPORAN -- //
  public function actionFrameGrafikPenunjang()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPPasienmasukpenunjangV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Penunjang';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikAgamaPenunjang()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPPasienmasukpenunjangV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Penunjang Berdasarkan Agama';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikAgama', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikAlamatPenunjang()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPPasienmasukpenunjangV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Penunjang Berdasarkan Alamat';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikAlamat', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikCaraMasukPenunjang()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPPasienmasukpenunjangV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Penunjang Berdasarkan Cara Masuk';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikCaraMasuk', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikDokterPemeriksaPenunjang()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPPasienmasukpenunjangV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Penunjang Berdasarkan Dokter Pemeriksa';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikDokterPemeriksa', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikJkPenunjang()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPPasienmasukpenunjangV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Penunjang Berdasarkan Jenis Kelamin';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikJk', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikKabKotaPenunjang()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPPasienmasukpenunjangV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Penunjang Berdasarkan Kabupaten / Kota';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikKabupaten', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikKecamatanPenunjang()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPPasienmasukpenunjangV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Penunjang Berdasarkan Kecamatan';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikKecamatan', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikKetPulangPenunjang()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPPasienmasukpenunjangV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Penunjang Berdasarkan Keterangan Pulang';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikKetPulang', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikPekerjaanPenunjang()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPPasienmasukpenunjangV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Penunjang Berdasarkan Pekerjaan';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikPekerjaan', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikPemeriksaanPenunjang()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPPasienmasukpenunjangV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Penunjang Berdasarkan Pemeriksaan';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikPemeriksaan', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikPenjaminPenunjang()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPPasienmasukpenunjangV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Penunjang Berdasarkan Penjamin';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikPenjamin', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikRujukanPenunjang()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPPasienmasukpenunjangV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Penunjang Berdasarkan Rujukan';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikRujukan', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikStatusPerkawinanPenunjang()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPPasienmasukpenunjangV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Penunjang Berdasarkan Status Perkawinan';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikStatusPerkawinan', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikStatusPenunjang()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPPasienmasukpenunjangV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Penunjang Berdasarkan Kedatangan Lama / Baru';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikStatus', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikUmurPenunjang()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPPasienmasukpenunjangV('search');
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
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Penunjang Berdasarkan Umur';
    $data['type'] = $_GET['type'];

    if (isset($_GET['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->pathViewPP . '_grafikUmur', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikUnitPelayananPenunjang()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPRuanganM('searchGrafikUnitPelayanan');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->tipe = 'penunjang';
    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Penunjang Berdasarkan Unit Pelayanan';
    $data['type'] = $_REQUEST['type'];

    if (isset($_REQUEST['PPRuanganM'])) {
      $model->attributes = $_REQUEST['PPRuanganM'];
      $model->jns_periode = $_REQUEST['PPRuanganM']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPRuanganM']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPRuanganM']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPRuanganM']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPRuanganM']['bln_akhir']);
      $model->thn_awal = $_REQUEST['PPRuanganM']['thn_awal'];
      $model->thn_akhir = $_REQUEST['PPRuanganM']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      $model->tipe = 'penunjang';
    }

    $this->render($this->pathViewPP . '_grafikUnitPelayanan', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionGetDokter()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      if (isset($_GET['term'])) {
        $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      }
      //$criteria->addCondition('ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
      $criteria->order = 'nama_pegawai';
      if (isset($_GET['idPegawai'])) {
        $criteria->addCondition('pegawai_id = ' . $_GET['idPegawai']);
      }
      $models = DokterpegawaiV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * - digunakan untuk masuk ke menu laporan bor
   */
  public function actionBOR()
  {
    $this->pageTitle = Yii::app()->name . " - Bor";
    $model = new RKLaporanindikatorpelayananrsV();
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');


    if (isset($_GET['RKLaporanindikatorpelayananrsV'])) {
      $model->attributes = $_GET['RKLaporanindikatorpelayananrsV'];
      $format = new MyFormatter();
      $model->jns_periode = $_GET['RKLaporanindikatorpelayananrsV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RKLaporanindikatorpelayananrsV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RKLaporanindikatorpelayananrsV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RKLaporanindikatorpelayananrsV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RKLaporanindikatorpelayananrsV']['bln_akhir']);
      $model->thn_awal = $_GET['RKLaporanindikatorpelayananrsV']['thn_awal'];
      $model->thn_akhir = $_GET['RKLaporanindikatorpelayananrsV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->path_view . 'bor.admin', array(
      'model' => $model, 'format' => $format
    ));
  }

  /**
   * - digunakan untuk mencetak prinout laporan bor
   */
  public function actionPrintBOR()
  {
    $model = new RKLaporanindikatorpelayananrsV();
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan BOR';

    //Data Grafik
    $data['title'] = 'Grafik Laporan BOR';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['RKLaporanindikatorpelayananrsV'])) {
      $model->attributes = $_REQUEST['RKLaporanindikatorpelayananrsV'];
      $model->jns_periode = $_REQUEST['RKLaporanindikatorpelayananrsV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RKLaporanindikatorpelayananrsV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RKLaporanindikatorpelayananrsV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['RKLaporanindikatorpelayananrsV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['RKLaporanindikatorpelayananrsV']['bln_akhir']);
      $model->thn_awal = $_GET['RKLaporanindikatorpelayananrsV']['thn_awal'];
      $model->thn_akhir = $_GET['RKLaporanindikatorpelayananrsV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view . 'bor._print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  /**
   * - digunakan untuk menampilkan data grafik
   */
  public function actionFrameGrafikBOR()
  {
    $this->layout = '//layouts/iframe';

    $model = new RKLaporanindikatorpelayananrsV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan BOR';
    $data['type'] = $_GET['type'];

    if (isset($_GET['RKLaporanindikatorpelayananrsV'])) {
      $model->attributes = $_GET['RKLaporanindikatorpelayananrsV'];
      $model->jns_periode = $_GET['RKLaporanindikatorpelayananrsV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RKLaporanindikatorpelayananrsV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RKLaporanindikatorpelayananrsV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RKLaporanindikatorpelayananrsV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RKLaporanindikatorpelayananrsV']['bln_akhir']);
      $model->thn_awal = $_GET['RKLaporanindikatorpelayananrsV']['thn_awal'];
      $model->thn_akhir = $_GET['RKLaporanindikatorpelayananrsV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->path_view . 'bor._grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  /**
   * - digunakan untuk masuk ke menu riwayat surat keterangan pasien
   */
  public function actionRiwayatSuratKeterangan()
  {
    $this->pageTitle = Yii::app()->name . " - Riwayat Surat Keterangan";
    $model = new RKLaporanriwayatsuratketV();
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');


    if (isset($_GET['RKLaporanriwayatsuratketV'])) {
      $model->attributes = $_GET['RKLaporanriwayatsuratketV'];
      $format = new MyFormatter();
      $model->jns_periode = $_GET['RKLaporanriwayatsuratketV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RKLaporanriwayatsuratketV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RKLaporanriwayatsuratketV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RKLaporanriwayatsuratketV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RKLaporanriwayatsuratketV']['bln_akhir']);
      $model->thn_awal = $_GET['RKLaporanriwayatsuratketV']['thn_awal'];
      $model->thn_akhir = $_GET['RKLaporanriwayatsuratketV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->path_view . 'riwayatSuratKeterangan.index', array(
      'model' => $model, 'format' => $format
    ));
  }

  /**
   * - digunakan untuk mencetak prinout riwayat surat keterangan
   */
  public function actionPrintRiwayatSuratKeterangan()
  {
    $model = new RKLaporanriwayatsuratketV();
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Riwayat Surat Keterangan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Riwayat Surat Keterangan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['RKLaporanriwayatsuratketV'])) {
      $model->attributes = $_REQUEST['RKLaporanriwayatsuratketV'];
      $model->jns_periode = $_REQUEST['RKLaporanriwayatsuratketV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RKLaporanriwayatsuratketV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RKLaporanriwayatsuratketV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['RKLaporanriwayatsuratketV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['RKLaporanriwayatsuratketV']['bln_akhir']);
      $model->thn_awal = $_GET['RKLaporanriwayatsuratketV']['thn_awal'];
      $model->thn_akhir = $_GET['RKLaporanriwayatsuratketV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view . 'riwayatSuratKeterangan._print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  /**
   * - digunakan untuk menampilkan data frame grafik riwayat surat keterangan
   */
  public function actionFrameGrafikRiwayatSuratKeterangan()
  {
    $this->layout = '//layouts/iframe';

    $model = new RKLaporanriwayatsuratketV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Riwayat Surat Keterangan';
    $data['type'] = $_GET['type'];

    if (isset($_GET['RKLaporanriwayatsuratketV'])) {
      $model->attributes = $_GET['RKLaporanriwayatsuratketV'];
      $model->jns_periode = $_GET['RKLaporanriwayatsuratketV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RKLaporanriwayatsuratketV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RKLaporanriwayatsuratketV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RKLaporanriwayatsuratketV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RKLaporanriwayatsuratketV']['bln_akhir']);
      $model->thn_awal = $_GET['RKLaporanriwayatsuratketV']['thn_awal'];
      $model->thn_akhir = $_GET['RKLaporanriwayatsuratketV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $this->render($this->path_view . 'riwayatSuratKeterangan._grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionPrintPekerjaanKunjunganPenunjang()
  {
    $judulLaporan = 'Laporan Kunjungan Penunjang Berdasarkan Pekerjaan ';

    //Data Grafik
    $data['title'] = 'Grafik Kunjungan Penunjang Berdasarkan Pekerjaan ';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    $model = new PPPasienmasukpenunjangV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printPekerjaan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintPemeriksaKunjunganPenunjang()
  {
    $judulLaporan = 'Laporan Kunjungan Penunjang Berdasarkan Pemeriksaan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Penunjang Rawat Jalan Berdasarkan Pemeriksaan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    $model = new PPPasienmasukpenunjangV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPPasienmasukpenunjangV'])) {
      $model->attributes = $_GET['PPPasienmasukpenunjangV'];
      $model->jns_periode = $_GET['PPPasienmasukpenunjangV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienmasukpenunjangV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienmasukpenunjangV']['bln_akhir']);
      $model->thn_awal = $_GET['PPPasienmasukpenunjangV']['thn_awal'];
      $model->thn_akhir = $_GET['PPPasienmasukpenunjangV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . '_printPemeriksaan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionAutocompleteDiagnosaNama()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $diagnosa_nama = isset($_GET['diagnosa_nama']) ? $_GET['diagnosa_nama'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(diagnosa_nama)', strtolower($diagnosa_nama), true);
      $criteria->order = 'diagnosa_nama';
      $criteria->limit = 5;

      $models = DiagnosaM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->diagnosa_nama;
        // $returnVal[$i]['value'] = $model->nama_pasien;
      }
      
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionLaporanDiagnosaPasien()
  {
    $controller = Yii::app()->controller->action->id;

    $this->pageTitle = Yii::app()->name . " - Morbiditas";
    $model = new RKLaporanmorbiditasV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['RKLaporanmorbiditasV'])) {
      $model->attributes = $_GET['RKLaporanmorbiditasV'];
      $model->jns_periode = $_GET['RKLaporanmorbiditasV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RKLaporanmorbiditasV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RKLaporanmorbiditasV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RKLaporanmorbiditasV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RKLaporanmorbiditasV']['bln_akhir']);
      $model->thn_awal = $_GET['RKLaporanmorbiditasV']['thn_awal'];
      $model->thn_akhir = $_GET['RKLaporanmorbiditasV']['thn_akhir'];
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
      //$model->tgl_awal = $model->tgl_awal . " 00:00:00";
      //$model->tgl_akhir = $model->tgl_akhir . " 00:00:00";
      $model->instalasi_id = isset($_GET['RKLaporanmorbiditasV']['instalasi_id']) ? $_GET['RKLaporanmorbiditasV']['instalasi_id'] : null;
    }

    $this->render('morbiditas/admin', array(
      'model' => $model, 'format' => $format, 'controller' =>$controller,
    ));
  }
}
