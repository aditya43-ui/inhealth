<?php

class InformasiTarifController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Tarif Pemulasaran Jenazah";
    $instalasi_id = Yii::app()->user->getState('instalasi_id');
    $idRuangan = Yii::app()->user->getState('ruangan_id');
    $modTarifTindakanRuanganV = new PJTarifTindakanPerdaRuanganV;
    $modTarifTindakanRuanganV->instalasi_id = $instalasi_id;
    $modTarifTindakanRuanganV->ruangan_id = $idRuangan;

    if (isset($_GET['PJTarifTindakanPerdaRuanganV'])) {
      $modTarifTindakanRuanganV->attributes = $_GET['PJTarifTindakanPerdaRuanganV'];
      //                $modTarifTindakanRuanganV->daftartindakan_id = $_GET['PJTarifTindakanPerdaRuanganV']['daftartindakan_id'];
      $modTarifTindakanRuanganV->daftartindakan_nama = $_GET['PJTarifTindakanPerdaRuanganV']['daftartindakan_nama'];
    }
    $this->render('index', array('modTarifTindakanRuanganV' => $modTarifTindakanRuanganV));
  }

  public function actionDetailsTarif($kelaspelayanan_id, $daftartindakan_id, $kategoritindakan_id)
  {

    $this->layout = '//layouts/iframe';
    $kelaspelayanan_id = (isset($kelaspelayanan_id) ? $kelaspelayanan_id : null);
    $daftartindakan_id = (isset($daftartindakan_id) ? $daftartindakan_id : null);
    $kategoritindakan_id = (isset($kategoritindakan_id) ? $kategoritindakan_id : null);

    $modTarifTindakanform = new PJTarifTindakanPerdaRuanganV();
    if ($kelaspelayanan_id != '') {
      $modTarifTindakan = PJTariftindakanM::model()->with('komponentarif')->findAll('kelaspelayanan_id=' . $kelaspelayanan_id . ' AND 
                                                               daftartindakan_id=' . $daftartindakan_id . '
                                                               AND t.komponentarif_id!=' . Params::KOMPONENTARIF_ID_TOTAL . '');
    } else {
      $modTarifTindakan = PJTariftindakanM::model()->with('komponentarif')->findAll('daftartindakan_id=' . $daftartindakan_id . '
                                                               AND t.komponentarif_id!=' . Params::KOMPONENTARIF_ID_TOTAL . '
                                                               AND kelaspelayanan_id isNull');
    }
    if (empty($kategoritindakan_id)) {
      $modTarif = TariftindakanperdaruanganV::model()->find('daftartindakan_id = ' . $daftartindakan_id . ' and kelaspelayanan_id = ' . $kelaspelayanan_id . '');
    } else {
      $modTarif = TariftindakanperdaruanganV::model()->find('daftartindakan_id = ' . $daftartindakan_id . ' and kelaspelayanan_id = ' . $kelaspelayanan_id . ' and kategoritindakan_id = ' . $kategoritindakan_id);
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
