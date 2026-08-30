<?php

/**
 * RND-7811 : INI SUDAH TIDAK DIGUNAKAN LAGI, FUNCTION PINDAHKAN KE CONTROLLER MASING2
 */
class ActionAjaxController extends MyAuthController
{
  public function actionCekHakAkses()
  {
    if (!Yii::app()->user->checkAccess('Administrator')) {
      //throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));
      $data['cekAkses'] = false;
    } else {
      $pendaftaran = PendaftaranT::model()->findByPk($_POST['pendaftaran_id']);
      $data['pendaftaran'] = $pendaftaran->attributes;
      //echo 'punya hak akses';
      $pasienAdmisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran->pendaftaran_id));
      $ruangan_m = RuanganM::model()->findByPk($pasienAdmisi->ruangan_id);
      //                $kamar_m = KamarruanganM::model()->findByPk($pasienAdmisi->kamarruangan_id);
      $data['ruanganPasien'] =  $ruangan_m->ruangan_nama;
      //                $data['nokamarPasien'] = $kamar_m->kamarruangan_nokamar;
      //                $data['nobedPasien'] = $kamar_m->kamarruangan_nobed;
      $data['cekAkses'] = true;
      $data['userid'] = Yii::app()->user->id;
      $data['username'] = Yii::app()->user->name;
    }

    echo CJSON::encode($data);
    Yii::app()->end();
  }

  public function actiondataPasien()
  {
    $pasien_id = $_POST['pasien_id'];
    $pendaftaran_id = $_POST['pendaftaran_id'];
    $modPasien = RIPasienM::model()->findByPk($pasien_id);
    $modPendaftaran = RIPendaftaranT::model()->findByPk($pendaftaran_id);
    $form = $this->renderPartial('/_ringkasDataPasien', array(
      'modPasien' => $modPasien,
      'modPendaftaran' => $modPendaftaran,
    ), true);

    $data['form'] = $form;
    echo CJSON::encode($data);
  }
}
