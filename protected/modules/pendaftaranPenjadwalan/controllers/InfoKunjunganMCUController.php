<?php

class InfoKunjunganMCUController extends MyAuthController
{
  public $path_view = 'pendaftaranPenjadwalan.views.infoKunjunganMCU.';
  public $rujukantersimpan = false;
  public $asuransipasientersimpan = false;
  public $septersimpan = false;

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Mcu";
    $format = new MyFormatter();
    $modInfokunjunganmcuV = new PPInfokunjunganmcuV;
    $modInfokunjunganmcuV->tgl_awal = date('Y-m-d');
    $modInfokunjunganmcuV->tgl_akhir = date('Y-m-d');
    $modInfokunjunganmcuV->tgl_awall = date('Y-m-d');
    $modInfokunjunganmcuV->tgl_akhirl = date('Y-m-d');
    $modInfokunjunganmcuV->ceklis = false;
    if (isset($_REQUEST['PPInfokunjunganmcuV'])) {
      $modInfokunjunganmcuV->attributes = $_REQUEST['PPInfokunjunganmcuV'];
      $modInfokunjunganmcuV->ceklis = $_REQUEST['PPInfokunjunganmcuV']['ceklis'];
      $modInfokunjunganmcuV->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PPInfokunjunganmcuV']['tgl_awal']);
      $modInfokunjunganmcuV->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PPInfokunjunganmcuV']['tgl_akhir']);
      $modInfokunjunganmcuV->tgl_awall = $format->formatDateTimeForDb($_REQUEST['PPInfokunjunganmcuV']['tgl_awall']);
      $modInfokunjunganmcuV->tgl_akhirl = $format->formatDateTimeForDb($_REQUEST['PPInfokunjunganmcuV']['tgl_akhirl']);
      // $modInfokunjunganmcuV->rujukandari_id = $_GET['PPInfokunjunganmcuV']['rujukandari_id'];
      $modInfokunjunganmcuV->tgl_awal = $modInfokunjunganmcuV->tgl_awal . " 00:00:00";
      $modInfokunjunganmcuV->tgl_akhir = $modInfokunjunganmcuV->tgl_akhir . " 23:59:59";
    }
    $this->render($this->path_view . 'index', array('format' => $format, 'modInfokunjunganmcuV' => $modInfokunjunganmcuV));
  }

  public function actionGetPenjaminPasien($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $carabayar_id = $_POST["$namaModel"]['carabayar_id'];

      if ($encode) {
        echo CJSON::encode($penjamin);
      } else {
        if (empty($carabayar_id)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $carabayar_id, 'penjamin_aktif' => true), array('order' => 'penjamin_nama ASC'));
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
