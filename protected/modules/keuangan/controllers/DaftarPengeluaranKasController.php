<?php

class DaftarPengeluaranKasController extends MyAuthController
{
  public function actionIndex()
  {
    $modPengeluaran = new KUPengeluaranumumT();
    $format = new MyFormatter();
    $modPengeluaran->tgl_awal = date('Y-m-d');
    $modPengeluaran->tgl_akhir = date('Y-m-d');

    if (isset($_GET['KUPengeluaranumumT'])) {
      $modPengeluaran->attributes = $_GET['KUPengeluaranumumT'];
      $modPengeluaran->tgl_awal = $format->formatDateTimeForDb($_GET['KUPengeluaranumumT']['tgl_awal']);
      $modPengeluaran->tgl_akhir = $format->formatDateTimeForDb($_GET['KUPengeluaranumumT']['tgl_akhir']);
    }

    $this->render('index', array('modPengeluaran' => $modPengeluaran, 'format' => $format));
  }

  public function actionReturPengeluaranUmum()
  {
    //            $this->render('index', array('modPengeluaran'=>$modPengeluaran));
  }
}
