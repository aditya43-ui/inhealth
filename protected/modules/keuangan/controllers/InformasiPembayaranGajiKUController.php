<?php
Yii::import("penggajian.models.*");
Yii::import("penggajian.controllers.InformasiPembayaranGajiController");
class InformasiPembayaranGajiKUController extends InformasiPembayaranGajiController
{
    public function actionIndex($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(2128);
        return InformasiPembayaranGajiController::actionIndex($linkHalaman);
    }
}
