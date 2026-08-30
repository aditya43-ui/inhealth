<?php
class LaporanCostCenterController extends MyAuthController
{
  public $path_view = 'akuntansi.views.laporanCostCenter.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Cost Revenue";
    $model = new AKLaporancostcenterV();
    $model->unsetAttributes();
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['AKLaporancostcenterV'])) {
      $model->attributes = $_GET['AKLaporancostcenterV'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['AKLaporancostcenterV']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['AKLaporancostcenterV']['tgl_akhir']);
    }
    $models = $model->findAll($model->searchLaporan());

    $this->render($this->path_view . 'admin', array('model' => $model, 'models' => $models));
  }

  public function actionPrint()
  {
    $model = new AKLaporancostcenterV();
    $model->unsetAttributes();
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['AKLaporancostcenterV'])) {
      $model->attributes = $_GET['AKLaporancostcenterV'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['AKLaporancostcenterV']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['AKLaporancostcenterV']['tgl_akhir']);
    }
    $models = $model->findAll($model->searchLaporan());

    $caraPrint = $_REQUEST['caraPrint'];
    $judulLaporan = 'LAPORAN COST CENTER';
    $periode = date('d', strtotime($model->tgl_awal)) . ' ' . MyFormatter::getMonthId(date('m', strtotime($model->tgl_awal))) . ' ' . date('Y', strtotime($model->tgl_awal)) . ' - ' . date('d', strtotime($model->tgl_akhir)) . ' ' . MyFormatter::getMonthId(date('m', strtotime($model->tgl_akhir))) . ' ' . date('Y', strtotime($model->tgl_akhir));
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . '_print', array('model' => $model, 'models' => $models,  'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . '_print', array('model' => $model, 'models' => $models,  'periode' => $periode, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');    //Ukuran Kertas Pdf
      $posisi = 'L';     //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      ////$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 0, 5, 15, 15);
      $mpdf->tMargin = 5;
      $mpdf->WriteHTML($this->renderPartial($this->path_view . '_print', array('model' => $model, 'models' => $models,  'periode' => $periode,  'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
