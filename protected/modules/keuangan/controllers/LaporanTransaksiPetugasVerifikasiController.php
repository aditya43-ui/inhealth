<?php

class LaporanTransaksiPetugasVerifikasiController extends MyAuthController
{
  public $path_view = "keuangan.views.laporanTransaksiPetugasVerifikasi.";

  public function actionIndex()
  {
    $format = new MyFormatter();
    $model = new VerifikasipetugaskeuanganV();
    $model->unsetAttributes();
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    $model->pegawai_id = Yii::app()->user->getState('pegawai_id');
    if (isset($_GET['VerifikasipetugaskeuanganV'])) {
      $model->attributes = $_GET['VerifikasipetugaskeuanganV'];
      $model->billing = $_GET['VerifikasipetugaskeuanganV']['billing'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['VerifikasipetugaskeuanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['VerifikasipetugaskeuanganV']['tgl_akhir']);
    }

    $this->render($this->path_view . 'admin', array(
      'model' => $model,
    ));
  }

  public function actionPrintLaporan()
  {
    $format = new MyFormatter();
    $model = new VerifikasipetugaskeuanganV();
    $judulLaporan = 'LAPORAN VERIFIKASI';
    //Data Grafik
    $data['title'] = 'Laporan Penerimaan Kas';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    $model->pegawai_id = Yii::app()->user->getState('pegawai_id');
    if (isset($_REQUEST['VerifikasipetugaskeuanganV'])) {
      $model->attributes = $_REQUEST['VerifikasipetugaskeuanganV'];
      $model->billing = $_GET['VerifikasipetugaskeuanganV']['billing'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['VerifikasipetugaskeuanganV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['VerifikasipetugaskeuanganV']['tgl_akhir']);
    }

    if (isset($_REQUEST['VerifikasipetugaskeuanganV']['billing'])) {
      $billing = $_REQUEST['VerifikasipetugaskeuanganV']['billing'];
      
      if ($billing == "rj") {
        $judulLaporan .= " - RAWAT JALAN";
      } else if ($billing == "ri") {
        $judulLaporan .= " - RAWAT INAP";
      }
    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = '_print';

    $this->printFunction($model, $data, $caraPrint, $judulLaporan, $target);
  }

  protected function printFunction($model, $data, $caraPrint, $judulLaporan, $target)
  {
    $format = new MyFormatter();
    $periode = $format->formatDateTimeForUser($model->tgl_awal) . ' s/d ' . $format->formatDateTimeForUser($model->tgl_akhir);

    if($model->tgl_awal == $model->tgl_akhir) {
      $periode = $format->formatDateTimeForUser($model->tgl_awal);
    }

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
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->SetHTMLFooter('<span></span>');

      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));

      $mpdf->Output();
    }
  }
}
