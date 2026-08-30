<?php

/**
 *       - controller ini untuk extends ke controller Faktur Penerimaan Bahan Makanan
 *       @author		Deni Hamdani <denihamdani@piindonesia.co.id>
 *       @website	<piindonesia.co.id>
 */
Yii::import('gizi.models.*');
Yii::import('gizi.controllers.FakturTerimaBahanMakananController');
class FakturTerimaBahanMakananKUController extends FakturTerimaBahanMakananController
{
    public function actionIndex($id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(3352);
        return FakturTerimaBahanMakananController::actionIndex($id, $linkHalaman);
    }
    public function actionInformasi($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(3351);
        return FakturTerimaBahanMakananController::actionInformasi($linkHalaman);
    }
}
