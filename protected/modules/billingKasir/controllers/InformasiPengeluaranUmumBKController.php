<?php
Yii::import('keuangan.models.*');
Yii::import('keuangan.controllers.InformasiPengeluaranUmumController');
class InformasiPengeluaranUmumBKController extends InformasiPengeluaranUmumController
{
    public function actionIndex($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(275);
        return InformasiPengeluaranUmumController::actionIndex($linkHalaman);
    }
}
