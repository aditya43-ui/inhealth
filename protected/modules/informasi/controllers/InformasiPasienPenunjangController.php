<?php
class InformasiPasienPenunjangController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Penunjang";
    $format = new MyFormatter();
    $modPenunjang = new INPasienPenunjang('searchPenunjang');
    $modPenunjang->unsetAttributes();
    $modPenunjang->tgl_awal = date('Y-m-d');
    $modPenunjang->tgl_akhir = date('Y-m-d');
    if (isset($_GET['INPasienPenunjang'])) {
      $modPenunjang->attributes = $_GET['INPasienPenunjang'];
      $modPenunjang->tgl_awal = isset($_GET['INPasienPenunjang']['tgl_awal']) ? $format->formatDateTimeForDb($_GET['INPasienPenunjang']['tgl_awal']) : null;
      $modPenunjang->tgl_akhir = isset($_GET['INPasienPenunjang']['tgl_akhir']) ? $format->formatDateTimeForDb($_GET['INPasienPenunjang']['tgl_akhir']) : null;
      $modPenunjang->no_pendaftaran = isset($_GET['INPasienPenunjang']['no_pendaftaran']) ? $_GET['INPasienPenunjang']['no_pendaftaran'] : null;
      $modPenunjang->nama_pasien = isset($_GET['INPasienPenunjang']['nama_pasien']) ? $_GET['INPasienPenunjang']['nama_pasien'] : null;
      $modPenunjang->no_rekam_medik = isset($_GET['INPasienPenunjang']['no_rekam_medik']) ? $_GET['INPasienPenunjang']['no_rekam_medik'] : null;
    }
    $this->render('index', array(
      'modPenunjang' => $modPenunjang,
      'format' => $format
    ));
  }
}
