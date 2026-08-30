<?php

class LaporanPengirimanLinenController extends MyAuthController
{
  public $path_view = 'laundry.views.laporan.';
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Pengiriman Linen";
    $model = new LALaporanpengirimanlinenV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->tgl_awal = date('d/m/Y', strtotime('first day of this month'));
    $model->tgl_akhir = date('d/m/Y');
    //		$model->jml_tampil = -1;

    if (isset($_GET['LALaporanpengirimanlinenV'])) {
      $model->attributes = $_GET['LALaporanpengirimanlinenV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['LALaporanpengirimanlinenV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LALaporanpengirimanlinenV']['tgl_akhir']);
      //			$model->jml_tampil = $_GET['LALaporanpengirimanlinenV']['jml_tampil'];

      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $this->render($this->path_view . 'pengirimanLinen/index', array(
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
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode,  'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }


  public function actionPrintLaporanPengirimanLinen()
  {
    $model = new LALaporanpengirimanlinenV('searchPrint');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->tgl_awal = date("d/m/Y", strtotime('first day of this month'));
    $model->tgl_akhir = date("d/m/Y");

    $judulLaporan = 'Laporan Pengiriman Linen';
    if (isset($_REQUEST['LALaporanpengirimanlinenV'])) {
      $model->attributes = $_GET['LALaporanpengirimanlinenV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['LALaporanpengirimanlinenV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LALaporanpengirimanlinenV']['tgl_akhir']);

      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view . 'pengirimanLinen/_printPengirimanLinen';
    $this->printFunction($model, $caraPrint, $judulLaporan, $target);
  }
}
