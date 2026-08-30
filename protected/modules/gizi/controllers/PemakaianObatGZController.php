<?php
Yii::import('farmasiApotek.controllers.PemakaianObatController');
Yii::import('farmasiApotek.models.*');
class PemakaianObatGZController extends PemakaianObatController
{
    public function actionIndex($pemakaianobat_id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(3103);
        return PemakaianObatController::actionIndex($pemakaianobat_id, $linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(797);
        return PemakaianObatController::actionInformasi($linkHalaman);
    }
}
