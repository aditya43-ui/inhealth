<?php

class LaporanPerPetugasController extends MyAuthController
{
  public $path_view = 'rawatJalan.views.laporanPerPetugas.';

  public function actionAdmin()
  {
    $this->pageTitle = Yii::app()->name . " - Laporan Input Transaksi Per Petugas";
    $model = new LaporantransaksipetugasV('search');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->pegawai_id = Yii::app()->user->getState('pegawai_id');

    if (isset($_GET['LaporantransaksipetugasV'])) {
      $model->attributes = $_GET['LaporantransaksipetugasV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['LaporantransaksipetugasV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LaporantransaksipetugasV']['tgl_akhir']);

    }

    if (Yii::app()->request->isAjaxRequest) {
      echo $this->renderPartial($this->path_view . '_table', array('model' => $model), true);
    } else {
      $this->render($this->path_view . 'admin', array(
        'model' => $model,
      ));
    }
  }

  public function actionPrintLaporan()
  {
    $model = new LaporantransaksipetugasV('search');
    $model->tgl_awal = date('Y-m-d', strtotime('first day of this month'));
    $model->tgl_akhir = date('Y-m-d');
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->pegawai_id = Yii::app()->user->getState('pegawai_id');
    $judulLaporan = ' Laporan Input Transaksi Per Petugas';
    $format = new MyFormatter();
    //Data Grafik       
    $data['title'] = 'Laporan Input Transaksi Per Petugas';
    $data['type'] = isset($_REQUEST['type']) ? $_REQUEST['type'] : null;

    if (isset($_REQUEST['LaporantransaksipetugasV'])) {
      $model->attributes = $_REQUEST['LaporantransaksipetugasV'];
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['LaporantransaksipetugasV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['LaporantransaksipetugasV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view . '_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
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
        $stylesheet1 = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
        $mpdf->WriteHTML($stylesheet1, 1);
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->setHtmlFooter('<span></span>');
        $mpdf->AddPage($posisi, '', '', '', '', 5, 5, 15, 25, 15, 15);
        $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
        $mpdf->Output($judulLaporan . '-' . date('Y/m/d') . '.pdf', 'I');
      }
    }
  
}