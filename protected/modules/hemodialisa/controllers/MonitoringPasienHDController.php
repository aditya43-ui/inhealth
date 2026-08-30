<?php

/**
 * Digunakan sebagai url utama untuk mengelola transaksi monitoring pasien hemodialisa
 * @author Andyka Putra <andykaputra@.com>
 * @package application.modules.hemodialisa
 * @subpackage controllers
 */
class MonitoringPasienHDController extends MyAuthController {

    public $defaultAction = 'index';
    public $path_view = 'hemodialisa.views.monitoringPasienHD.';
    public $init = '';

    /**
     * action utama untuk masuk ke menu transaksi monitoring pasien hemodialisa
     * @param type $pendaftaran_id
     * @param type $pasienmasukpenunjang_id
     */
    public function actionIndex($pendaftaran_id, $pasienmasukpenunjang_id = null) {
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        if (!empty($pasienmasukpenunjang_id)) {
            $modPenunjang = PasienmasukpenunjangT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'pendaftaran_id' => $pendaftaran_id));
        } else {
            $modPenunjang = new PasienmasukpenunjangT;
        }

        $this->render($this->path_view . 'index', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'modPenunjang' => $modPenunjang
        ));
    }

}
