<?php

/**
 * Digunakan untuk menampilkan Daftar Pasien di Informasi MCU
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @author Elham Budianto <elhambudianto@.com>
 * @package application.modules.mcu
 * @subpackage controllers
 */
Yii::import('rawatJalan.models.*');
Yii::import('asuhanKeperawatan.controllers.PengkajianAskepController');
Yii::import('rawatInap.controllers.AsesmenAwalMedisController');
Yii::import('rawatInap.models.RIAsesmenAwalMedisT');
Yii::import('rawatInap.models.RIRiwayatobatsebelumnyaT');

class InformasiDaftarPasienMCController extends MyAuthController
{

  public $defaultAction = 'index';
  public $path_view = 'mcu.views.informasiDaftarPasienMC';
  public $path_view_askep = 'asuhanKeperawatan.views.pengkajianAskep.';

  /**
   * action ini digunakan untuk mengakses menu informasi daftar pasien mcu
   *
   */
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pasien Mcu";
    $model = new MCInfokunjunganmcuV('searchDaftarPasienMcu');
    $model->unsetAttributes();
    $model->tgl_awal = date('d M Y');
    $model->tgl_akhir = date('d M Y');
    $model->tgl_awal_pendaftar = date('d M Y');
    $model->tgl_akhir_pendaftar = date('d M Y');
    $model->ceklis = false;
    $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    if (isset($_GET['MCInfokunjunganmcuV'])) {
      $model->attributes = $_GET['MCInfokunjunganmcuV'];
      $model->ceklis = (!empty($_GET['MCInfokunjunganmcuV']['ceklis'])?$_GET['MCInfokunjunganmcuV']['ceklis']:null);
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($_REQUEST['MCInfokunjunganmcuV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['MCInfokunjunganmcuV']['tgl_akhir']);
      $model->tgl_awal_pendaftar = (!empty($_REQUEST['MCInfokunjunganmcuV']['tgl_awal_pendaftar'])? $format->formatDateTimeForDb($_REQUEST['MCInfokunjunganmcuV']['tgl_awal_pendaftar']): date('d M Y'));
      $model->tgl_akhir_pendaftar = (!empty($_REQUEST['MCInfokunjunganmcuV']['tgl_akhir_pendaftar'])? $format->formatDateTimeForDb($_REQUEST['MCInfokunjunganmcuV']['tgl_akhir_pendaftar']): date('d M Y'));
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->pegawai_id = isset($_REQUEST['MCInfokunjunganmcuV']['pegawai_id']) ? $_REQUEST['MCInfokunjunganmcuV']['pegawai_id'] : null;
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo $this->renderPartial('_tablePasien', array('model' => $model));
    } else {
      $this->render('index', array('model' => $model));
    }
  }

  /**
   * digunakan untuk mengubah status periksa pasien
   */
  public function actionUbahStatusPeriksaPasien()
  {
    $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
    $status = isset($_POST['status']) ? $_POST['status'] : null;
    $konsulpoli_id = isset($_POST['konsulpoli_id']) ? $_POST['konsulpoli_id'] : null;
    $model = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modBatalPeriksa = new PasienbatalperiksaR;
    $model->tglselesaiperiksa = date('Y-m-d H:i:s');
    if (isset($_POST['status'])) {
      if ($status == "ANTRIAN") {
        if (!empty($konsulpoli_id)) {
          $modKonsulPoliT = KonsulpoliT::model()->findByPk($konsulpoli_id);
          if (!empty($modKonsulPoliT)) {
            $update = KonsulpoliT::model()->updateByPk($konsulpoli_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
          }
        } else {
          $update = PendaftaranT::model()->updateByPk($pendaftaran_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
        }
      } else {
        if ($status == "SEDANG PERIKSA") {
          if (!empty($konsulpoli_id)) {
            $modKonsulPoliT = KonsulpoliT::model()->findByPk($konsulpoli_id);
            if (!empty($modKonsulPoliT)) {
              $update = KonsulpoliT::model()->updateByPk($konsulpoli_id, array('statusperiksa' => Params::STATUSPERIKSA_SUDAH_DIPERIKSA));
            }
          } else {
            //$update = PendaftaranT::model()->updateByPk($pendaftaran_id, array('statusperiksa' => Params::STATUSPERIKSA_SUDAH_DIPERIKSA));
            $update = PendaftaranT::model()->updateByPk($pendaftaran_id, array('statusperiksa' => Params::STATUSPERIKSA_SUDAH_DIPERIKSA, 'waktuselesaiperiksa' => date("Y-m-d H:i:s")));
          }
        } else if ($status == "SEDANG DIRAWAT INAP") {
          if (!empty($konsulpoli_id)) {
            $modKonsulPoliT = KonsulpoliT::model()->findByPk($konsulpoli_id);
            if (!empty($modKonsulPoliT)) {
              $update = KonsulpoliT::model()->updateByPk($konsulpoli_id, array('statusperiksa' => Params::STATUSPERIKSA_SUDAH_PULANG));
            }
          } else {
            $update = PendaftaranT::model()->updateByPk($pendaftaran_id, array('statusperiksa' => Params::STATUSPERIKSA_SUDAH_PULANG));
          }
        }
      }
      if ($update) {
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
  }

  /**
   * membuat rencan kontral pasien, ke polik
   * @param type $pendaftaran_id
   */
  public function actionRencanaKontrolPasienRJ($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter;
    $model = new PendaftaranT;
    $tersimpan = 'Tidak';

    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

    $model->tglrenkontrol = $format->formatDateTimeForDb($modPendaftaran->tgl_pendaftaran);
    $model->tglrenkontrol = strtotime($model->tglrenkontrol . ' + 1 years');
    $model->tglrenkontrol = date('Y-m-d H:i:s', $model->tglrenkontrol);

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
    $smspasien = 1;

    if (isset($_POST['PendaftaranT'])) {
      $renKontrol = $format->formatDateTimeForDb($_POST['PendaftaranT']['tglrenkontrol']);
      $pasien_id = $_POST['PendaftaranT']['pendaftaran_id'];
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $update = PendaftaranT::model()->updateByPk($pasien_id, array('tglrenkontrol' => $renKontrol));

        if ($update) {
          // SMS GATEWAY
          $modPegawai = $modPendaftaran->pegawai;
          $modRuangan = $modPendaftaran->ruangan;
          $modInstalasi = $modPendaftaran->instalasi;
          $sms = new Sms();
          foreach ($modSmsgateway as $i => $smsgateway) {
            $isiPesan = $smsgateway->templatesms;

            $attributes = $modPasien->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $modPendaftaran->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $modPegawai->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $modRuangan->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $modInstalasi->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modPendaftaran->tglrenkontrol), $isiPesan);

            if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
              if (!empty($modPasien->no_mobile_pasien)) {
                $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
              } else {
                $smspasien = 0;
              }
            }
          }
          // END SMS GATEWAY

          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil disimpan");
          $tersimpan = 'Ya';
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan", MyExceptionMessage::getMessage($exc, false));
      }
    }

    $model->tglrenkontrol = Yii::app()->dateFormatter->formatDateTime(
      CDateTimeParser::parse($model->tglrenkontrol, 'yyyy-MM-dd hh:mm:ss')
    );

    $this->render('formRencanaKontrol', array(
      'modPasien' => $modPasien,
      'modPendaftaran' => $modPendaftaran,
      'model' => $model,
      'tersimpan' => $tersimpan,
      'smspasien' => $smspasien
    ));
  }

  /**
   * mengubah data dpjp
   */
  public function actionUbahDokterPeriksa()
  {
    $model = new MCPendaftaranT;
    $modUbahDokter = new MCUbahdokterR;
    $menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
    if (isset($_POST['MCPendaftaranT'])) {
      if ($_POST['MCPendaftaranT']['pegawai_id'] != "") {
        $model->attributes = $_POST['MCPendaftaranT'];
        $modUbahDokter->attributes = $_POST['MCUbahdokterR'];
        $modUbahDokter->pendaftaran_id = $_POST['MCPendaftaranT']['pendaftaran_id'];
        $modUbahDokter->dokterbaru_id = $_POST['MCPendaftaranT']['pegawai_id'];
        $modUbahDokter->tglubahdokter = date('Y-m-d H:i:s');
        $modUbahDokter->create_time = date('Y-m-d H:i:s');
        $modUbahDokter->create_loginpemakai_id = Yii::app()->user->id;
        $modUbahDokter->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $attributes = array('pegawai_id' => $_POST['MCPendaftaranT']['pegawai_id']);
          $save = $model::model()->updateByPk($_POST['MCPendaftaranT']['pendaftaran_id'], $attributes);
          if ($save) {
            $modUbahDokter->save();
            $transaction->commit();
            echo CJSON::encode(array(
              'status' => 'proses_form',
              'div' => "<div class='flash-success'>Berhasil merubah Dokter Periksa.</div>",
            ));
          } else {
            echo CJSON::encode(array(
              'status' => 'proses_form',
              'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
            ));
          }
          exit;
        } catch (Exception $exc) {
          $transaction->rollback();
        }
      } else {
        echo CJSON::encode(
          array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Berhasil merubah Dokter Periksa.</div>",
          )
        );
        exit;
      }
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo CJSON::encode(array(
        'status' => 'create_form',
        'div' => $this->renderPartial('_formUbahDokterPeriksa', array('model' => $model, 'menu' => $menu, 'modUbahDokter' => $modUbahDokter), true)
      ));
      exit;
    }
  }

  /**
   * mengubah ppjp
   */
  public function actionUbahPerawatPJP()
  {
    $model = new MCPendaftaranT;
    $modUbahPerawat = new MCUbahperawatR;
    $menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
    if (isset($_POST['MCPendaftaranT'])) {
      if ($_POST['MCPendaftaranT']['pegawai_id'] != "") {
        $model->attributes = $_POST['MCPendaftaranT'];
        $modUbahPerawat->attributes = $_POST['MCUbahperawatR'];
        $modUbahPerawat->pendaftaran_id = $_POST['MCPendaftaranT']['pendaftaran_id'];
        $modUbahPerawat->perawatbaru_id = $_POST['MCPendaftaranT']['pegawai_id'];
        $modUbahPerawat->tglubahperawat = date('Y-m-d H:i:s');
        $modUbahPerawat->create_time = date('Y-m-d H:i:s');
        $modUbahPerawat->create_loginpemakai_id = Yii::app()->user->id;
        $modUbahPerawat->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $attributes = array('ppjp_id' => $_POST['MCPendaftaranT']['pegawai_id']);
          $save = $model::model()->updateByPk($_POST['MCPendaftaranT']['pendaftaran_id'], $attributes);
          if ($save) {
            $modUbahPerawat->save();
            $transaction->commit();
            echo CJSON::encode(
              array(
                'status' => 'proses_form',
                'div' => "<div class='flash-success'>Berhasil merubah Perawat Penanggung Jawab.</div>",
              )
            );
          } else {
            echo CJSON::encode(
              array(
                'status' => 'proses_form',
                'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
              )
            );
          }
          exit;
        } catch (Exception $exc) {
          $transaction->rollback();
        }
      } else {
        echo CJSON::encode(
          array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Berhasil merubah Perawat Penanggung Jawab.</div>",
          )
        );
        exit;
      }
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo CJSON::encode(
        array(
          'status' => 'create_form',
          'div' => $this->renderPartial('_formUbahPerawatPJP', array('model' => $model, 'modUbahPerawat' => $modUbahPerawat, 'menu' => $menu), true)
        )
      );
      exit;
    }
  }

  /**
   * untuk menyimpan, data ppjp
   */
  public function actionSavePPJP()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $ppjp_id = isset($_POST['ppjp_id']) ? $_POST['ppjp_id'] : null;
      $pesan = 'gagal';

      $update = MCPendaftaranT::model()->updateByPk($pendaftaran_id, array('ppjp_id' => $ppjp_id));
      if ($update) {
        $pesan = 'berhasil';
      } else {
        $pesan = 'gagal';
      }
      $data['pesan'] = $pesan;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * mengenerate data pegawai, berdasarkan pendaftaran mcu
   */
  public function actionGetDataPendaftaranMCU()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id_pendaftaran = $_POST['pendaftaran_id'];
      $model = PendaftaranT::model()->findByPk($id_pendaftaran);

      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      $returnVal["perawatLengkap"] = !empty($model->ppjp_id) ? $model->perawatPJP->namaLengkap : '-';
      $returnVal["nama_pasien"] = $model->pasien->nama_pasien;
      $returnVal["gelardepan"] = !empty($model->pegawai->gelardepan) ? $model->pegawai->gelardepan : '';
      $returnVal["nama_pegawai"] = $model->pegawai->nama_pegawai;
      $returnVal["gelarbelakang_nama"] = ''; //!empty($model->pegawai->gelarbelakang_id)?$model->pegawai->gelarbelakang->gelarbelakang_nama:null;

      echo json_encode($returnVal);
      Yii::app()->end();
    }
  }

  /**
   * menampilkan list dokter ruangan, sesuai user loginnya
   */
  public function actionListDokterRuangan()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      if (!empty($_POST['idRuangan'])) {
        $idRuangan = $_POST['idRuangan'];
        $data = DokterV::model()->findAllByAttributes(array('ruangan_id' => $idRuangan), array('order' => 'nama_pegawai'));
        $data = CHtml::listData($data, 'pegawai_id', 'NamaLengkap');

        if (empty($data)) {
          $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($data as $value => $name) {
            $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }

        $dataList['listDokter'] = $option;
      } else {
        $dataList['listDokter'] = $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      }

      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  /**
   * membatalkan pasien mcu, yang sudah terdaftar
   */
  public function actionBatalPeriksa()
  {
    $nama_modul = Yii::app()->controller->module->id;
    $nama_controller = Yii::app()->controller->id;
    $nama_action = Yii::app()->controller->action->id;
    $modul_id = ModulK::model()->findByAttributes(array('url_modul' => $nama_modul))->modul_id;
    $smspasien = 1;
    $smsdokter = 1;
    $criteria = new CDbCriteria;
    $criteria->compare('modul_id', $modul_id);
    $criteria->compare('LOWER(modcontroller)', strtolower($nama_controller), true);
    $criteria->compare('LOWER(modaction)', strtolower($nama_action), true);
    if (isset($_POST['tujuansms'])) {
      $criteria->addInCondition('tujuansms', $_POST['tujuansms']);
    }
    $modSmsgateway = SmsgatewayM::model()->findAll($criteria);

    if (Yii::app()->request->isAjaxRequest) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
        $ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = new PasienM();
        $modPegawai = new PegawaiM();

        /*
            * cek jika pasien sudah bayar START RSSP-3045
            */
        if (empty($modPendaftaran->pembayaranpelayanan_id)) {

          /*
                 * cek data pendaftaran pasien masuk penunjang
                 */
          $criteria = new CDbCriteria();
          if (!empty($pendaftaran_id)) {
            $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
          }

          $pasienMasukPenunjang = PasienmasukpenunjangT::model()->find($criteria);

          $pesan = '';
          $status = false;
          $model = new PasienbatalperiksaR();
          $model->pendaftaran_id = $pendaftaran_id;
          $model->pasien_id = $modPendaftaran->pasien_id;
          $model->tglbatal = date('Y-m-d');
          $model->keterangan_batal = "Batal Medical Checkup";
          $model->create_ruangan = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : Yii::app()->user->getState('ruangan_id');

          if ($model->save()) {
            $status = true;
            $pesan = "Pemeriksaan pasien berhasil dibatalkan!";
          } else {
            $status = false;
            $pesan = "Pemeriksaan gagal dibatalkan! " . CHtml::errorSummary($model);
          }

          $attributes = array(
            'pasienbatalperiksa_id' => $model->pasienbatalperiksa_id,
            'update_time' => date('Y-m-d H:i:s'),
            'update_loginpemakai_id' => Yii::app()->user->id
          );
          $pendaftaran = PendaftaranT::model()->updateByPk($pendaftaran_id, $attributes);

          if (!empty($pasienMasukPenunjang)) {
            if ($pasienMasukPenunjang->pasienkirimkeunitlain_id == null) {
              $attributes = array(
                'pasienkirimkeunitlain_id' => $pasienMasukPenunjang->pasienkirimkeunitlain_id
              );
              $Perminataan_penunjang = PermintaankepenunjangT::model()->deleteAllByAttributes($attributes);
            }

            $attributes = array(
              'statusperiksa' => Params::STATUSPERIKSA_BATAL_PERIKSA,
              'update_time' => date('Y-m-d H:i:s'),
              'update_loginpemakai_id' => Yii::app()->user->id
            );

            $penunjang = PasienmasukpenunjangT::model()->updateByPk($pasienMasukPenunjang->pasienmasukpenunjang_id, $attributes);
            if (!$penunjang) {
              $status = false;
            }
            /*
                     * cek data tindakan_pelayanan
                     */
            $attributes = array(
              'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id,
              'tindakansudahbayar_id' => null
            );

            $criteria2 = new CDbCriteria();
            $criteria2->addCondition('pasienmasukpenunjang_id = ' . $pasienMasukPenunjang->pasienmasukpenunjang_id);
            $criteria2->addCondition('tindakansudahbayar_id is null');
            $tindakan = TindakanpelayananT::model()->findAll($criteria2);

            if (count((array)$tindakan) > 0) {

              foreach ($tindakan as $val => $key) {
                $attributes = array(
                  'tindakanpelayanan_id' => $key->tindakanpelayanan_id
                );
                $hapus_komponen = TindakankomponenT::model()->deleteAllByAttributes($attributes);
              }

              $attributes = array(
                'pasienmasukpenunjang_id' => $pasienMasukPenunjang->pasienmasukpenunjang_id
              );

              $hapus_tindakan = TindakanPelayananT::model()->deleteAllByAttributes($attributes);
              if (!$hapus_tindakan) {
                $status = false;
                $pesan = "exist";
              }
            } else {
              $pesan = "exist";
            }
          }
        } else {
          $status = false;
          $pesan = "NoBatal";
        }
        /*
                 * kondisi_commit
                 */
        if ($status == true) {
          // SMS GATEWAY
          $modPegawai = $modPendaftaran->pegawai;
          $modPasien = $modPendaftaran->pasien;
          $sms = new Sms();
          foreach ($modSmsgateway as $i => $smsgateway) {
            $isiPesan = $smsgateway->templatesms;

            $attributes = $modPasien->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $attributes = $model->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($model->tglbatal), $isiPesan);

            if ($smsgateway->tujuansms == Params::TUJUANSMS_PASIEN && $smsgateway->statussms) {
              if (!empty($modPasien->no_mobile_pasien)) {
                $sms->kirim($modPasien->no_mobile_pasien, $isiPesan);
              } else {
                $smspasien = 0;
              }
            } elseif ($smsgateway->tujuansms == Params::TUJUANSMS_DOKTER && $smsgateway->statussms) {
              if (!empty($modPegawai->nomobile_pegawai)) {
                $sms->kirim($modPegawai->nomobile_pegawai, $isiPesan);
              } else {
                $smsdokter = 0;
              }
            }
          }
          // END SMS GATEWAY
          $transaction->commit();
        } else {
          $transaction->rollback();
        }
      } catch (Exception $ex) {
        $status = false;
        $pesan = "exist";
        $transaction->rollback();
      }

      $data = array(
        'pesan' => $pesan,
        'status' => $status,
        'smspasien' => $smspasien,
        'smsdokter' => $smsdokter,
        'nama_pasien' => $modPasien->nama_pasien,
        'nama_pegawai' => $modPegawai->nama_pegawai,
      );
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * mengenerate data prinout detail rincian belum bayar
   * @param type $instalasi_id
   * @param type $pendaftaran_id
   * @param type $pasienadmisi_id
   */
  public function actionPrintDetailRincianBelumBayar($instalasi_id, $pendaftaran_id, $pasienadmisi_id = null)
  {
    $this->layout = '//layouts/printWindows';
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    $modRincians = null;
    if ($instalasi_id == Params::INSTALASI_ID_RJ) {
      $criteria = new CDbCriteria();
      $criteria->addCondition('pendaftaran_id = ' . $pendaftaran_id);
      $criteria->order = 'ruangantindakan_id, tgl_tindakan';
      $modRincians = RincianbelumbayarrjV::model()->findAll($criteria);
    } else if ($instalasi_id == Params::INSTALASI_ID_RD) {
      $criteria = new CDbCriteria();
      $criteria->addCondition('pendaftaran_id = ' . $pendaftaran_id);
      $criteria->order = 'ruangantindakan_id, tgl_tindakan';
      $modRincians = RincianbelumbayarrdV::model()->findAll($criteria);
      //$modPendaftaran=PendaftaranT::model()->findByPk($pendaftaran_id);
    } else if ($instalasi_id == Params::INSTALASI_ID_RI) {
      $criteria = new CDbCriteria();
      $criteria->addCondition('pendaftaran_id = ' . $pendaftaran_id);
      $criteria->addCondition('pasienadmisi_id = ' . $pasienadmisi_id);
      $criteria->order = 'ruangantindakan_id, tgl_tindakan';
      $modRincians = RincianbelumbayarrawatinapV::model()->findAll($criteria);
    }
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $this->render('billingKasir.views.pembayaranTagihanPasien.printDetailRincianBelumBayar', array('modRincians' => $modRincians, 'modPendaftaran' => $modPendaftaran));
  }

  /**
   * mengenerate data tincian tagiha pasien
   * @param type $pendaftaran_id
   * @param type $pasienadmisi_id
   */
  public function actionRincianTagihanPasien($pendaftaran_id, $pasienadmisi_id = null)
  {
    $format = new MyFormatter();
    $this->layout = '//layouts/printWindows';
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    // untuk load data pasien
    $criteria = new CDbCriteria();
    if (!empty($pendaftaran_id)) {
      $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
    }
    if (!empty($pasienadmisi_id)) {
      $criteria->addCondition("pasienadmisi_id = " . $pasienadmisi_id);
    }
    //		$criteria->addInCondition('instalasi_id',array(Params::INSTALASI_ID_RJ,Params::INSTALASI_ID_RD,Params::INSTALASI_ID_RI,Params::INSTALASI_ID_KECANTIKAN));
    $modInfo = InfopasienpengunjungV::model()->find($criteria);
    if (!empty($modInfo->pasienadmisi_id)) { //replace dgn admisi
      $modInfo->instalasi_id = $modInfo->instalasiadmisi_id;
      $modInfo->ruangan_id = $modInfo->ruanganadmisi_id;
      $modInfo->kelaspelayanan_id = $modInfo->kelaspelayananadmisi_id;
      $modInfo->carabayar_id = $modInfo->carabayaradmisi_id;
      $modInfo->penjamin_id = $modInfo->penjaminadmisi_id;
      $modInfo->ruangan_nama = $modInfo->ruanganadmisi_nama;
      $modInfo->kelaspelayanan_nama = $modInfo->kelaspelayananadmisi_nama;
      $modInfo->carabayar_nama = $modInfo->carabayaradmisi_nama;
      $modInfo->penjamin_nama = $modInfo->penjaminadmisi_nama;
    }

    // untuk load data tindakan
    $criteriaTindakan = new CDbCriteria();
    if (!empty($pendaftaran_id)) {
      $criteriaTindakan->addCondition('pendaftaran_id = ' . $pendaftaran_id);
    }

    $criteriaTindakan->group = 'pendaftaran_id, pasien_id, instalasi_id, ruangan_id, kelaspelayanan_id, tgl_tindakan, instalasi_nama, ruangan_nama, kelaspelayanan_nama';
    $criteriaTindakan->select = $criteriaTindakan->group . ', sum(tarif_tindakan) as tarif_tindakan, sum(tarif_medis) as tarif_medis, sum(tarif_bhp) as tarif_bhp, sum(tarif_paramedis) as tarif_paramedis, sum(tarifcyto_tindakan) as tarifcyto_tindakan';
    $criteriaTindakan->order = 'instalasi_id, ruangan_id, tgl_tindakan';
    $modRincianTindakan = RinciantagihantindakanV::model()->findAll($criteriaTindakan);

    // untuk load data obat
    $criteriaObatAlkes = new CDbCriteria();
    if (!empty($pendaftaran_id)) {
      $criteriaObatAlkes->addCondition('pendaftaran_id = ' . $pendaftaran_id);
    }
    $criteriaObatAlkes->group = 'pendaftaran_id, ruangan_id, kelaspelayanan_id, penjualanresep_id, instalasi_nama, ruangan_nama, kelaspelayanan_nama, noresep, tglpelayanan, qty_oa';
    $criteriaObatAlkes->select = $criteriaObatAlkes->group . ', sum(hargajual_oa) as hargajual_oa, sum(harganetto_oa) as harganetto_oa, sum(hargasatuan_oa) as hargasatuan_oa';
    $criteriaObatAlkes->order  = 'ruangan_id, penjualanresep_id, tglpelayanan';
    $modRincianObatAlkes = RinciantagihanobatalkesV::model()->findAll($criteriaObatAlkes);

    $this->render('billingKasir.views.pembayaranTagihanPasien.printRincianTagihanPasien', array(
      'format' => $format,
      'modInfo' => $modInfo,
      'modRincianTindakan' => $modRincianTindakan,
      'modRincianObatAlkes' => $modRincianObatAlkes
    ));
  }

  /**
   * @author Aida Rahmawati <aidarahmawati@.com>
   * digunakan untuk menampilkan Riwayat Pemeriksaan di menu Informasi Daftar Pasien MC
   * @param type $pendaftaran_id
   */
  public function actionRiwayatPemeriksaan($pendaftaran_id)
  {
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = MCPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPenunjang = PasienmasukpenunjangT::model()->findByPk($pendaftaran_id);
    $modKunjungan = MCPendaftaranT::model()->findByPk($pendaftaran_id);
    $this->render($this->path_view . '/_riwayatPemeriksaan', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modPenunjang' => $modPenunjang,
      'modKunjungan' => $modKunjungan,
    ));
  }

  /**
   * @author Aida Rahmawati <aidarahmawati@.com>
   * digunakan untuk menampilkan Riwayat Laboratorium di menu Informasi Daftar Pasien MC
   * @param type $pendaftaran_id
   */
  public function actionRiwayatLab($pendaftaran_id)
  {
    $this->layout = "//layouts/iframe";
    $modKunjungan = MCPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = MCPasienM::model()->findByPk($modKunjungan->pasien_id);
    $modRiwayatLab = MCHasilPemeriksaanLabT::model()->findAllByAttributes(array('pendaftaran_id' => $modKunjungan->pendaftaran_id));
    $this->render($this->path_view . '/_riwayatLab', array(
      'modPasien' => $modPasien,
      'modRiwayatLab' => $modRiwayatLab,
      'modKunjungan' => $modKunjungan,
    ));
  }

  /**
   * @author Aida Rahmawati <aidarahmawati@.com>
   * digunakan untuk menampilkan Riwayat Radiologi di menu Informasi Daftar Pasien MC
   * @param type $pendaftaran_id
   */
  public function actionRiwayatRad($pendaftaran_id)
  {
    $this->layout = "//layouts/iframe";
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = MCPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPenunjang = PasienmasukpenunjangT::model()->findByPk($pendaftaran_id);
    $modRiwayatRad = MCHasilpemeriksaanradT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modKunjungan = MCPendaftaranT::model()->findByPk($pendaftaran_id);
    $this->render($this->path_view . '/_riwayatRadiologi', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modPenunjang' => $modPenunjang,
      'modRiwayatRad' => $modRiwayatRad,
      'modKunjungan' => $modKunjungan,
    ));
  }

  /**
   * @author Aida Rahmawati <aidarahmawati@.com>
   * digunakan untuk menampilkan Riwayat Pemeriksaan MCU di menu Informasi Daftar Pasien MC
   * @param type $pendaftaran_id
   */
  public function actionRiwayatMCU($pendaftaran_id)
  {
    $this->layout = "//layouts/iframe";
    /** Data pendaftaran di-filter sesuai dengan ruangan MCU */
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id, $condition = 'ruangan_id =' . Params::RUANGAN_ID_KLINIK_MCU);
    $modPasien = MCPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPenunjang = PasienmasukpenunjangT::model()->findByPk($pendaftaran_id);
    $modRiwayatAwalMedis = new AsesmenAwalMedisT;
    $modRiwayatAwalMedis->pendaftaran_id = $pendaftaran_id;

    if (isset($_GET['AsesmenAwalMedisT'])) {
      $modRiwayatAwalMedis->attributes = $_GET['AsesmenAwalMedisT'];
    }

    $modRiwayatMCU = MCKesimpulanmcuT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modKunjungan = MCPendaftaranT::model()->findByPk($pendaftaran_id);
    $this->render($this->path_view . '/_riwayatMCU', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modPenunjang' => $modPenunjang,
      'modRiwayatMCU' => $modRiwayatMCU,
      'modKunjungan' => $modKunjungan,
      'modRiwayatAwalMedis' => $modRiwayatAwalMedis
    ));
  }

  /**
   * @author Aida Rahmawati <aidarahmawati@.com>
   * digunakan untuk menampilkan Riwayat Treadmill di menu Informasi Daftar Pasien MC
   * @param type $pendaftaran_id
   */
  public function actionRiwayatTreadmill($pendaftaran_id)
  {
    $this->layout = "//layouts/iframe";
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = MCPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modPenunjang = PasienmasukpenunjangT::model()->findByPk($pendaftaran_id);
    $modRiwayatTreadmill = MCTreadmillT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modKunjungan = MCPendaftaranT::model()->findByPk($pendaftaran_id);
    $this->render($this->path_view . '/_riwayatTreadmill', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modPenunjang' => $modPenunjang,
      'modRiwayatTM' => $modRiwayatTreadmill,
      'modKunjungan' => $modKunjungan
    ));
  }

  /**
   * @author Aida Rahmawati <aidarahmawati@.com>
   * digunakan untuk load data riwayat dari asesmen awal medis
   * @param type $id
   * @return type
   */
  public function actionLihatRiwayat($id)
  {
    $con = new AsesmenAwalMedisController($module = '');

    return $con->actionLihatRiwayat($id);
  }

  public function actionRincianPaketMCU($pendaftaran_id)
  {

    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modTindakanPelayanan = TindakanpelayananT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
      // 'ruangan_id'=> Params::RUANGAN_ID_KLINIK_MCU
    ), array(
      'condition' => 'tipepaket_id is not null'
    ));

    $modPermintaanmcu = PermintaanmcuT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'create_ruangan' => Yii::app()->user->getState('ruangan_id')));
    $this->render('rincianPaketMCU', array(
      'modTindakanPelayanan' => $modTindakanPelayanan,
      'modPermintaanmcu' => $modPermintaanmcu,
      'format' => $format
    ));
  }

  public function actionAmbilHasil($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $format = new MyFormatter();
    $modPasienMcu = MCInfokunjunganmcuV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modPasien = PasienM::model()->findByPk($modPasienMcu->pasien_id);
    $modHasilMcu = KesimpulanmcuT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    if (!empty($modHasilMcu)) {
      $modHasilMcu->namaygmenyerahkan = Yii::app()->user->getState('nama_pegawai');
    } else {
      $modHasilMcu = new KesimpulanmcuT();      
    }
    $pegMenyerahan = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
    if (isset($pegMenyerahan)) {
      $modHasilMcu->namaygmenyerahkan = $pegMenyerahan->namaLengkap;
    }

    if (isset($_POST['KesimpulanmcuT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        //var_dump($_POST['HasilpemeriksaanmcuT']);die;

        $modHasilMcu->attributes = $_POST['KesimpulanmcuT'];
        $modHasilMcu->tglpengambilanhasil = $format->formatDateTimeForDb($_POST['KesimpulanmcuT']['tglpengambilanhasil']);

        $attributes = array(
          'tglpengambilanhasil' => $modHasilMcu->tglpengambilanhasil,
          'namapenerimahasil' => $modHasilMcu->namapenerimahasil,
          'notelppenerimahasil' => $modHasilMcu->notelppenerimahasil,
          'namaygmenyerahkan' => $modHasilMcu->namaygmenyerahkan,
          'ketpenyerahan' => $modHasilMcu->ketpenyerahan,
          'jenisidentitas' => $modHasilMcu->jenisidentitas,
          'no_identitas' => $modHasilMcu->no_identitas,
          'alamat' => $modHasilMcu->alamat,
        );

        if (!empty($modHasilMcu->kesimpulanmcu_id)){
            $update = KesimpulanmcuT::model()->updateAll($attributes, " pendaftaran_id = " . $pendaftaran_id);
        }else{
            $modHasilMcu->pasien_id = $modPasienMcu->pasien_id;
            $modHasilMcu->ruangan_id = $modPasienMcu->ruangan_id;
            $modHasilMcu->tgl_kesimpulanmcu = !empty($modHasilMcu->tgl_kesimpulanmcu)?MyFormatter::formatDateTimeForDb($modHasilMcu->tgl_kesimpulanmcu):date('Y-m-d H:i:s');
            
            $modHasilMcu->kesimpulan1_status = !empty($modHasilMcu->kesimpulan1_status)?$modHasilMcu->kesimpulan1_status:'-';
            $modHasilMcu->kesimpulan1_desc = !empty($modHasilMcu->kesimpulan1_desc)?$modHasilMcu->kesimpulan1_desc:'-';
            $modHasilMcu->saran1_status = !empty($modHasilMcu->saran1_status)?$modHasilMcu->saran1_status:'-';
            $modHasilMcu->saran1_desc = !empty($modHasilMcu->saran1_desc)?$modHasilMcu->saran1_desc:'-';
            $modHasilMcu->saran1_1_status = !empty($modHasilMcu->saran1_1_status)?$modHasilMcu->saran1_1_status:'-';
            $modHasilMcu->saran1_1_desc = !empty($modHasilMcu->saran1_1_desc)?$modHasilMcu->saran1_1_desc:'-';
            $modHasilMcu->saran1_2_status = !empty($modHasilMcu->saran1_2_status)?$modHasilMcu->saran1_2_status:'-';
            $modHasilMcu->saran1_2_desc = !empty($modHasilMcu->saran1_2_desc)?$modHasilMcu->saran1_2_desc:'-';
            $modHasilMcu->saran1_3_status = !empty($modHasilMcu->saran1_3_status)?$modHasilMcu->saran1_3_status:'-';
            $modHasilMcu->saran1_3_desc = !empty($modHasilMcu->saran1_3_desc)?$modHasilMcu->saran1_3_desc:'-';
            
            $modHasilMcu->kesimpulan2_status = !empty($modHasilMcu->kesimpulan2_status)?$modHasilMcu->kesimpulan2_status:'-';
            $modHasilMcu->kesimpulan2_desc = !empty($modHasilMcu->kesimpulan2_desc)?$modHasilMcu->kesimpulan2_desc:'-';
            $modHasilMcu->saran2_status = !empty($modHasilMcu->saran2_status)?$modHasilMcu->saran2_status:'-';
            $modHasilMcu->saran2_desc = !empty($modHasilMcu->saran2_desc)?$modHasilMcu->saran2_desc:'-';
            
            $modHasilMcu->kesimpulan3_status = !empty($modHasilMcu->kesimpulan3_status)?$modHasilMcu->kesimpulan3_status:'-';
            $modHasilMcu->kesimpulan3_desc = !empty($modHasilMcu->kesimpulan3_desc)?$modHasilMcu->kesimpulan3_desc:'-';
            $modHasilMcu->saran3_status = !empty($modHasilMcu->saran3_status)?$modHasilMcu->saran3_status:'-';
            $modHasilMcu->saran3_desc = !empty($modHasilMcu->saran3_desc)?$modHasilMcu->saran3_desc:'-';
            $modHasilMcu->saran3_3_1_status = !empty($modHasilMcu->saran3_3_1_status)?$modHasilMcu->saran3_3_1_status:'-';
            $modHasilMcu->saran3_3_1_desc = !empty($modHasilMcu->saran3_3_1_desc)?$modHasilMcu->saran3_3_1_desc:'-';
            $modHasilMcu->saran3_3_2_status = !empty($modHasilMcu->saran3_3_2_desc)?$modHasilMcu->saran3_3_2_desc:'-';
            $modHasilMcu->saran3_3_2_desc = !empty($modHasilMcu->saran3_3_2_desc)?$modHasilMcu->saran3_3_2_desc:'-';
            $modHasilMcu->saran3_3_3_status = !empty($modHasilMcu->saran3_3_3_status)?$modHasilMcu->saran3_3_3_status:'-';
            $modHasilMcu->saran3_3_3_desc = !empty($modHasilMcu->saran3_3_3_desc)?$modHasilMcu->saran3_3_3_desc:'-';
            $modHasilMcu->saran3_3_4_status = !empty($modHasilMcu->saran3_3_4_status)?$modHasilMcu->saran3_3_4_status:'-';
            $modHasilMcu->saran3_3_4_desc = !empty($modHasilMcu->saran3_3_4_desc)?$modHasilMcu->saran3_3_4_desc:'-';
            
            $modHasilMcu->saran3_1_desc = !empty($modHasilMcu->saran3_1_desc)?$modHasilMcu->saran3_1_desc:'-';
            $modHasilMcu->saran3_2_desc = !empty($modHasilMcu->saran3_2_desc)?$modHasilMcu->saran3_2_desc:'-';
            $modHasilMcu->saran3_3_desc = !empty($modHasilMcu->saran3_3_desc)?$modHasilMcu->saran3_3_desc:'-';
            $modHasilMcu->saran3_4_desc = !empty($modHasilMcu->saran3_4_desc)?$modHasilMcu->saran3_4_desc:'-';
            
            $modHasilMcu->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
            $modHasilMcu->create_time = date('Y-m-d H:i:s');
            $modHasilMcu->create_ruangan = Yii::app()->user->getState('ruangan_id');                       
            
            $update = $modHasilMcu->save();                        
        }
        
        if ($update) {
          //                        $modHasilMcu->save();
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data berhasil Disimpan");
          $this->redirect(array('ambilHasil', 'pendaftaran_id' => $pendaftaran_id, 'frame' => 1, 'popup' => 'true', 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan !");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render('ambilHasil', array(
      'modPasienMcu' => $modPasienMcu,
      'modPasien' => $modPasien,
      'modHasilMcu' => $modHasilMcu,
      'format' => $format,
    ));
  }
}
