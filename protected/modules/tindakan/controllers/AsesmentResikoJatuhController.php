<?php

/**
 * Form Transaksi Asesment Skorin Resiko Jatuh
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.modules.rawatJalan
 * @subpackage controllers
 * @category controller
 */
class AsesmentResikoJatuhController extends MyAuthController
{
  /**
   *
   * @var string sebagai peraga untuk mengambil view.
   */
  public $path_view = "application.modules.rawatJalan.views.asesmentResikoJatuh.";
  public $init = '';

  /**
   * Menampilkan asesmen skoring resiko jatuh
   * @param integer $id ID PendaftaranT
   */
  public function actionIndex($id)
  {
    $this->layout = '//layouts/iframe';

    $model = new SkoringresikojatuhT();
    $model->tgl_skoring = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
    $model->pegawaiskoring_id = Yii::app()->user->getState('loginpemakai_id');
    // if ($this->init == '') {
      $model->pegawaiskoring_id = Yii::app()->user->getState('pegawai_id');
      if (!empty(Yii::app()->user->getState('pegawai_id'))) {
        $pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
        $model->pegawaiskoring_nama = $pegawai->namaLengkap;
      }
    // }
    $modPendaftaran = PendaftaranT::model()->findByPk($id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modResikoJatuh = SkoringresikojatuhT::model()->findAllByAttributes(array('pendaftaran_id' => $id));

    $cekSkoring = SkoringresikojatuhT::model()->findByAttributes(array('pendaftaran_id' => $id, 'pasien_id' => $modPendaftaran->pasien_id));

    if (isset($_POST['SkoringresikojatuhT'])) {
      $ok = true;
      $trans = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['SkoringresikojatuhT'];
        $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $model->pasien_id = $modPendaftaran->pasien_id;
        $model->create_time = date('Y-m-d H:i:s');
        $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $model->tgl_skoring = MyFormatter::formatDateTimeForDb($model->tgl_skoring);
        $ok = $ok && $model->save();

        if ($ok) {
          $p = PendaftaranT::model()->findByPk($model->pendaftaran_id);
          $p->setStatusPeriksa(Params::STATUSPERIKSA_SEDANG_PERIKSA);

          $trans->commit();
          Yii::app()->user->setFlash('success', "Data Sukses Disimpan");
          $this->redirect(array('index', 'id' => $model->pendaftaran_id, 'skoringresikojatuh_id' => $model->skoringresikojatuh_id, 'sukses' => 1,));
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan !");
        }
      } catch (Exception $e) {
        $trans->rollback();
        $btn_ulang = "<a class='btn btn-danger' href='javascript:document.location.reload();' rel='tooltip' title='Klik tombol ini lalu klik \"Resend\" '>"
          . "<i class='icon-refresh icon-white'></i> Simpan Ulang"
          . "</a>";
        Yii::app()->user->setFlash('error', "Data pasien gagal disimpan ! " . $btn_ulang . " " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modResikoJatuh' => $modResikoJatuh,
    ));
  }

  /**
   * Mencetak asesmen skoring resiko jatuh
   * @param type $id
   */
  public function actionPrint($id)
  {
    $this->layout = '//layouts/printWindows';
    $modPendaftaran = PendaftaranT::model()->findByPk($id);
    $model = SkoringresikojatuhT::model()->findAll('pendaftaran_id = ' . $modPendaftaran->pendaftaran_id);
    //            $model = SkoringresikojatuhT::model()->findAll(array('pendaftaran_id = '.$modPendaftaran->pendaftaran_id));
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

    $this->render($this->path_view . 'print', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'model' => $model,
    ));
  }

  /**
   * Menampilkan detail skoring resiko jatuh
   * @param type $id
   */
  public function actionDetail($id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter();
    $modResikoJatuh = SkoringresikojatuhT::model()->findByPk($id);
    $modPendaftaran = PendaftaranT::model()->findByPk($modResikoJatuh->pendaftaran_id);
    $this->render($this->path_view . '/_detailResikoJatuh', array(
      'model' => $modPendaftaran,
      'format' => $format,
      'modResikoJatuh' => $modResikoJatuh,
    ));
  }

  /**
   * Mencetak detail skoring resiko jatuh
   * @param type $id
   */
  public function actionPrintDetail($id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modPendaftaran = PendaftaranT::model()->findByPk($id);
    $modResikoJatuh = SkoringresikojatuhT::model()->findByAttributes(array('pendaftaran_id' => $id));
    $this->render($this->path_view . '/_detailResikoJatuh', array(
      'model' => $modPendaftaran,
      'format' => $format,
      'modResikoJatuh' => $modResikoJatuh,
    ));
  }
}
