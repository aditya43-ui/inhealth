<?php
Yii::import('rawatDarurat.models.*');
class RiwayatBPJSController extends MyAuthController
{
  public $path_view = 'pendaftaranPenjadwalan.views.riwayatBPJS.';
  public $rujukantersimpan = false;
  public $asuransipasientersimpan = false;
  public $septersimpan = false;

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Riwayat BPJS";
    $format = new MyFormatter();
    $model = new InformasibpjslogV;
    $model->tgl_awal  = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    if (isset($_REQUEST['InformasibpjslogV'])) {
      $model->attributes = $_REQUEST['InformasibpjslogV'];
      $model->tgl_awal  = MyFormatter::formatDateTimeForDb($_REQUEST['InformasibpjslogV']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_REQUEST['InformasibpjslogV']['tgl_akhir']);
    }
    $this->render($this->path_view . 'index', array('format' => $format, 'model' => $model));
  }

  public function actionPrintRiwayatBpjs()
  {
    $model = new InformasibpjslogV;
    $model->tgl_awal  = isset($_GET['tgl_awal']) ? MyFormatter::formatDateTimeForDb($_GET['tgl_awal']) : date('Y-m-d');
    $model->tgl_akhir = isset($_GET['tgl_akhir']) ? MyFormatter::formatDateTimeForDb($_GET['tgl_akhir']) : date('Y-m-d');

    $model->no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : "";
    $model->json_request_respose = isset($_GET['json']) ? $_GET['json'] : "";

    $caraPrint = $_GET['caraprint'];
    $judulLaporan = 'RIWAYAT BPJS LOG';
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printRiwayat', array('model' => $model, 'caraPrint' => $caraPrint, 'judulLaporan' => $judulLaporan));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printRiwayat', array('model' => $model, 'caraPrint' => $caraPrint, 'judulLaporan' => $judulLaporan));
    } else if ($caraPrint == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait                    
      $mpdf = new MyPDF60('', $ukuranKertasPDF);

      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      // $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerLaporanTransaksiPDF',array('judulLaporan'=>$judulLaporan,  'periode'=> $periode, 'colspan'=>10),true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 20, 15, 15);
      $mpdf->WriteHTML(
        $this->renderPartial($this->path_view . 'printRiwayat', array('model' => $model, 'caraPrint' => $caraPrint, 'judulLaporan' => $judulLaporan), true)
      );
      $mpdf->Output($judulLaporan . '-' . date('Y_m_d') . '.pdf', 'I');
    }

    // $this->render($this->path_view . 'printRiwayat', array('model' => $model, 'caraPrint'=>$caraPrint, 'judulLaporan'=>$judulLaporan));

  }
  /**
   * untuk merubah ruangan / poliklinik
   */
}
