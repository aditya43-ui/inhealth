<?php
Yii::import("keuangan.models.*");
Yii::import("keuangan.controllers.PembayaranJasaDokterController");
class PengajuanJasaMedisREController extends PembayaranJasaDokterController
{
    public function actionCreate($id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(2551);
        return PembayaranJasaDokterController::actionCreate($id = null, $linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(2550);
        return PembayaranJasaDokterController::actionInformasi($linkHalaman);
    }
}
