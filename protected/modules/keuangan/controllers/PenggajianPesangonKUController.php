<?php
Yii::import("penggajian.models.*");
Yii::import("penggajian.controllers.PenggajianPesangonController");
class PenggajianPesangonKUController extends PenggajianPesangonController
{
    public function actionIndex($idPenggajian = null, $pengeluaranumum_id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(3359);
        return PenggajianPesangonController::actionIndex($idPenggajian, $pengeluaranumum_id, $linkHalaman);
    }
}
