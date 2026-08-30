<?php

/**
 * controller utama untuk mengakses tabulasi asesmen risiko jatuh
 * 
 * @package application.modules.rawatJalan
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0 
 * @link    <http://piindonesia.co.id>
 */
class AsesmenResikoJatuhPIController extends MyAuthController
{

  public $path_view = "rawatInap.views.asesmenResikoJatuh.";
  public $init = '';

  /**
   * digunakan untuk masuk ke halaman pemeriksaa resiko jatuh
   * @param type $pendaftaran_id, variabel yang wajib ada, untuk mengakses fungsi action ini
   */
  public function actionIndex($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';

    $model = new SkoringresikojatuhT();
    $model->tgl_skoring = date('Y-m-d H:i:s');
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modResikoJatuh = SkoringresikojatuhT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));

    $cekSkoring = SkoringresikojatuhT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'pasien_id' => $modPendaftaran->pasien_id));

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


        if ($model->validate()) {
          $ok = $ok && $model->save();
        } else {
          $ok = false;
        }

        // var_dump($model->attributes); die;

        if ($ok) {
          $trans->commit();
          Yii::app()->user->setFlash('success', "Data Sukses Disimpan");
          $this->redirect(array('index', 'pendaftaran_id' => $model->pendaftaran_id, 'skoringresikojatuh_id' => $model->skoringresikojatuh_id, 'sukses' => 1,));
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
   * mengenerate hasil inputan yang sudah disimpan, agar dapat ditampilkan dalam bentuk prinout
   * @param type $pendaftaran_id
   */
  public function actionPrint($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
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
   * untuk mengenerate detail data per riwayatnya
   * @param type $pendaftaran_id
   */
  public function actionDetail($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter();
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modResikoJatuh = SkoringresikojatuhT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $this->render($this->path_view . '/_detailResikoJatuh', array(
      'model' => $modPendaftaran,
      'format' => $format,
      'modResikoJatuh' => $modResikoJatuh,
    ));
  }

  /**
   * untuk mengenerate prinout detail data per riwayatnya
   * @param type $pendaftaran_id
   */
  public function actionPrintDetail($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modResikoJatuh = SkoringresikojatuhT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $this->render($this->path_view . '/_detailResikoJatuh', array(
      'model' => $modPendaftaran,
      'format' => $format,
      'modResikoJatuh' => $modResikoJatuh,
    ));
  }

  public function actionHapusRiwayatAsesmentResikoJatuh()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $skoringresikojatuh_id = (isset($_POST['skoringresikojatuh_id']) ? $_POST['skoringresikojatuh_id'] : null);
      $data['pesan'] = "";
      $data['sukses'] = 0;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $deletePemeriksaanFisik = SkoringresikojatuhT::model()->deleteAllByAttributes(array('skoringresikojatuh_id' => $skoringresikojatuh_id));
        if ($deletePemeriksaanFisik) {
          $data['pesan'] = "Riwayat Asesment Skoring Resiko Jatuh Berhasil Dihapus!";
          $data['sukses'] = 1;
          $transaction->commit();
        } else {
          $data['pesan'] = "Gagal Menghapus Asesment Skoring Resiko Jatuh";
          $data['sukses'] = 0;
          $transaction->rollback();
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $data['pesan'] = "Hapus Data Gagal :" . MyExceptionMessage::getMessage($exc, true);
      }
      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }
}
