<?php
Yii::import('gudangUmum.controllers.InfoPemakaianBarangController');
Yii::import('gudangUmum.models.*');
class InfoPemakaianBarangHDController extends InfoPemakaianBarangController
{
    public function actionIndex($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(2809);
        return InfoPemakaianBarangController::actionIndex($linkHalaman);
    }
}
