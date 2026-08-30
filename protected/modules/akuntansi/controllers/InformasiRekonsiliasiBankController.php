<?php

class InformasiRekonsiliasiBankController extends MyAuthController
{
  protected $path_view = 'akuntansi.views.informasiRekonsiliasiBank.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Rekonsiliasi Bank";
    $format = new MyFormatter();
    $model = new AKInformasirekonsiliasibankV;
    $model->tgl_awal = date("Y-m-d");
    $model->tgl_akhir = date("Y-m-d");

    if (isset($_GET['AKInformasirekonsiliasibankV'])) {
      $model->attributes = $_GET['AKInformasirekonsiliasibankV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['AKInformasirekonsiliasibankV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKInformasirekonsiliasibankV']['tgl_akhir']);
    }

    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'model' => $model
    ));
  }

  public function actionPrint()
  {
    $format = new MyFormatter();
    $model = new AKInformasirekonsiliasibankV;
    $model->tgl_awal = date("Y-m-d");
    $model->tgl_akhir = date("Y-m-d");

    if (isset($_GET['AKInformasirekonsiliasibankV'])) {
      $model->attributes = $_GET['AKInformasirekonsiliasibankV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['AKInformasirekonsiliasibankV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKInformasirekonsiliasibankV']['tgl_akhir']);
    }

    $judulLaporan = 'Jurnal Kelompok Bahan Makanan';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      // //$mpdf->useOddEven = 2;  

      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
