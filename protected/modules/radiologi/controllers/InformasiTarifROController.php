<?php
Yii::import('laboratorium.controllers.InformasiTarifController');
Yii::import('laboratorium.models.*');
class InformasiTarifROController extends InformasiTarifController
{
  public $path_view_ro = 'radiologi.views.informasiTarifRO.';
  public function actionIndex()
  {
    $modTarifRad = new ROTarifTindakanPerdaRuanganV('searchInformasi');
    $modTarifRad->jenistarif_id = Params::JENISTARIF_ID_PELAYANAN;
    $modTarifRad->instalasi_id = Yii::app()->user->getState('instalasi_id');

    $kom_unit = Params::KomponenUnitRuangan();
    if (isset($kom_unit[Yii::app()->user->getState('ruangan_id')])) {
      $modTarifRad->komponenunit_id = $kom_unit[Yii::app()->user->getState('ruangan_id')];
    }

    $kel_tin = Params::KelompokTindakanInstalasi();

    if (isset($kel_tin[Yii::app()->user->getState('instalasi_id')])) {

      $modTarifRad->kelompoktindakan_id = $kel_tin[Yii::app()->user->getState('instalasi_id')];
    }
    //$modTarifRad->carabayar_id = Params::CARABAYAR_ID_MEMBAYAR;
    //$modTarifRad->penjamin_id = Params::PENJAMIN_ID_UMUM;
    if (isset($_GET['ROTarifTindakanPerdaRuanganV'])) {
      $modTarifRad->attributes = $_GET['ROTarifTindakanPerdaRuanganV'];
      //$modTarifRad->carabayar_id=$_GET['ROTarifpemeriksaanradruanganV']['carabayar_id'];
      //$modTarifRad->penjamin_id=$_GET['ROTarifpemeriksaanradruanganV']['penjamin_id'];
    }
    $this->render($this->path_view_ro . 'index', array('modTarifRad' => $modTarifRad));
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
      $models = CHtml::listData(RORuanganM::getRuangans($instalasi_id), 'ruangan_id', 'ruangan_nama');

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
    $modTarifRad = new ROTarifTindakanPerdaRuanganV('searchInformasi');
    //$modTarifRad->jenistarif_id = Params::JENISTARIF_ID_PELAYANAN;
    //$modTarifRad->instalasi_id = Yii::app()->user->getState('instalasi_id');
    //$modTarifRad->carabayar_id = Params::CARABAYAR_ID_MEMBAYAR;
    //$modTarifRad->penjamin_id = Params::PENJAMIN_ID_UMUM;
    if (isset($_GET['ROTarifTindakanPerdaRuanganV'])) {
      $modTarifRad->attributes = $_GET['ROTarifTindakanPerdaRuanganV'];
      //var_dump($modTarifRad->jenistarif_id);die;
      //$modTarifRad->carabayar_id=$_GET['ROTarifpemeriksaanradruanganV']['carabayar_id'];
      //$modTarifRad->penjamin_id=$_GET['ROTarifpemeriksaanradruanganV']['penjamin_id'];
    }
    $this->render($this->path_view_ro . 'print', array('modTarifRad' => $modTarifRad));
  }
}
