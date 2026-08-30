<?php
class ResumeKeperawatanController extends MyAuthController
{
  public $path_view = "rawatInap.views.resumeKeperawatan.";

  public function actionIndex($pendaftaran_id = null)
  {
    $format = new MyFormatter();
    $modKunjungan = new RIInfokunjunganriV;
    $modResumeKeperawatan = new RIResumeperawatR;
    $modPegawai = new RIPegawaiM;
    $modPasienMasukKamar = new RIInfopasienmasukkamarV();
    if (isset($_GET['pendaftaran_id'])) {
      $modResumeKeperawatan = RIResumeperawatR::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));
      $modKunjungan = RIInfokunjunganriV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));
      $modPegawai = RIPegawaiM::model()->findByPk($modKunjungan->pasien->pegawai_id);
      if (!empty($modPegawai)) {
        RIPegawaiM::model()->findByPk($modKunjungan->pasien->pegawai_id);
      } else {
        $modPegawai = new RIPegawaiM;
      }
      $modPasienMasukKamar = RIInfopasienmasukkamarV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));
      $modResumeKeperawatan->diagnosaawal_nama =    !empty($modResumeKeperawatan->diagnosaawal_id) ? $modResumeKeperawatan->diagnosaawal->diagnosa_kode . ' - ' . $modResumeKeperawatan->diagnosaawal->diagnosa_nama : null;
      $modResumeKeperawatan->diagnosautama_nama =    !empty($modResumeKeperawatan->diagnosautama_id) ? $modResumeKeperawatan->diagnosautama->diagnosa_kode . ' - ' . $modResumeKeperawatan->diagnosautama->diagnosa_nama : null;
      $modResumeKeperawatan->diagnosasekunder1_nama =  !empty($modResumeKeperawatan->diagnosasekunder1_id) ? $modResumeKeperawatan->diagnosasekunder1->diagnosa_kode . ' - ' . $modResumeKeperawatan->diagnosasekunder1->diagnosa_nama : null;
      $modResumeKeperawatan->diagnosasekunder2_nama =  !empty($modResumeKeperawatan->diagnosasekunder2_id) ? $modResumeKeperawatan->diagnosasekunder2->diagnosa_kode . ' - ' . $modResumeKeperawatan->diagnosasekunder2->diagnosa_nama : null;
      $modResumeKeperawatan->diagnosasekunder3_nama =  !empty($modResumeKeperawatan->diagnosasekunder3_id) ? $modResumeKeperawatan->diagnosasekunder3->diagnosa_kode . ' - ' . $modResumeKeperawatan->diagnosasekunder3->diagnosa_nama : null;
    }

    if (isset($_POST['RIResumeperawatR'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        if (empty($_POST['resumeperawat_id'])) {
          $modResumeKeperawatan = new RIResumeperawatR;
          $modResumeKeperawatan->attributes = $_POST['RIResumeperawatR'];
          $modResumeKeperawatan->pendaftaran_id = $_POST['pendaftaran_id'];
          $modResumeKeperawatan->pasien_id = $_POST['pasien_id'];
          $modResumeKeperawatan->pegawai_id = $_POST['pegawai_id'];
          $modResumeKeperawatan->perawatbidan_id = Yii::app()->user->id;
          $modResumeKeperawatan->nodocresperwt = MyGenerator::noDokResPerwt();
          $modResumeKeperawatan->tglmasukrs = $format::FormatDateTimeForDb($_POST['tglmasukrs']);
          $modResumeKeperawatan->tglkeluarrs = $format::FormatDateTimeForDb($_POST['tglkeluarrs']);
          $modResumeKeperawatan->tglreseumperwt = date('Y-m-d H:i:s');
          $modResumeKeperawatan->tglkontrol = $format->formatDateTimeForDb($modResumeKeperawatan->tglkontrol);
          $modResumeKeperawatan->ruanganakhir_id = $_POST['ruanganakhir_id'];
          $modResumeKeperawatan->create_time = date('Y-m-d H:i:s');
          $modResumeKeperawatan->create_loginpemakai_id = Yii::app()->user->id;
          $modResumeKeperawatan->create_ruangan = Yii::app()->user->getState('ruangan_id');
          $modResumeKeperawatan->diagnosaawal_id = $_POST['diagnosaawal_id'];
          $modResumeKeperawatan->diagnosautama_id = $_POST['diagnosautama_id'];
          $modResumeKeperawatan->diagnosasekunder1_id = $_POST['diagnosasekunder1_id'];
          $modResumeKeperawatan->diagnosasekunder2_id = $_POST['diagnosasekunder2_id'];
          $modResumeKeperawatan->diagnosasekunder3_id = $_POST['diagnosasekunder3_id'];
          $modResumeKeperawatan->kelaspelayanan_id = $_POST['kelaspelayanan_id'];
          $modResumeKeperawatan->suhu_saatkeluar = $_POST['suhu_saatkeluar'];
          $modResumeKeperawatan->nadi_saatkeluar = $_POST['nadi_saatkeluar'];
          $modResumeKeperawatan->tensi_saatkeluar = $_POST['tensi_saatkeluar'];
          $modResumeKeperawatan->nafas_saatkeluar = $_POST['nafas_saatkeluar'];
          if ($modResumeKeperawatan->save()) {
            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data resume keperawatan berhasil disimpan !");
            $this->redirect(array('index', 'pendaftaran_id' => $modResumeKeperawatan->pendaftaran_id, 'sukses' => 1));
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data resume keperawatan gagal disimpan !");
          }
        } else {
          $modResumeKeperawatan = RIResumeperawatR::model()->findByPk($_POST['resumeperawat_id']);
          $modResumeKeperawatan->attributes = $_POST['RIResumeperawatR'];
          $modResumeKeperawatan->pendaftaran_id = $_POST['pendaftaran_id'];
          $modResumeKeperawatan->pasien_id = $_POST['pasien_id'];
          $modResumeKeperawatan->pegawai_id = $_POST['pegawai_id'];
          $modResumeKeperawatan->perawatbidan_id = Yii::app()->user->id;
          $modResumeKeperawatan->tglmasukrs = $format::FormatDateTimeForDb($_POST['tglmasukrs']);
          $modResumeKeperawatan->tglkeluarrs = $format::FormatDateTimeForDb($_POST['tglkeluarrs']);
          $modResumeKeperawatan->tglreseumperwt = date('Y-m-d H:i:s');
          $modResumeKeperawatan->tglkontrol = date('Y-m-d H:i:s');
          $modResumeKeperawatan->ruanganakhir_id = $_POST['ruanganakhir_id'];
          $modResumeKeperawatan->update_time = date('Y-m-d H:i:s');
          $modResumeKeperawatan->update_loginpemakai_id = Yii::app()->user->id;
          $modResumeKeperawatan->create_ruangan = Yii::app()->user->getState('ruangan_id');
          $modResumeKeperawatan->diagnosaawal_id = $_POST['diagnosaawal_id'];
          $modResumeKeperawatan->diagnosautama_id = $_POST['diagnosautama_id'];
          $modResumeKeperawatan->diagnosasekunder1_id = $_POST['diagnosasekunder1_id'];
          $modResumeKeperawatan->diagnosasekunder2_id = $_POST['diagnosasekunder2_id'];
          $modResumeKeperawatan->diagnosasekunder3_id = $_POST['diagnosasekunder3_id'];
          $modResumeKeperawatan->kelaspelayanan_id = $_POST['kelaspelayanan_id'];
          $modResumeKeperawatan->suhu_saatkeluar = $_POST['suhu_saatkeluar'];
          $modResumeKeperawatan->nadi_saatkeluar = $_POST['nadi_saatkeluar'];
          $modResumeKeperawatan->tensi_saatkeluar = $_POST['tensi_saatkeluar'];
          $modResumeKeperawatan->nafas_saatkeluar = $_POST['nafas_saatkeluar'];
          if ($modResumeKeperawatan->validate()) {
            $modResumeKeperawatan->update();
            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data resume keperawatan berhasil disimpan !");
            $this->redirect(array('index', 'pendaftaran_id' => $modResumeKeperawatan->pendaftaran_id, 'sukses' => 1));
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data resume keperawatan gagal disimpan !");
          }
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data resume keperawatan gagal disimpan !" . " " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render($this->path_view . 'index', array(
      'modKunjungan' => $modKunjungan,
      'modResumeKeperawatan' => $modResumeKeperawatan,
      'modPegawai' => $modPegawai,
      'modPasienMasukKamar' => $modPasienMasukKamar
    ));
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
      $modPasienMasukKamar = RIInfopasienmasukkamarV::model()->findByAttributes(array('pasien_id' => $model->pasien_id));
      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      if (!empty($model->pasien->pegawai_id)) {
        $returnVal['nomorindukpegawai'] = $model->pasien->pegawai->nomorindukpegawai;
      }

      $returnVal["tglmasukkamar"] = !empty($modPasienMasukKamar->tglmasukkamar) ? $modPasienMasukKamar->tglmasukkamar : '';
      $returnVal["tglpulang"] = !empty($modPasienMasukKamar->tglpulang) ? $modPasienMasukKamar->tglpulang : '';
      $returnVal["kelaspelayanan_nama"] = !empty($modPasienMasukKamar->kelaspelayanan_nama) ? $modPasienMasukKamar->kelaspelayanan_nama : '';
      $returnVal["kamarruangan_nokamar"] = !empty($modPasienMasukKamar->kamarruangan_nokamar) ? $modPasienMasukKamar->kamarruangan_nokamar : '';

      $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
      $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * @param type $pendaftaran_id
   * @return RIInfokunjunganriV
   */
  public function loadModPasienPengunjung($pendaftaran_id)
  {
    $criteria = new CDbCriteria;
    $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
    $model = RIInfokunjunganriV::model()->find($criteria);
    return $model;
  }

  /**
   * untuk menampilkan data kunjungan dari autocomplete
   * - no_pendaftaran
   * - no_rekam_medik
   * - 
   */
  public function actionAutocompleteKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
      $no_badge = isset($_GET['nomorindukpegawai']) ? $_GET['nomorindukpegawai'] : null;

      if (empty($no_badge)) {
        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);

        $criteria->order = 'no_pendaftaran, no_rekam_medik, nama_pasien';
        $models = RIInfokunjunganriV::model()->findAll($criteria);
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }

          $returnVal[$i]['label'] = $model->no_pendaftaran . ' - ' . $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
          $returnVal[$i]['value'] = $model->no_pendaftaran;
          $returnVal[$i]['pasienadmisi_id'] = isset($model->pasienadmisi_id) ? $model->pasienadmisi_id : '';
        }
      } else {
        $criteria = new CDbCriteria;
        $criteria->join = "JOIN pasien_m ON t.pasien_id = pasien_m.pasien_id
									JOIN pegawai_m ON pasien_m.pegawai_id = pegawai_m.pegawai_id
									";
        $criteria->compare('LOWER(pegawai_m.nomorindukpegawai)',  strtolower($no_badge), true);
        $criteria->order = 't.no_pendaftaran';
        $models = RIInfokunjunganriV::model()->findAll($criteria);
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }

          $returnVal[$i]['label'] = $model->pasien->pegawai->nomorindukpegawai .
            ' - ' . $model->no_rekam_medik .
            ' - ' . $model->nama_pasien .
            ' - (' . $model->pasien->pegawai->nama_pegawai .
            ') - ' . $format->formatDateTimeForUser($model->tanggal_lahir);
          $returnVal[$i]['value'] = $model->no_rekam_medik;
        }
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   *	This function made for LNG Project Only
   * - Get resume keperawatan rawat inap
   * - pendaftaran_id
   * - LNG-304
   */
  public function actionGetDataResumeKeperawatan()
  {
    if (Yii::app()->request->isAjaxRequest) {

      // untuk mengisi data resume keperawatan pasien memerlukan kondisi 
      // (1. cek ke table resumeperawat_r jika ada pakai data itu)
      // (2. jika tidak ada ambil dari beberapa table yang telah ditentukan)

      $format = new MyFormatter();
      $returnVal = array();
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $modResumeKeperawatan = RIResumeperawatR::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
      $returnVal['status'] = '';
      $returnVal['keluhansaatmasuk'] = '';
      $returnVal['diagnosaawal_id'] = null;
      $returnVal['diagnosaawal_nama'] = '';
      $returnVal['diagnosautama_nama'] = '';
      $returnVal['diagnosasekunder1_nama'] = '';
      $returnVal['diagnosasekunder2_nama'] = '';
      $returnVal['diagnosasekunder3_nama'] = '';
      $returnVal['diagnosautama_id'] = null;
      $returnVal['diagnosasekunder1_id'] = null;
      $returnVal['diagnosasekunder2_id'] = null;
      $returnVal['diagnosasekunder3_id'] = null;
      $returnVal['diagkeprwtdiatasi'] = '';
      $returnVal['tindakankeprwatan'] = '';
      $returnVal['diagkeprwtblmteratasi'] = '';
      $returnVal['hasikperiksalab'] = '';
      $returnVal['hasilperiksarad'] = '';
      $returnVal['hasilperiksadiet'] = '';
      $returnVal['hasilperiksarehabmedis'] = '';
      $returnVal['hasilperiksalainlain'] = '';
      $returnVal['keadaanumumkeluar'] = '';
      $returnVal['suhu_saatkeluar'] = '';
      $returnVal['nadi_saatkeluar'] = '';
      $returnVal['tensi_saatkeluar'] = '';
      $returnVal['nafas_saatkeluar'] = '';
      $returnVal['terapilanjutan'] = '';
      $returnVal['nasehat_diit'] = '';
      $returnVal['nasehat_mobilisasi'] = '';
      $returnVal['nasehat_eliminasi'] = '';
      $returnVal['nasehat_kontrol'] = '';
      $returnVal['carakeluar'] = '';


      if (!empty($modResumeKeperawatan)) {
        $returnVal['status'] = 'ada';

        $attributes = $modResumeKeperawatan->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal["$attribute"] = $modResumeKeperawatan->$attribute;
        }
        $returnVal['diagnosaawal_nama'] =    !empty($modResumeKeperawatan->diagnosaawal_id) ? $modResumeKeperawatan->diagnosaawal->diagnosa_kode . ' - ' . $modResumeKeperawatan->diagnosaawal->diagnosa_nama : null;
        $returnVal['diagnosautama_nama'] =    !empty($modResumeKeperawatan->diagnosautama_id) ? $modResumeKeperawatan->diagnosautama->diagnosa_kode . ' - ' . $modResumeKeperawatan->diagnosautama->diagnosa_nama : null;
        $returnVal['diagnosasekunder1_nama'] =  !empty($modResumeKeperawatan->diagnosasekunder1_id) ? $modResumeKeperawatan->diagnosasekunder1->diagnosa_kode . ' - ' . $modResumeKeperawatan->diagnosasekunder1->diagnosa_nama : null;
        $returnVal['diagnosasekunder2_nama'] =  !empty($modResumeKeperawatan->diagnosasekunder2_id) ? $modResumeKeperawatan->diagnosasekunder2->diagnosa_kode . ' - ' . $modResumeKeperawatan->diagnosasekunder2->diagnosa_nama : null;
        $returnVal['diagnosasekunder3_nama'] =  !empty($modResumeKeperawatan->diagnosasekunder3_id) ? $modResumeKeperawatan->diagnosasekunder3->diagnosa_kode . ' - ' . $modResumeKeperawatan->diagnosasekunder3->diagnosa_nama : null;
      } else {
        $returnVal['status'] = 'tidakada';

        // keluhansaatmasuk
        $modAnamesa = AnamnesaT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        $returnVal['keluhansaatmasuk'] = !empty($modAnamesa->keluhanutama) ? $modAnamesa->keluhanutama : '';

        // diagnosa keperawatan awal
        $modPasienMorbiditasAwal = RIPasienMorbiditasT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_MASUK));
        if (!empty($modPasienMorbiditasAwal)) {
          $returnVal['diagnosaawal_nama'] = $modPasienMorbiditasAwal->diagnosa->diagnosa_kode . " - " . $modPasienMorbiditasAwal->diagnosa->diagnosa_nama;
          $returnVal['diagnosaawal_id'] = $modPasienMorbiditasAwal->diagnosa_id;
        }

        // diagnosa keperawatan utama
        $modPasienMorbiditasUtama = RIPasienMorbiditasT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA));
        if (!empty($modPasienMorbiditasUtama)) {
          $returnVal['diagnosautama_nama'] = $modPasienMorbiditasUtama->diagnosa->diagnosa_kode . " - " . $modPasienMorbiditasUtama->diagnosa->diagnosa_nama;
          $returnVal['diagnosautama_id'] = $modPasienMorbiditasUtama->diagnosa_id;
        }

        // diagnosa keperawatan tambahan
        $modPasienMorbiditasTambahans = RIPasienMorbiditasT::model()->findAllByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_TAMBAH));
        if (count((array)$modPasienMorbiditasTambahans) > 0) {
          foreach ($modPasienMorbiditasTambahans as $i => $modPasienMorbiditasTambahan) {
            if ($i == 0) {
              $returnVal['diagnosasekunder1_id'] = $modPasienMorbiditasTambahan->diagnosa_id;
              $returnVal['diagnosasekunder1_nama'] = $modPasienMorbiditasTambahan->diagnosa->diagnosa_kode . " - " . $modPasienMorbiditasTambahan->diagnosa->diagnosa_nama;
            } else if ($i == 1) {
              $returnVal['diagnosasekunder2_id'] = $modPasienMorbiditasTambahan->diagnosa_id;
              $returnVal['diagnosasekunder2_nama'] = $modPasienMorbiditasTambahan->diagnosa->diagnosa_kode . " - " . $modPasienMorbiditasTambahan->diagnosa->diagnosa_nama;
            } else if ($i == 2) {
              $returnVal['diagnosasekunder3_id'] = $modPasienMorbiditasTambahan->diagnosa_id;
              $returnVal['diagnosasekunder3_nama'] = $modPasienMorbiditasTambahan->diagnosa->diagnosa_kode . " - " . $modPasienMorbiditasTambahan->diagnosa->diagnosa_nama;
            }
          }
        }

        // hasil pemeriksaan lab 
        $criteria = new CDbCriteria;
        $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
        $criteria->select = 'daftartindakan_id';
        $criteria->group = 'daftartindakan_id';
        $criteria->addInCondition(
          'ruangan_id',
          array(
            Params::RUANGAN_ID_LAB_KLINIK,
            Params::RUANGAN_ID_LAB_ANATOMI,
            Params::RUANGAN_ID_LAB
          )
        );
        $modTindakanLabs = RITindakanPelayananT::model()->findAll($criteria);
        if (count((array)$modTindakanLabs) > 0) {
          $returnVal['hasikperiksalab'] .= '<ol>';
          foreach ($modTindakanLabs as $ii => $modTindakanLab) {
            $returnVal['hasikperiksalab'] .= '<li>';
            $returnVal['hasikperiksalab'] .= $modTindakanLab->daftartindakan->daftartindakan_nama;
            $returnVal['hasikperiksalab'] .= '</li>';
          }
          $returnVal['hasikperiksalab'] .= '</ol>';
        }

        // hasil pemeriksaan rad 
        $criteria = new CDbCriteria;
        $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
        $criteria->select = 'daftartindakan_id';
        $criteria->group = 'daftartindakan_id';
        $criteria->addInCondition('ruangan_id', array(Params::RUANGAN_ID_RAD));
        $modTindakanRads = RITindakanPelayananT::model()->findAll($criteria);
        if (count((array)$modTindakanRads) > 0) {
          $returnVal['hasilperiksarad'] .= '<ol>';
          foreach ($modTindakanRads as $ii => $modTindakanRad) {
            $returnVal['hasilperiksarad'] .= '<li>';
            $returnVal['hasilperiksarad'] .= $modTindakanRad->daftartindakan->daftartindakan_nama;
            $returnVal['hasilperiksarad'] .= '</li>';
          }
          $returnVal['hasilperiksarad'] .= '</ol>';
        }

        // tanda vital
        $modPemeriksaanFisik = RIPemeriksaanFisikT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id), array('order' => 'pemeriksaanfisik_id DESC'));
        if (!empty($modPemeriksaanFisik)) {
          $returnVal['suhu_saatkeluar'] = $modPemeriksaanFisik->suhutubuh;
          $returnVal['nadi_saatkeluar'] = $modPemeriksaanFisik->detaknadi;
          $returnVal['tensi_saatkeluar'] = $modPemeriksaanFisik->tekanandarah;
          $returnVal['nafas_saatkeluar'] = $modPemeriksaanFisik->pernapasan;
        }

        //obat lanjutan
        $criteria = new CDbCriteria;
        $criteria->addCondition("t.pendaftaran_id = " . $pendaftaran_id);
        $criteria->join = 'join obatalkespasien_t on obatalkespasien_t.penjualanresep_id = t.penjualanresep_id
									join obatalkes_m on obatalkespasien_t.obatalkes_id = obatalkes_m.obatalkes_id';
        $criteria->select = 'obatalkespasien_t.obatalkes_id, obatalkes_m.obatalkes_nama as obatalkes_nama';
        $criteria->group = 'obatalkespasien_t.obatalkes_id, obatalkes_m.obatalkes_nama';
        $modPenjualanReseps = RIPenjualanresepT::model()->findAll($criteria);

        if (count((array)$modPenjualanReseps) > 0) {
          $returnVal['terapilanjutan'] .= '<ol>';
          foreach ($modPenjualanReseps as $iii => $modPenjualanResep) {
            $returnVal['terapilanjutan'] .= '<li>';
            $returnVal['terapilanjutan'] .= $modPenjualanResep->obatalkes_nama;
            $returnVal['terapilanjutan'] .= '</li>';
          }
          $returnVal['terapilanjutan'] .= '</ol>';
        }

        //Cara keluar
        $modPasienPulang = RIPasienPulangT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
        if (!empty($modPasienPulang)) {
          $returnVal['carakeluar'] = $modPasienPulang->carakeluar->carakeluar_nama;
        }
      }

      //				echo"<pre>";
      //				print_r($returnVal);
      //				exit;

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }


  public function actionPrint($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modKunjungan = RIInfokunjunganriV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modResumeKeperawatan = RIResumeperawatR::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modPasienMasukKamar = RIInfopasienmasukkamarV::model()->findByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));
    $modResumeKeperawatan->diagnosaawal_nama =    !empty($modResumeKeperawatan->diagnosaawal_id) ? $modResumeKeperawatan->diagnosaawal->diagnosa_kode . ' - ' . $modResumeKeperawatan->diagnosaawal->diagnosa_nama : null;
    $modResumeKeperawatan->diagnosautama_nama =    !empty($modResumeKeperawatan->diagnosautama_id) ? $modResumeKeperawatan->diagnosautama->diagnosa_kode . ' - ' . $modResumeKeperawatan->diagnosautama->diagnosa_nama : null;
    $modResumeKeperawatan->diagnosasekunder1_nama =  !empty($modResumeKeperawatan->diagnosasekunder1_id) ? $modResumeKeperawatan->diagnosasekunder1->diagnosa_kode . ' - ' . $modResumeKeperawatan->diagnosasekunder1->diagnosa_nama : null;
    $modResumeKeperawatan->diagnosasekunder2_nama =  !empty($modResumeKeperawatan->diagnosasekunder2_id) ? $modResumeKeperawatan->diagnosasekunder2->diagnosa_kode . ' - ' . $modResumeKeperawatan->diagnosasekunder2->diagnosa_nama : null;
    $modResumeKeperawatan->diagnosasekunder3_nama =  !empty($modResumeKeperawatan->diagnosasekunder3_id) ? $modResumeKeperawatan->diagnosasekunder3->diagnosa_kode . ' - ' . $modResumeKeperawatan->diagnosasekunder3->diagnosa_nama : null;


    $judul_print = 'RESUME KEPERAWATAN';
    $this->render($this->path_view . 'print', array(
      'format' => $format,
      'judul_print' => $judul_print,
      'modKunjungan' => $modKunjungan,
      'modResumeKeperawatan' => $modResumeKeperawatan,
      'modPasienMasukKamar' => $modPasienMasukKamar,
    ));
  }
}
