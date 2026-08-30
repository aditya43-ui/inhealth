<?php
Yii::import('gudangUmum.models.*');
Yii::import('gudangUmum.controllers.MutasibrgTController');
class MutasibrgTGZController extends MutasibrgTController
{
  public function actionIndex($id = null, $a = null)
  {
      $linkHalaman = CustomFunction::getUrlByMenuID(585);
      return MutasibrgTController::actionIndex($id, $linkHalaman);
  }
  public function actionInformasi($a = null) {
      $linkHalaman = CustomFunction::getUrlByMenuID(277);
      return MutasibrgTController::actionInformasi($linkHalaman);
  }
}
