<?php
Yii::import('gudangUmum.controllers.PesanbarangTController');
Yii::import('gudangUmum.models.*');
class PesanbarangTKUController extends PesanbarangTController
{
    public function actionIndex($id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(127);
        return PesanbarangTController::actionIndex($id, $linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(41);
        return PesanbarangTController::actionInformasi($linkHalaman);
    }
}
