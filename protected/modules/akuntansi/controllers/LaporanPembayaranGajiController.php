<?php

class LaporanPembayaranGajiController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pembayaran Gaji";
    $format = new MyFormatter();
    $model = new AKLaporanpembayarangajiV('searchLaporan');
    $model->unsetAttributes();
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    if (isset($_GET['AKLaporanpembayarangajiV'])) {
      $model->attributes = $_GET['AKLaporanpembayarangajiV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['AKLaporanpembayarangajiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKLaporanpembayarangajiV']['tgl_akhir']);
    }

    $this->render('index', array(
      'model' => $model,
    ));
  }

  public function actionPrint()
  {
    $format = new MyFormatter();
    $model = new AKLaporanpembayarangajiV('searchLaporan');
    $judulLaporan = 'Laporan Pembayaran Gaji Pegawai';
    //Data Grafik
    $data['title'] = 'Laporan Pembayaran Gaji Pegawai';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['AKLaporanpembayarangajiV'])) {
      $model->attributes = $_REQUEST['AKLaporanpembayarangajiV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['AKLaporanpembayarangajiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['AKLaporanpembayarangajiV']['tgl_akhir']);
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
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 30, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
