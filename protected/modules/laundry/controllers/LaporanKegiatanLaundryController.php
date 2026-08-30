<?php

class LaporanKegiatanLaundryController extends MyAuthController
{

  public $path_view = 'laundry.views.laporan.';
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Kegiatan Laundry";
    $model = new LALaporankegiatanlaundryV('search');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->tgl_awal = date('d/m/Y', strtotime('first day of this month'));
    $model->tgl_akhir = date('d/m/Y');
    //		$model->jml_tampil = -1;

    if (isset($_GET['LALaporankegiatanlaundryV'])) {
      $model->attributes = $_GET['LALaporankegiatanlaundryV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['LALaporankegiatanlaundryV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LALaporankegiatanlaundryV']['tgl_akhir']);
      //			$model->jml_tampil = $_GET['LALaporankegiatanlaundryV']['jml_tampil'];

      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $this->render($this->path_view . 'kegiatanLaundry/index', array(
      'model' => $model, 'format' => $format
    ));
  }

  protected function printFunction($model, $caraPrint, $data, $judulLaporan, $target)
  {
    $format = new MyFormatter();
    $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);
    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data'=>$data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
      echo 'exit';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data'=>$data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data'=>$data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }


  public function actionPrintLaporanKegiatanLaundry()
  {
    $model = new LALaporankegiatanlaundryV('searchPrint');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->tgl_awal = date("d/m/Y", strtotime('first day of this month'));
    $model->tgl_akhir = date("d/m/Y");
    $judulLaporan = 'Laporan Kegiatan Laundry';
    

    $data['title'] = 'Grafik Laporan Kegiatan Laundry';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['LALaporankegiatanlaundryV'])) {
      $model->attributes = $_GET['LALaporankegiatanlaundryV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['LALaporankegiatanlaundryV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LALaporankegiatanlaundryV']['tgl_akhir']);

      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view . 'kegiatanLaundry/_printKegiatanLaundry';
    $this->printFunction($model, $caraPrint, $data, $judulLaporan, $target);
  }

  public function actionFrameGrafikKegiatanLaundry()
  {
    $this->layout = '//layouts/frameDialog';
    $model = new LALaporankegiatanlaundryV('searchGrafik');
    $format = new MyFormatter();
    $model->unsetAttributes();
    $model->tgl_awal = date("d/m/Y", strtotime('first day of this month'));
    $model->tgl_akhir = date("d/m/Y");
    // $judulLaporan = 'Laporan Kegiatan Laundry';

    $data['title'] = 'Grafik Laporan Kegiatan Laundry';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);

    if (isset($_REQUEST['LALaporankegiatanlaundryV'])) {
      $model->attributes = $_GET['LALaporankegiatanlaundryV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['LALaporankegiatanlaundryV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LALaporankegiatanlaundryV']['tgl_akhir']);

      $model->tgl_awal = $model->tgl_awal . " 00:00:00";
      $model->tgl_akhir = $model->tgl_akhir . " 23:59:59";
    }

    $this->render($this->path_view . 'kegiatanLaundry/_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

}
