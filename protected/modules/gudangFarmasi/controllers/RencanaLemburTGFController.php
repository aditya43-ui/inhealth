<?php
Yii::import('kepegawaian.controllers.RencanaLemburTController');
Yii::import('kepegawaian.models.*');
Yii::import('kepegawaian.views.*');
class RencanaLemburTGFController extends RencanaLemburTController
{
  public $modul_sk = 'GF';
  public function actionBuat($id = null, $sukses = null, $a = null)
  {
      $linkHalaman = CustomFunction::getUrlByMenuID(2215);
      return RencanaLemburTController::actionBuat($id, $sukses, $linkHalaman);
  }
  public function actionInformasi($a = null) {
      $linkHalaman = CustomFunction::getUrlByMenuID(2183);
      return RencanaLemburTController::actionInformasi($linkHalaman);
  }
}
