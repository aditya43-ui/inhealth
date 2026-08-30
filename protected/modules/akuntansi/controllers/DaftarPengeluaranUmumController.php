<?php

class DaftarPengeluaranUmumController extends MyAuthController
{
  public function actionIndex()
  {
    $modPengeluaran = new AKPengeluaranumumT();
    $format = new MyFormatter();
    $modPengeluaran->tgl_awal = date('d M Y 00:00:00');
    $modPengeluaran->tgl_akhir = date('d M Y H:i:s');

    if (isset($_GET['AKPengeluaranumumT'])) {
      $modPengeluaran->attributes = $_GET['AKPengeluaranumumT'];
      $modPengeluaran->tgl_awal = $format->formatDateTimeForDb($_GET['AKPengeluaranumumT']['tgl_awal']);
      $modPengeluaran->tgl_akhir = $format->formatDateTimeForDb($_GET['AKPengeluaranumumT']['tgl_akhir']);
    }

    $this->render('index', array('modPengeluaran' => $modPengeluaran));
  }

  public function actionReturPengeluaranUmum()
  {
    //            $this->render('index', array('modPengeluaran'=>$modPengeluaran));
  }

  public function actionDetailPengeluaranUmum($pengeluaranumum_id)
  {
    if (isset($_GET['caraPrint'])) {
      $this->layout = '//layouts/printWindows';
    } else {
      $this->layout = '//layouts/iframe';
    }
    $modPengeluaran = AKPengeluaranumumT::model()->findByPk($pengeluaranumum_id);
    if (empty($modPengeluaran)) {
      echo "<h4>Data pengeluran umum tidak ditemukan!!</h4>";
      exit;
    }
    $modUraianKeluarUmum = UraiankeluarumumT::model()->findAllByAttributes(array('pengeluaranumum_id' => $pengeluaranumum_id));
    $this->render('detailPengeluaran', array(
      'modUraianKeluarUmum' => $modUraianKeluarUmum,
      'modPengeluaran' => $modPengeluaran,
    ));
  }
}
