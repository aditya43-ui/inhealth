<?php
Yii::import('gudangUmum.models.*');
Yii::import('gudangUmum.controllers.PesanbarangTController');
class PesanbarangTGJController extends PesanbarangTController
{
    public function actionIndex($id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(2756);
        return PesanbarangTController::actionIndex($id, $linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(2749);
        return PesanbarangTController::actionInformasi($linkHalaman);
    }
}
