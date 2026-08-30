<?php

class DaftarPenerimaanKasController extends MyAuthController
{
  public function actionIndex()
  {
    $modPenerimaan = new KUPenerimaanUmumT;
    $format = new MyFormatter();
    $modPenerimaan->tgl_awal = date('Y-m-d');
    $modPenerimaan->tgl_akhir = date('Y-m-d');

    if (isset($_GET['KUPenerimaanUmumT'])) {
      $modPenerimaan->attributes = $_GET['KUPenerimaanUmumT'];
      $modPenerimaan->tgl_awal = $format->formatDateTimeForDb($_GET['KUPenerimaanUmumT']['tgl_awal']);
      $modPenerimaan->tgl_akhir = $format->formatDateTimeForDb($_GET['KUPenerimaanUmumT']['tgl_akhir']);
    }

    $this->render('index', array('modPenerimaan' => $modPenerimaan));
  }
}
