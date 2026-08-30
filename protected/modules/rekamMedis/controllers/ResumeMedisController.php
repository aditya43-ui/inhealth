<?php

class ResumeMedisController extends MyAuthController
{
  public $path_view = "rekamMedis.views.resumeMedis.";

  // dicopy dari laboratorium.controller.pemakaianBmhp
  public function actionIndex($pendaftaran_id = null)
  {
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }

    $this->pageTitle = Yii::app()->name . " - Resume Medis";
    $format = new MyFormatter();
    $modKunjungan = new RKInfopasienpengunjungV;
    $modKunjungan->ruangan_id = Yii::app()->user->getState("ruangan_id");
    $modResume = new RKResumemedisR;
    $dataDiagnosa = null;
    if (isset($_GET['pendaftaran_id'])) {
      $modKunjungan = RKInfopasienpengunjungV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));
      $modKunjungan->tgl_pendaftaran = $format::FormatDateTimeForUser($modKunjungan->tgl_pendaftaran);
      $modKunjungan->tanggal_lahir = $format::FormatDateTimeForUser($modKunjungan->tanggal_lahir);
      $modKunjungan->tglpasienpulang = $format::FormatDateTimeForUser($modKunjungan->tglpasienpulang);
      $modResume = RKResumemedisR::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']), array('order' => 'resumemedis_id DESC'));
      if (empty($modResume)) {
        $modResume = new RKResumemedisR;
      }

      $dataDiagnosa['diagnosaawal'] = '';
      $dataDiagnosa['diagnosautama'] = '';
      // load diagnosa awal
      $criteria = new CDbCriteria;
      $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
      $criteria->addCondition("kelompokdiagnosa_id = " . Params::KELOMPOKDIAGNOSA_MASUK);
      $modPasienMorbiditas = RKPasienMorbiditasT::model()->find($criteria);
      if (!empty($modPasienMorbiditas)) {
        $dataDiagnosa['diagnosaawal'] .= "Diagnosa awal : " . $modPasienMorbiditas->diagnosa->diagnosa_kode . " - " . $modPasienMorbiditas->diagnosa->diagnosa_nama;
      } else {
        $dataDiagnosa['diagnosaawal'] .= "";
      }

      //load diagnosa akhir
      $criteria = new CDbCriteria;
      $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
      $criteria->addInCondition(
        'kelompokdiagnosa_id',
        array(
          Params::KELOMPOKDIAGNOSA_UTAMA,
          Params::KELOMPOKDIAGNOSA_TAMBAH
        )
      );
      $modPasienMorbiditass = RKPasienMorbiditasT::model()->findAll($criteria);
      foreach ($modPasienMorbiditass as $key => $modPasienMorbiditas) {
        if ($modPasienMorbiditas->kelompokdiagnosa_id == Params::KELOMPOKDIAGNOSA_UTAMA) {
          $dataDiagnosa['diagnosautama'] .= "Diagnosa utama : " . $modPasienMorbiditas->diagnosa->diagnosa_kode . " - " . $modPasienMorbiditas->diagnosa->diagnosa_nama;
        }
        if ($modPasienMorbiditas->kelompokdiagnosa_id == Params::KELOMPOKDIAGNOSA_TAMBAH) {
          if ($key == 0) {
            $dataDiagnosa['diagnosautama'] .= ", <br>Diagnosa tambahan : " . $modPasienMorbiditas->diagnosa->diagnosa_kode . " - " . $modPasienMorbiditas->diagnosa->diagnosa_nama;
          } elseif ($key == 1) {
            $dataDiagnosa['diagnosautama'] .= ", <br>Diagnosa tambahan : " . $modPasienMorbiditas->diagnosa->diagnosa_kode . " - " . $modPasienMorbiditas->diagnosa->diagnosa_nama;
          } elseif ($key == 2) {
            $dataDiagnosa['diagnosautama'] .= ", <br>Diagnosa tambahan : " . $modPasienMorbiditas->diagnosa->diagnosa_kode . " - " . $modPasienMorbiditas->diagnosa->diagnosa_nama;
          }
        }
      }
    }

    if (isset($_POST['RKResumemedisR'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {

        $modResume = new RKResumemedisR;
        $modResume->attributes = $_POST['RKResumemedisR'];
        $modResume->pendaftaran_id = $_POST['pendaftaran_id'];
        $modResume->pasien_id = $_POST['pasien_id'];
        //				$modResume->pegawai_id = $_POST['pegawaipenanggung_id'];
        $modResume->pegawai_id = Yii::app()->user->getState('pegawai_id');
        $modResume->nodocmedis = MyGenerator::noDokMedis();
        $modResume->tglmasukrs = $format::FormatDateTimeForDb($_POST['tgl_pendaftaran']);
        $modResume->tglkeluarrs = $format::FormatDateTimeForDb($_POST['tglpasienpulang']);
        $modResume->tglresume = date('Y-m-d H:i:s');
        $modResume->ruanganterahkir_id = $_POST['ruangan_id'];
        $modResume->create_time = date('Y-m-d H:i:s');
        $modResume->create_loginpemakai_id = Yii::app()->user->id;
        $modResume->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $modResume->diagnosaawal_id = $_POST['diagnosaawal_id'];
        $modResume->diagnosautama_id = $_POST['diagnosautama_id'];
        $modResume->diagnosasekunder1_id = $_POST['diagnosasekunder1_id'];
        $modResume->diagnosasekunder2_id = $_POST['diagnosasekunder2_id'];
        $modResume->diagnosasekunder3_id = $_POST['diagnosasekunder3_id'];
        $modResume->status_resume = true;
        if ($modResume->save()) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data resume medis Pasien " . $modResume->pasien->nama_pasien . " berhasil disimpan !");
          if (isset($_GET['frame'])) {
            $this->redirect(array('index', 'pendaftaran_id' => $modResume->pendaftaran_id, 'sukses' => 1, 'frame' => true));
          } else {
            $this->redirect(array('index', 'pendaftaran_id' => $modResume->pendaftaran_id, 'sukses' => 1));
          }
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data resume medis gagal disimpan !");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data resume medis gagal disimpan !" . " " . MyExceptionMessage::getMessage($exc, true));
      }
    }



    $this->render($this->path_view . 'index', array(
      'modKunjungan' => $modKunjungan,
      'modResume' => $modResume,
      'dataDiagnosa' => $dataDiagnosa
    ));
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
      $no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
      $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
      $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
      if (!empty($this->carabayar_id)) {
        $criteria->addCondition('carabayar_id = ' . $this->carabayar_id);
      }
      $criteria->order = 'no_pendaftaran, no_rekam_medik, nama_pasien';
      $models = RKInfopasienpengunjungV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }

        $returnVal[$i]['label'] = $model->no_pendaftaran . ' - ' . $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
        $returnVal[$i]['value'] = $model->no_pendaftaran;
        $returnVal[$i]['pasienadmisi_id'] = isset($model->pasienadmisi_id) ? $model->pasienadmisi_id : '';
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * Mengurai data kunjungan berdasarkan:
   * - pendaftaran_id
   * @throws CHttpException
   */
  public function actionGetDataKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $returnVal['pesan'] = "";
      $criteria = new CDbCriteria();
      $model = $this->loadModPasienPengunjung($_POST['pendaftaran_id']);
      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
      $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
      $returnVal["tglpasienpulang"] = (($model->tglpasienpulang) ? $format->formatDateTimeForUser($model->tglpasienpulang) : $format->formatDateTimeForUser($model->tgl_pendaftaran));
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * @param type $pendaftaran_id
   * @return RKInfopasienpengunjungV
   */
  public function loadModPasienPengunjung($pendaftaran_id)
  {
    $criteria = new CDbCriteria;
    $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
    $model = RKInfopasienpengunjungV::model()->find($criteria);
    if (!empty($model)) {
      $pegawai = PegawaiM::model()->findByPk($model->dokterpenanggungjawab_id);
      $model->dokterpenanggungjawab_nama = $pegawai->namaLengkap;
    }
    return $model;
  }

  /**
   * Mengurai data resume berdasarkan:
   * - pendaftaran_id
   * @throws CHttpException
   */
  public function actionGetDataIkhisar()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['pesan'] = "";
      $data['ikhtisar'] = "";
      $data['tekanandarah'] = "";
      // validasi data tabel anamnesa_t
      $criteria = new CDbCriteria;
      $criteria->addCondition("pendaftaran_id = " . $_POST['pendaftaran_id']);
      $criteria->order = "anamesa_id DESC";
      $model = AnamnesaT::model()->find($criteria);

      if ((!empty($model->riwayatpenyakitterdahulu)) && (!empty($model->keluhanutama))) { // jika keluhan utama ada dan riwayat penyakit ada 
        $data['ikhtisar'] .= "Keluhan utama " . $model->keluhanutama . " dan memiliki riwayat penyakit " . $model->riwayatpenyakitterdahulu;
      } elseif ((!empty($model->keluhanutama)) && (empty($model->riwayatpenyakitterdahulu))) { // jika keluhan utama ada dan riwayat penyakit tidak ada
        $data['ikhtisar'] .= "Keluhan utama " . $model->keluhanutama;
      } elseif ((!empty($model->riwayatpenyakitterdahulu)) && (empty($model->keluhanutama))) { // jika keluhan utama tidak ada dan riwayat penyakit ada
        $data['ikhtisar'] .= "Memiliki riwayat penyakit " . $model->riwayatpenyakitterdahulu;
      } else {
        $data['ikhtisar'] .= ""; //jika keluhan utama dan riwayat penyakit tidak ada
      }

      // validasi data tabel pemeriksaanfisik_t
      $criteria = new CDbCriteria;
      $criteria->addCondition("pendaftaran_id = " . $_POST['pendaftaran_id']);
      $criteria->order = "pemeriksaanfisik_id DESC";
      $modPemeriksaan = PemeriksaanfisikT::model()->find($criteria);

      if (!empty($modPemeriksaan)) {
        if ((!empty($modPemeriksaan->beratbadan_kg)) && ($modPemeriksaan->tekanandarah != '000 / 000')) { // jika Tekanan darah ada dan berat badan ada 
          $data['tekanandarah'] .= "Tekanan darah " . $modPemeriksaan->tekanandarah . " dan berat badan " . $modPemeriksaan->beratbadan_kg . " kg";
        } elseif (($modPemeriksaan->tekanandarah != '000 / 000') && (empty($modPemeriksaan->beratbadan_kg))) { // jika Tekanan darah ada dan berat badan tidak ada
          $data['tekanandarah'] .= "Tekanan darah " . $modPemeriksaan->tekanandarah;
        } elseif ((!empty($modPemeriksaan->beratbadan_kg)) && ($modPemeriksaan->tekanandarah = '000 / 000')) { // jika Tekanan darah tidak ada dan berat badan ada
          $data['tekanandarah'] .= "Berat badan " . $modPemeriksaan->beratbadan_kg . " kg";
        } else {
          $data['tekanandarah'] .= ""; //jika Tekanan darah dan berat badan tidak ada
        }
      }

      // validasi kombinasi antara tabel anamnesa_t dengan pemeriksaanfisik_t
      if ((!empty($data['ikhtisar'])) && (!empty($data['tekanandarah']))) { // Jika isi tabel anamnesa_t ada dan isi tabel pemeriksaanfisik_t ada
        $data['ikhtisar'] .= " dengan " . $data['tekanandarah'];
      } elseif ((empty($data['ikhtisar'])) && (!empty($data['tekanandarah']))) { // Jika isi tabel anamnesa_t tidak ada dan isi tabel pemeriksaanfisik_t ada
        $data['ikhtisar'] .= $data['tekanandarah'];
      }
      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  /**
   * Mengurai data resume berdasarkan:
   * - pendaftaran_id
   * @throws CHttpException
   */
  public function actionGetDataDiagnosisKelainan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['pesan'] = "";
      $data['fisik'] = "";
      $data['lab'] = "";
      $data['radiologi'] = "";
      // validasi data tabel pemeriksaanfisik_t
      $criteria = new CDbCriteria;
      $criteria->addCondition("pendaftaran_id = " . $_POST['pendaftaran_id']);
      $criteria->order = "pemeriksaanfisik_id DESC";
      $modPemeriksaan = PemeriksaanfisikT::model()->findAll($criteria);

      // validasi data tabel pemeriksaanfisik_t untuk data kelainanpadabagtubuh
      foreach ($modPemeriksaan as $key => $val) {
        if (!empty($val->keadaanumum)) {
          $data['fisik'] .= "Keadaan umum: " . $val->keadaanumum . ", <br/>";
        }
        if (!empty($val->tekanandarah)) {
          $data['fisik'] .= "Tekanan Darah: " . $val->tekanandarah . " Mm/Hg, <br/>";
        }
        if (!empty($val->meanarteripressure)) {
          $data['fisik'] .= "Mean Arteri Pressure: " . $val->meanarteripressure . ", <br/>";
        }
        if (!empty($val->detaknadi)) {
          $data['fisik'] .= "Detak Nadi: " . $val->detaknadi . " /Menit, <br/>";
        }
        if (!empty($val->denyutjantung)) {
          $data['fisik'] .= "Detak Jantung: " . $val->denyutjantung . ", <br/>";
        }
        if (!empty($val->pernapasan)) {
          $data['fisik'] .= "Pernapasan: " . $val->pernapasan . " /Menit, <br/>";
        }
        if (!empty($val->suhutubuh)) {
          $data['fisik'] .= "Suhu Tubuh: " . $val->suhutubuh . " Celcius, <br/>";
        }
        if (!empty($val->tinggibadan_cm)) {
          $data['fisik'] .= "Tinggi Badan: " . $val->tinggibadan_cm . ", <br/>";
        }
        if (!empty($val->beratbadan_kg)) {
          $data['fisik'] .= "Berat Badan: " . $val->beratbadan_kg . ", <br/>";
        }
        if (!empty($val->kelainanpadabagtubuh)) {
          $data['fisik'] .= "Kelainan Pada Bag. Tubuh: " . $val->kelainanpadabagtubuh . ", <br/>";
        }
      }


      // validasi data tabel tindakanpelayanan_t untuk data laboratorium dan radiologi
      $data['lab'] = "";
      $modPasienPenunjang = RKPasienMasukPenunjangV::model()->findByAttributes(array('pendaftaran_id' => $_POST['pendaftaran_id']));
      if (!empty($modPasienPenunjang)) {
        $modHasilPemeriksaan = RKHasilpemeriksaanlabT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $modPasienPenunjang->pasienmasukpenunjang_id));
        $criteria = new CDbCriteria();
        $criteria->join = "
								JOIN pemeriksaanlab_m ON pemeriksaanlab_m.pemeriksaanlab_id = t.pemeriksaanlab_id 
								JOIN pemeriksaanlabdet_m ON pemeriksaanlabdet_m.pemeriksaanlabdet_id = t.pemeriksaanlabdet_id 
								JOIN nilairujukan_m ON nilairujukan_m.nilairujukan_id = pemeriksaanlabdet_m.nilairujukan_id";
        $criteria->addCondition('t.hasilpemeriksaanlab_id = ' . $modHasilPemeriksaan->hasilpemeriksaanlab_id);
        $criteria->order = "pemeriksaanlab_m.pemeriksaanlab_urutan ASC, pemeriksaanlabdet_m.pemeriksaanlabdet_nourut ASC";
        $modDetailHasilPemeriksaanLabs = RKDetailhasilpemeriksaanlabT::model()->findAll($criteria);
        if (count((array)$modDetailHasilPemeriksaanLabs) > 0) {
          $data['lab'] .= "Pemeriksaan Lab :<br> ";
          foreach ($modDetailHasilPemeriksaanLabs as $key => $modDetailHasilPemeriksaan) {
            $data['lab'] .= "- " . $modDetailHasilPemeriksaan->pemeriksaandetail->nilairujukan->namapemeriksaandet . " = " . $modDetailHasilPemeriksaan->hasilpemeriksaan . "<br>";
          }
        }
      }
      $modPasienPenunjang = RKPasienMasukPenunjangV::model()->findByAttributes(array('pendaftaran_id' => $_POST['pendaftaran_id']), array('order' => 'pasienmasukpenunjang_id DESC'));
      if (!empty($modPasienPenunjang)) {
        $modDetailHasilPemeriksaanRads = HasilpemeriksaanradT::model()->findAllByAttributes(array('pasienmasukpenunjang_id' => $modPasienPenunjang->pasienmasukpenunjang_id), array('order' => 'pasienmasukpenunjang_id DESC'));
        if (count((array)$modDetailHasilPemeriksaanRads) > 0) {
          foreach ($modDetailHasilPemeriksaanRads as $key => $modDetailHasilPemeriksaanRad) {
            $data['radiologi'] .= "- " . $modDetailHasilPemeriksaanRad->pemeriksaanrad->pemeriksaanrad_nama . " = " . $modDetailHasilPemeriksaanRad->hasilexpertise . "<br>";
          }
        }
      }

      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  /**
   * Mengurai data resume berdasarkan:
   * - pendaftaran_id
   * @throws CHttpException
   */
  public function actionGetDataDiagnosisSementara()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['pesan'] = "";
      $data['diagnosaawal'] = "";
      $data['diagnosaid'] = "";
      $criteria = new CDbCriteria;
      $criteria->addCondition("pendaftaran_id = " . $_POST['pendaftaran_id']);
      $criteria->addCondition("kelompokdiagnosa_id = " . Params::KELOMPOKDIAGNOSA_MASUK);
      $modPasienMorbiditas = RKPasienMorbiditasT::model()->find($criteria);

      if (!empty($modPasienMorbiditas)) {
        $data['diagnosaawal'] .= "Diagnosa awal : " . $modPasienMorbiditas->diagnosa->diagnosa_kode . " - " . $modPasienMorbiditas->diagnosa->diagnosa_nama;
        $data['diagnosaid'] .= $modPasienMorbiditas->diagnosa_id;
      } else {
        $data['diagnosaawal'] .= "";
      }
      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  /**
   * Mengurai data resume berdasarkan:
   * - pendaftaran_id
   * @throws CHttpException
   */
  public function actionGetDataDiagnosisAkhir()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $data['pesan'] = "";
      $data['diagnosautama'] = "";
      $data['diagnosautamaid'] = "";
      $data['diagnosasekunder1'] = "";
      $data['diagnosasekunder2'] = "";
      $data['diagnosasekunder3'] = "";
      $data['diagnosasekunderid1'] = "";
      $data['diagnosasekunderid2'] = "";
      $data['diagnosasekunderid3'] = "";

      $criteria = new CDbCriteria;
      $criteria->addCondition("pendaftaran_id = " . $_POST['pendaftaran_id']);
      $criteria->addInCondition(
        'kelompokdiagnosa_id',
        array(
          Params::KELOMPOKDIAGNOSA_UTAMA,
          Params::KELOMPOKDIAGNOSA_TAMBAH
        )
      );
      $modPasienMorbiditass = RKPasienMorbiditasT::model()->findAll($criteria);
      if (count((array)$modPasienMorbiditass) > 0) {
        foreach ($modPasienMorbiditass as $key => $modPasienMorbiditas) {
          if ($modPasienMorbiditas->kelompokdiagnosa_id == Params::KELOMPOKDIAGNOSA_UTAMA) {
            $data['diagnosautama'] .= "Diagnosa utama : " . $modPasienMorbiditas->diagnosa->diagnosa_kode . " - " . $modPasienMorbiditas->diagnosa->diagnosa_nama;
            $data['diagnosautamaid'] = $modPasienMorbiditas->diagnosa_id;
          }
          if ($modPasienMorbiditas->kelompokdiagnosa_id == Params::KELOMPOKDIAGNOSA_TAMBAH) {
            if ($key == 0) {
              $data['diagnosautama'] .= ", <br>Diagnosa tambahan : " . $modPasienMorbiditas->diagnosa->diagnosa_kode . " - " . $modPasienMorbiditas->diagnosa->diagnosa_nama;
              $data['diagnosasekunderid1'] = $modPasienMorbiditas->diagnosa_id;
            } elseif ($key == 1) {
              $data['diagnosautama'] .= ", <br>Diagnosa tambahan : " . $modPasienMorbiditas->diagnosa->diagnosa_kode . " - " . $modPasienMorbiditas->diagnosa->diagnosa_nama;
              $data['diagnosasekunderid2'] = $modPasienMorbiditas->diagnosa_id;
            } elseif ($key == 2) {
              $data['diagnosautama'] .= ", <br>Diagnosa tambahan : " . $modPasienMorbiditas->diagnosa->diagnosa_kode . " - " . $modPasienMorbiditas->diagnosa->diagnosa_nama;
              $data['diagnosasekunderid3'] = $modPasienMorbiditas->diagnosa_id;
            }
          }
        }
      } else {
        $data['diagnosautama'] .= "";
        $data['diagnosasekunder1'] .= "";
        $data['diagnosasekunder2'] .= "";
        $data['diagnosasekunder3'] .= "";
      }
      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }


  /**
   * Mengurai data resume berdasarkan:
   * - pendaftaran_id
   * @throws CHttpException
   */
  public function actionGetDataObatSementara()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['pesan'] = "";
      $data['terapiperawatan'] = "";
      // validasi data tabel penjualanresep_t
      $criteria = new CDbCriteria;
      $criteria->addCondition("pendaftaran_id = " . $_POST['pendaftaran_id']);
      $criteria->addCondition("isresepperawatan IS TRUE");
      $modResepp = RKPenjualanresepT::model()->findAll($criteria);

      if (count((array)$modResepp) > 0) {
        foreach ($modResepp as $key => $modResep) {
          $cariObatAlkes = ObatalkespasienT::model()->find('penjualanresep_id =' . $modResep->penjualanresep_id);
          $data['terapiperawatan'] .= $cariObatAlkes->obatalkes->obatalkes_nama . ", ";
        }
      } else {
        $data['terapiperawatan'] .= "";
      }
      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  /**
   * Mengurai data resume berdasarkan:
   * - pendaftaran_id
   * @throws CHttpException
   */
  public function actionGetDataObatPulang()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['pesan'] = "";
      $data['terapisaatpulang'] = "";
      // validasi data tabel penjualanresep_t
      $criteria = new CDbCriteria;
      $criteria->addCondition("pendaftaran_id = " . $_POST['pendaftaran_id']);
      $criteria->addCondition("isresepperawatan IS FALSE");
      $modResepp = RKPenjualanresepT::model()->findAll($criteria);

      if (count((array)$modResepp) > 0) {
        foreach ($modResepp as $key => $modResep) {
          $cariObatAlkes = ObatalkespasienT::model()->find('penjualanresep_id =' . $modResep->penjualanresep_id);
          $data['terapisaatpulang'] .= $cariObatAlkes->obatalkes->obatalkes_nama . ", ";
        }
      } else {
        $data['terapisaatpulang'] .= "";
      }
      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  /**
   * Mengurai data riwayat pasien berdasarkan:
   * - pendaftaran_id
   * @throws CHttpException
   */
  public function actionGetDataRiwayatOperasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['pesan'] = "";
      $data['riwayatoperasi'] = "";

      $criteria = new CDbCriteria;
      $criteria->select = 'd.daftartindakan_nama';
      $criteria->group = $criteria->select;
      $criteria->addCondition("t.pendaftaran_id = " . $_POST['pendaftaran_id']);
      $criteria->join = " JOIN daftartindakan_m AS d ON d.daftartindakan_id = t.daftartindakan_id ";
      $criteria->addCondition(" d.daftartindakan_nama ILIKE '%operasi%' ");
      $modOperasi = RKTindakanpelayananT::model()->findAll($criteria);

      if (count((array)$modOperasi) > 0) {
        foreach ($modOperasi as $key => $val) {
          $data['riwayatoperasi'] .= $val->daftartindakan_nama . ", ";
        }
      } else {
        $data['riwayatoperasi'] .= "";
      }
      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  /**
   * Mengurai data carakeluar pasien berdasarkan:
   * - pendaftaran_id
   * @throws CHttpException
   */
  public function actionGetDataCaraKeluar()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['pesan'] = "";
      $data['carakeluar'] = "";

      $criteria = new CDbCriteria;
      $criteria->select = 'c.carakeluar_nama, t.pasienpulang_id';
      $criteria->group = 'c.carakeluar_nama, t.pasienpulang_id';
      $criteria->addCondition("t.pendaftaran_id = " . $_POST['pendaftaran_id']);
      $criteria->join = " JOIN carakeluar_m AS c ON c.carakeluar_id = t.carakeluar_id ";
      $criteria->order = "t.pasienpulang_id desc";
      $criteria->limit = 1;
      $modPulang = PasienpulangT::model()->findAll($criteria);

      if (count((array)$modPulang) > 0) {
        foreach ($modPulang as $key => $val) {
          $data['carakeluar'] .= $val->carakeluar_nama . ", ";
        }
      } else {
        $data['carakeluar'] .= "";
      }
      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  /**
   * Mengurai data kondisi pulang pasien berdasarkan:
   * - pendaftaran_id
   * @throws CHttpException
   */
  public function actionGetDataKondisiPulang()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['pesan'] = "";
      $data['kondisipulang'] = "";

      $criteria = new CDbCriteria;
      $criteria->select = 'k.kondisikeluar_nama, t.pasienpulang_id';
      $criteria->group = 'k.kondisikeluar_nama, t.pasienpulang_id';
      $criteria->addCondition("t.pendaftaran_id = " . $_POST['pendaftaran_id']);
      $criteria->join = " JOIN kondisikeluar_m AS k ON k.kondisikeluar_id = t.kondisikeluar_id ";
      $criteria->order = "t.pasienpulang_id desc";
      $criteria->limit = 1;
      $modPulang = PasienpulangT::model()->findAll($criteria);

      if (count((array)$modPulang) > 0) {
        foreach ($modPulang as $key => $val) {
          $data['kondisipulang'] .= $val->kondisikeluar_nama . ", ";
        }
      } else {
        $data['kondisipulang'] .= "";
      }
      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  /**
   * Mengurai data tindak lanjut pasien berdasarkan:
   * - pendaftaran_id
   * @throws CHttpException
   */
  public function actionGetDataTindakLanjut()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['pesan'] = "";
      $data['saran_resume'] = "";

      $criteria = new CDbCriteria;
      $criteria->select = 't.pasiendirujukkeluar_id, r.rumahsakitrujukan, r.alamatrsrujukan';
      $criteria->group = 't.pasiendirujukkeluar_id, r.rumahsakitrujukan, r.alamatrsrujukan';
      $criteria->addCondition("t.pendaftaran_id = " . $_POST['pendaftaran_id']);
      $criteria->join = " JOIN rujukankeluar_m AS r ON r.rujukankeluar_id = t.rujukankeluar_id ";
      $criteria->order = "t.pasiendirujukkeluar_id desc";
      $criteria->limit = 1;
      $modRujukan = PasiendirujukkeluarT::model()->findAll($criteria);

      if (count((array)$modRujukan) > 0) {
        foreach ($modRujukan as $key => $val) {
          $data['saran_resume'] .= 'Dirujuk ke ' . $val->rumahsakitrujukan . ", " . $val->alamatrsrujukan;
        }
      } else {
        $data['saran_resume'] .= "";
      }
      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  public function actionPrint($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modKunjungan = RKInfopasienpengunjungV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modResume = RKResumemedisR::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'resumemedis_id DESC'));
    $modDiagnosaAwal = RKDiagnosaM::model()->findByAttributes(array('diagnosa_id' => $modResume->diagnosaawal_id));


    $dataDiagnosa['diagnosautama'] = '';
    //load diagnosa akhir
    $criteria = new CDbCriteria;
    $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
    $criteria->addInCondition(
      'kelompokdiagnosa_id',
      array(
        Params::KELOMPOKDIAGNOSA_UTAMA,
        Params::KELOMPOKDIAGNOSA_TAMBAH
      )
    );
    $modPasienMorbiditass = RKPasienMorbiditasT::model()->findAll($criteria);
    foreach ($modPasienMorbiditass as $key => $modPasienMorbiditas) {
      if ($modPasienMorbiditas->kelompokdiagnosa_id == Params::KELOMPOKDIAGNOSA_UTAMA) {
        $dataDiagnosa['diagnosautama'] .= "Diagnosa utama : " . $modPasienMorbiditas->diagnosa->diagnosa_kode . " - " . $modPasienMorbiditas->diagnosa->diagnosa_nama;
      }
      if ($modPasienMorbiditas->kelompokdiagnosa_id == Params::KELOMPOKDIAGNOSA_TAMBAH) {
        if ($key == 0) {
          $dataDiagnosa['diagnosautama'] .= ", <br>Diagnosa tambahan : " . $modPasienMorbiditas->diagnosa->diagnosa_kode . " - " . $modPasienMorbiditas->diagnosa->diagnosa_nama;
        } elseif ($key == 1) {
          $dataDiagnosa['diagnosautama'] .= ", <br>Diagnosa tambahan : " . $modPasienMorbiditas->diagnosa->diagnosa_kode . " - " . $modPasienMorbiditas->diagnosa->diagnosa_nama;
        } elseif ($key == 2) {
          $dataDiagnosa['diagnosautama'] .= ", <br>Diagnosa tambahan : " . $modPasienMorbiditas->diagnosa->diagnosa_kode . " - " . $modPasienMorbiditas->diagnosa->diagnosa_nama;
        }
      }
    }

    $judul_print = 'RESUME ( Ringkasan Pasien Keluar )';
    $this->render($this->path_view . 'print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modKunjungan' => $modKunjungan,
      'modResume' => $modResume,
      'modDiagnosaAwal' => $modDiagnosaAwal,
      'dataDiagnosa' => $dataDiagnosa,
    ));
  }

  public function actionPrintResumePasien($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modResume = RKResumemedisR::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'resumemedis_id DESC'));
    $modKunjungan = RKInfopasienpengunjungV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modAnamnesa = RKAnamnesaT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'anamesa_id DESC'));
    $modPeriksaFisik = PemeriksaanfisikT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'pemeriksaanfisik_id DESC'));
    $modKosul = KonsulpoliT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'konsulpoli_id DESC'));
    $modPenunjangLab = RKPasienMasukPenunjangV::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'instalasi_id' => Params::INSTALASI_ID_LAB));
    $modPenunjangRad = RKPasienMasukPenunjangV::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'instalasi_id' => Params::INSTALASI_ID_RAD));
    $arrayLab = array();
    $arrayRad = array();
    if (count((array)$modPenunjangLab) > 0) {
      foreach ($modPenunjangLab as $value) {
        $arrayLab[] = $value->pasienmasukpenunjang_id;
      }
    }
    if (count((array)$modPenunjangRad) > 0) {
      foreach ($modPenunjangRad as $value) {
        $arrayRad[] = $value->pasienmasukpenunjang_id;
      }
    }
    $criteriaLab = new CDbCriteria;
    $criteriaLab->addInCondition('pasienmasukpenunjang_id', $arrayLab);
    $modTindakanLab = RKTindakanpelayananT::model()->findAll($criteriaLab);
    $criteriaRad = new CDbCriteria;
    $criteriaRad->addInCondition('pasienmasukpenunjang_id', $arrayRad);
    $modTindakanRad = RKTindakanpelayananT::model()->findAll($criteriaRad);
    $modDiadnosaUtama = RKPasienMorbiditasT::model()->findByAttributes(array('diagnosaicdix_id' => null, 'pendaftaran_id' => $pendaftaran_id, 'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA), array('order' => 'pasienmorbiditas_id DESC'));
    $modDiadnosaTambahan = RKPasienMorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_TAMBAH), array('order' => 'pasienmorbiditas_id DESC'));
    $pasienmorbiditas_id = isset($modDiadnosaUtama->pasienmorbiditas_id) ? $modDiadnosaUtama->pasienmorbiditas_id : null;
    $modDiadnosaTindakan = Pasienicd9cmT::model()->findAllByAttributes(array('pasienmorbiditas_id' => $pasienmorbiditas_id), array('order' => 'pasienmorbiditas_id DESC'));

    $judul_print = 'RESUME MEDIS';

    $this->render($this->path_view . 'print_1', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modKunjungan' => $modKunjungan,
      'modAnamnesa' => $modAnamnesa,
      'modPeriksaFisik' => $modPeriksaFisik,
      'modKosul' => $modKosul,
      'modTindakanLab' => $modTindakanLab,
      'modTindakanRad' => $modTindakanRad,
      'modDiadnosaUtama' => $modDiadnosaUtama,
      'modDiadnosaTambahan' => $modDiadnosaTambahan,
      'modDiadnosaTindakan' => $modDiadnosaTindakan,
      'modResume' => $modResume,
    ));
  }
}
