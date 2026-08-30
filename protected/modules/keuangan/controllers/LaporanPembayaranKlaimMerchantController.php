<?php

class LaporanPembayaranKlaimMerchantController extends MyAuthController
{
  public function actionIndex()
  {
    $format = new MyFormatter();
    $model = new KUInformasipembayaranklaimmerchantV();
    $model->unsetAttributes();
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    if (isset($_GET['KUInformasipembayaranklaimmerchantV'])) {
      $model->attributes = $_GET['KUInformasipembayaranklaimmerchantV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KUInformasipembayaranklaimmerchantV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KUInformasipembayaranklaimmerchantV']['tgl_akhir']);
    }

    $this->render('index', array(
      'model' => $model,
    ));
  }
  public function actionPrint()
  {
    $format = new MyFormatter();
    $model = new KUInformasipembayaranklaimmerchantV();
    $judulLaporan = 'Laporan Pembayaran Klaim Merchant';
    //Data Grafik
    $data['title'] = 'Laporan Pembayaran Klaim Merchant';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['KUInformasipembayaranklaimmerchantV'])) {
      $model->attributes = $_REQUEST['KUInformasipembayaranklaimmerchantV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['KUInformasipembayaranklaimmerchantV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['KUInformasipembayaranklaimmerchantV']['tgl_akhir']);
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
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
