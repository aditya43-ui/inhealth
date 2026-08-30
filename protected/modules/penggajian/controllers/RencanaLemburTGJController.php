<?php
Yii::import('kepegawaian.controllers.RencanaLemburTController');
Yii::import('kepegawaian.models.*');
Yii::import('kepegawaian.views.*');
class RencanaLemburTGJController extends RencanaLemburTController
{
  public $modul_sk = 'GJ';
  public function actionBuat($id = null, $sukses = '', $linkHalaman = null)
  {
      $linkHalaman = CustomFunction::getUrlByMenuID(3401);
      return RencanaLemburTController::actionBuat($id, $sukses, $linkHalaman);
  }
  public function actionInformasi($a = null) {
      $linkHalaman = CustomFunction::getUrlByMenuID(3400);
      return RencanaLemburTController::actionInformasi($linkHalaman);
  }
}
