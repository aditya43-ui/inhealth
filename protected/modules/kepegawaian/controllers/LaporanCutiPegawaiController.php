<?php

class LaporanCutiPegawaiController extends MyAuthController
{
  public $path_view = 'kepegawaian.views.laporanCutiPegawai.';
  public $defaultAction = 'admin';

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $this->pageTitle = Yii::app()->name . " - Cuti Pegawai";
    $model = new LaporancutipegawaiV('search');
    $model->unsetAttributes();  // clear any default values

    $model->tgl_awal = date('Y-m-01');
    $model->tgl_akhir = date('Y-m-t');

    if (isset($_GET['LaporancutipegawaiV'])) {
      $model->attributes = $_GET['LaporancutipegawaiV'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($model->tgl_awal);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($model->tgl_akhir);
    }

    $this->render($this->path_view . 'admin', array(
      'model' => $model,
    ));
  }


  public function actionPrint($caraPrint = null)
  {
    $this->layout = '//layouts/printWindows';
    $model = new LaporancutipegawaiV('search');
    $model->unsetAttributes();  // clear any default values

    $periode = "";

    if (isset($_GET['LaporancutipegawaiV'])) {
      $model->attributes = $_GET['LaporancutipegawaiV'];


      $model->tgl_awal = MyFormatter::formatDateTimeForDb($model->tgl_awal);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($model->tgl_akhir);

      $periode = MyFormatter::formatDateTimeForUser($model->tgl_awal) . " - " . MyFormatter::formatDateTimeForUser($model->tgl_akhir);
    }

    $judulLaporan = "Laporan Cuti Pegawai";

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . '_print', array(
        'model' => $model,
        'judulLaporan' => $judulLaporan,
        'periode' => $periode,
        'caraPrint' => $caraPrint
      ));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . '_print', array(
        'model' => $model,
        'judulLaporan' => $judulLaporan,
        'periode' => $periode,
        'caraPrint' => $caraPrint
      ));
    } else if ($caraPrint == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . '_print', array(
        'model' => $model,
        'judulLaporan' => $judulLaporan,
        'periode' => $periode,
        'caraPrint' => $caraPrint
      ), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }
}
