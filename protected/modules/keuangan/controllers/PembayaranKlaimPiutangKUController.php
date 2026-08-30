<?php
Yii::import('billingKasir.controllers.PembayaranKlaimPiutangController');
Yii::import('billingKasir.models.*');
class PembayaranKlaimPiutangKUController extends PembayaranKlaimPiutangController
{
    public function actionIndex($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(2249);
        return PembayaranKlaimPiutangController::actionIndex($linkHalaman);
    }
}
