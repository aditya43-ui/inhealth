<?php
Yii::import('gudangUmum.models.*');
Yii::import('gudangUmum.controllers.PesanbarangTController');
class PesanbarangTLKController extends PesanbarangTController
{
    public function actionIndex($id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(563);
        return PesanbarangTController::actionIndex($id, $linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(558);
        return PesanbarangTController::actionInformasi($linkHalaman);
    }
}
