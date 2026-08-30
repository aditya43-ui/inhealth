<?php

/**
 * Digunakan sebagai informasi stok kantong darah
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.modules.bankDarah
 * @subpackage controllers
 * @category controller
 */
class LaporanStokKantongDarahController extends MyAuthController
{
  public $path_view = 'bankDarah.views.laporanStokKantongDarah.';

  /**
   * Load Data Laporan stok kantong darah
   */
  public function actionIndex()
  {
    $model = new BDInformasiStokKantongDarahV();
    $format = new MyFormatter();

    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['BDInformasiStokKantongDarahV'])) {
      $model->attributes = $_GET['BDInformasiStokKantongDarahV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDInformasiStokKantongDarahV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDInformasiStokKantongDarahV']['tgl_akhir']);
      $model->singkatan_komp = $_GET['BDInformasiStokKantongDarahV']['singkatan_komp'];
      $model->gol_darah = $_GET['BDInformasiStokKantongDarahV']['gol_darah'];
    }
    $this->render(
      'index',
      array(
        'model' => $model,
      )
    );
  }

  public function actionPrint()
  {

    $model = new BDInformasiStokKantongDarahV();

    $format = new MyFormatter();
    if (isset($_GET['BDInformasiStokKantongDarahV'])) {
      $model->attributes = $_GET['BDInformasiStokKantongDarahV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['BDInformasiStokKantongDarahV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BDInformasiStokKantongDarahV']['tgl_akhir']);
      $model->singkatan_komp = $_GET['BDInformasiStokKantongDarahV']['singkatan_komp'];
      $model->gol_darah = $_GET['BDInformasiStokKantongDarahV']['gol_darah'];
    }
    $judulLaporan = 'Laporan Stok Kantong Darah';
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
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      ////$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
      //            $kertas = Params::getUkuranKertas();
      //            $mpdf = new MyPDF60('', $kertas['F4']);
      //            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait                
      //            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinoutTable.css');
      //            $mpdf->WriteHTML($stylesheet, 1);
      //            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot') . '/themes/neon18/assets/css/custom.css');
      //            $mpdf->WriteHTML($stylesheet, 1);
      //            $mpdf->AddPage(Params::DEFAULT_KERTAS_POSISI, '', '', '', '', 20, 20, 20, 20, 20, 20);
      //            $mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('model' => $model,'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      //            $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }
}
