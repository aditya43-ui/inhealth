<?php
Yii::import('gudangUmum.models.*');
Yii::import('gudangUmum.controllers.PesanbarangTController');
class PesanbarangTAKController extends PesanbarangTController
{
    public function actionIndex($id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(111);
        return PesanbarangTController::actionIndex($id, $linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(25);
        return PesanbarangTController::actionInformasi($linkHalaman);
    }
}
