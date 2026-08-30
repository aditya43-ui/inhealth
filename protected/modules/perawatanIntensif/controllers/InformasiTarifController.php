<?php

class InformasiTarifController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Rawatintensif";
    $modTarifTindakanRuanganV = new PITarifTindakanPerdaRuanganV('search');
    $modTarifTindakanRuanganV->jenistarif_id = Params::JENISTARIF_ID_PELAYANAN;
    if (isset($_GET['PITarifTindakanPerdaRuanganV'])) {
      $modTarifTindakanRuanganV->attributes = $_GET['PITarifTindakanPerdaRuanganV'];
    }
    $this->render('index', array('modTarifTindakanRuanganV' => $modTarifTindakanRuanganV));
  }

  public function actionDetailsTarif($kelaspelayanan_id, $daftartindakan_id, $kategoritindakan_id, $jenistarif_id)
  {
    $this->layout = '//layouts/iframe';
    $kelaspelayanan_id = (isset($kelaspelayanan_id) ? $kelaspelayanan_id : null);
    $daftartindakan_id = (isset($daftartindakan_id) ? $daftartindakan_id : null);
    $kategoritindakan_id = (isset($kategoritindakan_id) ? $kategoritindakan_id : null);
    $jenistarif_id = (isset($jenistarif_id) ? $jenistarif_id : null);
    if (empty($jenistarif_id)) {
      $jenistarif_id = Params::JENISTARIF_ID_PELAYANAN;
    }

    $modTarifTindakanform = new PITarifTindakanPerdaRuanganV();
    if ($kelaspelayanan_id != '') {
      $modTarifTindakan = PITariftindakanM::model()->with('komponentarif')->findAll('kelaspelayanan_id=' . $kelaspelayanan_id . ' AND 
														   daftartindakan_id=' . $daftartindakan_id . '
														   AND t.komponentarif_id!=' . Params::KOMPONENTARIF_ID_TOTAL . ' AND t.jenistarif_id = ' . $jenistarif_id . '');
    } else {
      $modTarifTindakan = PITariftindakanM::model()->with('komponentarif')->findAll('daftartindakan_id=' . $daftartindakan_id . '
														   AND t.komponentarif_id!=' . Params::KOMPONENTARIF_ID_TOTAL . '
														   AND kelaspelayanan_id isNull AND t.jenistarif_id = ' . $jenistarif_id . '');
    }
    if (empty($kategoritindakan_id)) {
      $modTarif = TariftindakanperdaruanganV::model()->find('daftartindakan_id = ' . $daftartindakan_id . ' and kelaspelayanan_id = ' . $kelaspelayanan_id . ' AND t.jenistarif_id = ' . $jenistarif_id . '');
    } else {
      $modTarif = TariftindakanperdaruanganV::model()->find('daftartindakan_id = ' . $daftartindakan_id . ' and kelaspelayanan_id = ' . $kelaspelayanan_id . '  AND t.jenistarif_id = ' . $jenistarif_id . ' AND kategoritindakan_id = ' . $kategoritindakan_id);
    }
    $jumlahTarifTindakan = count((array)$modTarifTindakan);

    $this->render('detailsTarif', array(
      'modTarif' => $modTarif,
      'modTarifTindakan' => $modTarifTindakan,
      'modTarifTindakanform' => $modTarifTindakanform,
      'jumlahTarifTindakan' => $jumlahTarifTindakan
    ));
  }
}
