<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MonitoringGiziController
 *
 * @author inova
 */
class MonitoringGiziController extends MyAuthController
{
  public $path_view = "rawatInap.views.monitoringGizi.";

  public function actionIndex($pendaftaran_id, $pasienadmisi_id)
  {
    $this->layout = '//layouts/iframe';

    $asesmen = AsesmengiziT::model()->findByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
      //'pasienadmisi_id'=>$pasienadmisi_id,
    ), array(
      'condition' => 'pasienmasukpenunjang_id is null'
    ));

    if (empty($asesmen)) {
      echo "Lakukan input Asesmen Gizi sebelum melakukan transaksi ini.";
      Yii::app()->end();
    }

    $pendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

    $model = new MonitoringgiziranapT;
    $model->tglmonitoringgizi = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
    $model->pendaftaran_id = $pendaftaran_id;
    $model->pasienadmisi_id = $pasienadmisi_id;
    $model->pasien_id = $pendaftaran->pasien_id;
    $model->instalasi_id = Yii::app()->user->getState('instalasi_id');
    $model->asesmengizi_id = $asesmen->asesmengizi_id;


    if (isset($_POST['MonitoringgiziranapT'])) {
      $model->attributes = $_POST['MonitoringgiziranapT'];
      $model->tglmonitoringgizi = MyFormatter::formatDateTimeForDB($model->tglmonitoringgizi);

      $model->create_time = date('Y-m-d H:i:s');
      $model->create_loginpemakai_id = Yii::app()->user->id;
      $model->create_ruangan = Yii::app()->user->getState('ruangan_id');


      if ($model->validate() && $model->save()) {

        Yii::app()->user->setFlash('success', "Monitoring Gizi berhasil disimpan");

        $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id));
      } else {
        Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data gagal disimpan ' . '<pre>' .
          print_r($model->getErrors(), 1) . '</pre>');
      }
    }

    $this->render($this->path_view . "create", array(
      'model' => $model,
      'asesmen' => $asesmen
    ));
  }

  public function actionHapus()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    MonitoringgiziranapT::model()->deleteByPk($_POST['id']);

    echo "";
  }
}
