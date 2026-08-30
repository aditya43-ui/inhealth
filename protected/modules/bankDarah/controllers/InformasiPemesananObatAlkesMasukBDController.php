<?php

Yii::import('gudangFarmasi.models.*');
Yii::import('gudangFarmasi.controllers.InformasiPemesananObatAlkesMasukController');

class InformasiPemesananObatAlkesMasukBDController extends InformasiPemesananObatAlkesMasukController
{
  public $defaultAction = 'index';
  public $path_view = 'gudangFarmasi.views.informasiPemesananObatAlkesMasuk.';

  public function actionIndex()
  {
    $model = new GFInformasipesanobatalkesV('searchInformasiPemesananMasuk');
    $format = new MyFormatter();
    $model->tgl_awal = date("Y-m-d");
    $model->tgl_akhir = date("Y-m-d");
    $instalasiPemesanans = CHtml::listData(GFInstalasiM::getInstalasiPemesananObatAlkes(), 'instalasi_id', 'instalasi_nama');
    $ruanganPemesanans = CHtml::listData(GFRuanganM::getRuanganPemesananObatAlkes(Params::INSTALASI_ID_FARMASI), 'ruangan_id', 'ruangan_nama');

    if (isset($_GET['GFInformasipesanobatalkesV'])) {
      $model->attributes = $_GET['GFInformasipesanobatalkesV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['GFInformasipesanobatalkesV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFInformasipesanobatalkesV']['tgl_akhir']);
    }
    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'model' => $model,
      'instalasiPemesanans' => $instalasiPemesanans,
      'ruanganPemesanans' => $ruanganPemesanans,
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
        $instalasi_id = $_POST["$model_nama"]['instalasipemesan_id'];
      } else if ($model_nama == '' && $attr !== '') {
        $instalasi_id = $_POST["$attr"];
      } else if ($model_nama !== '' && $attr !== '') {
        $instalasi_id = $_POST["$model_nama"]["$attr"];
      }
      $models = null;
      $models = CHtml::listData(GFRuanganM::getRuanganPemesananObatAlkes($instalasi_id), 'ruangan_id', 'ruangan_nama');

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
   * menampilkan url print karna setiap modul berbeda
   */
  public function getUrlPrint()
  {
    return $this->createUrl('pemesananObatAlkesBD/print');
  }

  /**
   * menampilkan url action transaksi mutasi karna setiap modul berbeda
   */
  public function getUrlMutasi()
  {
    return $this->createUrl("MutasiObatAlkesBD/Index");
  }
}
