<?php

/** 
 * digunakan untuk transaksi pemeriksaan Kandungan pada module MCU
 * @author rusdiyanto <rusdiyanto@.com>
 * @package    application.modules.mcu
 * @subpackage controllers
 */
class PemeriksaanKandunganMcuController extends MyAuthController
{
  public $path_view = 'mcu.views.pemeriksaanKandunganMcu.';
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';

  /**
   * digunakan menampilkan halaman transaksi dan proses insert 
   * @params integer $pendaftaran_id 
   * @params string $baru
   */
  public function actionIndex($pendaftaran_id, $baru = null)
  {
    $format = new MyFormatter();
    $criteria = new CDbCriteria();
    $criteria->addCondition('pendaftaran_id =' . $pendaftaran_id);
    $criteria->order = 'checkup_kandungan_id DESC';
    $ModPemeriksaankandungan = McuPemeriksaankandunganT::model()->find($criteria);
    if (empty($ModPemeriksaankandungan) || isset($baru))
      $ModPemeriksaankandungan = new McuPemeriksaankandunganT();
    $ModPemeriksaankandungan->tgl_pemeriksaan = date('Y-m-d H:i:s');
    $ModPemeriksaankandungan->tgl_haid_terakhir = date('Y-m-d');
    $ModPemeriksaankandunganRiwayat = new McuPemeriksaankandunganT();
    if (isset($pendaftaran_id)) {
      $ModPemeriksaankandunganRiwayat = McuPemeriksaankandunganT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $modPegawai = PegawaiV::model()->findByAttributes(array(
        'pegawai_id' => Yii::app()->user->getState('pegawai_id'),
      ));
      $ModPemeriksaankandungan->dokterpemeriksa_id = $modPegawai->pegawai_id;
    }
    if (isset($_POST['McuPemeriksaankandunganT'])) {
      $ok = true;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $ModPemeriksaankandungan->attributes = $_POST['McuPemeriksaankandunganT'];
        $ModPemeriksaankandungan->tgl_pemeriksaan = $format->formatDateTimeForDb($_POST['McuPemeriksaankandunganT']['tgl_pemeriksaan']);
        $ModPemeriksaankandungan->tgl_haid_terakhir = $format->formatDateTimeForDb($_POST['McuPemeriksaankandunganT']['tgl_haid_terakhir']);
        $ModPemeriksaankandungan->pasien_id = $modPendaftaran->pasien_id;
        $ModPemeriksaankandungan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $ModPemeriksaankandungan->create_time = date('Y-m-d H:i:s');
        $ModPemeriksaankandungan->create_loginpemakai_id = Yii::app()->user->id;
        $ModPemeriksaankandungan->create_ruangan = Yii::app()->user->getState('ruangan_id');
        if ($ModPemeriksaankandungan->save()) {
          $ok = true;
        } else {
          $ok = false;
        }
        if ($ok == true) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
          $this->redirect(array('index', 'pendaftaran_id' => $ModPemeriksaankandungan->pendaftaran_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data  gagal disimpan!");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan ! " . MyExceptionMessage::getMessage($ex, true));
      }
    }
    $this->render($this->path_view . 'index', array(
      'format' => $format,
      'ModPemeriksaankandungan' => $ModPemeriksaankandungan,
      'ModPemeriksaankandunganRiwayat' => $ModPemeriksaankandunganRiwayat,
      'modPegawai' => $modPegawai
    ));
  }
  /**
   * @author rusdiyanto <rusdiyanto@.com>
   * digunakan untuk delete data pemeriksaan kandungan
   */
  public function actionSetDelete()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $checkup_kandungan_id = isset($_POST['id']) ? $_POST['id'] : " ";
      $modPemeriksaanKandungan = McuPemeriksaankandunganT::model()->findByPk($checkup_kandungan_id);

      if ($modPemeriksaanKandungan->delete()) {
        $data['status'] = true;
        $data['pesan'] = 'data pemeriksaan KAndungan berhasil dihapus !!';
      } else {
        $data['status'] = false;
        $data['pesan'] = 'data pemeriksaan KAndungan gagal dihapus !!';
      }

      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }
  /**
   * fungsi digunakan untuk detail pemeriksaan kandungan
   * @author rusdiyanto <rusdiyanto@.com>
   * @params integer $id
   */
  public function actionDetail($id)
  {
    $this->layout = "//layouts/iframe";
    $format = new MyFormatter();
    $ModPemeriksaankandungan = McuPemeriksaankandunganT::model()->findByPk($id);
    $modPegawai = PegawaiV::model()->findByAttributes(array('pegawai_id' => $ModPemeriksaankandungan->dokterpemeriksa_id));

    $this->render($this->path_view . 'detail', array(
      'ModPemeriksaankandungan' => $ModPemeriksaankandungan,
      'format' => $format,
      'modPegawai' => $modPegawai

    ));
  }

  /**
   * fungsi untuk ubah data pemeriksaan kandungan
   * @author rusdiyanto <rusdiyanto@.com>
   * @params integer $id
   */
  public function actionUpdate($id)
  {
    $this->layout = "//layouts/iframe";
    $format = new MyFormatter();
    $ModPemeriksaankandungan = McuPemeriksaankandunganT::model()->findByPk($id);
    if (isset($_POST['McuPemeriksaankandunganT'])) {
      $ok = true;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model = McuPemeriksaankandunganT::model()->findByPk($_POST['McuPemeriksaankandunganT']['checkup_kandungan_id']);
        $model->attributes = $_POST['McuPemeriksaankandunganT'];
        $model->tgl_pemeriksaan = $format->formatDateTimeForDb($_POST['McuPemeriksaankandunganT']['tgl_pemeriksaan']);
        $model->tgl_haid_terakhir = $format->formatDateTimeForDb($_POST['McuPemeriksaankandunganT']['tgl_haid_terakhir']);
        $model->update_time = date('Y-m-d H:i:s');
        $model->update_loginpemakai_id = Yii::app()->user->id;
        if ($model->update()) {
          $ok = true;
        } else {
          $ok = false;
        }
        if ($ok == true) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Berhasil diubah");
          $this->redirect(array('update', 'id' => $model->checkup_kandungan_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Pemeriksaan Kandungan gagal diubah !");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data pemeriksaan Kandungan gagal diubah ! " . MyExceptionMessage::getMessage($ex, true));
      }
    }
    $this->render($this->path_view . 'ubah/_formUbah', array(
      'ModPemeriksaankandungan' => $ModPemeriksaankandungan,
      'format' => $format,

    ));
  }

  /**
   * Digunakan untuk mencetak data
   * @author Andyka <andykaputra@.com>
   * @param type $id
   */
  public function actionPrint($id)
  {
    $this->layout = '//layouts/printWindows';
    $model = McuPemeriksaankandunganT::model()->findByPk($id);
    $modPendaftaran = PendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

    $this->render($this->path_view . 'Print', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'model' => $model,
    ));
  }
}
