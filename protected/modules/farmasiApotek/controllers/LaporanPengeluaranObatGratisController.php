<?php

class LaporanPengeluaranObatGratisController extends MyAuthController
{
  public function actionIndex()
  {
    $format = new MyFormatter;
    $model = new FALaporanpengeluaranobatgratisV;
    $model->tgl_awal = date("d M Y");
    $model->tgl_akhir = date("d M Y");

    if (isset($_GET['FALaporanpengeluaranobatgratisV'])) {
      $model->attributes = $_GET['FALaporanpengeluaranobatgratisV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpengeluaranobatgratisV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpengeluaranobatgratisV']['tgl_akhir']);
    }

    $this->render('index', array(
      'format' => $format,
      'model' => $model,
    ));
  }

  public function actionPrint()
  {
    $format = new MyFormatter;
    $model = new FALaporanpengeluaranobatgratisV;
    $model->tgl_awal = date("d M Y");
    $model->tgl_akhir = date("d M Y");

    if (isset($_GET['FALaporanpengeluaranobatgratisV'])) {
      $model->attributes = $_GET['FALaporanpengeluaranobatgratisV'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['FALaporanpengeluaranobatgratisV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['FALaporanpengeluaranobatgratisV']['tgl_akhir']);
    }
    $judulLaporan = 'Laporan Pengeluaran Obat Gratis';
    $data['title'] = 'Grafik Laporan Pengeluaran Obat Gratis';
    $data['type'] = $_REQUEST['type'];
    $data['nama_pegawai'] = LoginpemakaiK::model()->findByPk(Yii::app()->user->id)->pegawai->nama_pegawai;
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == "PRINTRINCIAN") {
      $caraPrint = 'PRINT';
      $data['rincian'] = true;
    }
    $target = 'print';

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
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
