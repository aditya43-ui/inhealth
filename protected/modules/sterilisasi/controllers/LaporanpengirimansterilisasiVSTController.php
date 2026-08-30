<?php

class LaporanpengirimansterilisasiVSTController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pengiriman Sterilisasi";
    $model = new STLaporanpengirimansterilisasiV('search');
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    if (isset($_GET['STLaporanpengirimansterilisasiV'])) {
      $model->attributes = $_GET['STLaporanpengirimansterilisasiV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['STLaporanpengirimansterilisasiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['STLaporanpengirimansterilisasiV']['tgl_akhir']);
    }

    $this->render('index', array(
      'model' => $model,
    ));
  }

  public function actionPrintLaporanPengirimanSterilisasi()
  {
    $model = new STLaporanpengirimansterilisasiV('search');
    $judulLaporan = 'Laporan Pengiriman Sterilisasi';

    //Data Grafik
    $data['title'] = 'Grafik Laporan Pengiriman Sterilisasi';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['STLaporanpengirimansterilisasiV'])) {
      $model->attributes = $_REQUEST['STLaporanpengirimansterilisasiV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['STLaporanpengirimansterilisasiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['STLaporanpengirimansterilisasiV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = '_print';
    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanPengirimanSterilisasi()
  {
    $this->layout = '//layouts/iframe';
    $model = new STLaporanpengirimansterilisasiV('search');
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Pengiriman Sterilisasi';
    $data['type'] = isset($_GET['type']) ? $_GET['type'] : null;
    if (isset($_GET['STLaporanpengirimansterilisasiV'])) {
      $model->attributes = $_GET['STLaporanpengirimansterilisasiV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['STLaporanpengirimansterilisasiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['STLaporanpengirimansterilisasiV']['tgl_akhir']);
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
      //$mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
