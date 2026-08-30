<?php
class InformasiAntrianPoliklinikController extends MyAuthController
{
  //    	public $layout='//layouts/column1';
  //        public $defaultAction = 'index';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Antrian Poliklinik";
    $modInfoAntrianPoli = new INInfokunjunganrjV();
    $modInfoAntrianPoli->unsetAttributes();
    if (isset($_GET['INInfokunjunganrjV'])) {
      $modInfoAntrianPoli->attributes = $_GET['INInfokunjunganrjV'];
      $modInfoAntrianPoli->pegawai_id = $_GET['INInfokunjunganrjV']['pegawai_id'];
    }
    $this->render('index', array('modInfoAntrianPoli' => $modInfoAntrianPoli));
  }
  /**
   * Mengatur dropdown nama pegawai
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownPegawai($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modDokter = new DokterV;
      if ($model_nama !== '' && $attr == '') {
        $ruangan_id = $_POST["$model_nama"]['ruangan_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $ruangan_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $ruangan_id = $_POST["$model_nama"]["$attr"];
      }
      $dokter = null;
      if ($ruangan_id) {
        $dokter = $modDokter->getDokter($ruangan_id);
        $dokter = CHtml::listData($dokter, 'pegawai_id', 'NamaLengkap');
      }

      if ($encode) {
        echo CJSON::encode($dokter);
      } else {
        if (empty($dokter)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($dokter as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  public function actionPrintStatus($pendaftaran_id)
  {
    $this->redirect(Yii::app()->createUrl('pendaftaranPenjadwalan/pendaftaranRawatJalan/printStatus/', array("pendaftaran_id" => $pendaftaran_id)));
  }
}
