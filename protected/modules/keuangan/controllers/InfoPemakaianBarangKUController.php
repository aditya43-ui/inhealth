<?php
Yii::import('gudangUmum.controllers.InfoPemakaianBarangController');
Yii::import('gudangUmum.models.*');
class InfoPemakaianBarangKUController extends InfoPemakaianBarangController
{
    public function actionIndex($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(1557);
        return InfoPemakaianBarangController::actionIndex($linkHalaman);
    }
}
