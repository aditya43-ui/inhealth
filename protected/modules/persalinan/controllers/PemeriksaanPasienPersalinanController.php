<?php
class PemeriksaanPasienPersalinanController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'persalinan.views.pemeriksaanPasienPersalinan.';
  /**
   * Lists all models.
   */
  public function actionIndex($pendaftaran_id)
  {
    $modPendaftaran = PSPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = PSPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $this->render('index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
    ));
  }
}
