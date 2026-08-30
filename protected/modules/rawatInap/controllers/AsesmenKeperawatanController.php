<?php

/**
 *   - digunakan sebagai url utama untuk mengelola transaksi asesmen keperawatan
 *   @author	M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 *   @website	<piindonesia.co.id>
 */
class AsesmenKeperawatanController extends MyAuthController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/iframe';
    public $defaultAction = 'index';
    public $path_view = 'rawatInap.views.asesmenKeperawatan.';
    public $path_perkembangan = 'rawatInap.views.perkembanganTerintegrasiPasienT.';
    public $init = '';
   // public $modPasien;

    /**
     * action utama untuk masuk ke menu transaksi asesmen keperawatan
     * @param type $id
     * @param type $pasienmasukpenunjang_id
     */
    public function actionIndex($id, $pasienmasukpenunjang_id = null) {

        $modPendaftaran = PendaftaranT::model()->findByPk($id);
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        $model = new RIPerkembanganTerintegrasiPasienT;
        $model->pendaftaran_id = $id;
        $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);


        if (!empty($pasienmasukpenunjang_id)) {
            $modPenunjang = RIPasienMasukPenunjangT::model()->findByAttributes
                    (array('pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'pendaftaran_id' => $id));
        } else {
            $modPenunjang = new RIPasienMasukPenunjangT;
        }

        $this->render($this->path_view . 'index', array(
        
        'model' => $model,
        'modPendaftaran' => $modPendaftaran,
        'modPasien' => $modPasien,
        'modPenunjang' => $modPenunjang,
        'modAdmisi' => $modAdmisi,
        ));
    }

}
