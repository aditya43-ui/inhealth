<?php
//Yii::import('sistemAdministrator.controllers.NotifikasiRController'); RND-6398
class RadiologiController extends MyAuthController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';
  protected $statusSaveKirimkeUnitLain = false;
  protected $statusSavePermintaanPenunjang = false;
  protected $tindakanpelayanantersimpan = true;
  protected $komponentindakantersimpan = true;
  protected $path_view = 'rawatJalan.views.radiologi.';

  public function actionIndex($pendaftaran_id, $idPasienKirimKeUnitLain = null)
  {
    $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modKirimKeUnitLain = new RJPasienKirimKeUnitLainT;
    $modKirimKeUnitLain->tgl_kirimpasien = date('Y-m-d H:i:s');
    $modKirimKeUnitLain->pegawai_id = $modPendaftaran->pegawai_id;
    //RSPMC-1260
    if (!empty(Yii::app()->user->getState('kelasrujukanpenunjang_id'))) {
      $modKirimKeUnitLain->kelaspelayanan_id = Yii::app()->user->getState('kelasrujukanpenunjang_id');
    } else {
      $modKirimKeUnitLain->kelaspelayanan_id = Params::KELASPELAYANAN_ID_TANPA_KELAS;
    }
    if ($modPendaftaran->carabayar_id == Params::CARABAYAR_ID_MEMBAYAR && $modPendaftaran->penjamin_id == Params::PENJAMIN_ID_UMUM) $modKirimKeUnitLain->isbayarkekasirpenunjang = Yii::app()->user->getState('isbayarkekasirpenunjang');
    else $modKirimKeUnitLain->isbayarkekasirpenunjang = false;
    $modPemeriksaanRad = new TarifpemeriksaanradruanganV();

    $critpr = new CDbCriteria;
    $critpr->select = 't.pemeriksaanrad_id, t.pemeriksaanrad_nama, j.jenispemeriksaanrad_id,
                        j.jenispemeriksaanrad_nama, d.daftartindakan_id, k.kelaspelayanan_id';
    $critpr->join = ' JOIN jenispemeriksaanrad_m j ON t.jenispemeriksaanrad_id = j.jenispemeriksaanrad_id
                      JOIN daftartindakan_m d ON t.daftartindakan_id = d.daftartindakan_id
                      JOIN tariftindakan_m tt ON tt.daftartindakan_id = d.daftartindakan_id
                      JOIN kelaspelayanan_m k ON tt.kelaspelayanan_id = k.kelaspelayanan_id ';
    $critpr->group = $critpr->select;
    $critpr->order = ' t.pemeriksaanrad_id, t,pemeriksaanrad_urutan ';
    $critpr->addCondition('t.pemeriksaanrad_aktif = true');

    if(!empty($modPendaftaran->kelaspelayanan_id)) {
      $critpr->addCondition('k.kelaspelayanan_id = ' . $modPendaftaran->kelaspelayanan_id);
    }

    $modPeriksaRad = RJPemeriksaanRadM::model()->findAll($critpr);

    $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $modPendaftaran->penjamin_id);

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

    if (isset($idPasienKirimKeUnitLain)) {
      $modKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findByPk($idPasienKirimKeUnitLain);
      $modPasien = $modKirimKeUnitLain->pasien;
    }

    $konsul = ($modPendaftaran->ruangan_id == Yii::app()->user->getState('ruangan_id')) ? null : KonsulpoliT::model()->findByAttributes(array(
      'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
      'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
    ), array(
      'order' => 'tglkonsulpoli desc',
    ));

    if (!empty($konsul)) {
      $modKirimKeUnitLain->pegawai_id = $konsul->pegawai_id;
    }

    if (isset($_POST['RJPasienKirimKeUnitLainT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        // if($_POST['RJPasienKirimKeUnitLainT']['is_cyto'] == 1){
        //   $_POST['RJPasienKirimKeUnitLainT']['is_cyto'] = true;
        // } else{
        //   $_POST['RJPasienKirimKeUnitLainT']['is_cyto'] = false;
        // }
        $modKirimKeUnitLain = $this->savePasienKirimKeUnitLain($modPendaftaran);
        if (isset($_POST['permintaanPenunjang'])) {
          $this->savePermintaanPenunjang($_POST['permintaanPenunjang'], $modKirimKeUnitLain);

          PendaftaranT::model()->updateByPk(
            $modPendaftaran->pendaftaran_id,
            array(
              'pembayaranpelayanan_id' => null
            )
          );

          //                        RND-6398
          //                        $params['tglnotifikasi'] = date( 'Y-m-d H:i:s');
          //                        $params['create_time'] = date( 'Y-m-d H:i:s');
          //                        $params['create_loginpemakai_id'] = Yii::app()->user->id;
          //                        $params['instalasi_id'] = 6;
          //                        $params['modul_id'] = 9;
          //                        $ruangan = RuanganM::model()->findByPk($ruangan_id);
          //                        $params['isinotifikasi'] = $modPasien->no_rekam_medik . '-' . $modPendaftaran->no_pendaftaran . '-' . $modPasien->nama_pasien . '-' . $ruangan->ruangan_nama;
          //                        $params['create_ruangan'] = 19;
          //                        $params['judulnotifikasi'] = 'Rujukan Rawat Jalan';                        
          //                        $nofitikasi = NotifikasiRController::insertNotifikasi($params);                        

        } else {
          $this->statusSavePermintaanPenunjang = true;
        }

        $judul = 'Pasien Rujuk ke Radiologi';

        $isi = $modPasien->no_rekam_medik . ' - ' . $modPasien->nama_pasien;
        $mr = RuanganM::model()->findByPk($modKirimKeUnitLain->ruangan_id);

        $link = Yii::app()->createUrl('/radiologi/rujukanPenunjang/Index', array(
          'PasienkirimkeunitlainV[tgl_awal]' => date('Y-m-d', strtotime($modKirimKeUnitLain->tgl_kirimpasien)),
          'PasienkirimkeunitlainV[tgl_akhir]' => date('Y-m-d', strtotime($modKirimKeUnitLain->tgl_kirimpasien)),
          'PasienkirimkeunitlainV[no_pendaftaran]' => $modKirimKeUnitLain->pendaftaran->no_pendaftaran,
          'PasienkirimkeunitlainV[no_rekam_medik]' => $modPasien->no_rekam_medik,
          'PasienkirimkeunitlainV[nama_pasien]' => $modPasien->nama_pasien
        ));

        $ok = CustomFunction::broadcastNotif($judul, $isi, array(
          array('instalasi_id' => $mr->instalasi_id, 'ruangan_id' => $mr->ruangan_id, 'modul_id' => $mr->modul_id, 'link_proses' => $link),
          // array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=>Params::RUANGAN_ID_APOTEK_RJ, 'modul_id'=>10),
          // array('instalasi_id'=>Params::INSTALASI_ID_KASIR, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=>19),
        ));

        if ($this->statusSaveKirimkeUnitLain && $this->statusSavePermintaanPenunjang) {

          // SMS GATEWAY
          $modPegawai = $modPendaftaran->pegawai;
          $sms = new Sms();
          $smspasien = 1;
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
            $attributes = $modKirimKeUnitLain->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modKirimKeUnitLain->tgl_kirimpasien), $isiPesan);

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
          Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
          $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'smspasien' => $smspasien, 'pasienkirim_id'=>$modKirimKeUnitLain->pasienkirimkeunitlain_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data tidak valid ");
        }
      } catch (Exception $exc) {
        Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(
      array(
        'pendaftaran_id' => $pendaftaran_id,
        'ruangan_id' => Params::RUANGAN_ID_RAD,
        'create_ruangan' => Yii::app()->user->getState('ruangan_id')
      ),
      'pasienmasukpenunjang_id IS NULL'
    );

    $this->render($this->path_view . 'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modKirimKeUnitLain' => $modKirimKeUnitLain,
      'modPeriksaRad' => $modPeriksaRad,
      'modPemeriksaanRad' => $modPemeriksaanRad,
      'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain,
      'modJenisTarif' => $modJenisTarif,
    ));
  }

  public function actionUpdate($pendaftaran_id, $pasienkirimkeunitlain_id) {
    $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findByPk($pasienkirimkeunitlain_id);
    //RSPMC-1260

    $modPemeriksaanRad = new TarifpemeriksaanradruanganV();

    $critpr = new CDbCriteria;
    $critpr->select = 't.pemeriksaanrad_id, t.pemeriksaanrad_nama, j.jenispemeriksaanrad_id,
                        j.jenispemeriksaanrad_nama, d.daftartindakan_id, k.kelaspelayanan_id';
    $critpr->join = ' JOIN jenispemeriksaanrad_m j ON t.jenispemeriksaanrad_id = j.jenispemeriksaanrad_id
                      JOIN daftartindakan_m d ON t.daftartindakan_id = d.daftartindakan_id
                      JOIN tariftindakan_m tt ON tt.daftartindakan_id = d.daftartindakan_id
                      JOIN kelaspelayanan_m k ON tt.kelaspelayanan_id = k.kelaspelayanan_id ';
    $critpr->group = $critpr->select;
    $critpr->order = ' t.pemeriksaanrad_id, t,pemeriksaanrad_urutan ';
    $critpr->addCondition('t.pemeriksaanrad_aktif = true');

    if(!empty($modPendaftaran->kelaspelayanan_id)) {
      $critpr->addCondition('k.kelaspelayanan_id = ' . $modPendaftaran->kelaspelayanan_id);
    }

    $modPeriksaRad = RJPemeriksaanRadM::model()->findAll($critpr);

    $modJenisTarif = JenistarifpenjaminM::model()->find('penjamin_id =' . $modPendaftaran->penjamin_id);

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

    if (isset($modKirimKeUnitLain)) {
      $modPasien = $modKirimKeUnitLain->pasien;
    }

    $konsul = ($modPendaftaran->ruangan_id == Yii::app()->user->getState('ruangan_id')) ? null : KonsulpoliT::model()->findByAttributes(array(
      'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
      'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
    ), array(
      'order' => 'tglkonsulpoli desc',
    ));

    if (!empty($konsul)) {
      $modKirimKeUnitLain->pegawai_id = $konsul->pegawai_id;
    }

    if (isset($_POST['RJPasienKirimKeUnitLainT'])) {
      // var_dump($_POST); die;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        // if($_POST['RJPasienKirimKeUnitLainT']['is_cyto'] == 1){
        //   $_POST['RJPasienKirimKeUnitLainT']['is_cyto'] = true;
        // } else{
        //   $_POST['RJPasienKirimKeUnitLainT']['is_cyto'] = false;
        // }
        $modKirimKeUnitLain = $this->savePasienKirimKeUnitLain($modPendaftaran, $modKirimKeUnitLain);
        if (isset($_POST['permintaanPenunjang'])) {
          $hapuspermintaan = true;
          $hapuspermintaan = $hapuspermintaan && PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));
          // var_dump($hapuspermintaan); die;
          $this->savePermintaanPenunjang($_POST['permintaanPenunjang'], $modKirimKeUnitLain);

          PendaftaranT::model()->updateByPk(
            $modPendaftaran->pendaftaran_id,
            array(
              'pembayaranpelayanan_id' => null
            )
          );

          //                        RND-6398
          //                        $params['tglnotifikasi'] = date( 'Y-m-d H:i:s');
          //                        $params['create_time'] = date( 'Y-m-d H:i:s');
          //                        $params['create_loginpemakai_id'] = Yii::app()->user->id;
          //                        $params['instalasi_id'] = 6;
          //                        $params['modul_id'] = 9;
          //                        $ruangan = RuanganM::model()->findByPk($ruangan_id);
          //                        $params['isinotifikasi'] = $modPasien->no_rekam_medik . '-' . $modPendaftaran->no_pendaftaran . '-' . $modPasien->nama_pasien . '-' . $ruangan->ruangan_nama;
          //                        $params['create_ruangan'] = 19;
          //                        $params['judulnotifikasi'] = 'Rujukan Rawat Jalan';                        
          //                        $nofitikasi = NotifikasiRController::insertNotifikasi($params);                        

        } else {
          $this->statusSavePermintaanPenunjang = true;
        }

        $judul = 'Pasien Rujuk ke Radiologi';

        $isi = $modPasien->no_rekam_medik . ' - ' . $modPasien->nama_pasien;
        $mr = RuanganM::model()->findByPk($modKirimKeUnitLain->ruangan_id);

        $link = Yii::app()->createUrl('/radiologi/rujukanPenunjang/Index', array(
          'PasienkirimkeunitlainV[tgl_awal]' => date('Y-m-d', strtotime($modKirimKeUnitLain->tgl_kirimpasien)),
          'PasienkirimkeunitlainV[tgl_akhir]' => date('Y-m-d', strtotime($modKirimKeUnitLain->tgl_kirimpasien)),
          'PasienkirimkeunitlainV[no_pendaftaran]' => $modKirimKeUnitLain->pendaftaran->no_pendaftaran,
          'PasienkirimkeunitlainV[no_rekam_medik]' => $modPasien->no_rekam_medik,
          'PasienkirimkeunitlainV[nama_pasien]' => $modPasien->nama_pasien
        ));

        $ok = CustomFunction::broadcastNotif($judul, $isi, array(
          array('instalasi_id' => $mr->instalasi_id, 'ruangan_id' => $mr->ruangan_id, 'modul_id' => $mr->modul_id, 'link_proses' => $link),
          // array('instalasi_id'=>Params::INSTALASI_ID_FARMASI, 'ruangan_id'=>Params::RUANGAN_ID_APOTEK_RJ, 'modul_id'=>10),
          // array('instalasi_id'=>Params::INSTALASI_ID_KASIR, 'ruangan_id'=>Params::RUANGAN_ID_KASIR, 'modul_id'=>19),
        ));

        // var_dump($this->statusSaveKirimkeUnitLain && $this->statusSavePermintaanPenunjang, $hapuspermintaan); die;

        if ($this->statusSaveKirimkeUnitLain && $this->statusSavePermintaanPenunjang && $hapuspermintaan) {

          // echo "OK"; die;

          // SMS GATEWAY
          $modPegawai = $modPendaftaran->pegawai;
          $sms = new Sms();
          $smspasien = 1;
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
            $attributes = $modKirimKeUnitLain->getAttributes();
            foreach ($attributes as $attributes => $value) {
              $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
            }
            $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($modKirimKeUnitLain->tgl_kirimpasien), $isiPesan);

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
          Yii::app()->user->setFlash('success', "Data Berhasil disimpan");
          $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'smspasien' => $smspasien, 'pasienkirim_id'=>$modKirimKeUnitLain->pasienkirimkeunitlain_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data tidak valid ");
        }
      } catch (Exception $exc) {
        Yii::app()->user->setFlash('error', "Data Gagal disimpan. " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(
      array(
        'pendaftaran_id' => $pendaftaran_id,
        'ruangan_id' => Params::RUANGAN_ID_RAD,
        'create_ruangan' => Yii::app()->user->getState('ruangan_id')
      ),
      'pasienmasukpenunjang_id IS NULL'
    );

    $this->render($this->path_view . 'index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modKirimKeUnitLain' => $modKirimKeUnitLain,
      'modPeriksaRad' => $modPeriksaRad,
      'modPemeriksaanRad' => $modPemeriksaanRad,
      'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain,
      'modJenisTarif' => $modJenisTarif,
    ));
  }

  protected function savePasienKirimKeUnitLain($modPendaftaran, $modKirimKeUnitLain = null)
  {
    $format = new MyFormatter();
    if (empty($modKirimKeUnitLain)) {
      $modKirimKeUnitLain = new RJPasienKirimKeUnitLainT;
    }
    $modKirimKeUnitLain->attributes = $_POST['RJPasienKirimKeUnitLainT'];
    $modKirimKeUnitLain->pasien_id = $modPendaftaran->pasien_id;
    $modKirimKeUnitLain->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modKirimKeUnitLain->instalasi_id = Params::INSTALASI_ID_RAD;
    $modKirimKeUnitLain->ruangan_id = Params::RUANGAN_ID_RAD;
    $modKirimKeUnitLain->ppds_id = isset($_POST['RJPasienKirimKeUnitLainT']['ppds_id']) ? $_POST['RJPasienKirimKeUnitLainT']['ppds_id'] : false;
    $modKirimKeUnitLain->tgl_kirimpasien = $format->formatDateTimeForDb($_POST['RJPasienKirimKeUnitLainT']['tgl_kirimpasien']);
    $modKirimKeUnitLain->create_time = date("Y-m-d H:i:s");
    $modKirimKeUnitLain->update_time = date("Y-m-d H:i:s");
    $modKirimKeUnitLain->create_loginpemakai_id = Yii::app()->user->id;
    $modKirimKeUnitLain->update_loginpemakai_id = Yii::app()->user->id;
    $modKirimKeUnitLain->create_ruangan = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
    $modKirimKeUnitLain->tgl_kirimpasien = MyFormatter::formatDateTimeForDb($modKirimKeUnitLain->tgl_kirimpasien);
    $modKirimKeUnitLain->isbayarkekasirpenunjang = isset($_POST['RJPasienKirimKeUnitLainT']['isbayarkekasirpenunjang']) ? $_POST['RJPasienKirimKeUnitLainT']['isbayarkekasirpenunjang'] : 0;
    $modKirimKeUnitLain->is_cito = isset($_POST['RJPasienKirimKeUnitLainT']['is_cito']) ? $_POST['RJPasienKirimKeUnitLainT']['is_cito'] : false;

    $modKirimKeUnitLain->nourut = MyGenerator::noUrutPasienKirimKeUnitLain($modKirimKeUnitLain->ruangan_id);
    if ($modKirimKeUnitLain->validate()) {
      $modKirimKeUnitLain->save();
      $this->statusSaveKirimkeUnitLain = true;

      $p = PendaftaranT::model()->findByPk($modPendaftaran->pendaftaran_id);
      // $updateStatusPeriksa = $p->setStatusPeriksa(Params::STATUSPERIKSA_SUDAH_DIPERIKSA);

      /* ================================================ */
      /* Proses update status periksa KonsulPoli EHS-179  */
      /* ================================================ */
      $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
      $konsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'ruangan_id' => $ruangan_id));
      if (!empty($konsulPoli)) {
        $updateStatusPeriksa = KonsulpoliT::model()->updateByPk($konsulPoli->konsulpoli_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
      }
      /* ================================================ */
    }

    return $modKirimKeUnitLain;
  }

  protected function savePermintaanPenunjang($permintaan, $modKirimKeUnitLain)
  {
    // var_dump($permintaan); die;

    foreach ($permintaan['inputpemeriksaanrad'] as $i => $value) {
      $modPermintaan = new RJPermintaanPenunjangT;
      $modPermintaan->daftartindakan_id = $permintaan['idDaftarTindakan'][$i];
      $modPermintaan->pemeriksaanlab_id = '';
      $modPermintaan->pemeriksaanrad_id = $permintaan['inputpemeriksaanrad'][$i];
      $modPermintaan->pasienkirimkeunitlain_id = $modKirimKeUnitLain->pasienkirimkeunitlain_id;
      $modPermintaan->noperminatanpenujang = MyGenerator::noPermintaanPenunjang('PR');
      $modPermintaan->qtypermintaan = $permintaan['inputqty'][$i];
      $modPermintaan->tarif_pelayananan = $permintaan['inputtarifpemeriksaanrad'][$i];
      $modPermintaan->tglpermintaankepenunjang = $modKirimKeUnitLain->tgl_kirimpasien; //date('Y-m-d H:i:s');
      if($modKirimKeUnitLain->is_cyto == true){
        $modTarif = TariftindakanM::model()->findByAttributes(array('kelaspelayanan_id'=>$modKirimKeUnitLain->kelaspelayanan_id,
                                                                            'daftartindakan_id'=>$modPermintaan->pemeriksaanrad->daftartindakan_id,
                                                                            'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));
        $modPermintaan->tarif_pelayananan = $modTarif->totaltarifakhir_cyto;
      }else{
        $modTarif = TariftindakanM::model()->findByAttributes(array('kelaspelayanan_id'=>$modKirimKeUnitLain->kelaspelayanan_id,
                                                                            'daftartindakan_id'=>$modPermintaan->pemeriksaanrad->daftartindakan_id,
                                                                            'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));
        $modPermintaan->tarif_pelayananan = $modTarif->harga_tariftindakan;
      }
      // insert paket pelayanan
      /*
                if (isset($permintaan['tindakanpelayanan_id'][$i])) {
                    $modPermintaan->tindakanpelayanan_id = $permintaan['tindakanpelayanan_id'][$i];
                }
                 * 
                 */

      if ($modPermintaan->validate()) {
        if ($modPermintaan->save()) {
          $this->statusSavePermintaanPenunjang = true;

          // insert tindakan, jika bayar kasir di centang dan belum ada tindakan dari paket.
          /*
						if($modKirimKeUnitLain->isbayarkekasirpenunjang && empty($modPermintaan->tindakanpelayanan_id)){ 
							$modPendaftaran = $modKirimKeUnitLain->pendaftaran;
							$modTindakan = $this->simpanTindakanPelayanan($modPendaftaran,$modKirimKeUnitLain,$modPermintaan); //AGAR BISA DI BAYAR DI KASIR
							$modPermintaan->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
							$modPermintaan->update();
						}
                         * 
                         */
        }
      }
      // var_dump($modPermintaan->attributes);
    }

    // die;
  }

  /**
   * proses simpan TindakanPelayananT dan TindakanKomponenT
   * khusus untuk permintaan penunjang
   */
  public function simpanTindakanPelayanan($modPendaftaran, $modKirimKeUnitLain, $modPermintaan)
  {
    $modTindakan = new RJTindakanPelayananT;

    $modTindakan->attributes = $modPendaftaran->attributes;
    $modTindakan->ruangan_id = $modKirimKeUnitLain->ruangan_id;
    $modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
    $modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modTindakan->daftartindakan_id = $modPermintaan->daftartindakan_id;
    $modTindakan->tarif_satuan = $modPermintaan->tarif_pelayananan;
    $modTindakan->qty_tindakan = $modPermintaan->qtypermintaan;
    $modTindakan->satuantindakan = Params::SATUAN_TINDAKAN_LABORATORIUM;
    $modTindakan->create_time = date("Y-m-d H:i:s");
    $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
    $modTindakan->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
    $modTindakan->dokterpemeriksa1_id = $modKirimKeUnitLain->pegawai_id;
    $modTindakan->perawat_id = (!empty($modKirimKeUnitLain->perawat_id) ? $modKirimKeUnitLain->perawat_id : null);
    $modTindakan->tgl_tindakan = $modPermintaan->tglpermintaankepenunjang;
    $modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
    $modTindakan->tarif_satuan = $modTindakan->getTarifSatuan(); //RND-7248
    $modTindakan->tarif_tindakan = $modTindakan->tarif_satuan * $modTindakan->qty_tindakan;
    $modTindakan->cyto_tindakan = 0;
    $modTindakan->tarifcyto_tindakan = 0;
    $modTindakan->discount_tindakan = 0;
    $modTindakan->subsidiasuransi_tindakan = 0;
    $modTindakan->subsidipemerintah_tindakan = 0;
    $modTindakan->subsisidirumahsakit_tindakan = 0;
    $modTindakan->iurbiaya_tindakan = 0;
    $modTindakan->tarif_rsakomodasi = 0;
    $modTindakan->tarif_medis = 0;
    $modTindakan->tarif_paramedis = 0;
    $modTindakan->tarif_bhp = 0;

    if ($modTindakan->validate()) {
      if ($modTindakan->save()) {
        $this->komponentindakantersimpan &= $modTindakan->saveTindakanKomponen();
      }
    } else {
      $this->tindakanpelayanantersimpan &= false;
    }

    return $modTindakan;
  }

  //copy dari RJ - LaboratoriumController penyesuaian di $modRiwayatKirimKeUnitLain
  public function actionAjaxBatalKirim()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pasienkirimkeunitlain_id = $_POST['pasienkirimkeunitlain_id'];
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $data['pesan'] = "Pasien kirim ke radiologi gagal dibatalkan!";
      $data['sukses'] = 0;
      $kirimUnit = array();

      $status = 'ok';

      $transaction = Yii::app()->db->beginTransaction();
      try {
        $criteria = new CDbCriteria();
        $criteria->select = "count(t.permintaankepenunjang_id) as permintaankepenunjang_id";
        $criteria->join = "join tindakanpelayanan_t tp on tp.tindakanpelayanan_id = t.tindakanpelayanan_id ";
        $criteria->addCondition("t.pasienkirimkeunitlain_id = " . $pasienkirimkeunitlain_id . " and tp.tindakansudahbayar_id is not null");
        $permintaan = PermintaankepenunjangT::model()->find($criteria);

        if ($permintaan->permintaankepenunjang_id > 0) {
          $data['pesan'] = "Pasien kirim ke radiologi tidak bisa dibatalkan karena tindakan sudah dibayarkan!";
          $data['sukses'] = 0;
        } else {
          $ok = true;
          $kirim = PasienkirimkeunitlainT::model()->findByPk($pasienkirimkeunitlain_id);

          if (!empty($kirim)) {
            $kirimUnit = array(
              'instalasi_id' => $kirim->instalasi_id,
              'ruangan_id' => $kirim->ruangan_id,
              'pasien_id' => $kirim->pasien_id,
              'no_pendaftaran' => $kirim->pendaftaran->no_pendaftaran
            );
          }

          $permintaan = PermintaankepenunjangT::model()->findAllByAttributes(array(
            'pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id
          ));
          foreach ($permintaan as $item) {
            if (!empty($item->tindakanpelayanan_id)) {
              $ok = $ok && TindakanpelayananT::model()->deleteByPk($item->tindakanpelayanan_id);
            }
          }
          $ok = $ok && PermintaankepenunjangT::model()->deleteAllByAttributes(array('pasienkirimkeunitlain_id' => $pasienkirimkeunitlain_id));
          $ok = $ok && PasienkirimkeunitlainT::model()->deleteByPk($pasienkirimkeunitlain_id);
          $keterangan = "Pasien berhasil dibatalkan";

          if ($status == 'ok' && $ok) {

            $this->notifBatalRujuk($kirimUnit);

            $data['pesan'] = "Pasien kirim ke radiologi berhasil dibatalkan!";
            $data['sukses'] = 1;
            $transaction->commit();
          } else {
            $transaction->rollback();
            $data['pesan'] = "Pasien kirim ke radiologi tidak bisa dibatalkan!";
            $data['sukses'] = 0;
          }
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $data['pesan'] = "Pasien kirim ke radiologi gagal dibatalkan!<br/>" . $exc->getMessage();
        $data['sukses'] = 0;
      }
      $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(
        array(
          'pendaftaran_id' => $pendaftaran_id,
          'ruangan_id' => Params::RUANGAN_ID_RAD
        ),
        'pasienmasukpenunjang_id IS NULL'
      );

      $data['result'] = $this->renderPartial($this->path_view . '_listKirimKeUnitLain', array('modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain), true);

      echo json_encode($data);
      Yii::app()->end();
    }
  }


  // public function actionPrint()
  // {
  //      $pendaftaran_id = $_GET['id'];
  //      $modPendaftaran= PendaftaranT::model()->findByPk($pendaftaran_id);
  //      $modKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAll('pendaftaran_id='.$pendaftaran_id);
  //      $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id'=>$pendaftaran_id,
  //                                                                                               'ruangan_id'=>Params::RUANGAN_ID_RAD),
  //                                                                                         'pasienmasukpenunjang_id IS NULL');

  //     $judulLaporan='Permintaan Pasien Ke Radiologi';
  //     $caraPrint=$_REQUEST['caraPrint'];
  //     if($caraPrint=='PRINT') {
  //         $this->layout='//layouts/printWindows';
  //         $this->render($this->path_view.'Print',array('modKirimKeUnitLain'=> $modKirimKeUnitLain,'modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
  //     }
  //     else if($caraPrint=='EXCEL') {
  //         $this->layout='//layouts/printExcel';
  //         $this->render($this->path_view.'Print',array('modKirimKeUnitLain'=> $modKirimKeUnitLain,'modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
  //     }
  //     else if($_REQUEST['caraPrint']=='PDF') {
  //         $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
  //         $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
  //         $mpdf = new MyPDF60('',$ukuranKertasPDF); 
  //         //$mpdf->useOddEven = 2;  
  //         $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
  //         $mpdf->WriteHTML($stylesheet,1);  
  //         $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
  //         $mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('modKirimKeUnitLain'=> $modKirimKeUnitLain,'modPendaftaran'=>$modPendaftaran,'modRiwayatKirimKeUnitLain'=>$modRiwayatKirimKeUnitLain,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
  //         $mpdf->Output();
  //     }                       
  // }

  public function actionPrint()
  {
    $pendaftaran_id = $_GET['id'];
    $idPasienKirimKeUnitLain = $_GET['idPasienKirimKeUnitLain'];
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(
      array(
        'pendaftaran_id' => $pendaftaran_id,
        'pasienkirimkeunitlain_id' => $idPasienKirimKeUnitLain
      ),
      'pasienmasukpenunjang_id IS NULL'
    );
    $modKirim = RJPasienKirimKeUnitLainT::model()->findByAttributes(
      array(
        'pendaftaran_id' => $pendaftaran_id,
        'pasienkirimkeunitlain_id' => $idPasienKirimKeUnitLain
      )
    );

    $judulLaporan = 'Permintaan Pemeriksaan Radiologi';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modKirim'=>$modKirim));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modKirim'=>$modKirim));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modKirim'=>$modKirim), true));
      $mpdf->Output();
    }
  }

  public function actionPrintRiwayat()
  {
    $pendaftaran_id = $_GET['id'];
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAll('pendaftaran_id=' . $pendaftaran_id);
    $modRiwayatKirimKeUnitLain = RJPasienKirimKeUnitLainT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'instalasi_id' => Params::INSTALASI_ID_RAD), 'pasienmasukpenunjang_id IS NULL');
    $judulLaporan = 'Permintaan Pemeriksaan Radiologi';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'printRiwayat', array('modKirimKeUnitLain' => $modKirimKeUnitLain, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'printRiwayat', array('modKirimKeUnitLain' => $modKirimKeUnitLain, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'printRiwayat', array('modKirimKeUnitLain' => $modKirimKeUnitLain, 'modPendaftaran' => $modPendaftaran, 'modRiwayatKirimKeUnitLain' => $modRiwayatKirimKeUnitLain, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  /**
   * @author Deni Hamdani <denihamdani@piindonesia.co.id>
   * 
   * UNTUK LOAD DAFTAR PEMERIKSAAN RADIOLOGI
   * 
   */
  public function actionLoadFormPemeriksaanRad()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pemeriksaanrad_id = (isset($_POST['pemeriksaanrad_id']) ? $_POST['pemeriksaanrad_id'] : null);
      $kelaspelayanan_id = (isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : null);
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

      //$modTindakanRuangan = TindakanruanganV::model()->findByAttributes(array('daftartindakan_id'=>$modPeriksaRad->daftartindakan_id));
      $criteria = new CDbCriteria();
      $criteria->addCondition('pemeriksaanrad_id = ' . $pemeriksaanrad_id);
      $criteria->addCondition('kelaspelayanan_id = ' . $kelaspelayanan_id);
      $criteria->addCondition('penjamin_id = ' . $modPendaftaran->penjamin_id);
      $modTarif = TarifpemeriksaanradruanganV::model()->find($criteria);



      $id_tindakan = null;
      $paket = null;

      /*
                if (!empty($modTarif)) {
                    $crPaket = new CDbCriteria();
                    $crPaket->compare('t.daftartindakan_id', $modTarif->daftartindakan_id);
                    $crPaket->addCondition('t.tipepaket_id <> '.Params::TIPEPAKET_ID_NONPAKET);
                    $crPaket->join = 'left join permintaankepenunjang_t p on t.tindakanpelayanan_id = p.tindakanpelayanan_id';
                    $crPaket->addCondition('p.tindakanpelayanan_id is null');
                    $crPaket->order = 'p.tindakanpelayanan_id asc';
                    
                    $tindakanPaket = TindakanpelayananT::model()->find($crPaket);
                    
                    if (!empty($tindakanPaket)) {
                        $id_tindakan = null; //$tindakanPaket->tindakanpelayanan_id;
                        $paket = TipepaketM::model()->findByPk($tindakanPaket->tipepaket_id);
                    }
                }
                 * 
                 */

      /**
       * dicomment RND-3288
       */
      //                $jenistarif = JenistarifpenjaminM::model()->find('penjamin_id = '.$modPasienAdmisi->penjamin_id)->jenistarif_id;
      //                $modPeriksaRad = PemeriksaanradM::model()->findByPk($pemeriksaanrad_id);
      //                $modTarif = TariftindakanM::model()->findByAttributes(array('daftartindakan_id'=>$modPeriksaRad->daftartindakan_id,
      //                                                                            'kelaspelayanan_id'=>$kelaspelayanan_id,
      //                                                                            'jenistarif_id'=>$jenistarif,
      //                                                                            'komponentarif_id'=>Params::KOMPONENTARIF_ID_TOTAL));
      echo CJSON::encode(array(
        'status' => 'create_form',
        'form' => $this->renderPartial($this->path_view . '_formLoadPemeriksaanRad', array(
          //                                                                                'modPeriksaRad'=>$modPeriksaRad,
          //'modTindakanRuangan'=>$modTindakanRuangan,
          'modTarif' => $modTarif, 'id_tindakan' => $id_tindakan, 'paket' => $paket
        ), true)
      ));
      exit;
    }
  }

  /**
   * - digunakan untuk mengenerate notif batal rujukan
   * @param type $modKirimKeunitlain
   */
  protected function notifBatalRujuk($modKirimKeunitlain)
  {

    $modRuangan = RuanganM::model()->findByPk($modKirimKeunitlain['ruangan_id']);
    $pasien_id = $modKirimKeunitlain['pasien_id'];
    $modPasien = PasienM::model()->findByPk($pasien_id);
    $judul = 'Pasien Batal Rujuk Radiologi';

    $isi = $modKirimKeunitlain['no_pendaftaran'] . ' ' . $modPasien->no_rekam_medik . ' ' . $modPasien->nama_pasien;


    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => $modKirimKeunitlain['instalasi_id'], 'ruangan_id' => $modRuangan->ruangan_id, 'modul_id' => $modRuangan->modul_id),
    ));
  }

  // Uncomment the following methods and override them if needed
  /*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
  /**
   * set autocomplte panel pemeriksaan radiologi
   */
  /**
   * set checklist pemeriksaan lab
   */
  public function actionSetChecklistPemeriksaanRad()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $content = "";
      parse_str($_POST['data'], $post);
      $postPemeriksaan = $post['TarifpemeriksaanradruanganV'];

      $jenispemeriksaanrad_nama = $postPemeriksaan['jenispemeriksaanrad_nama'] ?? null;
      $pemeriksaanrad_nama = $postPemeriksaan['pemeriksaanrad_nama'] ?? null;
      $kelaspelayanan_id = $postPemeriksaan['kelaspelayanan_id'] ?? null;

      // echo '<pre>'; var_dump($post); die();

      // tarif radiologi antar kelas sama
      //$postPemeriksaan['kelaspelayanan_id'] = Params::KELASPELAYANAN_ID_TANPA_KELAS;

      // if ( !empty($postPemeriksaan['pemeriksaanrad_nama']) ) {
      // $modPeriksaRad = RJPemeriksaanRadM::model()->findAllByAttributes(array('pemeriksaanrad_aktif' => true), array('order' => 'jenispemeriksaanrad_id, pemeriksaanrad_urutan ASC'));


      $critRad = new CDbCriteria();
      $critRad->select = 'jenispemeriksaanrad_id, jenispemeriksaanrad_nama, pemeriksaanrad_id, pemeriksaanrad_nama, jenispemeriksaanrad_urutan, pemeriksaanrad_urutan';
      $critRad->group = $critRad->select;
      $critRad->order = 'jenispemeriksaanrad_urutan, jenispemeriksaanrad_nama, pemeriksaanrad_nama';
      $critRad->compare('LOWER(jenispemeriksaanrad_nama)', strtolower($jenispemeriksaanrad_nama), true);
      $critRad->compare('LOWER(pemeriksaanrad_nama)', strtolower($pemeriksaanrad_nama), true);
      if(!empty($kelaspelayanan_id)) {
        $critRad->addCondition('kelaspelayanan_id = ' . $kelaspelayanan_id);
      }
      $modPeriksaRad = RJTarifpemeriksaanradruanganV::model()->findAll($critRad);

      // echo '<pre>'; var_dump($post); die();


      // var_dump($modPemeriksaanlabs);die();
      $content = $this->renderPartial($this->path_view . '_checklistPemeriksaanRad', array('modPeriksaRad' => $modPeriksaRad), true);
      // }
      echo CJSON::encode(array(
        'content' => $content
      ));
      Yii::app()->end();
    }
  }
}
