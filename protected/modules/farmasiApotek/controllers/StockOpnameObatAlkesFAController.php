<?php
Yii::import('gudangFarmasi.models.*');
Yii::import('gudangFarmasi.controllers.StockOpnameObatAlkesController');
class StockOpnameObatAlkesFAController extends StockOpnameObatAlkesController
{
    public function actionIndex($formuliropname_id = null,$stokopname_id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(1293);
        return StockOpnameObatAlkesController::actionIndex($formuliropname_id, $stokopname_id, $linkHalaman);
    }
}
