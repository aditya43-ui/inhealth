<?php
Yii::import('gudangUmum.controllers.PemakaianbarangTController');
Yii::import('gudangUmum.models.*');
class PemakaianbarangTSAController extends PemakaianbarangTController
{
    public function actionIndex($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(777);
        return PemakaianbarangTController::actionIndex($linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(690);
        return PemakaianbarangTController::actionInformasi($linkHalaman);
    }
}
