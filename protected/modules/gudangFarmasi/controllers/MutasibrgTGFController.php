<?php
Yii::import('gudangUmum.models.*');
Yii::import('gudangUmum.controllers.MutasibrgTController');
class MutasibrgTGFController extends MutasibrgTController
{
  public function actionIndex($id = null, $a = null)
  {
      $linkHalaman = CustomFunction::getUrlByMenuID(1312);
      return MutasibrgTController::actionIndex($id, $linkHalaman);
  }
  public function actionInformasi($a = null) {
      $linkHalaman = CustomFunction::getUrlByMenuID(735);
      return MutasibrgTController::actionInformasi($linkHalaman);
  }
}
