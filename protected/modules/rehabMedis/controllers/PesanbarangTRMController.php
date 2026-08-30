<?php
Yii::import('gudangUmum.models.*');
Yii::import('gudangUmum.controllers.PesanbarangTController');
class PesanbarangTRMController extends PesanbarangTController
{
    public function actionIndex($id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(2719);
        return PesanbarangTController::actionIndex($id, $linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(2701);
        return PesanbarangTController::actionInformasi($linkHalaman);
    }
}
