<?php
Yii::import("penggajian.models.*");
Yii::import("penggajian.controllers.PenggajianController");
class PembayaranGajiPegawaiController extends PenggajianController
{
    public function actionIndex($idPenggajian = null, $pengeluaranumum_id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(2129);
        return PenggajianController::actionIndex($idPenggajian, $pengeluaranumum_id, $linkHalaman);
    }
}
