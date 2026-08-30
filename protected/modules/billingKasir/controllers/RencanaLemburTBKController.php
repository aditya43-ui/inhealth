<?php
Yii::import('kepegawaian.controllers.RencanaLemburTController');
Yii::import('kepegawaian.models.*');
Yii::import('kepegawaian.views.*');
class RencanaLemburTBKController extends RencanaLemburTController
{
  public $modul_sk = 'BK';
  public function actionBuat($id = null, $sukses = '', $a = null)
  {
      $linkHalaman = CustomFunction::getUrlByMenuID(2212);
      return RencanaLemburTController::actionBuat($id, $sukses, $linkHalaman);
  }
  public function actionInformasi($a = null) {
      $linkHalaman = CustomFunction::getUrlByMenuID(2180);
      return RencanaLemburTController::actionInformasi($linkHalaman);
  }
}
