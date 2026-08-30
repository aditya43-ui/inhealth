<?php
Yii::import('kepegawaian.controllers.RencanaLemburTController');
Yii::import('kepegawaian.models.*');
Yii::import('kepegawaian.views.*');
class RencanaLemburTPSController extends RencanaLemburTController
{
  public $modul_sk = 'PS';
  public function actionBuat($id = null, $sukses = '', $linkHalaman = null)
  {
      $linkHalaman = CustomFunction::getUrlByMenuID(2220);
      return RencanaLemburTController::actionBuat($id, $sukses, $linkHalaman);
  }
  public function actionInformasi($a = null) {
      $linkHalaman = CustomFunction::getUrlByMenuID(2187);
      return RencanaLemburTController::actionInformasi($linkHalaman);
  }
}
