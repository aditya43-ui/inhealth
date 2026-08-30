<?php
Yii::import('gizi.controllers.PesanmenudietTController');
Yii::import('gizi.models.*');
class PesanmenudietRITController extends PesanmenudietTController
{
    public function actionIndexTamu($id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(3423);
        return PesanmenudietTController::actionIndexTamu($id, $linkHalaman);
    }
    public function actionInformasiPendamping($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(3045);
        return PesanmenudietTController::actionInformasiPendamping($linkHalaman);
    }
    public function actionIndexPegawai($id = null, $a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(382);
        return PesanmenudietTController::actionIndexPegawai($id, $linkHalaman);
    }
}
