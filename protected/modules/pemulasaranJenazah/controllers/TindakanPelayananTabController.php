<?php

class TindakanPelayananTabController extends MyAuthController
{
    public function actionIndex($pendaftaran_id, $instalasi_id, $pasienmasukpenunjang_id = null)
    {
        $this->pageTitle = Yii::app()->name . " - Tindakan Dan Pelayanan";
        $format = new MyFormatter();
        
        $modPasien = new PasienM();
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasienMasukPenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);

        if(empty($modPendaftaran)) {
            $modPendaftaran = new PendaftaranT();
        }
        if(empty($modPasienMasukPenunjang)) {
            $modPasienMasukPenunjang = new PasienmasukpenunjangT();
        }

        if(!empty($modPendaftaran)) {
            $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

            if(empty($modPasien)) {
                $modPasien = new PasienM();
            }
        }
        
        $this->render('index', [
            'modPendaftaran' => $modPendaftaran,
            'modPasienMasukPenunjang' => $modPasienMasukPenunjang,
            'modPasien' => $modPasien
        ]);
    }
}