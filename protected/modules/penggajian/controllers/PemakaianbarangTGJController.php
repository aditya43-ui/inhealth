<?php
Yii::import('gudangUmum.controllers.PemakaianbarangTController');
Yii::import('gudangUmum.models.*');
class PemakaianbarangTGJController extends PemakaianbarangTController
{
    public function actionIndex($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(2758);
        return PemakaianbarangTController::actionIndex($linkHalaman);
    }
}
