<?php
Yii::import('billingKasir.controllers.PengajuanKlaimPiutangController');
Yii::import('billingKasir.models.*');
class PengajuanKlaimPiutangKUController extends PengajuanKlaimPiutangController
{
    public function actionIndex($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(2250);
        return PengajuanKlaimPiutangController::actionIndex($linkHalaman);
    }
}
