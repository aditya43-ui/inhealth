<?php
Yii::import('gudangUmum.controllers.InfoPemakaianBarangController');
Yii::import('gudangUmum.models.*');
class InfoPemakaianBarangLBController extends InfoPemakaianBarangController
{
    public function actionIndex($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(1543);
        return InfoPemakaianBarangController::actionIndex($linkHalaman);
    }
}
