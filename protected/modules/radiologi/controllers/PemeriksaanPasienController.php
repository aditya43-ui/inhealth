<?php
class PemeriksaanPasienController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'radiologi.views.pemeriksaanPasien.';
  /**
   * Lists all models.
   */
  public function actionIndex($pasienmasukpenunjang_id)
  {
    $modPenunjang = PasienmasukpenunjangV::model()->findByAttributes(array(
      'pasienmasukpenunjang_id'=>$pasienmasukpenunjang_id
    ));
    $modPendaftaran = ROPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($modPenunjang->pendaftaran_id);
    $modPasien = ROPasienM::model()->findByPk($modPendaftaran->pasien_id);
    


    $this->render('index', array(
      'modPenunjang' => $modPenunjang,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
    ));
  }

}
