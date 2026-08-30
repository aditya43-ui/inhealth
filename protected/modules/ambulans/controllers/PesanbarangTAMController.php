<?php

Yii::import('gudangUmum.models.*');
Yii::import('gudangUmum.controllers.PesanbarangTController');

class PesanbarangTAMController extends PesanbarangTController
{
    public function actionIndex($id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(2568);
        return PesanbarangTController::actionIndex($id, $linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(2584);
        return PesanbarangTController::actionInformasi($linkHalaman);
    }
}
