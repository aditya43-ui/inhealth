<?php
Yii::import('rawatJalan.models.*');
class AnamnesaController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';
  public $simpananamnesa = false;
  public $simpanriwayatindividu = true; //loop
  public $simpanriwayatkeluarga = true; //loop
  public $simpanriwayatresikokerja = true; //loop
  public function actionIndex($pendaftaran_id)
  {
    $format = new MyFormatter();
    //            $this->layout='//layouts/iframe';
    $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);

    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);

    $dataPendaftaran = RJPendaftaranT::model()->findAllByAttributes(array('pasien_id' => $modPasien->pasien_id), array('order' => 'tgl_pendaftaran DESC'));

    $i = 1;
    if (count((array)$dataPendaftaran) > 1) {
      foreach ($dataPendaftaran as $row) {
        if ($i == 2) {
          $lastPendaftaran = $row->pendaftaran_id;
        }
        $i++;
      }
    } else {
      $lastPendaftaran = $pendaftaran_id;
    }


    $cekAnamnesa = RJAnamnesaT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modDiagnosa = new RJDiagnosaM;

    $modRiwayatIndividu = new MCRiwayatindividuR();
    $modRiwayatIndividu->pengobatan_tbc = 0;
    $modRiwayatIndividu->pengobatan_hepatitis = 0;
    $modRiwayatIndividu->asma = 0;
    $modRiwayatIndividu->radang_sendi = 0;
    $modRiwayatIndividu->serangan_jantung = 0;
    $modRiwayatIndividu->patah_tulang = 0;
    $modRiwayatIndividu->hemoroid = 0;
    $modRiwayatIndividu->hipertensi = 0;
    $modRiwayatIndividu->diabetes_melitus = 0;
    $modRiwayatIndividu->tyroid = 0;
    $modRiwayatIndividu->penyakit_ginjal = 0;
    $modRiwayatIndividu->saluran_kemih = 0;
    $modRiwayatIndividu->penyakit_stroke = 0;
    $modRiwayatIndividu->epilepsi = 0;
    $modRiwayatIndividu->thypus = 0;
    $modRiwayatIndividu->tranfusi_darah = 0;
    $modRiwayatIndividu->hiv = 0;
    $modRiwayatIndividu->kanker = 0;

    $modRiwayatKeluarga = new MCRiwayatkeluargaR();
    $modRiwayatKeluarga->darah_tinggi = 0;
    $modRiwayatKeluarga->kanker = 0;
    $modRiwayatKeluarga->asma = 0;
    $modRiwayatKeluarga->ambeien = 0;
    $modRiwayatKeluarga->jantung = 0;
    $modRiwayatKeluarga->tbc = 0;
    $modRiwayatKeluarga->stroke = 0;
    $modRiwayatKeluarga->diabetes_melitus = 0;
    $modRiwayatKeluarga->gangguan_jiwa = 0;
    $modRiwayatKeluarga->penyakit_kuning = 0;
    $modRiwayatKeluarga->kelainan_darah = 0;

    $modRiwayatResikoKerja = new MCRiwayatresikokerjaR();
    $modRiwayatResikoKerja->kebisingan = 0;
    $modRiwayatResikoKerja->suhu_panas = 0;
    $modRiwayatResikoKerja->kelembaban = 0;
    $modRiwayatResikoKerja->pencahayaan_kurang = 0;
    $modRiwayatResikoKerja->kesilauan = 0;
    $modRiwayatResikoKerja->getaran_padatangan = 0;
    $modRiwayatResikoKerja->getaran_seluruhbadan = 0;
    $modRiwayatResikoKerja->ventilasi_kurang = 0;
    $modRiwayatResikoKerja->radiasi_pengion = 0;
    $modRiwayatResikoKerja->radiasi_bukanpengion = 0;
    $modRiwayatResikoKerja->ketinggian = 0;
    $modRiwayatResikoKerja->bakteri = 0;
    $modRiwayatResikoKerja->darah_cairan = 0;
    $modRiwayatResikoKerja->nyamuk = 0;
    $modRiwayatResikoKerja->limbah = 0;
    $modRiwayatResikoKerja->asam = 0;
    $modRiwayatResikoKerja->basa = 0;
    $modRiwayatResikoKerja->pelarut_organik = 0;
    $modRiwayatResikoKerja->uap_logam = 0;
    $modRiwayatResikoKerja->gas = 0;
    $modRiwayatResikoKerja->pestisida = 0;
    $modRiwayatResikoKerja->debu = 0;
    $modRiwayatResikoKerja->posisi_kerja = 0;
    $modRiwayatResikoKerja->gerakan_repetitif = 0;
    $modRiwayatResikoKerja->berdiri_lama = 0;
    $modRiwayatResikoKerja->duduk_lama = 0;
    $modRiwayatResikoKerja->angkat_angkut = 0;
    $modRiwayatResikoKerja->bekerja_denganmotor = 0;
    $modRiwayatResikoKerja->stress_kerja = 0;
    $modRiwayatResikoKerja->kekerasan = 0;
    $modRiwayatResikoKerja->pelecehan = 0;
    $modRiwayatResikoKerja->ketidakjelasan_tugas = 0;
    $modRiwayatResikoKerja->konflik = 0;

    if (!empty($cekAnamnesa)) {  //Jika Pasien Sudah Melakukan Anamnesis Sebelumnya				
      $modAnamnesa = new RJAnamnesaT();

      $detTriase = (isset($_POST['RJTriase']) ? $_POST['RJTriase'] : null);
      if (isset($detTriase)) {
        if (count((array)$detTriase) > 0) {
          foreach ($detTriase as $i => $triase) {
            $modAnamnesa->triase_id = $triase['triase_id'];
          }
        }
      }

      $modAnamnesa = $cekAnamnesa;
      $pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
      $modAnamnesa->paramedis_nama = $pegawai->nama_pegawai;

      $modRiwayatIndividus = MCRiwayatindividuR::model()->findAllByAttributes(array('anamesa_id' => $modAnamnesa->anamesa_id), array('order' => 'riwayatindividu_id ASC'));
      $attrRiwayatIndividu = array(
        'pengobatan_tbc', 'pengobatan_hepatitis', 'asma', 'radang_sendi', 'serangan_jantung', 'patah_tulang', 'hemoroid', 'hipertensi',
        'diabetes_melitus', 'tyroid', 'penyakit_ginjal', 'saluran_kemih', 'penyakit_stroke', 'epilepsi', 'thypus', 'tranfusi_darah',
        'hiv', 'kanker', 'lainnya_label', 'lainnya', 'riwayat_kecelakankerja', 'riwayat_jenisoperasi'
      );
      if (count((array)$modRiwayatIndividus) <= 20) {
        unset($attrRiwayatIndividu[18]); // hapus element lainnya_label
        unset($attrRiwayatIndividu[19]); // hapus element lainnya
        $attrRiwayatIndividu = array_values($attrRiwayatIndividu); // re-index array

      }

      foreach ($modRiwayatIndividus as $i => $val) {
        if (($val->status_riwayatinidividu == 'Ya') || ($val->status_riwayatinidividu == 'Pernah')) {
          $modRiwayatIndividu[$attrRiwayatIndividu[$i]] = 1;
        } else {
          if (($attrRiwayatIndividu[$i] == 'riwayat_kecelakankerja') || ($attrRiwayatIndividu[$i] == 'riwayat_jenisoperasi')) {
            $modRiwayatIndividu[$attrRiwayatIndividu[$i]] = $val->status_riwayatinidividu;
          } else {
            $modRiwayatIndividu[$attrRiwayatIndividu[$i]] = 0;
          }
        }
      }
      if (count((array)$modRiwayatIndividus) > 20) { // jika ada data riwayat lainnya 
        $modRiwayatIndividu->lainnya_label = $modRiwayatIndividus[18]->nama_riwayat_individu;
        if ($modRiwayatIndividus[18]->status_riwayatinidividu == 'Ya') {
          $modRiwayatIndividu->lainnya = 1;
        } else {
          $modRiwayatIndividu->lainnya = 0;
        }
        $modRiwayatIndividu->riwayat_kecelakankerja = $modRiwayatIndividus[19]->status_riwayatinidividu;
        $modRiwayatIndividu->riwayat_jenisoperasi = $modRiwayatIndividus[20]->status_riwayatinidividu;
      }

      $modRiwayatKeluargas = MCRiwayatkeluargaR::model()->findAllByAttributes(array('anamesa_id' => $modAnamnesa->anamesa_id), array('order' => 'riwayatkeluarga_id ASC'));
      $attrRiwayatKeluarga = array('darah_tinggi', 'kanker', 'asma', 'ambeien', 'jantung', 'tbc', 'stroke', 'diabetes_melitus', 'gangguan_jiwa', 'penyakit_kuning', 'kelainan_darah', 'lainnya_label', 'lainnya');
      foreach ($modRiwayatKeluargas as $i => $val) {
        if ($val->status_riwayat_keluarga == 'Ada') {
          $modRiwayatKeluarga[$attrRiwayatKeluarga[$i]] = 1;
        } else {
          $modRiwayatKeluarga[$attrRiwayatKeluarga[$i]] = 0;
        }
      }

      if (count((array)$modRiwayatKeluargas) > 11) { // jika ada data riwayat keluarga lainnya 
        $modRiwayatKeluarga->lainnya_label = $modRiwayatKeluargas[11]->nama_riwayat_keluarga;
        if ($modRiwayatKeluargas[11]->status_riwayat_keluarga == 'Ada') {
          $modRiwayatKeluarga->lainnya = 1;
        } else {
          $modRiwayatKeluarga->lainnya = 0;
        }
      }


      $modRiwayatResikoKerjas = MCRiwayatresikokerjaR::model()->findAllByAttributes(array('anamesa_id' => $modAnamnesa->anamesa_id), array('order' => 'riwayatresikokerja_id ASC'));
      $attrRiwayatResikoKerja = array(
        'kebisingan', 'suhu_panas', 'kelembaban', 'pencahayaan_kurang', 'kesilauan', 'getaran_padatangan', 'getaran_seluruhbadan',
        'ventilasi_kurang', 'radiasi_pengion', 'radiasi_bukanpengion', 'ketinggian', 'bakteri', 'darah_cairan', 'nyamuk', 'limbah',
        'asam', 'basa', 'pelarut_organik', 'uap_logam', 'gas', 'pestisida', 'debu', 'posisi_kerja', 'gerakan_repetitif', 'berdiri_lama',
        'duduk_lama', 'angkat_angkut', 'bekerja_denganmotor', 'stress_kerja', 'kekerasan', 'pelecehan', 'ketidakjelasan_tugas', 'konflik'
      );
      foreach ($modRiwayatResikoKerjas as $i => $val) {
        if ($val->status_faktor_resiko == 'Ya') {
          $modRiwayatResikoKerja[$attrRiwayatResikoKerja[$i]] = 1;
        } else {
          $modRiwayatResikoKerja[$attrRiwayatResikoKerja[$i]] = 0;
        }
      }
    } else {
      $modAnamnesa = new RJAnamnesaT;
      $modAnamnesa->pegawai_id = $modPendaftaran->pegawai_id;
      $pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
      $modAnamnesa->paramedis_nama = $pegawai->nama_pegawai;
      $modAnamnesa->pendaftaran_id = $modPendaftaran->pendaftaran_id;
      $modAnamnesa->pasien_id = $modPendaftaran->pasien_id;
      $modAnamnesa->tglanamnesis = date('Y-m-d H:i:s');
      $modAnamnesa->update_loginpemakai_id = Yii::app()->user->id;
      $modAnamnesa->create_time = date('Y-m-d H:i:s');
      $modAnamnesa->statusmerokok = 0;
      $modAnamnesa->keb_olahraga = 0;
      $modAnamnesa->keb_konsumsialkohol = 0;
      $modAnamnesa->keb_minumkopi = 0;
      $modAnamnesa->keb_konsumsidrug = 0;
    }


    if ($modPendaftaran->statuspasien == "PENGUNJUNG LAMA") {
      $modDiagnosaTerdahulu = RJPasienMorbiditasT::model()->with('diagnosa')->findAllByAttributes(array('pasien_id' => $modPasien->pasien_id, 'pendaftaran_id' => $lastPendaftaran));

      $hasilImunisasi = array();
      $hasilDiagnosaDahulu = array();
      foreach ($modDiagnosaTerdahulu as $row) {
        if ($row->diagnosa->diagnosa_imunisasi == true)
          $hasilImunisasi[] = (isset($row->diagnosa->diagnosa_nama) ? $row->diagnosa->diagnosa_nama : "");
        else
          $hasilDiagnosaDahulu[] = (isset($row->diagnosa->diagnosa_nama) ? $row->diagnosa->diagnosa_nama : "");
      }
      if (empty($modAnamnesa->riwayatimunisais)) {
        $modAnamnesa->riwayatimunisasi = implode(', ', $hasilImunisasi);
      }
      if (empty($modAnamnesa->riwayatpenyakitterdahulu)) {
        $modAnamnesa->riwayatpenyakitterdahulu = implode(', ', $hasilDiagnosaDahulu);
      }
    }




    //echo $modAnamnesa->riwayatpenyakitterdahulu;exit();
    if (isset($_POST['RJAnamnesaT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $detTriase = (isset($_POST['RJTriase']) ? $_POST['RJTriase'] : null);
        $modAnamnesa->attributes = $_POST['RJAnamnesaT'];
        if (isset($detTriase)) {
          if (count((array)$detTriase) > 0) {
            foreach ($detTriase as $i => $triase) {
              $modAnamnesa->triase_id = $triase['triase_id'];
            }
          }
        }
        $modAnamnesa->tglanamnesis = $format->formatDateTimeForDb($modAnamnesa->tglanamnesis);
        $modAnamnesa->keluhanutama = isset($_POST['RJAnamnesaT']['keluhanutama']) ? ((count((array)$_POST['RJAnamnesaT']['keluhanutama']) > 0) ? implode(', ', $_POST['RJAnamnesaT']['keluhanutama']) : '') : '';
        $modAnamnesa->keluhantambahan = isset($_POST['RJAnamnesaT']['keluhantambahan']) ? ((count((array)$_POST['RJAnamnesaT']['keluhantambahan']) > 0) ? implode(', ', $_POST['RJAnamnesaT']['keluhantambahan']) : '') : '';
        $modAnamnesa->riwayatperjalananpasien = isset($_POST['RJAnamnesaT']['riwayatperjalananpasien']) ? $_POST['RJAnamnesaT']['riwayatperjalananpasien'] : null;
        $modAnamnesa->tglanamnesis = $format->formatDateTimeForDb($_POST['RJAnamnesaT']['tglanamnesis']);
        $modAnamnesa->riwayatobatygsering = isset($_POST['RJAnamnesaT']['riwayatobatygsering']) ? $_POST['RJAnamnesaT']['riwayatobatygsering'] : null;
        $modAnamnesa->riwayatimunisasi = isset($_POST['RJAnamnesaT']['riwayatimunisasi']) ? $_POST['RJAnamnesaT']['riwayatimunisasi'] : null;
        $modAnamnesa->riwayatimunisasiblm = isset($_POST['RJAnamnesaT']['riwayatimunisasiblm']) ? $_POST['RJAnamnesaT']['riwayatimunisasiblm'] : null;
        $modAnamnesa->keb_olahraga = $_POST['RJAnamnesaT']['keb_olahraga'];
        $modAnamnesa->keb_jnsolahraga = isset($_POST['RJAnamnesaT']['keb_jnsolahraga']) ? $_POST['RJAnamnesaT']['keb_jnsolahraga'] : null;
        $modAnamnesa->keb_frekuensi_kaliminggu = isset($_POST['RJAnamnesaT']['keb_frekuensi_kaliminggu']) ? $_POST['RJAnamnesaT']['keb_frekuensi_kaliminggu'] : null;
        $modAnamnesa->keb_konsumsialkohol = $_POST['RJAnamnesaT']['keb_konsumsialkohol'];
        $modAnamnesa->keb_minumkopi = $_POST['RJAnamnesaT']['keb_minumkopi'];
        $modAnamnesa->keb_konsumsidrug = $_POST['RJAnamnesaT']['keb_konsumsidrug'];


        $updateStatusPeriksa = PendaftaranT::model()->updateByPk($pendaftaran_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));

        /* ================================================ */
        /* Proses update status periksa KonsulPoli EHS-179  */
        /* ================================================ */
        $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
        $konsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => $ruangan_id));
        if (!empty($konsulPoli) > 0) {
          $updateStatusPeriksa = KonsulpoliT::model()->updateByPk($konsulPoli->konsulpoli_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
        }
        $modAnamnesa->create_time = date("Y-m-d H:i:s");
        $modAnamnesa->create_loginpemakai_id = Yii::app()->user->id;
        $modAnamnesa->create_ruangan = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
        //					echo print_r($modAnamnesa->attributes);exit;
        /* ================================================ */
        if ($modAnamnesa->save()) {
          $this->simpananamnesa = true;
          $this->saveriwayatindividu($modAnamnesa, $_POST['MCRiwayatindividuR']);
          $this->saveriwayatkeluarga($modAnamnesa, $_POST['MCRiwayatkeluargaR']);
          $this->saveriwayatresikokerja($modAnamnesa, $_POST['MCRiwayatresikokerjaR']);
        } else {
          Yii::app()->user->setFlash('error', "Data anamnesa gagal disimpan " . CHtml::errorSummary($modAnamnesa));
        }
        if ($this->simpananamnesa && $this->simpanriwayatindividu && $this->simpanriwayatkeluarga && $this->simpanriwayatresikokerja) {
          $transaction->commit();
          $this->redirect(array('index', 'pendaftaran_id' => $pendaftaran_id, 'sukses' => 1));
        } else {
          Yii::app()->user->setFlash('error', "Transaksi Gagal " . CHtml::errorSummary($modAnamnesa));
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }
    $modAnamnesa->tglanamnesis = $format->formatDateTimeForUser($modAnamnesa->tglanamnesis);
    $modDiagnosa = new RJDiagnosaM('searchDiagnosaAnamnesa');
    $modDiagnosa->unsetAttributes();
    if (isset($_GET['RJDiagnosaM']))
      $modDiagnosa->attributes = $_GET['RJDiagnosaM'];

    $this->render('index', array(
      'modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien,
      'modAnamnesa' => $modAnamnesa, 'modDiagnosa' => $modDiagnosa, 'modRiwayatIndividu' => $modRiwayatIndividu,
      'modRiwayatKeluarga' => $modRiwayatKeluarga, 'modRiwayatResikoKerja' => $modRiwayatResikoKerja
    ));
  }

  public function saveriwayatindividu($modAnamnesa, $posts)
  {
    $namariwayat = array(
      'Pengobatan TBC', 'Pengobatan Hepatitis', 'Asma', 'Radang Sendi/Remantik', 'Serangan Jantung', 'Patah Tulang / Pasang Pen', 'Hemoroid', 'Hipertensi',
      'Diabetes Melitus', 'Tyroid (Penyakit Gondok)', 'Penyakit Ginjal', 'Saluran Kemih Lainnya', 'Penyakit Stroke', 'Epilepsi', 'Thypus', 'Transfusi Darah',
      'HIV', 'Kanker', 'Riwayat Kecelakaan Kerja', 'Riwayat Jenis Operasi'
    );
    $index = 0;
    $cekRiwayatInduvidu = MCRiwayatindividuR::model()->findAllByAttributes(array('anamesa_id' => $modAnamnesa->anamesa_id));
    if (count((array)$cekRiwayatInduvidu) > 0) {
      MCRiwayatindividuR::model()->deleteAllByAttributes(array('anamesa_id' => $modAnamnesa->anamesa_id));
    }

    if (!empty($posts['lainnya_label'])) {
      array_splice($namariwayat, 18, 0, $posts['lainnya_label']); // inputin label lainnya setelah element array kanker
      unset($posts['lainnya_label']);
    } else {
      unset($posts['lainnya_label']);
      unset($posts['lainnya']);
    }

    foreach ($posts as $i => $post) {
      $index = $index;
      $modRiwayatIndividu = new MCRiwayatindividuR();
      $modRiwayatIndividu->anamesa_id = $modAnamnesa->anamesa_id;
      $modRiwayatIndividu->nama_riwayat_individu = $namariwayat[$index];


      if ($posts[$i] == 1) {
        if (($i == 'pengobatan_tbc') || ($i == 'pengobatan_hepatitis') || ($i == 'serangan_jantung') || ($i == 'tyroid') || ($i == 'penyakit_stroke') || ($i == 'typhus') || ($i == 'tranfusi_darah')) {
          $modRiwayatIndividu->status_riwayatinidividu = 'Pernah';
        } else {
          $modRiwayatIndividu->status_riwayatinidividu = 'Ya';
        }
      } else {
        if (($i == 'riwayat_kecelakankerja') || ($i == 'riwayat_jenisoperasi')) {
          $modRiwayatIndividu->status_riwayatinidividu = !empty($posts[$i]) ? $posts[$i] : ' - ';
        } else {
          $modRiwayatIndividu->status_riwayatinidividu = 'Tidak';
        }
      }
      if ($modRiwayatIndividu->validate()) {
        $modRiwayatIndividu->save();
        $this->simpanriwayatindividu &= true;
      }
      $index++;
    }
  }

  public function saveriwayatkeluarga($modAnamnesa, $posts)
  {
    $namariwayat = array(
      'Darah Tinggi', 'Kanker', 'Asma', 'Ambeien', 'Jantung', 'TBC', 'Stroke', 'Diabetes Melitus', 'Gangguan Jiwa', 'Penyakit Kuning (hati)',
      'Kelainan Darah (thalasemia)'
    );
    $index = 0;
    $cekRiwayatKeluarga = MCRiwayatkeluargaR::model()->findAllByAttributes(array('anamesa_id' => $modAnamnesa->anamesa_id));
    if (count((array)$cekRiwayatKeluarga) > 0) {
      MCRiwayatkeluargaR::model()->deleteAllByAttributes(array('anamesa_id' => $modAnamnesa->anamesa_id));
    }
    if (!empty($posts['lainnya_label'])) {
      array_push($namariwayat, $posts['lainnya_label']); // inputin label lainnya dielement terakhir
      unset($posts['lainnya_label']);
    } else {
      unset($posts['lainnya_label']);
      unset($posts['lainnya']);
    }

    foreach ($posts as $i => $post) {
      $index = $index;
      $modRiwayatKeluarga = new MCRiwayatkeluargaR();
      $modRiwayatKeluarga->anamesa_id = $modAnamnesa->anamesa_id;
      $modRiwayatKeluarga->nama_riwayat_keluarga = $namariwayat[$index];
      if ($posts[$i] == 1) {
        $modRiwayatKeluarga->status_riwayat_keluarga = 'Ada';
      } else {
        $modRiwayatKeluarga->status_riwayat_keluarga = 'Tidak';
      }
      if ($modRiwayatKeluarga->save()) {
        $this->simpanriwayatkeluarga &= true;
      }
      $index++;
    }
  }
  public function saveriwayatresikokerja($modAnamnesa, $posts)
  {
    $namariwayat = array(
      'Kebisingan', 'Suhu Panas Ekstrim', 'Kelembaban', 'Pencahayaan Kurang', 'Kesilauan', 'Getaran Pada Tangan', 'Getaran Seluruh Badan',
      'Ventilasi Kurang Memadai', 'Radiasi Pengion', 'Radiasi Bukan Pengion', 'Ketinggian', 'Bakteri / Virus / Jamur / Parasit', 'Darah / Cairan Tubuh Lainnya',
      'Nyamuk / Serangga Lainnya', 'Limbah (Kotoran manusia / hewan)', 'Asam', 'Basa', 'Pelarut Organik', 'Uap Logam', 'Gas', 'Pestisida / Insektisida', 'Debu',
      'Posisi Kerja Tidak Ergonomis', 'Gerakan Repetitif', 'Berdiri Lama', 'Duduk Lama', 'Angkat / Angkut Berat', 'Bekerja Dengan Motor (>= 4Jam/hari)', 'Stress Kerja',
      'Kekerasan di Tempat Kerja', 'Pelecehan di Tempat Kerja', 'Ketidakjelasan Tugas', 'Konflik dengan Teman Kerja'
    );
    $index = 0;
    $cekRiwayatResikoKerja = MCRiwayatresikokerjaR::model()->findAllByAttributes(array('anamesa_id' => $modAnamnesa->anamesa_id));
    if (count((array)$cekRiwayatResikoKerja) > 0) {
      MCRiwayatresikokerjaR::model()->deleteAllByAttributes(array('anamesa_id' => $modAnamnesa->anamesa_id));
    }
    foreach ($posts as $i => $post) {
      $index = $index;
      $modRiwayatResikoKerja = new MCRiwayatresikokerjaR();
      $modRiwayatResikoKerja->anamesa_id = $modAnamnesa->anamesa_id;
      $modRiwayatResikoKerja->nama_faktor_resiko = $namariwayat[$index];
      if ($index <= 10) {
        $modRiwayatResikoKerja->jenis_faktor_resiko = 'Faktor Fisika';
      } else if ((10 < $index) && ($index <= 14)) {
        $modRiwayatResikoKerja->jenis_faktor_resiko = 'Faktor Biologi';
      } else if ((14 < $index) && ($index <= 21)) {
        $modRiwayatResikoKerja->jenis_faktor_resiko = 'Faktor Kimia';
      } else if ((21 < $index) && ($index <= 27)) {
        $modRiwayatResikoKerja->jenis_faktor_resiko = 'Faktor Ergonomi';
      } else {
        $modRiwayatResikoKerja->jenis_faktor_resiko = 'Faktor Psikisosial';
      }

      if ($posts[$i] == 1) {
        $modRiwayatResikoKerja->status_faktor_resiko = 'Ya';
      } else {
        $modRiwayatResikoKerja->status_faktor_resiko = 'Tidak';
      }
      if ($modRiwayatResikoKerja->save()) {
        $this->simpanriwayatresikokerja &= true;
      }
      $index++;
    }
  }

  /**
   * @param type $pendaftaran_id
   */
  public function actionPrintAnamnesa($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modAnamnesa = RJAnamnesaT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));

    $judul_print = 'ANAMNESIS';
    $this->render('printAnamnesa', array(
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
      'judul_print' => $judul_print,
      'modPasien' => $modPasien,
      'modAnamnesa' => $modAnamnesa,
    ));
  }

  public function actionMasterKeluhan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria;
      $criteria->compare('LOWER(keluhananamnesis_nama)', strtolower($_GET['tag']), true);
      $keluhans = KeluhananamnesisM::model()->findAll($criteria);
      $data = array();
      foreach ($keluhans as $i => $keluhan) {
        $data[$i] = array(
          'key' => $keluhan->keluhananamnesis_nama,
          'value' => $keluhan->keluhananamnesis_nama
        );
      }

      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }

  /**
   * actionGetTriasePasien untuk Triase Tabulasi Anamnesis:
   * issue		: RND-6415
   */
  public function actionGetTriasePasien()
  {

    if (Yii::app()->request->isAjaxRequest) {
      $triase_id = $_POST['triase_id'];

      $modDetail = new RJTriase;
      $modTriase = RJTriase::model()->findByPk($triase_id);
      $warna = RJTriase::model()->getKodeWarnaId($triase_id);
      $tr = "<tr>
                            <td> " . CHtml::hiddenField('noUrut', '', array('class' => 'span1 noUrut', 'readonly' => TRUE)) .
        CHtml::activeHiddenField($modDetail, '[' . $triase_id . ']triase_id', array('value' => $modTriase->triase_id, 'class' => 'triase_id'))
        . "<div class='colorPicker-picker' style='background-color:#" . $warna . ";'> </div>" .
        "</td>
                            <td>" . $modTriase->triase_nama . "</td>
                            <td>" . $modTriase->keterangan_triase . "</td>
                            <td>" . CHtml::link(
          "<span class='icon-remove'>&nbsp;</span>",
          '',
          array('href' => '#', 'onClick' => 'batalTriase();return false;', 'style' => 'text-decoration:none;')
        ) . "</td>
                         </tr>   
                        ";
      $data['tr'] = $tr;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionHapusTriase()
  {
    if (Yii::app()->request->isPostRequest) {
      $anamesa_id = $_POST['anamesa_id'];
      $triase_id = $_POST['triase_id'];
      $modAnamnesa = AnamnesaT::model()->findByPk($anamesa_id);
      if (!empty($modAnamnesa->triase_id)) {
        $update = AnamnesaT::model()->updateByPk($anamesa_id, array('triase_id' => null));
      }

      if ($update) {
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
          ));
          exit;
        }
      }

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }
}
