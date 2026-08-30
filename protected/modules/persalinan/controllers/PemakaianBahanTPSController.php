<?php
Yii::import('rawatJalan.controllers.PemakaianBahanRJController');
Yii::import('rawatJalan.models.*');
class PemakaianBahanTPSController extends PemakaianBahanRJController
{
    public function actionIndex1($pasienmasukpenunjang_id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(222);
        return PemakaianBahanRJController::actionIndex($pasienmasukpenunjang_id, $linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(216);
        return PemakaianBahanRJController::actionInformasi($linkHalaman);
    }
}
