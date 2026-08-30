<?php
Yii::import('gudangUmum.controllers.PemakaianbarangTController');
Yii::import('gudangUmum.models.*');
class PemakaianbarangTAKController extends PemakaianbarangTController
{
    public function actionIndex($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(1690);
        return PemakaianbarangTController::actionIndex($linkHalaman);
    }
}
