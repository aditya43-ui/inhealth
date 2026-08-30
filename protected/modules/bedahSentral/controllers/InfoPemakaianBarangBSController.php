<?php
Yii::import('gudangUmum.controllers.InfoPemakaianBarangController');
Yii::import('gudangUmum.models.*');
class InfoPemakaianBarangBSController extends InfoPemakaianBarangController
{
    public function actionIndex($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(1547);
        return InfoPemakaianBarangController::actionIndex($linkHalaman);
    }
}
