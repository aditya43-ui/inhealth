<?php
Yii::import('sterilisasi.controllers.PengajuanSterilisasiRuanganTController');
Yii::import('sterilisasi.models.*');
Yii::import('sterilisasi.views.*');
class PengajuanSterilisasiRuanganTRDController extends PengajuanSterilisasiRuanganTController
{
    public function actionIndex($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(3324);
        return PengajuanSterilisasiRuanganTController::actionIndex($linkHalaman);
    }
}
