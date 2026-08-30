<?php

class LaporanPembayaranGajiController extends MyAuthController
{
  public $path_view = 'keuangan.views.laporanPembayaranGaji.';
  public function actionIndex()
  {
    $format = new MyFormatter();
    $model = new KULaporanpembayarangajiV('searchLaporan');
    $model->unsetAttributes();
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    if (isset($_GET['KULaporanpembayarangajiV'])) {
      $model->attributes = $_GET['KULaporanpembayarangajiV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['KULaporanpembayarangajiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['KULaporanpembayarangajiV']['tgl_akhir']);
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model,
    ));
  }
  public function actionPrint()
  {
    $format = new MyFormatter();
    $model = new KULaporanpembayarangajiV('searchLaporan');
    $judulLaporan = 'Laporan Pembayaran Gaji Pegawai';
    //Data Grafik
    $data['title'] = 'Laporan Pembayaran Gaji Pegawai';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['KULaporanpembayarangajiV'])) {
      $model->attributes = $_REQUEST['KULaporanpembayarangajiV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['KULaporanpembayarangajiV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['KULaporanpembayarangajiV']['tgl_akhir']);
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = 'Print';

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
      $this->render($this->path_view . $target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . $target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $footer = '
            <table width="100%">
            <tr>'
        . '<td style = "text-align:left;font-size:12px;"><i><b>{PAGENO}</b></i></td>'
        . '</tr>
             <tr>'
        . '<td style = "text-align:right;font-size:12px;"><i><b>Created At : ' . MyFormatter::formatDateTimeId(date('Y-m-d H:i:s')) . '</b></i></td>'
        . '<td style = "text-align:right;font-size:12px;"><i><b>Created By : ' . $this->pageTitle = Yii::app()->user->nama_pemakai . ' </b></i></td>'
        . '</tr>
            </table>';
      $mpdf->SetHtmlFooter($footer, 'E');
      $mpdf->SetHtmlFooter($footer, 'O');
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
