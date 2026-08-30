<?php

class LaporanTransaksiPetugasPembayaranController extends MyAuthController
{
  public $path_view = "keuangan.views.laporanTransaksiPetugasPembayaran.";

  public $is_umum = true;

  public function actionIndex()
  {
    $format = new MyFormatter();
    $model = new VerifikasipetugasbillingV();
    $model->unsetAttributes();
    $model->tgl_awal = date('Y-m-d H:i:s');
    $model->tgl_akhir = date('Y-m-d H:i:s');
    $model->is_umum = $this->is_umum;
    $model->create_loginpemakai_id = Yii::app()->user->id;
    if (isset($_GET['VerifikasipetugasbillingV'])) {
      $model->attributes = $_GET['VerifikasipetugasbillingV'];
      $model->billing = $_GET['VerifikasipetugasbillingV']['billing'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['VerifikasipetugasbillingV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['VerifikasipetugasbillingV']['tgl_akhir']);
    }

    $this->render($this->path_view . 'admin', array(
      'model' => $model,
    ));
  }

  public function actionPrintLaporan()
  {
    $format = new MyFormatter();

    $model = new VerifikasipetugasbillingV();
    $model->unsetAttributes();
    $model->is_umum = $this->is_umum;
    $model->create_loginpemakai_id = Yii::app()->user->id;

    $judulLaporan = 'LAPORAN KASIR';

    if (!$this->is_umum) {
      $judulLaporan = 'LAPORAN PIUTANG';
    }

    //Data Grafik
    $data['title'] = 'Laporan Penerimaan Kasir';
    $data['type'] = (isset($_REQUEST['type']) ? $_REQUEST['type'] : null);
    if (isset($_REQUEST['VerifikasipetugasbillingV'])) {
      $model->attributes = $_REQUEST['VerifikasipetugasbillingV'];
      $model->billing = $_GET['VerifikasipetugasbillingV']['billing'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['VerifikasipetugasbillingV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['VerifikasipetugasbillingV']['tgl_akhir']);

      if ($model->billing == "rj") {
        $judulLaporan .= " - RAWAT JALAN";
      }
      if ($model->billing == "ri") {
        $judulLaporan .= " - RAWAT INAP";
      }
      if ($model->billing == "rd") {
        $judulLaporan .= " - RAWAT DARURAT";
      }

    }

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view.'_print';

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
      $mpdf->AddPage($posisi, '', '', '', '', 10, 10, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));

      $mpdf->Output($judulLaporan.".pdf", 'I');
    }
  }
}
