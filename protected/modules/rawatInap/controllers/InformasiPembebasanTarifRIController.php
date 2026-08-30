<?php
Yii::import('rawatJalan.models.*');
Yii::import('rawatJalan.controllers.InformasiPembebasanTarifController');
class InformasiPembebasanTarifRIController extends InformasiPembebasanTarifController
{
  public function actionIndex($a = null)
  {
      $linkHalaman = CustomFunction::getUrlByMenuID(3491);
      return InformasiPembebasanTarifController::actionIndex($linkHalaman);
  }
}
