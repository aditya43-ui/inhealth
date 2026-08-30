<?php

/**
 *       Controller ini untuk extends ke controller Verifikasi Tagihan
 *       @author	Deni Hamdani <denihamdani@piindonesia.co.id>
 *       @website	<piindonesia.co.id>
 */
Yii::import('billingKasir.models.*');
Yii::import('billingKasir.controllers.VerifikasiTagihanController');
class VerifikasiTagihanKUController extends VerifikasiTagihanController
{
    public function actionIndex($id = null, $pendaftaran_id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(2268);
        return VerifikasiTagihanController::actionIndex($id, $pendaftaran_id, $linkHalaman);
    }
    public function actionInformasi($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(2267);
        return VerifikasiTagihanController::actionInformasi($linkHalaman);
    }
}
