<?php

class InformasiPembatalanPermintaanPembelianController extends MyAuthController
{
  public $defaultAction = 'index';
  public $path_view = 'gizi.views.informasiPembatalanPermintaanPembelian.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pembatalan Permintaan Pembelian Bahan Makanan";
    $model = new GZBatalpermintaanpembelianT;
    $format = new MyFormatter();
    $model->ruangan_id = array(Params::RUANGAN_ID_GIZI, Params::RUANGAN_ID_GUDANG_UMUM);
    $model->tgl_awal  = date('Y-m-d');
    $model->tgl_akhir  = date('Y-m-d');
    $model->tglbatal_awal  = date('Y-m-d');
    $model->tglbatal_akhir = date('Y-m-d');

    if (isset($_GET['GZBatalpermintaanpembelianT'])) {
      $model->attributes = $_GET['GZBatalpermintaanpembelianT'];
      $model->tgl_awal  = $format->formatDateTimeForDb($_GET['GZBatalpermintaanpembelianT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GZBatalpermintaanpembelianT']['tgl_akhir']);
      $model->tglbatal_awal = $format->formatDateTimeForDb($_GET['GZBatalpermintaanpembelianT']['tglbatal_awal']);
      $model->tglbatal_akhir = $format->formatDateTimeForDb($_GET['GZBatalpermintaanpembelianT']['tglbatal_akhir']);
    }
    $this->render($this->path_view . 'index', array('format' => $format, 'model' => $model));
  }

  public function actionRincian($id)
  {
    $this->layout = '//layouts/iframe';
    $judulLaporan = 'PERMINTAAN PEMBELIAN BAHAN MAKANAN';
    $modPengajuan = PengajuanbahanmknT::model()->findByPk($id);
    $modDetailPengajuan = array();
    if (isset($modPengajuan)) {
      $modDetailPengajuan = PengajuanbahandetailT::model()->with('bahanmakanan', 'golbahanmakanan')->findAllByAttributes(array('pengajuanbahanmkn_id' => $modPengajuan->pengajuanbahanmkn_id), array('order' => 'nourutbahan'));
    }

    $this->render($this->path_view . 'detailInformasi', array(
      'modPengajuan' => $modPengajuan,
      'modDetailPengajuan' => $modDetailPengajuan,
      'judulLaporan' => $judulLaporan,
    ));
  }

  public function actionPrintRincian($id)
  {
    $judulLaporan = 'PERMINTAAN PEMBELIAN BAHAN MAKANAN';
    //$this->layout = '//layouts/iframe';
    $modPengajuan = PengajuanbahanmknT::model()->findByPk($id);
    $modDetailPengajuan = array();
    if (isset($modPengajuan)) {
      $modDetailPengajuan = PengajuanbahandetailT::model()->with('bahanmakanan', 'golbahanmakanan')->findAllByAttributes(array('pengajuanbahanmkn_id' => $modPengajuan->pengajuanbahanmkn_id), array('order' => 'nourutbahan'));
    }

    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      //   var_dump($id);die;
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printDetailInformasi', array('modPengajuan' => $modPengajuan, 'modDetailPengajuan' => $modDetailPengajuan, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    }
  }
}
