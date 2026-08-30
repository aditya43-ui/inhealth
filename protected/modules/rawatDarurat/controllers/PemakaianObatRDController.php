<?php
Yii::import('farmasiApotek.controllers.PemakaianObatController');
Yii::import('farmasiApotek.models.*');
class PemakaianObatRDController extends PemakaianObatController
{
    public function actionIndex($pemakaianobat_id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(144);
        return PemakaianObatController::actionIndex($pemakaianobat_id, $linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(1563);
        return PemakaianObatController::actionInformasi($linkHalaman);
    }
}
