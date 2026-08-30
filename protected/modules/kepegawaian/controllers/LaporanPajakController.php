<?php

class LaporanPajakController extends MyAuthController
{
  public $tgl_awal;
  public $tgl_akhir;

  public $path_view = 'kepegawaian.views.laporanPajak.';
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Pajak";
    $model = new KPLaporanpph21V('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->tgl_awal = date('d/m/Y', strtotime('first day of this month'));
    $model->tgl_akhir = date('d/m/Y');


    if (isset($_GET['KPLaporanpph21V'])) {
      $model->attributes = $_GET['KPLaporanpph21V'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KPLaporanpph21V']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KPLaporanpph21V']['tgl_akhir']);

      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $this->render($this->path_view . 'pajak/index', array(
      'model' => $model, 'format' => $format
    ));
  }

  protected function printFunction($model, $caraPrint, $judulLaporan, $target)
  {
    $format = new MyFormatter();
    $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }


  public function actionPrintLaporanPajak()
  {
    $model = new KPLaporanpph21V('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->tgl_awal = date("d/m/Y", strtotime('first day of this month'));
    $model->tgl_akhir = date("d/m/Y");

    $judulLaporan = 'Laporan Pajak';
    if (isset($_REQUEST['KPLaporanpph21V'])) {
      $model->attributes = $_GET['KPLaporanpph21V'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KPLaporanpph21V']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KPLaporanpph21V']['tgl_akhir']);

      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view . 'pajak/_printPajak';
    $this->printFunction($model, $caraPrint, $judulLaporan, $target);
  }
}
