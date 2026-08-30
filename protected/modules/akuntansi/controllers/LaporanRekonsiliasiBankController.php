<?php

class LaporanRekonsiliasiBankController extends MyAuthController
{
  protected $path_view = 'akuntansi.views.laporanRekonsiliasiBank.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Rekonsiliasi Bank";
    $model  = new AKLaporanrekonsiliasibankV('searchLaporan');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');

    if (isset($_GET['AKLaporanrekonsiliasibankV'])) {
      $model->attributes = $_GET['AKLaporanrekonsiliasibankV'];
      $model->jns_periode = $_GET['AKLaporanrekonsiliasibankV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['AKLaporanrekonsiliasibankV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKLaporanrekonsiliasibankV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['AKLaporanrekonsiliasibankV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['AKLaporanrekonsiliasibankV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
      //$model->filter = $_GET['BKFakturPembelianT']['filter'];
    }

    $this->render($this->path_view . 'admin', array(
      'format' => $format,
      'model' => $model
    ));
  }

  public function actionPrintLaporanRekonsiliasiBank()
  {
    $model = new AKLaporanrekonsiliasibankV('searchLaporanPrint');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');
    $judulLaporan = 'Laporan Rekonsiliasi Bank';
    //Data Grafik
    $data['title'] = 'Laporan Rekonsiliasi Bank';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['AKLaporanrekonsiliasibankV'])) {
      $model->attributes = $_REQUEST['AKLaporanrekonsiliasibankV'];
      $model->jns_periode = $_GET['AKLaporanrekonsiliasibankV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['AKLaporanrekonsiliasibankV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKLaporanrekonsiliasibankV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['AKLaporanrekonsiliasibankV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['AKLaporanrekonsiliasibankV']['bln_akhir']);
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
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
    $target = $this->path_view . '_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanRekonsiliasiBank()
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = new AKLaporanrekonsiliasibankV('search');
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->bln_awal = date('Y-m', strtotime('first day of january'));
    $model->bln_akhir = date('Y-m');
    $model->thn_awal = date('Y');
    $model->thn_akhir = date('Y');



    //Data Grafik
    $data['title'] = 'Grafik Laporan Rekonsiliasi Bank';
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;

    if (isset($_GET['AKLaporanrekonsiliasibankV'])) {
      $model->attributes = $_GET['AKLaporanrekonsiliasibankV'];
      $model->jns_periode = $_GET['AKLaporanrekonsiliasibankV']['jns_periode'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['AKLaporanrekonsiliasibankV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKLaporanrekonsiliasibankV']['tgl_akhir']);
      $model->bln_awal = $format->formatMonthForDb($_GET['AKLaporanrekonsiliasibankV']['bln_awal']);
      $model->bln_akhir = $format->formatMonthForDb($_GET['AKLaporanrekonsiliasibankV']['bln_akhir']);
      $model->thn_awal = $_GET['AKLaporanrekonsiliasibankV']['thn_awal'];
      $model->thn_akhir = $_GET['AKLaporanrekonsiliasibankV']['thn_akhir'];
      $bln_akhir = $model->bln_akhir . "-" . date("t", strtotime($model->bln_akhir));
      $thn_akhir = $model->thn_akhir . "-" . date("m-t", strtotime($model->thn_akhir . "-12"));
      switch ($model->jns_periode) {
        case 'bulan':
          $model->tgl_awal = $model->bln_awal . "-01";
          $model->tgl_akhir = $bln_akhir;
          break;
        case 'tahun':
          $model->tgl_awal = $model->thn_awal . "-01-01";
          $model->tgl_akhir = $thn_akhir;
          break;
        default:
          null;
      }
      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $this->render('akuntansi.views.laporanAkuntansi._grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target)
  {
    $format = new MyFormatter();
    $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
    if (empty($model->tgl_awal)) {
      $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
    }
    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } elseif ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } elseif ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }
}
