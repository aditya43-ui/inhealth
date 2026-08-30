<?php
class InfoKomposisiBahanMakananController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Komposisi Bahan Makanan";
    $modKomposisiBahanMakanan = new GZInformasikomposisibahanmakananV();

    if (isset($_REQUEST['GZInformasikomposisibahanmakananV'])) {
      $modKomposisiBahanMakanan->attributes = $_REQUEST['GZInformasikomposisibahanmakananV'];
    }
    $this->render('index', array('modKomposisiBahanMakanan' => $modKomposisiBahanMakanan));
  }
}
