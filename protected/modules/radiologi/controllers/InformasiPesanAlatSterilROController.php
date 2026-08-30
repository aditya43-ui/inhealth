<?php
Yii::import('sterilisasi.controllers.InformasiPesanAlatSterilRuanganController');
Yii::import('sterilisasi.models.*');
Yii::import('sterilisasi.views.*');
class InformasiPesanAlatSterilROController extends InformasiPesanAlatSterilRuanganController
{
    public function actionIndex($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(3432);
        return InformasiPesanAlatSterilRuanganController::actionIndex($linkHalaman);
    }
}
