<?php

class InformasiPembatalanPermintaanPembelianController extends MyAuthController
{
  public $defaultAction = 'index';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pembatalan Permintaan Pembelian Obat dan Alkes";
    $model = new GFBatalpermintaanpembelianT;
    $format = new MyFormatter();
    $model->ruangan_id = array(Params::RUANGAN_ID_GUDANG_FARMASI, Params::RUANGAN_ID_GUDANG_UMUM);
    $model->tgl_awal  = date('Y-m-d');
    $model->tgl_akhir  = date('Y-m-d');
    $model->tglbatal_awal  = date('Y-m-d');
    $model->tglbatal_akhir = date('Y-m-d');

    if (isset($_GET['GFBatalpermintaanpembelianT'])) {
      $model->attributes = $_GET['GFBatalpermintaanpembelianT'];
      $model->tgl_awal  = $format->formatDateTimeForDb($_GET['GFBatalpermintaanpembelianT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFBatalpermintaanpembelianT']['tgl_akhir']);
      $model->tglbatal_awal = $format->formatDateTimeForDb($_GET['GFBatalpermintaanpembelianT']['tglbatal_awal']);
      $model->tglbatal_akhir = $format->formatDateTimeForDb($_GET['GFBatalpermintaanpembelianT']['tglbatal_akhir']);
    }
    $this->render('index', array('format' => $format, 'model' => $model));
  }

  public function actionRincian($permintaanpembelian_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $model = PermintaanpembelianT::model()->findByAttributes(array('permintaanpembelian_id' => $permintaanpembelian_id));
    $modDetails = array();
    if (isset($model)) {
      $modDetails = PermintaandetailT::model()->findAllByAttributes(array('permintaanpembelian_id' => $permintaanpembelian_id));
    }

    $judulLaporan = 'Permintaan Pembelian';
    $deskripsi = '';
    $this->render('_rincianBaru', array(
      'format' => $format,
      'model' => $model,
      'judulLaporan' => $judulLaporan,
      'deskripsi' => $deskripsi,
      'modDetails' => $modDetails
    ));
  }

  public function actionPrintRincian($permintaanpembelian_id, $caraPrint = null)
  {
    $format = new MyFormatter;
    $modPermintaanPembelian = PermintaanpembelianT::model()->findByPk($permintaanpembelian_id);
    $modPermintaanPembelianDetail = PermintaandetailT::model()->findAllByAttributes(array('permintaanpembelian_id' => $permintaanpembelian_id));

    $judul_print = 'Permintaan Pembelian Farmasi';
    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('PrintBaru', array(
        'format' => $format,
        'judul_print' => $judul_print,
        'modPermintaanPembelian' => $modPermintaanPembelian,
        'modPermintaanPembelianDetail' => $modPermintaanPembelianDetail,
        'caraPrint' => $caraPrint
      ), true));
      $mpdf->Output($judul_print . "_" . date('Y-m-d') . '.pdf', 'I');
    }
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    }
    $this->render('PrintBaru', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modPermintaanPembelian' => $modPermintaanPembelian,
      'modPermintaanPembelianDetail' => $modPermintaanPembelianDetail,
      'caraPrint' => $caraPrint
    ));
  }

  public function cekPegawaiJabatan()
  {
    $approval = ApprovalotorisasiM::model()->find();
    if (empty($approval)) {
      return false;
    }

    return in_array(Yii::app()->user->getState('pegawai_id'), array(
      $approval->managerumum_id,
      $approval->managerkeuangan_id,
      $approval->direkturrs_id,
    ));
  }
}
