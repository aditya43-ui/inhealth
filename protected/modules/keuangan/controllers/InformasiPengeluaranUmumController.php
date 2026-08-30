<?php

class InformasiPengeluaranUmumController extends MyAuthController
{
  public $path_view = 'keuangan.views.informasiPengeluaranUmum.';
  public function actionIndex($linkHalaman = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pengeluaran Kas / Umum";
    $modPengeluaran = new KUPengeluaranumumT();
    $format = new MyFormatter();
    $modPengeluaran->tgl_awal = date('d M Y 00:00:00');
    $modPengeluaran->tgl_akhir = date('d M Y H:i:s');

    if (isset($_GET['KUPengeluaranumumT'])) {
      $modPengeluaran->attributes = $_GET['KUPengeluaranumumT'];
      $modPengeluaran->tgl_awal = $format->formatDateTimeForDb($_GET['KUPengeluaranumumT']['tgl_awal']);
      $modPengeluaran->tgl_akhir = $format->formatDateTimeForDb($_GET['KUPengeluaranumumT']['tgl_akhir']);
      $modPengeluaran->jenispengeluaran_nama = isset($_GET['KUPengeluaranumumT']['jenispengeluaran_nama']) ? $_GET['KUPengeluaranumumT']['jenispengeluaran_nama'] : null;
      // $modPengeluaran->pegawai_id = isset($_GET['KUPengeluaranumumT']['pegawai_id']) ? $_GET['KUPengeluaranumumT']['pegawai_id'] : null;
      // $modPengeluaran->shift_id = isset($_GET['KUPengeluaranumumT']['shift_id']) ? $_GET['KUPengeluaranumumT']['shift_id'] : null;
      // var_dump($_GET['KUPengeluaranumumT']);die;
    }

    if($linkHalaman == null) $linkHalaman = CustomFunction::getUrlByMenuID(1391);

    $this->render($this->path_view . 'index', array(
      'modPengeluaran' => $modPengeluaran,
      'linkHalaman' => $linkHalaman
    ));
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
    $modPengeluaran = KUPengeluaranumumT::model()->findByPk($pengeluaranumum_id);
    $modTandaBukti = KUTandabuktikeluarT::model()->findByPk($modPengeluaran->tandabuktikeluar_id);
    // var_dump($modTandaBukti);die;
    if (!count((array)$modPengeluaran) > 0) {
      echo "<h4>Data pengeluran umum tidak ditemukan!!</h4>";
      exit;
    }
    $modUraianKeluarUmum = UraiankeluarumumT::model()->findAllByAttributes(array('pengeluaranumum_id' => $pengeluaranumum_id));
    $this->render($this->path_view . 'detailPengeluaran', array(
      'modUraianKeluarUmum' => $modUraianKeluarUmum,
      'modPengeluaran' => $modPengeluaran,
      'modTandaBukti' => $modTandaBukti
    ));
  }
}
