<?php

class InformasiPembatalanPermintaanPembelianController extends MyAuthController
{
  public $defaultAction = 'index';
  public $path_view = 'gudangUmum.views.informasiPembatalanPermintaanPembelian.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pembatalan Permintaan Pembelian Barang";
    $model = new GUBatalpermintaanpembelianT;
    $format = new MyFormatter();
    //        $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $model->ruangan_id = array(Params::RUANGAN_ID_LOGISTIK, Params::RUANGAN_ID_GUDANG_UMUM);
    $model->tgl_awal  = date('Y-m-d');
    $model->tgl_akhir  = date('Y-m-d');
    $model->tglbatal_awal  = date('Y-m-d');
    $model->tglbatal_akhir = date('Y-m-d');
    $model->ceklis = false;

    if (isset($_GET['GUBatalpermintaanpembelianT'])) {
      $model->attributes = $_GET['GUBatalpermintaanpembelianT'];
      $model->tgl_awal  = $format->formatDateTimeForDb($_GET['GUBatalpermintaanpembelianT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GUBatalpermintaanpembelianT']['tgl_akhir']);
      $model->tglbatal_awal = $format->formatDateTimeForDb($_GET['GUBatalpermintaanpembelianT']['tglbatal_awal']);
      $model->tglbatal_akhir = $format->formatDateTimeForDb($_GET['GUBatalpermintaanpembelianT']['tglbatal_akhir']);
    }
    $this->render($this->path_view . 'index', array('format' => $format, 'model' => $model));
  }

  public function actionRincian($id)
  {
    $this->layout = '//layouts/iframe';
    $modBeli = PembelianbarangT::model()->findByPk($id);
    $judulLaporan = 'SURAT PESANAN';
    $modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id' => $modBeli->pembelianbarang_id));
    $this->render($this->path_view . 'detailInformasi', array(
      'modBeli' => $modBeli,
      'modDetailBeli' => $modDetailBeli,
      'judulLaporan' => $judulLaporan,
    ));
  }
  public function actionRincianPrint($id)
  {
    $this->layout = '//layouts/printWindows';
    $judulLaporan = 'SURAT PESANAN';
    $modBeli = PembelianbarangT::model()->findByPk($id);
    $modDetailBeli = BelibrgdetailT::model()->findAllByAttributes(array('pembelianbarang_id' => $modBeli->pembelianbarang_id));
    $this->render($this->path_view . 'detailInformasi', array(
      'judulLaporan' => $judulLaporan,
      'modBeli' => $modBeli,
      'modDetailBeli' => $modDetailBeli,
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
