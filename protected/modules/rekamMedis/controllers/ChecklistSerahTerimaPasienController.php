<?php
class ChecklistSerahTerimaPasienController extends MyAuthController
{
  public $layout = '//layouts/iframe';
	public $defaultAction = 'index';
  public $path_view = 'rekamMedis.views.checklistSerahTerimaPasien.';

  public function actionIndex($pendaftaran_id=null, $type=null)
  {
    $format = new MyFormatter();

    $modPendaftaran = PendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
   
    $this->render($this->path_view . 'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'type' => $type
    ));
  }
}
