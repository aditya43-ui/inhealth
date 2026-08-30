<?php
Yii::import('sterilisasi.controllers.PengajuanSterilisasiRuanganTController');
Yii::import('sterilisasi.models.*');
Yii::import('sterilisasi.views.*');
class PengajuanSterilisasiRuanganTROController extends PengajuanSterilisasiRuanganTController
{
    public function actionIndex($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(3435);
        return PengajuanSterilisasiRuanganTController::actionIndex($linkHalaman);
    }
}
