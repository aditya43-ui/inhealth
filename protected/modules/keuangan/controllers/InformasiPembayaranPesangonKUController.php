<?php
Yii::import("penggajian.models.*");
Yii::import("penggajian.controllers.InformasiPembayaranPesangonController");
class InformasiPembayaranPesangonKUController extends InformasiPembayaranPesangonController
{
    public function actionIndex($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(3358);
        return InformasiPembayaranPesangonController::actionIndex($linkHalaman);
    }
}
