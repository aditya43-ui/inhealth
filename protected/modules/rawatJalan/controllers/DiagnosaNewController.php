<?php
Yii::import('pendaftaranPenjadwalan.models.*');
Yii::import('hemodialisa.models.*');
Yii::import('rehabMedis.models.*');
Yii::import('perawatanIntensif.models.*');
Yii::import('persalinan.models.*');
Yii::import('mcu.models.*');
class DiagnosaNewController extends MyAuthController
{
  public $path_view = 'rawatJalan.views.diagnosaNew.';

  public function actionIndex($pendaftaran_id, $pasienadmisi_id = null, $pasienmasukpenunjang_id = null, $salin = null)
  {
    $this->layout = '//layouts/iframe';
    $modAdmisi = null;
    if (!empty($pasienadmisi_id)) {
      $modAdmisi = PasienadmisiT::model()->findByPk($pasienadmisi_id);
    }

    $model = $this->loadModel($pendaftaran_id);
    $modUraian = new PPPasienMorbiditasT();
    $modUraianIx = new PPPasienMorbiditasIx();

    if (!empty($salin)) {
      $model = $this->loadModel($salin);
    }
    $modInstalasiPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
    $instalasi = $modInstalasiPendaftaran->instalasi_id;
    if ($instalasi == Params::INSTALASI_ID_RJ) {
      $modPendaftaran = PPInfoKunjunganRJV::model()->findByPk($pendaftaran_id);
    } else if ($instalasi == Params::INSTALASI_ID_RD) {
      $modPendaftaran = PPInfoKunjunganRDV::model()->findByPk($pendaftaran_id);
    } else if ($instalasi == Params::INSTALASI_ID_RI) {
      $modPendaftaran = PPInfoKunjunganRIV::model()->findByPk($pendaftaran_id);
    } else if ($instalasi == Params::INSTALASI_ID_PERAWATAN_INTENSIF) {
      $modPendaftaran = PIInfopasienmasukkamarV::model()->findByPk($pendaftaran_id);
    } else if ($instalasi == Params::INSTALASI_ID_REHAB) {
      $modPendaftaran = RMMasukPenunjangV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    } else if ($instalasi == Params::INSTALASI_ID_HD) {
      $modPendaftaran = HDInfoKunjunganRDV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    } else if ($instalasi == Params::INSTALASI_ID_PERSALINAN) {
      $modPendaftaran = PSInfokunjunganpersalinanV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    } else if ($instalasi == Params::INSTALASI_ID_MCU) {
      $modPendaftaran = MCInfokunjunganmcuV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    } else {
      $modPendaftaran = PPPendaftaranT::model()->findByPk($pendaftaran_id);
    }
    
    $instalasi_login = Yii::app()->user->getState('instalasi_id');

    if($instalasi_login == Params::INSTALASI_ID_REHAB && isset($_GET['pasienmasukpenunjang_id'])) {
      $modPendaftaran = RMMasukPenunjangV::model()->findByAttributes(array('pasienmasukpenunjang_id' => $_GET['pasienmasukpenunjang_id']));
    }
    
    // echo '<pre>'; var_dump($instalasi, Params::INSTALASI_ID_REHAB); die;
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

    $modRiwayat = new PPPasienMorbiditasT();
    $modRiwayat->pasien_id = $modPasien->pasien_id;
    $criteria = new CDbCriteria;
    if (!empty($pendaftaran_id) && empty($salin)) {
      $criteria->addCondition("t.pendaftaran_id = " . $pendaftaran_id);
      $criteria->addCondition("t.create_ruangan_id = " . Yii::app()->user->getState('ruangan_id'));
      $criteria->addCondition("t.pegawai_id = " . Yii::app()->user->getState('pegawai_id'));
      $criteria->select = 't.*, pasienmorbiditas_r.tglmorbiditas,  pasienmorbiditas_r.ruangan_id';
      $criteria->join = 'JOIN pasienmorbiditas_r ON pasienmorbiditas_r.pasienmorbiditas_id = t.pasienmorbiditas_id';
    }
    if (!empty($salin) && isset($_GET['pegawai_id']) && isset($_GET['ruangan_id'])) {
      $criteria->addCondition("t.pendaftaran_id = " . $salin);
      $criteria->addCondition("t.create_ruangan_id = " . $_GET['ruangan_id']);
      $criteria->addCondition("t.pegawai_id = " . $_GET['pegawai_id']);
      $criteria->select = 't.*, pasienmorbiditas_r.tglmorbiditas, pasienmorbiditas_r.ruangan_id';
      $criteria->join = 'JOIN pasienmorbiditas_r ON pasienmorbiditas_r.pasienmorbiditas_id = t.pasienmorbiditas_id';
    }
    // echo '<pre>';var_dump($criteria);die;
    $model_ix = Pasienicd9cmT::model()->findAll($criteria);
    // echo '<pre>';var_dump($model_ix);die;

    $modDiagnosa = new PPDiagnosaM('searchDiagnosis');
    $modDiagnosaix = new DiagnosaicdixM();

    $modPasienMorbiditasR = PasienmorbiditasR::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'is_verifikasidiagnosa' => true));

    if (empty($modPasienMorbiditasR)) {
      if (isset($_REQUEST['PPPasienMorbiditasT'])) {
        // echo '<pre>';var_dump($_POST);die;
        $diagnosax = $_REQUEST['PPPasienMorbiditasT'];
        // $insert_form = $this->validasiTabular(
        //   $diagnosax,
        //   $modPendaftaran['pendaftaran_id'],
        //   true,
        //   (isset($modAdmisi->ruangan_id) ? $modAdmisi->ruangan_id : $modInstalasiPendaftaran->ruangan_id)
        // );

        // echo "<pre>";
        // var_dump($insert_form);die;
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $is_simpan = false;
          $is_create = false;
          $is_insert = false;
          $is_diagnosaUtama = null;
          $x = 0;

          $cek_pasienmorbitas_r = PasienmorbiditasR::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'is_verifikasidiagnosa' => false));

          $cek_pasienicd9_r = Pasienicd9cmR::model()->findByAttributes(array('pendaftaran_id' => $modPendaftaran->pendaftaran_id, 'is_verifikasidiagnosa' => false));
          // echo '<pre>';var_dump($_POST);die;
          foreach ($diagnosax as $val) {
            if ($val['pasienmorbiditas_id'] == null || $val['pasienmorbiditas_id'] == "" || !empty($salin)) {
              $is_create = true;
              $insert = new PPPasienMorbiditasT();
              $insert->attributes = $val;
              $golUmur = $this->cekGolonganUmur($modPendaftaran->golonganumur_id);
              $insert->kelompokumur_id = $modPasien->kelompokumur_id;
              $insert->golonganumur_id = $modPendaftaran->golonganumur_id;
              $insert->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;

              if (!$insert->ruangan_id) $insert->ruangan_id = Yii::app()->user->getState('ruangan_id');

              if (!empty($modAdmisi)) {
                $insert->ruangan_id = (isset($modAdmisi->ruangan_id) ? $modAdmisi->ruangan_id : $modInstalasiPendaftaran->ruangan_id);
                $insert->pasienadmisi_id = isset($modAdmisi->pasienadmisi_id) ? $modAdmisi->pasienadmisi_id : null;
              }
              $insert->kasusdiagnosa = (!empty($val['kasusdiagnosa']) ? $val['kasusdiagnosa'] : '');
              $insert->ppds_id = (!empty($val['ppds_id']) ? $val['ppds_id'] : null);
              $insert->statusdiagnosapasien = (!empty($val['statusdiagnosapasien']) ? $val['statusdiagnosapasien'] : '');
              $insert->ket_diagnosa = (!empty($val['ket_diagnosa']) ? $val['ket_diagnosa'] : '');

              $insert->pasien_id = $modPendaftaran->pasien_id;
              $insert->pendaftaran_id = $modPendaftaran->pendaftaran_id;
              $insert->create_ruangan = Yii::app()->user->getState('ruangan_id');
              $insert->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');

              if (!empty($golUmur)) {
                $insert->$golUmur = 1;
              }


              // echo '<pre>';var_dump($insert->save(), $insert->getErrors());
              if ($insert->save()) {


                PasienmorbiditasR::model()->catat($insert);

                $is_insert = true;
                if ($val['kelompokdiagnosa_id'] == 2) {
                  $is_diagnosaUtama = $insert->pasienmorbiditas_id;
                }
              }
            } else {
              $attributes = array(
                'pegawai_id' => $val['pegawai_id'],
                'diagnosa_id' => $val['diagnosa_id'],
                'kelompokdiagnosa_id' => $val['kelompokdiagnosa_id'],
                'ppds_id' => $val['ppds_id'],
                'ket_diagnosa' => $val['ket_diagnosa'],
                'kasusdiagnosa' => $val['kasusdiagnosa'],
                'statusdiagnosapasien' => $val['statusdiagnosapasien'],
                'update_time' => date('Y-m-d H:i:s'),
                'update_loginpemakai_id' => Yii::app()->user->getState('loginpemakai_id')

              );
              // var_dump($attributes, 'atribut');
              $update = PPPasienMorbiditasT::model()->updateByPk($val['pasienmorbiditas_id'], $attributes);
              if ($update) {
                $data_update = PPPasienMorbiditasT::model()->findByPk($val['pasienmorbiditas_id']);

                $cek_pasienmorbitas_r = PasienmorbiditasR::model()->findByAttributes(array('pasienmorbiditas_id' => $val['pasienmorbiditas_id'], 'is_verifikasidiagnosa' => false));
                // echo '<pre>';var_dump($data_update);die;
                PasienmorbiditasR::model()->updateRiwayat($data_update);
             
                $is_simpan = true;

                if ($val['kelompokdiagnosa_id'] == 2) {
                  $is_diagnosaUtama = $val['pasienmorbiditas_id'];
                }
              }
            }
            $x++;
          }
          // die;
          // echo '<pre>';var_dump($is_diagnosaUtama,'dsfsdfsf');die;
          if(empty($is_diagnosaUtama)) {
            if(!empty($pasienadmisi_id)) {
              // jika pasien rawat inap
              // mendapatkan diagnosa utama yang diinputkan di rawat inap
              $getDiagnosaUtama = PasienmorbiditasT::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id, 'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA]);
            } else {
              $getDiagnosaUtama = PasienmorbiditasT::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => null, 'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA]);
            }
            if(!empty($getDiagnosaUtama)) {
              $is_diagnosaUtama = $getDiagnosaUtama->pasienmorbiditas_id;
            }
          }
          // echo '<pre>';var_dump($is_diagnosaUtama);die;
          if (isset($_REQUEST['PPPasienMorbiditasix'])) {
            // echo "<pre>";
            // print_r($_POST['PPPasienMorbiditasix']);
            // exit;
            $diagnosaix = $_REQUEST['PPPasienMorbiditasix'];
            // $insert_ix_form = $this->validasiTabular($diagnosaix, $modPendaftaran['pendaftaran_id'], false, (isset($modAdmisi->ruangan_id) ? $modAdmisi->ruangan_id : $modInstalasiPendaftaran->ruangan_id));


            // echo '<pre>';var_dump($_POST);die;
            $modDiagnosa = $this->loadModel($pendaftaran_id);
            foreach ($diagnosaix as $value) {
              if ($value['pasienmorbiditas_id'] == null || $value['pasienmorbiditas_id'] == "") {
                $is_create = true;
                if (!empty($is_diagnosaUtama)) {
                  $is_insert = true;
                  // start RSSP-1815
                  $insert_icd9 = new RJPasienicd9cmT();
                  $insert_icd9->pasienadmisi_id = isset($modAdmisi->pasienadmisi_id) ? $modAdmisi->pasienadmisi_id : null;
                  $insert_icd9->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                  $insert_icd9->diagnosaicdix_id = $value['diagnosaicdix_id'];
                  //								$insert_icd9->pasienmorbiditas_id = $insert_ix->pasienmorbiditas_id;
                  $insert_icd9->pasienmorbiditas_id = $is_diagnosaUtama;
                  $insert_icd9->create_time = date('Y-m-d H:i:s');
                  $insert_icd9->create_loginpemakai_id = Yii::app()->user->id;
                  $insert_icd9->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
                  $insert_icd9->ruangan_id = Yii::app()->user->getState('ruangan_id');
                  $insert_icd9->kelompokdiagnosa_id =  $value['kelompokdiagnosa_id'];
                  $insert_icd9->ppds_id =  isset($value['ppds_id']) ? $value['ppds_id'] : null;
                  $insert_icd9->pegawai_id =  isset($value['pegawai_id']) ? $value['pegawai_id'] : null;
                  $insert_icd9->tglmorbiditas =  MyFormatter::formatDateTimeForDb($value['tglmorbiditas']) ?? null;
                  $insert_icd9->tglpasienicd9cm = $insert_icd9->tglmorbiditas;
                  $insert_icd9->keterangan = isset($value['keterangan']) ? $value['keterangan'] : null;




                  //   var_dump($insert_icd9);
                  //   die;
                  $insert_icd9->save();

                  // $cek_pasienicd9_r = Pasienicd9cmR::model()->findByAttributes(array('pasienmorbiditas_id' => $is_diagnosaUtama, 'is_verifikasidiagnosa' => false));

                  // if (!empty($cek_pasienicd9_r)) {
                  //   Pasienicd9cmR::model()->deleteAllByAttributes(array('pasienmorbiditas_id' => $is_diagnosaUtama, 'is_verifikasidiagnosa' => false));
                  // }

                  Pasienicd9cmR::model()->catat($insert_icd9);

                  // end RSSP-1815
                }
                //                            }
              } else {
                // $attributes = array(
                //   'pegawai_id' => $val['pegawai_id'],
                //   'kelompokdiagnosa_id' => $val['kelompokdiagnosa_id']


                // );
                // $update = PPPasienMorbiditasT::model()->updateByPk($value['pasienmorbiditas_id'], $attributes);
                // if ($update) {
                  $is_simpan = true;
                  // start RSSP-1815
                  $attributesIcd9 = array(
                    'update_time' => date('Y-m-d H:i:s'),
                    'diagnosaicdix_id' => $value['diagnosaicdix_id'],
                    'update_loginpemakai_id' => Yii::app()->user->id,
                    'create_ruangan_id' => $value['create_ruangan_id'],
                    'create_loginpemakai_id' => $value['create_loginpemakai_id'],
                    'kelompokdiagnosa_id' => $value['kelompokdiagnosa_id']
                  );
                  RJPasienicd9cmT::model()->updateAll($attributesIcd9, 'pasienmorbiditas_id=' . $value['pasienmorbiditas_id']);

                  $data_update = RJPasienicd9cmT::model()->findByPk($value['pasienicd9cm_id']);
                  if (!empty($data_update)) {
                    $cek_pasienicd9_r = Pasienicd9cmR::model()->findByAttributes(array('pasienicd9cm_id' => $value['pasienicd9cm_id'], 'is_verifikasidiagnosa' => false));

                    if (!empty($cek_pasienicd9_r)) {
                      Pasienicd9cmR::model()->deleteAllByAttributes(array('pasienicd9cm_id' => $value['pasienicd9cm_id'], 'is_verifikasidiagnosa' => false));
                    }
                    Pasienicd9cmR::model()->catat($data_update);
                  }
                  // end RSSP-1815
                // }
              }
            }
          }

          //proses update table icd ix
          if (isset($_REQUEST['Pasienicd9cmT'])) {
            $diagnosaicd9 = $_REQUEST['Pasienicd9cmT'];
            // $update_ix_form = $this->validasiTabular($diagnosaicd9, $modPendaftaran['pendaftaran_id'], false, (isset($modAdmisi->ruangan_id) ? $modAdmisi->ruangan_id : $modInstalasiPendaftaran->ruangan_id));
            $modDiagnosa = $this->loadModel($pendaftaran_id);
            // echo '<pre>';var_dump($update_ix_form);die;
            foreach ($diagnosaicd9 as $valicd) {
              if ($valicd['pasienmorbiditas_id'] != null || $valicd['pasienmorbiditas_id'] != "") {
                  $is_simpan = true;
                  if (!empty($valicd['pasienicd9cm_id'])) {
                    $attributesIcd9 = array(
                      'update_time' => date('Y-m-d H:i:s'),
                      'diagnosaicdix_id' => $valicd['diagnosaicdix_id'],
                      'update_loginpemakai_id' => Yii::app()->user->id,
                      'kelompokdiagnosa_id' => $valicd['kelompokdiagnosa_id'],
                      'keterangan' => isset($valicd['keterangan']) ? $valicd['keterangan'] : null
                    );

                    RJPasienicd9cmT::model()->updateAll($attributesIcd9, 'pasienicd9cm_id=' . $valicd['pasienicd9cm_id']);
                    $data_update = RJPasienicd9cmT::model()->findByPk($valicd['pasienicd9cm_id']);
                    if (!empty($data_update)) {
                      $cek_pasienicd9_r = Pasienicd9cmR::model()->findByAttributes(array('pasienicd9cm_id' => $valicd['pasienicd9cm_id'], 'is_verifikasidiagnosa' => false));

                      Pasienicd9cmR::model()->updateRiwayat($data_update);
                    }
                  }
                // }
              }

              if($valicd['pasienicd9cm_id'] == null || $valicd['pasienicd9cm_id'] == "") {
                if (!empty($is_diagnosaUtama)) {
                  $insert_icd9 = new RJPasienicd9cmT();
                  $insert_icd9->pasienadmisi_id = isset($modAdmisi->pasienadmisi_id) ? $modAdmisi->pasienadmisi_id : null;
                  $insert_icd9->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                  $insert_icd9->diagnosaicdix_id = $valicd['diagnosaicdix_id'];
                  $insert_icd9->pasienmorbiditas_id = $is_diagnosaUtama;
                  $insert_icd9->create_time = date('Y-m-d H:i:s');
                  $insert_icd9->create_loginpemakai_id = Yii::app()->user->id;
                  $insert_icd9->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
                  $insert_icd9->ruangan_id = Yii::app()->user->getState('ruangan_id');
                  $insert_icd9->kelompokdiagnosa_id =  $valicd['kelompokdiagnosa_id'];
                  $insert_icd9->ppds_id =  isset($val['ppds_id']) ? $val['ppds_id'] : null;
                  $insert_icd9->pegawai_id =  isset($valicd['pegawai_id']) ? $valicd['pegawai_id'] : null;
                  $insert_icd9->tglmorbiditas =  MyFormatter::formatDateTimeForDb($valicd['tglmorbiditas']) ?? null;
                  $insert_icd9->tglpasienicd9cm = $insert_icd9->tglmorbiditas;


                  $insert_icd9->save();

                  Pasienicd9cmR::model()->catat($insert_icd9);
                }
              }
            }
          }

          $pselesai = PendaftaranT::model()->findByPk($modPendaftaran['pendaftaran_id']);
          $findwaktu = WaktutunggupelayananT::model()->findByAttributes(array('pendaftaran_id' => $pselesai->pendaftaran_id, 'task_id' => '5'));
          $kodebooking = $pselesai->no_pendaftaran;
          if (!empty($pselesai) && $pselesai->instalasi_id == Params::INSTALASI_ID_RJ && (empty($pselesai->pasienadmisi_id)) && empty($findwaktu)) {
            $kodebooking = $pselesai->no_pendaftaran;

            if (!empty($pselesai->buatjanjipoli_id)) {
              $buatjanjipoli = BuatjanjipoliT::model()->findByPk($pselesai->buatjanjipoli_id);

              if (!empty($buatjanjipoli)) {
                $kodebooking = $buatjanjipoli->no_buatjanji;
              }
            }

            // $min = 900;
            // $max = 1800;
            // $rand_second = rand($min, $max);
            $tgltask_5 = new DateTime(date('Y-m-d H:i:s'));
            // $tgltask_5->add(new DateInterval("PT" . $rand_second . "S"));
            $datetask5 = $tgltask_5->format('Y-m-d H:i:s');

            $waktutunggupelayanan = new WaktutunggupelayananT();
            $waktutunggupelayanan->pendaftaran_id = $pselesai->pendaftaran_id;
            $waktutunggupelayanan->pasien_id = $pselesai->pasien_id;
            $waktutunggupelayanan->task_id = 5;
            $lookup_waktutunggu = LookupM::model()->findByAttributes(array('lookup_type' => 'taskid', 'lookup_value' => $waktutunggupelayanan->task_id));
            $waktutunggupelayanan->task_name = (!empty($lookup_waktutunggu) ? $lookup_waktutunggu->lookup_name : null);
            $dateNow = date('c', strtotime(MyFormatter::formatDateTimeForDb($datetask5)));
            $waktutunggupelayanan->waktutunggu_rs = date('Y-m-d H:i:s', strtotime($dateNow));

            $waktutunggupelayanan->tanggal = $waktutunggupelayanan->waktutunggu_rs;
            $waktutunggupelayanan->kode_booking = $kodebooking;
            $waktutunggupelayanan->statuskirim = 0;
            $waktutunggupelayanan->create_time = $waktutunggupelayanan->waktutunggu_rs;
            $waktutunggupelayanan->create_loginpemakai_id = Yii::app()->user->id;
            $waktutunggupelayanan->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
            $waktutunggupelayanan->waktutunggu_mil = (strtotime($dateNow) * 1000);

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
          } else {
            $tgltask_5 = new DateTime(date('Y-m-d H:i:s'));
            $datetask5 = $tgltask_5->format('Y-m-d H:i:s');

            if (!empty($findwaktu)) {
              # code...
              $lookup_waktutunggu = LookupM::model()->findByAttributes(array('lookup_type' => 'taskid', 'lookup_value' => $findwaktu->task_id));
              $findwaktu->task_name = (!empty($lookup_waktutunggu) ? $lookup_waktutunggu->lookup_name : null);
              $dateNow = date('c', strtotime(MyFormatter::formatDateTimeForDb($datetask5)));
              $findwaktu->waktutunggu_rs = date('Y-m-d H:i:s', strtotime($dateNow));

              $findwaktu->tanggal = $findwaktu->waktutunggu_rs;
              $findwaktu->kode_booking = $kodebooking;
              $findwaktu->statuskirim = 0;
              $findwaktu->create_time = $findwaktu->waktutunggu_rs;
              $findwaktu->create_loginpemakai_id = Yii::app()->user->id;
              $findwaktu->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
              $findwaktu->waktutunggu_mil = (strtotime($dateNow) * 1000);
              $findwaktu->save();
            }
          }
          // var_dump("OK"); die;
          if ($is_create) {
            if ($is_insert || $is_insert) {
              $transaction->commit();
              Yii::app()->user->setFlash('success', "Data berhasil disimpan");

              $modLogMorbi = new PasienmorbiditaslogR();
              $modLogMorbi->create_time = date('Y-m-d H:i:s');
              $modLogMorbi->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
              $modLogMorbi->create_ruangan = Yii::app()->user->getState('ruangan_id');
              $modLogMorbi->pendaftaran_id = $modPendaftaran->pendaftaran_id;
              $modLogMorbi->pasien_id = $modPendaftaran->pasien_id;
              $modLogMorbi->save();
              
              if ($modPendaftaran->statusperiksa == Params::STATUSPERIKSA_ANTRIAN) {
                $update = PendaftaranT::model()->updateByPk(
                  $pendaftaran_id,
                  array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA)
                );
              }

              //                        $criteria=new CDbCriteria;
              //						if(!empty($pendaftaran_id)){
              //							$criteria->addCondition("pendaftaran_id = ".$pendaftaran_id); 			
              //						}
              //                        $criteria->addCondition('diagnosaicdix_id IS NOT NULL');
              //                        $model_ix = PPPasienMorbiditasIx::model()->findAll($criteria);
              $criteria = new CDbCriteria;
              if (!empty($pendaftaran_id)) {
                $criteria->addCondition("t.pendaftaran_id = " . $pendaftaran_id);
                $criteria->addCondition("t.create_ruangan_id = " . Yii::app()->user->getState('ruangan_id'));
                $criteria->addCondition("t.pegawai_id = " . Yii::app()->user->getState('pegawai_id'));
                $criteria->select = 't.*, pasienmorbiditas_t.tglmorbiditas, pasienmorbiditas_t.kelompokdiagnosa_id, pasienmorbiditas_t.ruangan_id';
                $criteria->join = 'JOIN pasienmorbiditas_t ON pasienmorbiditas_t.pasienmorbiditas_id = t.pasienmorbiditas_id';
                
              }
              $model_ix = Pasienicd9cmT::model()->findAll($criteria);

              $model = $this->loadModel($pendaftaran_id);
              $modDiagnosa = new PPDiagnosaM('searchDiagnosis');
              $modDiagnosaix = new DiagnosaicdixM();


              $this->redirect(array('index', 'status' => 1, 'pendaftaran_id' => $pendaftaran_id, 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id, 'sukses' => 1));
            } else {
              Yii::app()->user->setFlash('danger', "Data tidak berhasil disimpan");
            }
          } else {
            if ($is_simpan) {
              $transaction->commit();
              Yii::app()->user->setFlash('success', "Data berhasil update");

              $modLogMorbi = new PasienmorbiditaslogR();
              $modLogMorbi->create_time = date('Y-m-d H:i:s');
              $modLogMorbi->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
              $modLogMorbi->create_ruangan = Yii::app()->user->getState('ruangan_id');
              $modLogMorbi->pendaftaran_id = $modPendaftaran->pendaftaran_id;
              $modLogMorbi->pasien_id = $modPendaftaran->pasien_id;
              $modLogMorbi->save();
              if ($modPendaftaran->statusperiksa == Params::STATUSPERIKSA_ANTRIAN) {
                $update = PendaftaranT::model()->updateByPk($pendaftaran_id, array('statusperiksa' => Params::STATUSPERIKSA_SEDANG_PERIKSA));
              }
              //                        $criteria=new CDbCriteria;
              //						if(!empty($pendaftaran_id)){
              //							$criteria->addCondition("pendaftaran_id = ".$pendaftaran_id); 			
              //						}
              //                        $criteria->addCondition('diagnosaicdix_id IS NOT NULL');
              //                        $model_ix = PPPasienMorbiditasIx::model()->findAll($criteria);
              $criteria = new CDbCriteria;
              if (!empty($pendaftaran_id)) {
                $criteria->addCondition("t.pendaftaran_id = " . $pendaftaran_id);
                $criteria->addCondition("t.create_ruangan_id = " . Yii::app()->user->getState('ruangan_id'));
                $criteria->addCondition("t.pegawai_id = " . Yii::app()->user->getState('pegawai_id'));
                $criteria->select = 't.*, pasienmorbiditas_t.tglmorbiditas, pasienmorbiditas_t.kelompokdiagnosa_id, pasienmorbiditas_t.ruangan_id';
                $criteria->join = 'JOIN pasienmorbiditas_t ON pasienmorbiditas_t.pasienmorbiditas_id = t.pasienmorbiditas_id';
              }
              $model_ix = Pasienicd9cmT::model()->findAll($criteria);

              $model = $this->loadModel($pendaftaran_id);
              $modDiagnosa = new PPDiagnosaM('searchDiagnosis');
              $modDiagnosaix = new DiagnosaicdixM();

              $this->redirect(array('index', 'status' => 1, 'pendaftaran_id' => $pendaftaran_id, 'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id));
            } else {
              Yii::app()->user->setFlash('error', "Data tidak berhasil update");
              $transaction->rollback();
            }
          }
        } catch (Exception $exc) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        }
      }
    }

    // echo '<pre>';var_dump($is_create, $is_simpan);die;

    if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_REKAMMEDIS || isset($_GET['lihat'])) {
      $this->render(
        $this->path_view . 'indexRekamMedis',
        array(
          'model' => $model,
          'modPendaftaran' => $modPendaftaran,
          'modDiagnosa' => $modDiagnosa,
          'modDiagnosaix' => $modDiagnosaix,
          'modUraian' => $modUraian,
          'modUraianIx' => $modUraianIx,
          'model_ix' => $model_ix,
          'path_view' => $this->path_view,
          'instalasi' => $instalasi,
          'modAdmisi' => $modAdmisi,
          'modRiwayat' => $modRiwayat
        )
      );
    } else {
      $this->render(
        $this->path_view . 'index',
        array(
          'model' => $model,
          'modPendaftaran' => $modPendaftaran,
          'modDiagnosa' => $modDiagnosa,
          'modDiagnosaix' => $modDiagnosaix,
          'modUraian' => $modUraian,
          'modUraianIx' => $modUraianIx,
          'model_ix' => $model_ix,
          'path_view' => $this->path_view,
          'instalasi' => $instalasi,
          'modAdmisi' => $modAdmisi,
          'modRiwayat' => $modRiwayat
        )
      );
    }
  }

  function actionCekDiagnosaUtama() {
      $pendaftaran_id = $_GET['pendaftaran_id'];
      $pasienadmisi_id = $_GET['pasienadmisi_id'];
      $ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : null;
      $pegawai_id = isset($_GET['pegawai_id']) ? $_GET['pegawai_id'] : null;
      $jumlahtrIX = isset($_GET['jumlahtrIX']) ? $_GET['jumlahtrIX'] : null;
      $jumlahtrX = isset($_GET['jumlahtrX']) ? $_GET['jumlahtrX'] : null;
      $salin = isset($_GET['salin']) ? $_GET['salin'] : 0; 
      $data['sudahAdaDiagnosaUtama'] = 0;
      // Jika validasi terlalu ruwet maka bisa ditanyakan ke programmer yang mengerjakan(full dikerjakan oleh M. Hidayat) dan analis nya mba wahyu may
      if(Yii::app()->user->getState('modul_id') != Params::MODUL_ID_RD) {
        if(!empty($pasienadmisi_id)) {
          // untuk rawat inap ditambahkan kondisi yang pasienadmisi_id nya ada
          if($salin == 1) {
            $modPasienMorbiditas = PasienmorbiditasT::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id, 'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA]);
          } else {
            $modPasienMorbiditas = PasienmorbiditasT::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => $pasienadmisi_id,'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA]);
          }

        } else {
          $modPasienMorbiditas = PasienmorbiditasT::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => null, 'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA]);
        }

        if(!empty($modPasienMorbiditas)) {
          $data['sudahAdaDiagnosaUtama'] = 1;
          $data['namadokter'] = $modPasienMorbiditas->pegawai->namaLengkap;
        }

        if($data['sudahAdaDiagnosaUtama'] == 1 && !empty($ruangan_id)) {
          $criteria = new CDbCriteria;
          if (!empty($pendaftaran_id)) {
            $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
          }
          $criteria->addCondition("ruangan_id = " . $ruangan_id);
          $criteria->addCondition("pegawai_id = " . $pegawai_id);
          $criteria->addCondition('diagnosaicdix_id IS NULL');
          $criteria->order = 'kelompokdiagnosa_id asc';
          $model = PPPasienMorbiditasT::model()->findAll($criteria);
          // echo '<pre>';var_dump($model);die;
          foreach ($model as $i => $val) {
            //dibuat null karena agar jadi data baru
            $val->pasienmorbiditas_id = null;
            $val->tglmorbiditas = date('Y-m-d H:i:s');
            $val->pegawai_id = Yii::app()->user->getState('pegawai_id');
          }
          $data['rowDiagnosaX'] = $this->renderPartial($this->path_view . '_rowDiagnosaX', [
                              'model' => $model,
                              'jumlahtr' => $jumlahtrX
                          ], true);

           // mengambil diagnosa IX
           $criteria = new CDbCriteria();
           $criteria->addCondition("t.pendaftaran_id = " . $pendaftaran_id);
           $criteria->addCondition("t.create_ruangan_id = " . $ruangan_id);
           $criteria->addCondition("t.pegawai_id = " . $pegawai_id);
           $criteria->select = 't.*, pasienmorbiditas_r.tglmorbiditas, pasienmorbiditas_r.ruangan_id';
           $criteria->join = 'JOIN pasienmorbiditas_r ON pasienmorbiditas_r.pasienmorbiditas_id = t.pasienmorbiditas_id';
         
           // echo '<pre>';var_dump($criteria);die;
           $model_ix = Pasienicd9cmT::model()->findAll($criteria);
 
           foreach (
             $model_ix as $i => $val) {
             $val->pasienicd9cm_id = null;
             $val->tglmorbiditas = date('Y-m-d H:i:s');
             $val->pegawai_id = Yii::app()->user->getState('pegawai_id');
           }
           $data['rowDiagnosaIX'] = $this->renderPartial($this->path_view . '_rowDiagnosaIX', [
               'model' => $model_ix,
               'jumlahtr' => $jumlahtrIX
           ], true);
        }
      } else {

        // khusus untuk rawat darurat kondisi query nya itu per ruangan login dan pegawai login
        $modPasienMorbiditas = PasienmorbiditasT::model()->findByAttributes(['pendaftaran_id' => $pendaftaran_id, 'pasienadmisi_id' => null, 'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA, 'ruangan_id' => Yii::app()->user->getState('ruangan_id'), 'pegawai_id' => Yii::app()->user->getState('pegawai_id')]);

        // cek sudah ada diagnosa utama atau belum
        if(!empty($modPasienMorbiditas)) {
          $data['sudahAdaDiagnosaUtama'] = 1;
          $data['namadokter'] = $modPasienMorbiditas->pegawai->namaLengkap;
        }

        // untuk menambahkan row diagnosa X dan IX ke tabel saat klik salin
        if(!empty($ruangan_id)) {
         
  
          // mengmbil row diagnosa X
          $criteria = new CDbCriteria;
          if (!empty($pendaftaran_id)) {
            $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
          }
          $criteria->addCondition("ruangan_id = " . $ruangan_id);
          $criteria->addCondition("pegawai_id = " . $pegawai_id);
          $criteria->addCondition('diagnosaicdix_id IS NULL');
          $criteria->order = 'kelompokdiagnosa_id asc';
          $model = PPPasienMorbiditasT::model()->findAll($criteria);
          // echo '<pre>';var_dump($model);die;
          foreach ($model as $i => $val) {
            //dibuat null karena agar jadi data baru
            $val->pasienmorbiditas_id = null;
            $val->tglmorbiditas = date('Y-m-d H:i:s');
            $val->pegawai_id = Yii::app()->user->getState('pegawai_id');
            if($val->kelompokdiagnosa_id == Params::KELOMPOKDIAGNOSA_UTAMA) {
              $data['sudahAdaDiagnosaUtama'] = 1;
            }
          }
          $data['rowDiagnosaX'] = $this->renderPartial($this->path_view . '_rowDiagnosaX', [
                              'model' => $model,
                              'jumlahtr' => $jumlahtrX
                          ], true);


          // mengambil diagnosa IX
          $criteria = new CDbCriteria();
          $criteria->addCondition("t.pendaftaran_id = " . $pendaftaran_id);
          $criteria->addCondition("t.create_ruangan_id = " . $ruangan_id);
          $criteria->addCondition("t.pegawai_id = " . $pegawai_id);
          $criteria->select = 't.*, pasienmorbiditas_r.tglmorbiditas, pasienmorbiditas_r.ruangan_id';
          $criteria->join = 'JOIN pasienmorbiditas_r ON pasienmorbiditas_r.pasienmorbiditas_id = t.pasienmorbiditas_id';
        
          // echo '<pre>';var_dump($criteria);die;
          $model_ix = Pasienicd9cmT::model()->findAll($criteria);

          foreach (
            $model_ix as $i => $val) {
            $val->pasienicd9cm_id = null;
            $val->tglmorbiditas = date('Y-m-d H:i:s');
            $val->pegawai_id = Yii::app()->user->getState('pegawai_id');
          }
          $data['rowDiagnosaIX'] = $this->renderPartial($this->path_view . '_rowDiagnosaIX', [
              'model' => $model_ix,
              'jumlahtr' => $jumlahtrIX
          ], true);

        }
        
      }

      echo json_encode($data);
  }

  public function actionGetDiagnosaixM()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria;
      $returnVal = array();

      if ($_GET['param'] == "kode") {
        $criteria->compare('LOWER(diagnosaicdix_kode)', strtolower($_GET['term']), true);
      }

      if ($_GET['param'] == "nama") {
        $ex = explode(" ", $_GET['term']);
        $hitung = count($ex);
        $diagnosa_nama = "";
        $lastKey = array_key_last($ex);
        if (!empty($ex)) {
          if ($hitung > 1) {
            foreach ($ex as $k => $det) {
              if ($k == $lastKey) {
                $diagnosa_nama .= "diagnosaicdix_nama ilike '%" . $det . "%' ";
              } else {
                $diagnosa_nama .= "diagnosaicdix_nama ilike '%" . $det . "%' and ";
              }
            }
            $criteria->addCondition($diagnosa_nama);
          } else {
            $criteria->compare('LOWER(diagnosaicdix_nama)', strtolower($_GET['term']), true);
          }
        }
      }

      if ($_GET['param'] == "lainnya") {
        $ex = explode(" ", $_GET['term']);
        $hitung = count($ex);
        $diagnosa_nama = "";
        $lastKey = array_key_last($ex);
        if (!empty($ex)) {
          if ($hitung > 1) {
            foreach ($ex as $k => $det) {
              if ($k == $lastKey) {
                $diagnosa_nama .= "diagnosaicdix_namalainnya ilike '%" . $det . "%' ";
              } else {
                $diagnosa_nama .= "diagnosaicdix_namalainnya ilike '%" . $det . "%' and ";
              }
            }
            $criteria->addCondition($diagnosa_nama);
          } else {
            $criteria->compare('LOWER(diagnosaicdix_namalainnya)', strtolower($_GET['term']), true);
          }
        }
      }
      $criteria->order = 'diagnosaicdix_nama';
      $criteria->addCondition("diagnosaicdix_aktif = true");
      $models = DiagnosaicdixM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = ($_GET['param'] == "lainnya" ? $model->diagnosaicdix_kode . ' - ' . $model->diagnosaicdix_namalainnya : $model->diagnosaicdix_kode . ' - ' . $model->diagnosaicdix_nama);
        $returnVal[$i]['value'] = $model->diagnosaicdix_id;
      }
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionGetDiagnosaM()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria;
      $returnVal = array();

      if ($_GET['param'] == "kode") {
        $criteria->compare('LOWER(diagnosa_kode)', strtolower($_GET['term']), true);
      }

      if ($_GET['param'] == "nama") {
        $ex = explode(" ", $_GET['term']);
        $hitung = count($ex);
        $diagnosa_nama = "";
        $lastKey = array_key_last($ex);
        if (!empty($ex)) {
          if ($hitung > 1) {
            foreach ($ex as $k => $det) {
              if ($k == $lastKey) {
                $diagnosa_nama .= "diagnosa_nama ilike '%" . $det . "%' ";
              } else {
                $diagnosa_nama .= "diagnosa_nama ilike '%" . $det . "%' and ";
              }
            }
            $criteria->addCondition($diagnosa_nama);
          } else {
            $criteria->compare('LOWER(diagnosa_nama)', strtolower($_GET['term']), true);
          }
        }
      }

      if ($_GET['param'] == "lainnya") {
        $ex = explode(" ", $_GET['term']);
        $hitung = count($ex);
        $diagnosa_nama = "";
        $lastKey = array_key_last($ex);
        if (!empty($ex)) {
          if ($hitung > 1) {
            foreach ($ex as $k => $det) {
              if ($k == $lastKey) {
                $diagnosa_nama .= "diagnosa_namalainnya ilike '%" . $det . "%' ";
              } else {
                $diagnosa_nama .= "diagnosa_namalainnya ilike '%" . $det . "%' and ";
              }
            }
            $criteria->addCondition($diagnosa_nama);
          } else {
            $criteria->compare('LOWER(diagnosa_namalainnya)', strtolower($_GET['term']), true);
          }
        }
      }
      $criteria->order = 'diagnosa_nama';
      $criteria->addCondition("diagnosa_aktif = true");
      $models = DiagnosaM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = ($_GET['param'] == "lainnya" ? $model->diagnosa_kode . ' - ' . $model->diagnosa_namalainnya : $model->diagnosa_kode . ' - ' . $model->diagnosa_nama);
        $returnVal[$i]['value'] = $model->diagnosa_id;
      }
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  protected function validasiTabular($params, $pendaftaran_id, $is_diagnosa = true, $ruangan_id = null)
  {
    $result = array();
    // echo '<pre>';var_dump($is_diagnosa);die;
    foreach ($params as $i => $val) {
      if ($val['pasienmorbiditas_id'] == null || $val['pasienmorbiditas_id'] == "" || (strlen($val['pasienmorbiditas_id']) == 0)) {
        if ($is_diagnosa) {
          $attributes = array(
            'pendaftaran_id' => $pendaftaran_id,
            'diagnosa_id' => $val['diagnosa_id'],
            'diagnosaicdix_id' => null,
            'ruangan_id' => $ruangan_id,
          );
        } else {
          $attributes = array(
            'pendaftaran_id' => $pendaftaran_id,
            'diagnosaicdix_id' => $val['diagnosaicdix_id'],
            'ruangan_id' => $ruangan_id,
          );
        }
        //				if($i == 0){
        //					echo "<pre>";
        //					print_r($_POST);
        //					
        // exit;
        //				}
        $model = PPPasienMorbiditasT::model()->findByAttributes($attributes);
        if (empty($model)) {
          $result[] = $val;
        }
      } else {
        $result[] = $val;
        /*
                $attributes = array(
                    'pendaftaran_id'=>$pendaftaran_id,
                    'diagnosa_id'=>$val['diagnosa_id']
                );
                $model = PPPasienMorbiditasT::model()->findByAttributes($attributes);
                if(!$model)
                {
                    $result[] = $val;
                }
                 */
      }
    }
    return $result;
  }

  public function actionHapusDiagnosax()
  {
    $delete = 'false';
    $msg = 'Data Gagal Dihapus';
    $id = (isset($_POST['pasienmorbiditas_id']) ? $_POST['pasienmorbiditas_id'] : null);
    $modGetPasienICD9 = Pasienicd9cmT::model()->findAllByAttributes(['pasienmorbiditas_id' => $_POST['pasienmorbiditas_id']]);
    if(count($modGetPasienICD9) > 0) {
      $delete = 'false';
      $msg = 'Data tidak dapat dihapus karena masih terdapat prosedur tindakan yang berelasi';
    } else {
      $transaction = Yii::app()->db->beginTransaction();
      $modR = PasienmorbiditasR::model()->findByAttributes(['pasienmorbiditas_id' => $id]);
      if(!empty($modR)) {
        $remove = $modR->delete();
      }
      $remove = PPPasienMorbiditasT::model()->deleteByPk($id);
      $hapusix = Pasienicd9cmT::model()->deleteAllByAttributes(array('pasienmorbiditas_id' => $id));
      if ($remove) {
        $transaction->commit();
        $delete = 'ok';
      } else {
        $transaction->rollback();
      }
      
    }
  
    
    echo CJSON::encode(array('status' => $delete, 'msg' => $msg));
  }

  public function actionHapusDiagnosaix()
  {
    $delete = 'false';
    $id = (isset($_POST['pasienicd9cm_id']) ? $_POST['pasienicd9cm_id'] : null);

    $transaction = Yii::app()->db->beginTransaction();
    $modR = Pasienicd9cmR::model()->findByAttributes(['pasienicd9cm_id' => $id]);
    if(!empty($modR)) {
      $remove = $modR->delete();
    }
    $remove = Pasienicd9cmT::model()->deleteByPk($id);

    if ($remove) {
      $transaction->commit();
      $delete = 'ok';
    } else {
      $transaction->rollback();
    }
    echo CJSON::encode(array('status' => $delete));
  }

  public function loadModel($pendaftaran_id)
  {
    $criteria = new CDbCriteria;
    if (!empty($pendaftaran_id)) {
      $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
    }
    $criteria->addCondition("ruangan_id = " . Yii::app()->user->getState('ruangan_id'));
    $criteria->addCondition("pegawai_id = " . Yii::app()->user->getState('pegawai_id'));
    $criteria->addCondition('diagnosaicdix_id IS NULL');
    $criteria->order = 'kelompokdiagnosa_id asc';
    $model = PPPasienMorbiditasT::model()->findAll($criteria);
    /*
        $attributes = array('pendaftaran_id'=>$id);
        $model = PPPasienMorbiditasT::model()->findAllByAttributes($attributes);
         * 
         */
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  protected function getKasusDiagnosa($pasien_id, $idDiagnosa)
  {
    $modMorbiditas = PasienmorbiditasT::model()->findByAttributes(array('pasien_id' => $pasien_id, 'diagnosa_id' => $idDiagnosa));
    if (!empty($modMorbiditas))
      return Params::KASUSDIAGNOSA_KASUS_LAMA;
    else
      return Params::KASUSDIAGNOSA_KASUS_BARU;
  }

  private function cekGolonganUmur($idGolonganUmur)
  {
    switch ($idGolonganUmur) {
      case 1:
        return 'umur_5_14thn';
      case 2:
        return 'umur_15_24thn';
      case 3:
        return 'umur_25_44thn';
      case 4:
        return 'umur_45_64thn';
      case 5:
        return 'umur_65';
      case 6:
        return 'umur_0_6hr';
      case 7:
        return 'umur_28hr_1thn';
      case 8:
        return 'umur_1_4thn';
      case 9:
        return 'umur_7_28hr';
      default:
        break;
    }
  }

  public function actionAjaxDetailDiagnosa()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pasienmorbiditas_id = $_POST['pasienmorbiditas_id'];
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $ruangan_id = $_POST['ruangan_id'];
      $pegawai_id = $_POST['pegawai_id'];
      $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
      $modDiagnosa = PasienmorbiditasR::model()->findAllByAttributes(['pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => $ruangan_id, 'pegawai_id' => $pegawai_id]);
      $modDiagnosaIX = Pasienicd9cmR::model()->findAllByAttributes(['pendaftaran_id' => $pendaftaran_id, 'create_ruangan_id' => $ruangan_id, 'pegawai_id' => $pegawai_id]);

      // echo '<pre>';var_dump(!empty($modDiagnosa[0]));die;
      if(!empty($modDiagnosa[0])) {
        $modPendaftaran->pegawai_nama = $modDiagnosa[0]->pegawai->namaLengkap ?? ""; 
        $modPendaftaran->ruangan_nama = $modDiagnosa[0]->ruangan->ruangan_nama ?? ""; 
      }

      $data['result'] = $this->renderPartial($this->path_view . '_viewDetailDiagnosa', array('modDiagnosa' => $modDiagnosa, 'modPendaftaran' => $modPendaftaran, 'modDiagnosaIX' => $modDiagnosaIX), true);

      echo json_encode($data);
      Yii::app()->end();
    }
  }
  public function actionAjaxDetailRiwayatDiagnosa()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $modPendaftaran = PPPendaftaranT::model()->findByPk($pendaftaran_id);
      $modDiagnosa = PasienmorbiditasR::model()->findAllByAttributes(['pendaftaran_id' => $pendaftaran_id], [
        'order' => 'create_time asc'
      ]);
      $modDiagnosaIX = Pasienicd9cmR::model()->findAllByAttributes(['pendaftaran_id' => $pendaftaran_id], [
        'order' => 'create_time asc'
      ]);

      $data['result'] = $this->renderPartial($this->path_view . '_viewDetailRiwayatDiagnosa', array('modDiagnosa' => $modDiagnosa, 'modPendaftaran' => $modPendaftaran, 'modDiagnosaIX' => $modDiagnosaIX), true);

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionPrint($pendaftaran_id = null)
  {
    $pendaftaran_id = $_GET['id'];
    $criteria = new CDbCriteria;

    // if (empty($pendaftaran_id)) {
    //     $criteria->addCondition("create_time=(select max(create_time) from reseptur_t)");
    // } else {
    //     $criteria->compare('pendaftaran_id', $pendaftaran_id);
    // }
    // $maxtime = RJResepturT::model()->find($criteria);
    $modDiagnosa = PPPasienMorbiditasT::model()->findAllByAttributes(['pendaftaran_id' => $pendaftaran_id]);
    $modDiagnosaIX = Pasienicd9cmT::model()->findAllByAttributes(['pendaftaran_id' => $pendaftaran_id]);
    $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);

    $judulLaporan = 'Reseptur';
    $caraPrint = $_REQUEST['caraPrint'];

    if (isset($_GET['pendaftaran_id'])) {
      $modDetailResep = ResepturdetailT::model()->findAllByAttributes(array('pendaftaran_id' => $_GET['pendaftaran_id']));
      if ($caraPrint == 'PRINT') {
        $this->layout = '//layouts/printWindows';
        $this->render($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modDiagnosa' => $modDiagnosa, 'modDiagnosaIX' => $modDiagnosaIX));
      } else if ($caraPrint == 'EXCEL') {
        $this->layout = '//layouts/printExcel';
        $this->render($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modDiagnosa' => $modDiagnosa, 'modDiagnosaIX' => $modDiagnosaIX));
      } else if ($_REQUEST['caraPrint'] == 'PDF') {
        $ukuranKertasPDF = Yii::app()->session['ukuran_kertas'];                  //Ukuran Kertas Pdf
        $posisi = Yii::app()->session['posisi_kertas'];                           //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', $ukuranKertasPDF);
        //$mpdf->useOddEven = 2;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
        $this->render($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modDiagnosa' => $modDiagnosa, 'modDiagnosaIX' => $modDiagnosaIX));
        $mpdf->Output();
      }
    } else {
      if ($caraPrint == 'PRINT') {
        $this->layout = '//layouts/printWindows';
        $this->render($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, "modDiagnosa" => $modDiagnosa, 'modDiagnosaIX' => $modDiagnosaIX));
      } else if ($caraPrint == 'EXCEL') {
        $this->layout = '//layouts/printExcel';
        $this->render($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modDiagnosa' => $modDiagnosa, 'modDiagnosaIX' => $modDiagnosaIX));
      } else if ($_REQUEST['caraPrint'] == 'PDF') {
        $ukuranKertasPDF = Yii::app()->session['ukuran_kertas'];                  //Ukuran Kertas Pdf
        $posisi = Yii::app()->session['posisi_kertas'];                           //Posisi L->Landscape,P->Portait
        $mpdf = new MyPDF60('', $ukuranKertasPDF);
        // $mpdf->useOddEven = 2;
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
        $mpdf->SetHTMLFooter('<span></span>');
        $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('modPendaftaran' => $modPendaftaran, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint, 'modDiagnosa' => $modDiagnosa, 'modDiagnosaIX' => $modDiagnosaIX), true));
        $mpdf->Output();
      }
    }
  }
  public function actionValidasiDiagnosa()
  {
    $pendaftaran_id = $_POST['pendaftaran_id'];
    $result = array();

    $modPasienMorbiditasR = PasienmorbiditasR::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'is_verifikasidiagnosa' => true));
    $result['is_verifikasi'] = !empty($modPasienMorbiditasR) ? 1 : 0;

    echo json_encode($result);
  }
}
