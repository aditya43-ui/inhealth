<?php
Yii::import('gudangUmum.models.*');
Yii::import('gudangUmum.controllers.PesanbarangTController');
class PesanbarangTPPController extends PesanbarangTController
{
    public function actionIndex($id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(101);
        return PesanbarangTController::actionIndex($id, $linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(9);
        return PesanbarangTController::actionInformasi($linkHalaman);
    }
}
