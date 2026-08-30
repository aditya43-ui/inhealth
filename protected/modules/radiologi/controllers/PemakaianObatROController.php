<?php
Yii::import('farmasiApotek.controllers.PemakaianObatController');
Yii::import('farmasiApotek.models.*');
class PemakaianObatROController extends PemakaianObatController
{
    public function actionIndex($pemakaianobat_id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(900);
        return PemakaianObatController::actionIndex($pemakaianobat_id, $linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(1566);
        return PemakaianObatController::actionInformasi($linkHalaman);
    }
}
