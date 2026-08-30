<?php

class InformasiUmurPiutangController extends MyAuthController
{
  public $path_view = 'akuntansi.views.informasiUmurPiutang.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Umur Piutang";
    $model = new AKUmurpiutangpasienV();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['AKUmurpiutangpasienV'])) {
      $model->attributes = $_GET['AKUmurpiutangpasienV'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['AKUmurpiutangpasienV']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['AKUmurpiutangpasienV']['tgl_akhir']);
    }

    $this->render('index', array('model' => $model));
  }

  public function actionIndexPengajuanPiutang()
  {
    $this->layout = '//layouts/iframe1';
    $model = new AKInfoumurpiutangpenjaminV;
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['AKInfoumurpiutangpenjaminV'])) {
      $model->attributes = $_GET['AKInfoumurpiutangpenjaminV'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['AKInfoumurpiutangpenjaminV']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['AKInfoumurpiutangpenjaminV']['tgl_akhir']);
    }

    $this->render('indexPengajuanPiutang', array('model' => $model));
  }

  public function actionIndexPasienPiutang()
  {
    $this->layout = '//layouts/iframe1';
    $model = new AKPembayaranpelayananT();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['AKPembayaranpelayananT'])) {
      $model->attributes = $_GET['AKPembayaranpelayananT'];
      $model->tgl_awal = MyFormatter::formatDateTimeForDb($_GET['AKPembayaranpelayananT']['tgl_awal']);
      $model->tgl_akhir = MyFormatter::formatDateTimeForDb($_GET['AKPembayaranpelayananT']['tgl_akhir']);
      $model->no_pendaftaran = $_GET['AKPembayaranpelayananT']['no_pendaftaran'];
      $model->nama_pasien = $_GET['AKPembayaranpelayananT']['nama_pasien'];
    }

    $this->render('indexPasienPiutang', array('model' => $model));
  }
}
