<?php
Yii::import('gudangUmum.controllers.InfoPemakaianBarangController');
Yii::import('gudangUmum.models.*');
class InfoPemakaianBarangGZController extends InfoPemakaianBarangController
{
    public function actionIndex($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(1548);
        return InfoPemakaianBarangController::actionIndex($linkHalaman);
    }
}
