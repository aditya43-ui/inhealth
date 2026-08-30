<?php
class PemeriksaanPasienController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'rawatJalan.views.pemeriksaanPasien.';
  public $path_view2 = 'rawatJalan.views._periksaDataPasien.';
  /**
   * Lists all models.
   */
  public function actionIndex($pendaftaran_id, $pasienmasukpenunjang_id = null, $lihat = null)
  {
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $waktutunggupelayanan = WaktutunggupelayananT::model()->findByAttributes(array(
      'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
      'task_id' => 4
    ));
    $kodebooking = $modPendaftaran->no_pendaftaran;
    if (!empty($modPendaftaran->buatjanjipoli_id)) {
      $buatjanjipoli = BuatjanjipoliT::model()->findByPk($modPendaftaran->buatjanjipoli_id);

      if (!empty($buatjanjipoli)) {
        $kodebooking = $buatjanjipoli->no_buatjanji;
      }
    }
    if (empty($waktutunggupelayanan)) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $index_antrianol = 3;

        //task_id 4
        $waktutunggupelayanan = new WaktutunggupelayananT();
        $waktutunggupelayanan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $waktutunggupelayanan->pasien_id = $modPendaftaran->pasien_id;
        $waktutunggupelayanan->task_id = 4;
        $lookup_waktutunggu = LookupM::model()->findByAttributes(array('lookup_type' => 'taskid', 'lookup_value' => $waktutunggupelayanan->task_id));
        $waktutunggupelayanan->task_name = (!empty($lookup_waktutunggu) ? $lookup_waktutunggu->lookup_name : null);
        $dateNow = date('c', strtotime(date('Y-m-d H:i:s')));
        $waktutunggupelayanan->waktutunggu_rs = date('Y-m-d H:i:s', strtotime($dateNow));
        $waktutunggupelayanan->tanggal = $waktutunggupelayanan->waktutunggu_rs;
        $waktutunggupelayanan->kode_booking = $kodebooking; //$modPendaftaran->no_pendaftaran;
        $waktutunggupelayanan->create_time = $waktutunggupelayanan->waktutunggu_rs;
        $waktutunggupelayanan->create_loginpemakai_id = Yii::app()->user->id;
        $waktutunggupelayanan->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
        $waktutunggupelayanan->waktutunggu_mil = (strtotime($dateNow) * 1000);

        $antrianonlinebpjs = new AntrianOnlineBpjs();
        $body = array(
          "kodebooking" => $kodebooking, "taskid" => $waktutunggupelayanan->task_id, "waktu" => $waktutunggupelayanan->waktutunggu_mil
        );
        $response = CJSON::decode($antrianonlinebpjs->update_waktu($body));

        if (
          !empty($response['metaData']['code']) && $response['metaData']['code'] == '200'
        ) {
          $waktutunggupelayanan->statuskirim = 1;
          $waktutunggupelayanan->update_loginpemakai_id = Yii::app()->user->id;
          $waktutunggupelayanan->update_time = date('Y-m-d H:i:s');
        } else {
          $waktutunggupelayanan->statuskirim = 0;
          $waktutunggupelayanan->response_list = $response['metaData']['message'];
        }
        $waktutunggupelayanan->save();

        //task_id 5
        $waktutunggupelayanan = new WaktutunggupelayananT();
        $waktutunggupelayanan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $waktutunggupelayanan->pasien_id = $modPendaftaran->pasien_id;
        $waktutunggupelayanan->task_id = 5;
        $lookup_waktutunggu = LookupM::model()->findByAttributes(array('lookup_type' => 'taskid', 'lookup_value' => $waktutunggupelayanan->task_id));
        $waktutunggupelayanan->task_name = (!empty($lookup_waktutunggu) ? $lookup_waktutunggu->lookup_name : null);
        if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GIGI_UMUM || Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GIGI_ANAK || Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GIGI_KONSERVASI) {
          $dateNow = date('c', strtotime(date("Y-m-d H:i:s", strtotime("+20 minutes"))));
        } else if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GIGI_LAKTASI) {
          $dateNow = date('c', strtotime(date("Y-m-d H:i:s", strtotime("+10 minutes"))));
        } else if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GIGI_JIWA) {
          $dateNow = date('c', strtotime(date("Y-m-d H:i:s", strtotime("+45 minutes"))));
        } else if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GIGI_PSIKOLOG_ANAK || Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GIGI_PSIKOLOG_DEWASA) {
          $dateNow = date('c', strtotime(date("Y-m-d H:i:s", strtotime("+15 minutes"))));
        } else {
          $dateNow = date('c', strtotime(date("Y-m-d H:i:s", strtotime("+5 minutes"))));
        }


        $waktutunggupelayanan->waktutunggu_rs = date('Y-m-d H:i:s', strtotime($dateNow));
        $waktutunggupelayanan->tanggal = $waktutunggupelayanan->waktutunggu_rs;
        $waktutunggupelayanan->kode_booking = $kodebooking; //$modPendaftaran->no_pendaftaran;
        $waktutunggupelayanan->create_time = $waktutunggupelayanan->waktutunggu_rs;
        $waktutunggupelayanan->create_loginpemakai_id = Yii::app()->user->id;
        $waktutunggupelayanan->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
        $waktutunggupelayanan->waktutunggu_mil = (strtotime($dateNow) * 1000);

        $antrianonlinebpjs = new AntrianOnlineBpjs();
        $body = array(
          "kodebooking" => $kodebooking, "taskid" => $waktutunggupelayanan->task_id, "waktu" => $waktutunggupelayanan->waktutunggu_mil
        );
        $response = CJSON::decode($antrianonlinebpjs->update_waktu($body));

        if (
          !empty($response['metaData']['code']) && $response['metaData']['code'] == '200'
        ) {
          $waktutunggupelayanan->statuskirim = 1;
          $waktutunggupelayanan->update_loginpemakai_id = Yii::app()->user->id;
          $waktutunggupelayanan->update_time = date('Y-m-d H:i:s');
        } else {
          $waktutunggupelayanan->statuskirim = 0;
          $waktutunggupelayanan->response_list = $response['metaData']['message'];
        }
        $waktutunggupelayanan->save();

        $transaction->commit();
      } catch (Exception $exc) {
        var_dump($exc->getMessage(), $exc->getTraceAsString());
        die;
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data pasien gagal disimpan ! " . $exc->getMessage());
      }
    }

    $modul = Yii::app()->controller->module->id;

    // var_dump($modul); die;

    if($modul == 'rawatDarurat') {

      $this->render('rawatDarurat.views.pemeriksaanPasienTRD.index', array(
        'modPendaftaran' => $modPendaftaran,
        'modPasien' => $modPasien,
      ));

    } else if ($modul == 'hemodialisa') {
      $this->render('hemodialisa.views.pemeriksaanPasienTHD.index', array(
        'modPendaftaran' => $modPendaftaran,
        'modPasien' => $modPasien,
      ));

    } else if ($modul == 'rehabMedis') {
      $this->render('rehabMedis.views.pemeriksaanPasienTRM.index', array(
        'modPendaftaran' => $modPendaftaran,
        'modPasien' => $modPasien,
      ));

    } else {

      $this->render('index', array(
        'modPendaftaran' => $modPendaftaran,
        'modPasien' => $modPasien,
      ));

    }

    
  }


  public function actionIndex2($pendaftaran_id)
  {


    $this->layout = '//layouts/iframe';
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $waktutunggupelayanan = WaktutunggupelayananT::model()->findByAttributes(array(
      'pendaftaran_id' => $modPendaftaran->pendaftaran_id,
      'task_id' => 4
    ));
    $kodebooking = $modPendaftaran->no_pendaftaran;
    if (!empty($modPendaftaran->buatjanjipoli_id)) {
      $buatjanjipoli = BuatjanjipoliT::model()->findByPk($modPendaftaran->buatjanjipoli_id);

      if (!empty($buatjanjipoli)) {
        $kodebooking = $buatjanjipoli->no_buatjanji;
      }
    }
    if (empty($waktutunggupelayanan)) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $index_antrianol = 3;

        //task_id 4
        $waktutunggupelayanan = new WaktutunggupelayananT();
        $waktutunggupelayanan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $waktutunggupelayanan->pasien_id = $modPendaftaran->pasien_id;
        $waktutunggupelayanan->task_id = 4;
        $lookup_waktutunggu = LookupM::model()->findByAttributes(array('lookup_type' => 'taskid', 'lookup_value' => $waktutunggupelayanan->task_id));
        $waktutunggupelayanan->task_name = (!empty($lookup_waktutunggu) ? $lookup_waktutunggu->lookup_name : null);
        $dateNow = date('c', strtotime(date('Y-m-d H:i:s')));
        $waktutunggupelayanan->waktutunggu_rs = date('Y-m-d H:i:s', strtotime($dateNow));
        $waktutunggupelayanan->tanggal = $waktutunggupelayanan->waktutunggu_rs;
        $waktutunggupelayanan->kode_booking = $kodebooking; //$modPendaftaran->no_pendaftaran;
        $waktutunggupelayanan->create_time = $waktutunggupelayanan->waktutunggu_rs;
        $waktutunggupelayanan->create_loginpemakai_id = Yii::app()->user->id;
        $waktutunggupelayanan->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
        $waktutunggupelayanan->waktutunggu_mil = (strtotime($dateNow) * 1000);

        $antrianonlinebpjs = new AntrianOnlineBpjs();
        $body = array(
          "kodebooking" => $kodebooking, "taskid" => $waktutunggupelayanan->task_id, "waktu" => $waktutunggupelayanan->waktutunggu_mil
        );
        $response = CJSON::decode($antrianonlinebpjs->update_waktu($body));

        if (
          !empty($response['metaData']['code']) && $response['metaData']['code'] == '200'
        ) {
          $waktutunggupelayanan->statuskirim = 1;
          $waktutunggupelayanan->update_loginpemakai_id = Yii::app()->user->id;
          $waktutunggupelayanan->update_time = date('Y-m-d H:i:s');
        } else {
          $waktutunggupelayanan->statuskirim = 0;
          $waktutunggupelayanan->response_list = $response['metaData']['message'];
        }
        $waktutunggupelayanan->save();

        //task_id 5
        $waktutunggupelayanan = new WaktutunggupelayananT();
        $waktutunggupelayanan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
        $waktutunggupelayanan->pasien_id = $modPendaftaran->pasien_id;
        $waktutunggupelayanan->task_id = 5;
        $lookup_waktutunggu = LookupM::model()->findByAttributes(array('lookup_type' => 'taskid', 'lookup_value' => $waktutunggupelayanan->task_id));
        $waktutunggupelayanan->task_name = (!empty($lookup_waktutunggu) ? $lookup_waktutunggu->lookup_name : null);
        if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GIGI_UMUM || Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GIGI_ANAK || Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GIGI_KONSERVASI) {
          $dateNow = date('c', strtotime(date("Y-m-d H:i:s", strtotime("+20 minutes"))));
        } else if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GIGI_LAKTASI) {
          $dateNow = date('c', strtotime(date("Y-m-d H:i:s", strtotime("+10 minutes"))));
        } else if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GIGI_JIWA) {
          $dateNow = date('c', strtotime(date("Y-m-d H:i:s", strtotime("+45 minutes"))));
        } else if (Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GIGI_PSIKOLOG_ANAK || Yii::app()->user->getState('ruangan_id') == Params::RUANGAN_ID_GIGI_PSIKOLOG_DEWASA) {
          $dateNow = date('c', strtotime(date("Y-m-d H:i:s", strtotime("+15 minutes"))));
        } else {
          $dateNow = date('c', strtotime(date("Y-m-d H:i:s", strtotime("+5 minutes"))));
        }


        $waktutunggupelayanan->waktutunggu_rs = date('Y-m-d H:i:s', strtotime($dateNow));
        $waktutunggupelayanan->tanggal = $waktutunggupelayanan->waktutunggu_rs;
        $waktutunggupelayanan->kode_booking = $kodebooking; //$modPendaftaran->no_pendaftaran;
        $waktutunggupelayanan->create_time = $waktutunggupelayanan->waktutunggu_rs;
        $waktutunggupelayanan->create_loginpemakai_id = Yii::app()->user->id;
        $waktutunggupelayanan->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
        $waktutunggupelayanan->waktutunggu_mil = (strtotime($dateNow) * 1000);

        $antrianonlinebpjs = new AntrianOnlineBpjs();
        $body = array(
          "kodebooking" => $kodebooking, "taskid" => $waktutunggupelayanan->task_id, "waktu" => $waktutunggupelayanan->waktutunggu_mil
        );
        $response = CJSON::decode($antrianonlinebpjs->update_waktu($body));

        if (
          !empty($response['metaData']['code']) && $response['metaData']['code'] == '200'
        ) {
          $waktutunggupelayanan->statuskirim = 1;
          $waktutunggupelayanan->update_loginpemakai_id = Yii::app()->user->id;
          $waktutunggupelayanan->update_time = date('Y-m-d H:i:s');
        } else {
          $waktutunggupelayanan->statuskirim = 0;
          $waktutunggupelayanan->response_list = $response['metaData']['message'];
        }
        $waktutunggupelayanan->save();

        $transaction->commit();
      } catch (Exception $exc) {
        var_dump($exc->getMessage(), $exc->getTraceAsString());
        die;
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data pasien gagal disimpan ! " . $exc->getMessage());
      }
    }


    $this->render('index2', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
    ));
  }



  public function actionLoadFormDiagnosis()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idDiagnosa = (isset($_POST['idDiagnosa']) ? $_POST['idDiagnosa'] : null);
      $idKelDiagnosa = (isset($_POST['idKelDiagnosa']) ? $_POST['idKelDiagnosa'] : null);
      $tglDiagnosa = (isset($_POST['tglDiagnosa']) ? $_POST['tglDiagnosa'] : null);

      if (!empty($idKelDiagnosa)) {
        $modDiagnosaicdixM = DiagnosaicdixM::model()->findAll();
        $modSebabDiagnosa = SebabdiagnosaM::model()->findAll();
        $modDiagnosa = DiagnosaM::model()->findByPk($idDiagnosa);

        echo CJSON::encode(array(
          'status' => 'create_form',
          'form' => $this->renderPartial('/diagnosa/_formLoadDiagnosis', array(
            'modDiagnosa' => $modDiagnosa,
            'idKelDiagnosa' => $idKelDiagnosa,
            'modDiagnosaicdixM' => $modDiagnosaicdixM,
            'modSebabDiagnosa' => $modSebabDiagnosa,
            'tglDiagnosa' => $tglDiagnosa
          ), true)
        ));
        exit;
      } else {
        echo CJSON::encode(array('status' => 'fail', 'pesan' => 'Pilih terlebih dahulu kelompok diagnosa!'));
        exit;
      }
    }
  }

  public function actionSaveDiagnosis()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $IdPendaftaran = $_POST['IdPendaftaran'];
      $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByAttributes(array('pendaftaran_id' => $IdPendaftaran));

      $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
      $morbiditas = new RJPasienMorbiditasT;
      $morbiditas->pendaftaran_id = $modPendaftaran->pendaftaran_id;
      $morbiditas->pasien_id = $modPendaftaran->pasien_id;
      $morbiditas->ruangan_id = Yii::app()->user->getState('ruangan_id');
      $morbiditas->kelompokumur_id = $modPasien->kelompokumur_id;
      $morbiditas->golonganumur_id = $modPendaftaran->golonganumur_id;
      $morbiditas->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
      $morbiditas->pegawai_id = $modPendaftaran->pegawai_id;
      $morbiditas->diagnosa_id = $_POST['idDiagnosa'];
      $morbiditas->kelompokdiagnosa_id = $_POST['kelompokDiagnosa'];
      $morbiditas->infeksinosokomial = '0';
      $morbiditas->tglmorbiditas = (isset($_POST['tglDiagnosa']) ? $_POST['tglDiagnosa'] : null);

      $modMorbiditas = PasienmorbiditasT::model()->findByAttributes(array('pasien_id' => $modPendaftaran->pasien_id, 'diagnosa_id' => $morbiditas->diagnosa_id));
      if (!empty($modMorbiditas))
        $morbiditas->kasusdiagnosa = Params::KASUSDIAGNOSA_KASUS_LAMA;
      else
        $morbiditas->kasusdiagnosa = Params::KASUSDIAGNOSA_KASUS_BARU;

      $valid = $morbiditas->validate();
      if ($valid) {
        $morbiditas->save();
      }
    }
  }

  public function actionHapusDiagnosis()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $IdPendaftaran = $_POST['IdPendaftaran'];
      $idDiagnosa    = $_POST['idDiagnosa'];

      $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByAttributes(array('pendaftaran_id' => $IdPendaftaran));

      PasienmorbiditasT::model()->deleteAllByAttributes(array('diagnosa_id' => $idDiagnosa, 'pendaftaran_id' => $modPendaftaran->pendaftaran_id));
    }
  }

  public function actionCheckData()
  {
    $modDaftar = new PendaftaranT();
    $modDaftar->unsetAttributes();  // clear any default values
    $id = null;
    if (isset($_POST['pendaftaran_id'])) {
      $id = $_POST['pendaftaran_id'];
      //$modDaftar->pendaftaran_id = $_POST['pendaftaran_id'];
      $modPendaf = PendaftaranT::model()->findByPk($id);
      $modDaftar->pasien_id = (isset($modPendaf) ? $modPendaf->pasien_id : null);
      $modDaftar->isprmrj = true;
      $modDaftar->instalasi_id = Params::INSTALASI_ID_RJ;
      $modDaftar->ceklispendaftaran = false;
    }

    if (isset($_GET['PendaftaranT'])) {
      $id = $_GET['PendaftaranT']['pendaftaran_id'];
      $modDaftar->attributes = $_GET['PendaftaranT'];
      $modDaftar->pendaftaran_id = $_GET['PendaftaranT']['pendaftaran_id'];
      $modDaftar->instalasi_id = $_GET['PendaftaranT']['instalasi_id'];
      $modDaftar->isprmrj = $_GET['PendaftaranT']['isprmrj'];
      $modDaftar->ruangan_id = $_GET['PendaftaranT']['ruangan_id'];
      $modDaftar->pegawai_id = $_GET['PendaftaranT']['pegawai_id'];
      $modDaftar->ceklispendaftaran = $_GET['PendaftaranT']['ceklispendaftaran'];
      $modDaftar->diagnosa_nama = (!empty($_GET['PendaftaranT']['diagnosa_nama']) ? $_GET['PendaftaranT']['diagnosa_nama'] : null);
      $modDaftar->diagnosa_kode = (!empty($_GET['PendaftaranT']['diagnosa_kode']) ? $_GET['PendaftaranT']['diagnosa_kode'] : null);
    }
    $modDaftar->pendaftaran_id = $id;

    if (Yii::app()->request->isAjaxRequest) {
      echo $this->renderPartial('_riwayatProfilRingkasMedis', array('modDaftar' => $modDaftar));
    }
  }

  public function actionCekPeriksaLengkapBackup() {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $id = $_POST['pendaftaran_id'];

    $anamnesa = AnamnesaT::model()->countByAttributes(array(
      'pendaftaran_id'=>$id,
    ));
    $periksa = PemeriksaanfisikT::model()->countByAttributes(array(
      'pendaftaran_id'=>$id,
    ));
    $diagnosa = PasienmorbiditasT::model()->countByAttributes(array(
      'pendaftaran_id'=>$id,
    ));

    $is_lengkap = (($anamnesa > 0) && ($periksa > 0) && ($diagnosa > 0)) ? 1 : 0;

    echo CJSON::encode(array('is_lengkap'=>$is_lengkap));
  }

  public function actionCekPeriksaLengkap() {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $id = $_POST['pendaftaran_id'];

    $anamnesa = AnamnesaT::model()->countByAttributes(array(
      'pendaftaran_id'=>$id,
    ));
    $periksa = PemeriksaanfisikT::model()->countByAttributes(array(
      'pendaftaran_id'=>$id,
    ));
    $diagnosa = PasienmorbiditasT::model()->countByAttributes(array(
      'pendaftaran_id'=>$id,
    ));

    $is_lengkap = (($anamnesa > 0) && ($periksa > 0) && ($diagnosa > 0)) ? 1 : 0;

    echo CJSON::encode(array('is_lengkap'=>$is_lengkap));
  }

  function actionGetDataPemeriksaanPenunjang() {
    $pendaftaran_id = $_POST['pendaftaran_id'];
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $data['pesan'] = 'Pendaftaran_id kosong';
    $data['reseptur'] = 0;
    $data['labKlinik'] = 0;
    $data['labPA'] = 0;
    $data['labMikro'] = 0;
    $data['labRadiologi'] = 0;
    $data['konsulPoli'] = 0;

    if(!empty($pendaftaran_id)) {
      // reseptur
      $modReseptur = ResepturT::model()->findByAttributes(['pasien_id' => $modPendaftaran->pasien_id]);
  
      // lab klinik
      $modLabKlinik = PasienkirimkeunitlainT::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => Params::RUANGAN_ID_LAB_KLINIK]);
  
      // lab PA
      $modLabPA = PasienkirimkeunitlainT::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => Params::RUANGAN_ID_LAB_ANATOMI], 'pasienmasukpenunjang_id IS NULL');
  
      // lab mikrobiologi
      $criRiwayat = new CDbCriteria();
      $criRiwayat->join = " JOIN ruangan_m r ON r.ruangan_id = t.ruangan_id "
          . "JOIN instalasi_m i ON i.instalasi_id = r.instalasi_id ";
      $criRiwayat->addCondition(" pendaftaran_id =" . $pendaftaran_id);
      $criRiwayat->compare("t.ruangan_id", Params::RUANGAN_ID_LAB_MIKROBIOLOGI);
      $modLabMikro = RJPasienKirimKeUnitLainT::model()->findAll($criRiwayat);
     
      // lab radiologi
      $q_riwayat = "(pendaftaran_id = ".$pendaftaran_id." OR (pendaftaran_id IS NULL AND pasien_id = ".$modPendaftaran->pasien_id.") ) AND instalasi_id = ".Params::INSTALASI_ID_RAD." ORDER BY  pasienmasukpenunjang_id IS NULL";
      $modLabRadiologi = PasienKirimKeUnitLainT::model()->findAll($q_riwayat);
     
  
      // konsuldokterlain
      $modKonsul = KonsulpoliT::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id]);


      // pengkondisian
      if(!empty($modReseptur)) {
        $data['reseptur'] = 1;
      }
      if(!empty($modLabKlinik)) {
        $data['labKlinik'] = 1;
      }
      if(!empty($modLabPA)) {
        $data['labPA'] = 1;
      }
      if(!empty($modLabMikro)) {
        $data['labMikro'] = 1;
      }
      if(!empty($modLabRadiologi)) {
        $data['labRadiologi'] = 1;
      }
      if(!empty($modKonsul)) {
        $data['konsulPoli'] = 1;
      }

      $data['pesan'] = 'data berhasi didapat';
    }

    echo json_encode($data);

    
  }
}
