<?php
Yii::import('sterilisasi.controllers.PengajuanSterilisasiRuanganTController');
Yii::import('sterilisasi.models.*');
Yii::import('sterilisasi.views.*');
class PengajuanSterilisasiRuanganTRJController extends PengajuanSterilisasiRuanganTController
{
    public function actionIndex($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(3323);
        return PengajuanSterilisasiRuanganTController::actionIndex($linkHalaman);
    }
}
