<?php
Yii::import("billingKasir.models.*");
class LaporanController extends MyAuthController
{
  public $path_view = 'rawatJalan.views.laporan.';

  public function actionLaporanSensusHarian()
  {
    $this->pageTitle = Yii::app()->name . " - Sensus Harian";
    $model = new RJLaporansensusharian('search');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $format = new MyFormatter();

    if (isset($_GET['RJLaporansensusharian'])) {
      $model->attributes = $_GET['RJLaporansensusharian'];

      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RJLaporansensusharian']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporansensusharian']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporansensusharian']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJLaporansensusharian']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJLaporansensusharian']['bln_akhir']);
      $model->thn_awal = $_GET['RJLaporansensusharian']['thn_awal'];
      $model->thn_akhir = $_GET['RJLaporansensusharian']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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
      echo $this->renderPartial($this->path_view . 'sensus._table', array('model' => $model), true);
    } else {
      $this->render($this->path_view . 'sensus/adminSensus', array(
        'model' => $model,
      ));
    }
  }

  public function actionPrintLaporanSensusHarian()
  {
    $model = new RJLaporansensusharian('search');
    $ruanganId = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruangan_id = $ruanganId;
    $format = new MyFormatter();
    $ruanganNama = RuanganM::model()->findByPk($ruanganId);
    $judulLaporan = 'Laporan Sensus Harian Rawat Jalan <br/> ' . $ruanganNama->ruangan_nama . '';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Sensus Harian';
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
    if (isset($_REQUEST['RJLaporansensusharian'])) {
      $model->attributes = $_REQUEST['RJLaporansensusharian'];
      $model->ruangan_id = $ruanganId;
      $model->jns_periode = $_REQUEST['RJLaporansensusharian']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporansensusharian']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporansensusharian']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJLaporansensusharian']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJLaporansensusharian']['bln_akhir']);
      $model->thn_awal = $_GET['RJLaporansensusharian']['thn_awal'];
      $model->thn_akhir = $_GET['RJLaporansensusharian']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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
    $target = $this->path_view . 'sensus/_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikSensusHarian()
  {
    $this->layout = '//layouts/iframe';
    $model = new RJLaporansensusharian('search');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $format = new MyFormatter();

    //Data Grafik
    $data['title'] = 'Grafik Laporan Sensus Harian';
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;

    if (isset($_GET['RJLaporansensusharian'])) {
      $model->attributes = $_GET['RJLaporansensusharian'];
      $model->pilihanx = $_GET['RJLaporansensusharian']['pilihanx'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RJLaporansensusharian']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporansensusharian']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporansensusharian']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJLaporansensusharian']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJLaporansensusharian']['bln_akhir']);
      $model->thn_awal = $_GET['RJLaporansensusharian']['thn_awal'];
      $model->thn_akhir = $_GET['RJLaporansensusharian']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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

  public function actionLaporanKunjungan()
  {
    $this->pageTitle = Yii::app()->name . " - Kunjungan Pasien";
    $model = new RJInfokunjunganrjV('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

    if (isset($_GET['RJInfokunjunganrjV'])) {
      $model->attributes = $_GET['RJInfokunjunganrjV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RJInfokunjunganrjV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJInfokunjunganrjV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJInfokunjunganrjV']['bln_akhir']);
      $model->thn_awal = $_GET['RJInfokunjunganrjV']['thn_awal'];
      $model->thn_akhir = $_GET['RJInfokunjunganrjV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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
      echo $this->renderPartial($this->path_view . 'kunjungan._tableKunjungan', array('model' => $model), true);
    } else {
      $this->render($this->path_view . 'kunjungan/adminKunjungan', array(
        'model' => $model,
      ));
    }
  }

  public function actionPrintLaporanKunjungan()
  {
    $model = new RJInfokunjunganrjV('search');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $judulLaporan = 'Laporan Info Kunjungan Pasien Rawat Jalan';
    $format = new MyFormatter();
    //Data Grafik       
    $data['title'] = 'Grafik Laporan Info Kunjungan';
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
    if (isset($_REQUEST['RJInfokunjunganrjV'])) {
      $model->attributes = $_REQUEST['RJInfokunjunganrjV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_REQUEST['RJInfokunjunganrjV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJInfokunjunganrjV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJInfokunjunganrjV']['bln_akhir']);
      $model->thn_awal = $_GET['RJInfokunjunganrjV']['thn_awal'];
      $model->thn_akhir = $_GET['RJInfokunjunganrjV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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
    $target = $this->path_view . 'kunjungan/_printKunjungan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikKunjungan()
  {
    $this->layout = '//layouts/iframe';
    $model = new RJInfokunjunganrjV('searchGrafik');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $format = new MyFormatter();

    //Data Grafik
    $data['title'] = 'Grafik Info Kunjungan';
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;
    if (isset($_GET['RJInfokunjunganrjV'])) {
      $model->attributes = $_GET['RJInfokunjunganrjV'];
      $model->pilihanx = $_GET['RJInfokunjunganrjV']['pilihanx'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RJInfokunjunganrjV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJInfokunjunganrjV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJInfokunjunganrjV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJInfokunjunganrjV']['bln_akhir']);
      $model->thn_awal = $_GET['RJInfokunjunganrjV']['thn_awal'];
      $model->thn_akhir = $_GET['RJInfokunjunganrjV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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

  public function actionLaporanBukuRegister()
  {
    $this->pageTitle = Yii::app()->name . " - Buku Register";
    $model = new RJBukuregisterpasien('search');
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

    if (isset($_GET['RJBukuregisterpasien'])) {
      $model->attributes = $_GET['RJBukuregisterpasien'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RJBukuregisterpasien']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJBukuregisterpasien']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJBukuregisterpasien']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJBukuregisterpasien']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJBukuregisterpasien']['bln_akhir']);
      $model->thn_awal = $_GET['RJBukuregisterpasien']['thn_awal'];
      $model->thn_akhir = $_GET['RJBukuregisterpasien']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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
      echo $this->renderPartial($this->path_view . 'bukuRegister._tableBukuRegister', array('model' => $model), true);
    } else {
      $this->render($this->path_view . 'bukuRegister/adminBukuRegister', array(
        'model' => $model,
      ));
    }
  }

  public function actionPrintLaporanBukuRegister()
  {
    $model = new RJBukuregisterpasien('search');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

    $judulLaporan = 'Laporan Buku Register Pasien Rawat Jalan';
    $format = new MyFormatter();
    //Data Grafik
    $data['title'] = 'Grafik Laporan Buku Register Pasien Rawat Jalan';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['RJBukuregisterpasien'])) {
      $model->attributes = $_REQUEST['RJBukuregisterpasien'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_REQUEST['RJBukuregisterpasien']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJBukuregisterpasien']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJBukuregisterpasien']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJBukuregisterpasien']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJBukuregisterpasien']['bln_akhir']);
      $model->thn_awal = $_GET['RJBukuregisterpasien']['thn_awal'];
      $model->thn_akhir = $_GET['RJBukuregisterpasien']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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
    $target = $this->path_view . 'bukuRegister/_printBukuRegister';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikBukuRegister()
  {
    $this->layout = '//layouts/iframe';
    $model = new RJBukuregisterpasien('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    //Data Grafik
    $data['title'] = 'Grafik Laporan Buku Register Pasien Rawat Jalan';
    $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;
    if (isset($_GET['RJBukuregisterpasien'])) {
      $model->attributes = $_GET['RJBukuregisterpasien'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RJBukuregisterpasien']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJBukuregisterpasien']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJBukuregisterpasien']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJBukuregisterpasien']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJBukuregisterpasien']['bln_akhir']);
      $model->thn_awal = $_GET['RJBukuregisterpasien']['thn_awal'];
      $model->thn_akhir = $_GET['RJBukuregisterpasien']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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

  public function actionLaporan10BesarPenyakit()
  {
    $this->pageTitle = Yii::app()->name . " - 10 Besar Penyakit";
    $model = new RJLaporan10besarpenyakit('search');
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
    $model->jumlahTampil = 10;

    if (isset($_GET['RJLaporan10besarpenyakit'])) {
      $model->attributes = $_GET['RJLaporan10besarpenyakit'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RJLaporan10besarpenyakit']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporan10besarpenyakit']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporan10besarpenyakit']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJLaporan10besarpenyakit']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJLaporan10besarpenyakit']['bln_akhir']);
      $model->thn_awal = $_GET['RJLaporan10besarpenyakit']['thn_awal'];
      $model->thn_akhir = $_GET['RJLaporan10besarpenyakit']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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
      echo $this->renderPartial($this->path_view . '10Besar._table10Besar', array('model' => $model), true);
    } else {
      $this->render($this->path_view . '10Besar/admin10BesarPenyakit', array(
        'model' => $model,
      ));
    }
  }

  public function actionPrintLaporan10BesarPenyakit()
  {
    $model = new RJLaporan10besarpenyakit('search');
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
    $judulLaporan = 'Laporan 10 Besar Penyakit Pasien Rawat Jalan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan 10 Besar Penyakit Pasien';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['RJLaporan10besarpenyakit'])) {
      $model->attributes = $_REQUEST['RJLaporan10besarpenyakit'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_REQUEST['RJLaporan10besarpenyakit']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporan10besarpenyakit']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporan10besarpenyakit']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJLaporan10besarpenyakit']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJLaporan10besarpenyakit']['bln_akhir']);
      $model->thn_awal = $_GET['RJLaporan10besarpenyakit']['thn_awal'];
      $model->thn_akhir = $_GET['RJLaporan10besarpenyakit']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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
    $target = $this->path_view . '10Besar/_print10Besar';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafik10BesarPenyakit()
  {
    $this->layout = '//layouts/iframe';
    $model = new RJLaporan10besarpenyakit('search');
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
    $data['title'] = 'Grafik Laporan 10 Besar Penyakit';
    $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;
    if (isset($_GET['RJLaporan10besarpenyakit'])) {
      $model->attributes = $_GET['RJLaporan10besarpenyakit'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_REQUEST['RJLaporan10besarpenyakit']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporan10besarpenyakit']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporan10besarpenyakit']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJLaporan10besarpenyakit']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJLaporan10besarpenyakit']['bln_akhir']);
      $model->thn_awal = $_GET['RJLaporan10besarpenyakit']['thn_awal'];
      $model->thn_akhir = $_GET['RJLaporan10besarpenyakit']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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

  public function actionLaporanCaraMasukPasien()
  {
    $this->pageTitle = Yii::app()->name . " - Cara Masuk";
    $model = new RJLaporancaramasukpasienrj('search');
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
    $asalrujukan = CHtml::listData(AsalrujukanM::model()->findAll('asalrujukan_aktif = true'), 'asalrujukan_id', 'asalrujukan_id');
    $model->asalrujukan_id = $asalrujukan;
    $model->is_rujukan = 'non_rujukan';
    $filter = array();
    if (isset($_GET['RJLaporancaramasukpasienrj'])) {
      $model->attributes = $_GET['RJLaporancaramasukpasienrj'];
      $model->is_rujukan = $_GET['RJLaporancaramasukpasienrj']['is_rujukan'];
      $model->jns_periode = $_GET['RJLaporancaramasukpasienrj']['jns_periode'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporancaramasukpasienrj']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporancaramasukpasienrj']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJLaporancaramasukpasienrj']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJLaporancaramasukpasienrj']['bln_akhir']);
      $model->thn_awal = $_GET['RJLaporancaramasukpasienrj']['thn_awal'];
      $model->thn_akhir = $_GET['RJLaporancaramasukpasienrj']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
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

    $this->render($this->path_view . 'caraMasuk/adminCaraMasukPasien', array(
      'model' => $model, 'filter' => $filter
    ));
  }

  public function actionPrintLaporanCaraMasukPasien()
  {
    $model = new RJLaporancaramasukpasienrj('search');
    $judulLaporan = 'Laporan Cara Masuk Pasien Rawat Jalan';
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Cara Masuk Pasien';
    $data['type'] = $_REQUEST['type'];
    $asalrujukan = CHtml::listData(AsalrujukanM::model()->findAll('asalrujukan_aktif = true'), 'asalrujukan_id', 'asalrujukan_id');
    $model->asalrujukan_id = $asalrujukan;
    $model->is_rujukan = 'non_rujukan';
    $filter = array();
    if (isset($_REQUEST['RJLaporancaramasukpasienrj'])) {
      $model->attributes = $_REQUEST['RJLaporancaramasukpasienrj'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->is_rujukan = $_GET['RJLaporancaramasukpasienrj']['is_rujukan'];
      $model->jns_periode = $_REQUEST['RJLaporancaramasukpasienrj']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporancaramasukpasienrj']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporancaramasukpasienrj']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJLaporancaramasukpasienrj']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJLaporancaramasukpasienrj']['bln_akhir']);
      $model->thn_awal = $_GET['RJLaporancaramasukpasienrj']['thn_awal'];
      $model->thn_akhir = $_GET['RJLaporancaramasukpasienrj']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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
    $target = $this->path_view . 'caraMasuk/_printCaraMasuk';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target, $filter);
  }

  public function actionFrameGrafikLaporanCaraMasukPasien()
  {
    $this->layout = '//layouts/iframe';
    $model = new RJLaporancaramasukpasienrj('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Cara Masuk Pasien';
    $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;
    if (isset($_GET['RJLaporancaramasukpasienrj'])) {
      $model->attributes = $_GET['RJLaporancaramasukpasienrj'];
      $format = new MyFormatter();
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RJLaporancaramasukpasienrj']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporancaramasukpasienrj']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporancaramasukpasienrj']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJLaporancaramasukpasienrj']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJLaporancaramasukpasienrj']['bln_akhir']);
      $model->thn_awal = $_GET['RJLaporancaramasukpasienrj']['thn_awal'];
      $model->thn_akhir = $_GET['RJLaporancaramasukpasienrj']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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

  public function actionLaporanTindakLanjut()
  {
    $this->pageTitle = Yii::app()->name . " - Tindak Lanjut";
    $model = new RJLaporantindaklanjutrj('search');
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
    $temp = array();
    foreach (LookupM::getItems('carakeluar') as $i => $data) {
      //            $temp[] = strtoupper($data);
    }
    $model->carakeluar = $temp;

    if (isset($_GET['RJLaporantindaklanjutrj'])) {
      $model->attributes = $_GET['RJLaporantindaklanjutrj'];
      $format = new MyFormatter();
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RJLaporantindaklanjutrj']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporantindaklanjutrj']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporantindaklanjutrj']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJLaporantindaklanjutrj']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJLaporantindaklanjutrj']['bln_akhir']);
      $model->thn_awal = $_GET['RJLaporantindaklanjutrj']['thn_awal'];
      $model->thn_akhir = $_GET['RJLaporantindaklanjutrj']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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
      echo $this->renderPartial($this->path_view . 'tindakLanjut._tableTindakLanjut', array('model' => $model), true);
    } else {
      $this->render($this->path_view . 'tindakLanjut/adminTindakLanjut', array(
        'model' => $model,
      ));
    }
  }

  public function actionPrintLaporanTindakLanjut()
  {
    $model = new RJLaporantindaklanjutrj('search');
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $temp = array();
    foreach (LookupM::getItems('carakeluar') as $i => $data) {
      //            $temp[] = strtoupper($data);
    }
    $model->carakeluar = $temp;
    $judulLaporan = 'Laporan Tindak Lanjut Pasien Rawat Jalan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Tindak Lanjut Pasien';
    $data['type'] = $_REQUEST['type'];

    if (isset($_GET['RJLaporantindaklanjutrj'])) {
      $model->attributes = $_GET['RJLaporantindaklanjutrj'];
      $format = new MyFormatter();
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RJLaporantindaklanjutrj']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporantindaklanjutrj']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporantindaklanjutrj']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJLaporantindaklanjutrj']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJLaporantindaklanjutrj']['bln_akhir']);
      $model->thn_awal = $_GET['RJLaporantindaklanjutrj']['thn_awal'];
      $model->thn_akhir = $_GET['RJLaporantindaklanjutrj']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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
    $target = $this->path_view . 'tindakLanjut/_printTindakLanjut';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanTindakLanjut()
  {
    $this->layout = '//layouts/iframe';
    $model = new RJLaporantindaklanjutrj('search');
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
    $data['title'] = 'Grafik Laporan Tindak Lanjut Pasien';
    $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;
    if (isset($_GET['RJLaporantindaklanjutrj'])) {
      $model->attributes = $_GET['RJLaporantindaklanjutrj'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RJLaporantindaklanjutrj']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporantindaklanjutrj']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporantindaklanjutrj']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJLaporantindaklanjutrj']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJLaporantindaklanjutrj']['bln_akhir']);
      $model->thn_awal = $_GET['RJLaporantindaklanjutrj']['thn_awal'];
      $model->thn_akhir = $_GET['RJLaporantindaklanjutrj']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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

  public function actionLaporanKonsulAntarPoli()
  {
    $this->pageTitle = Yii::app()->name . " - Konsultasi Antar Poli";
    $model = new RJLaporankonsulantarpoli('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
    $ruanganrawatjalan = CHtml::listData(RuanganrawatjalanV::model()->findAll('ruangan_aktif = true ORDER BY ruangan_nama ASC '), 'ruangan_id', 'ruangan_id');
    $model->ruangantujuan_id = $ruanganrawatjalan;
    if (isset($_GET['RJLaporankonsulantarpoli'])) {
      $model->attributes = $_GET['RJLaporankonsulantarpoli'];
      $model->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RJLaporankonsulantarpoli']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporankonsulantarpoli']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporankonsulantarpoli']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJLaporankonsulantarpoli']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJLaporankonsulantarpoli']['bln_akhir']);
      $model->thn_awal = $_GET['RJLaporankonsulantarpoli']['thn_awal'];
      $model->thn_akhir = $_GET['RJLaporankonsulantarpoli']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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
      echo $this->renderPartial($this->path_view . 'konsulPoli._tableKonsul', array('model' => $model), true);
    } else {
      $this->render($this->path_view . 'konsulPoli/adminKonsulAntarPoli', array(
        'model' => $model,
      ));
    }
  }

  public function actionPrintLaporanKonsulAntarPoli()
  {
    $model = new RJLaporankonsulantarpoli('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
    $judulLaporan = 'Laporan Konsul Antar Poli Rawat Jalan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Konsul Antar Poli';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['RJLaporankonsulantarpoli'])) {
      $model->attributes = $_REQUEST['RJLaporankonsulantarpoli'];
      $format = new MyFormatter();
      $model->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_REQUEST['RJLaporankonsulantarpoli']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporankonsulantarpoli']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporankonsulantarpoli']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJLaporankonsulantarpoli']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJLaporankonsulantarpoli']['bln_akhir']);
      $model->thn_awal = $_GET['RJLaporankonsulantarpoli']['thn_awal'];
      $model->thn_akhir = $_GET['RJLaporankonsulantarpoli']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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
    $target = $this->path_view . 'konsulPoli/_printKonsulPoli';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanKonsulAntarPoli()
  {
    $this->layout = '//layouts/iframe';
    $model = new RJLaporankonsulantarpoli('searchGrafik');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruanganasal_id = Yii::app()->user->getState('ruangan_id');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Konsul Antar Poli';
    $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;
    if (isset($_GET['RJLaporankonsulantarpoli'])) {
      $model->attributes = $_GET['RJLaporankonsulantarpoli'];
      $model->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RJLaporankonsulantarpoli']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporankonsulantarpoli']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporankonsulantarpoli']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJLaporankonsulantarpoli']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJLaporankonsulantarpoli']['bln_akhir']);
      $model->thn_awal = $_GET['RJLaporankonsulantarpoli']['thn_awal'];
      $model->thn_akhir = $_GET['RJLaporankonsulantarpoli']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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

  public function actionLaporanKepenunjang()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Masuk Penunjang";
    $model = new RJLaporankepenunjangrj('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruanganasal_id = Yii::app()->user->getState('ruangan_id');

    $kepenunjang = CHtml::listData(RuanganpenunjangV::model()->findAll('ruangan_aktif = true ORDER BY ruangan_nama ASC'), 'ruangan_id', 'ruangan_id');
    $model->ruanganpenunj_id = $kepenunjang;
    if (isset($_GET['RJLaporankepenunjangrj'])) {
      $model->attributes = $_GET['RJLaporankepenunjangrj'];
      $model->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RJLaporankepenunjangrj']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporankepenunjangrj']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporankepenunjangrj']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJLaporankepenunjangrj']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJLaporankepenunjangrj']['bln_akhir']);
      $model->thn_awal = $_GET['RJLaporankepenunjangrj']['thn_awal'];
      $model->thn_akhir = $_GET['RJLaporankepenunjangrj']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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
      echo $this->renderPartial($this->path_view . 'kepenunjang._tableKepenunjang', array('model' => $model), true);
    } else {
      $this->render($this->path_view . 'kepenunjang/adminKepenunjang', array(
        'model' => $model,
      ));
    }
  }

  public function actionPrintLaporanKepenunjang()
  {
    $model = new RJLaporankepenunjangrj('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
    $judulLaporan = 'Laporan Kepenunjang Rawat Jalan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kepenunjang';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['RJLaporankepenunjangrj'])) {
      $model->attributes = $_REQUEST['RJLaporankepenunjangrj'];
      $model->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_REQUEST['RJLaporankepenunjangrj']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporankepenunjangrj']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporankepenunjangrj']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJLaporankepenunjangrj']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJLaporankepenunjangrj']['bln_akhir']);
      $model->thn_awal = $_GET['RJLaporankepenunjangrj']['thn_awal'];
      $model->thn_akhir = $_GET['RJLaporankepenunjangrj']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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
    $target = $this->path_view . 'kepenunjang/_printKepenunjang';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanKepenunjang()
  {
    $this->layout = '//layouts/iframe';
    $model = new RJLaporankepenunjangrj('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $model->ruanganasal_id = Yii::app()->user->getState('ruangan_id');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Kepenunjang';
    $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;
    if (isset($_GET['RJLaporankepenunjangrj'])) {
      $model->attributes = $_GET['RJLaporankepenunjangrj'];
      $model->ruanganasal_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_REQUEST['RJLaporankepenunjangrj']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporankepenunjangrj']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporankepenunjangrj']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJLaporankepenunjangrj']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJLaporankepenunjangrj']['bln_akhir']);
      $model->thn_awal = $_GET['RJLaporankepenunjangrj']['thn_awal'];
      $model->thn_akhir = $_GET['RJLaporankepenunjangrj']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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

  public function actionLaporanBiayaPelayanan()
  {
    $model = new RJLaporanbiayapelayanan('search');
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
    $filter = array();
    $penjamin = CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif=TRUE ORDER BY penjamin_nama ASC'), 'penjamin_id', 'penjamin_id');
    $model->penjamin_id = $penjamin;
    $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
    $model->kelaspelayanan_id = $kelas;

    if (isset($_GET['RJLaporanbiayapelayanan'])) {
      $model->attributes = $_GET['RJLaporanbiayapelayanan'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_REQUEST['RJLaporanbiayapelayanan']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporanbiayapelayanan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporanbiayapelayanan']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJLaporanbiayapelayanan']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJLaporanbiayapelayanan']['bln_akhir']);
      $model->thn_awal = $_GET['RJLaporanbiayapelayanan']['thn_awal'];
      $model->thn_akhir = $_GET['RJLaporanbiayapelayanan']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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
      echo $this->renderPartial($this->path_view . 'biayaPelayanan._tableBiayaPelayanan', array('model' => $model), true);
    } else {
      $this->render($this->path_view . 'biayaPelayanan/adminBiayaPelayanan', array(
        'model' => $model, 'filter' => $filter
      ));
    }
  }

  public function actionPrintLaporanBiayaPelayanan()
  {
    $model = new RJLaporanbiayapelayanan('search');
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

    $judulLaporan = 'Laporan Biaya Pelayanan Rawat Jalan';

    //Data Grafik        
    $data['title'] = 'Grafik Laporan Biaya Pelayanan';
    $data['type'] = $_REQUEST['type'];

    $filter = array();
    $penjamin = CHtml::listData(PenjaminpasienM::model()->findAll('penjamin_aktif=TRUE'), 'penjamin_id', 'penjamin_id');
    $model->penjamin_id = $penjamin;
    $kelas = CHtml::listData(KelaspelayananM::model()->findAll(), 'kelaspelayanan_id', 'kelaspelayanan_id');
    $model->kelaspelayanan_id = $kelas;

    if (isset($_REQUEST['RJLaporanbiayapelayanan'])) {
      $model->attributes = $_REQUEST['RJLaporanbiayapelayanan'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_REQUEST['RJLaporanbiayapelayanan']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporanbiayapelayanan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporanbiayapelayanan']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJLaporanbiayapelayanan']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJLaporanbiayapelayanan']['bln_akhir']);
      $model->thn_awal = $_GET['RJLaporanbiayapelayanan']['thn_awal'];
      $model->thn_akhir = $_GET['RJLaporanbiayapelayanan']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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
    $target = $this->path_view . 'biayaPelayanan/_printBiayaPelayanan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanBiayaPelayanan()
  {
    $this->layout = '//layouts/iframe';
    $model = new RJLaporanbiayapelayanan('search');
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
    $data['title'] = 'Grafik Laporan Biaya Pelayanan';
    $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;
    if (isset($_GET['RJLaporanbiayapelayanan'])) {
      $model->attributes = $_GET['RJLaporanbiayapelayanan'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RJLaporanbiayapelayanan']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporanbiayapelayanan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporanbiayapelayanan']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJLaporanbiayapelayanan']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJLaporanbiayapelayanan']['bln_akhir']);
      $model->thn_awal = $_GET['RJLaporanbiayapelayanan']['thn_awal'];
      $model->thn_akhir = $_GET['RJLaporanbiayapelayanan']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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
  public function actionLaporanPendapatanRuangan()
  {
    $model = new RJLaporanpendapatanruangan('search');
    $model->unsetAttributes();
    $format = new MyFormatter();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
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

    if (isset($_GET['RJLaporanpendapatanruangan'])) {
      $model->attributes = $_GET['RJLaporanpendapatanruangan'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RJLaporanpendapatanruangan']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporanpendapatanruangan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporanpendapatanruangan']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJLaporanpendapatanruangan']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJLaporanpendapatanruangan']['bln_akhir']);
      $model->thn_awal = $_GET['RJLaporanpendapatanruangan']['thn_awal'];
      $model->thn_akhir = $_GET['RJLaporanpendapatanruangan']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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
      echo $this->renderPartial($this->path_view . 'pendapatanRuangan._tablePendapatanRuangan', array('model' => $model), true);
    } else {
      $this->render($this->path_view . 'pendapatanRuangan/adminPendapatanRuangan', array(
        'model' => $model,
      ));
    }
  }

  public function actionPrintLaporanPendapatanRuangan()
  {
    $model = new RJLaporanpendapatanruangan('search');
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
    $judulLaporan = 'Laporan Grafik Pendapatan Ruangan Rawat Jalan';

    //Data Grafik        
    $data['title'] = 'Grafik Laporan Pendapatan Ruangan';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['RJLaporanpendapatanruangan'])) {
      $model->attributes = $_REQUEST['RJLaporanpendapatanruangan'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_REQUEST['RJLaporanpendapatanruangan']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporanpendapatanruangan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporanpendapatanruangan']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJLaporanpendapatanruangan']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJLaporanpendapatanruangan']['bln_akhir']);
      $model->thn_awal = $_GET['RJLaporanpendapatanruangan']['thn_awal'];
      $model->thn_akhir = $_GET['RJLaporanpendapatanruangan']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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
    $target = $this->path_view . 'pendapatanRuangan/_printPendapatanRuangan';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanPendapatanRuangan()
  {
    $this->layout = '//layouts/iframe';
    $model = new RJLaporanpendapatanruangan('search');
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
    $data['title'] = 'Grafik Laporan Pendapatan Ruangan';
    $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;
    if (isset($_GET['RJLaporanpendapatanruangan'])) {
      $model->attributes = $_GET['RJLaporanpendapatanruangan'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_REQUEST['RJLaporanpendapatanruangan']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporanpendapatanruangan']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporanpendapatanruangan']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJLaporanpendapatanruangan']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJLaporanpendapatanruangan']['bln_akhir']);
      $model->thn_awal = $_GET['RJLaporanpendapatanruangan']['thn_awal'];
      $model->thn_akhir = $_GET['RJLaporanpendapatanruangan']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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
  public function actionLaporanJasaInstalasi()
  {
    $model = new RJLaporanjasainstalasi('search');
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

    $filter = array();
    $penjamin = CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_id');
    $model->penjamin_id = $penjamin;
    $model->tindakansudahbayar_id = CustomFunction::getStatusBayar();
    if (isset($_GET['RJLaporanjasainstalasi'])) {
      $model->attributes = $_GET['RJLaporanjasainstalasi'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_REQUEST['RJLaporanjasainstalasi']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporanjasainstalasi']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporanjasainstalasi']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJLaporanjasainstalasi']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJLaporanjasainstalasi']['bln_akhir']);
      $model->thn_awal = $_GET['RJLaporanjasainstalasi']['thn_awal'];
      $model->thn_akhir = $_GET['RJLaporanjasainstalasi']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
      $model->nama_pegawai = isset($_GET['RJLaporanjasainstalasi']['nama_pegawai']) ? $_GET['RJLaporanjasainstalasi']['nama_pegawai'] : null;
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo $this->renderPartial($this->path_view . 'jasaInstalasi._tableJasaInstalasi', array('model' => $model), true);
    } else {
      $this->render($this->path_view . 'jasaInstalasi/adminJasaInstalasi', array(
        'model' => $model, 'filter' => $filter
      ));
    }
  }

  public function actionPrintLaporanJasaInstalasi()
  {
    $model = new RJLaporanjasainstalasi('search');
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
    $judulLaporan = 'Laporan Jasa Instalasi Rawat Jalan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Jasa Instalasi';
    $data['type'] = $_REQUEST['type'];

    if (isset($_REQUEST['RJLaporanjasainstalasi'])) {
      $model->attributes = $_REQUEST['RJLaporanjasainstalasi'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_REQUEST['RJLaporanjasainstalasi']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporanjasainstalasi']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporanjasainstalasi']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJLaporanjasainstalasi']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJLaporanjasainstalasi']['bln_akhir']);
      $model->thn_awal = $_GET['RJLaporanjasainstalasi']['thn_awal'];
      $model->thn_akhir = $_GET['RJLaporanjasainstalasi']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
      $model->nama_pegawai = isset($_GET['RJLaporanjasainstalasi']['nama_pegawai']) ? $_GET['RJLaporanjasainstalasi']['nama_pegawai'] : null;
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view . 'jasaInstalasi/_printJasaInstalasi';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanJasaInstalasi()
  {
    $this->layout = '//layouts/iframe';
    $model = new RJLaporanjasainstalasi('searchGrafik');
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
    $data['title'] = 'Grafik Laporan Jasa Instalasi';
    $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;
    if (isset($_GET['RJLaporanjasainstalasi'])) {
      $model->attributes = $_GET['RJLaporanjasainstalasi'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_REQUEST['RJLaporanjasainstalasi']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporanjasainstalasi']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporanjasainstalasi']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJLaporanjasainstalasi']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJLaporanjasainstalasi']['bln_akhir']);
      $model->thn_awal = $_GET['RJLaporanjasainstalasi']['thn_awal'];
      $model->thn_akhir = $_GET['RJLaporanjasainstalasi']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
      $model->nama_pegawai = isset($_GET['RJLaporanjasainstalasi']['nama_pegawai']) ? $_GET['RJLaporanjasainstalasi']['nama_pegawai'] : null;
    }

    $this->render($this->path_view . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  /*
     * ======================== PEMBEBASAN TARIF ===============================
     */

  public function actionLaporanPembebasanTarif()
  {
    $this->pageTitle = Yii::app()->name . " - Pembebasan Tarif";
    $model = new RJLaporanpembebasantarifV('search');
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
    if (isset($_GET['RJLaporanpembebasantarifV'])) {
      $model->attributes = $_GET['RJLaporanpembebasantarifV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_REQUEST['RJLaporanpembebasantarifV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporanpembebasantarifV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporanpembebasantarifV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJLaporanpembebasantarifV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJLaporanpembebasantarifV']['bln_akhir']);
      $model->thn_awal = $_GET['RJLaporanpembebasantarifV']['thn_awal'];
      $model->thn_akhir = $_GET['RJLaporanpembebasantarifV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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
    $model = new RJLaporanpembebasantarifV('search');
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
    if (isset($_REQUEST['RJLaporanpembebasantarifV'])) {
      $model->attributes = $_REQUEST['RJLaporanpembebasantarifV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_REQUEST['RJLaporanpembebasantarifV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporanpembebasantarifV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporanpembebasantarifV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJLaporanpembebasantarifV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJLaporanpembebasantarifV']['bln_akhir']);
      $model->thn_awal = $_GET['RJLaporanpembebasantarifV']['thn_awal'];
      $model->thn_akhir = $_GET['RJLaporanpembebasantarifV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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
    $model = new RJLaporanpembebasantarifV('search');
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
    if (isset($_GET['RJLaporanpembebasantarifV'])) {
      $model->attributes = $_GET['RJLaporanpembebasantarifV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_REQUEST['RJLaporanpembebasantarifV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporanpembebasantarifV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporanpembebasantarifV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJLaporanpembebasantarifV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJLaporanpembebasantarifV']['bln_akhir']);
      $model->thn_awal = $_GET['RJLaporanpembebasantarifV']['thn_awal'];
      $model->thn_akhir = $_GET['RJLaporanpembebasantarifV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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
      $stylesheet1 = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($stylesheet1, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 25, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '-' . date('Y/m/d') . '.pdf', 'I');
    }
  }

  public function actionLaporanPemakaiObatAlkes()
  {
    $this->pageTitle = Yii::app()->name . " - Pemakaian Obat Alkes Ruangan";
    $model = new RJLaporanpemakaiobatalkesruanganV;
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
    $jenisObat = CHtml::listData($model->getJenisobatalkesItems(), 'jenisobatalkes_id', 'jenisobatalkes_id');
    $model->jenisobatalkes_id = $jenisObat;
    if (isset($_GET['RJLaporanpemakaiobatalkesruanganV'])) {
      $model->attributes = $_GET['RJLaporanpemakaiobatalkesruanganV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_REQUEST['RJLaporanpemakaiobatalkesruanganV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporanpemakaiobatalkesruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporanpemakaiobatalkesruanganV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJLaporanpemakaiobatalkesruanganV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJLaporanpemakaiobatalkesruanganV']['bln_akhir']);
      $model->thn_awal = $_GET['RJLaporanpemakaiobatalkesruanganV']['thn_awal'];
      $model->thn_akhir = $_GET['RJLaporanpemakaiobatalkesruanganV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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
      echo $this->renderPartial($this->path_view . 'pemakaiObatAlkes._tablePemakaiObatAlkes', array('model' => $model), true);
    } else {
      $this->render($this->path_view . 'pemakaiObatAlkes/adminPemakaiObatAlkes', array('model' => $model));
    }
  }

  public function actionPrintLaporanPemakaiObatAlkes()
  {
    $model = new RJLaporanpemakaiobatalkesruanganV('search');
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
    $judulLaporan = 'Laporan Info Pemakai Obat Alkes Rawat Jalan';

    //Data Grafik       
    $data['title'] = 'Grafik Laporan Pemakai Obat Alkes';
    $data['type'] = $_REQUEST['type'];
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    $jenisObat = CHtml::listData($model->getJenisobatalkesItems(), 'jenisobatalkes_id', 'jenisobatalkes_id');
    $model->jenisobatalkes_id = $jenisObat;
    if (isset($_REQUEST['RJLaporanpemakaiobatalkesruanganV'])) {
      $model->attributes = $_GET['RJLaporanpemakaiobatalkesruanganV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_REQUEST['RJLaporanpemakaiobatalkesruanganV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporanpemakaiobatalkesruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporanpemakaiobatalkesruanganV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJLaporanpemakaiobatalkesruanganV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJLaporanpemakaiobatalkesruanganV']['bln_akhir']);
      $model->thn_awal = $_GET['RJLaporanpemakaiobatalkesruanganV']['thn_awal'];
      $model->thn_akhir = $_GET['RJLaporanpemakaiobatalkesruanganV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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
    $target = $this->path_view . 'pemakaiObatAlkes/_printPemakaiObatAlkes';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }


  public function actionFrameGrafikLaporanPemakaiObatAlkes()
  {
    $this->layout = '//layouts/iframe';
    $model = new RJLaporanpemakaiobatalkesruanganV('search');
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
    $data['title'] = 'Grafik Laporan Pemakai Obat Alkes';
    $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;
    if (isset($_GET['RJLaporanpemakaiobatalkesruanganV'])) {
      $model->attributes = $_GET['RJLaporanpemakaiobatalkesruanganV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_REQUEST['RJLaporanpemakaiobatalkesruanganV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporanpemakaiobatalkesruanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporanpemakaiobatalkesruanganV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['RJLaporanpemakaiobatalkesruanganV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['RJLaporanpemakaiobatalkesruanganV']['bln_akhir']);
      $model->thn_awal = $_GET['RJLaporanpemakaiobatalkesruanganV']['thn_awal'];
      $model->thn_akhir = $_GET['RJLaporanpemakaiobatalkesruanganV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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



/*
     * ======================== Tindakan Ruangan ===============================
     */
    public function actionLaporanTindakanRuangan()
    {
      $this->pageTitle = Yii::app()->name . " - Tindakan Ruangan";
      $model = new RJLaporantindakanruangan('search');
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
  
      if (isset($_GET['RJLaporantindakanruangan'])) {
        $model->attributes = $_GET['RJLaporantindakanruangan'];
        $model->jns_periode = $_GET['RJLaporantindakanruangan']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporantindakanruangan']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporantindakanruangan']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_GET['RJLaporantindakanruangan']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_GET['RJLaporantindakanruangan']['bln_akhir']);
        $model->thn_awal = $_GET['RJLaporantindakanruangan']['thn_awal'];
        $model->thn_akhir = $_GET['RJLaporantindakanruangan']['thn_akhir'];
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
      $model = new RJLaporantindakanruangan('search');
      $model->jns_periode = "hari";
      $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
      $model->tgl_akhir = date('Y-m-d');
      $model->bln_awal = date('Y-m', strtotime('first day of january'));
      $model->bln_akhir = date('Y-m');
      $model->thn_awal = date('Y');
      $model->thn_akhir = date('Y');
      $judulLaporan = 'Laporan Grafik Tindakan Ruangan Rawat Jalan';
      $format = new MyFormatter();
      //Data Grafik        
      $data['title'] = 'Grafik Laporan Tindakan Ruangan';
      $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
      if (isset($_REQUEST['RJLaporantindakanruangan'])) {
        $model->attributes = $_REQUEST['RJLaporantindakanruangan'];
        $model->jns_periode = $_REQUEST['RJLaporantindakanruangan']['jns_periode'];
        $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RJLaporantindakanruangan']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RJLaporantindakanruangan']['tgl_akhir']);
        $model->bln_awal = $format->formatMonthForDb($_REQUEST['RJLaporantindakanruangan']['bln_awal']);
        $model->bln_akhir = $format->formatMonthForDb($_REQUEST['RJLaporantindakanruangan']['bln_akhir']);
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
      $model = new RJLaporantindakanruangan('search');
      $model->tgl_awal = date('d M Y H:i:s');
      $model->tgl_akhir = date('d M Y H:i:s');
  
      //Data Grafik
      $data['title'] = 'Grafik Laporan Tindakan Ruangan Rawat Jalan';
      $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
      if (isset($_GET['RJLaporantindakanruangan'])) {
        $model->attributes = $_GET['RJLaporantindakanruangan'];
        $format = new MyFormatter();
        $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporantindakanruangan']['tgl_awal']);
        $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RJLaporantindakanruangan']['tgl_akhir']);
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
