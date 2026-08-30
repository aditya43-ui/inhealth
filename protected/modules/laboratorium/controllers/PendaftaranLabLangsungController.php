<?php
Yii::import('pendaftaranPenjadwalan.models.*');
Yii::import('pendaftaranPenjadwalan.views.pendaftaranRawatJalan');
Yii::import('pendaftaranPenjadwalan.controllers.PendaftaranRawatJalanController');
class PendaftaranLabLangsungController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = "laboratorium.views.pendaftaranLabLangsung.";
  public $path_viewPPRJ = 'pendaftaranPenjadwalan.views.pendaftaranRawatJalan.';

  public $pasientersimpan = false;
  public $pendaftarantersimpan = false;
  public $penanggungjawabtersimpan = false;
  public $tindakanpelayanantersimpan = true; //dilooping / boleh tanpa ini
  public $karcistersimpan = true; //dilooping / boleh tanpa ini
  public $komponentindakantersimpan = true; //di looping
  public $rujukantersimpan = false;
  public $pengambilansampletersimpan = true; //dilooping / boleh tanpa ini
  public $pasienpenunjangtersimpan = true; //dilooping
  public $hasilpemeriksaantersimpan = true; //dilooping
  public $asuransipasientersimpan = false;

  public $is_pasien_baru = false;
  public $is_anatomi = false;

  /**
   * Index transaksi pendaftaran
   */
  public function actionIndex($id = null, $idAntrian = null)
  {
    $format = new MyFormatter();
    $model = new LBPendaftaranT;
    $model->pendaftaran_id = null; //new record
    $modPasien = new LBPasienM;
    $modPenanggungJawab = new LBPenanggungJawabM;
    $modAsuransiPasien = new LBAsuransipasienM;

    $modPegawai = new PPPegawaiM;
    $modPegawaiPJ = new PPPegawaiM;
    $modAsuransiPasienBadak = new PPAsuransipasienbadakM();
    $modAsuransiPasienDepartemen = new PPAsuransipasiendepartemenM();
    $modAsuransiPasienPekerja = new PPAsuransipasienpegawaiM();

    $modPasienMasukPenunjangs[0] = new LBPasienmasukpenunjangT;
    $modPasienMasukPenunjangs[0]->ruangan_id = Params::RUANGAN_ID_LAB_KLINIK;
    $modPasienMasukPenunjangs[0]->is_pilihpenunjang = 0;
    $modPasienMasukPenunjangs[0]->is_adakarcis = 0; //dibawah ada switch
    $modPasienMasukPenunjangs[0]->jeniskasuspenyakit_id = Params::JENIS_KASUSPENYAKIT_ID_LAB_KLIINIK; //default 
    $modPasienMasukPenunjangs[1] = new LBPasienmasukpenunjangT;
    $modPasienMasukPenunjangs[1]->ruangan_id = Params::RUANGAN_ID_LAB_ANATOMI;
    $modPasienMasukPenunjangs[1]->is_pilihpenunjang = 0;
    $modPasienMasukPenunjangs[1]->is_adakarcis = 0; //dibawah ada switch

    $modAntrian = new PPAntrianT;

    switch (Yii::app()->user->getState('ruangan_id')) {
      case Params::RUANGAN_ID_LAB_ANATOMI:
        $modPasienMasukPenunjangs[1]->is_pilihpenunjang = 1;
        $modPasienMasukPenunjangs[1]->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
        break;
      default:
        $modPasienMasukPenunjangs[0]->is_pilihpenunjang = 1;
        $modPasienMasukPenunjangs[0]->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
    }

    $modPemeriksaanLab = new LBTarifpemeriksaanlabruanganV;
    $modRujukan = new LBRujukanT;
    $modTindakan = new LBTindakanPelayananT;
    $modHasilPemeriksaan = new LBHasilPemeriksaanLabT;
    $modHasilPemeriksaanPA = new LBHasilPemeriksaanPAT;
    $modDetailHasilPemeriksaan = new LBDetailHasilPemeriksaanLabT;
    $modPengambilanSample = new LBPengambilanSampleT;
    $modPengambilanSample->no_pengambilansample = "- Otomatis -";
    $dataTindakans[0] = array();
    $dataTindakans[1] = array();
    $modKarcis[0] = array();
    $modKarcis[1] = array();
    $dataSamples[0] = array();
    $dataSamples[1] = array();
    $modPasien->propinsi_id = Yii::app()->user->getState('propinsi_id');
    $modPasien->kabupaten_id = Yii::app()->user->getState('kabupaten_id');
    $modPasien->kecamatan_id = Yii::app()->user->getState('kecamatan_id');
    $modPasien->warga_negara = Params::DEFAULT_WARGANEGARA;
    $modPasien->agama = Params::DEFAULT_AGAMA;

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

    //==load data
    if (!empty($idAntrian)) {
      $modAntrian = PPAntrianT::model()->findByPk($idAntrian, array(
        'condition' => 'pendaftaran_id is null',
      ));
      if (empty($modAntrian)) {
        $modAntrian = new PPAntrianT;
      } else {
        $model->antrian_id = $modAntrian->antrian_id;
      }
    }
    if (isset($id)) {
      $model = $this->loadModel($id);
      $modPasien = LBPasienM::model()->findByPk($model->pasien_id);
      $criteria = new CdbCriteria();
      $criteria->addCondition('pendaftaran_id = ' . $model->pendaftaran_id);
      $criteria->order = "pendaftaran_id DESC, pasienmasukpenunjang_id ASC";
      $criteria->limit = 2;
      $criteria1 = $criteria;
      $criteria1->addCondition('ruangan_id <> ' . Params::RUANGAN_ID_LAB_ANATOMI);
      $loadPasienMasukPenunjangs[0] = LBPasienmasukpenunjangT::model()->find($criteria1);
      if (isset($loadPasienMasukPenunjangs[0])) {
        $modPasienMasukPenunjangs[0] = $loadPasienMasukPenunjangs[0];
        $modPasienMasukPenunjangs[0]->is_pilihpenunjang = 1;
        $modPasienMasukPenunjangs[0]->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
      }
      $criteria2 = $criteria;
      $criteria2->addCondition('ruangan_id = ' . Params::RUANGAN_ID_LAB_ANATOMI);
      $loadPasienMasukPenunjangs[1] = LBPasienmasukpenunjangT::model()->find($criteria2);
      if (isset($loadPasienMasukPenunjangs[1])) {
        $modPasienMasukPenunjangs[1] = $loadPasienMasukPenunjangs[1];
        $modPasienMasukPenunjangs[1]->is_pilihpenunjang = 1;
        $modPasienMasukPenunjangs[1]->is_adakarcis = Yii::app()->user->getState('iskarcis'); //RND-7737
      }
      if (!empty($model->penanggungjawab_id)) {
        $modPenanggungJawab = LBPenanggungJawabM::model()->findByPk($model->penanggungjawab_id);
        if (!empty($modPenanggungJawab->pegawai_id)) {
          $modPasien->pegawai_penanggungjawab_id = $modPenanggungJawab->pegawai_id;
          $modPegawaiPJ = LBPegawaiM::model()->findByPk($modPenanggungJawab->pegawai_id);
        }
      }
      if (!empty($model->rujukan_id)) {
        $modRujukan = LBRujukanT::model()->findByPk($model->rujukan_id);
      }
      $dataKarcis[0] = LBTindakanPelayananT::model()->findByAttributes(array('ruangan_id' => Params::RUANGAN_ID_LAB_KLINIK, 'pendaftaran_id' => $model->pendaftaran_id), "karcis_id is not null");
      $dataKarcis[1] = LBTindakanPelayananT::model()->findByAttributes(array('ruangan_id' => Params::RUANGAN_ID_LAB_ANATOMI, 'pendaftaran_id' => $model->pendaftaran_id), "karcis_id is not null");
      if (isset($dataKarcis[0]->karcis_id)) {
        $modKarcis[0][0] =  LBKarcisV::model()->findByAttributes(array('karcis_id' => $dataKarcis[0]->karcis_id));
        $modKarcis[0][0]->harga_tariftindakan = $dataKarcis[0]->tarif_tindakan;
      }
      if (isset($dataKarcis[1]->karcis_id)) {
        $modKarcis[1][0] =  LBKarcisV::model()->findByAttributes(array('karcis_id' => $dataKarcis[1]->karcis_id));
        $modKarcis[1][0]->harga_tariftindakan = $dataKarcis[1]->tarif_tindakan;
      }
      $dataTindakans[0] = LBTindakanPelayananT::model()->findAllByAttributes(array('ruangan_id' => Params::RUANGAN_ID_LAB_KLINIK, 'pendaftaran_id' => $model->pendaftaran_id), "karcis_id is null");
      $dataTindakans[1] = LBTindakanPelayananT::model()->findAllByAttributes(array('ruangan_id' => Params::RUANGAN_ID_LAB_ANATOMI, 'pendaftaran_id' => $model->pendaftaran_id), "karcis_id is null");
    }

    if (isset($_POST['LBPendaftaranT'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modPasien = $this->simpanPasien($modPasien, $_POST['LBPasienM']);
        // echo '<pre>';var_dump($_POST);die;
        if ($_POST['LBPendaftaranT']['is_adapjpasien']) {
          if (isset($_POST['LBPenanggungJawabM'])) {
            $modPenanggungJawab = $this->simpanPenanggungjawab($modPenanggungJawab, $_POST['LBPenanggungJawabM']);
          }
        } else {
          $this->penanggungjawabtersimpan = true;
        }

        if (isset($_POST['LBPasienM']['pegawai_penanggungjawab_id'])) {
          $modPenanggungJawab = $this->simpanPenanggungjawabDokter($modPenanggungJawab, $_POST['LBPasienM']['pegawai_penanggungjawab_id']);
        }

        if ($_POST['LBPendaftaranT']['is_pasienrujukan']) {
          if (isset($_POST['LBRujukanT'])) {
            $modRujukan = $this->simpanRujukan($modRujukan, $_POST['LBRujukanT']);
          }
        } else {
          $this->rujukantersimpan = true;
        }

        if (isset($_POST['LBAsuransipasienM'])) {
          if (isset($_POST['LBAsuransipasienM']['asuransipasien_id'])) {
            if (!empty($_POST['LBAsuransipasienM']['asuransipasien_id'])) {
              $modAsuransiPasien = LBAsuransipasienM::model()->findByPk($_POST['LBAsuransipasienM']['asuransipasien_id']);
            }
          }
          $modAsuransiPasien = $this->simpanAsuransiPasien($modAsuransiPasien, $_POST['LBPendaftaranT'], $modPasien, $_POST['LBAsuransipasienM']);
        } else {
          $this->asuransipasientersimpan = true;
        }

        if (isset($_POST['PPAsuransipasienbadakM'])) {
          if (isset($_POST['PPAsuransipasienbadakM']['asuransipasien_id'])) {
            if (!empty($_POST['PPAsuransipasienbadakM']['asuransipasien_id'])) {
              $modAsuransiPasienBadak = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienbadakM']['asuransipasien_id']);
            }
          }
          $modAsuransiPasienBadak = $this->simpanAsuransiPasien($modAsuransiPasienBadak, $_POST['LBPendaftaranT'], $modPasien, $_POST['PPAsuransipasienbadakM']);
        } else {
          $this->asuransipasientersimpan = true;
        }

        if (isset($_POST['PPAsuransipasiendepartemenM'])) {
          if (isset($_POST['PPAsuransipasiendepartemenM']['asuransipasien_id'])) {
            if (!empty($_POST['PPAsuransipasiendepartemenM']['asuransipasien_id'])) {
              $modAsuransiPasienDepartemen = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasiendepartemenM']['asuransipasien_id']);
            }
          }
          $modAsuransiPasienDepartemen = $this->simpanAsuransiPasien($modAsuransiPasienDepartemen, $_POST['LBPendaftaranT'], $modPasien, $_POST['PPAsuransipasiendepartemenM']);
        } else {
          $this->asuransipasientersimpan = true;
        }

        if (isset($_POST['PPAsuransipasienpegawaiM'])) {
          if (isset($_POST['PPAsuransipasienpegawaiM']['asuransipasien_id'])) {
            if (!empty($_POST['PPAsuransipasienpegawaiM']['asuransipasien_id'])) {
              $modAsuransiPasienPekerja = PPAsuransipasienM::model()->findByPk($_POST['PPAsuransipasienpegawaiM']['asuransipasien_id']);
            }
          }
          $modAsuransiPasienPekerja = $this->simpanAsuransiPasien($modAsuransiPasienPekerja, $_POST['LBPendaftaranT'], $modPasien, $_POST['PPAsuransipasienpegawaiM']);
        } else {
          $this->asuransipasientersimpan = true;
        }

        $model = $this->simpanPendaftaran($model, $modPasien, $modRujukan, $modPenanggungJawab, $_POST['LBPendaftaranT'], $_POST['LBPasienM'], $_POST['LBPasienmasukpenunjangT'], $modAsuransiPasien);

        if (count((array)$_POST['LBPasienmasukpenunjangT']) > 0) {
          foreach ($_POST['LBPasienmasukpenunjangT'] as $i => $postPenunjang) {
            if ($postPenunjang['is_pilihpenunjang']) {
              $modPasienMasukPenunjangs[$i] = $this->simpanPasienMasukPenunjang($modPasienMasukPenunjangs[$i], $model, $postPenunjang);
            //   $modPasienMasukPenunjangs[$i]->noorderlis = MyGenerator::noOrderLAB($modPasienMasukPenunjangs[$i]->ruangan_id);
            //   $modPasienMasukPenunjangs[$i]->save(false, array('noorderlis'));
              if ($postPenunjang['ruangan_id'] <> Params::RUANGAN_ID_LAB_ANATOMI) {
                $modHasilPemeriksaan = $this->simpanHasilPemeriksaanLab($modPasien, $modPasienMasukPenunjangs[$i]);
              }
              if (isset($_POST['LBTindakanPelayananT'][$i])) {
                if (count((array)$_POST['LBTindakanPelayananT'][$i]) > 0) {
                  foreach ($_POST['LBTindakanPelayananT'][$i] as $ii => $tindakan) {
                    $dataTindakans[$i][$ii] = $this->simpanTindakanPelayanan($model, $modPasienMasukPenunjangs[$i], $tindakan);
                    $dataTindakans[$i][$ii]->pemeriksaanlab_id = $tindakan['pemeriksaanlab_id'];
                    $dataTindakans[$i][$ii]->jenistarif_id = $tindakan['jenistarif_id'];
                    if ($postPenunjang['ruangan_id'] <> Params::RUANGAN_ID_LAB_ANATOMI) {
                      if (!empty($modHasilPemeriksaan->hasilpemeriksaanlab_id)) {
                        $this->simpanDetailHasilPemeriksaanLab($modHasilPemeriksaan, $dataTindakans[$i][$ii], $tindakan);
                      }
                    } else {
                      $modHasilPemeriksaanPA = $this->simpanHasilPemeriksaanPA($modPasienMasukPenunjangs[$i], $dataTindakans[$i][$ii], $tindakan);
                    }
                    $dataTindakans[$i][$ii]->tarif_tindakan = $format->formatNumberForUser($dataTindakans[$i][$ii]->tarif_tindakan);
                  }
                }
              }
              if ($postPenunjang['is_adakarcis']) {
                if (isset($_POST['LBKarcisV'][$i])) {
                  if (count((array)$_POST['LBKarcisV'][$i]) > 0) {
                    foreach ($_POST['LBKarcisV'][$i] as $ii => $karcis) {
                      if ($karcis['is_pilihkarcis']) {
                        $modKarcis[$i][$ii] = new LBKarcisV;
                        $modKarcis[$i][$ii]->attributes = $karcis;
                        $this->simpanTindakanPelayanan($model, $modPasienMasukPenunjangs[$i], $karcis);
                      }
                    }
                  }
                }
              }

              if ($postPenunjang['is_adasample']) {
                $modPengambilanSamples[$i] = $this->simpanPengambilanSample($modPasienMasukPenunjangs[$i], $_POST['LBPengambilanSampleT'][$i]);
              } else {
                $this->pengambilansampletersimpan &= true;
              }
            }
          }
        }

        $ok_vaksinasi = true;


        if ($_POST['LBPendaftaranT']['is_vaksinasi'] && isset($_POST['RiwayatvaksinasipasienT']['detail'])) {
          $ok_vaksinasi = RiwayatvaksinasipasienT::simpanRiwayat($model->pendaftaran_id, $model->pasien_id, $_POST['RiwayatvaksinasipasienT']['detail']);
        }

        if (isset($_POST['scan'])) {
          $this->simpanScanPasien($model, $_POST['scan']);
        }

        //////////////////
        //////////////////
        //////////////////
        //////////////////
        //////////////////
        //////////////////
        // var_dump($modPasien->is_bukanmanusia);die;
        if($modPasien->is_bukanmanusia==true){

        }else{
          if (!empty($modHasilPemeriksaan)) {
            $sysmex = new Sysmex;
            $sysmex->kirim_tambah($modHasilPemeriksaan->hasilpemeriksaanlab_id, null, $_POST['LBPasienmasukpenunjangT'][0]['dokterperujuk']);
          }
        }


        // var_dump($this->pasientersimpan , $this->pendaftarantersimpan , $this->penanggungjawabtersimpan , $this->rujukantersimpan , $this->tindakanpelayanantersimpan , $this->karcistersimpan , $this->komponentindakantersimpan , $this->pasienpenunjangtersimpan , $this->hasilpemeriksaantersimpan , $this->pengambilansampletersimpan , $this->asuransipasientersimpan); die;

        if ($ok_vaksinasi && $this->pasientersimpan && $this->pendaftarantersimpan && $this->penanggungjawabtersimpan && $this->rujukantersimpan && $this->tindakanpelayanantersimpan && $this->karcistersimpan && $this->komponentindakantersimpan && $this->pasienpenunjangtersimpan && $this->hasilpemeriksaantersimpan && $this->pengambilansampletersimpan && $this->asuransipasientersimpan) {

          $this->broadcastNotifDaftarLab($model, $modPasien);

          if ($this->is_pasien_baru) {
            $this->cleanUpSessionPasienSudahBaca($model->pendaftaran_id);
          }

          //Di set di form >> Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan !");
          //                      RND-666 >>>  $this->redirect(array('view','id'=>$model->pendaftaran_id,'sukses'=>1));
          $smspasien = 1;
          $smsdokter = 1;
          $smspenanggungjawab = 1;

          if (Yii::app()->user->getState('issmsgateway')) {
            // SMS GATEWAY
            $modPegawai = $model->pegawai;
            $modRuangan = $model->ruangan;
            $sms = new Sms();
            $smspasien = 1;
            $smsdokter = 1;
            $smspenanggungjawab = 1;

            $model->tgl_pendaftaran = MyFormatter::formatDateTimeForUser($model->tgl_pendaftaran);
            $model->no_urutantri = $model->ruangan->ruangan_singkatan . "-" . $model->no_urutantri;

            if (!empty($modPegawai)) {
              $modPegawai->nama_pegawai = $modPegawai->namaLengkap;
            }



            foreach ($modSmsgateway as $i => $smsgateway) {

              if (isset($_POST['tujuansms']) && in_array($smsgateway->tujuansms, $_POST['tujuansms'])) {
                $isiPesan = $smsgateway->templatesms;
                $isiPesan = "${isiPesan}";

                $attributes = $modPasien->getAttributes();
                foreach ($attributes as $attributes => $value) {
                  $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                }
                $attributes = $modPenanggungJawab->getAttributes();
                foreach ($attributes as $attributes => $value) {
                  $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                }
                if (!empty($modPegawai)) {
                  $attributes = $modPegawai->getAttributes();
                  foreach ($attributes as $attributes => $value) {
                    $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                  }
                }
                $attributes = $model->getAttributes();
                foreach ($attributes as $attributes => $value) {
                  $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                }
                $attributes = $modRuangan->getAttributes();
                foreach ($attributes as $attributes => $value) {
                  $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                }
                $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($model->tgl_pendaftaran), $isiPesan);
                $isiPesan = str_replace("{{nama_rumahsakit}}", Yii::app()->user->getState('nama_rumahsakit'), $isiPesan);
                $isiPesan = str_replace("\\n", hex2bin("0a"), $isiPesan);


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
                } elseif ($smsgateway->tujuansms == Params::TUJUANSMS_PENANGGUNGJAWAB && $smsgateway->statussms) {
                  if (!empty($modPenanggungJawab->no_mobilepj)) {
                    $sms->kirim($modPenanggungJawab->no_mobilepj, $isiPesan);
                  } else {
                    $smspenanggungjawab = 0;
                  }
                }
              }
            }
          }

          if (isset($_POST['is_whatsapp']) && $_POST['is_whatsapp'] == 1) {
            $this->kirimWhatsApp($model, $modPasien);
          }
          //            die;
          // var_dump($modPasien);die;
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data pendaftaran berhasil disimpan !");
          $this->redirect(array('index', 'id' => $model->pendaftaran_id, 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data pendaftaran gagal disimpan !");
          //                        echo "-".$this->pasientersimpan."<br>";
          //                        echo "-".$this->pendaftarantersimpan."<br>";
          //                        echo "-".$this->penanggungjawabtersimpan."<br>";
          //                        echo "-".$this->rujukantersimpan."<br>";
          //                        echo "-".$this->karcistersimpan."<br>";
          //                        echo "-".$this->tindakanpelayanantersimpan."<br>";
          //                        echo "-".$this->komponentindakantersimpan."<br>";
          //                        echo "-".$this->hasilpemeriksaantersimpan."<br>";
          //                        echo "-".$this->pengambilansampletersimpan."<br>";
          //                        exit;
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        echo '<pre>';
        var_dump($exc->getMessage());
        die;
        Yii::app()->user->setFlash('error', "Data pendaftaran gagal disimpan !" . " " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'modPasien' => $modPasien,
      'modPegawaiPJ' => $modPegawaiPJ,
      'modPenanggungJawab' => $modPenanggungJawab,
      'modAsuransiPasien' => $modAsuransiPasien,
      'modPasienMasukPenunjangs' => $modPasienMasukPenunjangs,
      'modPemeriksaanLab' => $modPemeriksaanLab,
      'modPengambilanSample' => $modPengambilanSample,
      'modRujukan' => $modRujukan,
      'modTindakan' => $modTindakan,
      'dataTindakans' => $dataTindakans,
      'modKarcis' => $modKarcis,
      'dataSamples' => $dataSamples,
      'modPegawai' => $modPegawai,
      'modAsuransiPasienBadak' => $modAsuransiPasienBadak,
      'modAsuransiPasienPekerja' => $modAsuransiPasienPekerja,
      'modAsuransiPasienDepartemen' => $modAsuransiPasienDepartemen,
      'modSmsgateway' => $modSmsgateway,
      'modAntrian' => $modAntrian,
    ));
  }

  public function kirimWhatsApp($model, $modPasien)
  {

    $str = "Selamat Datang di ((nama_rs))\n\n";
    $str .= $modPasien->namadepan . $modPasien->nama_pasien . " dengan No RM " . $modPasien->no_rekam_medik . " ";
    $str .= "terdaftar sebagai pasien pada tanggal " . MyFormatter::formatDateTimeForUser($model->tgl_pendaftaran);
    $str .= " dan akan melakukan pemeriksaan di ";
    $str .= $model->ruangan->ruangan_nama . ".\n\n";

    //$str .= "Kamar ".(empty($modPasienAdmisi->kamarruangan) ? "-" : $modPasienAdmisi->kamarruangan->kamarruangan_nokamar)." - ";
    //$str .= (empty($modPasienAdmisi->kamarruangan) ? "-" : $modPasienAdmisi->kamarruangan->kamarruangan_nobed)."\n\n";

    $str .= "Harap dicermati dan dipatuhi apa yg sudah disetujui dan ditandatangani di persetujuan umum.\n";
    $str .= "Jika memerlukan bantuan bisa kontak ke bagian informasi Rumah Sakit.\n\n";

    $str .= "Terimakasih\n((nama_rs)) - ((lokasi))";

    $str = str_replace("((nama_rs))", ucwords(strtolower((Yii::app()->user->getState('nama_rumahsakit')))), $str);
    $str = str_replace("((lokasi))", Yii::app()->user->getState('kabupaten_nama'), $str);


    //            var_dump($str); die;

    $wa = new WhatsApp();
    $res = $wa->kirimIndividu($modPasien->no_mobile_pasien, $str);
    //            $res = $wa->kirimIndividu("085606615990", $str);

    //            var_dump($res, $str, $model->attributes, $modPasienAdmisi->attributes, $modPasien->attributes);
    //            die;
  }


  public function simpanPenanggungjawabDokter($modPenanggungjawab, $pegawai_id)
  {
    $format = new MyFormatter;
    $peg = PegawaiM::model()->findByPk($pegawai_id);

    // $modPenanggungjawab = new PPPenanggungJawabM;
    $modPenanggungjawab->pengantar = Params::PENGANTAR_PEGAWAI_RS;
    $modPenanggungjawab->jenisidentitas = $peg->jenisidentitas;
    $modPenanggungjawab->no_identitas = $peg->noidentitas;
    $modPenanggungjawab->no_identitas_pj = $peg->noidentitas;
    $modPenanggungjawab->nama_pj = $peg->namaLengkap;
    $modPenanggungjawab->tempatlahir_pj = $peg->tempatlahir_pegawai;
    $modPenanggungjawab->tgllahir_pj = $peg->tgl_lahirpegawai;
    $modPenanggungjawab->jeniskelamin = $peg->jeniskelamin;
    $modPenanggungjawab->alamat_pj = $peg->alamat_pegawai;
    $modPenanggungjawab->no_teleponpj = $peg->notelp_pegawai;
    $modPenanggungjawab->no_mobilepj = str_replace(" ", "", $peg->nomobile_pegawai);
    $modPenanggungjawab->pegawai_id = $pegawai_id;
    $modPenanggungjawab->hubungankeluarga = "";

    if ($modPenanggungjawab->save()) {
      $this->penanggungjawabtersimpan = true;
    } else {
      $this->penanggungjawabtersimpan = false;
    }

    return $modPenanggungjawab;
  }



  protected function broadcastNotifDaftarLab($model, $modPasien)
  {
    $judul = "Pendaftaran langsung Pasien Laboratorium";
    $isi = $model->no_pendaftaran . " - " . $modPasien->no_rekam_medik . " - " . $modPasien->nama_pasien;

    $linkDaftarPasien = Yii::app()->createUrl('/laboratorium/daftarPasien/index', array(
      'LBPasienMasukPenunjangV[tgl_awal]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
      'LBPasienMasukPenunjangV[tgl_akhir]' => date('Y-m-d', strtotime($model->tgl_pendaftaran)),
      'LBPasienMasukPenunjangV[no_pendaftaran]' => $model->no_pendaftaran,
      'LBPasienMasukPenunjangV[statusperiksahasil]' => '',
      'LBPasienMasukPenunjangV[tgl_awall]' => date('Y-m-d'),
      'LBPasienMasukPenunjangV[tgl_akhirl]' => date('Y-m-d'),
      'LBPasienMasukPenunjangV[prefix_pendaftaran]' => '',
      'LBPasienMasukPenunjangV[ceklis]' => 0,
    ));


    // var_dump($judul, $isi, $linkDaftarPasien); die;

    $ok = CustomFunction::broadcastNotif($judul, $isi, array(
      array('instalasi_id' => Params::INSTALASI_ID_LAB, 'ruangan_id' => Params::RUANGAN_ID_LAB_KLINIK, 'modul_id' => Params::MODUL_ID_LAB,  'link_proses' => $linkDaftarPasien), //, 'link_proses'=>$link_rj
    ));
  }

  /**
   * form verifikasi sebelum submit
   * @param type $id
   */
  public function actionVerifikasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $this->layout = '//layouts/iframe';
      if (isset($_POST['LBPendaftaranT'])) {
        $format = new MyFormatter();
        $model = new LBPendaftaranT;
        $modPasien = new LBPasienM;
        $modPengambilanSamples = array();
        $modPenanggungJawab = null;
        $modRujukan = null;
        $modTindakans = array();
        $modKarcis = array();

        $model->attributes = $_POST['LBPendaftaranT'];
        $modPasien->attributes = $_POST['LBPasienM'];
        if($_POST['LBPasienM']['is_bukanmanusia'] == 1) {
            $modPasien->nama_pasien  = $_POST['LBPasienM']['nama_pasien_spesimen'];
        }
        // echo '<pre>';var_dump($_POST);die;
        if ($_POST['LBPendaftaranT']['is_adapjpasien']) {
          if (isset($_POST['LBPenanggungJawabM'])) {
            $modPenanggungJawab = new LBPenanggungJawabM;
            $modPenanggungJawab->attributes = $_POST['LBPenanggungJawabM'];
          }
        }
        // if($modPasien->is_bukanmanusia = true){
        //   $modPasien->agama = '';
        // }

        if ($_POST['LBPendaftaranT']['is_pasienrujukan']) {
          if (isset($_POST['LBRujukanT'])) {
            $modRujukan = new LBRujukanT;
            $modRujukan->attributes = $_POST['LBRujukanT'];
            $modRujukan->rujukandari_id = !empty($modRujukan->rujukandari_id) ? $modRujukan->rujukandari_id : null;
          }
        }
        if (count((array)$_POST['LBPasienmasukpenunjangT']) > 0) {
          foreach ($_POST['LBPasienmasukpenunjangT'] as $i => $postPenunjang) {
            if ($postPenunjang['is_pilihpenunjang']) {
              $modPasienMasukPenunjangs[$i] = new LBPasienmasukpenunjangT;
              $modPasienMasukPenunjangs[$i]->attributes = $postPenunjang;
              $modPasienMasukPenunjangs[$i]->tglmasukpenunjang = date('Y-m-d H:i:s');
              if (isset($_POST['LBTindakanPelayananT'][$i])) {
                if (count((array)$_POST['LBTindakanPelayananT'][$i]) > 0) {
                  foreach ($_POST['LBTindakanPelayananT'][$i] as $ii => $tindakan) {
                    $modTindakans[$i][$ii] = new LBTindakanPelayananT;
                    $modTindakans[$i][$ii]->attributes = $tindakan;
                  }
                }
              }
              if ($postPenunjang['is_adakarcis']) {
                if (isset($_POST['LBKarcisV'][$i])) {
                  if (count((array)$_POST['LBKarcisV'][$i]) > 0) {
                    foreach ($_POST['LBKarcisV'][$i] as $ii => $karcis) {
                      if ($karcis['is_pilihkarcis']) {
                        $modKarcis[$ii] = new LBKarcisV;
                        $modKarcis[$ii]->attributes = $karcis;
                      }
                    }
                  }
                }
              }
              if ($postPenunjang['is_adasample']) {
                $modPengambilanSamples[$i] = new LBPengambilanSampleT;
                $modPengambilanSamples[$i]->attributes = $_POST['LBPengambilanSampleT'][$i];
              }
            }
          }
        }
      }
      echo CJSON::encode(array(
        'content' => $this->renderPartial($this->path_view . 'verifikasi', array(
          'model' => $model,
          'modPasienMasukPenunjangs' => $modPasienMasukPenunjangs,
          'modPasien' => $modPasien,
          'modPenanggungJawab' => $modPenanggungJawab,
          'modRujukan' => $modRujukan,
          'modTindakans' => $modTindakans,
          'modKarcis' => $modKarcis,
          'modPengambilanSamples' => $modPengambilanSamples,
          'format' => $format,
        ), true)
      ));
      Yii::app()->end();
    }
  }

  /**
   * proses simpan / ubah data pasien
   * @param type $modPasien
   * @param type $post
   * @return type
   */
  public function simpanPasien($modPasien, $post)
  {
    $format = new MyFormatter();
    if (isset($post['pasien_id']) && (!empty($post['pasien_id']))) {
      $load = new $modPasien;
      $modPasien = $load->findByPk($post['pasien_id']);
    }
    $modPasien->attributes = $post;
    if($modPasien->is_bukanmanusia = true){
      $modPasien->tanggal_lahir = $format->formatDateTimeForDb(date('Y-m-d'));
    }else{
      $modPasien->tanggal_lahir = $format->formatDateTimeForDb($modPasien->tanggal_lahir);
    }
    $modPasien->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);

    if (empty($modPasien->pasien_id)) {
      $this->is_pasien_baru = true;
      $modPasien->tgl_rekam_medik = date('Y-m-d H:i:s');
      $modPasien->profilrs_id = Params::getDefaultProfilRS();
      $modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;
      $modPasien->ispasienluar = TRUE;
      $modPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $modPasien->create_loginpemakai_id = Yii::app()->user->id;
      $modPasien->create_time = date('Y-m-d H:i:s');
      if($modPasien->is_bukanmanusia = true){
        $modPasien->no_rekam_medik = MyGenerator::noRekamMedikPenunjangBM(Yii::app()->user->getState('mr_lab'));
        $modPasien->jeniskelamin = '-';
        $modPasien->alamat_pasien = '-';
        $modPasien->nama_pasien = $post['nama_pasien_spesimen'];
      }else{
        $modPasien->no_rekam_medik = MyGenerator::noRekamMedikPenunjang(Yii::app()->user->getState('mr_lab'));
      }
      // $modPasien->no_rekam_medik = MyGenerator::noRekamMedikPenunjang(Yii::app()->user->getState('mr_lab'));
    } else {
      $modPasien->update_loginpemakai_id = Yii::app()->user->id;
      $modPasien->update_time = date('Y-m-d H:i:s');
    }
    $modPasien->kelurahan_id = (!empty($modPasien->kelurahan_id) ? $modPasien->kelurahan_id : null);
    $modPasien->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;

    // simpan gambar
    if (isset($post['is_ambilfoto']) && $post['is_ambilfoto'] == 1) {
      $nama_file = "pasien_" . date('YmdHis') . "_" . (str_replace(".", "_", microtime(true))) . ".png";
      $fullImgSource = Params::pathPasienDirectory() . $nama_file;
      $fullThumbSource = Params::pathPasienTumbsDirectory() . 'kecil_' . $nama_file;

      $file = fopen($fullImgSource, "wb");
      $data_foto = explode(",", $modPasien->photopasien);

      fwrite($file, base64_decode($data_foto[1]));
      fclose($file);

      // thumbnail
      Yii::import("ext.EPhpThumb.EPhpThumb");
      $thumb = new EPhpThumb();
      $thumb->init();
      $thumb->create($fullImgSource)
        ->resize(200, 200)
        ->save($fullThumbSource);

      $modPasien->photopasien = $nama_file;
    }

    if (empty($modPasien->create_ruangan)) {
      $modPasien->create_ruangan = Yii::app()->user->getState('ruangan_id');
    }

    if (!is_numeric($modPasien->no_mobile_pasien)) {
      $modPasien->no_mobile_pasien = str_replace("-", "", $modPasien->no_mobile_pasien);
      $modPasien->no_mobile_pasien = trim($modPasien->no_mobile_pasien);
    }
    if (!is_numeric($modPasien->no_telepon_pasien)) {
      $modPasien->no_telepon_pasien = str_replace("-", "", $modPasien->no_telepon_pasien);
      $modPasien->no_telepon_pasien = trim($modPasien->no_telepon_pasien);
    }

    if ($modPasien->save()) {
      $this->pasientersimpan = true;
    }
    // var_dump($modPasien);die;


    return $modPasien;
  }

  /**
   * proses simpan data penanggungjawab pasien
   * @param type $modPenanggungjawab
   * @param type $post
   * @return type
   */
  public function simpanPenanggungjawab($modPenanggungjawab, $post)
  {
    $format = new MyFormatter;
    $modPenanggungjawab->attributes = $post;
    $modPenanggungjawab->tgllahir_pj = $format->formatDateTimeForDb($modPenanggungjawab->tgllahir_pj);

    if ($modPenanggungjawab->save()) {
      $this->penanggungjawabtersimpan = true;
    }
    return $modPenanggungjawab;
  }

  /**
   * proses simpan data rujukan
   * @param type $modRujukan
   * @param type $post
   * @return type
   */
  public function simpanRujukan($modRujukan, $post)
  {
    $format = new MyFormatter();
    $modRujukan->attributes = $post;
    $modRujukan->tanggal_rujukan = $format->formatDateTimeForDb($modRujukan->tanggal_rujukan);

    if ($modRujukan->save()) {
      $this->rujukantersimpan = true;
    }
    return $modRujukan;
  }

  /**
   * simpan asuransi pasien
   * @param type $modAsuransiPasien
   * @param type $postPendaftaran
   * @param type $postPasien
   * @param type $postAsuransiPasien
   * @return type
   */
  public function simpanAsuransiPasien($modAsuransiPasien, $postPendaftaran, $postPasien, $postAsuransiPasien)
  {
    $format = new MyFormatter();
    $modAsuransiPasien->attributes = $postAsuransiPasien;
    $modAsuransiPasien->pasien_id = isset($postPasien['pasien_id']) ? $postPasien['pasien_id'] : null;
    $modAsuransiPasien->penjamin_id = isset($postPendaftaran['penjamin_id']) ? $postPendaftaran['penjamin_id'] : null;
    $modAsuransiPasien->carabayar_id = isset($postPendaftaran['carabayar_id']) ? $postPendaftaran['carabayar_id'] : null;
    $modAsuransiPasien->create_loginpemakai_id = Yii::app()->user->id;
    $modAsuransiPasien->create_time = date("Y-m-d H:i:s");
    $modAsuransiPasien->tgl_konfirmasi = $format->formatDateTimeForDb($modAsuransiPasien->tgl_konfirmasi);
    $modAsuransiPasien->hubkeluarga = isset($postAsuransiPasien['hubkeluarga']) ? $postAsuransiPasien['hubkeluarga'] : '';
    if (empty($postAsuransiPasien['nokartuasuransi'])) {
      $modAsuransiPasien->nokartuasuransi = $modAsuransiPasien->nopeserta;
    }

    if ($modAsuransiPasien->save()) {
      $this->asuransipasientersimpan = true;
    }
    return $modAsuransiPasien;
  }

  /**
   * proses simpan / ubah data pendaftaran
   * @return type
   */
  public function simpanPendaftaran($model, $modPasien, $modRujukan, $modPenanggungJawab, $post, $postPasien, $postPenunjang, $modAsuransiPasien)
  {

    $format = new MyFormatter();
    $model->attributes = $post;
    $model->pendaftaran_id = null;
    $model->pasien_id = $modPasien->pasien_id;
    $model->penanggungjawab_id = $modPenanggungJawab->penanggungjawab_id;
    $model->rujukan_id = $modRujukan->rujukan_id;
    $model->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
    if (empty($model->ruangan_id)) {
      $model->ruangan_id = Yii::app()->user->getState('ruangan_id');
    }
    $model->instalasi_id = (isset($model->ruangan_id) ? RuanganM::model()->findByPk($model->ruangan_id)->instalasi_id : null);
    if (count((array)$postPenunjang) > 0) { //pegawai_id, jeniskasuspenyakit_id, kelaspelayanan_id dari salah satu form pasienmasukpenunjang
      foreach ($postPenunjang as $i => $penunjang) {
        if (!empty($penunjang['pegawai_id'])) {
          $model->pegawai_id = $penunjang['pegawai_id'];
        }
        if (!empty($penunjang['jeniskasuspenyakit_id'])) {
          $model->jeniskasuspenyakit_id = $penunjang['jeniskasuspenyakit_id'];
        }
        if (!empty($penunjang['kelaspelayanan_id'])) {
          $model->kelaspelayanan_id = $penunjang['kelaspelayanan_id'];
        }
      }
    }
    $model->no_urutantri = MyGenerator::noAntrian($model->ruangan_id);
    $model->golonganumur_id = CustomFunction::getGolonganUmur($modPasien->tanggal_lahir);

    // if($modPasien->is_bukanmanusia = true){}else{
      $model->umur = CustomFunction::getUmur($modPasien->tanggal_lahir);
    // }
    $model->kunjungan = CustomFunction::getKunjungan($modPasien, $model->ruangan_id);
    $model->shift_id = Yii::app()->user->getState('shift_id');
    $model->statusmasuk = (!empty($model->rujukan_id) ? Params::STATUSMASUK_RUJUKAN : Params::STATUSMASUK_NONRUJUKAN);
    $model->statuspasien = (empty($postPasien['pasien_id']) ? Params::STATUSPASIEN_BARU : Params::STATUSPASIEN_LAMA);
    $model->statusperiksa = Params::STATUSPERIKSA_ANTRIAN;
    $model->kelompokumur_id = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $model->create_loginpemakai_id = Yii::app()->user->id;
    $model->create_time = date("Y-m-d H:i:s");
    if (Yii::app()->user->getState('tgltransaksimundur') && !empty($model->tgl_pendaftaran)) {
      $model->tgl_pendaftaran = $format->formatDateTimeForDb($model->tgl_pendaftaran);
    } else {
      $model->tgl_pendaftaran = date("Y-m-d H:i:s");
    }
    $model->no_pendaftaran = MyGenerator::noPendaftaran($model->instalasi_id, $model->tgl_pendaftaran);
    $model->tgl_konfirmasi = $format->formatDateTimeForDb($model->tgl_konfirmasi);
    $model->tglselesaiperiksa = $format->formatDateTimeForDb($model->tglselesaiperiksa);
    $model->tglrenkontrol = $format->formatDateTimeForDb($model->tglrenkontrol);
    $model->asuransipasien_id = $modAsuransiPasien->asuransipasien_id;


    if ($model->save()) {
      $this->pendaftarantersimpan = true;
      if (!empty($model->antrian_id)) {
        AntrianT::model()->updateByPk($model->antrian_id, array(
          'pendaftaran_id' => $model->pendaftaran_id,
        ));
      }
    } else {
      // var_dump($model->errors); die;
    }
    return $model;
  }

  /**
   * Fungsi untuk menyimpan data ke model LBPasienmasukpenunjangT
   * @param type $modPendaftaran
   * @param type $modPasien
   * @return LBPasienmasukpenunjangT 
   */
  public function simpanPasienMasukPenunjang($modPasienMasukPenunjang, $modPendaftaran, $post)
  {
    $modPasienMasukPenunjang = new $modPasienMasukPenunjang;
    $modPasienMasukPenunjang->attributes = $modPendaftaran->attributes;
    $modPasienMasukPenunjang->attributes = $post;
    $modPasienMasukPenunjang->perawat_id = (isset($post['perawat_id']) ? $post['perawat_id'] : null);
    $modPasienMasukPenunjang->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $instalasi_id = $modPasienMasukPenunjang->ruangan->instalasi_id;
    $kode_instalasi = InstalasiM::model()->findByPk($instalasi_id)->instalasi_singkatan;
    $modPasienMasukPenunjang->no_masukpenunjang = MyGenerator::noMasukPenunjang($kode_instalasi);
    $modPasienMasukPenunjang->tglmasukpenunjang = date("Y-m-d H:i:s");
    $modPasienMasukPenunjang->no_urutperiksa =  MyGenerator::noAntrianPenunjang($modPasienMasukPenunjang->ruangan_id);
    $modPasienMasukPenunjang->ruanganasal_id = $modPasienMasukPenunjang->ruangan_id;

    if (!empty($modPasienMasukPenunjang->pasienkirimkeunitlain_id)) {
      $kirim = PasienkirimkeunitlainT::model()->findByPk($modPasienMasukPenunjang->pasienkirimkeunitlain_id);
      $modPasienMasukPenunjang->ruanganasal_id = $kirim->create_ruangan;
    }

    $modPasienMasukPenunjang->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modPasienMasukPenunjang->create_loginpemakai_id = Yii::app()->user->id;
    $modPasienMasukPenunjang->create_time = date('Y-m-d H:i:s');

    if (!empty($modPasienMasukPenunjang->pasienkirimkeunitlain_id)) {
      $kirim = PasienkirimkeunitlainT::model()->findByPk($modPasienMasukPenunjang->pasienkirimkeunitlain_id);
      
      $modPasienMasukPenunjang->dokter_perujuk = $kirim->pegawai->namaLengkap;
      
      // var_dump($kirim->attributes);
    } else {
      $modPasienMasukPenunjang->dokter_perujuk = $post['dokter_perujuk'];
    }

    // var_dump( $modPasienMasukPenunjang->attributes, $post['dokter_perujuk']);die;
    // var_dump($modPasienMasukPenunjang->validate());die;
    if ($modPasienMasukPenunjang->validate()) {
      $modPasienMasukPenunjang->save();
      $this->pasienpenunjangtersimpan &= true;
    } else {
      $this->pasienpenunjangtersimpan &= false;
    }

    // var_dump($modPasienMasukPenunjang->attributes); die;

    return $modPasienMasukPenunjang;
  }

  /**
   * simpan LBHasilPemeriksaanLabT
   */
  public function simpanHasilPemeriksaanLab($modPasien, $modPasienMasukPenunjang)
  {
    $modHasilPemeriksaan = new LBHasilPemeriksaanLabT;
    $modHasilPemeriksaan->attributes = $modPasienMasukPenunjang->attributes;
    $modHasilPemeriksaan->nohasilperiksalab = MyGenerator::noHasilPemeriksaanLK();
    $modHasilPemeriksaan->tglhasilpemeriksaanlab = $modPasienMasukPenunjang->tglmasukpenunjang;
    $modHasilPemeriksaan->hasil_kelompokumur = CustomFunction::getKelompokUmur($modPasien->tanggal_lahir);
    $modHasilPemeriksaan->hasil_jeniskelamin = $modPasien->jeniskelamin;
    $modHasilPemeriksaan->statusperiksahasil = Params::STATUSPERIKSAHASIL_BELUM;
    $modHasilPemeriksaan->create_ruangan = $modPasienMasukPenunjang->ruangan_id;
    if ($modHasilPemeriksaan->validate()) {
      $modHasilPemeriksaan->save();
    } else {
      $this->hasilpemeriksaantersimpan &= false;
    }
    return $modHasilPemeriksaan;
  }

  /**
   * proses simpan LBTindakanPelayananT
   */
  public function simpanTindakanPelayanan($modPendaftaran, $modPasienMasukPenunjang, $post, $modTindakan = null)
  {
    if (empty($modTindakan)) {
      $modTindakan = new LBTindakanPelayananT;
    }

    // jika pasien merupakan pasien MCU
    $is_mcu = !$modTindakan->isNewRecord && $modPendaftaran->instalasi_id == Params::INSTALASI_ID_MCU2;
    $old_tarif_satuan = $modTindakan->tarif_satuan;
    
    $modTindakan->attributes = $modPendaftaran->attributes;
    $modTindakan->attributes = $modPasienMasukPenunjang->attributes;
    $modTindakan->pendaftaran_id = $modPendaftaran->pendaftaran_id;
    $modTindakan->kelaspelayanan_id = !empty($modPasienMasukPenunjang->kelaspelayanan_id) ? $modPasienMasukPenunjang->kelaspelayanan_id : Params::KELASPELAYANAN_ID_TANPA_KELAS;
    $modTindakan->attributes = $post;
    $modTindakan->instalasi_id = $modTindakan->ruangan->instalasi_id;
    if (!$is_mcu && empty($modTindakan->tindakansudahbayar_id)) {
      $modTindakan->tarif_satuan = $modTindakan->getTarifSatuan(); //RND-7248
    }

    if ($is_mcu) {
      $modTindakan->tarif_satuan = $old_tarif_satuan;
    }

    $modTindakan->qty_tindakan = (float)$modTindakan->qty_tindakan;
    $modTindakan->karcis_id = (isset($post['karcis_id']) ? $post['karcis_id'] : null);
    if (!empty($modTindakan->karcis_id)) {
      $this->karcistersimpan = true;
      if (isset($post['harga_tariftindakan']) && empty($modTindakan->tindakansudahbayar_id)) { //jika dari form karcis
        if (!empty($post['harga_tariftindakan'])) {
          $modTindakan->tarif_satuan = $post['harga_tariftindakan'];
        }
      }
      $modTindakan->tipepaket_id = $this->tipePaketKarcis($modPendaftaran, $modTindakan->karcis_id, $modTindakan->daftartindakan_id);
    }

    $modTindakan->tarif_satuan = is_numeric($modTindakan->tarif_satuan) ? $modTindakan->tarif_satuan : MyFormatter::formatRupiahForDB($modTindakan->tarif_satuan);
    $modTindakan->tarif_tindakan = $modTindakan->tarif_satuan * $modTindakan->qty_tindakan;

    $modTindakan->create_time = date("Y-m-d H:i:s");
    $modTindakan->create_loginpemakai_id = Yii::app()->user->id;
    $modTindakan->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $modTindakan->shift_id = Yii::app()->user->getState('shift_id');
    $modTindakan->dokterpemeriksa1_id = $modPasienMasukPenunjang->pegawai_id;
    $modTindakan->perawat_id = (!empty($modPasienMasukPenunjang->perawat_id) ? $modPasienMasukPenunjang->perawat_id : null);
    $modTindakan->tgl_tindakan = date('Y-m-d H:i:s');
    if (!empty($_POST['tgl_tindakan_semua'])) {
      $modTindakan->tgl_tindakan = MyFormatter::formatDateTimeForDb($_POST['tgl_tindakan_semua']);
    } else {
      $modTindakan->tgl_tindakan = date('Y-m-d H:i:s');
    }

    if (!$is_mcu) {
      // $modTindakan->cyto_tindakan = 0;
      // $modTindakan->tarifcyto_tindakan = 0;
      if (empty($modTindakan->tindakansudahbayar_id)) {
        $modTindakan->discount_tindakan = 0;
        $modTindakan->subsidiasuransi_tindakan = 0;
        $modTindakan->subsidipemerintah_tindakan = 0;
        $modTindakan->subsisidirumahsakit_tindakan = 0;
        $modTindakan->iurbiaya_tindakan = 0;
        $modTindakan->tarif_rsakomodasi = 0;
        $modTindakan->tarif_medis = 0;
        $modTindakan->tarif_paramedis = 0;
        $modTindakan->tarif_bhp = 0;
      }
      $kirim = PasienkirimkeunitlainT::model()->findByPk($modPasienMasukPenunjang->pasienkirimkeunitlain_id);
      $kelas = empty($kirim) ? $modPasienMasukPenunjang->kelaspelayanan_id : $kirim->kelaspelayanan_id;
      $penjamin = JenistarifpenjaminM::model()->findByAttributes(array('penjamin_id' => $modPendaftaran->penjamin_id));
      $modTarif = TariftindakanM::model()->findByAttributes(array(
        'jenistarif_id' => $penjamin->jenistarif_id,
        'kelaspelayanan_id' => $kelas,
        'daftartindakan_id' => $modTindakan->daftartindakan_id,
        'komponentarif_id' => Params::KOMPONENTARIF_ID_TOTAL
      ));
      if (empty($modTindakan->tindakansudahbayar_id)) {
        if (!empty($kirim)) {
          $modTindakan->cyto_tindakan = $kirim->is_cyto;
        } else {
          $modTindakan->cyto_tindakan = false;
        }

        $modTindakan->tarifcyto_tindakan = !$modTindakan->cyto_tindakan ? "0" : ($modTarif->totaltarifakhir_cyto ?? 0);
        $modTindakan->cyto_tindakan = $modTindakan->cyto_tindakan ?? false;
      }
      // var_dump($modTarif->attributes);
    }

    //var_dump($modTindakan->attributes); die;
    if ($modTindakan->validate()) {
      if ($modTindakan->save()) {
        $this->komponentindakantersimpan &= $modTindakan->saveTindakanKomponen();
      }
    } else {
      $this->tindakanpelayanantersimpan &= false;
    }

    // var_dump($modTindakan->errors,  $modTindakan->attributes);
    // die;
    return $modTindakan;
  }

  /**
   * simpan LBDetailHasilPemeriksaanLabT
   */
  public function simpanDetailHasilPemeriksaanLab($modHasilPemeriksaan, $modTindakan, $post)
  {
    $modDetailHasilPemeriksaans = array();
    $date1 = new DateTime($modTindakan->pendaftaran->tgl_pendaftaran);
    $date2 = new DateTime($modTindakan->pasien->tanggal_lahir);

    $dateDiff = $date2->diff($date1);

    $umurhari = $dateDiff->days;
    $umurbulan = $dateDiff->m + ($dateDiff->y * 12);
    $umurtahun = $dateDiff->y;

    $criteria = new CDbCriteria();
    $criteria->addCondition('pemeriksaanlab_id = ' . $post['pemeriksaanlab_id']);
    $criteria->addCondition("((lower(trim(satuankelumur)) = 'hr' and " . $umurhari . " between umurminlab and umurmakslab) "
      . "or (lower(trim(satuankelumur)) = 'bln' and " . $umurbulan . " between umurminlab and umurmakslab) "
      . "or (lower(trim(satuankelumur)) = 'thn' and " . $umurtahun . " between umurminlab and umurmakslab))");
    $criteria->compare('LOWER(nilairujukan_jeniskelamin)', strtolower($modHasilPemeriksaan->pasien->jeniskelamin), true);
    $criteria->order = 'pemeriksaanlabdet_nourut ASC';

    $modPemeriksaanLadDet = PemeriksaanlabdetV::model()->findAll($criteria);
    
    // var_dump(count($modPemeriksaanLadDet));
    if (count((array)$modPemeriksaanLadDet) > 0) {
      foreach ($modPemeriksaanLadDet as $i => $pemeriksaanDet) {
        $modDetailHasilPemeriksaans[$i] = new LBDetailHasilPemeriksaanLabT;
        $modDetailHasilPemeriksaans[$i]->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
        $modDetailHasilPemeriksaans[$i]->pemeriksaanlabdet_id = $pemeriksaanDet->pemeriksaanlabdet_id;
        $modDetailHasilPemeriksaans[$i]->pemeriksaanlab_id = $pemeriksaanDet->pemeriksaanlab_id;
        $modDetailHasilPemeriksaans[$i]->hasilpemeriksaanlab_id = $modHasilPemeriksaan->hasilpemeriksaanlab_id;
        $modDetailHasilPemeriksaans[$i]->nilairujukan = $pemeriksaanDet->nilairujukan_nama;
        $modDetailHasilPemeriksaans[$i]->hasilpemeriksaan_satuan = $pemeriksaanDet->nilairujukan_satuan;
        $modDetailHasilPemeriksaans[$i]->hasilpemeriksaan_metode = $pemeriksaanDet->nilairujukan_metode;
        $modDetailHasilPemeriksaans[$i]->create_time = date("Y-m-d H:i:s");
        $modDetailHasilPemeriksaans[$i]->create_loginpemakai_id = Yii::app()->user->id;
        $modDetailHasilPemeriksaans[$i]->create_ruangan = $modHasilPemeriksaan->create_ruangan;
        // /* 
        if ($modDetailHasilPemeriksaans[$i]->validate()) {
          $modDetailHasilPemeriksaans[$i]->save();
          if ($i == 0) {
            $modTindakan->detailhasilpemeriksaanlab_id = null;
          }
          if (empty($modTindakan->detailhasilpemeriksaanlab_id)) {
            $modTindakan->detailhasilpemeriksaanlab_id = $modDetailHasilPemeriksaans[$i]->detailhasilpemeriksaanlab_id;
            $modTindakan->save(false, array('detailhasilpemeriksaanlab_id'));
          }
        } else {
          $this->hasilpemeriksaantersimpan &= false;
        } 
        // */
      }
    }
    return $modDetailHasilPemeriksaans;
  }

  /**
   * simpan LBHasilPemeriksaanPAT
   */
  public function simpanHasilPemeriksaanPA($modPasienMasukPenunjang, $modTindakan, $post)
  {
    $modHasilPemeriksaanPA = new LBHasilPemeriksaanPAT;
    $modHasilPemeriksaanPA->attributes = $modPasienMasukPenunjang->attributes;
    $modHasilPemeriksaanPA->tindakanpelayanan_id = $modTindakan->tindakanpelayanan_id;
    $modHasilPemeriksaanPA->pemeriksaanlab_id = $post['pemeriksaanlab_id'];
    // $modHasilPemeriksaanPA->nosediaanpa = $post['nosediaanpa'];//MyGenerator::noSediaanPA();
    $modHasilPemeriksaanPA->tglperiksapa = $modPasienMasukPenunjang->tglmasukpenunjang;
    $modHasilPemeriksaanPA->create_time = date("Y-m-d H:i:s");
    $modHasilPemeriksaanPA->create_loginpemakai_id = Yii::app()->user->id;
    $modHasilPemeriksaanPA->create_ruangan = $modPasienMasukPenunjang->ruangan_id;
    // var_dump($modHasilPemeriksaanPA);die;
    if ($modHasilPemeriksaanPA->validate()) {
      $modHasilPemeriksaanPA->save();
      $modTindakan->hasilpemeriksaanpa_id = $modHasilPemeriksaanPA->hasilpemeriksaanpa_id;
      $modTindakan->update();
    } else {
      $this->hasilpemeriksaantersimpan = false;
    }

    return $modHasilPemeriksaanPA;
  }

  /**
   * Fungsi untuk menyimpan data ke model LBPengambilanSampleT
   */
  public function simpanPengambilanSample($modPasienMasukPenunjang, $post)
  {
    $modPengambilanSample = new LBPengambilanSampleT;
    $modPengambilanSample->attributes = $post;
    $modPengambilanSample->tglpengambilansample = $modPasienMasukPenunjang->tglmasukpenunjang;
    $modPengambilanSample->pasienmasukpenunjang_id = $modPasienMasukPenunjang->pasienmasukpenunjang_id;
    $modPengambilanSample->no_pengambilansample = MyGenerator::noPengambilanSample($modPengambilanSample->alatmedis_id);
    if ($modPengambilanSample->validate()) {
      $modPengambilanSample->save();
      $this->pengambilansampletersimpan &= true;
    } else {
      $this->pengambilansampletersimpan &= false;
    }

    return $modPengambilanSample;
  }


  /**
   * menentukan tipepaket_id
   * @param type $modPendaftaran
   * @param type $karcis_id
   * @param type $idTindakan
   * @return type
   */
  public function tipePaketKarcis($modPendaftaran, $karcis_id, $tindakan_id)
  {
    $criteria = new CDbCriteria;
    $criteria->with = array('tipepaket');
    if (!empty($tindakan_id)) {
      $criteria->addCondition('daftartindakan_id = ' . $tindakan_id);
    }
    if (!empty($modPendaftaran->carabayar_id)) {
      $criteria->addCondition('tipepaket.carabayar_id = ' . $modPendaftaran->carabayar_id);
    }
    if (!empty($modPendaftaran->penjamin_id)) {
      $criteria->addCondition('tipepaket.penjamin_id = ' . $modPendaftaran->penjamin_id);
    }
    if (!empty($modPendaftaran->kelaspelayanan_id)) {
      $criteria->addCondition('tipepaket.kelaspelayanan_id = ' . $modPendaftaran->kelaspelayanan_id);
    }
    $paket = PaketpelayananM::model()->find($criteria);
    $result = Params::TIPEPAKET_ID_NONPAKET;
    if (isset($paket)) $result = $paket->tipepaket_id;

    return $result;
  }


  /**
   * Set Tanggal, Wilayah, dan Jenis Kelamin berdasarkan No KTP
   */
  public function actionInputDariNoKTP()
  {
      if (!Yii::app()->request->isAjaxRequest) {
          Yii::app()->end();
      }
      $no_ktp = $_POST['no_ktp'];
      $str_lens = strlen($no_ktp);
      $res = array(
          'propinsi_id' => null,
          'kabupaten_id' => null,
          'kecamatan_id' => null,
          'tanggal_lahir' => null,
          'tanggal_lahir_format' => null,
          'jeniskelamin' => '',
      );
      if ($str_lens >= 2) {
          $prop = PropinsiM::model()->findByAttributes(array(
              'kode_propinsi' => substr($no_ktp, 0, 2),
          ));
          if (!empty($prop)) {
              $res['propinsi_id'] = $prop->propinsi_id;
              if ($str_lens >= 4) {
                  $kab = KabupatenM::model()->findByAttributes(array(
                      'propinsi_id' => $prop->propinsi_id,
                      'kode_kabupaten' => substr($no_ktp, 2, 2),
                  ));
                  if (!empty($kab)) {
                      $res['kabupaten_id'] = $kab->kabupaten_id;
                      if ($str_lens >= 6) {
                          $kec = KecamatanM::model()->findByAttributes(array(
                              'kabupaten_id' => $kab->kabupaten_id,
                              'kode_kecamatan' => substr($no_ktp, 4, 2),
                          ));
                          if (!empty($kec)) {
                              $res['kecamatan_id'] = $kec->kecamatan_id;
                          }
                      }
                  }
              }
          }
      }
      if ($str_lens >= 12) {
          $str_tgl = substr($no_ktp, 6, 6);
          $tgl = substr($str_tgl, 0, 2);
          $bln = substr($str_tgl, 2, 2);
          $thn = substr($str_tgl, 4, 2);
          $thn_min = "19" . $thn;
          $thn_max = "20" . $thn;
          $thn_real = $thn_max;
          if (($thn_real) > date('Y')) {
              $thn_real = $thn_min;
          }
          $bln = ((int)$bln > 12) ? "01" : $bln;
          $hari_limit = date('t', strtotime($thn_real . "-" . $bln . "-01"));
          $tgl_true = (int)$tgl - 40;
          if ($tgl_true < 0) {
              $tgl_true = $tgl;
          } else if ($tgl_true < 10 && $tgl_true > 0) {
              $tgl_true = '0' . $tgl_true;
          }
          $tgl_true = ($tgl_true > $hari_limit) ? "01" : $tgl_true;
          $res['tanggal_lahir'] = $thn_real . "-" . $bln . "-" . $tgl_true;
          $res['tanggal_lahir_format'] = $tgl_true . "/" . $bln . "/" . $thn_real;
          // jenis kelamin
          $res_jk = (int)$tgl - 40;
          if ($res_jk < 0) {
              $res['jeniskelamin'] = 'LAKI-LAKI';
          } else {
              $res['jeniskelamin'] = 'PEREMPUAN';
          }
      }
      echo CJSON::encode($res);
  }



  /**
   * set umur dari tanggal lahir (date)
   */
  public function actionSetUmur()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data['umur'] = null;
      if (isset($_POST['tanggal_lahir']) && !empty($_POST['tanggal_lahir'])) {
        $data['umur'] = CustomFunction::hitungUmur($_POST['tanggal_lahir']);
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }
  /**
   * set dropdown dokter
   */
  public function actionSetDropdownDokter()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $model = new LBPendaftaranT;
      $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      if (!empty($_POST['ruangan_id'])) {
        $data = $model->getDokterItems($_POST['ruangan_id']);
        $data = CHtml::listData($data, 'pegawai_id', 'NamaLengkap');
        foreach ($data as $value => $name) {
          $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      }
      $dataList['listDokter'] = $option;
      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  /**
   * set dropdown jenis kasus penyakit
   */
  public function actionSetDropdownJeniskasuspenyakit()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $model = new LBPendaftaranT;
      $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      if (!empty($_POST['ruangan_id'])) {
        $data = $model->getJenisKasusPenyakitItems($_POST['ruangan_id']);
        $data = CHtml::listData($data, 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama');
        foreach ($data as $value => $name) {
          $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      }
      $dataList['listKasuspenyakit'] = $option;
      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  /**
   * set dropdown penjamin pasien dari carabayar_id
   * @param type $encode
   * @param type $namaModel
   */
  public function actionSetDropdownPenjaminPasien($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $carabayar_id = $_POST["$namaModel"]['carabayar_id'];
      if ($encode) {
        echo CJSON::encode($penjamin);
      } else {
        if (empty($carabayar_id)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $carabayar_id, 'penjamin_aktif' => true), array('order' => 'penjamin_nama ASC'));
          if (count((array)$penjamin) > 1) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          }
          $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
          foreach ($penjamin as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * set antrian ruangan
   */
  public function actionSetAntrianRuangan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = $_POST['ruangan_id'];
      $data = array();
      $data['maxantrianruangan'] = null;
      $data['no_urutantri'] = '001';
      if (!empty($ruangan_id)) {
        $data['no_urutantri'] = MyGenerator::noAntrian($ruangan_id);
        $criteria = new CDbCriteria;
        if (!empty($ruangan_id)) {
          $criteria->addCondition('ruangan_id = ' . $ruangan_id);
        }
        $modJadwalBukaPoli = JadwalbukapoliM::model()->findAll($criteria);
        if (count((array)$modJadwalBukaPoli) > 0) {
          foreach ($modJadwalBukaPoli as $key => $antrian) {
            $data['maxantrianruangan'] = $antrian->maxantiranpoli;
          }
        }
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }
  /**
   * set antrian dokter
   */
  public function actionSetAntrianDokter()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = $_POST['ruangan_id'];
      $pegawai_id = $_POST['pegawai_id'];
      $data = array();
      $data['maxantriandokter'] = 0;
      if (!empty($ruangan_id) && !empty($pegawai_id)) {
        $criteria = new CDbCriteria;
        if (!empty($ruangan_id)) {
          $criteria->addCondition('ruangan_id = ' . $ruangan_id);
        }
        if (!empty($pegawai_id)) {
          $criteria->addCondition('pegawai_id = ' . $pegawai_id);
        }
        $modJadwalDokter = JadwaldokterM::model()->findAll($criteria);
        if (count((array)$modJadwalDokter) > 0) {
          foreach ($modJadwalDokter as $key => $antrian) {
            $data['maxantriandokter'] = $antrian->maximumantrian;
          }
        }
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }
  /**
   * menampilkan karcis
   */
  public function actionSetKarcis()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $form_index = $_POST['form_index'];
      $kelaspelayanan_id = $_POST['kelaspelayanan_id'];
      $ruangan_id = $_POST['ruangan_id'];
      $pasien_id = $_POST['pasien_id'];
      $penjamin_id = $_POST['penjamin_id'];
      $form = '';
      $is_pasienbaru = 'true';
      if (!empty($pasien_id)) {
        $modPasien = PasienM::model()->findByPk($pasien_id);
        if (isset($modPasien)) {
          $is_pasienbaru = ($modPasien->statusrekammedis == Params::STATUSREKAMMEDIS_AKTIF) ? 'false' : 'true';
        }
      }
      $criteria = new CdbCriteria();
      $criteria->addCondition("kelaspelayanan_id = " . $kelaspelayanan_id);
      $criteria->addCondition("ruangan_id = " . $ruangan_id);
      $criteria->addCondition("penjamin_id = " . $penjamin_id);

      $modKarcisAll = LBKarcisV::model()->findAll($criteria);

      if (Yii::app()->user->getState('karcisbarulama')) { //RND-7737
        $criteria->addCondition("pasienbaru_karcis = $is_pasienbaru");
      }

      $modKarcis = LBKarcisV::model()->findAll($criteria);

      // susun karcis global
      $modKarcisFinal = array();
      $modKarcisAda = array();
      foreach ($modKarcisAll as $item) {
        if (empty($modKarcisAda[$item->daftartindakan_id])) {
          $modKarcisAda[$item->daftartindakan_id] = 1;
          $modKarcisFinal[] = $item;
        }
      }

      $form = $this->renderPartial($this->path_view . '_formKarcis', array('i' => $form_index, 'modKarcisAll' => $modKarcisFinal, 'modKarcis' => $modKarcis), true);
      $data['listKarcis'][$form_index] = $form;
      echo json_encode($data);
      Yii::app()->end();
    }
  }
  /**
   * set tabel riwayat kunjungan pasien
   */
  public function actionSetRiwayatKunjunganPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['table'] = "";
      $modPasien = new LBPasienM;
      $modPasien->pasien_id = $_POST['pasien_id'];
      $data['table'] = $this->renderPartial($this->path_view . '_tableRiwayatPasien', array(
        'modPasien' => $modPasien,
      ), true);
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * untuk menampilkan pasien lama dari autocomplete
   * 1. no_rekam_medik
   * 2. no_identitas_pasien
   * 3. nama_pasien
   * 4. nama_bin (alias)
   */
  public function actionAutocompletePasienLama()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
      $no_identitas_pasien = isset($_GET['no_identitas_pasien']) ? $_GET['no_identitas_pasien'] : null;
      $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
      $tanggal_lahir = isset($_GET['tanggal_lahir']) ? $format->formatDateTimeForDb($_GET['tanggal_lahir']) : null;
      $no_badge = isset($_GET['nomorindukpegawai']) ? $_GET['nomorindukpegawai'] : null;

      if (empty($no_badge)) {

        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
        $criteria->compare('LOWER(no_identitas_pasien)', strtolower($no_identitas_pasien), true);
        $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
        $criteria->compare('tanggal_lahir', $tanggal_lahir);
        $criteria->compare('ispasienluar', true);
        $criteria->order = 'no_rekam_medik, nama_pasien';
        $criteria->limit = 5;
        $models = PasienM::model()->findAll($criteria);
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
          $returnVal[$i]['label'] = $model->no_rekam_medik . ' - '.$model->no_identitas_pasien. ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "") . " - " . $format->formatDateTimeForUser($model->tanggal_lahir);
          $returnVal[$i]['value'] = $model->no_rekam_medik;
        }
      } else {

        $criteria = new CDbCriteria();
        $criteria->compare('LOWER(pegawai_m.nomorindukpegawai)', strtolower($no_badge), true);
        $criteria->join = "JOIN pegawai_m ON t.pegawai_id = pegawai_m.pegawai_id";
        $criteria->order = 'pegawai_m.nomorindukpegawai, t.nama_pasien';
        $criteria->limit = 50;
        $models = PPPasienM::model()->findAll($criteria);
        foreach ($models as $i => $model) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $returnVal[$i]["$attribute"] = $model->$attribute;
          }
          $returnVal[$i]['label'] = $model->pegawai->nomorindukpegawai .
            ' - ' . $model->no_rekam_medik .
            ' - ' . $model->nama_pasien .
            ' - (' . $model->pegawai->nama_pegawai .
            ') - ' . $format->formatDateTimeForUser($model->tanggal_lahir);
          $returnVal[$i]['value'] = $model->no_rekam_medik;
        }
      }

      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  /**
   * Mengurai data pasien berdasarkan pasien_id
   * @throws CHttpException
   */
  public function actionGetDataPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null;
      $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
      $returnVal = array();
      if (!empty($pasien_id)) {
        $pendaftaran = PendaftaranT::model()->findByAttributes(array(
          'pasien_id' => $pasien_id,
        ), array(
          'condition' => 'pasienbatalperiksa_id is null'
        ));
        if (empty($pendafaran)) {
          $pendaftaran = PendaftaranT::model()->findByAttributes(array(
            'pasien_id' => $pasien_id,
          ), array(
            'condition' => 'pasienbatalperiksa_id is null',
            'order' => 'tgl_pendaftaran desc',
          ));
        }
      } else if (!empty($no_rekam_medik)) {
        //var_dump($no_rekam_medik); die; 
        $p = PasienM::model()->findByAttributes(array('no_rekam_medik' => trim($no_rekam_medik)));
        //var_dump($p->pasien_id); die;
        $pendaftaran = PendaftaranT::model()->findByAttributes(array(
          'pasien_id' => $p->pasien_id,
        ), array(
          'condition' => 'pasienbatalperiksa_id is null',
          'order' => 'pendaftaran_id desc',
        ));
        if (empty($pendafaran)) {
          $pendaftaran = PendaftaranT::model()->findByAttributes(array(
            'pasien_id' => $p->pasien_id,
          ), array(
            'condition' => 'pasienbatalperiksa_id is null',
            'order' => 'tgl_pendaftaran desc',
          ));
        }
      } else {
        $pendaftaran = null;
      }



      $returnVal['lebih'] = false;
      $returnVal['adaDaftar'] = false;

      $pp = null;
      if (!empty($pendaftaran)) {
        $returnVal['listDaftar'] = $pendaftaran->attributes;
        $returnVal['listDaftar']['pasien'] = $pendaftaran->pasien;
        $returnVal['listDaftar']['ruangan'] = $pendaftaran->ruangan;
        $returnVal['listDaftar']['instalasi'] = $pendaftaran->ruangan->instalasi;

        $admisi = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);
        $pp = PasienadmisiT::model()->findByPk($pendaftaran->pasienadmisi_id);

        // if (!empty($admisi)) {
        //   $this->periksaValidasiPasienRI($pendaftaran, $admisi, $pp, $returnVal);
        // } else {

        //   $con = new PendaftaranRawatJalanController('index');

        //   //var_dump($pendaftaran->attributes);die;
        //   switch ($pendaftaran->instalasi_id) {
        //     case Params::INSTALASI_ID_RJ:
        //       $con->periksaValidasiPasienRJ($pendaftaran, $admisi, $pp, $returnVal);
        //       break;
        //     case Params::INSTALASI_ID_MCU:
        //       $con->periksaValidasiPasienRJ($pendaftaran, $admisi, $pp, $returnVal);
        //       break;
        //     case Params::INSTALASI_ID_HD:
        //       $con->periksaValidasiPasienRJ($pendaftaran, $admisi, $pp, $returnVal);
        //       break;
        //     case Params::INSTALASI_ID_RD:
        //       $con->periksaValidasiPasienRD($pendaftaran, $admisi, $pp, $returnVal);
        //       break;
        //     case Params::INSTALASI_ID_RI:
        //       $con->periksaValidasiPasienRI($pendaftaran, $admisi, $pp, $returnVal);
        //       break;
        //     case Params::INSTALASI_ID_ICU:
        //       $con->periksaValidasiPasienRI($pendaftaran, $admisi, $pp, $returnVal);
        //       break;
        //     default:
        //       $con->periksaValidasiPasienPenunjang($pendaftaran, $admisi, $pp, $returnVal);
        //       break;
        //   }
        // }
        //die;
      }


      $criteria = new CDbCriteria();
      if (!empty($pasien_id)) {
        $criteria->addCondition('pasien_id = ' . $pasien_id);
      }
      if (!empty($no_rekam_medik)) {
        $criteria->compare('no_rekam_medik', $no_rekam_medik);
      }
      $model = PasienM::model()->find($criteria);
      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      $returnVal["fingerprint_data"] = null;
      $returnVal["tanggal_lahir"] = date("d/m/Y", strtotime($model->tanggal_lahir));
      if (!empty($model->pegawai_id)) {
        $returnVal['nomorindukpegawai'] = $model->pegawai->nomorindukpegawai;
        $returnVal['nama_pegawai'] = $model->pegawai->nama_pegawai;
        $returnVal['gelardepan'] = $model->pegawai->gelardepan;
        $returnVal['unit_perusahaan'] = $model->pegawai->unit_perusahaan;
        $returnVal['gelarbelakang_nama'] = isset($model->pegawai->gelarbelakang->gelarbelakang_nama) ? $model->pegawai->gelarbelakang->gelarbelakang_nama : "";
        $returnVal['jabatan_nama'] = isset($model->pegawai->jabatan->jabatan_nama) ? $model->pegawai->jabatan->jabatan_nama : "";
        $returnVal["nomorindukpegawai"] = $model->pegawai->nomorindukpegawai;
      }
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
  /**
   * Mengatur dropdown kabupaten
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownKabupaten($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPasien = new LBPasienM;
      if ($model_nama !== '' && $attr == '') {
        $propinsi_id = $_POST["$model_nama"]['propinsi_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $propinsi_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $propinsi_id = $_POST["$model_nama"]["$attr"];
      }
      $kabupaten = null;
      if ($propinsi_id) {
        $kabupaten = $modPasien->getKabupatenItems($propinsi_id);
        $kabupaten = CHtml::listData($kabupaten, 'kabupaten_id', 'kabupaten_nama');
      }
      if ($encode) {
        echo CJSON::encode($kabupaten);
      } else {
        if (empty($kabupaten)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($kabupaten as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }
  /**
   * Mengatur dropdown kecamatan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownKecamatan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPasien = new LBPasienM;
      if ($model_nama !== '' && $attr == '') {
        $kabupaten_id = $_POST["$model_nama"]['kabupaten_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $kabupaten_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $kabupaten_id = $_POST["$model_nama"]["$attr"];
      }
      $kecamatan = null;
      if ($kabupaten_id) {
        $kecamatan = $modPasien->getKecamatanItems($kabupaten_id);
        $kecamatan = CHtml::listData($kecamatan, 'kecamatan_id', 'kecamatan_nama');
      }

      if ($encode) {
        echo CJSON::encode($kecamatan);
      } else {
        if (empty($kecamatan)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($kecamatan as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }
  /**
   * Mengatur dropdown kelurahan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownKelurahan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modPasien = new LBPasienM;
      if ($model_nama !== '' && $attr == '') {
        $kecamatan_id = $_POST["$model_nama"]['kecamatan_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $kecamatan_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $kecamatan_id = $_POST["$model_nama"]["$attr"];
      }
      $kelurahan = null;
      if ($kecamatan_id) {
        $kelurahan = $modPasien->getKelurahanItems($kecamatan_id);
        //                    $kelurahan = KelurahanM::model()->findAll('kecamatan_id='.$kecamatan_id.'');
        $kelurahan = CHtml::listData($kelurahan, 'kelurahan_id', 'kelurahan_nama');
      }

      if ($encode) {
        echo CJSON::encode($kelurahan);
      } else {
        if (empty($kelurahan)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($kelurahan as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * set dropdown daerah pasien berdasarkan
   * propinsi_id
   * kabupaten_id
   * kecamatan_id
   * kelurahan_id
   * pasien_id
   */
  public function actionSetDropdownDaerahPasien()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $modPasien = new PPPasienM;
      $propinsi_id = $_POST['propinsi_id'];
      $kabupaten_id = $_POST['kabupaten_id'];
      $kecamatan_id = $_POST['kecamatan_id'];
      $kelurahan_id = (isset($_POST['kelurahan_id']) ? $_POST['kelurahan_id'] : null);

      $propinsis = PropinsiM::model()->findAll('propinsi_aktif = TRUE');
      $propinsis = CHtml::listData($propinsis, 'propinsi_id', 'propinsi_nama');
      $propinsiOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
      foreach ($propinsis as $value => $name) {
        if ($value == $propinsi_id)
          $propinsiOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $propinsiOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }

      if (empty($propinsi_id)) {
        $kabupatens = array();
      } else {
        $kabupatens = $modPasien->getKabupatenItems($propinsi_id);
        //                $kabupatens = KabupatenM::model()->findAllByAttributes(array('propinsi_id'=>$propinsi_id,'kabupaten_aktif'=>true,));
        $kabupatens = CHtml::listData($kabupatens, 'kabupaten_id', 'kabupaten_nama');
      }

      $kabupatenOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
      foreach ($kabupatens as $value => $name) {
        if ($value == $kabupaten_id)
          $kabupatenOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $kabupatenOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }


      if (empty($kabupaten_id)) {
        $kecamatans = array();
      } else {
        $kecamatans = $modPasien->getKecamatanItems($kabupaten_id);
        //                $kecamatans = KecamatanM::model()->findAllByAttributes(array('kabupaten_id'=>$kabupaten_id,'kecamatan_aktif'=>true,));
        $kecamatans = CHtml::listData($kecamatans, 'kecamatan_id', 'kecamatan_nama');
      }
      $kecamatanOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
      foreach ($kecamatans as $value => $name) {
        if ($value == $kecamatan_id)
          $kecamatanOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $kecamatanOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }

      if (empty($kecamatan_id)) {
        $kelurahans = array();
      } else {
        $kelurahans = $modPasien->getKelurahanItems($kecamatan_id);
        $kelurahans = CHtml::listData($kelurahans, 'kelurahan_id', 'kelurahan_nama');
      }

      $kelurahanOption = CHtml::tag('option', array('value' => ''), "-- Pilih --", true);
      foreach ($kelurahans as $value => $name) {
        if ($value == $kelurahan_id)
          $kelurahanOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $kelurahanOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }

      $dataList['listPropinsi'] = $propinsiOption;
      $dataList['listKabupaten'] = $kabupatenOption;
      $dataList['listKecamatan'] = $kecamatanOption;
      $dataList['listKelurahan'] = $kelurahanOption;

      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  /**
   * set tanggal lahir dari umur (__ Thn __ Bln __ Hr)
   */
  public function actionSetTanggalLahir()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data['tanggal_lahir'] = date("d/m/Y", strtotime(CustomFunction::getTanggalUmur($_POST['umur'])));

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * untuk drop down rujukan
   */
  public function actionGetRujukanDari($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $asalrujukan_id = $_POST["$namaModel"]['asalrujukan_id'];

      if ($encode) {
        echo CJSON::encode($rujukandari);
      } else {
        if (empty($asalrujukan_id)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          $rujukandari = RujukandariM::model()->findAllByAttributes(array('asalrujukan_id' => $asalrujukan_id), array('order' => 'namaperujuk'));
          $rujukandari = CHtml::listData($rujukandari, 'rujukandari_id', 'namaperujuk');
          foreach ($rujukandari as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model =  LBPendaftaranT::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }



  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'lkpendaftaran-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  /**
   * set checklist pemeriksaan lab
   */
  public function actionSetChecklistPemeriksaanLab()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $content = "";
      parse_str($_POST['data'], $post);
      $postPemeriksaan = $post['LBTarifpemeriksaanlabruanganV'];

      // tarif radiologi antar kelas sama
      $postPemeriksaan['kelaspelayanan_id'] = Params::KELASPELAYANAN_ID_TANPA_KELAS;

      if (!empty($postPemeriksaan['ruangan_id']) && !empty($postPemeriksaan['kelaspelayanan_id']) && !empty($postPemeriksaan['penjamin_id'])) {
        $criteria = new CdbCriteria();
        $criteria->addCondition('ruangan_id = ' . $postPemeriksaan['ruangan_id']);
        $criteria->addCondition('kelaspelayanan_id = ' . $postPemeriksaan['kelaspelayanan_id']);
        $criteria->addCondition('penjamin_id = ' . $postPemeriksaan['penjamin_id']);
        $criteria->compare('LOWER(jenispemeriksaanlab_nama)', strtolower($postPemeriksaan['jenispemeriksaanlab_nama']), true);
        $criteria->compare('LOWER(pemeriksaanlab_nama)', strtolower($postPemeriksaan['pemeriksaanlab_nama']), true);
        $jeniswaktukerja = null;

        if (!empty($postPemeriksaan['pegawai_id'])) {
          $peg = PegawaiM::model()->findByPk($postPemeriksaan['pegawai_id']);
          $jeniswaktukerja = ((!empty($peg)) ? $peg->jeniswaktukerja : null);
        }
        $criteria->compare("jeniswaktukerja" , ((!empty($jeniswaktukerja)) ? $jeniswaktukerja : null), false);
        
        $criteria->order = "jenispemeriksaanlab_urutan, pemeriksaanlab_urutan";
        $modPemeriksaanlabs = LBTarifpemeriksaanlabruanganV::model()->findAll($criteria);
        $content = $this->renderPartial($this->path_view . '_checklistPemeriksaanLab', array('modPemeriksaanlabs' => $modPemeriksaanlabs), true);
      }
      echo CJSON::encode(array(
        'content' => $content
      ));
      Yii::app()->end();
    }
  }

  /**
   * Autocomplete Asuransi
   * @throws CHttpException
   */
  public function actionAutocompleteAsuransi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $nopeserta = isset($_GET['nopeserta']) ? $_GET['nopeserta'] : '';
      $penjamin_id = isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null;
      $pasien_id = isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nopeserta)', strtolower($nopeserta), true);
      $criteria->addCondition('penjamin_id=' . $penjamin_id);
      $criteria->addCondition('asuransipasien_aktif is true');
      if ($_GET['pasien_id'] == "") {
        $criteria->addCondition('pasien_id is null');
      } else {
        $criteria->addCondition('pasien_id=' . $pasien_id);
      }
      $criteria->order = 'namapemilikasuransi';
      $criteria->limit = 5;
      $models = LBAsuransipasienM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nopeserta . ' - ' . $model->namapemilikasuransi;
        $returnVal[$i]['value'] = $model->nopeserta;
        $returnVal[$i]['asuransipasien_id'] = $model->asuransipasien_id;
        $returnVal[$i]['nokartuasuransi'] = $model->nokartuasuransi;
        $returnVal[$i]['namapemilikasuransi'] = $model->namapemilikasuransi;
        $returnVal[$i]['jenispeserta_id'] = $model->jenispeserta_id;
        $returnVal[$i]['nomorpokokperusahaan'] = $model->nomorpokokperusahaan;
        $returnVal[$i]['namaperusahaan'] = $model->namaperusahaan;
        $returnVal[$i]['kelastanggunganasuransi_id'] = $model->kelastanggunganasuransi_id;
      }


      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  public function actionAutocompleteAsuransiKartu()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $nokartuasuransi = isset($_GET['nokartuasuransi']) ? $_GET['nokartuasuransi'] : '';
      $penjamin_id = isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null;
      $pasien_id = isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nokartuasuransi)', strtolower($nokartuasuransi), true);
      $criteria->addCondition('penjamin_id=' . $penjamin_id);
      if ($_GET['pasien_id'] == "") {
        $criteria->addCondition('pasien_id is null');
      } else {
        $criteria->addCondition('pasien_id=' . $pasien_id);
      }
      $criteria->order = 'namapemilikasuransi';
      $criteria->limit = 5;
      $models = LBAsuransipasienM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nokartuasuransi . ' - ' . $model->namapemilikasuransi;
        $returnVal[$i]['value'] = $model->nokartuasuransi;
        $returnVal[$i]['asuransipasien_id'] = $model->asuransipasien_id;
        $returnVal[$i]['nopeserta'] = $model->nopeserta;
        $returnVal[$i]['namapemilikasuransi'] = $model->namapemilikasuransi;
        $returnVal[$i]['jenispeserta_id'] = $model->jenispeserta_id;
        $returnVal[$i]['nomorpokokperusahaan'] = $model->nomorpokokperusahaan;
        $returnVal[$i]['namaperusahaan'] = $model->namaperusahaan;
        $returnVal[$i]['kelastanggunganasuransi_id'] = $model->kelastanggunganasuransi_id;
      }


      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  /**
   * menampilkan data asuransi terakhir pasien
   * @throws CHttpException
   */
  public function actionSetAsuransiPasienLama()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data = array();
      $criteria = new CDbCriteria();
      $criteria->addCondition("pasien_id = " . $_POST['pasien_id']);
      $criteria->order = 'asuransipasien_id DESC';
      $model = AsuransipasienM::model()->find($criteria);
      $data["penjamin_nama"] = '';
      if ($model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $data["$attribute"] = $model->$attribute;
        }
        $data["penjamin_nama"] = $model->penjamin->penjamin_nama;
        $data['listPenjamin'] = "";
        $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $model->carabayar_id, 'penjamin_aktif' => true), array('order' => 'penjamin_nama ASC'));
        if (count((array)$penjamin) > 1) {
          $data['listPenjamin'] .= CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        }
        $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
        foreach ($penjamin as $value => $name) {
          $data['listPenjamin'] .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      }
      echo CJSON::encode($data);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }
  /**
   * @param type $pendaftaran_id
   */
  public function actionPrintStatusLab($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = $this->loadModel($pendaftaran_id);
    $modAdmisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modPasien = LBPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modTindakans = array();
    $criteria1 = new CdbCriteria();
    $criteria1->addCondition('pendaftaran_id = ' . $modPendaftaran->pendaftaran_id);
    $criteria1->order = "pendaftaran_id DESC, pasienmasukpenunjang_id DESC";
    $criteria1->addCondition('ruangan_id <> ' . Params::RUANGAN_ID_LAB_ANATOMI);
    $loadPasienMasukPenunjangs[0] = LBPasienmasukpenunjangT::model()->find($criteria1);
    if (isset($loadPasienMasukPenunjangs[0])) {
      $modPasienMasukPenunjangs[0] = $loadPasienMasukPenunjangs[0];
      $modTindakans[0] = LBTindakanPelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $modPasienMasukPenunjangs[0]->pasienmasukpenunjang_id), "karcis_id is not null");
      $criteria_daf = new CdbCriteria();
      $criteria_daf->addCondition("karcis_id IS NULL");
      $criteria_daf->addCondition("pasienmasukpenunjang_id = " . $modPasienMasukPenunjangs[0]->pasienmasukpenunjang_id);
      $daftartindakan[0] = LBTindakanPelayananT::model()->findAll($criteria_daf);
    }

    $criteria2 = new CdbCriteria();
    $criteria2->addCondition('pendaftaran_id = ' . $modPendaftaran->pendaftaran_id);
    $criteria2->order = "pendaftaran_id DESC, pasienmasukpenunjang_id DESC";
    $criteria2->addCondition('ruangan_id = ' . Params::RUANGAN_ID_LAB_ANATOMI);
    $loadPasienMasukPenunjangs[1] = LBPasienmasukpenunjangT::model()->find($criteria2);
    if (isset($loadPasienMasukPenunjangs[1])) {
      $modPasienMasukPenunjangs[1] = $loadPasienMasukPenunjangs[1];
      $modTindakans[1] = LBTindakanPelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $modPasienMasukPenunjangs[1]->pasienmasukpenunjang_id), "karcis_id is not null");
      $criteria_daf = new CdbCriteria();
      $criteria_daf->addCondition("karcis_id IS NULL");
      $criteria_daf->addCondition("pasienmasukpenunjang_id = " . $modPasienMasukPenunjangs[1]->pasienmasukpenunjang_id);
      $daftartindakan[1] = LBTindakanPelayananT::model()->findAll($criteria_daf);
    }
    $judul_print = 'Kunjungan Laboratorium';
    $this->render($this->path_view . 'printStatusLab', array(
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
      'modPasienMasukPenunjangs' => $modPasienMasukPenunjangs,
      'judul_print' => $judul_print,
      'modPasien' => $modPasien,
      'modTindakans' => $modTindakans,
      'daftartindakan' => $daftartindakan,
    ));
  }

  // public function actionPrintKupon($pendaftaran_id)
  // {
  //   $this->layout = '//layouts/printWindows';
  //   $format = new MyFormatter;
  //   $modPendaftaran = $this->loadModel($pendaftaran_id);
  //   $modAdmisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
  //   $modPasien = LBPasienM::model()->findByPk($modPendaftaran->pasien_id);
  //   $modTindakans = array();

  //   $criteria1 = new CdbCriteria();
  //   $criteria1->addCondition('pendaftaran_id = ' . $modPendaftaran->pendaftaran_id);
  //   $criteria1->order = "pendaftaran_id DESC, pasienmasukpenunjang_id DESC";
  //   $criteria1->addCondition('ruangan_id <> ' . Params::RUANGAN_ID_LAB_ANATOMI);
  //   $loadPasienMasukPenunjangs[0] = LBPasienmasukpenunjangT::model()->find($criteria1);
  //   if (isset($loadPasienMasukPenunjangs[0])) {
  //     $modPasienMasukPenunjangs[0] = $loadPasienMasukPenunjangs[0];
  //     $modTindakans[0] = LBTindakanPelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $modPasienMasukPenunjangs[0]->pasienmasukpenunjang_id), "karcis_id is not null");
  //     $criteria_daf = new CdbCriteria();
  //     $criteria_daf->addCondition("karcis_id IS NULL");
  //     $criteria_daf->addCondition("pasienmasukpenunjang_id = " . $modPasienMasukPenunjangs[0]->pasienmasukpenunjang_id);
  //     $daftartindakan[0] = LBTindakanPelayananT::model()->findAll($criteria_daf);
  //   }

  //   $criteria2 = new CdbCriteria();
  //   $criteria2->addCondition('pendaftaran_id = ' . $modPendaftaran->pendaftaran_id);
  //   $criteria2->order = "pendaftaran_id DESC, pasienmasukpenunjang_id DESC";
  //   $criteria2->addCondition('ruangan_id = ' . Params::RUANGAN_ID_LAB_ANATOMI);
  //   $loadPasienMasukPenunjangs[1] = LBPasienmasukpenunjangT::model()->find($criteria2);
  //   if (isset($loadPasienMasukPenunjangs[1])) {
  //     $modPasienMasukPenunjangs[1] = $loadPasienMasukPenunjangs[1];
  //     $modTindakans[1] = LBTindakanPelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $modPasienMasukPenunjangs[1]->pasienmasukpenunjang_id), "karcis_id is not null");
  //     $criteria_daf = new CdbCriteria();
  //     $criteria_daf->addCondition("karcis_id IS NULL");
  //     $criteria_daf->addCondition("pasienmasukpenunjang_id = " . $modPasienMasukPenunjangs[1]->pasienmasukpenunjang_id);
  //     $daftartindakan[1] = LBTindakanPelayananT::model()->findAll($criteria_daf);
  //   }
  //   $judul_print = 'Kunjungan Laboratorium';

  //     $this->render($this->path_view . 'printKupon', array(
  //       'format' => $format,
  //       'modPendaftaran' => $modPendaftaran,
  //       'modPasienMasukPenunjangs' => $modPasienMasukPenunjangs,
  //       'judul_print' => $judul_print,
  //       'modPasien' => $modPasien,
  //       'modTindakans' => $modTindakans,
  //       'daftartindakan' => $daftartindakan,
  //     ));
  // }
  public function actionPrintKuponAnatomi($pendaftaran_id, $pasienmasukpenunjang_id = null)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = $this->loadModel($pendaftaran_id);
    $modAdmisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modPasien = LBPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modTindakans = array();
    // $criteria1 = new CdbCriteria();
    // $criteria1->addCondition('pendaftaran_id = ' . $modPendaftaran->pendaftaran_id);
    // $criteria1->order = "pendaftaran_id DESC, pasienmasukpenunjang_id DESC";
    // $criteria1->addCondition('ruangan_id <> ' . Params::RUANGAN_ID_LAB_ANATOMI);
    // $loadPasienMasukPenunjangs[0] = LBPasienmasukpenunjangT::model()->find($criteria1);
    // if (isset($loadPasienMasukPenunjangs[0])) {
    //   $modPasienMasukPenunjangs[0] = $loadPasienMasukPenunjangs[0];
    //   $modTindakans[0] = LBTindakanPelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $modPasienMasukPenunjangs[0]->pasienmasukpenunjang_id), "karcis_id is not null");
    //   $criteria_daf = new CdbCriteria();
    //   $criteria_daf->addCondition("karcis_id IS NULL");
    //   $criteria_daf->addCondition("pasienmasukpenunjang_id = " . $modPasienMasukPenunjangs[0]->pasienmasukpenunjang_id);
    //   $daftartindakan[0] = LBTindakanPelayananT::model()->findAll($criteria_daf);
    // }

    $criteria2 = new CdbCriteria();
    $criteria2->addCondition('pendaftaran_id = ' . $modPendaftaran->pendaftaran_id);
    $criteria2->order = "pendaftaran_id DESC, pasienmasukpenunjang_id DESC";
    $criteria2->addCondition('ruangan_id = ' . Params::RUANGAN_ID_LAB_ANATOMI);

    if (!empty($pasienmasukpenunjang_id)) {
      $criteria2->compare('pasienmasukpenunjang_id', $pasienmasukpenunjang_id);
    }
    $loadPasienMasukPenunjangs[1] = LBPasienmasukpenunjangT::model()->find($criteria2);
    if (isset($loadPasienMasukPenunjangs[1])) {
      $modPasienMasukPenunjangs[1] = $loadPasienMasukPenunjangs[1];
      $modTindakans[1] = LBTindakanPelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $modPasienMasukPenunjangs[1]->pasienmasukpenunjang_id), "karcis_id is not null");
      $criteria_daf = new CdbCriteria();
      $criteria_daf->addCondition("karcis_id IS NULL");
      $criteria_daf->addCondition("pasienmasukpenunjang_id = " . $modPasienMasukPenunjangs[1]->pasienmasukpenunjang_id);
      $daftartindakan[1] = LBTindakanPelayananT::model()->findAll($criteria_daf);
    }
    $judul_print = 'LAB. PATOLOGI ANATOMI';
    $this->render($this->path_view . 'printKuponAnatomi', array(
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
      'modPasienMasukPenunjangs' => $modPasienMasukPenunjangs,
      'judulLaporan' => $judul_print,
      'modPasien' => $modPasien,
      'modTindakans' => $modTindakans,
      'daftartindakan' => $daftartindakan,
    ));
  }

  public function actionPrintKuponAnatomi2($pendaftaran_id)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = $this->loadModel($pendaftaran_id);
    $modAdmisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modPasien = LBPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modTindakans = array();
    // $criteria1 = new CdbCriteria();
    // $criteria1->addCondition('pendaftaran_id = ' . $modPendaftaran->pendaftaran_id);
    // $criteria1->order = "pendaftaran_id DESC, pasienmasukpenunjang_id DESC";
    // $criteria1->addCondition('ruangan_id <> ' . Params::RUANGAN_ID_LAB_ANATOMI);
    // $loadPasienMasukPenunjangs[0] = LBPasienmasukpenunjangT::model()->find($criteria1);
    // if (isset($loadPasienMasukPenunjangs[0])) {
    //   $modPasienMasukPenunjangs[0] = $loadPasienMasukPenunjangs[0];
    //   $modTindakans[0] = LBTindakanPelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $modPasienMasukPenunjangs[0]->pasienmasukpenunjang_id), "karcis_id is not null");
    //   $criteria_daf = new CdbCriteria();
    //   $criteria_daf->addCondition("karcis_id IS NULL");
    //   $criteria_daf->addCondition("pasienmasukpenunjang_id = " . $modPasienMasukPenunjangs[0]->pasienmasukpenunjang_id);
    //   $daftartindakan[0] = LBTindakanPelayananT::model()->findAll($criteria_daf);
    // }

    $criteria2 = new CdbCriteria();
    $criteria2->addCondition('pendaftaran_id = ' . $modPendaftaran->pendaftaran_id);
    $criteria2->order = "pendaftaran_id DESC, pasienmasukpenunjang_id DESC";
    $criteria2->addCondition('ruangan_id = ' . Params::RUANGAN_ID_LAB_ANATOMI);
    $loadPasienMasukPenunjangs[1] = LBPasienmasukpenunjangT::model()->find($criteria2);
    if (isset($loadPasienMasukPenunjangs[1])) {
      $modPasienMasukPenunjangs[1] = $loadPasienMasukPenunjangs[1];
      $modTindakans[1] = LBTindakanPelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $modPasienMasukPenunjangs[1]->pasienmasukpenunjang_id), "karcis_id is not null");
      $criteria_daf = new CdbCriteria();
      $criteria_daf->addCondition("karcis_id IS NULL");
      $criteria_daf->addCondition("pasienmasukpenunjang_id = " . $modPasienMasukPenunjangs[1]->pasienmasukpenunjang_id);
      $daftartindakan[1] = LBTindakanPelayananT::model()->findAll($criteria_daf);
    }
    $judul_print = 'LAB PEMERIKSAAN LABORATORIUM PATOLOGI ANATOMI';
    $this->render($this->path_view . 'printKuponAnatomi2', array(
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
      'modPasienMasukPenunjangs' => $modPasienMasukPenunjangs,
      'judul_print' => $judul_print,
      'modPasien' => $modPasien,
      'modTindakans' => $modTindakans,
      'daftartindakan' => $daftartindakan,
    ));
  }
  public function actionPrintKuponKlinik($pendaftaran_id, $pasienmasukpenunjang_id = null)
  {
    $this->layout = '//layouts/printWindows';
    $format = new MyFormatter;
    $modPendaftaran = $this->loadModel($pendaftaran_id);
    $modAdmisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    $modPasien = LBPasienM::model()->findByPk($modPendaftaran->pasien_id);
    $modTindakans = array();
      

    $criteria1 = new CdbCriteria();
    $criteria1->addCondition('pendaftaran_id = ' . $modPendaftaran->pendaftaran_id);
    $criteria1->order = "pendaftaran_id DESC, pasienmasukpenunjang_id DESC";
    $criteria1->addCondition('ruangan_id <> ' . Params::RUANGAN_ID_LAB_ANATOMI);

    if (!empty($pasienmasukpenunjang_id)) {
      $criteria1->compare('pasienmasukpenunjang_id', $pasienmasukpenunjang_id);
    }

    $loadPasienMasukPenunjangs[0] = LBPasienmasukpenunjangT::model()->find($criteria1);
    if (isset($loadPasienMasukPenunjangs[0])) {
      $modPasienMasukPenunjangs[0] = $loadPasienMasukPenunjangs[0];
      $modTindakans[0] = LBTindakanPelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $modPasienMasukPenunjangs[0]->pasienmasukpenunjang_id), "karcis_id is not null");
      $criteria_daf = new CdbCriteria();
      $criteria_daf->addCondition("karcis_id IS NULL");
      $criteria_daf->addCondition("pasienmasukpenunjang_id = " . $modPasienMasukPenunjangs[0]->pasienmasukpenunjang_id);
      $daftartindakan[0] = LBTindakanPelayananT::model()->findAll($criteria_daf);
    }
    // $criteria2 = new CdbCriteria();
    // $criteria2->addCondition('pendaftaran_id = ' . $modPendaftaran->pendaftaran_id);
    // $criteria2->order = "pendaftaran_id DESC, pasienmasukpenunjang_id DESC";
    // $criteria2->addCondition('ruangan_id = ' . Params::RUANGAN_ID_LAB_ANATOMI);
    // $loadPasienMasukPenunjangs[1] = LBPasienmasukpenunjangT::model()->find($criteria2);
    // if (isset($loadPasienMasukPenunjangs[1])) {
    //   $modPasienMasukPenunjangs[1] = $loadPasienMasukPenunjangs[1];
    //   $modTindakans[1] = LBTindakanPelayananT::model()->findByAttributes(array('pasienmasukpenunjang_id' => $modPasienMasukPenunjangs[1]->pasienmasukpenunjang_id), "karcis_id is not null");
    //   $criteria_daf = new CdbCriteria();
    //   $criteria_daf->addCondition("karcis_id IS NULL");
    //   $criteria_daf->addCondition("pasienmasukpenunjang_id = " . $modPasienMasukPenunjangs[1]->pasienmasukpenunjang_id);
    //   $daftartindakan[1] = LBTindakanPelayananT::model()->findAll($criteria_daf);
    // }
    $judul_print = 'PEMERIKSAAN LABORATORIUM';
    $this->render($this->path_view . 'printKuponKlinik', array(
      'format' => $format,
      'modPendaftaran' => $modPendaftaran,
      'modPasienMasukPenunjangs' => $modPasienMasukPenunjangs,
      'judul_print' => $judul_print,
      'modPasien' => $modPasien,
      'modTindakans' => $modTindakans,
      'daftartindakan' => $daftartindakan,
    ));
  }

  /**
   * @param type $pendaftaran_id
   * Cetak label
   */
  public function actionPrintStatusLabel($pendaftaran_id, $pengambilansample_id = NULL)
  {
    $this->layout = '//layouts/printWindows';
    $modPendaftaran = $this->loadModel($pendaftaran_id);
    if (isset($pengambilansample_id)) {
      $sql = "				
					SELECT
					pasien_m.namadepan, pasien_m.no_rekam_medik,pasien_m.nama_pasien,pendaftaran_t.no_pendaftaran,pendaftaran_t.tgl_pendaftaran,
					pengambilansample_t.tglpengambilansample,
					pengambilansample_t.no_pengambilansample,
                                        pasien_m.tanggal_lahir,
                                        pasien_m.jeniskelamin
					FROM
					pengambilansample_t
					left join pasienmasukpenunjang_t ON pengambilansample_t.pasienmasukpenunjang_id = pasienmasukpenunjang_t.pasienmasukpenunjang_id
					left join pendaftaran_t on pasienmasukpenunjang_t.pendaftaran_id=pendaftaran_t.pendaftaran_id
					left join pasien_m on (pasien_m.pasien_id = pendaftaran_t.pasien_id)
					WHERE pasienmasukpenunjang_t.pasien_id = '" . $modPendaftaran->pasien_id . "' AND pasienmasukpenunjang_t.pendaftaran_id = '" . $pendaftaran_id . "'
					AND pengambilansample_t.pengambilansample_id = '" . $_GET['pengambilansample_id'] . "'
					";
    } else {
      $sql = "				
						SELECT
						pasien_m.namadepan, pasien_m.no_rekam_medik,pasien_m.nama_pasien,pendaftaran_t.no_pendaftaran,pendaftaran_t.tgl_pendaftaran,
						pengambilansample_t.tglpengambilansample,
						pengambilansample_t.no_pengambilansample,
                                                pasien_m.tanggal_lahir,
                                                pasien_m.jeniskelamin
						FROM
						pengambilansample_t
						left join pasienmasukpenunjang_t ON pengambilansample_t.pasienmasukpenunjang_id = pasienmasukpenunjang_t.pasienmasukpenunjang_id
						left join pendaftaran_t on pasienmasukpenunjang_t.pendaftaran_id=pendaftaran_t.pendaftaran_id
						left join pasien_m on (pasien_m.pasien_id = pendaftaran_t.pasien_id)
						WHERE pasienmasukpenunjang_t.pasien_id = '" . $modPendaftaran->pasien_id . "' AND pasienmasukpenunjang_t.pendaftaran_id = '" . $pendaftaran_id . "'
						";
    }
    $query = Yii::app()->db->createCommand($sql)->queryAll();

    if (empty($query)) {
      $query = array();
    }

    $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf


    $sampel = PengambilansampleT::model()->findByPk($pengambilansample_id);
    if (!empty($pengambilansample_id)) {
      $penunjang = PasienmasukpenunjangT::model()->findByPk($sampel->pasienmasukpenunjang_id);
    } else {
      $penunjang = "";
    }
    //            $query[0]['ruangan_asal'] = "";
    //            $query[0]['pemeriksaan'] = "";

    if (!empty($penunjang) && !empty($penunjang->ruanganasal_id)) {
      $ruangan = RuanganM::model()->findByPk($penunjang->ruanganasal_id);

      $query[0]['ruangan_asal'] = $ruangan->ruangan_nama;

      // kamar ruangan
      $admisi = PasienadmisiT::model()->findByAttributes(array(
        'pendaftaran_id' => $pendaftaran_id
      ));

      if (!empty($admisi)) {
        $crk = new CDbCriteria();
        $crk->compare('pasienadmisi_id', $admisi->pasienadmisi_id);
        $crk->compare('ruangan_id', $ruangan->ruangan_id);
        $crk->addCondition("tglmasukkamar >= '" . $sampel->tglpengambilansample . "'");
        $crk->order = 'tglmasukkamar asc';

        $kamar = MasukkamarT::model()->find($crk);

        if (empty($kamar)) {
          $kamar = MasukkamarT::model()->findByAttributes(array(
            'pasienadmisi_id' => $admisi->pasienadmisi_id,
            'ruangan_id' => $ruangan->ruangan_id,
          ), array(
            'order' => 'tglmasukkamar desc',
          ));
        }

        if (!empty($kamar)) {
          $kr = KamarruanganM::model()->findByPk($kamar->kamarruangan_id);

          $query[0]['ruangan_asal'] .= ", " . $kr->kamarruangan_nokamar;
        }
      }
    }

    // pemeriksaan
    if (!empty($penunjang->pasienmasukpenunjang_id)) {
      $tindakan = TindakanpelayananT::model()->findAllByAttributes(array(
        'pasienmasukpenunjang_id' => $penunjang->pasienmasukpenunjang_id,
      ));
    } else {
      $tindakan = "";
    }

    $list_periksa = array();

    if (!empty($tindakan)) {
      foreach ($tindakan as $item) {
        $periksa = PemeriksaanlabM::model()->findByAttributes(array(
          'daftartindakan_id' => $item->daftartindakan_id,
        ));


        if (!empty($periksa)) {
          if (!empty($periksa->daftartindakan)) {
            $list_periksa[] = $periksa->daftartindakan->daftartindakan_namalainnya;
          }
        }
      }
    }
    if (!empty($list_periksa)) {
      $query[0]['pemeriksaan'] = implode(", ", $list_periksa);
    }
    //var_dump($query); die;

    // var_dump($sampel->attributes); die;


    $posisi = 'P'; //Posisi L->Landscape,P->Portait
    //20->2cm, 50->5cm
    $mpdf = new MyPDF60('', array(50, 40));
    // ob_clean();
    //            $mpdf->mirrorMargins = 0;  
    //            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
    //            $mpdf->WriteHTML($stylesheet,1);  
    //            $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/5x4cm.css'); 
    //            $mpdf->WriteHTML($formatkonten, 1);
    $mpdf->setHTMLFooter('<span></span>');
    $mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
    //$mpdf->SetHtmlFooter($this->renderPartial("application.views.footer._footerLabel", array(), true), 'O');

    $mpdf->WriteHTML(
      $this->renderPartial($this->path_view . 'printStatusLabel', array(
        'query' => $query,
        'modPendaftaran' => $modPendaftaran,
      ), true)
    );
    // $mpdf->SetJS('this.print();');
    $mpdf->Output();
    //$this->render($this->path_view.'printStatusLabel', array(
    //						'query'=>$query,
    //              'modPendaftaran'=>$modPendaftaran,
    //));
  }

   /**
     * - digunakan untuk mencetak sticker
     * @param type $pendaftaran_id
     */
    public function actionPrintLabel($pendaftaran_id)
    {
        // $this->layout='//layouts/printWindows';
        $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

        //        $this->render($this->path_view.'printLabel',
        //            array(
        //                'modPendaftaran'=>$modPendaftaran,
        //            )
        //        );
        $posisi = 'L'; //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', array(40, 60));
        $mpdf->mirrorMargins = 2;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->AddPage($posisi, '', '', '', '', 0, 0, 0, 0, 0, 0);
        $mpdf->SetHTMLFooter('<span></span>');
        $mpdf->WriteHTML(
            $this->renderPartial($this->path_view . 'printStatusLabel', array(
                'modPendaftaran' => $modPendaftaran,
            ), true)
        );
        //                $mpdf->SetJS('this.print();');
        $mpdf->Output();
    }

  /**
   * Cek keaktifan pegawai jika penjamin pt badak
   * @param type $encode
   * @param type $namaModel
   */
  public function actionCekCaraBayarBadak()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pasien_id = $_POST['pasien_id'];
      $pegawai_id = $_POST['pegawai_id'];
      $pesan = '';
      $status = false;
      $modPegawai = PPPegawaiM::model()->findByPk($pegawai_id);
      if (!empty($modPegawai)) {
        if ($modPegawai->pegawai_aktif) {
          $status = true;
        } else {
          $status = false;
          $pesan = 'Data Pegawai tidak aktif';
        }
      } else {
        $status = false;
        $pesan = 'Data tidak ditemukan';
      }
      echo CJSON::encode(array('status' => $status, 'pesan' => $pesan));
    }
    Yii::app()->end();
  }

  /**
   * Ngeset data asuransi badak jika pasien telah memiliki data di asuransipasien_m
   * @param type $encode
   * @param type $namaModel
   */
  public function actionSetAsuransiBadak()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data = array();
      if ((!empty($_POST['pasien_id'])) && (!empty($_POST['penjamin_id']))) {
        $criteria = new CDbCriteria();
        $criteria->addCondition("pasien_id = " . $_POST['pasien_id']);
        $criteria->addCondition("penjamin_id = " . $_POST['penjamin_id']);
        $criteria->order = 'asuransipasien_id DESC';
        $model = AsuransipasienM::model()->find($criteria);
        if (!empty($model)) {
          $attributes = $model->attributeNames();
          foreach ($attributes as $j => $attribute) {
            $data["$attribute"] = $model->$attribute;
          }
          $data['listPenjamin'] = "";
          $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $model->carabayar_id, 'penjamin_aktif' => true), array('order' => 'penjamin_nama ASC'));
          if (count((array)$penjamin) > 1) {
            $data['listPenjamin'] .= CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          }
          $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
          foreach ($penjamin as $value => $name) {
            $data['listPenjamin'] .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        } else {
          $data = null;
          $pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : '';
          if (!empty($pegawai_id)) {
            $modPegawai = PegawaiM::model()->findByPk($pegawai_id);
            $data['nopeserta'] = $modPegawai->nomorindukpegawai;
            $data['namaperusahaan'] = $modPegawai->unit_perusahaan;
            $data['namapemilikasuransi'] = $modPegawai->nama_pegawai;
            $data['namaperusahaan'] = 'PT. Badak LNG';
          }
        }
      } else {
        $pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : '';
        if (!empty($pegawai_id)) {
          $modPegawai = PegawaiM::model()->findByPk($pegawai_id);
          $data['nopeserta'] = $modPegawai->nomorindukpegawai;
          $data['namaperusahaan'] = $modPegawai->unit_perusahaan;
          $data['namapemilikasuransi'] = $modPegawai->nama_pegawai;
          $data['namaperusahaan'] = 'PT. Badak LNG';
        }
      }
      echo CJSON::encode($data);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  /**
   * Cek kategori pegawai untuk menentukan asuransi pasien
   * @param type $encode
   * @param type $namaModel
   */
  public function actionCekValiditasPenjamin()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : '';
      $penjamin_id =  isset($_POST['penjamin_id']) ? $_POST['penjamin_id'] : '';
      $pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : '';
      $penj = '';
      $pesan = '';
      $status = '';
      $html = '';
      $data = null;
      switch ($_POST['type']) {
        case "badak":

          $modPegawai = PPPegawaiM::model()->findByPk($pegawai_id);
          $penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => Params::CARABAYAR_ID_BADAK, 'penjamin_aktif' => true), array('order' => 'penjamin_nama ASC'));
          $penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
          $html .= CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($penjamin as $value => $name) {
            $html .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }

          if (!empty($modPegawai)) {
            if ($modPegawai->kategoripegawai == "") {
              $status = "Empty";
              $pesan = 'Data Kategori pegawai penanggung jawab pasien tidak ditemukan!<br>Lakukan pengaturan kategori pegawai di modul kepegawaian';
            } else {
              if ($penjamin_id == Params::PENJAMIN_ID_PISA) {
                $penj = Params::PENJAMIN_ID_PISA;
                if ($modPegawai->kategoripegawai == "Tidak Tetap") {
                  $status = "Tidak Tetap";
                  $pesan = 'Tidak dapat memilih penjamin PISA. <br> Karena pegawai penanggung jawab pasien adalah pegawai tidak tetap / telah pensiun';
                }
              } else if ($penjamin_id == Params::PENJAMIN_ID_PROKESPEN) {
                $penj = Params::PENJAMIN_ID_PROKESPEN;
              }
            }
          } else {
            $status = "Fail";
            $pesan = 'Data tidak ditemukan';
          }
          break;

        case "departemen":

          $modPenjamin = PenjaminpasienM::model()->findByPk($penjamin_id);
          $data['penjamin_nama'] = $modPenjamin->penjamin_nama;
          break;
      }

      echo CJSON::encode(array('status' => $status, 'pesan' => $pesan, 'html' => $html, 'penj' => $penj, 'data' => $data));
    }
    Yii::app()->end();
  }

  /**
   * set dropdown jenis kasus penyakit
   */
  public function actionSetDropdownStatushubungankeluarga()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $penjamin_id = $_POST['penjamin_id'];
      $modAsuransiPasienBadak = new PPAsuransipasienbadakM();
      $option = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      if (!empty($penjamin_id)) {
        $data = $modAsuransiPasienBadak->getDropdownStatushubungankeluarga($penjamin_id);
        $data = CHtml::listData($data, 'lookup_value', 'lookup_name');
        foreach ($data as $value => $name) {
          $option .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
      }
      $dataList['statushubungankeluarga'] = $option;
      echo json_encode($dataList);
      Yii::app()->end();
    }
  }

  public function actionAutocompleteAsuransiBadak()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $nopeserta = isset($_GET['nomorindukpegawai']) ? $_GET['nomorindukpegawai'] : '';
      $penjamin_id = isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null;
      $pasien_id = isset($_GET['pasien_id']) ? $_GET['pasien_id'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nopeserta)', strtolower($nopeserta), true);
      if (!empty($pasien_id)) {
        $criteria->addCondition('pasien_id=' . $pasien_id);
      }
      if (!empty($penjamin_id)) {
        $criteria->addCondition('penjamin_id=' . $penjamin_id);
      }
      $criteria->order = 'namapemilikasuransi';
      $criteria->limit = 5;
      $models = PPAsuransipasienM::model()->findAll($criteria);

      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nopeserta . ' - ' . $model->namapemilikasuransi;
        $returnVal[$i]['value'] = $model->nopeserta;
        $returnVal[$i]['asuransipasien_id'] = $model->asuransipasien_id;
        //				$returnVal[$i]['nopeserta'] = $model->nopeserta;
        $returnVal[$i]['namapemilikasuransi'] = $model->namapemilikasuransi;
        $returnVal[$i]['jenispeserta_id'] = $model->jenispeserta_id;
        $returnVal[$i]['nomorpokokperusahaan'] = $model->nomorpokokperusahaan;
        $returnVal[$i]['namaperusahaan'] = $model->namaperusahaan;
        $returnVal[$i]['kelastanggunganasuransi_id'] = $model->kelastanggunganasuransi_id;

        $modPegawai = '';
        $modPegawai = PPPegawaiM::model()->findByPk($model->pasien->pegawai_id);
        $returnVal[$i]['alamat_pegawai'] = !empty($modPegawai) ? $modPegawai->alamat_pegawai : '';
        $returnVal[$i]['notelp_pegawai'] = !empty($modPegawai) ? $modPegawai->notelp_pegawai : '';
      }
      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }


  /**
   * untuk menampilkan data pegawai 
   */
  public function actionAutocompletePegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $nomorindukpegawai = isset($_GET['nomorindukpegawai']) ? $_GET['nomorindukpegawai'] : null;
      $nama_pegawai = isset($_GET['nama_pegawai']) ? $_GET['nama_pegawai'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nomorindukpegawai)', strtolower($nomorindukpegawai), true);
      $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
      $criteria->order = 'nomorindukpegawai, nama_pegawai';
      $criteria->limit = 5;
      $models = PPPegawaiM::model()->findAll($criteria);
      if (count((array)$models) > 0) {
        foreach ($models as $i => $model) {
          $returnVal[$i] = $model->attributes;
          if (!empty($nomorindukpegawai)) {
            $returnVal[$i]['label'] = $model->nomorindukpegawai . ' - ' . $model->nama_pegawai;
          } else {
            $returnVal[$i]['label'] = $model->nama_pegawai;
          }
          $returnVal[$i]['value'] = $model->pegawai_id;
          $returnVal[$i]['jabatan_nama'] = !empty($model->jabatan_id) ? $model->jabatan->jabatan_nama : "";
          $returnVal[$i]['gelarbelakang_nama'] = !empty($model->gelarbelakang_id) ? $model->gelarbelakang->gelarbelakang_nama : "";
        }
      }
      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  /**
   * menampilkan form antrian dari request ajax
   * @param type $record
   * @param type $noantrian
   * @throws CHttpException
   */
  public function actionSetFormAntrian()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $data = array();
      $data['pesan'] = "";
      $record = (isset($_POST['record']) ? $_POST['record'] : "");
      $noantrian = (isset($_POST['noantrian']) ? $_POST['noantrian'] : "");
      if (empty($noantrian)) { //antrian baru
        $criteria = new CDbCriteria();
        $criteria->join = "join loket_m l on l.loket_id = t.loket_id";
        $criteria->addCondition("l.loket_singkatan ilike 'l'");
        $criteria->compare('DATE(t.tglantrian)', date("Y-m-d"));
        $criteria->addCondition("t.pendaftaran_id IS NULL");
        // if($record == "reset"){
        // $criteria->addCondition("panggil_flaq = false");
        // }
        $criteria->order = "noantrian ASC";
        $criteria->limit = 1;
        $modAntrian =  PPAntrianT::model()->find($criteria);
      } else {
        $criteria = new CDbCriteria();
        $criteria->join = "join loket_m l on l.loket_id = t.loket_id";
        $criteria->addCondition("l.loket_singkatan ilike 'l'");
        $criteria->compare('DATE(t.tglantrian)', date("Y-m-d"));
        $criteria->compare("t.noantrian", trim($noantrian));
        $cari =  PPAntrianT::model()->find($criteria);
        if ($record == 'next') {
          $modAntrian = $cari->AntrianBerikut;
        } else if ($record == 'prev') {
          $modAntrian = $cari->AntrianSebelum;
        } else {
          $modAntrian = $cari;
        }
      }

      if (!isset($modAntrian)) {
        $modAntrian = new PPAntrianT;
        $data['pesan'] = "Antrian Habis !";
      }
      $modAntrian->tglantrian = $format->formatDateTimeForUser($modAntrian->tglantrian);
      $data['form_antrian'] = $this->renderPartial($this->path_view . '_formPanggilAntrian', array('modAntrian' => $modAntrian), true);
      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }


  /**
   * action ketika tombol panggil di klik
   */
  public function actionPanggil($antrian_id, $ket = null)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $data = array();
      $data['pesan'] = "";
      $modAntrian =  PPAntrianT::model()->findByPk($antrian_id);
      if (isset($modAntrian)) {
        if ($modAntrian->panggil_flaq == true) {
          if ($ket == "batal") {
            $modAntrian->panggil_flaq = false;
            if ($modAntrian->update()) {
              //                            $data['pesan'] = "Pemanggilan no. antrian ".$modAntrian->noantrian." dibatalkan !";
            }
          } //else{
          // $data['pesan'] = "No. antrian ".$modAntrian->noantrian." sudah dipanggil sebelumnya !";
          // }
        } else {
          $modAntrian->panggil_flaq = true;
          if ($modAntrian->update()) {
            //                        $data['pesan'] = "No. antrian ".$modAntrian->noantrian." dipanggil !";
          }
        }
      }
      $attributes = $modAntrian->attributeNames();
      foreach ($attributes as $i => $attribute) {
        $data["$attribute"] = $modAntrian->$attribute;
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  public function actionAutocompletePegawaiUntukPasienBaru($nip = null)
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $cr = new CDbCriteria;
    $cr->compare('lower(nomorindukpegawai)', strtolower("" . $nip . ""), true);
    $cr->addCondition('pegawai_aktif = true');
    $cr->order = 'nama_pegawai asc';

    $model = PegawaiM::model()->findAll($cr);
    $res = array();

    foreach ($model as $item) {
      $p = PasienM::model()->findByAttributes(array(
        'pegawai_id' => $item->pegawai_id
      ));

      $sub = array(
        'label' => $item->nomorindukpegawai . " - " . $item->namaLengkap,
        'pegawai_id' => $item->pegawai_id,
        'nip' => $item->nomorindukpegawai,
        'nama_pegawai' => $item->namaLengkap,
        'sudah_ada' => !empty($p),
      );

      $res[] = $sub;
    }

    echo CJSON::encode($res);
  }

  public function actionGetDataPegawaiUntukPasienBaru()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $pegawai_id = $_POST['pegawai_id'] == "null" ? null : $_POST['pegawai_id'];
    $nip = $_POST['nip'];

    $cr = new CDbCriteria();

    if (!empty($pegawai_id)) {
      $cr->compare('pegawai_id', $pegawai_id);
    } else if (!empty($nip)) {
      $cr->compare('lower(nomorindukpegawai)', strtolower($nip));
    }
    $cr->addCondition('pegawai_aktif = true');

    $model = PegawaiM::model()->find($cr);

    $ok = 1;
    $msg = "";
    $res = array();
    if (empty($model)) {
      $ok = 0;
      $msg = "Pegawai dengan nip " . $nip . " tidak ditemukan";
    } else {
      $pasien = PasienM::model()->findByAttributes(array(
        'pegawai_id' => $model->pegawai_id,
      ));

      if (!empty($pasien)) {
        $ok = 0;
        $msg = "Pegawai dengan nip " . $nip . " sudah didaftarkan sebagai pasien. Mohon cari pegawai di pasien lama.";
      }

      $model->nomobile_pegawai = str_replace(" ", "", $model->nomobile_pegawai);
      $model->tgl_lahirpegawai = date('d/m/Y', strtotime($model->tgl_lahirpegawai));
      $res = $model->attributes;
    }

    echo CJSON::encode(array('ok' => $ok, 'msg' => $msg, 'res' => $res));
  }

  public function actionCatatCeklisHakPasien()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    if (isset($_POST['ceklis'])) {
      Yii::app()->user->setState('ceklis_hak_pasien_' . $this->id, $_POST['ceklis']);
    }

    echo CJSON::encode(array('ok' => 1, 'data' => $_POST['ceklis']));
  }

  public function actionSetSudahDibaca()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $pendaftaran = isset($_POST['pendaftaran_id']) && $_POST['pendaftaran_id'] != 0 ? $_POST['pendaftaran_id'] : null;

    if (!empty($pendaftaran)) {
      PendaftaranT::model()->updateByPk($pendaftaran, array(
        'isbacahakpasien' => true,
      ));
      Yii::app()->user->setState('hak_pasien_sudah_baca_' . $this->id, null);
      Yii::app()->user->setState('ceklis_hak_pasien_' . $this->id, null);
    } else {
      Yii::app()->user->setState('hak_pasien_sudah_baca_' . $this->id, 1);
    }

    echo CJSON::encode(['ok' => 1]);
  }

  public function cleanUpSessionPasienSudahBaca($id = null)
  {

    if (!empty(Yii::app()->user->getState('hak_pasien_sudah_baca_' . $this->id)) && Yii::app()->user->getState('hak_pasien_sudah_baca_' . $this->id) == 1) {
      Yii::app()->user->setState('hak_pasien_sudah_baca_' . $this->id, null);
      Yii::app()->user->setState('ceklis_hak_pasien_' . $this->id, null);
      if (!empty($id)) {
        PendaftaranT::model()->updateByPk($id, array(
          'isbacahakpasien' => true,
        ));
      }
    }
  }


  public function actionHapusTindakanPemeriksaan()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $trans = Yii::app()->db->beginTransaction();
    $ok = 1;
    $msg = "Pemeriksaan berhasil dibatalkan.";



    try {

      $id = $_POST['id'];

      TindakanpelayananT::model()->updateByPk($id, array(
        'detailhasilpemeriksaanlab_id' => null,
      ));

      DetailhasilpemeriksaanlabT::model()->deleteAllByAttributes(array(
        'tindakanpelayanan_id' => $id,
      ));

      TindakanpelayananT::model()->deleteByPk($id);

      $trans->commit();
    } catch (Exception $ex) {
      $trans->rollback();
      $ok = 0;
      $msg = "Pemeriksaan gagal dibatalkan.<br/>" . $ex->getMessage();
    }

    echo CJSON::encode(array(
      'ok' => $ok,
      'msg' => $msg,
    ));
  }


  public function actionAjaxLoadPhotoScan()
  {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $mips = new MIPS;
    $response = $mips->newFindRecords(date('Y-m-d H:i', strtotime('now - 1 month')), date('Y-m-d H:i', strtotime('now + 1 day')));

    if ($response['success'] != true) {
      echo CJSON::encode(array(
        'ok' => 0,
        'msg' => 'Error. Data tidak dapat di ambil',
      ));

      Yii::app()->end();
    }

    if (count((array)$response['data']) == 0) {
      echo CJSON::encode(array(
        'ok' => 0,
        'msg' => 'Data belum ada',
      ));
      Yii::app()->end();
    }

    $res_dat = $response['data'];
    $sort_time = array();

    foreach ($res_dat as $key => $item) {
      $sort_time[$key] = $item['currentTime'];
    }

    array_multisort($sort_time, SORT_DESC, $res_dat);

    $res = $res_dat[0];

    $res_img = $mips->getRecordImg($res['imageName']);

    $pasien_id = "";
    $no_rm = "";

    if ($res['type'] == MIPS::REG_PASIEN) {
      $no_rm = substr($res['idCardNum'], 1);
      $pasien = PasienM::model()->findByAttributes(array(
        'no_rekam_medik' => $no_rm,
      ));

      if (!empty($pasien)) {
        $pasien_id = $pasien->pasien_id;
      } else {
        $no_rm = "";
      }
    }

    if ($res_img['success'] != true) {
      echo CJSON::encode(array(
        'ok' => 0,
        'msg' => 'Gambar tidak ditemukan',
      ));
      Yii::app()->end();
    }

    echo CJSON::encode(array(
      'ok' => 1,
      'msg' => '',
      'no_rm' => $no_rm,
      'pasien_id' => $pasien_id,
      'html' => $this->renderPartial($this->path_view . "_fotoScan", array(
        'res' => $res,
        'res_img' => $res_img,

      ), true),
    ));
  }

  protected function simpanScanPasien($modPendaftaran, $post)
  {

    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

    $model = new ScanpasiendarialatT();
    $model->attributes = $post;
    $model->pake_masker = $model->pake_masker == 1;
    $model->pasien_id = $modPendaftaran->pasien_id;
    $model->pendaftaran_id = $modPendaftaran->pendaftaran_id;

    if ($model->save()) {
      $modPendaftaran->suhu_tubuh = $model->suhu_tubuh;
      $modPendaftaran->save();

      if (!empty($model->data_gambar)) {
        $modPasien->setFotoPasienDariPerangkatMIPS($model->data_gambar);
      }
    }

    $response = $this->registerScanMIPS($model, $modPasien);

    //        if ($response['success'] != true) {
    //            Yii::app()->user->setFlash('warning', 'Scan Foto gagal didaftarkan');
    //        }

    // die;
  }


  protected function registerScanMIPS($model, $modPasien)
  {

    $person = array(
      'age' => $modPasien->umurTahun,
      'name' => $modPasien->nama_pasien,
      'prescription' => date('Y-m-d H:i') . ", " . date('Y-m-d H:i', strtotime('now + 1 year')),
      'sex' => $modPasien->jeniskelamin == 'LAKI-LAKI' ? 0 : 1,
      'type' => MIPS::REG_PASIEN,
      'vipID' => "1" . $modPasien->no_rekam_medik,
      'welCome' => '',
      'idCard' => "1" . $modPasien->no_rekam_medik,
      'card' => "1" . $modPasien->no_rekam_medik,
      'wn' => '',
      'imgBase64' => $model->data_gambar,
    );

    $mips = new MIPS();
    $response = $mips->register($person);

    // var_dump($response, $person); die;



    //var_dump($response, $person); die;
    //var_dump($model->attributes, $modPasien->attributes); die;
  }

  function actionGetPJPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $pasien_id = isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null;
      $returnValPP = array();
      if (!empty($pasien_id)) {
        $pendaftaran = PendaftaranT::model()->findByAttributes(array(
          'pasien_id' => $pasien_id,
        ), array(
          'condition' => 'pasienbatalperiksa_id is not null And penanggungjawab_id is not null'
        ));
        if (!empty($pendaftaran)) {
          $penanggungJP = PenanggungjawabM::model()->findByAttributes(array(
            'penanggungjawab_id' => $pendaftaran->penanggungjawab_id,
          ));

          $returnValPP['pengantar'] = $penanggungJP->pengantar;
          $returnValPP['nama_pj'] = $penanggungJP->nama_pj;
          $returnValPP['jeniskelamin'] = $penanggungJP->jeniskelamin;
          $returnValPP['jenisidentitas'] = $penanggungJP->jenisidentitas;
          $returnValPP['no_identitas'] = $penanggungJP->no_identitas;
          $returnValPP['no_teleponpj'] = $penanggungJP->no_teleponpj;
          $returnValPP['no_mobilepj'] = $penanggungJP->no_mobilepj;
          $returnValPP['hubungankeluarga'] = $penanggungJP->hubungankeluarga;
          $returnValPP['tempatlahir_pj'] = $penanggungJP->tempatlahir_pj;
          $returnValPP['tgllahir_pj'] = $penanggungJP->tgllahir_pj;
          $returnValPP['alamat_pj'] = $penanggungJP->alamat_pj;
        } else {
          $returnValPP = null;
        }
      }
      echo CJSON::encode($returnValPP);
      Yii::app()->end();
    }
  }

  public function actionAutocompleteDokterPerujuk($term = null) {

    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $cr = new CDbCriteria;
    $cr->compare('lower(nama_pegawai)', strtolower($term), true);
    $cr->order = "nama_pegawai asc";
    $cr->group = $cr->select = "pegawai_id, nama_pegawai, gelardepan, gelarbelakang_nama";

    $model = DokterV::model()->findAll($cr);

    $res = array();

    foreach ($model as $item) {
      $sub = $item->attributes;
      $sub['label'] = $item->namaLengkap;
      $sub['value'] = $item->pegawai_id;
      
      $res[] = $sub;
    }

    echo CJSON::encode($res);
  }
}
