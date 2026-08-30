<?php
Yii::import('gudangUmum.controllers.InfoPemakaianBarangController');
Yii::import('gudangUmum.models.*');
class InfoPemakaianBarangRIController extends InfoPemakaianBarangController
{
    public function actionIndex($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(1542);
        return InfoPemakaianBarangController::actionIndex($linkHalaman);
    }
}
