<?php

class LaporanController extends MyAuthController
{
  public $pathViewPP = 'pendaftaranPenjadwalan.views.laporan.';
  public $pathViewRj = 'rawatJalan.views.laporan.';

  // -- Laporan RD --//
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
    $model->instalasi_id = Params::INSTALASI_ID_RD;

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $this->render($this->pathViewPP . 'rawatDarurat/dokterPemeriksaRD', array(
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
    $model->instalasi_id = Params::INSTALASI_ID_RD;

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRDV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRDV']['thn_akhir'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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

    $this->render($this->pathViewPP . 'rawatDarurat/penjaminRD', array(
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
    $model->instalasi_id = Params::INSTALASI_ID_RD;

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $this->render($this->pathViewPP . 'rawatDarurat/ketPulangRD', array(
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
    $model->instalasi_id = Params::INSTALASI_ID_RD;

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $this->render($this->pathViewPP . 'rawatDarurat/pemeriksaanRD', array(
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
    $model->instalasi_id = Params::INSTALASI_ID_RD;

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $this->render($this->pathViewPP . 'rawatDarurat/rujukanRD', array(
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
    $model->instalasi_id = Params::INSTALASI_ID_RD;

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $this->render($this->pathViewPP . 'rawatDarurat/caraMasukRD', array(
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
    $model->instalasi_id = Params::INSTALASI_ID_RD;

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $this->render($this->pathViewPP . 'rawatDarurat/kabupatenRD', array(
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
    $model->instalasi_id = Params::INSTALASI_ID_RD;

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $this->render($this->pathViewPP . 'rawatDarurat/kecamatanRD', array(
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
    $model->instalasi_id = Params::INSTALASI_ID_RD;

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $this->render($this->pathViewPP . 'rawatDarurat/alamatRD', array(
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
    $model->instalasi_id = Params::INSTALASI_ID_RD;

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $this->render($this->pathViewPP . 'rawatDarurat/statusPerkawinanRD', array(
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
    $model->instalasi_id = Params::INSTALASI_ID_RD;

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $this->render($this->pathViewPP . 'rawatDarurat/pekerjaanRD', array(
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
    $model->instalasi_id = Params::INSTALASI_ID_RD;

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $this->render($this->pathViewPP . 'rawatDarurat/agamaRD', array(
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
    $model->instalasi_id = Params::INSTALASI_ID_RD;

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $this->render($this->pathViewPP . 'rawatDarurat/statusRD', array(
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
    $model->instalasi_id = Params::INSTALASI_ID_RD;

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
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
    $model->instalasi_id = Params::INSTALASI_ID_RD;

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $this->render($this->pathViewPP . 'rawatDarurat/jkRD', array(
      'model' => $model, 'format' => $format
    ));
  }

  //-- Akhir Laporan RD--//

  // -- Laporan RJ --//
  public function actionLaporanKunjunganUmurRJ()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Jalan Berdasarkan Umur";
    $model = new PPInfoKunjunganRJV('searchUmur');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->instalasi_id = Params::INSTALASI_ID_RJ;

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
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

    $this->render($this->pathViewPP . 'rawatJalan/umurRJ', array(
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
    $model->instalasi_id = Params::INSTALASI_ID_RJ;

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
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
    $model->instalasi_id = Params::INSTALASI_ID_RJ;

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRJV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
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
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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

    $this->render($this->pathViewPP . 'rawatJalan/kecamatanRJ', array('model' => $model, 'format' => $format));
  }

  public function actionLaporanKabKotaKunjunganRJ()
  {
    //        $tihs->pageTitle = Yii::app()->name."- Laporan Kunjungan Rawat Jalan Berdasarakan Agama";
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

    $this->render($this->pathViewPP . 'rawatJalan/kabupatenRJ', array('model' => $model, 'format' => $format));
  }

  public function actionLaporanCaraMasukKunjunganRJ()
  {
    //        $tihs->pageTitle= Yii::app()->name."- Laporan Kunjungan Rawat Jalan Berdasarakan Cara Masuk";
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

    $this->render($this->pathViewPP . 'rawatJalan/caraMasukRJ', array('model' => $model, 'format' => $format));
  }

  public function actionLaporanRujukanKunjunganRJ()
  {
    $this->pageTitle = Yii::app()->name . "- Laporan Kunjungan Rawat Jalan Berdasarakan Rujukan";
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

    $this->render($this->pathViewPP . 'rawatJalan/rujukanRJ', array('model' => $model, 'format' => $format));
  }

  public function actionLaporanPemeriksaanKunjunganRJ()
  {
    $this->pageTitle = Yii::app()->name . "- Laporan Kunjungan Rawat Jalan Berdasarakan Pemeriksaan";
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

    $this->render($this->pathViewPP . 'rawatJalan/pemeriksaanRJ', array('model' => $model, 'format' => $format));
  }

  public function actionLaporanKetPulangKunjunganRJ()
  {
    $this->pageTitle = Yii::app()->name . "- Laporan Kunjungan Rawat Jalan Berdasarakan Keterangan Pulang";
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

    $this->render($this->pathViewPP . 'rawatJalan/ketPulangRJ', array('model' => $model, 'format' => $format));
  }

  public function actionLaporanPenjaminKunjunganRJ()
  {
    $this->pageTitle = Yii::app()->name . "- Laporan Kunjungan Rawat Jalan Berdasarakan Penjamin Pasien";
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

    $this->render($this->pathViewPP . 'rawatJalan/penjaminRJ', array('model' => $model, 'format' => $format));
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

  public function actionLaporanDokterPemeriksaKunjunganRJ()
  {
    $this->pageTitle = Yii::app()->name . "- Laporan Kunjungan Rawat Jalan Berdasarakan Penjamin Pasien";
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

    $this->render($this->pathViewPP . 'rawatJalan/dokterPemeriksaRJ', array('model' => $model, 'format' => $format));
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
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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

    $this->render($this->pathViewPP . 'rawatJalan/agamaRJ', array(
      'model' => $model, 'format' => $format
    ));
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
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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

    $this->render($this->pathViewPP . 'rawatJalan/pekerjaanRJ', array(
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
    $model->instalasi_id = Params::INSTALASI_ID_RJ;
    $model->tipe = 'rawatjalan';

    if (isset($_GET['PPRuanganM'])) {
      $model->attributes = $_GET['PPRuanganM'];
      $model->jns_periode = $_GET['PPRuanganM']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
      $model->tipe = 'rawatjalan';
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPRuanganM']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPRuanganM']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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

    $this->render($this->pathViewPP . 'rawatJalan/unitPelayananRJ', array(
      'model' => $model, 'format' => $format
    ));
  }
  // -- END VIEW LAPORAN RJ --//


  //-- View laporan RI --//

  public function actionLaporanKunjunganUmurRI()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Inap Berdasarkan Umur";
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

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->instalasi_id = Params::INSTALASI_ID_RI;
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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

    $this->render($this->pathViewPP . 'rawatInap/umurRI', array(
      'model' => $model, 'format' => $format
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
    $model->instalasi_id = Params::INSTALASI_ID_RI;

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->instalasi_id = Params::INSTALASI_ID_RI;
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
    $model->instalasi_id = Params::INSTALASI_ID_RI;

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->instalasi_id = Params::INSTALASI_ID_RI;
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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

    $this->render($this->pathViewPP . 'rawatInap/statusRI', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionLaporanAgamaKunjunganRI()
  {
    $this->pageTitle =  Yii::app()->name . "- Laporan Kunjungan Rawat Inap Berdasarkan Kedatangan Agama";
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

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->instalasi_id = Params::INSTALASI_ID_RI;
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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

    $this->render($this->pathViewPP . 'rawatInap/agamaRI', array('model' => $model, 'format' => $format));
  }

  public function actionLaporanPekerjaanKunjunganRI()
  {
    $this->pageTitle =  Yii::app()->name . "- Laporan Kunjungan Rawat Inap Berdasarkan Pekerjaan";
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

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RI;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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

    $this->render($this->pathViewPP . 'rawatInap/pekerjaanRI', array('model' => $model, 'format' => $format));
  }

  public function actionLaporanStatusPerkawinanKunjunganRI()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Inap Berdasarkan Status Perkawinan";
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

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RI;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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


    $this->render($this->pathViewPP . 'rawatInap/statusPerkawinanRI', array('model' => $model, 'format' => $format));
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
    $model->instalasi_id = Params::INSTALASI_ID_RI;

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RI;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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

    $this->render($this->pathViewPP . 'rawatInap/alamatRI', array('model' => $model, 'format' => $format));
  }

  public function actionLaporanKecamatanKunjunganRI()
  {
    $this->pageTitle =  Yii::app()->name . "- Laporan Kunjungan Rawat Inap Berdasarkan Kecamatan";
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

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RI;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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

    $this->render($this->pathViewPP . 'rawatInap/kecamatanRI', array('model' => $model, 'format' => $format));
  }

  public function actionLaporanKabKotaKunjunganRI()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Inap Berdasarkan Kota Kabupaten";
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

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RI;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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

    $this->render($this->pathViewPP . 'rawatInap/kabupatenRI', array('model' => $model, 'format' => $format));
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
    $model->instalasi_id = Params::INSTALASI_ID_RI;

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
      $model->instalasi_id = Params::INSTALASI_ID_RI;
    }

    $this->render($this->pathViewPP . 'rawatInap/caraMasukRI', array('model' => $model, 'format' => $format));
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
    $model->instalasi_id = Params::INSTALASI_ID_RI;

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RI;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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

    $this->render($this->pathViewPP . 'rawatInap/rujukanRI', array('model' => $model, 'format' => $format));
  }

  public function actionLaporanRMKunjunganRI()
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
    $model->instalasi_id = Params::INSTALASI_ID_RI;

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
      $model->instalasi_id = Params::INSTALASI_ID_RI;
    }

    $this->render($this->pathViewPP . 'rawatInap/rmRI', array('model' => $model, 'format' => $format));
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
    $model->instalasi_id = Params::INSTALASI_ID_RI;

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
      $model->instalasi_id = Params::INSTALASI_ID_RI;
    }

    $this->render($this->pathViewPP . 'rawatInap/kamarRuanganRI', array('model' => $model, 'format' => $format));
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
    $model->instalasi_id = Params::INSTALASI_ID_RI;


    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
      $model->instalasi_id = Params::INSTALASI_ID_RI;
    }

    $this->render($this->pathViewPP . 'rawatInap/ketPulangRI', array('model' => $model, 'format' => $format));
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
    $model->instalasi_id = Params::INSTALASI_ID_RI;

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->instalasi_id = Params::INSTALASI_ID_RI;
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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


    $this->render($this->pathViewPP . 'rawatInap/alasanPulangRI', array('model' => $model, 'format' => $format));
  }

  public function actionLaporanPenjaminKunjunganRI()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kunjungan Rawat Inap Berdasarkan Penjamin Pasien";
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

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RI;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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

    $this->render($this->pathViewPP . 'rawatInap/penjaminRI', array('model' => $model, 'format' => $format));
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
    $model->instalasi_id = Params::INSTALASI_ID_RI;

    if (isset($_GET['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->instalasi_id = Params::INSTALASI_ID_RI;
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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

    $this->render($this->pathViewPP . 'rawatInap/dokterPemeriksaRI', array('model' => $model, 'format' => $format));
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
    $model->instalasi_id = Params::INSTALASI_ID_RI;
    $model->tipe = 'rawatinap';

    if (isset($_GET['PPRuanganM'])) {
      $model->attributes = $_GET['PPRuanganM'];
      $model->jns_periode = $_GET['PPRuanganM']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RI;
      $model->tipe = 'rawatinap';
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPRuanganM']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPRuanganM']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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

    $this->render($this->pathViewPP . 'rawatInap/unitPelayananRI', array('model' => $model, 'format' => $format));
  }

  //-- END View Laporan RI -//


  // -- Laporan RJ --//
  // -- VIEW LAPORAN RJ --// 
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
  // -- END VIEW LAPORAN RJ --//

  // -- PRINT LAPORAN RJ --//
  public function actionPrintKunjunganRJ()
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

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_REQUEST['PPInfoKunjunganRJV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRJV'];
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = '_printKunjunganRJ';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintUmurKunjunganRJ()
  {
    $model = new PPInfoKunjunganRJV('searchUmur');
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

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_REQUEST['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
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
    $target = '_printUmur';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintJkKunjunganRJ()
  {
    $model = new PPInfoKunjunganRJV('searchJk');
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

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_REQUEST['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
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
    $target = '_printJk';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintStatusKunjunganRJ()
  {
    $model = new PPInfoKunjunganRJV('searchStatus');
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

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_REQUEST['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
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
    $target = '_printStatus';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintAgamaKunjunganRJ()
  {
    $model = new PPInfoKunjunganRJV('searchAgama');
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

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_REQUEST['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
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
    $target = '_printAgama';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }
  public function actionPrintPekerjaanKunjunganRJ()
  {
    $model = new PPInfoKunjunganRJV('searchPekerjaan');
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

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_REQUEST['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
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
    $target = '_printPekerjaan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintStatusPerkawinanKunjunganRJ()
  {
    $model = new PPInfoKunjunganRJV('searchStatusPerkawinan');
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

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_REQUEST['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
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
    $target = '_printStatusPerkawinan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintAlamatKunjunganRJ()
  {
    $model = new PPInfoKunjunganRJV('searchAlamat');
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

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_REQUEST['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
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
    $target = '_printAlamat';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintKecamatanKunjunganRJ()
  {
    $model = new PPInfoKunjunganRJV('printKecamatan');
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

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_REQUEST['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
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
    $target = '_printKecamatan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintKabKotaKunjunganRJ()
  {
    $model = new PPInfoKunjunganRJV('printKabKota');
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

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_REQUEST['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
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
    $target = '_printKabupaten';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintCaraMasukKunjunganRJ()
  {
    $model = new PPInfoKunjunganRJV('searchCaraMasuk');
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

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_REQUEST['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
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
    $target = '_printCaraMasuk';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintRujukanKunjunganRJ()
  {
    $model = new PPInfoKunjunganRJV('searchRujukan');
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

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_REQUEST['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
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
    $target = '_printRujukan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
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
    $model->instalasi_id = Params::INSTALASI_ID_RJ;

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_REQUEST['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
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
    $target = '_printPemeriksaan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintKetPulangKunjunganRJ()
  {
    $model = new PPInfoKunjunganRJV('searchKetPulang');
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

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_REQUEST['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
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
    $target = '_printKetPulang';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintPenjaminKunjunganRJ()
  {
    $model = new PPInfoKunjunganRJV('searchPenjamin');
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

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_REQUEST['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
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
    $target = '_printPenjamin';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintDokterPemeriksaKunjunganRJ()
  {
    $model = new PPInfoKunjunganRJV('searchDokterPemeriksa');
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

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_REQUEST['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
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
    $target = '_printDokterPemeriksa';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintUnitPelayananKunjunganRJ()
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
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Jalan';
    $model->instalasi_id = Params::INSTALASI_ID_RJ;
    $model->tipe = 'rawatjalan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");

    if (isset($_REQUEST['PPRuanganM'])) {
      $model->attributes = $_GET['PPRuanganM'];
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
      $model->tipe = 'rawatjalan';
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = '_printUnitPelayanan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
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
    $target = '_printPetugas';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  // -- END LAPORAN RJ --//

  // -- GRAFIK LAPORAN RJ --//
  public function actionFrameGrafikRJ()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRJV('search');
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $format = new MyFormatter();
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikAgamaRJ()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPInfoKunjunganRJV('search');
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Agama';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $format = new MyFormatter();
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
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
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Alamat';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $format = new MyFormatter();
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
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
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Cara Masuk';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $format = new MyFormatter();
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
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
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Dokter Pemeriksa';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $format = new MyFormatter();
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
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
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Jenis Kelamin';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $format = new MyFormatter();
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
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
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Kabupaten / Kota';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $format = new MyFormatter();
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
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
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Kecamatan';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $format = new MyFormatter();
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
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
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Keterangan Pulang';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $format = new MyFormatter();
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
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
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Pekerjaan';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $format = new MyFormatter();
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
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
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Pemeriksaan';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $format = new MyFormatter();
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
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
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Penjamin';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $format = new MyFormatter();
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
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
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Rujukan';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $format = new MyFormatter();
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
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
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Status Perkawinan';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $format = new MyFormatter();
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
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
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Kedatangan Lama / Baru';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $format = new MyFormatter();
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
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
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Umur';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRJV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRJV'];
      $format = new MyFormatter();
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRJV']['tgl_akhir']);
    }

    $this->render($this->pathViewPP . '_grafikUmur', array(
      'model' => $model,
      'data' => $data,
    ));
  }
  public function actionFrameGrafikUnitPelayananRJ()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPRuanganM('search');
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->instalasi_id = Params::INSTALASI_ID_RJ;
    $model->tipe = 'rawatjalan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Jalan Berdasarkan Unit Pelayanan';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPRuanganM'])) {
      $model->attributes = $_GET['PPRuanganM'];
      $format = new MyFormatter();
      $model->instalasi_id = Params::INSTALASI_ID_RJ;
      $model->tipe = 'rawatjalan';
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_akhir']);
    }

    $this->render($this->pathViewPP . '_grafikUnitPelayanan', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  // -- END GRAFIK LAPORAN RJ --//
  // -- END LAPORAN RJ --// 

  // -- LAPORAN RD --//
  // -- VIEW LAPORAN RD --//

  public function actionLaporanUnitPelayananKunjunganRD()
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
    $model->instalasi_id = Params::INSTALASI_ID_RD;

    if (isset($_GET['PPRuanganM'])) {
      $model->attributes = $_GET['PPRuanganM'];
      $model->jns_periode = $_GET['PPRuanganM']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPRuanganM']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPRuanganM']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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

    $this->render($this->pathViewPP . 'rawatDarurat/unitPelayananRD', array(
      'model' => $model, 'format' => $format
    ));
  }

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
    $model->instalasi_id = Params::INSTALASI_ID_RD;

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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

    $this->render('rawatDarurat/adminRD', array(
      'model' => $model, 'format' => $format
    ));
  }

  // -- END VIEW LAPORAN RD --//

  // -- PRINT LAPORAN RD --//

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
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Darurat';
    $model->instalasi_id = Params::INSTALASI_ID_RD;
    $model->tipe = 'rawatdarurat';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPRuanganM'])) {
      $model->attributes = $_GET['PPRuanganM'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->tipe = 'rawatdarurat';
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = '_printUnitPelayanan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintKunjunganRD()
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
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
    $target = '_printRD';

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

    if (isset($_REQUEST['PPInfoKunjunganRDV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRDV'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
    $target = '_printUmur';

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

    if (isset($_REQUEST['PPInfoKunjunganRDV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRDV'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
    $target = '_printJk';

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

    if (isset($_REQUEST['PPInfoKunjunganRDV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRDV'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
    $target = '_printStatus';

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

    if (isset($_REQUEST['PPInfoKunjunganRDV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRDV'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
    $target = '_printAgama';

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

    if (isset($_REQUEST['PPInfoKunjunganRDV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRDV'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
    $target = '_printPekerjaan';

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

    if (isset($_REQUEST['PPInfoKunjunganRDV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRDV'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
    $target = '_printStatusPerkawinan';

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

    if (isset($_REQUEST['PPInfoKunjunganRDV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRDV'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
    $target = '_printAlamat';

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

    if (isset($_REQUEST['PPInfoKunjunganRDV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRDV'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
    $target = '_printKecamatan';

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

    if (isset($_REQUEST['PPInfoKunjunganRDV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRDV'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
    $target = '_printKabupaten';

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

    if (isset($_REQUEST['PPInfoKunjunganRDV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRDV'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
    $target = '_printCaraMasuk';

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

    if (isset($_REQUEST['PPInfoKunjunganRDV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRDV'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
    $target = '_printRujukan';

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

    if (isset($_REQUEST['PPInfoKunjunganRDV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRDV'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
    $target = '_printPemeriksaan';

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

    if (isset($_REQUEST['PPInfoKunjunganRDV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRDV'];
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRDV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
    $target = '_printKetPulang';

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

    if (isset($_REQUEST['PPInfoKunjunganRDV'])) {
      $model->attributes = $_REQUEST['PPInfoKunjunganRDV'];
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRDV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
    $target = '_printPenjamin';

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
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->jns_periode = $_REQUEST['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPInfoKunjunganRDV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
    $target = '_printDokterPemeriksa';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  // -- END PRINT LAPORAN RD --//

  //-- GRAFIK LAPORAN RD --//
  public function actionFrameGrafikRD()
  {
    $this->layout = '//layouts/iframe';
    $model = new PPInfoKunjunganRDV('searchGrafik');
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
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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

    $this->render($this->pathViewPP . '_grafikAgama', array(
      'model' => $model,
      'data' => $data,
    ));
  }
  public function actionFrameGrafikAlamatRD()
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = new PPInfoKunjunganRDV('search');
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
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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

    $this->render($this->pathViewPP . '_grafikAlamat', array(
      'model' => $model,
      'data' => $data,
    ));
  }
  public function actionFrameGrafikCaraMasukRD()
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = new PPInfoKunjunganRDV('search');
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
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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

    $this->render($this->pathViewPP . '_grafikCaraMasuk', array(
      'model' => $model,
      'data' => $data,
    ));
  }
  public function actionFrameGrafikDokterPemeriksaRD()
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = new PPInfoKunjunganRDV('search');
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
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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

    $this->render($this->pathViewPP . '_grafikDokterPemeriksa', array(
      'model' => $model,
      'data' => $data,
    ));
  }
  public function actionFrameGrafikJkRD()
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = new PPInfoKunjunganRDV('search');
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
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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

    $this->render($this->pathViewPP . '_grafikJk', array(
      'model' => $model,
      'data' => $data,
    ));
  }
  public function actionFrameGrafikKabKotaRD()
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = new PPInfoKunjunganRDV('search');
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
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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

    $this->render($this->pathViewPP . '_grafikKabupaten', array(
      'model' => $model,
      'data' => $data,
    ));
  }
  public function actionFrameGrafikKecamatanRD()
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = new PPInfoKunjunganRDV('search');
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
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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

    $this->render($this->pathViewPP . '_grafikKecamatan', array(
      'model' => $model,
      'data' => $data,
    ));
  }
  public function actionFrameGrafikKetPulangRD()
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = new PPInfoKunjunganRDV('search');
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
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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

    $this->render($this->pathViewPP . '_grafikKetPulang', array(
      'model' => $model,
      'data' => $data,
    ));
  }
  public function actionFrameGrafikPekerjaanRD()
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = new PPInfoKunjunganRDV('search');
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
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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

    $this->render($this->pathViewPP . '_grafikPekerjaan', array(
      'model' => $model,
      'data' => $data,
    ));
  }
  public function actionFrameGrafikPemeriksaanRD()
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = new PPInfoKunjunganRDV('search');
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
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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

    $this->render($this->pathViewPP . '_grafikPemeriksaan', array(
      'model' => $model,
      'data' => $data,
    ));
  }
  public function actionFrameGrafikPenjaminRD()
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = new PPInfoKunjunganRDV('search');
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
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $format = new MyFormatter();
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $format = new MyFormatter();
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRDV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRDV'];
      $format = new MyFormatter();
      $model->jns_periode = $_GET['PPInfoKunjunganRDV']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRDV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRDV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->instalasi_id = Params::INSTALASI_ID_RD;
    $model->tipe = 'rawatdarurat';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Darurat Berdasarkan Unit Pelayanan';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPRuanganM'])) {
      $model->attributes = $_GET['PPRuanganM'];
      $format = new MyFormatter();
      $model->jns_periode = $_GET['PPRuanganM']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RD;
      $model->tipe = 'rawatdarurat';
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPRuanganM']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPRuanganM']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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

    $this->render($this->pathViewPP . '_grafikUnitPelayanan', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  // -- END GRAFIK LAPORAN RD --//
  // -- END LAPORAN RD --//

  // -- LAPORAN RI --//
  // -- VIEW LAPORAN RI --//
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
    $model->instalasi_id = Params::INSTALASI_ID_RI;

    if (isset($_GET['PPInfoKunjunganRIV'])) {
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }


    $this->render('rawatInap/adminRI', array(
      'model' => $model, 'format' => $format
    ));
  }
  // -- END VIEW LAPORAN RI --//

  //-- PRINT LAPORAN RI --//
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
    $model->instalasi_id = Params::INSTALASI_ID_RI;
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Inap';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->instalasi_id = Params::INSTALASI_ID_RI;
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = '_printRI';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  // -- START LAPORAN PEMERIKASAAN RI --//    
  public function actionLaporanPemeriksaanKunjunganRI()
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

    if (isset($_GET['PPInfoKunjunganRIV'])) {
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $this->render('rawatInap/pemeriksaanRI', array(
      'model' => $model, 'format' => $format
    ));
  }
  // -- END LAPORAN PEMERIKASAAN RI --//

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
    $model->instalasi_id = Params::INSTALASI_ID_RI;
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Inap';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->instalasi_id = Params::INSTALASI_ID_RI;
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = '_printUmur';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
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
    $model->instalasi_id = Params::INSTALASI_ID_RI;
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Inap';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPInfoKunjunganRIV'])) {
      $model->attributes = $_GET['PPInfoKunjunganRIV'];
      $model->instalasi_id = Params::INSTALASI_ID_RI;
      $model->jns_periode = $_GET['PPInfoKunjunganRIV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInfoKunjunganRIV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPInfoKunjunganRIV']['bln_akhir']);
      $model->thn_awal = $_GET['PPInfoKunjunganRIV']['thn_awal'];
      $model->thn_akhir = $_GET['PPInfoKunjunganRIV']['thn_akhir'];
      $model->instalasi_id = Params::INSTALASI_ID_RI;
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
    $target = '_printJk';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = '_printStatus';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = '_printAgama';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = '_printPekerjaan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = '_printStatusPerkawinan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = '_printAlamat';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintKecamatanKunjunganRI()
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = '_printKecamatan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = '_printKabupaten';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = '_printCaraMasuk';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = '_printRujukan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintRMKunjunganRI()
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = '_printrmRI';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintKamarRuanganKunjunganRI()
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = '_printKamarRuanganRI';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = '_printAlasanPulang';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = '_printPemeriksaan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionPrintKetPulangKunjunganRI()
  {
    $model = new PPInfoKunjunganRIV('searchKetPulang');
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
    $initial = 'RI';

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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = '_printKetPulang';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = '_printPenjamin';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = '_printDokterPemeriksa';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
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
    $model->instalasi_id = Params::INSTALASI_ID_RI;
    $model->tipe = 'rawatinap';
    $judulLaporan = 'Laporan Kunjungan Pasien Rawat Inap';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPRuanganM'])) {
      $model->attributes = $_GET['PPRuanganM'];
      $model->jns_periode = $_GET['PPRuanganM']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RI;
      $model->tipe = 'rawatinap';
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = '_printUnitPelayanan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  // -- END PRINT LAPORAN RI --//

  // -- GRAFIK LAPORAN RI --//
  public function actionFrameGrafikRI()
  {
    $this->layout = '//layouts/iframe';
    $model = new PPInfoKunjunganRIV('searchGrafik');
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

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRIV'])) {
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
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
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->instalasi_id = Params::INSTALASI_ID_RI;

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Alasan Pulang';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRIV'])) {
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
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
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->instalasi_id = Params::INSTALASI_ID_RI;

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Agama';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRIV'])) {
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
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
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->instalasi_id = Params::INSTALASI_ID_RI;

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Alamat';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRIV'])) {
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
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
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->instalasi_id = Params::INSTALASI_ID_RI;

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Cara Masuk';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRIV'])) {
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
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
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->instalasi_id = Params::INSTALASI_ID_RI;

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Dokter Pemeriksa';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRIV'])) {
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
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
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->instalasi_id = Params::INSTALASI_ID_RI;

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Jenis Kelamin';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRIV'])) {
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
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
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->instalasi_id = Params::INSTALASI_ID_RI;

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Kabupaten / Kota';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRIV'])) {
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
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
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->instalasi_id = Params::INSTALASI_ID_RI;

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Kecamatan';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRIV'])) {
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
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
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->instalasi_id = Params::INSTALASI_ID_RI;

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Keterangan Pulang';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRIV'])) {
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
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
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->instalasi_id = Params::INSTALASI_ID_RI;

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Pekerjaan';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRIV'])) {
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
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
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->instalasi_id = Params::INSTALASI_ID_RI;

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Pemeriksaan';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRIV'])) {
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
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
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->instalasi_id = Params::INSTALASI_ID_RI;

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Penjamin';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRIV'])) {
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
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
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->instalasi_id = Params::INSTALASI_ID_RI;

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Rujukan';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRIV'])) {
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
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
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->instalasi_id = Params::INSTALASI_ID_RI;

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Status Perkawinan';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRIV'])) {
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
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
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->instalasi_id = Params::INSTALASI_ID_RI;

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Kedatangan Lama / Baru';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRIV'])) {
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
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
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->instalasi_id = Params::INSTALASI_ID_RI;

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Umur';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRIV'])) {
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
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
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->instalasi_id = Params::INSTALASI_ID_RI;
    $model->tipe = 'rawatinap';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Unit Pelayanan';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPRuanganM'])) {
      $model->attributes = $_GET['PPRuanganM'];
      $model->jns_periode = $_GET['PPRuanganM']['jns_periode'];
      $model->instalasi_id = Params::INSTALASI_ID_RI;
      $model->tipe = 'rawatinap';
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $this->render($this->pathViewPP . '_grafikUnitPelayanan', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionFrameGrafikRMRI()
  {
    $this->layout = '//layouts/iframe';

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

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Rekam Medik';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRIV'])) {
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
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
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->instalasi_id = Params::INSTALASI_ID_RI;

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Pasien Rawat Inap Berdasarkan Kamar Ruangan';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPInfoKunjunganRIV'])) {
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $this->render($this->pathViewPP . '_grafikKamarRuanganRI', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  // -- END GRAFIK LAPORAN RI --//

  // -- END LAPORAN RI --//
  public function actionLaporanBukuRegister()
  {
    $this->pageTitle = Yii::app()->name . " - Buku Register";
    $format = new MyFormatter();
    $model = new PPBukuregisterpasienV('searchTableLaporan');
    $model->unsetAttributes();
    // $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    /*  $model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');*/

    if (isset($_GET['PPBukuregisterpasienV'])) {
      $model->attributes = $_GET['PPBukuregisterpasienV'];
      //$model->jns_periode = $_GET['PPBukuregisterpasienV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPBukuregisterpasienV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPBukuregisterpasienV']['tgl_akhir']);
      $model->pegawai_id = isset($_GET['PPBukuregisterpasienV']['pegawai_id']) ? $_GET['PPBukuregisterpasienV']['pegawai_id'] : null;
      /*$model->bln_awal = $format->formatMonthForDb($_GET['PPBukuregisterpasienV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['PPBukuregisterpasienV']['bln_akhir']);
            $model->thn_awal = $_GET['PPBukuregisterpasienV']['thn_awal'];
            $model->thn_akhir = $_GET['PPBukuregisterpasienV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }*/
//      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
//      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }
    $this->render('bukuRegister/adminBukuRegister', array(
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

    if (isset($_REQUEST['PPBukuregisterpasienV'])) {
      $model->attributes = $_REQUEST['PPBukuregisterpasienV'];
      //$model->jns_periode = $_REQUEST['PPBukuregisterpasienV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPBukuregisterpasienV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPBukuregisterpasienV']['tgl_akhir']);
      $model->pegawai_id = isset($_GET['PPBukuregisterpasienV']['pegawai_id']) ? $_GET['PPBukuregisterpasienV']['pegawai_id'] : null;
      /*$model->bln_awal = $format->formatMonthForDb($_REQUEST['PPBukuregisterpasienV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPBukuregisterpasienV']['bln_akhir']);
            $model->thn_awal = $_GET['PPBukuregisterpasienV']['thn_awal'];
            $model->thn_akhir = $_GET['PPBukuregisterpasienV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }*/
//      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
//      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'bukuRegister/_printBukuRegister';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikBukuRegister()
  {
    $this->layout = '//layouts/iframe';
    $model = new PPBukuregisterpasienV('search');
    $format = new MyFormatter();
    // $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    /*$model->bln_awal = date('Y-m', strtotime('first day of january'));
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');*/

    //Data Grafik
    $data['title'] = 'Grafik Laporan Grafik Buku Register';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPBukuregisterpasienV'])) {
      $model->attributes = $_GET['PPBukuregisterpasienV'];
      //$model->jns_periode = $_REQUEST['PPBukuregisterpasienV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPBukuregisterpasienV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPBukuregisterpasienV']['tgl_akhir']);
      $model->pegawai_id = isset($_GET['PPBukuregisterpasienV']['pegawai_id']) ? $_GET['PPBukuregisterpasienV']['pegawai_id'] : null;
      /* $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPBukuregisterpasienV']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPBukuregisterpasienV']['bln_akhir']);
            $model->thn_awal = $_GET['PPBukuregisterpasienV']['thn_awal'];
            $model->thn_akhir = $_GET['PPBukuregisterpasienV']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }*/
//      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
//      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanBatalPeriksa()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Batal Periksa";
    $model = new PPPasienbatalperiksa('searchTableLaporan');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

   

    if (isset($_GET['PPPasienbatalperiksa'])) {
      $model->attributes = $_GET['PPPasienbatalperiksa'];
      $model->jns_periode = $_GET['PPPasienbatalperiksa']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienbatalperiksa']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienbatalperiksa']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPPasienbatalperiksa']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPPasienbatalperiksa']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      // $create = array();
      // $create =($_GET['PPPasienbatalperiksa']['create_loginpemakai_id']);
      // $model->create_loginpemakai_id = $create;

      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
    $this->render('batalPeriksa/adminBatalPeriksa', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintBatalPeriksa()
  {
    $model = new PPPasienbatalperiksa('searchPrint');
    $judulLaporan = 'Laporan Pasien Batal Periksa';
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
    $data['title'] = 'Grafik Laporan Pasien Batal Periksa';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);
    if (isset($_REQUEST['PPPasienbatalperiksa'])) {
      $model->attributes = $_REQUEST['PPPasienbatalperiksa'];
      $model->jns_periode = $_REQUEST['PPPasienbatalperiksa']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPPasienbatalperiksa']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPPasienbatalperiksa']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['PPPasienbatalperiksa']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['PPPasienbatalperiksa']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
    $target = 'batalPeriksa/_printBatalPeriksa';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikBatalPeriksa()
  {
    $this->layout = '//layouts/iframe';
    $model = new PPPasienbatalperiksa('search');
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Pasien Batal Periksa';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPPasienbatalperiksa'])) {
      $model->attributes = $_GET['PPPasienbatalperiksa'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPasienbatalperiksa']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPasienbatalperiksa']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporan10Besar()
  {
    $this->pageTitle = Yii::app()->name . " - 10 Besar Penyakit";
    $model = new PPLaporan10besarpenyakit('searchTableLaporan');
    $format = new MyFormatter();
    //$model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    //  $model->bln_awal = date('Y-m');
    //  $model->bln_akhir = date('Y-m');
    //  $model->thn_awal = date('Y');
    // $model->thn_akhir = date('Y');
    $model->jumlahTampil = 10;
    if (isset($_GET['PPLaporan10besarpenyakit'])) {
      $model->attributes = $_GET['PPLaporan10besarpenyakit'];
      //  $model->jns_periode = $_GET['PPLaporan10besarpenyakit']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPLaporan10besarpenyakit']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPLaporan10besarpenyakit']['tgl_akhir']);
      //  $model->bln_awal = $format->formatMonthForDb($_GET['PPLaporan10besarpenyakit']['bln_awal']);
      //  $model->bln_akhir = $format->formatMonthForDb($_GET['PPLaporan10besarpenyakit']['bln_akhir']);
      //  $model->thn_awal = $_GET['PPLaporan10besarpenyakit']['thn_awal'];
      //  $model->thn_akhir = $_GET['PPLaporan10besarpenyakit']['thn_akhir'];
      //  $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
      //  $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
      //  switch($model->jns_periode){
      //     case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
      //    case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
      //     default : null;
      // }
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
      $model->jumlahTampil = $_GET['PPLaporan10besarpenyakit']['jumlahTampil'];
      $model->instalasi_id = !empty($_GET['PPLaporan10besarpenyakit']['instalasi_id']) ? $_GET['PPLaporan10besarpenyakit']['instalasi_id'] : null;
    }
    $this->render('10Besar/admin10BesarPenyakit', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrint10BesarPenyakit()
  {
    $model = new PPLaporan10besarpenyakit('searchPrint');
    $format = new MyFormatter();
    // $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    // $model->bln_awal = date('Y-m');
    // $model->bln_akhir = date('Y-m');
    // $model->thn_awal = date('Y');
    //  $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan 10 Besar Penyakit';

    //Data Grafik
    $data['title'] = 'Grafik Laporan 10 Besar Penyakit';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPLaporan10besarpenyakit'])) {
      $model->attributes = $_REQUEST['PPLaporan10besarpenyakit'];
      //  $model->jns_periode = $_GET['PPLaporan10besarpenyakit']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPLaporan10besarpenyakit']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPLaporan10besarpenyakit']['tgl_akhir']);
      /*   $model->bln_awal = $format->formatMonthForDb($_GET['PPLaporan10besarpenyakit']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['PPLaporan10besarpenyakit']['bln_akhir']);
            $model->thn_awal = $_GET['PPLaporan10besarpenyakit']['thn_awal'];
            $model->thn_akhir = $_GET['PPLaporan10besarpenyakit']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->jumlahTampil = $_GET['PPLaporan10besarpenyakit']['jumlahTampil'];*/
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
      $model->jumlahTampil = $_GET['PPLaporan10besarpenyakit']['jumlahTampil'];
      $model->instalasi_id = !empty($_GET['PPLaporan10besarpenyakit']['instalasi_id']) ? $_GET['PPLaporan10besarpenyakit']['instalasi_id'] : null;
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = '10Besar/_print10BesarPenyakit';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafik10BesarPenyakit()
  {
    $this->layout = '//layouts/iframe';
    $model = new PPLaporan10besarpenyakit('searchGrafik');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    /* $model->bln_awal = date('Y-m');
        $model->bln_akhir = date('Y-m');
        $model->thn_awal = date('Y');
        $model->thn_akhir = date('Y');*/

    //Data Grafik
    $data['title'] = 'Grafik Laporan 10 Besar Penyakit';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPLaporan10besarpenyakit'])) {
      $model->attributes = $_GET['PPLaporan10besarpenyakit'];
      // $model->jns_periode = $_GET['PPLaporan10besarpenyakit']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPLaporan10besarpenyakit']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPLaporan10besarpenyakit']['tgl_akhir']);
      /* $model->bln_awal = $format->formatMonthForDb($_GET['PPLaporan10besarpenyakit']['bln_awal']);
            $model->bln_akhir = $format->formatMonthForDb($_GET['PPLaporan10besarpenyakit']['bln_akhir']);
            $model->thn_awal = $_GET['PPLaporan10besarpenyakit']['thn_awal'];
            $model->thn_akhir = $_GET['PPLaporan10besarpenyakit']['thn_akhir'];
            $bln_akhir = $model->bln_akhir."-".date("t",strtotime($model->bln_akhir));
            $thn_akhir = $model->thn_akhir."-".date("m-t",strtotime($model->thn_akhir."-12"));
            switch($model->jns_periode){
                case 'bulan' : $model->tgl_awal = $model->bln_awal."-01"; $model->tgl_akhir = $bln_akhir; break;
                case 'tahun' : $model->tgl_awal = $model->thn_awal."-01-01"; $model->tgl_akhir = $thn_akhir; break;
                default : null;
            }
            $model->jumlahTampil = $_GET['PPLaporan10besarpenyakit']['jumlahTampil'];*/
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
      $model->jumlahTampil = $_GET['PPLaporan10besarpenyakit']['jumlahTampil'];
      $model->instalasi_id = !empty($_GET['PPLaporan10besarpenyakit']['instalasi_id']) ? $_GET['PPLaporan10besarpenyakit']['instalasi_id'] : null;
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanKarcis()
  {
    $this->pageTitle = Yii::app()->name . " - Karcis Pasien";
    $model = new PPLaporankarcispasien('searchTableLaporan');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['PPLaporankarcispasien'])) {
      // echo '<pre>';var_dump($_GET);die;
      $model->attributes = $_GET['PPLaporankarcispasien'];
      $model->spesialis_id = isset($_GET['PPLaporankarcispasien']['spesialis_id']) ? $_GET['PPLaporankarcispasien']['spesialis_id'] : null;
      $model->jns_periode = $_GET['PPLaporankarcispasien']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPLaporankarcispasien']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPLaporankarcispasien']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPLaporankarcispasien']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPLaporankarcispasien']['bln_akhir']);
      $model->thn_awal = $_GET['PPLaporankarcispasien']['thn_awal'];
      $model->thn_akhir = $_GET['PPLaporankarcispasien']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));

      // $create = array();
      // $create = (isset($_GET['PPLaporankarcispasien']['create_loginpemakai_id']));
      // $model->create_loginpemakai_id = $create;

      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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

    if(Yii::app()->request->isAjaxRequest) {
      if(isset($_GET['ajax']) && $_GET['ajax'] == 'PPInfoKunjungan-v') {
        $this->renderPartial('karcis/_tableKarcis', array('model' => $model));
        Yii::app()->end();
      }
    }

    $this->render('karcis/adminKarcis', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintLaporanKarcis()
  {
    $model = new PPLaporankarcispasien('searchPrint');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Karcis Pasien';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Karcis Pasien';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPLaporankarcispasien'])) {
      $model->attributes = $_REQUEST['PPLaporankarcispasien'];
      $model->jns_periode = $_GET['PPLaporankarcispasien']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPLaporankarcispasien']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPLaporankarcispasien']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPLaporankarcispasien']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPLaporankarcispasien']['bln_akhir']);
      $model->thn_awal = $_GET['PPLaporankarcispasien']['thn_awal'];
      $model->thn_akhir = $_GET['PPLaporankarcispasien']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
    $target = 'karcis/_printLaporanKarcis';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameLaporanKarcis()
  {
    $this->layout = '//layouts/iframe';
    $model = new PPLaporankarcispasien('searchGrafik');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m');
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Karcis Pasien';
    $data['type'] = $_GET['type'];
    if (isset($_GET['PPLaporankarcispasien'])) {
      $model->attributes = $_GET['PPLaporankarcispasien'];
      $model->jns_periode = $_GET['PPLaporankarcispasien']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPLaporankarcispasien']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPLaporankarcispasien']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['PPLaporankarcispasien']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['PPLaporankarcispasien']['bln_akhir']);
      $model->thn_awal = $_GET['PPLaporankarcispasien']['thn_awal'];
      $model->thn_akhir = $_GET['PPLaporankarcispasien']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
      $model->carabayar_id = $_GET['PPLaporankunjunganrs']['carabayar_id'];
      
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
      $model->pilihanx = isset($_GET['PPLaporankunjunganrs']['pilihanx']) ? $_GET['PPLaporankunjunganrs']['pilihanx'] : null;
            
    }

    if (Yii::app()->request->isAjaxRequest){
        if (isset($_GET['ajax'])){
            $ajax = $_GET['ajax'];
            if ($ajax == 'tableLaporan')
                echo $this->renderPartial('kunjunganRS/_tableKunjunganRS', array(
                  'model' => $model, 'format' => $format
                ), true);
            exit;
        }
    }else{    
        $this->render('kunjunganRS/adminKunjunganRS', array(
          'model' => $model, 'format' => $format
        ));
    }
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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
      $model->pilihanx = isset($_GET['PPLaporankunjunganrs']['pilihanx']) ? $_GET['PPLaporankunjunganrs']['pilihanx'] : null;
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'kunjunganRS/_printKunjunganRS';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionGetRuanganForCheckBox($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = $_POST["$namaModel"]['instalasi_id'];
      if ($encode) {
        echo CJSON::encode($ruangan);
      } else {
        if (empty($instalasi_id)) {
          $ruangan = RuanganM::model()->findAll('instalasi_id=9999 AND ruangan_aktif = true ORDER BY ruangan_nama ASC');
        } else {
          $ruangan = RuanganM::model()->findAll('instalasi_id=' . $instalasi_id . ' AND ruangan_aktif = true ORDER BY ruangan_nama ASC');
        }
        $ruangan = CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama');
        echo CHtml::hiddenField('' . $namaModel . '[ruangan_id]');
        $i = 0;
        if (count((array)$ruangan) > 0) {
          echo "<div style='margin-left:0px;'>" . CHtml::checkBox('checkAllRuangan', true, array(
            'onkeypress' => "return $(this).focusNextInputField(event)",
            'class' => 'checkbox-column', 'onclick' => 'checkAll()', 'checked' => 'checked'
          )) . "Pilih Semua";
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

  public function actionFrameGrafikKunjunganRS()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPLaporankunjunganrs('searchGrafik');
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
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

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
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
      $model->pilihanx = isset($_GET['PPLaporankunjunganrs']['pilihanx']) ? $_GET['PPLaporankunjunganrs']['pilihanx'] : null;
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  // protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target)
  // {
  //   $format = new MyFormatter();
  //   //        $periode = $this->parserTanggal($model->tgl_awal).' s/d '.$this->parserTanggal($model->tgl_akhir);
  //   $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
  //   if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
  //     $this->layout = '//layouts/printWindows';
  //     $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
  //   } else if ($caraPrint == 'EXCEL') {
  //     $this->layout = '//layouts/printExcel';
  //     $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
  //   } else if ($_REQUEST['caraPrint'] == 'PDF') {
  //     $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
  //     $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait            
  //     $mpdf = new MyPDF60('', $ukuranKertasPDF);
  //     ////$mpdf->useOddEven = 2;  

  //     // $stylesheet1 = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
  //     // $mpdf->WriteHTML($stylesheet1, 1);
  //     // $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
  //     // $mpdf->WriteHTML($stylesheet, 1);
  //     //$mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan,  'periode'=> $periode, 'colspan'=>10),true));
  //     $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 25, 15, 15);
  //     $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
  //     $mpdf->Output($judulLaporan . '-' . date('Y/m/d') . '.pdf', 'I');
  //   }
  // }

  protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target, $tab = 'rekap')
  {
    $format = new MyFormatter();
    $periode = $format->formatDateTimeForUser(date('Y-m-d H:i:s', strtotime($model->tgl_awal))) . ' s/d ' . $format->formatDateTimeForUser(date('Y-m-d H:i:s', strtotime($model->tgl_akhir)));
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


  public function actionLaporanKunjunganDokter()
  {
    $model = new PPLaporankunjunganbydokterV('search');
    $model->tgl_awal = date('d M Y') . ' 00:00:00';
    $model->tgl_akhir = date('Y-m-d');
    $format = new MyFormatter();

    if (isset($_GET['PPLaporankunjunganbydokterV'])) {
      $model->attributes = $_GET['PPLaporankunjunganbydokterV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPLaporankunjunganbydokterV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPLaporankunjunganbydokterV']['tgl_akhir']);
    }

    $this->render('kunjunganDokter/adminKunjunganDokter', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintLaporanKunjunganDokter()
  {
    $model = new PPLaporankunjunganbydokterV('search');
    $judulLaporan = 'Laporan Kunjungan Dokter';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Dokter';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPLaporankunjunganbydokterV'])) {
      $model->attributes = $_REQUEST['PPLaporankunjunganbydokterV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPLaporankunjunganbydokterV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPLaporankunjunganbydokterV']['tgl_akhir']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'kunjunganDokter/_printKunjunganDokter';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikKunjunganDokter()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPLaporankunjunganbydokterV('search');
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Dokter';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPLaporankunjunganbydokterV'])) {
      $model->attributes = $_GET['PPLaporankunjunganbydokterV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPLaporankunjunganbydokterV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPLaporankunjunganbydokterV']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanPerUnitPelayanan()
  {
    $model = new PPRuanganM('search');
    $model->tgl_awal = date('d M Y') . ' 00:00:00';
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['PPRuanganM'])) {
      $model->attributes = $_GET['PPRuanganM'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_akhir']);
    }

    $this->render($this->pathViewPP . 'unitPelayanan/adminUnitPelayanan', array(
      'model' => $model,
    ));
  }

  public function actionPrintLaporanPerUnitPelayanan()
  {
    $model = new PPRuanganM('search');
    $judulLaporan = 'Laporan Kunjungan Dokter';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Per Unit Pelayanan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPRuanganM'])) {
      $model->attributes = $_REQUEST['PPRuanganM'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPRuanganM']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPRuanganM']['tgl_akhir']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->pathViewPP . 'unitPelayanan/_printUnitPelayanan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikPerUnitPelayanan()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPRuanganM('search');
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kunjungan Per Unit Pelayanan';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPRuanganM'])) {
      $model->attributes = $_GET['PPRuanganM'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPRuanganM']['tgl_akhir']);
    }

    $this->render($this->pathViewPP . '_grafikUnitPelayanan', array(
      'model' => $model,
      'data' => $data,
    ));
  }



//======================================= Laporan Antrian ===================================================


  public function actionLaporanAntrian()
  {
    $model = new PPLaporanantrianV('search');
    $model->tgl_awal = date('d M Y') . ' 00:00:00';
    $model->tgl_akhir = date('Y-m-d');
    $format = new MyFormatter();

    if (isset($_GET['PPLaporanantrianV'])) {
      $model->attributes = $_GET['PPLaporanantrianV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPLaporanantrianV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPLaporanantrianV']['tgl_akhir']);
    }

    $this->render('antrian/adminAntrian', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintLaporanAntrian()
  {
    $model = new PPLaporanantrianV('search');
    $judulLaporan = 'Laporan Antrian';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Antrian';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : "");
    if (isset($_REQUEST['PPLaporanantrianV'])) {
      $model->attributes = $_REQUEST['PPLaporanantrianV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPLaporanantrianV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPLaporanantrianV']['tgl_akhir']);
    }
    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'antrian/_printAntrian';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikAntrian()
  {
    $this->layout = '//layouts/iframe';

    $model = new PPLaporanantrianV('search');
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Antrian';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_GET['PPLaporanantrianV'])) {
      $model->attributes = $_GET['PPLaporanantrianV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPLaporanantrianV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPLaporanantrianV']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

//======================================= End Laporan Antrian ===================================================


  /*
	* Mencari Ruangan berdasarkan instalasi di tabel kelas Ruangan M
	* and open the template in the editor.
	*/
  public function actionGetRuanganDariInstalasi($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {

      $idInstalasi = $_POST["$namaModel"]['instalasi_id'];
      $ruangan = RuanganM::model()->findAllByAttributes(array('instalasi_id' => $idInstalasi, 'ruangan_aktif' => true), array('order' => 'ruangan_nama'));

      $ruangan = CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama');

      if (empty($ruangan)) {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      } else {
        //  echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
        foreach ($ruangan as $value => $name) {
          echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      }
    }
    Yii::app()->end();
  }

  public function actionGantiPeriode()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $namaPeriode = $_POST['namaPeriode'];
      $month = date('m');
      $year = date('Y');
      $jumHari = cal_days_in_month(CAL_GREGORIAN, $month, $year);

      $bulan =  date("Y-m-d", mktime(0, 0, 0, $month, $jumHari, $year));


      $lastmonth = mktime(0, 0, 0, date("m") - 1, date("d"),   date("Y"));
      $nextyear  = mktime(0, 0, 0, date("m"),   date("d"),   date("Y") + 1);

      if ($namaPeriode == "hari") {
        $awal = date('Y-m-d 00:00:00');
        $akhir = date('Y-m-d 23:59:59');
      } else if ($namaPeriode == "bulan") {
        $awal = date('Y-m-01 00:00:00');
        $akhir = date('' . $bulan . ' 23:59:59');
      } else if ($namaPeriode == "tahun") {
        $awal = date('Y-01-01 00:00:00');
        $akhir = date('Y-12-01 23:59:59');
      } else {
        $awal = date('Y-m-d 00:00:00');
        $akhir = date('Y-m-d 23:59:59');
      }

      $data['periodeawal']  = $awal;
      $data['periodeakhir'] = $akhir;
      $data['namaPeriode'] = $namaPeriode;

      echo CJSON::encode($data);
      Yii::app()->end();
    }
  }

  /**
   * Mengatur dropdown kabupaten
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownKabupaten($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPasien = new PPPasienM;
      if ($model_nama !== '' && $attr == '') {
        $propinsi_id = $_POST["$model_nama"]['propinsi_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $propinsi_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $propinsi_id = $_POST["$model_nama"]["$attr"];
      }
      $kabupaten = null;
      if ($propinsi_id) {
        $kabupaten = $modPasien->getKabupatenItems($propinsi_id);
        $kabupaten = CHtml::listData($kabupaten, 'kabupaten_id', 'kabupaten_nama');
      }
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
  /**
   * Mengatur dropdown kecamatan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownKecamatan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPasien = new PPPasienM;
      if ($model_nama !== '' && $attr == '') {
        $kabupaten_id = $_POST["$model_nama"]['kabupaten_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $kabupaten_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $kabupaten_id = $_POST["$model_nama"]["$attr"];
      }
      $kecamatan = null;
      if ($kabupaten_id) {
        $kecamatan = $modPasien->getKecamatanItems($kabupaten_id);
        $kecamatan = CHtml::listData($kecamatan, 'kecamatan_id', 'kecamatan_nama');
      }

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
  /**
   * Mengatur dropdown kelurahan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownKelurahan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPasien = new PPPasienM;
      if ($model_nama !== '' && $attr == '') {
        $kecamatan_id = $_POST["$model_nama"]['kecamatan_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $kecamatan_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $kecamatan_id = $_POST["$model_nama"]["$attr"];
      }
      $kelurahan = null;
      if ($kecamatan_id) {
        $kelurahan = $modPasien->getKelurahanItems($kecamatan_id);
        //                    $kelurahan = KelurahanM::model()->findAll('kecamatan_id='.$kecamatan_id.'');
        $kelurahan = CHtml::listData($kelurahan, 'kelurahan_id', 'kelurahan_nama');
      }

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

  public function actionPegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 10;
      $models = PegawaiM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . ' ' . $model->nama_pegawai . ' ' . $model->gelarbelakang->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

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
        if (count((array)$models) > 1) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } elseif (count((array)$models) == 0) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        }

        if (count((array)$models) > 0) {
          foreach ($models as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }
}
