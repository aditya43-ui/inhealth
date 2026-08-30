<?php
class PemesananAmbulansPasienRSController extends MyAuthController
{
  public $path_view = 'ambulans.views.pemesananAmbulansPasienRS.';

  public function actionIndex($linkHalaman = null)
  {
    $format = new MyFormatter();
    $modPasien = new PasienM;
    $modKunjungan = new AMInfokunjunganrjV;
    $modPemesanan = new AMPesanambulansT;
    $modPemesanan->tglpemesananambulans = date('Y-m-d H:i:s');
    $modPemesanan->pesanambulans_no = "-- Otomatis --";
    $modPemesanan->instalasi_id = Yii::app()->user->getState('instalasi_id');
    $modPemesanan->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $modInstalasi = InstalasiM::model()->findAllByAttributes(array('instalasi_aktif' => true), array('order' => 'instalasi_nama'));
    $sukses = 0;

    $nama_modul = Yii::app()->controller->module->id;
    $nama_controller = Yii::app()->controller->id;
    $nama_action = Yii::app()->controller->action->id;
    $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
    $criteria = new CDbCriteria;
    $criteria->compare('modul_id', $modul_id);
    $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
    $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
    if (isset($_POST['tujuansms'])) {
      $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
    }
    $modSmsgateway = SmsgatewayM::model()->findAll($criteria);

    if (isset($_POST['AMPesanambulansT'])) {
      $trans = Yii::app()->db->beginTransaction();
      $modPemesanan->attributes = $_POST['AMPesanambulansT'];
      $modPemesanan->create_loginpemakai_id = Yii::app()->user->id;
      $modPemesanan->tglpemesananambulans  = $format->formatDateTimeForDb($_POST['AMPesanambulansT']['tglpemesananambulans']);
      if (isset($_POST['AMPesanambulansT']['tglpemakaianambulans'])) {
        $modPemesanan->tglpemakaianambulans  = $format->formatDateTimeForDb($_POST['AMPesanambulansT']['tglpemakaianambulans']);
      }
      $modPemesanan->create_time = date('Y-m-d H:i:s');
      $modPemesanan->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $modPemesanan->pesanambulans_no = MyGenerator::noPesanAmbulans(PARAMS::INSTALASI_ID_AMBULAN, date('Y-m-d', strtotime($modPemesanan->tglpemesananambulans)));

      $modPemesanan->rt_rw = $_POST['AMPesanambulansT']['rt'] . "/" . $_POST['AMPesanambulansT']['rw'];


      // $ok = CustomFunction::broadcastNotif($judul, $isi, $this->path_view);  

      if ($modPemesanan->validate()) {
        if ($modPemesanan->save()) {
          // SMS GATEWAY
          $modPasien = PasienM::model()->findByPk($modPemesanan->pasien_id);
          $sms = new Sms();
          $smspasien = 1;
          foreach ($modSmsgateway as $i => $smsgateway) {
            $isiPesan = $smsgateway->templatesms;

            $attributes = $modPasien->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $modPemesanan->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modPemesanan->tglpemesananambulans), $isiPesan);
            $isiPesan = str_replace("{{nama_rumahsakit}}", Yii::app()->user->getState('nama_rumahsakit'), $isiPesan);


            if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
              if (!empty($modPasien->no_mobile_pasien)) {
                $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
              } else {
                $smspasien = 0;
              }
            }
          }
          // END SMS GATEWAY
          $sukses = 1;
          $modPemesanan->isNewRecord = FALSE;

          $this->notifPesanAmbulansRS($modPemesanan, $modPasien);

          $trans->commit();
          Yii::app()->user->setFlash('success', "Transaksi Pesan Ambulans " . $modPemesanan->pesanambulans_no . " Berhasil disimpan");
          $this->redirect(array('index', 'id' => $modPemesanan->pesanambulans_t, 'sukses' => $sukses, 'smspasien' => $smspasien));
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', "Data Gagal disimpan");
        }
      }
    }

    if (isset($_GET['id'])) {
      $modPemesanan = AMPesanambulansT::model()->findByPk($_GET['id']);
      if (!empty($modPemesanan->pasien_id)) {
        $modPasien = PasienM::model()->findByPk($modPemesanan->pasien_id);
      }
      if (!empty($modPemesanan->pendaftaran_id)) {
        $modKunjungan->attributes = $modPemesanan->pendaftaran->attributes;
      }

      $rt_rw = explode("/", $modPemesanan->rt_rw);

      $modPemesanan->rt = empty($rt_rw[0]) ? null : $rt_rw[0];
      $modPemesanan->rw = empty($rt_rw[1]) ? null : $rt_rw[1];
    }
    $this->pageTitle = Yii::app()->name . " - Pemesanan Ambulans Pasien Rumah Sakit";
    $this->render($this->path_view . 'index', array(
      'modPemesanan' => $modPemesanan,
      'modPasien' => $modPasien,
      'modInstalasi' => $modInstalasi,
      'modKunjungan' => $modKunjungan,
      'format' => $format,
      'linkHalaman' => $linkHalaman
    ));
  }

  public function notifPesanAmbulansRS($modPemesanan, $modPasien)
  {

    $judul = "Pesan Mobil Ambulans";
    $asal = RuanganM::model()->findByPk(Yii::app()->user->getState('ruangan_id'));

    $isi = "Pesan mobil ambulans (No. " . $modPemesanan->pesanambulans_no . ") dari ruangan " . Yii::app()->user->getState('ruangan_nama') . " untuk Pasien atas nama " .
      $modPasien->namadepan . $modPasien->nama_pasien . ' (' . $modPasien->no_rekam_medik . ') pada tanggal ' .
      MyFormatter::formatDateTimeForUser($modPemesanan->tglpemesananambulans);

    $tujuan = array(
      array('instalasi_id' => Params::INSTALASI_ID_AMBULAN, 'ruangan_id' => Params::RUANGAN_ID_AMBULANCE, 'modul_id' => Params::MODUL_ID_AMBULANS),
    );

    if ($asal->ruangan_id != Params::RUANGAN_ID_AMBULANCE) {
      $tujuan[] = array(
        'instalasi_id' => $asal->instalasi_id, 'ruangan_id' => $asal->ruangan_id, 'modul_id' => $asal->modul_id,
      );
    }


    return CustomFunction::broadcastNotif($judul, $isi, $tujuan);
  }

  /**
   * Mengurai data kunjungan berdasarkan:
   * - instalasi_id
   * - pendaftaran_id
   * - pasienadmisi_id
   * - no_pendaftaran
   * - no_rekam_medik
   * @throws CHttpException
   */
  public function actionGetDataKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $pasienadmisi_id = isset($_POST['pasienadmisi_id']) ? $_POST['pasienadmisi_id'] : null;
      $no_pendaftaran = isset($_POST['no_pendaftaran']) ? $_POST['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
      $returnVal = array();
      $criteria = new CDbCriteria();
      $criteria->compare('pendaftaran_id', $pendaftaran_id);
      $criteria->compare('pasienadmisi_id', $pasienadmisi_id);
      $criteria->compare('instalasi_id', $instalasi_id);
      $criteria->compare('LOWER(no_pendaftaran)', strtolower(trim($no_pendaftaran)));
      $criteria->compare('LOWER(no_rekam_medik)', strtolower(trim($no_rekam_medik)));
      //var_dump($instalasi_id);die();
      if (empty($instalasi_id)) {
        $instalasi_id = Yii::app()->user->getState('instalasi_id');
      }
      // var_dump(Yii::app()->user->getState('instalasi_id'));die();

      $model = null;

      if ($instalasi_id == Params::INSTALASI_ID_RJ) {
        $model = AMInfokunjunganrjV::model()->find($criteria);
      } else if ($instalasi_id == Params::INSTALASI_ID_RD) {
        $model = AMInfoKunjunganRDV::model()->find($criteria);
      } else if ($instalasi_id == Params::INSTALASI_ID_RI) {
        $model = AMPasienrawatinapV::model()->find($criteria);
      } else if ($instalasi_id == Params::INSTALASI_ID_HD) {
        $model = InfokunjunganhdV::model()->find($criteria);
      } else if ($instalasi_id == Params::INSTALASI_ID_JZ || $instalasi_id == 59) {
        $model = PasienmasukpenunjangV::model()->find($criteria);
      } else if ($instalasi_id == Params::INSTALASI_ID_PERSALINAN) {
        $model = InfokunjunganpersalinanV::model()->find($criteria);
      }

      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      //var_dump($returnVal);die();
      $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
      $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * untuk menampilkan data kunjungan dari autocomplete
   * - no_pendaftaran
   * - no_rekam_medik
   * - nama_pasien
   */
  public function actionAutocompleteKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $instalasi_id = isset($_GET['instalasi_id']) ? $_GET['instalasi_id'] : null;
      $no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
      $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
      $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
      $criteria->limit = 5;
      if ($instalasi_id == Params::INSTALASI_ID_RJ) {
        //$criteria->addCondition("DATE(tgl_pendaftaran) = '".date("Y-m-d")."'");
        $models = AMInfokunjunganrjV::model()->findAll($criteria);
      } else if ($instalasi_id == Params::INSTALASI_ID_RD) {
        //$criteria->addCondition("DATE(tgl_pendaftaran) = '".date("Y-m-d")."'");
        $models = AMInfoKunjunganRDV::model()->findAll($criteria);
      } else if ($instalasi_id == Params::INSTALASI_ID_RI) {
        //$criteria->addBetweenCondition("DATE(tglmasukkamar)",date("Y-m-d", strtotime("-31 days")),date("Y-m-d"));
        $models = AMPasienrawatinapV::model()->findAll($criteria);
      }
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->no_pendaftaran . ' - ' . $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
        $returnVal[$i]['value'] = $model->no_pendaftaran;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionDynamicRuangan()
  {
    $instalasi_id = (isset($_POST['instalasi']) ? $_POST['instalasi'] : null);
    $data = RuanganM::model()->findAll(
      'instalasi_id=:instalasi_id AND ruangan_aktif = TRUE order by ruangan_nama',
      array(':instalasi_id' => $instalasi_id)
    );

    $data = CHtml::listData($data, 'ruangan_id', 'ruangan_nama');

    if (empty($data)) {
      echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Ruangan --'), true);
    } else {
      echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Ruangan --'), true);
      foreach ($data as $value => $name) {
        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
    }
  }
}
