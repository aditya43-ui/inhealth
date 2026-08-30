<?php
Yii::import('rawatInap.controllers.PasienRawatInapController');
class PasienRuanganLainController extends MyAuthController
{
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Dari Ruangan Lain";
    $format = new MyFormatter();
    $model = new RIPasienridariruanganlainV;
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_REQUEST['RIPasienridariruanganlainV'])) {
      $model->attributes = $_REQUEST['RIPasienridariruanganlainV'];
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['RIPasienridariruanganlainV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['RIPasienridariruanganlainV']['tgl_akhir']);
      $model->ceklis = $_REQUEST['RIPasienridariruanganlainV']['ceklis'];
      // $model->namaDokter = $_REQUEST['RIPasienridariruanganlainV']['namaDokter'];
      $model->prefix_pendaftaran = $_REQUEST['RIPasienridariruanganlainV']['prefix_pendaftaran'];
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

  public function actionBatalPindahKamar()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idPindahKamar = $_POST['idPindahKamar'];
      $idMasukKamar = $_POST['idMasukKamar'];

      //var_dump($_POST); die;

      $modPindahKamar = PindahkamarT::model()->findByPk($idPindahKamar);
      $modMasukKamar = MasukkamarT::model()->findByAttributes(array('pindahkamar_id' => $idPindahKamar));
      $modMasukKamarBaru = MasukkamarT::model()->findByPk($modPindahKamar->masukkamar_id);

      //var_dump($modMasukKamar->attributes);
      //var_dump($modMasukKamarBaru->attributes);
      //die;

      $transaction = Yii::app()->db->beginTransaction();
      try {
        $success = false;
        $modPasienAdmisi = PasienadmisiT::model()->findByPK(
          $modPindahKamar->pasienadmisi_id
        );
        $modPasienAdmisi->ruangan_id = $modMasukKamar->ruangan_id;
        $modPasienAdmisi->kelaspelayanan_id = $modMasukKamar->kelaspelayanan_id;
        $modPasienAdmisi->kamarruangan_id = $modMasukKamar->kamarruangan_id;

        $updatePasienAdmisi = $modPasienAdmisi->save();

        $modMasukKamar->pindahkamar_id = null;

        $updateMasukKamar = $modMasukKamar->save();

        $updateKamar1 = KamarruanganM::model()->updateByPk($modPindahKamar->kamarruangan_id, array('kamarruangan_status' => true, 'keterangan_kamar' => 'TERSEDIA'));
        $updateKamar2 = KamarruanganM::model()->updateByPk($modPasienAdmisi->kamarruangan_id, array('kamarruangan_status' => false));

        //$modPindahKamar->masukkamar_id = null;
        //$modPindahKamar->save();
        //var_dump($idPindahKamar, $idMasukKamar);
        $ok = PindahkamarT::model()->deleteByPk($idPindahKamar);
        $ok = $ok && MasukkamarT::model()->deleteByPk($idMasukKamar);
        //var_dump($ok); die;

        $ok = $ok && PasienRawatInapController::saveAkomodasi($modPasienAdmisi->pendaftaran, $modPasienAdmisi);
        // var_dump($ok); die;
        if ($updatePasienAdmisi && $updateMasukKamar) //TIDAK PERLU DI VALIDASI >> && $updateKamar1 && $updateKamar2
        {
          //Hapus masukkamar baru
          if ($ok) {
            $success = true;
            echo CJSON::encode(array(
              'status' => 'true',
              'div' => "<div class='flash-success'>Data Pasien <b></b> berhasil disimpan </div>"
            ));
          }
        }

        if ($success) {
          $transaction->commit();
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
      Yii::app()->end();
    }
  }
}
