<?php
Yii::import('rawatJalan.models.*');
Yii::import('rawatJalan.controllers.InformasiPembebasanTarifController');
class InformasiPembebasanTarifRDController extends InformasiPembebasanTarifController
{
  public function actionIndex($a = null) {
      $linkHalaman = CustomFunction::getUrlByMenuID(3492);
      return InformasiPembebasanTarifController::actionIndex($linkHalaman);
  }
}
