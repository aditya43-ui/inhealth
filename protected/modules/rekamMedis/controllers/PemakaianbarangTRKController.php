<?php
Yii::import('gudangUmum.controllers.PemakaianbarangTController');
Yii::import('gudangUmum.models.*');
class PemakaianbarangTRKController extends PemakaianbarangTController
{
    public function actionIndex($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(1711);
        return PemakaianbarangTController::actionIndex($linkHalaman);
    }
}
