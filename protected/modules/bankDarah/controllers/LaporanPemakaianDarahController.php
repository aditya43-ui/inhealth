<?php

class LaporanPemakaianDarahController extends MyAuthController
{
  public $path_view = 'bankDarah.views.laporanPemakaianDarah.';

  /**
   * Load Data Laporan stok kantong darah
   */
  public function actionIndex()
  {
    $model = new BDLaporanpermintaandarahpasienV();
    $format = new MyFormatter();

    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['BDLaporanpermintaandarahpasienV'])) {
      $model->attributes = $_GET['BDLaporanpermintaandarahpasienV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanpermintaandarahpasienV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanpermintaandarahpasienV']['tgl_akhir']);
    }
    $this->render(
      $this->path_view . 'index',
      array(
        'model' => $model,
      )
    );
  }

  public function actionPrint()
  {

    $model = new BDLaporanpermintaandarahpasienV();

    $format = new MyFormatter();
    if (isset($_GET['BDLaporanpermintaandarahpasienV'])) {
      $model->attributes = $_GET['BDLaporanpermintaandarahpasienV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDLaporanpermintaandarahpasienV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDLaporanpermintaandarahpasienV']['tgl_akhir']);
    }
    $judulLaporan = 'Laporan Pemakaian Darah';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF6060('', $ukuranKertasPDF);
      ////$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
