<?php

class InformasiTarifController extends MyAuthController
{
  public function actionIndex()
  {
    $modTarifTindakanRuanganV = new PSTarifTindakanPerdaRuanganV('search');
    $kom_unit = Params::KomponenUnitRuangan();
    if (isset($kom_unit[Yii::app()->user->getState('instalasi_id')])) {
      $modTarifTindakanRuanganV->komponenunit_id = $kom_unit[Yii::app()->user->getState('instalasi_id')];
    }

    $kel_tin = Params::KelompokTindakanInstalasi();

    if (isset($kel_tin[Yii::app()->user->getState('instalasi_id')])) {
      $modTarifTindakanRuanganV->kelompoktindakan_id = $kel_tin[Yii::app()->user->getState('instalasi_id')];
    }

    //  $modTarifTindakanRuanganV->instalasi_id = Params::INSTALASI_ID_RJ;
    //$modTarifTindakanRuanganV->jenistarif_id = Params::JENISTARIF_ID_PELAYANAN;                
    if (isset($_GET['PSTarifTindakanPerdaRuanganV'])) {
      $modTarifTindakanRuanganV->attributes = $_GET['PSTarifTindakanPerdaRuanganV'];
      $modTarifTindakanRuanganV->komponenunit_id = $_GET['PSTarifTindakanPerdaRuanganV']['komponenunit_id'];
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

    $modTarifTindakanform = new PSTarifTindakanPerdaRuanganV();
    if ($kelaspelayanan_id != '') {
      $modTarifTindakan = PSTariftindakanM::model()->with('komponentarif')->findAll('kelaspelayanan_id=' . $kelaspelayanan_id . ' AND 
                                                          daftartindakan_id=' . $daftartindakan_id . '
                                                          AND jenistarif_id=' . $jenistarif_id . '    
                                                          AND t.komponentarif_id!=' . Params::KOMPONENTARIF_ID_TOTAL . '');
    } else {
      $modTarifTindakan = PSTariftindakanM::model()->with('komponentarif')->findAll('daftartindakan_id=' . $daftartindakan_id . '
                                                          AND t.komponentarif_id!=' . Params::KOMPONENTARIF_ID_TOTAL . '
                                                          AND jenistarif_id=' . $jenistarif_id . '    
                                                          AND kelaspelayanan_id isNull');
    }
    if (empty($kategoritindakan_id)) {
      $modTarif = TariftindakanperdaruanganV::model()->find('daftartindakan_id = ' . $daftartindakan_id . ' and kelaspelayanan_id = ' . $kelaspelayanan_id . ' and jenistarif_id = ' . $jenistarif_id . '');
    } else {
      $modTarif = TariftindakanperdaruanganV::model()->find('daftartindakan_id = ' . $daftartindakan_id . ' and kelaspelayanan_id = ' . $kelaspelayanan_id . ' and kategoritindakan_id = ' . $kategoritindakan_id . 'and jenistarif_id = ' . $jenistarif_id . '');
    }
    $jumlahTarifTindakan = count((array)$modTarifTindakan);

    $this->render('detailsTarif', array(
      'modTarif' => $modTarif,
      'modTarifTindakan' => $modTarifTindakan,
      'modTarifTindakanform' => $modTarifTindakanform,
      'jumlahTarifTindakan' => $jumlahTarifTindakan
    ));
  }

  public function actionPrint()
  {
    $this->layout = '//layouts/iframe';
    $modTarifRad = new PSTarifTindakanPerdaRuanganV('searchInformasi');
    $modTarifRad->instalasi_id = Yii::app()->user->getState('instalasi_id');

    if (isset($_GET['PSTarifTindakanPerdaRuanganV'])) {
      $modTarifRad->attributes = $_GET['PSTarifTindakanPerdaRuanganV'];
      $modTarifRad->jenistarif_id = $_GET['PSTarifTindakanPerdaRuanganV']['jenistarif_id'];
    }
    $this->render('print', array('modTarifRad' => $modTarifRad));
  }
}
