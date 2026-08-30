<?php

class InformasiTarifController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Tarif Bedah Sentral";
    $idInstalasi = Yii::app()->user->getState('instalasi_id');
    $idRuangan = Yii::app()->user->getState('ruangan_id');
    $modTarifTindakanRuanganV = new BSTarifTindakanPerdaRuanganV;
    $modTarifTindakanRuanganV->instalasi_id = $idInstalasi;
    $modTarifTindakanRuanganV->ruangan_id = $idRuangan;
    $modTarifTindakanRuanganV->jenistarif_id = Params::JENISTARIF_ID_PELAYANAN;
    $kom_unit = Params::KomponenUnitRuangan();
    if (isset($kom_unit[Yii::app()->user->getState('ruangan_id')])) {
      $modTarifTindakanRuanganV->komponenunit_id = $kom_unit[Yii::app()->user->getState('ruangan_id')];
    }

    $kel_tin = Params::KelompokTindakanInstalasi();

    if (isset($kel_tin[Yii::app()->user->getState('instalasi_id')])) {
      $modTarifTindakanRuanganV->kelompoktindakan_id = $kel_tin[Yii::app()->user->getState('instalasi_id')];
    }



    if (isset($_GET['BSTarifTindakanPerdaRuanganV'])) {
      $modTarifTindakanRuanganV->attributes = $_GET['BSTarifTindakanPerdaRuanganV'];
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

    $modTarifTindakanform = new BSTarifTindakanPerdaRuanganV();
    if ($kelaspelayanan_id != '') {
      $modTarifTindakan = BSTariftindakanM::model()->with('komponentarif')->findAll('kelaspelayanan_id=' . $kelaspelayanan_id . ' AND 
                                                               daftartindakan_id=' . $daftartindakan_id . '
                                                               AND jenistarif_id=' . $jenistarif_id . '      
                                                               AND t.komponentarif_id!=' . Params::KOMPONENTARIF_ID_TOTAL . '');
    } else {
      $modTarifTindakan = BSTariftindakanM::model()->with('komponentarif')->findAll('daftartindakan_id=' . $daftartindakan_id . '
                                                               AND t.komponentarif_id!=' . Params::KOMPONENTARIF_ID_TOTAL . '
                                                               AND jenistarif_id=' . $jenistarif_id . '      
                                                               AND kelaspelayanan_id isNull');
    }
    if (empty($kategoritindakan_id)) {
      $modTarif = TariftindakanperdaruanganV::model()->find('daftartindakan_id = ' . $daftartindakan_id . ' and kelaspelayanan_id = ' . $kelaspelayanan_id . ' and jenistarif_id = ' . $jenistarif_id . '');
    } else {
      $modTarif = TariftindakanperdaruanganV::model()->find('daftartindakan_id = ' . $daftartindakan_id . ' and kelaspelayanan_id = ' . $kelaspelayanan_id . ' and kategoritindakan_id = ' . $kategoritindakan_id . ' and jenistarif_id = ' . $jenistarif_id . '');
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
    $modTarifRad = new BSTarifTindakanPerdaRuanganV('searchInformasi');
    //  $modTarifRad->jenistarif_id = Params::JENISTARIF_ID_PELAYANAN;
    //  $modTarifRad->instalasi_id = Yii::app()->user->getState('instalasi_id');
    //$modTarifRad->carabayar_id = Params::CARABAYAR_ID_MEMBAYAR;
    //$modTarifRad->penjamin_id = Params::PENJAMIN_ID_UMUM;
    if (isset($_GET['BSTarifTindakanPerdaRuanganV'])) {

      $modTarifRad->attributes = $_GET['BSTarifTindakanPerdaRuanganV'];

      //var_dump($modTarifRad->daftartindakan_nama);die;
      //$modTarifRad->carabayar_id=$_GET['ROTarifpemeriksaanradruanganV']['carabayar_id'];
      //$modTarifRad->penjamin_id=$_GET['ROTarifpemeriksaanradruanganV']['penjamin_id'];
    }
    $this->render('print', array('modTarifRad' => $modTarifRad));
  }
}
