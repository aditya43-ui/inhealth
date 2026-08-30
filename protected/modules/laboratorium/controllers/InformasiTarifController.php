<?php

class InformasiTarifController extends MyAuthController
{
  public $path_view = 'laboratorium.views.informasiTarif.';
  public $layouts = '//layouts/main';
  public function actionIndex()
  {
    $modTarifLab = new LBTariftindakanperdaruanganV('searchInformasi');
    $modTarifLab->jenistarif_id = Params::JENISTARIF_ID_PELAYANAN;
    $modTarifLab->instalasi_id = Yii::app()->user->getState('instalasi_id');

    $kom_unit = Params::KomponenUnitRuangan();
    if (isset($kom_unit[Yii::app()->user->getState('ruangan_id')])) {
      $modTarifLab->komponenunit_id = $kom_unit[Yii::app()->user->getState('ruangan_id')];
    }

    $kel_tin = Params::KelompokTindakanInstalasi();

    if (isset($kel_tin[Yii::app()->user->getState('instalasi_id')])) {

      $modTarifLab->kelompoktindakan_id = $kel_tin[Yii::app()->user->getState('instalasi_id')];
    }
    //$modTarifLab->carabayar_id = Params::CARABAYAR_ID_MEMBAYAR;
    //$modTarifLab->penjamin_id = Params::PENJAMIN_ID_UMUM;
    if (isset($_GET['LBTariftindakanperdaruanganV'])) {
      $modTarifLab->attributes = $_GET['LBTariftindakanperdaruanganV'];
      //$modTarifLab->carabayar_id=$_GET['LBTarifpemeriksaanlabruanganV']['carabayar_id'];
      //$modTarifLab->penjamin_id=$_GET['LBTarifpemeriksaanlabruanganV']['penjamin_id'];
    }
    $this->render($this->path_view . 'index', array('modTarifLab' => $modTarifLab));
  }

  public function actionDetailsTarif($kelaspelayanan_id, $daftartindakan_id, $kategoritindakan_id, $jenistarif_id)
  {

    $this->layout = '//layouts/iframe';
    $kelaspelayanan_id = (isset($kelaspelayanan_id) ? $kelaspelayanan_id : null);
    $daftartindakan_id = (isset($daftartindakan_id) ? $daftartindakan_id : null);
    $kategoritindakan_id = (isset($kategoritindakan_id) ? $kategoritindakan_id : null);
    if ($kelaspelayanan_id != '') {
      $modTarifTindakan = LBTariftindakanM::model()->with('komponentarif')->findAll('kelaspelayanan_id=' . $kelaspelayanan_id . ' AND 
														   daftartindakan_id=' . $daftartindakan_id . '
														   AND t.komponentarif_id!=' . Params::KOMPONENTARIF_ID_TOTAL
        . ' AND t.jenistarif_id = ' . $jenistarif_id);
    } else {
      $modTarifTindakan = LBTariftindakanM::model()->with('komponentarif')->findAll('daftartindakan_id=' . $daftartindakan_id . '
														   AND t.komponentarif_id!=' . Params::KOMPONENTARIF_ID_TOTAL .
        ' AND kelaspelayanan_id isNull'
        . ' AND t.jenistarif_id = ' . $jenistarif_id);
    }
    if (empty($kategoritindakan_id)) {
      $modTarif = TariftindakanperdaruanganV::model()->find('daftartindakan_id = ' . $daftartindakan_id . ' and kelaspelayanan_id = ' . $kelaspelayanan_id . ' and jenistarif_id = ' . $jenistarif_id);
    } else {
      $modTarif = TariftindakanperdaruanganV::model()->find('daftartindakan_id = ' . $daftartindakan_id . ' and kelaspelayanan_id = ' . $kelaspelayanan_id . ' and kategoritindakan_id = ' . $kategoritindakan_id . ' and jenistarif_id = ' . $jenistarif_id);
    }
    $jumlahTarifTindakan = count((array)$modTarifTindakan);
    $this->render($this->path_view . 'detailsTarif', array(
      'modTarif' => $modTarif,
      'modTarifTindakan' => $modTarifTindakan,
      'jumlahTarifTindakan' => $jumlahTarifTindakan
    ));
  }

  /**
   * Mengatur dropdown ruangan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = null;
      if ($model_nama !== '' && $attr == '') {
        $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
      } else if ($model_nama == '' && $attr !== '') {
        $instalasi_id = $_POST["$attr"];
      } else if ($model_nama !== '' && $attr !== '') {
        $instalasi_id = $_POST["$model_nama"]["$attr"];
      }
      $models = null;
      $models = CHtml::listData(LBRuanganM::getRuangans($instalasi_id), 'ruangan_id', 'ruangan_nama');

      if ($encode) {
        echo CJSON::encode($models);
      } else {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        if (count((array)$models) > 0) {
          foreach ($models as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * set dropdown penjamin pasien dari carabayar_id
   * @param type $encode
   * @param type $namaModel
   */
  public function actionSetDropdownPenjaminPasien($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $carabayar_id = $_POST["$namaModel"]['carabayar_id'];
      if ($encode) {
        echo CJSON::encode($penjamin);
      } else {
        if (empty($carabayar_id)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $carabayar_id), array('order' => 'penjamin_nama ASC'));
          if (count((array)$penjamin) > 1) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          }
          $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
          foreach ($penjamin as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  public function actionPrint()
  {
    $this->layout = '//layouts/iframe';
    $modTarifRad = new LBTariftindakanperdaruanganV('searchInformasi');
    //  $modTarifRad->jenistarif_id = Params::JENISTARIF_ID_PELAYANAN;
    $modTarifRad->instalasi_id = Yii::app()->user->getState('instalasi_id');
    //$modTarifRad->carabayar_id = Params::CARABAYAR_ID_MEMBAYAR;
    //$modTarifRad->penjamin_id = Params::PENJAMIN_ID_UMUM;
    if (isset($_GET['LBTariftindakanperdaruanganV'])) {
      $modTarifRad->attributes = $_GET['LBTariftindakanperdaruanganV'];
      //$modTarifRad->carabayar_id=$_GET['ROTarifpemeriksaanradruanganV']['carabayar_id'];
      //$modTarifRad->penjamin_id=$_GET['ROTarifpemeriksaanradruanganV']['penjamin_id'];
    }
    $this->render($this->path_view . 'print', array('modTarifRad' => $modTarifRad));
  }
}
