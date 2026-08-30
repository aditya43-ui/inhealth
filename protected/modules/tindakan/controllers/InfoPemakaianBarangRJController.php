<?php
Yii::import('gudangUmum.controllers.InfoPemakaianBarangController');
Yii::import('gudangUmum.models.*');
class InfoPemakaianBarangRJController extends InfoPemakaianBarangController
{
    public function actionIndex($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(1540);
        return InfoPemakaianBarangController::actionIndex($linkHalaman);
    }
}
