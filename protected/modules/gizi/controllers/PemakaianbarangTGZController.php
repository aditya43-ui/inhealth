<?php
Yii::import('gudangUmum.controllers.PemakaianbarangTController');
Yii::import('gudangUmum.models.*');
class PemakaianbarangTGZController extends PemakaianbarangTController
{
    public function actionIndex($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(1696);
        return PemakaianbarangTController::actionIndex($linkHalaman);
    }
}
