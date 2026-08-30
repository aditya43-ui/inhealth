<?php

class InformasiAntrianPasienController extends MyAuthController
{
  public function actionIndex()
  {
    $format = new MyFormatter();
    $model = new InformasiantrianV();
    $model->tgl_awal = date("Y-m-d");
    $model->tgl_akhir = date("Y-m-d");
    if (isset($_REQUEST['InformasiantrianV'])) {
      $model->attributes = $_REQUEST['InformasiantrianV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['InformasiantrianV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['InformasiantrianV']['tgl_akhir']);
      $model->ruangan_id = $_REQUEST['InformasiantrianV']['ruangan_id'];
      $model->carabayar_id = $_REQUEST['InformasiantrianV']['carabayar_id'];
      $model->statuspasien = $_REQUEST['InformasiantrianV']['statuspasien'];
      $model->no_rekam_medik = $_REQUEST['InformasiantrianV']['no_rekam_medik'];
      $model->no_pendaftaran = $_REQUEST['InformasiantrianV']['no_pendaftaran'];
      $model->barcode = $_REQUEST['InformasiantrianV']['barcode'];
      $model->noantrian2 = $_REQUEST['InformasiantrianV']['noantrian2'];
      $model->noantrian1 = $_REQUEST['InformasiantrianV']['noantrian1'];
     // $model->noantrian = $_REQUEST['InformasiantrianV']['noantrian'];
     // $model->modelantrisingkatan = $_REQUEST['InformasiantrianV']['modelantrisingkatan'];
     // $model->ruangan_singkatan = $_REQUEST['InformasiantrianV']['ruangan_singkatan'];
      

      
    }
    $this->render('index', array('model' => $model, 'format' => $format));
  }


}
