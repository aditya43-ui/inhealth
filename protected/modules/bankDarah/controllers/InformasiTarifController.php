<?php

class InformasiTarifController extends MyAuthController
{
  public $path_view = 'bankDarah.views.informasiTarif.';
  public function actionIndex()
  {
    $modTarifLab = new BDTarifpemeriksaanlabruanganV('searchTarif');
    $modTarifLab->jenistarif_id = Params::JENISTARIF_ID_PELAYANAN;
    $modTarifLab->instalasi_id = Yii::app()->user->getState('instalasi_id');
    $modTarifLab->carabayar_id = Params::CARABAYAR_ID_MEMBAYAR;
    $modTarifLab->penjamin_id = Params::PENJAMIN_ID_UMUM;
    if (isset($_GET['BDTarifpemeriksaanlabruanganV'])) {
      $modTarifLab->attributes = $_GET['BDTarifpemeriksaanlabruanganV'];
      $modTarifLab->carabayar_id = $_GET['BDTarifpemeriksaanlabruanganV']['carabayar_id'];
      $modTarifLab->penjamin_id = $_GET['BDTarifpemeriksaanlabruanganV']['penjamin_id'];
    }
    $this->render($this->path_view . 'index', array('modTarifLab' => $modTarifLab));
  }

  public function actionDetailsTarif($idKelasPelayanan, $idDaftarTindakan, $idKategoriTindakan)
  {
    $this->layout = '//layouts/iframe';
    if ($idKelasPelayanan != '') {
      $modTarifTindakan = BDTariftindakanM::model()->with('komponentarif')->findAll('kelaspelayanan_id=' . $idKelasPelayanan . ' AND 
														   daftartindakan_id=' . $idDaftarTindakan . '
														   AND t.komponentarif_id!=' . Params::KOMPONENTARIF_ID_TOTAL . '');
    } else {
      $modTarifTindakan =  BDTariftindakanM::model()->with('komponentarif')->findAll('daftartindakan_id=' . $idDaftarTindakan . '
														   AND t.komponentarif_id!=' . Params::KOMPONENTARIF_ID_TOTAL . '
														   AND kelaspelayanan_id isNull');
    }
    $modTarif = TariftindakanperdaruanganV::model()->find('daftartindakan_id = ' . $idDaftarTindakan . ' and kelaspelayanan_id = ' . $idKelasPelayanan . ' and kategoritindakan_id = ' . $idKategoriTindakan);
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
      $models = CHtml::listData(BDRuanganM::getRuangans($instalasi_id), 'ruangan_id', 'ruangan_nama');

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
}
