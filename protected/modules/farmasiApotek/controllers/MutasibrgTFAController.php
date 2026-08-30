<?php
Yii::import('gudangUmum.models.*');
Yii::import('gudangUmum.controllers.MutasibrgTController');
class MutasibrgTFAController extends MutasibrgTController
{
  public function actionIndex($id = null, $a = null)
  {
      $linkHalaman = CustomFunction::getUrlByMenuID(552);
      return MutasibrgTController::actionIndex($id, $linkHalaman);
  }
  public function actionInformasi($a = null) {
      $linkHalaman = CustomFunction::getUrlByMenuID(242);
      return MutasibrgTController::actionInformasi($linkHalaman);
  }
}
