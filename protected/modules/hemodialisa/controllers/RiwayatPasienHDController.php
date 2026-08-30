<?php
Yii::import('rawatJalan.models.*');
Yii::import('rawatJalan.controllers.DaftarPasienController');
class RiwayatPasienHDController extends DaftarPasienController
{
	public function actionGetRiwayatPasien($id) {
        return DaftarPasienController::actionGetRiwayatPasien($id);
    }  
    
//    public function actionDetailPersalinan($id) {
//        return parent::actionDetailPersalinan($id);
//    }
    
}

