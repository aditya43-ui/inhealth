<?php
class VerifikasiApotekerController extends MyAuthController
{
    public $path_view = 'rawatInap.views.verifikasiApoteker.';
    function actionIndex($pendaftaran_id) {
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = $modPendaftaran->pasien;
        $modAdmisi = $modPendaftaran->admisi;
        $this->render('index',[
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modAdmisi' => $modAdmisi
        ]);
    }
}