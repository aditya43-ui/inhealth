<?php

/** 
 * digunakan untuk transaksi pemeriksaan Lain-lain pada module MCU
 * @author rusdiyanto <rusdiyanto@.com>
 * @package    application.modules.mcu
 * @subpackage controllers
 */
class PemeriksaanLainlainMcuController extends MyAuthController
{
  public $path_view = 'mcu.views.pemeriksaanLainlainMcu.';
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
    $criteria->order = 'checkup_lainlain_id DESC';
    $modMcuPemeriksaanlainlain = McuPemeriksaanlainlainT::model()->find($criteria);
    if (empty($modMcuPemeriksaanlainlain) || isset($baru)) {
      $modMcuPemeriksaanlainlain = new McuPemeriksaanlainlainT();
      $modMcuPemeriksaanlainlain->tgl_pemeriksaan = date('Y-m-d H:i:s');
    }
    $modMcuPemeriksaanlainlainRiwayat = new McuPemeriksaanlainlainT();
    if (isset($pendaftaran_id)) {
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $modMcuPemeriksaanlainlainRiwayat = McuPemeriksaanlainlainT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
      $modPegawai = PegawaiV::model()->findByAttributes(array(
        'pegawai_id' => Yii::app()->user->getState('pegawai_id'),
      ));
      $modMcuPemeriksaanlainlain->dokterpemeriksa_id = $modPegawai->pegawai_id;
    }
    if (isset($_POST['McuPemeriksaanlainlainT'])) {
      $ok = true;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modMcuPemeriksaanlainlain->attributes = $_POST['McuPemeriksaanlainlainT'];
        $modMcuPemeriksaanlainlain->tgl_pemeriksaan = $format->formatDateTimeForDb($_POST['McuPemeriksaanlainlainT']['tgl_pemeriksaan']);
        $modMcuPemeriksaanlainlain->pasien_id = $modPendaftaran->pasien_id;
        $modMcuPemeriksaanlainlain->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modMcuPemeriksaanlainlain->create_time = date('Y-m-d H:i:s');
        $modMcuPemeriksaanlainlain->create_loginpemakai_id = Yii::app()->user->id;
        $modMcuPemeriksaanlainlain->create_ruangan = Yii::app()->user->getState('ruangan_id');
        if ($modMcuPemeriksaanlainlain->save()) {
          $ok = true;
        } else {
          $ok = false;
        }

        if ($ok == true) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
          $this->redirect(array('index', 'pendaftaran_id' => $modMcuPemeriksaanlainlain->pendaftaran_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data  gagal disimpan!");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data  gagal disimpan ! " . MyExceptionMessage::getMessage($ex, true));
      }
    }
    $this->render($this->path_view . 'index', array(
      'modMcuPemeriksaanlainlain' => $modMcuPemeriksaanlainlain,
      'modMcuPemeriksaanlainlainRiwayat' => $modMcuPemeriksaanlainlainRiwayat,
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
      'modPegawai' => $modPegawai
    ));
  }

  /**
   * @author rusdiyanto <rusdiyanto@.com>
   * digunakan untuk delete data pemeriksaan lain-lain
   */
  public function actionSetDelete()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $checkup_lainlain_id = isset($_POST['id']) ? $_POST['id'] : " ";
      $modMcuPemeriksaanlainlain = McuPemeriksaanlainlainT::model()->findByPk($checkup_lainlain_id);

      if ($modMcuPemeriksaanlainlain->delete()) {
        $data['status'] = true;
        $data['pesan'] = 'data pemeriksaan lain-lain berhasil dihapus !!';
      } else {
        $data['status'] = false;
        $data['pesan'] = 'data pemeriksaan lain-lain gagal dihapus !!';
      }

      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  /**
   * fungsi digunakan untuk detail pemeriksaan lain-lain
   * @author rusdiyanto <rusdiyanto@.com>
   * @params integer $id
   */
  public function actionDetail($id)
  {
    $this->layout = "//layouts/iframe";
    $format = new MyFormatter();
    $modMcuPemeriksaanlainlain = McuPemeriksaanlainlainT::model()->findByPk($id);
    $modPegawai = PegawaiV::model()->findByAttributes(array('pegawai_id' => $modMcuPemeriksaanlainlain->dokterpemeriksa_id));
    $this->render($this->path_view . 'detail', array(
      'modMcuPemeriksaanlainlain' => $modMcuPemeriksaanlainlain,
      'format' => $format,
      'modPegawai' => $modPegawai

    ));
  }

  /**
   * fungsi untuk ubah data pemeriksaan Lain-lain
   * @author rusdiyanto <rusdiyanto@.com>
   * @params integer $id
   */
  public function actionUpdate($id)
  {
    $this->layout = "//layouts/iframe";
    $format = new MyFormatter();
    $modMcuPemeriksaanlainlain = McuPemeriksaanlainlainT::model()->findByPk($id);
    if (isset($_POST['McuPemeriksaanlainlainT'])) {
      $ok = true;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model = McuPemeriksaanlainlainT::model()->findByPk($_POST['McuPemeriksaanlainlainT']['checkup_lainlain_id']);
        $model->attributes = $_POST['McuPemeriksaanlainlainT'];
        $model->tgl_pemeriksaan = $format->formatDateTimeForDb($_POST['McuPemeriksaanlainlainT']['tgl_pemeriksaan']);
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
          $this->redirect(array('update', 'id' => $model->checkup_lainlain_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Pemeriksaan Lain-lain gagal diubah !");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data pemeriksaan Lain-lain Bahan gagal diubah ! " . MyExceptionMessage::getMessage($ex, true));
      }
    }
    $this->render($this->path_view . 'ubah/_formUbah', array(
      'modMcuPemeriksaanlainlain' => $modMcuPemeriksaanlainlain,
      'format' => $format,

    ));
  }
}
