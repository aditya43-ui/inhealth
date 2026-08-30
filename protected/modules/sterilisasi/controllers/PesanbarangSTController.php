<?php
Yii::import('gudangUmum.controllers.PesanbarangTController');
Yii::import('gudangUmum.models.*');
class PesanbarangSTController extends PesanbarangTController
{
    public function actionIndex($id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(3037);
        return PesanbarangTController::actionIndex($id, $linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(3033);
        return PesanbarangTController::actionInformasi($linkHalaman);
    }
}
