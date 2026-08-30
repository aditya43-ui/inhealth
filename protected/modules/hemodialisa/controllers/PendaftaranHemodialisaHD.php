<?php
Yii::import('pendaftaranPenjadwalan.models.*');
Yii::import('pendaftaranPenjadwalan.controllers.PendaftaranRawatDaruratHDController');
class PendaftaranHemodialisaHD extends PendaftaranRawatDaruratHDController { 
    
    public function actionIndex($id = null, $idSep = null, $idAntrian = null, $sk_id = null) {
       return PendaftaranRawatDaruratHDController::actionIndex($id, $idSep, $idAntrian, $sk_id);
    }
    
}

