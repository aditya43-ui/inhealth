<?php
class AsuhanGiziPasienController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'rawatInap.views.asuhanGiziPasien.';

  public function actionIndex($pendaftaran_id, $pasienadmisi_id=null)
  {

    if(!empty($pasienadmisi_id)) {

      $modPendaftaran = RIInfokunjunganriV::model()->findByAttributes(array(
        'pendaftaran_id' => $pendaftaran_id,
      ));

    } else {

      $modPendaftaran = PendaftaranT::model()->findByAttributes(array(
        'pendaftaran_id' => $pendaftaran_id,
      ));

    }
    
    $modPasien = RIPasienM::model()->findByPk($modPendaftaran->pasien_id);
    if(empty($pasienadmisi_id)) {
      $modAdmisi = new RIPasienAdmisiT;
    } else {
      $modAdmisi = RIPasienAdmisiT::model()->findByPk($pasienadmisi_id);
    }
    $format = new MyFormatter();

    $this->render($this->path_view . 'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modAdmisi' => $modAdmisi,
    ));
  }
}
