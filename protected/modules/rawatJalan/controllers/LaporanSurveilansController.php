<?php

/**
 * Menampilkan Laporan Surveilance HAis
 *
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 */
class LaporanSurveilansController extends MyAuthController
{
  public $path_view = "rawatJalan.views.laporanSurveilans.";

  public function actionLaporanSurveilans()
  {
    $model = new RJLaporansurveilansV();
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->instalasi_id = Yii::app()->user->getState('instalasi_id');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->jumlah_tampil = 1;
    if (isset($_GET['RJLaporansurveilansV'])) {
      $model->attributes = $_GET['RJLaporansurveilansV'];
      $model->instalasi_id = $_GET['RJLaporansurveilansV']['instalasi_id'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['RJLaporansurveilansV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeFOrDb($_GET['RJLaporansurveilansV']['tgl_akhir']);
    }

    $this->render($this->path_view . 'admin', array(
      'model' => $model,
      'format' => $format,
    ));
  }

  public function actionPrintLaporanSurveilans()
  {
    $format = new MyFormatter();
    $model = new RJLaporansurveilansV();

    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->jumlah_tampil = 1;
    //Data Grafik
    $data['title'] = 'Grafik Laporan Surveilans Hais';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['RJLaporansurveilansV'])) {
      $model->attributes = $_REQUEST['RJLaporansurveilansV'];
      $model->instalasi_id = $_REQUEST['RJLaporansurveilansV']['instalasi_id'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RJLaporansurveilansV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RJLaporansurveilansV']['tgl_akhir']);
    }

    if ($_REQUEST['RJLaporansurveilansV']['pilihan_tab'] == 'report') {
      $judulLaporan = 'Laporan Surveilans Hais';
      $target = $this->path_view . '_print';
      $caraPrint = $_REQUEST['caraPrint'];
    } else if ($_REQUEST['RJLaporansurveilansV']['pilihan_tab'] == 'rekap') {
      $judulLaporan = 'Laporan Surveilans Hais';
      $target = $this->path_view . '_printRekap';
      $caraPrint = $_REQUEST['caraPrint'];
    } else if ($_REQUEST['RJLaporansurveilansV']['pilihan_tab'] == 'hitung') {
      $judulLaporan = 'Laporan Surveilans Hais';
      $target = $this->path_view . '_printHitung';
      $caraPrint = $_REQUEST['caraPrint'];
    }

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikSurveilans()
  {
    $this->layout = '//layouts/iframe';
    $model = new RJLaporansurveilansV;
    $model->tgl_awal = date('d M Y H:i:s');
    $model->tgl_akhir = date('d M Y H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Surveilans';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);

    if (isset($_GET['RJLaporansurveilansV'])) {
      $model->attributes = $_GET['RJLaporansurveilansV'];
      $format = new MyFormatter();
    }

    $this->render($this->path_view . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target)
  {
    $format = new MyFormatter();
    $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);

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
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A5.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '-' . date('Y/m/d') . '.pdf', 'I');
    }
  }
}
