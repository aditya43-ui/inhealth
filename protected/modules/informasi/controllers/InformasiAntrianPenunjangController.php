<?php

class InformasiAntrianPenunjangController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Antrian Masuk Penunjang";
    $modAntrianPenunjang = new INPasienmasukpenunjangV();
    $modAntrianPenunjang->unsetAttributes();
    if (isset($_GET['INPasienmasukpenunjangV'])) {
      $modAntrianPenunjang->attributes = $_GET['INPasienmasukpenunjangV'];
      //                $modAntrianPenunjang->instalasi_id = $_GET['INPasienmasukpenunjangV']['instalasi_id'];
      $modAntrianPenunjang->ruangan_id = $_GET['INPasienmasukpenunjangV']['ruangan_id'];
      $modAntrianPenunjang->pegawai_id = $_GET['INPasienmasukpenunjangV']['pegawai_id'];
    }
    $this->render('index', array('modAntrianPenunjang' => $modAntrianPenunjang));
  }
  /**
   * Mengatur dropdown nama ruangan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modRuangan = new RuanganM;
      if ($model_nama !== '' && $attr == '') {
        $instalasi = $_POST["$model_nama"]['instalasi_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $instalasi = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $instalasi = $_POST["$model_nama"]["$attr"];
      }
      $ruangan = null;
      if ($instalasi) {
        $ruangan = $modRuangan->getRuanganByInstalasi($instalasi);
        $ruangan = CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama');
      }

      if ($encode) {
        echo CJSON::encode($ruangan);
      } else {
        if (empty($ruangan)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          //                   echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
          foreach ($ruangan as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
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
  public function actionPrintStatus($pendaftaran_id, $instalasi_id, $pasienmasukpenunjang_id)
  {
    switch ($instalasi_id) {
      case Params::INSTALASI_ID_LAB:
        $this->redirect(Yii::app()->createUrl('laboratorium/pendaftaranLaboratorium/printStatusLab/', array("pendaftaran_id" => $pendaftaran_id)));
        break;
      case Params::INSTALASI_ID_RAD:
        $this->redirect(Yii::app()->createUrl('radiologi/pendaftaranRadiologi/printStatusRad/', array("pendaftaran_id" => $pendaftaran_id)));
        break;
      case Params::INSTALASI_ID_IBS:
        $this->redirect(Yii::app()->createUrl('rawatJalan/bedahSentral/printRiwayat/', array("id" => $pendaftaran_id, "caraPrint" => "PRINT")));
        break;
      case Params::INSTALASI_ID_REHAB:
        $this->redirect(Yii::app()->createUrl('rehabMedis/pendaftaranRehabilitasiMedis/printStatusRehabMedis', array("pendaftaran_id" => $pendaftaran_id)));
        break;
      case Params::INSTALASI_ID_GIZI:
        $this->redirect(Yii::app()->createUrl('gizi/pendaftaranKonsultasiGizi/printStatus/', array("pendaftaran_id" => $pendaftaran_id)));
        break;
    }
  }
}
