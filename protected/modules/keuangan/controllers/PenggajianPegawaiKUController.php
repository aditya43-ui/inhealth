<?php
Yii::import("penggajian.models.*");
Yii::import("penggajian.controllers.PenggajianpegTController");
class PenggajianPegawaiKUController extends PenggajianpegTController
{
    public function actionCreate($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(2137);
        return PenggajianpegTController::actionCreate($linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(2126);
        return PenggajianpegTController::actionInformasi($linkHalaman);
    }
}
