<?php

class InformasiTarifPaketController extends MyAuthController
{
  public $path_view = 'mcu.views.informasiTarifPaket.';

  public function actionIndex()
  {
    $modTarifTindakanRuanganV = new PaketpelayananV;

    if (isset($_GET['PaketpelayananV'])) {
      $modTarifTindakanRuanganV->attributes = $_GET['PaketpelayananV'];
    }
    $this->render($this->path_view . 'index', array('modTarifTindakanRuanganV' => $modTarifTindakanRuanganV));
  }

  public function actionDetailsTarif($tipepaket_id)
  {
    $this->layout = '//layouts/iframe';

    $modTarif = PaketpelayananV::model()->findByAttributes(array(
      'tipepaket_id' => $tipepaket_id,
    ));
    $modTarifTindakan = PaketpelayananV::model()->findAllByAttributes(array(
      'tipepaket_id' => $tipepaket_id,
    ));
    $jumlahTarifTindakan = count((array)$modTarifTindakan);

    $this->render($this->path_view . 'detailsTarif', array(
      'modTarif' => $modTarif,
      'modTarifTindakan' => $modTarifTindakan, 'jumlahTarifTindakan' => $jumlahTarifTindakan
    ));
  }
}
