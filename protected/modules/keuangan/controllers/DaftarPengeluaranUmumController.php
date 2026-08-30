<?php

class DaftarPengeluaranUmumController extends MyAuthController
{
  public function actionIndex()
  {
    $modPengeluaran = new KUPengeluaranumumT();
    $format = new MyFormatter();
    $modPengeluaran->tgl_awal = date('d M Y');
    $modPengeluaran->tgl_akhir = date('d M Y');


    if (isset($_GET['KUPengeluaranumumT'])) {
      $modPengeluaran->attributes = $_GET['KUPengeluaranumumT'];
      $modPengeluaran->tgl_awal = $format->formatDateTimeForDb($_GET['KUPengeluaranumumT']['tgl_awal']);
      $modPengeluaran->tgl_akhir = $format->formatDateTimeForDb($_GET['KUPengeluaranumumT']['tgl_akhir']);
    }

    $this->render('index', array('modPengeluaran' => $modPengeluaran));
  }

  public function actionReturPengeluaranUmum()
  {
    //            $this->render('index', array('modPengeluaran'=>$modPengeluaran));
  }
}
