<?php

/** 
 * digunakan untuk transaksi pemeriksaan Umum pada module MCU
 * @author rusdiyanto <rusdiyanto@.com>
 * @author Andyka <andykaputra@.com>
 * @author Elham Budianto <elhambudianto@.com>
 * @package    application.modules.mcu
 * @subpackage controllers
 */
class PemeriksaanUmumMcuController extends MyAuthController
{
  public $path_view = 'mcu.views.pemeriksaanUmumMcu.';
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
    $criteria->order = 'mcu_pemeriksaanumum_id DESC';
    $modpemeriksaanumum = McuPemeriksaanumumT::model()->find($criteria);

    if (empty($modpemeriksaanumum) || isset($baru)) {
      $modpemeriksaanumum = new McuPemeriksaanumumT;
      $modpemeriksaanumum->tgl_pemeriksaan = date('Y-m-d H:i:s');
    }
    
    $modKonsul = new KonsulpoliT();
    $modpemeriksaanumumRiwayat = new McuPemeriksaanumumT();
    if (isset($pendaftaran_id)) {
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $modPegawai = PegawaiV::model()->findByAttributes(array('pegawai_id' => $modPendaftaran->pegawai_id));
      $modpemeriksaanumum->dokterpemeriksa_id = $modPendaftaran->pegawai_id;
      $modpemeriksaanumumRiwayat = McuPemeriksaanumumT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    }
    
    $permintaanMCU = PermintaanmcuT::model()->find("pendaftaran_id = ".$pendaftaran_id);
    $modpemeriksaanumum->listpaketpemeriksaan = !empty($permintaanMCU)?$permintaanMCU->tipepaket->tipepaket_nama:'-';
    
    if (isset($_POST['McuPemeriksaanumumT'])) {
      $ok = true;
      $ok_konsul = true;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modpemeriksaanumum->attributes = $_POST['McuPemeriksaanumumT'];
        $modpemeriksaanumum->tgl_pemeriksaan = $format->formatDateTimeForDb($_POST['McuPemeriksaanumumT']['tgl_pemeriksaan']);
        $modpemeriksaanumum->pasien_id = $modPendaftaran->pasien_id;
        $modpemeriksaanumum->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $modpemeriksaanumum->create_time = date('Y-m-d H:i:s');
        $modpemeriksaanumum->create_loginpemakai_id = Yii::app()->user->id;
        $modpemeriksaanumum->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modpemeriksaanumum->jeniskeperluanmcu = $_POST['McuPemeriksaanumumT']['jeniskeperluanmcu'];

        if ($modpemeriksaanumum->save()) {
          if (isset($_POST['KonsulpoliT']) && $_POST['McuPemeriksaanumumT']['is_konsul'] == true) {
            $modKonsul->attributes = $_POST['KonsulpoliT'];
            $modKonsul->tglkonsulpoli = $format->formatDateTimeForDb($_POST['KonsulpoliT']['tglkonsulpoli']);
            $modKonsul->create_ruangan = Yii::app()->user->getState('ruangan_id');
            $modKonsul->create_loginpemakai_id = Yii::app()->user->id;
            $modKonsul->create_time = date('Y-m-d H:i:s');
            $modKonsul->statusperiksa = Params::STATUSPERIKSA_SEDANG_PERIKSA;
            $modKonsul->pasien_id = $modPendaftaran->pasien_id;
            $modKonsul->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $modKonsul->asalpoliklinikkonsul_id = $modPendaftaran->ruangan_id;
            $modKonsul->validate();
            echo CHtml::errorSummary($modKonsul);
            if ($modKonsul->save()) {
              $modpemeriksaanumum->konsulpoli_id = $modKonsul->konsulpoli_id;
              if ($modpemeriksaanumum->save()) {
                $ok = true;
              } else {
                $ok = false;
              }
              $ok_konsul = true;
            } else {
              $ok_konsul = false;
            }
          }
          if (!empty($modPendaftaran)) {
            if ($modPendaftaran->instalasi_id == 111) {
              $modPendaftaran->waktumulaiperiksa = date("Y-m-d H:i:s");
              if ($modPendaftaran->save()) {
                $oke = true;
              }
            }
          }
          $ok = true;
        } else {
          $ok = false;
        }
        if ($ok == true) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
          $this->redirect(array('index', 'pendaftaran_id' => $modpemeriksaanumum->pendaftaran_id, 'sukses' => 1));
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
      'modpemeriksaanumum' => $modpemeriksaanumum,
      'format' => $format,
      'modpemeriksaanumumRiwayat' => $modpemeriksaanumumRiwayat,
      'modKonsul' => $modKonsul,
      'modPendaftaran' => $modPendaftaran,
      'modPegawai' => $modPegawai
    ));
  }

  /**
   * @author rusdiyanto <rusdiyanto@.com>
   * digunakan untuk delete data pemeriksaan umum
   */
  public function actionSetDelete()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $mcu_pemeriksaanumum_id = isset($_POST['id']) ? $_POST['id'] : " ";
      $modPemeriksaanUmum = McuPemeriksaanumumT::model()->findByPk($mcu_pemeriksaanumum_id);

      if ($modPemeriksaanUmum->delete()) {
        $data['status'] = true;
        $data['pesan'] = 'data pemeriksaan umum berhasil dihapus !!';
      } else {
        $data['status'] = false;
        $data['pesan'] = 'data pemeriksaan umum gagal dihapus !!';
      }

      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  /**
   * fungsi digunakan untuk detail pemeriksaan umum
   * @author rusdiyanto <rusdiyanto@.com>
   * @params integer $id
   */
  public function actionDetail($id)
  {
    $this->layout = "//layouts/iframe";
    $format = new MyFormatter();
    $modpemeriksaanumum = McuPemeriksaanumumT::model()->findByAttributes(array('mcu_pemeriksaanumum_id' => $id));
    $modPegawai = PegawaiV::model()->findByAttributes(array('pegawai_id' => $modpemeriksaanumum->dokterpemeriksa_id));
    $this->render($this->path_view . 'detail', array(
      'modpemeriksaanumum' => $modpemeriksaanumum,
      'format' => $format,
      'modPegawai' => $modPegawai

    ));
  }

  /**
   * fungsi untuk ubah data pemeriksaan umum
   * @author rusdiyanto <rusdiyanto@.com>
   * @params integer $id
   */
  public function actionUpdate($id)
  {
    $this->layout = "//layouts/iframe";
    $format = new MyFormatter();
    $modpemeriksaanumum = McuPemeriksaanumumT::model()->findByPk($id);
    $permintaanMCU = PermintaanmcuT::model()->find("pendaftaran_id = ".$modpemeriksaanumum->pendaftaran_id);
    $modpemeriksaanumum->listpaketpemeriksaan = !empty($permintaanMCU)?$permintaanMCU->tipepaket->tipepaket_nama:'-';
    if (isset($_POST['McuPemeriksaanumumT'])) {
      $ok = true;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model = McuPemeriksaanumumT::model()->findByPk($_POST['McuPemeriksaanumumT']['mcu_pemeriksaanumum_id']);
        $model->jeniskeperluanmcu = $_POST['McuPemeriksaanumumT']['jeniskeperluanmcu'];
        $model->attributes = $_POST['McuPemeriksaanumumT'];
        $model->tgl_pemeriksaan = $format->formatDateTimeForDb($_POST['McuPemeriksaanumumT']['tgl_pemeriksaan']);
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
          $this->redirect(array('update', 'id' => $model->mcu_pemeriksaanumum_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data Pemeriksaan umum gagal diubah !");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data pemeriksaan umum gagal diubah ! " . MyExceptionMessage::getMessage($ex, true));
      }
    }
    $this->render($this->path_view . 'ubah/_formUbah', array(
      'modpemeriksaanumum' => $modpemeriksaanumum,
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
    $caraPrint = 'PRINT';
    if (isset($_GET['caraPrint'])){
        $caraPrint = $_GET['caraPrint'];
    }
    if ($caraPrint == 'frame'){
        $this->layout = '//layouts/iframe';
    }else{
        $this->layout = '//layouts/printWindows';
    }
    $model = McuPemeriksaanumumT::model()->findByPk($id);
    $modPendaftaran = PendaftaranT::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

    $this->render($this->path_view . 'printout/template', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'model' => $model,
    ));
  }
 
}
