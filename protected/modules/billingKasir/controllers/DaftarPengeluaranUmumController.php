<?php

class DaftarPengeluaranUmumController extends MyAuthController
{
  public function actionIndex()
  {
    $modPengeluaran = new BKPengeluaranumumT();
    $format = new MyFormatter();
    $modPengeluaran->tgl_awal = date('Y-m-d');
    $modPengeluaran->tgl_akhir = date('Y-m-d');


    if (isset($_GET['BKPengeluaranumumT'])) {
      $modPengeluaran->attributes = $_GET['BKPengeluaranumumT'];
      $modPengeluaran->tgl_awal = $format->formatDateTimeForDb($_GET['BKPengeluaranumumT']['tgl_awal']);
      $modPengeluaran->tgl_akhir = $format->formatDateTimeForDb($_GET['BKPengeluaranumumT']['tgl_akhir']);
    }

    $this->render('index', array('modPengeluaran' => $modPengeluaran, 'format' => $format));
  }

  public function actionReturPengeluaranUmum()
  {
    //            $this->render('index', array('modPengeluaran'=>$modPengeluaran));
  }
}
