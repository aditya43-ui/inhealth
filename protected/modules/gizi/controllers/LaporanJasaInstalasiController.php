<?php
Yii::import('rawatJalan.controllers.LaporanController');
Yii::import('rawatJalan.models.*');
class LaporanJasaInstalasiController extends LaporanController
{
  public $path_view = 'rawatJalan.views.laporan.';
  public $pathViewLap = 'rawatJalan.views.laporan.';

  public function actionLaporanJasaInstalasi()
  {
    $model = new RJLaporanjasainstalasi('search');
    $format = new MyFormatter();
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $filter = array();
    $penjamin = CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_id');
    $model->penjamin_id = $penjamin;
    $model->tindakansudahbayar_id = CustomFunction::getStatusBayar();
    if (isset($_GET['RJLaporanjasainstalasi'])) {
      $model->attributes = $_GET['RJLaporanjasainstalasi'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RJLaporanjasainstalasi']['jns_periode'];
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
      $model->tgl_awal = $model->tgl_awal;
      $model->tgl_akhir = $model->tgl_akhir;
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo $this->renderPartial('rawatJalan.views.laporan.jasaInstalasi._tableJasaInstalasi', array('model' => $model), true);
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
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Jasa Instalasi Rawat Jalan';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Jasa Instalasi';
    $data['type'] = $_REQUEST['type'];

    if (isset($_REQUEST['RJLaporanjasainstalasi'])) {
      $model->attributes = $_REQUEST['RJLaporanjasainstalasi'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RJLaporanjasainstalasi']['jns_periode'];
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
      $model->tgl_awal = $model->tgl_awal;
      $model->tgl_akhir = $model->tgl_akhir;
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view . 'jasaInstalasi/_printJasaInstalasi';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanJasaInstalasi()
  {
    $this->layout = '//layouts/iframe';
    $model = new RJLaporanjasainstalasi('search');
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
    if (isset($_GET['RJLaporanjasainstalasi'])) {
      $model->attributes = $_GET['RJLaporanjasainstalasi'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->jns_periode = $_GET['RJLaporanjasainstalasi']['jns_periode'];
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
      $model->tgl_awal = $model->tgl_awal;
      $model->tgl_akhir = $model->tgl_akhir;
    }

    $this->render($this->pathViewLap . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }
}
