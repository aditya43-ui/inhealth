<?php
Yii::import('kepegawaian.controllers.RencanaLemburTController');
Yii::import('kepegawaian.models.*');
Yii::import('kepegawaian.views.*');
class RencanaLemburTRMController extends RencanaLemburTController
{
  public $modul_sk = 'RM';
  public function actionBuat($id = null, $sukses = '', $a = null)
  {
      $linkHalaman = CustomFunction::getUrlByMenuID(3373);
      return RencanaLemburTController::actionBuat($id, $sukses, $linkHalaman);
  }
  public function actionInformasi($a = null) {
      $linkHalaman = CustomFunction::getUrlByMenuID(3372);
      return RencanaLemburTController::actionInformasi($linkHalaman);
  }
}
