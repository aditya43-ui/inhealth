<?php
Yii::import('kepegawaian.controllers.RencanaLemburTController');
Yii::import('kepegawaian.models.*');
Yii::import('kepegawaian.views.*');
class RencanaLemburTPJController extends RencanaLemburTController
{
  public $modul_sk = 'PJ';
  public function actionBuat($id = null, $sukses = '', $a = null)
  {
      $linkHalaman = CustomFunction::getUrlByMenuID(3405);
      return RencanaLemburTController::actionBuat($id, $sukses, $linkHalaman);
  }
  public function actionInformasi($a = null) {
      $linkHalaman = CustomFunction::getUrlByMenuID(3404);
      return RencanaLemburTController::actionInformasi($linkHalaman);
  }
}
