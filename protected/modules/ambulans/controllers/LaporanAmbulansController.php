<?php

class LaporanAmbulansController extends MyAuthController
{
  public function actionIndex()
  {
    $this->render('index');
  }

  public function actionPemakaianambulans()
  {
    $model = new AMPemakaianambulansT('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    if (isset($_GET['AMPemakaianambulansT'])) {
      $model->attributes = $_GET['AMPemakaianambulansT'];
      $model->jns_periode = $_GET['AMPemakaianambulansT']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['AMPemakaianambulansT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AMPemakaianambulansT']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['AMPemakaianambulansT']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['AMPemakaianambulansT']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }
    $this->render('pemakaianAmbulansT/index', array('model' => $model, 'format' => $format));
  }

  public function actionPrintPemakaianAmbulans()
  {
    $model = new AMPemakaianambulansT('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->jns_periode = "hari";
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Pemakaian Ambulans';

    //Data Grafik
    $data['title'] = 'Grafik Pemakaian Ambulans';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['AMPemakaianambulansT'])) {
      $model->attributes = $_REQUEST['AMPemakaianambulansT'];
      $model->jns_periode = $_REQUEST['AMPemakaianambulansT']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['AMPemakaianambulansT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['AMPemakaianambulansT']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_REQUEST['AMPemakaianambulansT']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_REQUEST['AMPemakaianambulansT']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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
    $target = 'pemakaianAmbulansT/Print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikPemakaianAmbulans()
  {
    $this->layout = '//layouts/iframe';

    $model = new AMPemakaianambulansT('search');
    $model->tgl_awal = date('Y-m-d 00:00:00');
    $model->tgl_akhir = date('Y-m-d 23:59:59');

    //Data Grafik
    $data['title'] = 'Grafik Presensi';
    $data['type'] = (isset($_GET['type']) ? $_GET['type'] : null);

    if (isset($_REQUEST['AMPemakaianambulansT'])) {
      $format = new MyFormatter();
      $model->attributes = $_GET['AMPemakaianambulansT'];
      $model->tgl_awal  = $format->formatDateTimeForDb($_GET['AMPemakaianambulansT']['tgl_awal']);
      $model->tgl_akhir  = $format->formatDateTimeForDb($_GET['AMPemakaianambulansT']['tgl_akhir']);
    }
    $this->render('_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }
  /* =================================== Function Laporan ======================================= */
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
