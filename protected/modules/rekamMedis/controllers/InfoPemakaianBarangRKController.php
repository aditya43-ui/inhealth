<?php
Yii::import('gudangUmum.controllers.InfoPemakaianBarangController');
Yii::import('gudangUmum.models.*');
class InfoPemakaianBarangRKController extends InfoPemakaianBarangController
{
    public function actionIndex($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(1553);
        return InfoPemakaianBarangController::actionIndex($linkHalaman);
    }
}
