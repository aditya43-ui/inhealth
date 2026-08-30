<?php

/**
 * @modifiedBy	M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 */
class LaporanRealisasiLemburController extends MyAuthController
{
  public $path_view = 'kepegawaian.views.realisasiLembur.';
  public $defaultAction = 'admin';

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $this->pageTitle = Yii::app()->name . " - Realisasi Lembur";
    $model = new LaporanrealisasilemburV('search');
    $model->unsetAttributes();  // clear any default values

    $model->tgl_awal = date('Y-m-01');
    $model->tgl_akhir = date('Y-m-t');

    if (isset($_GET['LaporanrealisasilemburV'])) {
      $model->attributes = $_GET['LaporanrealisasilemburV'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($model->tgl_awal);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($model->tgl_akhir);
    }

    $this->render('admin', array(
      'model' => $model,
    ));
  }

  public function actionPrint($caraPrint = null)
  {
    $this->layout = '//layouts/printWindows';
    $model = new LaporanrealisasilemburV('search');
    $model->unsetAttributes();  // clear any default values

    $periode = "";

    if (isset($_GET['LaporanrealisasilemburV'])) {
      $model->attributes = $_GET['LaporanrealisasilemburV'];


      $model->tgl_awal = MyFormatter::formatDateTimeForDb($model->tgl_awal);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($model->tgl_akhir);

      $periode = MyFormatter::formatDateTimeForUser($model->tgl_awal) . " - " . MyFormatter::formatDateTimeForUser($model->tgl_akhir);
    }

    $judulLaporan = "Laporan Realisasi Lembur";

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('_print', array(
        'model' => $model,
        'judulLaporan' => $judulLaporan,
        'periode' => $periode,
        'caraPrint' => $caraPrint
      ));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('_print', array(
        'model' => $model,
        'judulLaporan' => $judulLaporan,
        'periode' => $periode,
        'caraPrint' => $caraPrint
      ));
    } else if ($caraPrint == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('_print', array(
        'model' => $model,
        'judulLaporan' => $judulLaporan,
        'periode' => $periode,
        'caraPrint' => $caraPrint
      ), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }
}
