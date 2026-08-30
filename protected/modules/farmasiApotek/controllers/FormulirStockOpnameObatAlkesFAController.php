<?php
Yii::import('gudangFarmasi.models.*');
Yii::import('gudangFarmasi.controllers.FormulirStockOpnameObatAlkesController');
class FormulirStockOpnameObatAlkesFAController extends FormulirStockOpnameObatAlkesController
{
    public function actionIndex($formuliropname_id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(1291);
        return FormulirStockOpnameObatAlkesController::actionIndex($formuliropname_id, $linkHalaman);
    }
}
