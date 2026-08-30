<?php
Yii::import('sterilisasi.controllers.InformasiPengajuanSterilisasiRuanganController');
Yii::import('sterilisasi.models.*');
Yii::import('sterilisasi.views.*');
class InformasiPengajuanSterilisasiROController extends InformasiPengajuanSterilisasiRuanganController
{
    public function actionIndex($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(3434);
        return InformasiPengajuanSterilisasiRuanganController::actionIndex($linkHalaman);
    }
}
