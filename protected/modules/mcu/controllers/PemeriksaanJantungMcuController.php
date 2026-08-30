<?php

/** 
 * digunakan untuk transaksi pemeriksaan Jantung pada module MCU
 * @author rusdiyanto <rusdiyanto@.com>
 * @package    application.modules.mcu
 * @subpackage controllers
 */
class PemeriksaanJantungMcuController extends MyAuthController
{
  public $path_view = 'mcu.views.pemeriksaanJantungMcu.';
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';

  /**
   * digunakan menampilkan halaman transaksi dan proses insert 
   * @params integer $pendaftaran_id 
   * @params string $baru
   */
  public function actionIndex($pendaftaran_id, $baru = null)
  {
    $criteria = new CDbCriteria();
    $criteria->addCondition('pendaftaran_id =' . $pendaftaran_id);
    $criteria->order = 'checkup_jantung_id DESC';
    $modPemeriksaanjantung = McuPemeriksaanjantungT::model()->find($criteria);

    if (empty($modPemeriksaanjantung) || isset($baru)) {
      $modPemeriksaanjantung = new McuPemeriksaanjantungT();
      $modPemeriksaanjantung->tgl_pemeriksaan = date('Y-m-d H:i:s');
    }
    $format = new MyFormatter();
    $modPemeriksaanjantungRiwayat = new McuPemeriksaanjantungT();
    if (isset($pendaftaran_id)) {
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $modPegawai = PegawaiV::model()->findByAttributes(array('pegawai_id' => Yii::app()->user->getState('pegawai_id')));
      $modPemeriksaanjantung->dokterpemeriksa_id = $modPegawai->pegawai_id;
      $modPemeriksaanjantungRiwayat = McuPemeriksaanjantungT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    }
    if (isset($_POST['McuPemeriksaanjantungT'])) {
      $ok = true;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modPemeriksaanjantung->attributes = $_POST['McuPemeriksaanjantungT'];
        $modPemeriksaanjantung->tgl_pemeriksaan = date('Y-m-d H:i:s');
        $modPemeriksaanjantung->pasien_id = $modPendaftaran->pasien_id;
        $modPemeriksaanjantung->dokterpemeriksa_id = $modPemeriksaanjantung->dpjp_id;
        $modPemeriksaanjantung->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modPemeriksaanjantung->create_time = date('Y-m-d H:i:s');
        $modPemeriksaanjantung->create_loginpemakai_id = Yii::app()->user->id;
        $modPemeriksaanjantung->create_ruangan = Yii::app()->user->getState('ruangan_id');
        if ($modPemeriksaanjantung->save()) {
          $ok = true;
        } else {
          $ok = false;
        }

        if ($ok == true) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
          $this->redirect(array('index', 'pendaftaran_id' => $modPemeriksaanjantung->pendaftaran_id, 'sukses' => 1));
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
      'modPemeriksaanjantung' => $modPemeriksaanjantung,
      'modPemeriksaanjantungRiwayat' => $modPemeriksaanjantungRiwayat,
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
      'modPegawai' => $modPegawai
    ));
  }

  /**
   * @author rusdiyanto <rusdiyanto@.com>
   * digunakan untuk delete data pemeriksaan jantung
   */
  public function actionSetDelete()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $checkup_jantung_id = isset($_POST['id']) ? $_POST['id'] : " ";
      $modPemeriksaanJantung = McuPemeriksaanjantungT::model()->findByPk($checkup_jantung_id);

      if ($modPemeriksaanJantung->delete()) {
        $data['status'] = true;
        $data['pesan'] = 'data pemeriksaan jantung berhasil dihapus !!';
      } else {
        $data['status'] = false;
        $data['pesan'] = 'data pemeriksaan jantung gagal dihapus !!';
      }

      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  /**
   * fungsi digunakan untuk detail pemeriksaan jantung
   * @author rusdiyanto <rusdiyanto@.com>
   * @params integer $id
   */
  public function actionDetail($id)
  {
    $this->layout = "//layouts/iframe";
    $format = new MyFormatter();
    $modPemeriksaanjantung = McuPemeriksaanjantungT::model()->findByPk($id);
    $modPegawai = PegawaiV::model()->findByAttributes(array('pegawai_id' => $modPemeriksaanjantung->dokterpemeriksa_id));

    $this->render($this->path_view . 'detail', array(
      'modPemeriksaanjantung' => $modPemeriksaanjantung,
      'format' => $format,
      'modPegawai' => $modPegawai

    ));
  }

  /**
   * Fungsi untuk mencetak hasil pemeriksaan jantung
   * @author Aida Rahmawati <aida.rhmw@gmail.com>
   * @param type $id
   */
  public function actionPrint($id)
  {
    $caraPrint = 'PRINT';
    if (isset($_GET['caraPrint'])){
        $caraPrint = $_GET['caraPrint'];
    }
    if ($caraPrint == 'frame'){
        $this->layout = '//layouts/iframe';
    }else{
        $this->layout = '//layouts/printWindows';
    }
    $format = new MyFormatter();
    $modPemeriksaanjantung = McuPemeriksaanjantungT::model()->findByPk($id);
    $modPegawai = PegawaiV::model()->findByAttributes(array('pegawai_id' => $modPemeriksaanjantung->dokterpemeriksa_id));
    $modPendaftaran = PendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $modPemeriksaanjantung->pendaftaran_id));
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

    $this->render($this->path_view . 'printout/index', array(
      'model' => $modPemeriksaanjantung,
      'format' => $format,
      'modPegawai' => $modPegawai,
      'modPasien' => $modPasien,
      'modPendaftaran' => $modPendaftaran
    ));
  }

  /**
   * fungsi untuk ubah data pemeriksaan jantung
   * @author rusdiyanto <rusdiyanto@.com>
   * @params integer $id
   */
  public function actionUpdate($id)
  {
    $this->layout = "//layouts/iframe";
    $format = new MyFormatter();
    $modPemeriksaanjantung = McuPemeriksaanjantungT::model()->findByPk($id);
    if (isset($_POST['McuPemeriksaanjantungT'])) {
      $ok = true;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model = McuPemeriksaanjantungT::model()->findByPk($_POST['McuPemeriksaanjantungT']['checkup_jantung_id']);
        $model->attributes = $_POST['McuPemeriksaanjantungT'];
//        $model->tgl_pemeriksaan = $format->formatDateTimeForDb($_POST['McuPemeriksaanjantungT']['tgl_pemeriksaan']);
        $modPemeriksaanjantung->dokterpemeriksa_id = $modPemeriksaanjantung->dpjp_id;
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
          $this->redirect(array('index', 'id' => $model->checkup_jantung_id,'pendaftaran_id'=>$model->pendaftaran_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Pemeriksaan jantung gagal diubah !");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data pemeriksaan jantung Bahan gagal diubah ! " . MyExceptionMessage::getMessage($ex, true));
      }
    }
    $this->render($this->path_view . 'ubah/_formUbah', array(
      'modPemeriksaanjantung' => $modPemeriksaanjantung,
      'format' => $format,

    ));
  }
}
