<?php
Yii::import("penggajian.models.*");
Yii::import("penggajian.controllers.PembayaranJasaController");
class PembayaranJasaDokterController extends PembayaranJasaController
{
    public function actionCreate($id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(2125);
        return PembayaranJasaController::actionCreate($id, $linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(2123);
        return PembayaranJasaController::actionInformasi($linkHalaman);
    }
}
