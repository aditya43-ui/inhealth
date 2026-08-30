<?php
Yii::import('kepegawaian.controllers.RencanaLemburTController');
Yii::import('kepegawaian.models.*');
Yii::import('kepegawaian.views.*');
class RencanaLemburTBSController extends RencanaLemburTController
{
  public $modul_sk = 'BS';
  public function actionBuat($id = null, $sukses = null, $a = null)
  {
      $linkHalaman = CustomFunction::getUrlByMenuID(2211);
      return RencanaLemburTController::actionBuat($id, $sukses, $linkHalaman);
  }
  public function actionInformasi($a = null) {
      $linkHalaman = CustomFunction::getUrlByMenuID(2179);
      return RencanaLemburTController::actionInformasi($linkHalaman);
  }
}
