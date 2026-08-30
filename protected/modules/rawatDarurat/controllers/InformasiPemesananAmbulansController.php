<?php

class InformasiPemesananAmbulansController extends MyAuthController
{
  public $ambulansRS = 'PemakaianAmbulanPasienRSRD';
  public $ambulansLuar = 'PemakaianAmbulanPasienLuarRD';
  public $path_view = 'rawatDarurat.views.informasiPemesananAmbulans.';

  public function actionIndex($linkHalaman = null)
  {
    $format = new MyFormatter();
    $modPemesanan = new RDPesanambulansT('search');
    $modPemesanan->tgl_awal  = date('Y-m-d');
    $modPemesanan->tgl_akhir  = date('Y-m-d');
    $modPemesanan->ruangan_id = Yii::app()->user->getState('ruangan_id');
    if (isset($_GET['RDPesanambulansT'])) {
      $modPemesanan->unsetAttributes();
      $modPemesanan->attributes = $_GET['RDPesanambulansT'];
      $modPemesanan->tgl_awal  = $format->formatDateTimeForDb($_GET['RDPesanambulansT']['tgl_awal']);
      $modPemesanan->tgl_akhir  = $format->formatDateTimeForDb($_GET['RDPesanambulansT']['tgl_akhir']);
      $modPemesanan->nama_pemakai  = $_GET['RDPesanambulansT']['nama_pemakai'];
    }
    $this->render($this->path_view . 'index', array('format' => $format, 'modPemesanan' => $modPemesanan, 'linkHalaman' => $linkHalaman));
  }

  public function actionPrint()
  {
    $format = new MyFormatter();
    $modPemesanan = new RDPesanambulansT;
    $modPemesanan->tgl_awal  = date('Y-m-d');
    $modPemesanan->tgl_akhir  = date('Y-m-d');
    $modPemesanan->ruangan_id = Yii::app()->user->getState('ruangan_id');
    //  $modPemesanan->attributes=$_REQUEST['RDPesanambulansT'];

    if (isset($_GET['RDPesanambulansT'])) {
      $modPemesanan->attributes = $_GET['RDPesanambulansT'];
      $modPemesanan->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modPemesanan->tgl_awal = $format->formatDateTimeForDb($_GET['RDPesanambulansT']['tgl_awal']);
      $modPemesanan->tgl_akhir = $format->formatDateTimeForDb($_GET['RDPesanambulansT']['tgl_akhir']);
      $modPemesanan->tgl_awal = $modPemesanan->tgl_awal . " 00:00:00";
      $modPemesanan->tgl_akhir = $modPemesanan->tgl_akhir . " 23:59:59";
    }

    $judulLaporan = 'Informasi Data Pemesanan';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'print', array('modPemesanan' => $modPemesanan, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'print', array('modPemesanan' => $modPemesanan, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                            //Posisi
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial(path_view . 'Print', array('modPemesanan' => $modPemesanan, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
