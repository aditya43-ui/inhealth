<?php

class PasienRuanganLainController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Dari Ruangan Lain";
    $format = new MyFormatter();
    $model = new PIPasienridariruanganlainV;
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->ceklis = TRUE;

    if (isset($_REQUEST['PIPasienridariruanganlainV'])) {
      $model->attributes = $_REQUEST['PIPasienridariruanganlainV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['PIPasienridariruanganlainV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['PIPasienridariruanganlainV']['tgl_akhir']);
      $model->ceklis = $_REQUEST['PIPasienridariruanganlainV']['ceklis'];
    }
    $this->render('index', array('model' => $model, 'format' => $format));
  }

  /**
   * untuk load session masuk kamar
   */
  public function actionBuatSessionMasukKamar()
  {

    $kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
    $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);

    Yii::app()->session['kelaspelayanan_id'] =  $kelaspelayanan_id;
    Yii::app()->session['pendaftaran_id'] =  $pendaftaran_id;


    echo CJSON::encode(array(
      'kelaspelayanan_id' => Yii::app()->session['kelaspelayanan_id'],
      'pendaftaran_id' => Yii::app()->session['pendaftaran_id'],
    ));
  }

  public function actionInsertMasukKamar()
  {
    $pendaftaran_id = Yii::app()->session['pendaftaran_id'];
    $idKelasPelayanan = Yii::app()->session['kelaspelayanan_id'];
    $idRuangan = Yii::app()->user->getState('ruangan_id');
    $modMasukKamar = new MasukkamarT;
    $format = new MyFormatter();
    $modMasukKamar->tglmasukkamar = date('Y-m-d H:i:s');
    $modMasukKamar->jammasukkamar = date('H:i:s');
    $modDataPasien = PasienridariruanganlainV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modMasukKamar->kamarruangan_id = $modDataPasien->kamarruangan_id;
    $modPasienAdmisi = PasienadmisiT::model()->findByPk($modDataPasien->pasienadmisi_id);
    if (isset($_POST['MasukkamarT'])) {
      $modMasukKamar->attributes =  $_POST['MasukkamarT'];
      $modMasukKamar->carabayar_id = $modDataPasien->carabayar_id;
      $modMasukKamar->kelaspelayanan_id = $modPasienAdmisi->kelaspelayanan_id;
      $modMasukKamar->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $modMasukKamar->pasienadmisi_id = $modDataPasien->pasienadmisi_id;
      $modMasukKamar->pegawai_id = $modPasienAdmisi->pegawai_id;
      $modMasukKamar->tglmasukkamar = $format->formatDateTimeForDb($_POST['MasukkamarT']['tglmasukkamar']);
      $modMasukKamar->penjamin_id = $modDataPasien->penjamin_id;
      $modMasukKamar->shift_id = Yii::app()->user->getState('shift_id');
      $modMasukKamar->nomasukkamar = MyGenerator::noMasukKamar($modMasukKamar->ruangan_id);
      $modMasukKamar->tglkeluarkamar = null;
      $modMasukKamar->jamkeluarkamar = null;
      $modMasukKamar->lamadirawat_kamar = null;
      $modMasukKamar->create_time = date('Y-m-d H:i:s');
      $modMasukKamar->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $modMasukKamar->create_loginpemakai_id = Yii::app()->user->id;
      if ($modMasukKamar->save()) {
        //update kamarruangan di pasienadmisi_t
        //                $modPasienAdmisi = PasienadmisiT::model()->findByPk($modDataPasien->pasienadmisi_id);
        //                $modPasienAdmisi->kamarruangan_id = $modMasukKamar->kamarruangan_id;
        //                $modPasienAdmisi->save();
        $modPindahKamar = PindahkamarT::model()->findByPk($modDataPasien->pindahkamar_id);
        $modPindahKamar->masukkamar_id = $modMasukKamar->masukkamar_id;
        $modPindahKamar->save();

        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Data Pasien <b></b> berhasil disimpan </div>",
          ));
          exit;
        }
      } else {
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-error'>Data Pasien <b></b> gagal disimpan </div>",
          ));
          exit;
        }
      }
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo CJSON::encode(array(
        'status' => 'create_form',
        'div' => $this->renderPartial('_formInsertMasukKamar', array('modMasukKamar' => $modMasukKamar, 'modDataPasien' => $modDataPasien), true)
      ));
      exit;
    }
  }

  public function actionBatalPindah($task = 'BatalPindah')
  {

    $nama_modul = Yii::app()->controller->module->id;
    $nama_controller = Yii::app()->controller->id;
    $nama_action = Yii::app()->controller->action->id;

    $pindahkamar_id = isset($_POST['pindahkamar_id']) ? $_POST['pindahkamar_id'] : null;
    $masukkamar_id = isset($_POST['masukkamar_id']) ? $_POST['masukkamar_id'] : '';
    $nama_pemakai = isset($_POST['nama_pemakai']) ? $_POST['nama_pemakai'] : null;
    $kata_kunci = isset($_POST['kata_kunci']) ? $_POST['kata_kunci'] : null;


    $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
    $status_batal = true;
    $ruangan_nama = '';

    $pesan = '';
    $status = false;
    $success = false;

    $update_kamarruanganbaru = true;
    $update_pasienadmisi = false;
    $update_masukkamarlama = false;
    $delete_pindahkamar = false;
    $delete_masukkamarbaru = false;
    $update_kamarruanganlama = false;
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = Yii::app()->user->getState('ruangan_id');
      $user = LoginpemakaiK::model()->findByAttributes(array(
        'nama_pemakai' => $nama_pemakai,
        'loginpemakai_aktif' => TRUE
      ));
      if ($user === null) {
        $data['error'] = "Login Pemakai salah!";
        $data['cssError'] = 'username';
        $status = false;
        $pesan = 'Gagal Login';
      } else {
        // cek password
        if ($user->katakunci_pemakai !== $user->encrypt($kata_kunci)) {
          $data['error'] = 'password salah!';
          $data['cssError'] = 'password';
          $status = 'Gagal Login';
          $pesan = 'Gagal Login';
        } else {
          // cek ruangan					
          $ruangan_user = RuanganpemakaiK::model()->findByAttributes(array(
            'loginpemakai_id' => $user->loginpemakai_id,
            'ruangan_id' => $ruangan_id
          ));
          if ($ruangan_user === null) {
            $data['error'] = 'ruangan salah!';
            $status = false;
            $pesan = 'Gagal Login';
          } else {
            $data['error'] = '';
            $cek = $this->checkAccess(array('loginpemakai_id' => $user->loginpemakai_id)); //dari MyAuthController
            if ($cek) {
              $status = 'success';
              $data['userid'] = $user->loginpemakai_id;
              $data['username'] = $user->nama_pemakai;

              $transaction = Yii::app()->db->beginTransaction();
              try {
                $modPindahKamar = PindahkamarT::model()->findByPk($pindahkamar_id);
                $modPasienAdmisi = PasienadmisiT::model()->findByPk($modPindahKamar->pasienadmisi_id);

                if (!empty($masukkamar_id)) {
                  $modMasukKamarBaru = MasukkamarT::model()->findByPk($masukkamar_id);
                }

                $criteria = new CDbCriteria();
                $criteria->addCondition('pasienadmisi_id = ' . $modPasienAdmisi->pasienadmisi_id);
                $criteria->addCondition('pindahkamar_id is NOT NULL');
                $modMasukKamarLama = MasukkamarT::model()->find($criteria);

                $update_kamarruangan = KamarruanganM::model()->updateByPk($modMasukKamarBaru->kamarruangan_id, array(
                  'kamarruangan_status' => true,
                  'keterangan_kamar' => Params::KETERANGANKAMAR_TERSEDIA
                ));

                if ($update_kamarruangan) {
                  $update_kamarruanganbaru = true;
                }

                if (!empty($modPasienAdmisi)) {
                  $modPasienAdmisi->ruangan_id = $modMasukKamarLama->ruangan_id;
                  $modPasienAdmisi->kamarruangan_id = $modMasukKamarLama->kamarruangan_id;
                  $modPasienAdmisi->shift_id = $modMasukKamarLama->shift_id;
                  $modPasienAdmisi->carabayar_id = $modMasukKamarLama->carabayar_id;
                  $modPasienAdmisi->penjamin_id = $modMasukKamarLama->penjamin_id;
                  $modPasienAdmisi->kelaspelayanan_id = $modMasukKamarLama->kelaspelayanan_id;
                  if ($modPasienAdmisi->save()) {
                    $update_pasienadmisi = true;
                  }
                }

                $update_kamarruangan_lama = KamarruanganM::model()->updateByPk($modMasukKamarLama->kamarruangan_id, array(
                  'kamarruangan_status' => false,
                  'keterangan_kamar' => Params::KETERANGANKAMAR_DIGUNAKAN
                ));

                if ($update_kamarruangan_lama) {
                  $update_kamarruangan_lama = true;
                }

                $update_masukkamarlama = MasukkamarT::model()->updateByPk($modMasukKamarLama->masukkamar_id, array(
                  'pindahkamar_id' => NULL,
                ));
                if ($update_masukkamarlama) {
                  $update_masukkamarlama = true;
                }

                $delete_pindahkamar = PindahkamarT::model()->deleteByPk($pindahkamar_id);
                if ($delete_pindahkamar) {
                  $delete_pindahkamar = true;
                }

                $delete_masukkamar = MasukkamarT::model()->deleteByPk($masukkamar_id);
                if ($delete_pindahkamar) {
                  $delete_masukkamarbaru = true;
                }

                if ($update_kamarruanganbaru && $update_pasienadmisi && $update_masukkamarlama && $delete_pindahkamar && $delete_masukkamarbaru) {
                  $success = true;
                } else {
                  $success = false;
                  $pesan = 'Data pindahan rawat intensif pasien gagal dibatalkan';
                }
                if ($success) {
                  $transaction->commit();
                  $status = true;
                  $pesan = 'Data pindahan rawat intensif pasien berhasil dibatalkan';
                } else {
                  $status = false;
                  $pesan = 'Data pindahan rawat intensif pasien gagal dibatalkan';
                  $transaction->rollback();
                  Yii::app()->user->setFlash('error', "Data gagal dibatalkan");
                }
              } catch (Exception $ex) {
                $status = false;
                $pesan = "exist";
                $transaction->rollback();
              }
            } else {
              $status = 'Tidak memiliki akses untuk melakukan pembatalan!';
            }
          }
        }
      }

      $data = array(
        'pesan' => $pesan,
        'status' => $status,
      );
      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
