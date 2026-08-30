<?php

class PasienMeninggalController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Meninggal";
    $format = new MyFormatter();
    $model = new PJDaftarpasienmeninggalV;
    $model->tgl_awal = date("Y-m-d");
    $model->tgl_akhir = date('Y-m-d');
    $model->ceklis = TRUE;
    if (isset($_GET['PJDaftarpasienmeninggalV'])) {
      $model->attributes = $_GET['PJDaftarpasienmeninggalV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PJDaftarpasienmeninggalV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PJDaftarpasienmeninggalV']['tgl_akhir']);
      $model->ceklis = $_GET['PJDaftarpasienmeninggalV']['ceklis'];
    }

    $this->render('index', array('model' => $model, 'format' => $format));
  }

  public function actionBatalMeninggal()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $status = 'ok';
      $keterangan = "";

      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
      $pasienpulang_id = null;
      $pasienadmisi_id = null;

      if (!empty($modPendaftaran->pasienadmisi_id)) {
        $modAdmisi = PasienadmisiT::model()->findByPk($modPendaftaran->pasienadmisi_id);

        if (isset($modAdmisi)) {
          $pasienadmisi_id = $modAdmisi->pasienadmisi_id;
          $pasienpulang_id = $modAdmisi->pasienpulang_id;
        }
      } else {
        $pasienpulang_id = $modPendaftaran->pasienpulang_id;
      }

      $transaction = Yii::app()->db->beginTransaction();

      try {
        $modPasienBatalPulang  = new PasienbatalpulangT;

        $modPasienBatalPulang->tglpembatalan           = date('Y-m-d H:i:s');
        $modPasienBatalPulang->alasanpembatalan        = "Pembatalan Pasien Meninggal";
        $modPasienBatalPulang->create_time             = date('Y-m-d H:i:s');
        $modPasienBatalPulang->update_time             = date('Y-m-d H:i:s');
        $modPasienBatalPulang->namauser_otorisasi      = Yii::app()->user->name;
        $modPasienBatalPulang->iduser_otorisasi        = Yii::app()->user->id;
        $modPasienBatalPulang->create_loginpemakai_id  = Yii::app()->user->id;
        $modPasienBatalPulang->update_loginpemakai_id  = Yii::app()->user->id;
        $modPasienBatalPulang->create_ruangan          = Yii::app()->user->getState('ruangan_id');
        $modPasienBatalPulang->pasienpulang_id         = $pasienpulang_id;

        if ($modPasienBatalPulang->validate()) {
          if ($modPasienBatalPulang->save()) {
            $updateAdmisi = true;
            if (!empty($pasienadmisi_id)) {
              $updateAdmisi = PasienadmisiT::model()->updateByPk($pasienadmisi_id, array('pasienpulang_id' => null));
            }
            $updatependaftaran = PendaftaranT::model()->updateByPk($modPendaftaran->pendaftaran_id, array('pasienpulang_id' => null));
            $deletePulang = PasienpulangT::model()->deleteByPk($pasienpulang_id);

            if ($updatependaftaran == true && $updateAdmisi == true && $deletePulang == true) {
              $transaction->commit();
              $status = 'ok';
              $keterangan = "Pasien Berhasil dibatalkan";
            } else {
              $keterangan = "Pasien gagal dibatalkan";
              $status = 'not';
              $transaction->rollback();
            }
          } else {
            $keterangan = "Pasien gagal dibatalkan";
            $status = 'not';
            $transaction->rollback();
          }
        } else {
          $keterangan = "Pasien gagal dibatalkan";
          $status = 'not';
          $transaction->rollback();
        }
      } catch (Exception $ex) {
        print_r($ex);
        $status = 'not';
        $transaction->rollback();
      }

      $data = array(
        'status' => $status,
        'keterangan' => $keterangan,
      );
      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
