<?php
Yii::import('gizi.controllers.PesanmenudietTController');
Yii::import('gizi.models.*');
class PesanmenudietTROController extends PesanmenudietTController
{
    public function actionIndexPegawai($id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(3438);
        return PesanmenudietTController::actionIndexPegawai($id, $linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(3437);
        return PesanmenudietTController::actionInformasi($linkHalaman);
    }
}
