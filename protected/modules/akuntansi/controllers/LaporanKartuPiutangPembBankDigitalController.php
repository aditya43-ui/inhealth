<?php

class LaporanKartuPiutangPembBankDigitalController extends MyAuthController
{
  public $path_view = 'akuntansi.views.laporanKartuPiutangPembBankDigital.';

  public function actionIndex()
  {
    $model = new AKLaporankartupiutangpembbankdigitalV();
    $model->tgl_awal = date('d F Y');
    $model->tgl_akhir = date('d F Y');
    $format = new MyFormatter();

    if (isset($_GET['AKLaporankartupiutangpembbankdigitalV'])) {
      $model->attributes = $_GET['AKLaporankartupiutangpembbankdigitalV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['AKLaporankartupiutangpembbankdigitalV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKLaporankartupiutangpembbankdigitalV']['tgl_akhir']);
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model, 'format' => $format
    ));
  }

  /**
   * Menampilkan printout Kartu Hutang
   */
  public function actionPrint()
  {
    $model = new AKLaporankartupiutangpembbankdigitalV();
    $model->tgl_awal = date('d F Y');
    $model->tgl_akhir = date('d F Y');
    $format = new MyFormatter();

    if (isset($_GET['AKLaporankartupiutangpembbankdigitalV'])) {
      $model->attributes = $_GET['AKLaporankartupiutangpembbankdigitalV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['AKLaporankartupiutangpembbankdigitalV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['AKLaporankartupiutangpembbankdigitalV']['tgl_akhir']);
    }

    $judulLaporan = 'LAPORAN KARTU PENERIMAAN PEMBAYARAN PIUTANG BANK & PEMBAYARAN DIGITAL';
    $data['title'] = '';

    $caraPrint = $_REQUEST['caraPrint'];
    $target = $this->path_view . '_print';

    $periode = $format->formatDateTimeId($model->tgl_awal) . ' s/d ' . $format->formatDateTimeId($model->tgl_akhir);

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array(), true));
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($target, array('model' => $model, 'periode' => $periode, 'data' => $data, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }
}
