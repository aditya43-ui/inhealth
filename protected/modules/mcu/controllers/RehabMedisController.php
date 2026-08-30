<?php

Yii::import("rehabMedis.controllers.DaftarPasienController");
Yii::import("rehabMedis.models.*");
Yii::import("rehabMedis.views.*");
class RehabMedisController extends MyAuthController
{
  public $layout = '//layouts/iframe';

  public function actionHasilPemeriksaan($pendaftaran_id)
  {
    $penunjang = PasienmasukpenunjangT::model()->findByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
      'ruangan_id' => Params::RUANGAN_ID_FISIOTERAPI,
    ));

    if (empty($penunjang)) {
      echo "Pemeriksaan Fisioterapi tidak Ditemukan";
      Yii::app()->end();
    }

    $con = new DaftarPasienController('rehabMedis', Yii::app()->getModule('mcu'));
    $con->layout = $this->layout;

    $con->actionHasilPemeriksaan($pendaftaran_id, $penunjang->pasien_id, $penunjang->pasienmasukpenunjang_id);
  }

  public function actionHasilPeriksaPrint($pendaftaran_id, $pasien_id, $pasienmasukpenunjang_id, $caraPrint = null)
  {
    $con = new DaftarPasienController('rehabMedis', Yii::app()->getModule('mcu'));

    $con->actionHasilPeriksaPrint($pendaftaran_id, $pasien_id, $pasienmasukpenunjang_id, $caraPrint);
  }
}
