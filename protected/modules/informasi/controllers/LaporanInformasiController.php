<?php
class LaporanInformasiController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Informasi";  
    $this->render('index');
  }

  public function actionLaporanrekapsayhello()
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = new INLaporanrekapsayhelloV('searchSayHelloTable');
    $model->unsetAttributes();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    if (isset($_GET['INLaporanrekapsayhelloV'])) {
      $model->attributes = $_GET['INLaporanrekapsayhelloV'];
      $model->tgl_awal = isset($_GET['INLaporanrekapsayhelloV']['tgl_awal']) ? $format->formatDateTimeForDb($_GET['INLaporanrekapsayhelloV']['tgl_awal']) : date('Y-m-d');
      $model->tgl_akhir = isset($_GET['INLaporanrekapsayhelloV']['tgl_akhir']) ? $format->formatDateTimeForDb($_GET['INLaporanrekapsayhelloV']['tgl_akhir']) : date('Y-m-d');
    }
    $this->render('laporanrekapsayhello/index', array(
      'model' => $model,
      'format' => $format
    ));
  }

  public function actionPrintLaporanrekapsayhello()
  {
    $model = new INLaporanrekapsayhelloV('searchSayHelloTable');
    $format = new MyFormatter();
    if (isset($_REQUEST['INLaporanrekapsayhelloV'])) {
      $model->attributes = $_REQUEST['INLaporanrekapsayhelloV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['INLaporanrekapsayhelloV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['INLaporanrekapsayhelloV']['tgl_akhir']);
    }
    $judulLaporan = 'REKAPITULASI "SAY HELLO"';
    //Data Grafik
    $data['title'] = 'REKAPITULASI "SAY HELLO"';
    $data['judulLaporan'] = 'REKAPITULASI "SAY HELLO"';
    $data['periode'] = 'Periode : ' . MyFormatter::formatDateTimeId($model->tgl_awal) . ' s/d ' . MyFormatter::formatDateTimeId($model->tgl_akhir);
    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'laporanrekapsayhello/_print';
    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionLaporanrekappengaduan()
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = new INLaporanrekappengaduanV('searchPengaduanTable');
    $model->unsetAttributes();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    if (isset($_GET['INLaporanrekappengaduanV'])) {
      $model->attributes = $_GET['INLaporanrekappengaduanV'];
      $model->tgl_awal = isset($_GET['INLaporanrekappengaduanV']['tgl_awal']) ? $format->formatDateTimeForDb($_GET['INLaporanrekappengaduanV']['tgl_awal']) : date('Y-m-d');
      $model->tgl_akhir = isset($_GET['INLaporanrekappengaduanV']['tgl_akhir']) ? $format->formatDateTimeForDb($_GET['INLaporanrekappengaduanV']['tgl_akhir']) : date('Y-m-d');
    }
    $this->render('laporanrekappengaduan/index', array(
      'model' => $model,
      'format' => $format
    ));
  }

  public function actionPrintLaporanrekappengaduan()
  {
    $model = new INLaporanrekappengaduanV('searchPengaduanTable');
    $format = new MyFormatter();
    if (isset($_REQUEST['INLaporanrekappengaduanV'])) {
      $model->attributes = $_REQUEST['INLaporanrekappengaduanV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['INLaporanrekappengaduanV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['INLaporanrekappengaduanV']['tgl_akhir']);
    }
    $judulLaporan = 'REKAPITULASI PENGADUAN RUMAH SAKIT';
    //Data Grafik
    $data['title'] = 'REKAPITULASI PENGADUAN RUMAH SAKIT';
    $data['judulLaporan'] = 'REKAPITULASI PENGADUAN RUMAH SAKIT';
    $data['periode'] = 'Periode : ' . MyFormatter::formatDateTimeId($model->tgl_awal) . ' s/d ' . MyFormatter::formatDateTimeId($model->tgl_akhir);
    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'laporanrekappengaduan/_print';
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
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');          //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');               //Posisi L->Landscape,P->Portait
      ob_end_clean();
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
