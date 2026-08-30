<?php

class LaporanJasaDokterController extends MyAuthController
{
  public $path_view = 'penggajian.views.laporanJasaDokter.';
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pembayaran Jasa Medis";
    $format = new MyFormatter();
    $model = new GJLaporanpembayaranjasadokterV('searchLaporan');
    $model->unsetAttributes();
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    if (isset($_GET['GJLaporanpembayaranjasadokterV'])) {
      $model->attributes = $_GET['GJLaporanpembayaranjasadokterV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GJLaporanpembayaranjasadokterV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GJLaporanpembayaranjasadokterV']['tgl_akhir']);
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model,
    ));
  }
  public function actionPrint()
  {
    $format = new MyFormatter();
    $model = new GJLaporanpembayaranjasadokterV('searchLaporan');
    $judulLaporan = 'Laporan Jasa Dokter';
    //Data Grafik
    $data['title'] = 'Grafik Laporan Jasa Dokter';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['GJLaporanpembayaranjasadokterV'])) {
      $model->attributes = $_REQUEST['GJLaporanpembayaranjasadokterV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['GJLaporanpembayaranjasadokterV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GJLaporanpembayaranjasadokterV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'Print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target)
  {
    $format = new MyFormatter();
    $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
    if (empty($model->tgl_awal)) {
      $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
    }
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . $target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . $target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . $target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
