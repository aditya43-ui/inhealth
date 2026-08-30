<?php
Yii::import('gudangFarmasi.models.*');
Yii::import('gudangFarmasi.controllers.InformasiStockOpnameObatAlkesController');
class InformasiStockOpnameObatAlkesFAController extends InformasiStockOpnameObatAlkesController
{
  /**
   * menampilkan link untuk print detail stock opname
   * @return type
   */
  public function getUrlPrint()
  {
    return $this->createUrl("stockOpnameObatAlkesFA/print");
  }
  public function actionIndex($a = null)
  {
      $linkHalaman = CustomFunction::getUrlByMenuID(1292);
      return InformasiStockOpnameObatAlkesController::actionIndex($linkHalaman);
  }
}
