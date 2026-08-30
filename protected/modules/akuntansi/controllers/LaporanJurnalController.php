<?php
class LaporanJurnalController extends MyAuthController
{
  public $path_view = 'akuntansi.views.laporanJurnal.';

  public function actionIndex()
  {
    $model = new AKLaporanJurnalV;
    $model->unsetAttributes();
    $model->tgl_awal = date('d M Y 00:00:00');
    $model->tgl_akhir = date('d M Y H:i:s');
    if (isset($_GET['AKLaporanJurnalV'])) {
      $model->attributes = $_GET['AKLaporanJurnalV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['AKLaporanJurnalV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKLaporanJurnalV']['tgl_akhir']);
    }
    $this->render($this->path_view . 'admin', array('model' => $model));
  }

  public function actionPrintLaporanJurnal()
  {
    $model = new AKLaporanJurnalV('searchPrint');
    $judulLaporan = 'Laporan Jurnal';

    //Data Grafik       
    $data['title'] = 'Grafik Laporan Jurnal Berdasarkan Jenis Jurnal';
    $data['type'] = $_REQUEST['type'];
    if (isset($_REQUEST['AKLaporanJurnalV'])) {
      $model->attributes = $_REQUEST['AKLaporanJurnalV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['AKLaporanJurnalV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['AKLaporanJurnalV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view . '_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  public function actionFrameGrafikLaporanJurnal()
  {
    $this->layout = '//layouts/iframe';
    $model = new AKLaporanJurnalV('search');
    $model->tgl_awal = date('d M Y 00:00:00');
    $model->tgl_akhir = date('d M Y H:i:s');

    //Data Grafik
    $data['title'] = 'Grafik Laporan Jurnal Berdasarkan Jenis Jurnal';
    $data['type'] = $_GET['type'];
    if (isset($_GET['AKLaporanJurnalV'])) {
      $model->attributes = $_GET['AKLaporanJurnalV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['AKLaporanJurnalV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKLaporanJurnalV']['tgl_akhir']);
    }

    $this->render($this->path_view . '_grafik', array(
      'model' => $model,
      'data' => $data,
    ));
  }

  protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target)
  {
    $format = new MyFormatter();
    $periode = $this->parserTanggal($model->tgl_awal) . ' s/d ' . $this->parserTanggal($model->tgl_akhir);

    if ($caraPrint == 'PRINT' || $caraPrint == 'GRAFIK') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');    //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');     //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      ////$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  protected function parserTanggal($tgl)
  {
    $tgl = explode(' ', $tgl);
    $result = array();
    foreach ($tgl as $row) {
      if (!empty($row)) {
        $result[] = $row;
      }
    }
    return Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($result[0], 'yyyy-MM-dd'), 'medium', null) . ' ' . $result[1];
  }
}
