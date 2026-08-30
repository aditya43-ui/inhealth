<?php
Yii::import('keuangan.models.*');
Yii::import('keuangan.controllers.PengeluaranUmumController');
class PengeluaranUmumBKController extends PengeluaranUmumController
{
    public function actionIndex($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(300);
        return PengeluaranUmumController::actionIndex($linkHalaman);
    }
}
