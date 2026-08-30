<?php
Yii::import('mcu.controllers.PendaftaranPasienController');
Yii::import('mcu.models.*');
class PendaftaranPasienMCUController extends PendaftaranPasienController
{
    public function actionIndex($id = null, $idSep = null, $pendaftaran_id = null, $a = null)
    {
        
        $linkHalaman = CustomFunction::getUrlByMenuID(3328);
        return PendaftaranPasienController::actionIndex($id, $idSep, $pendaftaran_id, $linkHalaman);
    }
}
