<?php
Yii::import('pendaftaranPenjadwalan.controllers.BuatJanjiPoliTController');
Yii::import('pendaftaranPenjadwalan.models.*');
class BuatJanjiPoliTMCUController extends BuatJanjiPoliTController
{
  public $title = 'MCU';
  public function actionAdmin($a = null)
  {
      $linkHalaman = CustomFunction::getUrlByMenuID(2975);
      return BuatJanjiPoliTController::actionAdmin($linkHalaman);
  }
}
