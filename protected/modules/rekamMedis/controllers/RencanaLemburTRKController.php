<?php
Yii::import('kepegawaian.controllers.RencanaLemburTController');
Yii::import('kepegawaian.models.*');
Yii::import('kepegawaian.views.*');
class RencanaLemburTRKController extends RencanaLemburTController
{
  public $modul_sk = 'RK';
  public function actionBuat($id = null, $sukses = '', $a = null)
  {
      $linkHalaman = CustomFunction::getUrlByMenuID(2225);
      return RencanaLemburTController::actionBuat($id, $sukses, $linkHalaman);
  }
  public function actionInformasi($a = null) {
      $linkHalaman = CustomFunction::getUrlByMenuID(2192);
      return RencanaLemburTController::actionInformasi($linkHalaman);
  }
}
