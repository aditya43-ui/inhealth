<?php
Yii::import('sterilisasi.controllers.PemesananPeralatanSterilRuanganTController');
Yii::import('sterilisasi.models.*');
Yii::import('sterilisasi.views.*');
class PemesananPeralatanSterilRuanganTROController extends PemesananPeralatanSterilRuanganTController
{
    public function actionIndex($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(3433);
        return PemesananPeralatanSterilRuanganTController::actionIndex($linkHalaman);
    }
}
