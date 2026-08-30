<?php
Yii::import('kepegawaian.controllers.RencanaLemburTController');
Yii::import('kepegawaian.models.*');
Yii::import('kepegawaian.views.*');
class RencanaLemburTROController extends RencanaLemburTController
{
  public $modul_sk = 'RO';
  public function actionBuat($id = null, $sukses = '', $a = null)
  {
      $linkHalaman = CustomFunction::getUrlByMenuID(2221);
      return RencanaLemburTController::actionBuat($id, $sukses, $linkHalaman);
  }
  public function actionInformasi($a = null) {
      $linkHalaman = CustomFunction::getUrlByMenuID(2188);
      return RencanaLemburTController::actionInformasi($linkHalaman);
  }
}
