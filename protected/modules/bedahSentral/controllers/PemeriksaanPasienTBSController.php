<?php
Yii::import('rawatJalan.controllers.PemeriksaanPasienController');
Yii::import('rawatJalan.models.*');
class PemeriksaanPasienTBSController extends PemeriksaanPasienController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'indexBS';
  public $path_view = 'rawatJalan.views.pemeriksaanPasien.';
  /**
   * Lists all models.
   */
  public function actionIndexBS($pendaftaran_id)
  {
    $modPendaftaran = PendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $this->render('bedahSentral.views.pemeriksaanPasienTBS.index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
    ));
  }
}
