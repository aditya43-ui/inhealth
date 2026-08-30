<?php
Yii::import('farmasiApotek.controllers.PemakaianObatController');
Yii::import('farmasiApotek.models.*');
class PemakaianObatPSController extends PemakaianObatController
{
    public function actionIndex($pemakaianobat_id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(226);
        return PemakaianObatController::actionIndex($pemakaianobat_id, $linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(1572);
        return PemakaianObatController::actionInformasi($linkHalaman);
    }
}
