<?php
Yii::import('gudangUmum.controllers.PemakaianbarangTController');
Yii::import('gudangUmum.models.*');
class PemakaianbarangTRIController extends PemakaianbarangTController
{
    public function actionIndex($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(1708);
        return PemakaianbarangTController::actionIndex($linkHalaman);
    }
}
