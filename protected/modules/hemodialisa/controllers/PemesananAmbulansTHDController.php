<?php
Yii::import('ambulans.controllers.PemesananAmbulansPasienRSController');
Yii::import('ambulans.models.*');
Yii::import('ambulans.views.pemesananAmbulansPasienRS.');
class PemesananAmbulansTHDController extends PemesananAmbulansPasienRSController
{
    public function actionIndex($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(2801);
        return PemesananAmbulansPasienRSController::actionIndex($linkHalaman);
    }
}
