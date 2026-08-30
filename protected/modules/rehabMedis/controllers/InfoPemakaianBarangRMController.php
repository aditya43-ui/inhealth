<?php
Yii::import('gudangUmum.controllers.InfoPemakaianBarangController');
Yii::import('gudangUmum.models.*');
class InfoPemakaianBarangRMController extends InfoPemakaianBarangController
{
    public function actionIndex($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(2703);
        return InfoPemakaianBarangController::actionIndex($linkHalaman);
    }
}
