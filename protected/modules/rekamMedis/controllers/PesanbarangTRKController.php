<?php
Yii::import('gudangUmum.controllers.PesanbarangTController');
Yii::import('gudangUmum.models.*');
class PesanbarangTRKController extends PesanbarangTController
{
    public function actionIndex($id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(106);
        return PesanbarangTController::actionIndex($id, $linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(13);
        return PesanbarangTController::actionInformasi($linkHalaman);
    }
}
