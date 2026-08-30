<?php
class PemeriksaanPasienController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'tindakan.views.pemeriksaanPasien.';
  /**
   * Lists all models.
   */
  public function actionIndex($pendaftaran_id, $pasienmasukpenunjang_id = null)
  {
    $modPendaftaran = RJPendaftaranT::model()->with('jeniskasuspenyakit')->findByPk($pendaftaran_id);
    $modPasienMasukPenunjang = PasienmasukpenunjangT::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id]);
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
        $waktutunggupelayanan->kode_booking = $kodebooking;//$modPendaftaran->no_pendaftaran;
        $waktutunggupelayanan->statuskirim = 0;
        $waktutunggupelayanan->create_time = $waktutunggupelayanan->waktutunggu_rs;
        $waktutunggupelayanan->create_loginpemakai_id = Yii::app()->user->id;
        $waktutunggupelayanan->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
        $waktutunggupelayanan->waktutunggu_mil = (strtotime($dateNow) * 1000);

        $waktutunggupelayanan->save();
        if ($waktutunggupelayanan->save()) {
          if (Yii::app()->user->getState('antreanonlinewsbpjs')) {
            $body_waktutgp = array("kodebooking" => $waktutunggupelayanan->kode_booking, "taskid" => $waktutunggupelayanan->task_id, "waktu" => $waktutunggupelayanan->waktutunggu_mil);
            $antrianonlinebpjs = new AntrianOnlineBpjs();
            $response_antrianol = CJSON::decode($antrianonlinebpjs->update_waktu($body_waktutgp));
            $dateNowUpdt = date('c', strtotime(date('Y-m-d H:i:s')));

            if (!empty($response_antrianol['metaData']['code']) && $response_antrianol['metaData']['code'] == '200') {
              WaktutunggupelayananT::model()->updateByPk($waktutunggupelayanan->waktutunggupelayanan_id, array('statuskirim' => true, 'update_loginpemakai_id' => Yii::app()->user->id, 'update_time' => date('Y-m-d H:i:s', strtotime($dateNowUpdt))));
            } else {
              if (!empty($response_antrianol['metaData']['code'])) {
                WaktutunggupelayananT::model()->updateByPk($waktutunggupelayanan->waktutunggupelayanan_id, array('response_list' => $response_antrianol['metaData']['message']));
              }
            }
          }
        }

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
        $waktutunggupelayanan->kode_booking = $kodebooking;//$modPendaftaran->no_pendaftaran;
        $waktutunggupelayanan->statuskirim = 0;
        $waktutunggupelayanan->create_time = $waktutunggupelayanan->waktutunggu_rs;
        $waktutunggupelayanan->create_loginpemakai_id = Yii::app()->user->id;
        $waktutunggupelayanan->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
        $waktutunggupelayanan->waktutunggu_mil = (strtotime($dateNow) * 1000);

        $waktutunggupelayanan->save();

        if ($waktutunggupelayanan->save()) {
          if (Yii::app()->user->getState('antreanonlinewsbpjs')) {
            $body_waktutgp = array("kodebooking" => $waktutunggupelayanan->kode_booking, "taskid" => $waktutunggupelayanan->task_id, "waktu" => $waktutunggupelayanan->waktutunggu_mil);
            $antrianonlinebpjs = new AntrianOnlineBpjs();
            $response_antrianol = CJSON::decode($antrianonlinebpjs->update_waktu($body_waktutgp));
            $dateNowUpdt = $dateNow;

            if (!empty($response_antrianol['metaData']['code']) && $response_antrianol['metaData']['code'] == '200') {
              WaktutunggupelayananT::model()->updateByPk($waktutunggupelayanan->waktutunggupelayanan_id, array('statuskirim' => true, 'update_loginpemakai_id' => Yii::app()->user->id, 'update_time' => date('Y-m-d H:i:s', strtotime($dateNowUpdt))));
            } else {
              if (!empty($response_antrianol['metaData']['code'])) {
                WaktutunggupelayananT::model()->updateByPk($waktutunggupelayanan->waktutunggupelayanan_id, array('response_list' => $response_antrianol['metaData']['message']));
              }
            }
          }
        }

        $transaction->commit();
      } catch (Exception $exc) {
        var_dump($exc->getMessage(), $exc->getTraceAsString());
        die;
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data pasien gagal disimpan ! " . $exc->getMessage());
      }
    }

    if(!empty($pasienmasukpenunjang_id)) {
      $modPenunjang = PasienmasukpenunjangT::model()->findByPk($pasienmasukpenunjang_id);
      if(!empty($modPenunjang)) {
        $modPendaftaran->dokter_pemeriksa = $modPenunjang->pegawai->namaLengkap;
      }
    }


    $this->render('index', array(
      'modPendaftaran' => $modPendaftaran,
      'modPasien' => $modPasien,
      'modPasienMasukPenunjang' => $modPasienMasukPenunjang
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
}
