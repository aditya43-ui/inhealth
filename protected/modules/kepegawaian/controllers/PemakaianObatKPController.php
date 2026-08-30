<?php
Yii::import('farmasiApotek.controllers.PemakaianObatController');
Yii::import('farmasiApotek.models.*');
class PemakaianObatKPController extends PemakaianObatController
{
    public function actionIndex($pemakaianobat_id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(2308);
        return PemakaianObatController::actionIndex($pemakaianobat_id, $linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(1577);
        return PemakaianObatController::actionInformasi($linkHalaman);
    }
}
