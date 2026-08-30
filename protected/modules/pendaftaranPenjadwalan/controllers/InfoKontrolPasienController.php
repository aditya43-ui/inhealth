<?php

class InfoKontrolPasienController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Rencana Kontrol";
    $format = new MyFormatter();
    $model = new PPPendaftaranT;
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->tgl_awalrenkon = date('Y-m-d');
    $model->tgl_akhirrenkon = date('Y-m-d');
    if (isset($_GET['PPPendaftaranT'])) {
      $model->attributes = $_GET['PPPendaftaranT'];

      $model->no_rekam_medik = $_GET['PPPendaftaranT']['no_rekam_medik'];
      $model->nama_pasien = $_GET['PPPendaftaranT']['nama_pasien'];
      $model->alamat_pasien = $_GET['PPPendaftaranT']['alamat_pasien'];
      $model->ruangan_id = $_GET['PPPendaftaranT']['ruangan_id'];

      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPPendaftaranT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPPendaftaranT']['tgl_akhir']);
      $model->tgl_awalrenkon = $format->formatDateTimeForDb($_GET['PPPendaftaranT']['tgl_awalrenkon']);
      $model->tgl_akhirrenkon = $format->formatDateTimeForDb($_GET['PPPendaftaranT']['tgl_akhirrenkon']);
      $model->prefix_pendaftaran = $_GET['PPPendaftaranT']['prefix_pendaftaran'];

      $model->ceklis = $_REQUEST['PPPendaftaranT']['ceklis'];
    }

    $this->render(
      'index',
      array(
        'model' => $model, 'format' => $format
      )
    );
  }

  public function loadModel($id)
  {
    $model = PPPendaftaranT::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'ppinfokontrolpasien-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionDynamicRuangan()
  {

    $dataRuangan = array();
    if (isset($_POST['PPPendaftaranT']['instalasi_id'])) {
      $instalasi = (int)$_POST['PPPendaftaranT']['instalasi_id'];
      $dataRuangan = RuanganM::model()->findAll('instalasi_id=:instalasi_id AND ruangan_aktif = TRUE order by ruangan_nama', array(':instalasi_id' => $instalasi));
    }

    $data = CHtml::listData($dataRuangan, 'ruangan_id', 'ruangan_nama');
    $i = 0;
    if (count((array)$data) > 0) {
      if ($i == 0) {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      }

      foreach ($data as $value => $name) {
        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        $i++;
      }
    }
  }

  /*
	* Mencari Ruangan berdasarkan instalasi di tabel kelas Ruangan M
	* and open the template in the editor.
	*/
  public function actionGetRuanganDariInstalasi($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan = array();
      $idInstalasi = $_POST["$namaModel"]['instalasi_id'];
      if (!empty($idInstalasi)) {
        $ruangan = RuanganM::model()->findAllByAttributes(array('instalasi_id' => $idInstalasi, 'ruangan_aktif' => true), array('order' => 'ruangan_nama'));
        $ruangan = CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama');
      }
      if (empty($idInstalasi)) {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      } else {
        if (count((array)$ruangan) > 1) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } elseif (count((array)$ruangan) == 0) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        }

        foreach ($ruangan as $value => $name) {
          echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      }
    }
    Yii::app()->end();
  }
}
