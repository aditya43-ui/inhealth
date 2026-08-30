<?php
Yii::import("billingKasir.models.*");
class LaporanController extends MyAuthController
{
  public function actionLaporanSensusHarian()
  {
    $this->pageTitle = Yii::app()->name . " - Sensus Harian";
    $modPasLaporanPasienMeninggalien = new RDPasienM;
    $model = new RDLaporansensusharian('search');
    $modPasien = new RDPasienM();
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['RDLaporansensusharian'])) {
      $model->attributes = $_GET['RDLaporansensusharian'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RDLaporansensusharian']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporansensusharian']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporansensusharian']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporansensusharian']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporansensusharian']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporansensusharian']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporansensusharian']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
      $model->pilihanx = $_GET['RDLaporansensusharian']['pilihanx'];
    }
    if (Yii::app()->request->isAjaxRequest) {
      echo $this->renderPartial('rawatDarurat.views.laporan.sensus._table', array('model' => $model), true);
    } else {
      $this->render('sensus/adminSensus', array(
        'model' => $model, 'modPasien' => $modPasien
      ));
    }
  }

  public function actionPrintLaporanSensusHarian()
  {
    $model = new RDLaporansensusharian('searchPrint');
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Sensus Harian Rawat Darurat';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Sensus Harian';
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
    if (isset($_REQUEST['RDLaporansensusharian'])) {
      $model->attributes = $_REQUEST['RDLaporansensusharian'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_REQUEST['RDLaporansensusharian']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RDLaporansensusharian']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RDLaporansensusharian']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['RDLaporansensusharian']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['RDLaporansensusharian']['bln_akhir']);
      $model->thn_awal = $_REQUEST['RDLaporansensusharian']['thn_awal'];
      $model->thn_akhir = $_REQUEST['RDLaporansensusharian']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
      $model->pilihanx = $_GET['RDLaporansensusharian']['pilihanx'];
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'sensus/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikSensusHarian()
  {
    $this->layout = '//layouts/iframe';
    $model = new RDLaporansensusharian('searchGrafik');
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
    $data['title'] = 'Grafik Laporan Sensus Harian';
    $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;

    if (isset($_GET['RDLaporansensusharian'])) {
      $model->attributes = $_GET['RDLaporansensusharian'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RDLaporansensusharian']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporansensusharian']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporansensusharian']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporansensusharian']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporansensusharian']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporansensusharian']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporansensusharian']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
      $model->pilihanx = $_GET['RDLaporansensusharian']['pilihanx'];
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanKunjungan()
  {
    $this->pageTitle = Yii::app()->name . " - Kunjungan Pasien";
    $model = new RDLaporankunjunganrdV('search');
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['RDLaporankunjunganrdV'])) {
      $model->attributes = $_GET['RDLaporankunjunganrdV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RDLaporankunjunganrdV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporankunjunganrdV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporankunjunganrdV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporankunjunganrdV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporankunjunganrdV']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporankunjunganrdV']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporankunjunganrdV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
      $model->pilihanx = $_GET['RDLaporankunjunganrdV']['pilihanx'];
      $model->carabayar_id = isset($_GET['RDLaporankunjunganrdV']['carabayar_id']) ? $_GET['RDLaporankunjunganrdV']['carabayar_id'] : null;
      $model->penjamin_id = isset($_GET['RDLaporankunjunganrdV']['penjamin_id']) ? $_GET['RDLaporankunjunganrdV']['penjamin_id'] : null;
      $model->propinsi_id = isset($_GET['RDLaporankunjunganrdV']['propinsi_id']) ? $_GET['RDLaporankunjunganrdV']['propinsi_id'] : null;
      $model->kabupaten_id = isset($_GET['RDLaporankunjunganrdV']['kabupaten_id']) ? $_GET['RDLaporankunjunganrdV']['kabupaten_id'] : null;


      //			echo "<pre>";
      //			print_r($model->tgl_awal."-".$model->tgl_akhir);exit;
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo $this->renderPartial('rawatDarurat.views.laporan.kunjungan._tableKunjungan', array('model' => $model), true);
    } else {
      $this->render('kunjungan/adminKunjungan', array(
        'model' => $model,
      ));
    }
  }

  public function actionPrintLaporanKunjungan()
  {
    $model = new RDLaporankunjunganrdV('search');
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Info Kunjungan Pasien Rawat Darurat';


    //Data Grafik       
    $data['title'] = 'Grafik Laporan Info Kunjungan';
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
    if (isset($_REQUEST['RDLaporankunjunganrdV'])) {
      $model->attributes = $_REQUEST['RDLaporankunjunganrdV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_REQUEST['RDLaporankunjunganrdV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RDLaporankunjunganrdV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RDLaporankunjunganrdV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['RDLaporankunjunganrdV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['RDLaporankunjunganrdV']['bln_akhir']);
      $model->thn_awal = $_REQUEST['RDLaporankunjunganrdV']['thn_awal'];
      $model->thn_akhir = $_REQUEST['RDLaporankunjunganrdV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
      $model->pilihanx = $_GET['RDLaporankunjunganrdV']['pilihanx'];
      $model->carabayar_id = isset($_REQUEST['RDLaporankunjunganrdV']['carabayar_id']) ? $_REQUEST['RDLaporankunjunganrdV']['carabayar_id'] : null;
      $model->penjamin_id = isset($_REQUEST['RDLaporankunjunganrdV']['penjamin_id']) ? $_REQUEST['RDLaporankunjunganrdV']['penjamin_id'] : null;
      $model->propinsi_id = isset($_REQUEST['RDLaporankunjunganrdV']['propinsi_id']) ? $_REQUEST['RDLaporankunjunganrdV']['propinsi_id'] : null;
      $model->kabupaten_id = isset($_REQUEST['RDLaporankunjunganrdV']['kabupaten_id']) ? $_REQUEST['RDLaporankunjunganrdV']['kabupaten_id'] : null;
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'kunjungan/_printKunjungan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikKunjungan()
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = new RDLaporankunjunganrdV('searchGrafik');
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
    $data['title'] = 'Grafik Info Kunjungan';
    $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;
    if (isset($_GET['RDLaporankunjunganrdV'])) {
      $model->attributes = $_GET['RDLaporankunjunganrdV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RDLaporankunjunganrdV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporankunjunganrdV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporankunjunganrdV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporankunjunganrdV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporankunjunganrdV']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporankunjunganrdV']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporankunjunganrdV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
      $model->pilihanx = $_GET['RDLaporankunjunganrdV']['pilihanx'];
      $model->carabayar_id = isset($_GET['RDLaporankunjunganrdV']['carabayar_id']) ? $_GET['RDLaporankunjunganrdV']['carabayar_id'] : null;
      $model->penjamin_id = isset($_GET['RDLaporankunjunganrdV']['penjamin_id']) ? $_GET['RDLaporankunjunganrdV']['penjamin_id'] : null;
      $model->propinsi_id = isset($_GET['RDLaporankunjunganrdV']['propinsi_id']) ? $_GET['RDLaporankunjunganrdV']['propinsi_id'] : null;
      $model->kabupaten_id = isset($_GET['RDLaporankunjunganrdV']['kabupaten_id']) ? $_GET['RDLaporankunjunganrdV']['kabupaten_id'] : null;
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanBukuRegister()
  {
    $this->pageTitle = Yii::app()->name . " - Buku Register";
    $model = new RDBukuregisterpasien('search');
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $modPasien = new RDPasienM;

    if (isset($_GET['RDBukuregisterpasien'])) {
      $model->attributes = $_GET['RDBukuregisterpasien'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RDBukuregisterpasien']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDBukuregisterpasien']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDBukuregisterpasien']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDBukuregisterpasien']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDBukuregisterpasien']['bln_akhir']);
      $model->thn_awal = $_GET['RDBukuregisterpasien']['thn_awal'];
      $model->thn_akhir = $_GET['RDBukuregisterpasien']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
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
      echo $this->renderPartial('rawatDarurat.views.laporan.bukuRegister._tableBukuRegister', array('model' => $model), true);
    } else {
      $this->render('bukuRegister/adminBukuRegister', array(
        'model' => $model, 'modPasien' => $modPasien
      ));
    }
  }

  public function actionPrintLaporanBukuRegister()
  {
    $model = new RDBukuregisterpasien('search');
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Buku Register Pasien Rawat Darurat';

    //Data Grafik   
    $data['title'] = 'Grafik Laporan Buku Register Pasien Rawat Darurat';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['RDBukuregisterpasien'])) {
      $model->attributes = $_REQUEST['RDBukuregisterpasien'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RDBukuregisterpasien']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDBukuregisterpasien']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDBukuregisterpasien']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDBukuregisterpasien']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDBukuregisterpasien']['bln_akhir']);
      $model->thn_awal = $_GET['RDBukuregisterpasien']['thn_awal'];
      $model->thn_akhir = $_GET['RDBukuregisterpasien']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
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
    $model = new RDBukuregisterpasien('search');
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
    $data['title'] = 'Grafik Laporan Buku Register Pasien Rawat Darurat';
    $data['type'] = $_GET['type'];
    if (isset($_GET['RDBukuregisterpasien'])) {
      $model->attributes = $_GET['RDBukuregisterpasien'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RDBukuregisterpasien']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDBukuregisterpasien']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDBukuregisterpasien']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDBukuregisterpasien']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDBukuregisterpasien']['bln_akhir']);
      $model->thn_awal = $_GET['RDBukuregisterpasien']['thn_awal'];
      $model->thn_akhir = $_GET['RDBukuregisterpasien']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
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
    $model = new RDLaporan10besarpenyakit('search');
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

    if (isset($_GET['RDLaporan10besarpenyakit'])) {
      $model->attributes = $_GET['RDLaporan10besarpenyakit'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RDLaporan10besarpenyakit']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporan10besarpenyakit']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporan10besarpenyakit']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporan10besarpenyakit']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporan10besarpenyakit']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporan10besarpenyakit']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporan10besarpenyakit']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
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
      echo $this->renderPartial('rawatDarurat.views.laporan.10Besar._table10Besar', array('model' => $model), true);
    } else {
      $this->render('10Besar/admin10BesarPenyakit', array(
        'model' => $model,
      ));
    }
  }

  public function actionPrintLaporan10BesarPenyakit()
  {
    $model = new RDLaporan10besarpenyakit('search');
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
    $judulLaporan = 'Laporan 10 Besar Penyakit Pasien Rawat Darurat';

    //Data Grafik
    $data['title'] = 'Grafik Laporan 10 Besar Penyakit Pasien';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['RDLaporan10besarpenyakit'])) {
      $model->attributes = $_REQUEST['RDLaporan10besarpenyakit'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RDLaporan10besarpenyakit']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporan10besarpenyakit']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporan10besarpenyakit']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporan10besarpenyakit']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporan10besarpenyakit']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporan10besarpenyakit']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporan10besarpenyakit']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
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
    $model = new RDLaporan10besarpenyakit('search');
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

    //Data Grafik
    $data['title'] = 'Grafik Laporan 10 Besar Penyakit';
    $data['type'] = $_GET['type'];
    if (isset($_GET['RDLaporan10besarpenyakit'])) {
      $model->attributes = $_GET['RDLaporan10besarpenyakit'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RDLaporan10besarpenyakit']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporan10besarpenyakit']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporan10besarpenyakit']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporan10besarpenyakit']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporan10besarpenyakit']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporan10besarpenyakit']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporan10besarpenyakit']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
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
    $model = new RDLaporancaramasukpasienrd('search');
    $model->tgl_awal = date('d M Y 00:00:00');
    $model->tgl_akhir = date('d M Y H:i:s');
    $asalrujukan = CHtml::listData(AsalrujukanM::model()->findAll('asalrujukan_aktif = true'), 'asalrujukan_id', 'asalrujukan_id');
    $model->asalrujukan_id = $asalrujukan;
    if (isset($_GET['RDLaporancaramasukpasienrd'])) {
      $model->attributes = $_GET['RDLaporancaramasukpasienrd'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporancaramasukpasienrd']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporancaramasukpasienrd']['tgl_akhir']);
    }

    $this->render('caraMasuk/adminCaraMasukPasien', array(
      'model' => $model, 'filter' => $filter
    ));
  }

  public function actionPrintLaporanCaraMasukPasien()
  {
    $model = new RDLaporancaramasukpasienrd('search');
    $judulLaporan = 'Laporan Cara Masuk Pasien Rawat Darurat';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Cara Masuk Pasien';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['RDLaporancaramasukpasienrd'])) {
      $model->attributes = $_REQUEST['RDLaporancaramasukpasienrd'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RDLaporancaramasukpasienrd']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RDLaporancaramasukpasienrd']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'caraMasuk/_printCaraMasuk';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanCaraMasukPasien()
  {
    $this->layout = '//layouts/iframe';
    $model = new RDLaporancaramasukpasienrd('search');
    $model->tgl_awal = date('d M Y 00:00:00');
    $model->tgl_akhir = date('d M Y H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Cara Masuk Pasien';
    $data['type'] = $_GET['type'];
    if (isset($_GET['RDLaporancaramasukpasienrd'])) {
      $model->attributes = $_GET['RDLaporancaramasukpasienrd'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporancaramasukpasienrd']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporancaramasukpasienrd']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanTindakLanjut()
  {
    $this->pageTitle = Yii::app()->name . " - Tindak Lanjut";
    $model = new RDLaporantindaklanjutrd('search');
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $temp = array();
    foreach (CarakeluarM::model()->getCaraKeluar() as $i => $data) {
      $temp[] = strtoupper($data);
    }
    $model->carakeluar = $temp;

    if (isset($_GET['RDLaporantindaklanjutrd'])) {
      $model->attributes = $_GET['RDLaporantindaklanjutrd'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RDLaporantindaklanjutrd']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporantindaklanjutrd']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporantindaklanjutrd']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporantindaklanjutrd']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporantindaklanjutrd']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporantindaklanjutrd']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporantindaklanjutrd']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
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
      echo $this->renderPartial('rawatDarurat.views.laporan.tindakLanjut._tableTindakLanjut', array('model' => $model), true);
    } else {
      $this->render('tindakLanjut/adminTindakLanjut', array(
        'model' => $model,
      ));
    }
  }

  public function actionPrintLaporanTindakLanjut()
  {
    $model = new RDLaporantindaklanjutrd('search');
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Tindak Lanjut Pasien Rawat Darurat';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Tindak Lanjut Pasien';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['RDLaporantindaklanjutrd'])) {
      $model->attributes = $_REQUEST['RDLaporantindaklanjutrd'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RDLaporantindaklanjutrd']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporantindaklanjutrd']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporantindaklanjutrd']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporantindaklanjutrd']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporantindaklanjutrd']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporantindaklanjutrd']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporantindaklanjutrd']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
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
    $target = 'tindakLanjut/_printTindakLanjut';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanTindakLanjut()
  {
    $this->layout = '//layouts/iframe';
    $model = new RDLaporantindaklanjutrd('search');
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
    $data['title'] = 'Grafik Laporan Tindak Lanjut Pasien';
    $data['type'] = $_GET['type'];
    if (isset($_GET['RDLaporantindaklanjutrd'])) {
      $model->attributes = $_GET['RDLaporantindaklanjutrd'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RDLaporantindaklanjutrd']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporantindaklanjutrd']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporantindaklanjutrd']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporantindaklanjutrd']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporantindaklanjutrd']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporantindaklanjutrd']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporantindaklanjutrd']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
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

  public function actionLaporanKonsulAntarPoli()
  {
    $model = new RDLaporankonsulantarpoli('search');
    $model->tgl_awal = date('d M Y 00:00:00');
    $model->tgl_akhir = date('d M Y H:i:s');
    $ruanganrawatjalan = CHtml::listData(RuanganrawatjalanV::model()->findAll('ruangan_aktif = true'), 'ruangan_id', 'ruangan_id');
    $model->ruangantujuan_id = $ruanganrawatjalan;
    if (isset($_GET['RDLaporankonsulantarpoli'])) {
      $model->attributes = $_GET['RDLaporankonsulantarpoli'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporankonsulantarpoli']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporankonsulantarpoli']['tgl_akhir']);
    }

    $this->render('konsulPoli/adminKonsulAntarPoli', array(
      'model' => $model,
    ));
  }

  public function actionPrintLaporanKonsulAntarPoli()
  {
    $model = new RDLaporankonsulantarpoli('search');
    $judulLaporan = 'Laporan Konsul Antar Poli Rawat Darurat';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Konsul Antar Poli';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['RDLaporankonsulantarpoli'])) {
      $model->attributes = $_REQUEST['RDLaporankonsulantarpoli'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RDLaporankonsulantarpoli']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RDLaporankonsulantarpoli']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'konsulPoli/_printKonsulPoli';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanKonsulAntarPoli()
  {
    $this->layout = '//layouts/iframe';
    $model = new RDLaporankonsulantarpoli('search');
    $model->tgl_awal = date('d M Y 00:00:00');
    $model->tgl_akhir = date('d M Y H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Konsul Antar Poli';
    $data['type'] = $_GET['type'];
    if (isset($_GET['RDLaporankonsulantarpoli'])) {
      $model->attributes = $_GET['RDLaporankonsulantarpoli'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporankonsulantarpoli']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporankonsulantarpoli']['tgl_akhir']);
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanKepenunjang()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Masuk Penunjang";
    $model = new RDLaporankepenunjangrd('search');
    $format = new MyFormatter();
    $model->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $kepenunjang = CHtml::listData(RuanganpenunjangV::model()->findAll('ruangan_aktif = true'), 'ruangan_id', 'ruangan_id');
    $model->ruanganpenunj_id = $kepenunjang;
    if (isset($_GET['RDLaporankepenunjangrd'])) {
      $model->attributes = $_GET['RDLaporankepenunjangrd'];
      $model->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RDLaporankepenunjangrd']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporankepenunjangrd']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporankepenunjangrd']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporankepenunjangrd']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporankepenunjangrd']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporankepenunjangrd']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporankepenunjangrd']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
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
      echo $this->renderPartial('rawatDarurat.views.laporan.kepenunjang._tableKepenunjang', array('model' => $model), true);
    } else {
      $this->render('kepenunjang/adminKepenunjang', array(
        'model' => $model,
      ));
    }
  }

  public function actionPrintLaporanKepenunjang()
  {
    $model = new RDLaporankepenunjangrd('search');
    $format = new MyFormatter();
    $model->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Kepenunjang Rawat Darurat';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kepenunjang';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['RDLaporankepenunjangrd'])) {
      $model->attributes = $_REQUEST['RDLaporankepenunjangrd'];
      $model->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RDLaporankepenunjangrd']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporankepenunjangrd']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporankepenunjangrd']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporankepenunjangrd']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporankepenunjangrd']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporankepenunjangrd']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporankepenunjangrd']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
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
    $target = 'kepenunjang/_printKepenunjang';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanKepenunjang()
  {
    $this->layout = '//layouts/iframe';
    $model = new RDLaporankepenunjangrd('search');
    $format = new MyFormatter();
    $model->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kepenunjang';
    $data['type'] = $_GET['type'];
    if (isset($_GET['RDLaporankepenunjangrd'])) {
      $model->attributes = $_GET['RDLaporankepenunjangrd'];
      $model->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RDLaporankepenunjangrd']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporankepenunjangrd']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporankepenunjangrd']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporankepenunjangrd']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporankepenunjangrd']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporankepenunjangrd']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporankepenunjangrd']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
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
    $model = new RDLaporanbiayapelayanan('search');
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $filter = null;
    $penjamin = CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif=TRUE'), 'penjamin_id', 'penjamin_id');
    $model->penjamin_id = $penjamin;
    $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
    $model->kelaspelayanan_id = $kelas;

    if (isset($_GET['RDLaporanbiayapelayanan'])) {
      $model->attributes = $_GET['RDLaporanbiayapelayanan'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RDLaporanbiayapelayanan']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporanbiayapelayanan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporanbiayapelayanan']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporanbiayapelayanan']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporanbiayapelayanan']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporanbiayapelayanan']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporanbiayapelayanan']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
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
      echo $this->renderPartial('rawatDarurat.views.laporan.biayaPelayanan._tableBiayaPelayanan', array('model' => $model), true);
    } else {
      $this->render('biayaPelayanan/adminBiayaPelayanan', array(
        'model' => $model, 'filter' => $filter
      ));
    }
  }

  public function actionPrintLaporanBiayaPelayanan()
  {
    $model = new RDLaporanbiayapelayanan('search');
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Biaya Pelayanan Rawat Darurat';

    //Data Grafik        
    $data['title'] = 'Grafik Laporan Biaya Pelayanan';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['RDLaporanbiayapelayanan'])) {
      $model->attributes = $_REQUEST['RDLaporanbiayapelayanan'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RDLaporanbiayapelayanan']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporanbiayapelayanan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporanbiayapelayanan']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporanbiayapelayanan']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporanbiayapelayanan']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporanbiayapelayanan']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporanbiayapelayanan']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
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
    $model = new RDLaporanbiayapelayanan('search');
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
    $data['title'] = 'Grafik Laporan Biaya Pelayanan';
    $data['type'] = $_GET['type'];
    if (isset($_GET['RDLaporanbiayapelayanan'])) {
      $model->attributes = $_GET['RDLaporanbiayapelayanan'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RDLaporanbiayapelayanan']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporanbiayapelayanan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporanbiayapelayanan']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporanbiayapelayanan']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporanbiayapelayanan']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporanbiayapelayanan']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporanbiayapelayanan']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
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
    $model = new RDLaporanpendapatanruangan('search');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

    $penjamin = CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_id');
    $model->penjamin_id = $penjamin;
    $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
    $model->kelaspelayanan_id = $kelas;
    $filter = (isset($_GET['filter']) ? $_GET['filter'] : null);

    if (isset($_GET['RDLaporanpendapatanruangan'])) {
      $model->attributes = $_GET['RDLaporanpendapatanruangan'];
      $model->jns_periode = $_GET['RDLaporanpendapatanruangan']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporanpendapatanruangan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporanpendapatanruangan']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporanpendapatanruangan']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporanpendapatanruangan']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporanpendapatanruangan']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporanpendapatanruangan']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    }

    $this->render('pendapatanRuangan/adminPendapatanRuangan', array(
      'model' => $model, 'filter' => $filter, 'format' => $format
    ));
  }

  public function actionPrintLaporanPendapatanRuangan()
  {
    $model = new RDLaporanpendapatanruangan('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $judulLaporan = 'Laporan Grafik Pendapatan Ruangan Rawat Darurat';

    //Data Grafik        
    $data['title'] = 'Grafik Laporan Pendapatan Ruangan';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['RDLaporanpendapatanruangan'])) {
      $model->attributes = $_REQUEST['RDLaporanpendapatanruangan'];
      $model->jns_periode = $_GET['RDLaporanpendapatanruangan']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporanpendapatanruangan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporanpendapatanruangan']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporanpendapatanruangan']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporanpendapatanruangan']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporanpendapatanruangan']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporanpendapatanruangan']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'pendapatanRuangan/_printPendapatanRuangan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanPendapatanRuangan()
  {
    $this->layout = '//layouts/iframe';
    $model = new RDLaporanpendapatanruangan('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Pendapatan Ruangan';
    $data['type'] = $_GET['type'];
    if (isset($_GET['RDLaporanpendapatanruangan'])) {
      $model->attributes = $_GET['RDLaporanpendapatanruangan'];
      $model->jns_periode = $_GET['RDLaporanpendapatanruangan']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporanpendapatanruangan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporanpendapatanruangan']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporanpendapatanruangan']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporanpendapatanruangan']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporanpendapatanruangan']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporanpendapatanruangan']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanJasaInstalasi()
  {
    $model = new RDLaporanjasainstalasi('search');
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    $filter = null;
    $penjamin = CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_id');
    $model->penjamin_id = $penjamin;
    $model->tindakansudahbayar_id = CustomFunction::getStatusBayar();
    if (isset($_GET['RDLaporanjasainstalasi'])) {
      $model->attributes = $_GET['RDLaporanjasainstalasi'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RDLaporanjasainstalasi']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporanjasainstalasi']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporanjasainstalasi']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporanjasainstalasi']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporanjasainstalasi']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporanjasainstalasi']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporanjasainstalasi']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
      $model->nama_pegawai = isset($_GET['RDLaporanjasainstalasi']['nama_pegawai']) ? $_GET['RDLaporanjasainstalasi']['nama_pegawai'] : null;
    }
    if (Yii::app()->request->isAjaxRequest) {
      echo $this->renderPartial('rawatDarurat.views.laporan.jasaInstalasi._tableJasaInstalasi', array('model' => $model), true);
    } else {
      $this->render('jasaInstalasi/adminJasaInstalasi', array(
        'model' => $model, 'filter' => $filter
      ));
    }
  }

  public function actionPrintLaporanJasaInstalasi()
  {
    $model = new RDLaporanjasainstalasi('search');
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Jasa Instalasi Rawat Darurat';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Jasa Instalasi';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['RDLaporanjasainstalasi'])) {
      $model->attributes = $_REQUEST['RDLaporanjasainstalasi'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RDLaporanjasainstalasi']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporanjasainstalasi']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporanjasainstalasi']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporanjasainstalasi']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporanjasainstalasi']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporanjasainstalasi']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporanjasainstalasi']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
      $model->nama_pegawai = isset($_GET['RDLaporanjasainstalasi']['nama_pegawai']) ? $_GET['RDLaporanjasainstalasi']['nama_pegawai'] : null;
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'jasaInstalasi/_printJasaInstalasi';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanJasaInstalasi()
  {
    $this->layout = '//layouts/iframe';
    $model = new RDLaporanjasainstalasi('search');
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
    if (isset($_GET['RDLaporanjasainstalasi'])) {
      $model->attributes = $_GET['RDLaporanjasainstalasi'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RDLaporanjasainstalasi']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporanjasainstalasi']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporanjasainstalasi']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporanjasainstalasi']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporanjasainstalasi']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporanjasainstalasi']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporanjasainstalasi']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
      $model->nama_pegawai = isset($_GET['RDLaporanjasainstalasi']['nama_pegawai']) ? $_GET['RDLaporanjasainstalasi']['nama_pegawai'] : null;
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanPemakaiObatAlkes()
  {
    $this->pageTitle = Yii::app()->name . " - Pemakaian Obat Alkes Ruangan";
    $model = new RDLaporanpemakaiobatalkesruanganV;
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
    $jenisObat = CHtml::listData($model->getJenisobatalkesItems(), 'jenisobatalkes_id', 'jenisobatalkes_id');
    $model->jenisobatalkes_id = $jenisObat;
    if (isset($_GET['RDLaporanpemakaiobatalkesruanganV'])) {
      $model->attributes = $_GET['RDLaporanpemakaiobatalkesruanganV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RDLaporanpemakaiobatalkesruanganV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporanpemakaiobatalkesruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporanpemakaiobatalkesruanganV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporanpemakaiobatalkesruanganV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporanpemakaiobatalkesruanganV']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporanpemakaiobatalkesruanganV']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporanpemakaiobatalkesruanganV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
    }

    $this->render('pemakaiObatAlkes/adminPemakaiObatAlkes', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function actionPrintLaporanPemakaiObatAlkes()
  {
    $model = new RDLaporanpemakaiobatalkesruanganV('search');
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Info Pemakai Obat Alkes Rawat Darurat';

    //Data Grafik       
    $data['title'] = 'Grafik Laporan Pemakai Obat Alkes';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['RDLaporanpemakaiobatalkesruanganV'])) {
      $model->attributes = $_REQUEST['RDLaporanpemakaiobatalkesruanganV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RDLaporanpemakaiobatalkesruanganV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporanpemakaiobatalkesruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporanpemakaiobatalkesruanganV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporanpemakaiobatalkesruanganV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporanpemakaiobatalkesruanganV']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporanpemakaiobatalkesruanganV']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporanpemakaiobatalkesruanganV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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
    $target = 'pemakaiObatAlkes/_printPemakaiObatAlkes';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }


  public function actionFrameGrafikLaporanPemakaiObatAlkes()
  {
    $this->layout = '//layouts/iframe';
    $model = new RDLaporanpemakaiobatalkesruanganV('search');
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
    $data['title'] = 'Grafik Laporan Pemakai Obat Alkes';
    $data['type'] = $_GET['type'];
    if (isset($_GET['RDLaporanpemakaiobatalkesruanganV'])) {
      $model->attributes = $_GET['RDLaporanpemakaiobatalkesruanganV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RDLaporanpemakaiobatalkesruanganV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporanpemakaiobatalkesruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporanpemakaiobatalkesruanganV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporanpemakaiobatalkesruanganV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporanpemakaiobatalkesruanganV']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporanpemakaiobatalkesruanganV']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporanpemakaiobatalkesruanganV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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

  public function actionLaporanPasienMeninggal()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Meninggal";
    $modPasien = new RDPasienM;
    $model = new RDLaporanpasienmeninggalV('search');
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    //$caramasuk = CHtml::listData(CaramasukM::model()->findAll('caramasuk_aktif = true'), 'caramasuk_id', 'caramasuk_id');
    //$model->caramasuk_id = RDLaporanpasienmeninggalV;
    if (isset($_GET['RDLaporanpasienmeninggalV'])) {
      $model->attributes = $_GET['RDLaporanpasienmeninggalV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RDLaporanpasienmeninggalV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporanpasienmeninggalV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporanpasienmeninggalV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporanpasienmeninggalV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporanpasienmeninggalV']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporanpasienmeninggalV']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporanpasienmeninggalV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
      $model->kondisikeluar_id = isset($_GET['RDLaporanpasienmeninggalV']['kondisikeluar_id']) ? $_GET['RDLaporanpasienmeninggalV']['kondisikeluar_id'] : '';
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo $this->renderPartial('rawatDarurat.views.laporan.pasienMeninggal._table', array('model' => $model), true);
    } else {
      $this->render('pasienMeninggal/index', array(
        'model' => $model, 'modPasien' => $modPasien
      ));
    }
  }

  public function actionPrintLaporanPasienMeninggal()
  {
    $model = new RDLaporanpasienmeninggalV('search');
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Pasien Meninggal';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Pasien Meninggal';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['RDLaporanpasienmeninggalV'])) {
      $model->attributes = $_REQUEST['RDLaporanpasienmeninggalV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RDLaporanpasienmeninggalV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporanpasienmeninggalV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporanpasienmeninggalV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporanpasienmeninggalV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporanpasienmeninggalV']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporanpasienmeninggalV']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporanpasienmeninggalV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
      $model->kondisikeluar_id = isset($_GET['RDLaporanpasienmeninggalV']['kondisikeluar_id']) ? $_GET['RDLaporanpasienmeninggalV']['kondisikeluar_id'] : '';
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'pasienMeninggal/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikPasienMeninggal()
  {
    $this->layout = '//layouts/iframe';
    $model = new RDLaporanpasienmeninggalV('search');
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
    $data['title'] = 'Grafik Laporan Pasien Meninggal';
    $data['type'] = $_GET['type'];

    if (isset($_GET['RDLaporanpasienmeninggalV'])) {
      $model->attributes = $_GET['RDLaporanpasienmeninggalV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RDLaporanpasienmeninggalV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporanpasienmeninggalV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporanpasienmeninggalV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporanpasienmeninggalV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporanpasienmeninggalV']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporanpasienmeninggalV']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporanpasienmeninggalV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
      $model->kondisikeluar_id = isset($_GET['RDLaporanpasienmeninggalV']['kondisikeluar_id']) ? $_GET['RDLaporanpasienmeninggalV']['kondisikeluar_id'] : '';
    }

    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  public function actionLaporanTriasePasien()
  {
    $this->pageTitle = Yii::app()->name . " - Triase Pasien";
    $model = new RDLaporantriasepasienV('search');
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    //$caramasuk = CHtml::listData(CaramasukM::model()->findAll('caramasuk_aktif = true'), 'caramasuk_id', 'caramasuk_id');
    //$model->caramasuk_id = RDLaporanpasienmeninggalV;
    $triase = CHtml::listData(Triase::model()->findAll(), 'triase_id', 'triase_id');
    $model->triase_id = $triase;
    if (isset($_GET['RDLaporantriasepasienV'])) {
      $model->attributes = $_GET['RDLaporantriasepasienV'];
      $format = new MyFormatter();
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RDLaporantriasepasienV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporantriasepasienV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporantriasepasienV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporantriasepasienV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporantriasepasienV']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporantriasepasienV']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporantriasepasienV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
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
      echo $this->renderPartial('rawatDarurat.views.laporan.triase._table', array('model' => $model), true);
    } else {
      $this->render('triase/index', array(
        'model' => $model,
      ));
    }
  }

  public function actionPrintLaporanTriasePasien()
  {
    $model = new RDLaporantriasepasienV('search');
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Triase Pasien';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Triase Pasien';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['RDLaporantriasepasienV'])) {
      $model->attributes = $_REQUEST['RDLaporantriasepasienV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RDLaporantriasepasienV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporantriasepasienV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporantriasepasienV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporantriasepasienV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporantriasepasienV']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporantriasepasienV']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporantriasepasienV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
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
    $target = 'triase/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikTriasePasien()
  {
    $this->layout = '//layouts/iframe';
    $model = new RDLaporantriasepasienV('search');
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
    $data['title'] = 'Grafik Laporan Pasien Meninggal';
    $data['type'] = $_GET['type'];

    if (isset($_GET['RDLaporantriasepasienV'])) {
      $model->attributes = $_GET['RDLaporantriasepasienV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RDLaporantriasepasienV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporantriasepasienV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporantriasepasienV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporantriasepasienV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporantriasepasienV']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporantriasepasienV']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporantriasepasienV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
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

  public function actionLaporanPasienDirujuk()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Dirujuk";
    $model = new RDLaporanpasiendirujukV('search');
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    //$caramasuk = CHtml::listData(CaramasukM::model()->findAll('caramasuk_aktif = true'), 'caramasuk_id', 'caramasuk_id');
//    $rujuk = CHtml::listData(RujukankeluarM::model()->findAll(), 'rujukankeluar_id', 'rujukankeluar_id');
//    $model->rujukankeluar_id = $rujuk;
    if (isset($_GET['RDLaporanpasiendirujukV'])) {
      $model->attributes = $_GET['RDLaporanpasiendirujukV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RDLaporanpasiendirujukV']['jns_periode'];
      $model->rujukankeluar_id = !isset($_GET['RDLaporanpasiendirujukV']['rujukankeluar_id']) ? null : $_GET['RDLaporanpasiendirujukV']['rujukankeluar_id'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporanpasiendirujukV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporanpasiendirujukV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporanpasiendirujukV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporanpasiendirujukV']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporanpasiendirujukV']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporanpasiendirujukV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
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
      echo $this->renderPartial('rawatDarurat.views.laporan.pasienDirujuk._table', array('model' => $model), true);
    } else {
      $this->render('pasienDirujuk/index', array(
        'model' => $model,
      ));
    }
  }

  public function actionPrintLaporanPasienDirujuk()
  {
    $model = new RDLaporanpasiendirujukV('search');
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Pasien Dirujuk';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Pasien Dirujuk';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['RDLaporanpasiendirujukV'])) {
      $model->attributes = $_REQUEST['RDLaporanpasiendirujukV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RDLaporanpasiendirujukV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporanpasiendirujukV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporanpasiendirujukV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporanpasiendirujukV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporanpasiendirujukV']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporanpasiendirujukV']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporanpasiendirujukV']['thn_akhir'];
      $model->rujukankeluar_id = !isset($_GET['RDLaporanpasiendirujukV']['rujukankeluar_id']) ? null : $_GET['RDLaporanpasiendirujukV']['rujukankeluar_id'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
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
    $target = 'pasienDirujuk/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanPasienDirujuk()
  {
    $this->layout = '//layouts/iframe';
    $model = new RDLaporanpasiendirujukV('search');
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
    $data['title'] = 'Grafik Laporan Pasien Dirujuk';
    $data['type'] = $_GET['type'];

    if (isset($_GET['RDLaporanpasiendirujukV'])) {
      $model->attributes = $_GET['RDLaporanpasiendirujukV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RDLaporanpasiendirujukV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporanpasiendirujukV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporanpasiendirujukV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporanpasiendirujukV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporanpasiendirujukV']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporanpasiendirujukV']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporanpasiendirujukV']['thn_akhir'];
      $model->rujukankeluar_id = !isset($_GET['RDLaporanpasiendirujukV']['rujukankeluar_id']) ? null : $_GET['RDLaporanpasiendirujukV']['rujukankeluar_id'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
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
  { // $modDetail untuk apa?
    $format = new MyFormatter();
    $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
    //        echo $caraPrint;
    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows2';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      ////$mpdf->useOddEven = 2;          
      // $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      // $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '-' . date('Y/m/d') . '.pdf', 'I');
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

  public function actionGetPenjaminPasien($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPasien = new RDPasienM;
      if ($model_nama !== '' && $attr == '') {
        $carabayar_id = $_POST["$model_nama"]['carabayar_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $carabayar_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $carabayar_id = $_POST["$model_nama"]["$attr"];
      }
      $penjamin = null;
      if ($carabayar_id) {
        $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $carabayar_id));
        $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
      }

      if ($encode) {
        echo CJSON::encode($penjamin);
      } else {
        if (empty($penjamin)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          if (count((array)$penjamin) > 1) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          } elseif (count((array)$penjamin) == 0) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          }

          foreach ($penjamin as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
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
      $modPasien = new RDPasienM;
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
      $modPasien = new RDPasienM;
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
      $modPasien = new RDPasienM;
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

  /*
     * ======================== PEMBEBASAN TARIF ===============================
     */

  public function actionLaporanPembebasanTarif()
  {
    $this->pageTitle = Yii::app()->name . " - Pembebasan Tarif";
    $model = new RDLaporanpembebasantarifV('search');
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
    if (isset($_GET['RDLaporanpembebasantarifV'])) {
      $model->attributes = $_GET['RDLaporanpembebasantarifV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_REQUEST['RDLaporanpembebasantarifV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporanpembebasantarifV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporanpembebasantarifV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporanpembebasantarifV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporanpembebasantarifV']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporanpembebasantarifV']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporanpembebasantarifV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
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
    $model = new RDLaporanpembebasantarifV('search');
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
    if (isset($_REQUEST['RDLaporanpembebasantarifV'])) {
      $model->attributes = $_REQUEST['RDLaporanpembebasantarifV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_REQUEST['RDLaporanpembebasantarifV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporanpembebasantarifV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporanpembebasantarifV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporanpembebasantarifV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporanpembebasantarifV']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporanpembebasantarifV']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporanpembebasantarifV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
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
    $model = new RDLaporanpembebasantarifV('search');
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
    if (isset($_GET['RDLaporanpembebasantarifV'])) {
      $model->attributes = $_GET['RDLaporanpembebasantarifV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_REQUEST['RDLaporanpembebasantarifV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporanpembebasantarifV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporanpembebasantarifV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporanpembebasantarifV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporanpembebasantarifV']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporanpembebasantarifV']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporanpembebasantarifV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
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
    $model = new RDLaporantindakanruangan('search');
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

    if (isset($_GET['RDLaporantindakanruangan'])) {
      $model->attributes = $_GET['RDLaporantindakanruangan'];
      $model->jns_periode = $_GET['RDLaporantindakanruangan']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporantindakanruangan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporantindakanruangan']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RDLaporantindakanruangan']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RDLaporantindakanruangan']['bln_akhir']);
      $model->thn_awal = $_GET['RDLaporantindakanruangan']['thn_awal'];
      $model->thn_akhir = $_GET['RDLaporantindakanruangan']['thn_akhir'];
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
    $model = new RDLaporantindakanruangan('search');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Grafik Tindakan Ruangan Rawat Darurat';
    $format = new MyFormatter();
    //Data Grafik        
    $data['title'] = 'Grafik Laporan Tindakan Ruangan';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['RDLaporantindakanruangan'])) {
      $model->attributes = $_REQUEST['RDLaporantindakanruangan'];
      $model->jns_periode = $_REQUEST['RDLaporantindakanruangan']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RDLaporantindakanruangan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RDLaporantindakanruangan']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['RDLaporantindakanruangan']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['RDLaporantindakanruangan']['bln_akhir']);
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
    $model = new RDLaporantindakanruangan('search');
    $model->tgl_awal = date('d M Y H:i:s');
    $model->tgl_akhir = date('d M Y H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Tindakan Ruangan Rawat Darurat';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_GET['RDLaporantindakanruangan'])) {
      $model->attributes = $_GET['RDLaporantindakanruangan'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RDLaporantindakanruangan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RDLaporantindakanruangan']['tgl_akhir']);
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
