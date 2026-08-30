<?php
Yii::import('gudangUmum.models.*');
Yii::import('gudangUmum.controllers.MutasibrgTController');
class MutasibrgTRJController extends MutasibrgTController
{
  public function actionIndex($id = null, $a = null)
  {
      $linkHalaman = CustomFunction::getUrlByMenuID(538);
      return MutasibrgTController::actionIndex($id, $linkHalaman);
  }
  public function actionInformasi($a = null) {
      $linkHalaman = CustomFunction::getUrlByMenuID(73);
      return MutasibrgTController::actionInformasi($linkHalaman);
  }
}
