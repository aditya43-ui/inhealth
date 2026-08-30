<?php
Yii::import('gudangFarmasi.models.*');
Yii::import('gudangFarmasi.controllers.InformasiFormulirStockOpnameObatAlkesController');
class InformasiFormulirStockOpnameObatAlkesFAController extends InformasiFormulirStockOpnameObatAlkesController
{
  /**
   * menampilkan url untuk print karena nama controller tiap modul yg extend berbeda
   * @return type
   */
  public function getUrlPrint()
  {
    return $this->createUrl("formulirStockOpnameObatAlkesFA/Print");
  }

  /**
   * menampilkan url untuk action stock opname karena nama controller tiap modul yg extend berbeda
   * @return type
   */
  public function getUrlStokOpname()
  {
    return $this->createUrl("StockOpnameObatAlkesFA/Index");
  }
  
  public function actionIndex($a = null)
  {
      $linkHalaman = CustomFunction::getUrlByMenuID(1290);
      return InformasiFormulirStockOpnameObatAlkesController::actionIndex($linkHalaman);
  }
}
