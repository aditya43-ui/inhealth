<?php
Yii::import('gudangUmum.models.*');
Yii::import('gudangUmum.controllers.MutasibrgTController');
class MutasibrgTSAController extends MutasibrgTController
{
  public function actionIndex($id = null, $a = null)
  {
      $linkHalaman = CustomFunction::getUrlByMenuID(741);
      return MutasibrgTController::actionIndex($id, $linkHalaman);
  }
  public function actionInformasi($a = null) {
      $linkHalaman = CustomFunction::getUrlByMenuID(583);
      return MutasibrgTController::actionInformasi($linkHalaman);
  }
}
