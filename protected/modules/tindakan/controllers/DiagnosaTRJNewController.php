<?php
Yii::import('pendaftaranPenjadwalan.models.*');
Yii::import('hemodialisa.models.*');
Yii::import('rehabMedis.models.*');
Yii::import('perawatanIntensif.models.*');
Yii::import('persalinan.models.*');
Yii::import('mcu.models.*');
class DiagnosaTRJNewController extends MyAuthController
{
  public $path_view = 'rawatJalan.views.diagnosaTRJNew.';

  public function actionIndex($pendaftaran_id, $pasienadmisi_id = null, $salin = null)
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
    //        $menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
    $instalasi = $modInstalasiPendaftaran->instalasi_id;
    // if ($instalasi == Params::INSTALASI_ID_RJ) {
    //   $modPendaftaran = PPInfoKunjunganRJV::model()->findByPk($pendaftaran_id);
    // } else if ($instalasi == Params::INSTALASI_ID_RD) {
    //   $modPendaftaran = PPInfoKunjunganRDV::model()->findByPk($pendaftaran_id);
    // } else if ($instalasi == Params::INSTALASI_ID_RI) {
    //   $modPendaftaran = PPInfoKunjunganRIV::model()->findByPk($pendaftaran_id);
    // } else if ($instalasi == Params::INSTALASI_ID_PERAWATAN_INTENSIF) {
    //   $modPendaftaran = PIInfopasienmasukkamarV::model()->findByPk($pendaftaran_id);
    // } else if ($instalasi == Params::INSTALASI_ID_REHAB) {
    //   $modPendaftaran = RMMasukPenunjangV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    // } else if ($instalasi == Params::INSTALASI_ID_HD) {
    //   $modPendaftaran = HDInfoKunjunganRDV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    // } else if ($instalasi == Params::INSTALASI_ID_PERSALINAN) {
    //   $modPendaftaran = PSInfokunjunganpersalinanV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    // } else if ($instalasi == Params::INSTALASI_ID_MCU) {
    //   $modPendaftaran = MCInfokunjunganmcuV::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id));
    // } else {
      $modPendaftaran = $modInstalasiPendaftaran;
    // }
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

    $modRiwayat = new PPPasienMorbiditasT();
    $modRiwayat->pasien_id = $modPasien->pasien_id;


    //        $criteria=new CDbCriteria;
    //		if(!empty($pendaftaran_id)){
    //			$criteria->addCondition("pendaftaran_id = ".$pendaftaran_id); 			
    //		}
    //        $criteria->addCondition('diagnosaicdix_id IS NOT NULL');
    //        $model_ix = PPPasienMorbiditasIx::model()->findAll($criteria);
    $criteria = new CDbCriteria;
    if (!empty($pendaftaran_id)) {
      $criteria->addCondition("t.pendaftaran_id = " . $pendaftaran_id);
      $criteria->select = 't.*, pasienmorbiditas_t.tglmorbiditas, pasienmorbiditas_t.pegawai_id, pasienmorbiditas_t.kelompokdiagnosa_id, pasienmorbiditas_t.ruangan_id';
      $criteria->join = 'JOIN pasienmorbiditas_t ON pasienmorbiditas_t.pasienmorbiditas_id = t.pasienmorbiditas_id';
    }
    if (!empty($salin)) {
      $criteria->addCondition("t.pendaftaran_id = " . $salin);
      $criteria->select = 't.*, pasienmorbiditas_t.tglmorbiditas, pasienmorbiditas_t.pegawai_id, pasienmorbiditas_t.kelompokdiagnosa_id, pasienmorbiditas_t.ruangan_id';
      $criteria->join = 'JOIN pasienmorbiditas_t ON pasienmorbiditas_t.pasienmorbiditas_id = t.pasienmorbiditas_id';
    }
    $model_ix = Pasienicd9cmT::model()->findAll($criteria);

    $modDiagnosa = new PPDiagnosaM('searchDiagnosis');
    $modDiagnosaix = new DiagnosaicdixM();

    if (isset($_REQUEST['PPPasienMorbiditasT'])) {
      $diagnosax = $_REQUEST['PPPasienMorbiditasT'];
      $insert_form = $this->validasiTabular(
        $diagnosax,
        $modPendaftaran['pendaftaran_id'],
        true,
        (isset($modAdmisi->ruangan_id) ? $modAdmisi->ruangan_id : $modInstalasiPendaftaran->ruangan_id));

        

      $transaction = Yii::app()->db->beginTransaction();
      try {
        $is_simpan = false;
        $is_create = false;
        $is_insert = false;
        $is_diagnosaUtama = null;
        $x = 0;
        foreach ($insert_form as $val) {
          if ($val['pasienmorbiditas_id'] == null || $val['pasienmorbiditas_id'] == "" || !empty($salin)) {
            $is_create = true;
            $insert = new PPPasienMorbiditasT();
            $insert->attributes = $val;
            $golUmur = $this->cekGolonganUmur($modPendaftaran->golonganumur_id);
            $insert->kelompokumur_id = $modPasien->kelompokumur_id;
            $insert->golonganumur_id = $modPendaftaran->golonganumur_id;
            $insert->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
            
            if(!$insert->ruangan_id) $insert->ruangan_id = Yii::app()->user->getState('ruangan_id');
            
            if (!empty($modAdmisi)) {
              $insert->ruangan_id = (isset($modAdmisi->ruangan_id) ? $modAdmisi->ruangan_id : $modInstalasiPendaftaran->ruangan_id);
            }
            //                        $insert->kasusdiagnosa = $this->getKasusDiagnosa($modPendaftaran->pasien_id, $val['diagnosa_id']);
         //   $insert->kasusdiagnosa = (!empty($val['kasusdiagnosa'])?$val['kasusdiagnosa']:'');
            $insert->ppds_id = (!empty($val['ppds_id'])?$val['ppds_id']:'');
            $insert->statusdiagnosapasien = (!empty($val['statusdiagnosapasien'])?$val['statusdiagnosapasien']:'');
            $insert->ket_diagnosa = (!empty($val['ket_diagnosa'])?$val['ket_diagnosa']:'');

         //   $insert->kasusdiagnosa = $val['kasusdiagnosa'];
            
            $insert->pasien_id = $modPendaftaran->pasien_id;
            $insert->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            if (!empty($golUmur)) {
              $insert->$golUmur = 1;
            }
                // var_dump($insert->attributes);
                // var_dump($insert->validate());
                // die;
                
            if ($insert->save()) {
            
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
              'statusdiagnosapasien' => $val['statusdiagnosapasien'],
              
              
            );
            $update = PPPasienMorbiditasT::model()->updateByPk($val['pasienmorbiditas_id'], $attributes);
            if ($update) {
                // var_dump($update);
                // die;

            
              $is_simpan = true;


         
              if ($val['kelompokdiagnosa_id'] == 2) {
                $is_diagnosaUtama = $val['pasienmorbiditas_id'];
              }
            }
          }
          $x++;
        }

        if (isset($_REQUEST['PPPasienMorbiditasix'])) {
          //					echo "<pre>";
          //					print_r($_POST);
          //					exit;
          $diagnosaix = $_REQUEST['PPPasienMorbiditasix'];
          $insert_ix_form = $this->validasiTabular($diagnosaix, $modPendaftaran['pendaftaran_id'], false, (isset($modAdmisi->ruangan_id) ? $modAdmisi->ruangan_id : $modInstalasiPendaftaran->ruangan_id));

          $modDiagnosa = $this->loadModel($pendaftaran_id);
          foreach ($insert_ix_form as $value) {
            if ($value['pasienmorbiditas_id'] == null || $value['pasienmorbiditas_id'] == "") {
              $is_create = true;
              //                            $insert_ix = new PPPasienMorbiditasIx();
              //                            $insert_ix->diagnosa_id = $modDiagnosa[0]->diagnosa_id;
              //                            $insert_ix->tglmorbiditas = $value['tglmorbiditas'];
              //                            $insert_ix->kelompokdiagnosa_id = $value['kelompokdiagnosa_id'];
              //                            $insert_ix->pegawai_id = $value['pegawai_id'];
              //                            $insert_ix->diagnosaicdix_id = $value['diagnosaicdix_id'];
              //                            $insert_ix->ruangan_id = Yii::app()->user->getState('ruangan_id');
              //                            if(count((array)$modAdmisi)){
              //                                $insert_ix->ruangan_id = $modAdmisi->ruangan_id;
              //                            }
              //
              //                            $golUmur = $this->cekGolonganUmur($modPendaftaran->golonganumur_id);
              //                            $insert_ix->kelompokumur_id = $modPasien->kelompokumur_id;
              //                            $insert_ix->golonganumur_id = $modPendaftaran->golonganumur_id;
              //                            $insert_ix->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
              ////                            $insert_ix->ruangan_id = Yii::app()->user->getState('ruangan_id');
              ////                            $insert_ix->kasusdiagnosa = $this->getKasusDiagnosa($modPendaftaran->pasien_id, $val['diagnosa_id']);
              //                            $insert_ix->kasusdiagnosa = $this->getKasusDiagnosa($modPendaftaran->pasien_id, $insert_ix->diagnosa_id);
              //                            $insert_ix->pasien_id = $modPendaftaran->pasien_id;
              //                            $insert_ix->pendaftaran_id = $modPendaftaran->pendaftaran_id;
              //                            $insert_ix->$golUmur = 1;

              //                            if($insert_ix->save())
              //                            {

              if (!empty($is_diagnosaUtama)) {
                $is_insert = true;
                // start RSSP-1815
                $insert_icd9 = new RJPasienicd9cmT();
                $insert_icd9->pasienadmisi_id = isset($modPendaftaran->pasienadmisi_id) ? $modPendaftaran->pasienadmisi_id : null;
                $insert_icd9->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $insert_icd9->diagnosaicdix_id = $value['diagnosaicdix_id'];
                //								$insert_icd9->pasienmorbiditas_id = $insert_ix->pasienmorbiditas_id;
                $insert_icd9->pasienmorbiditas_id = $is_diagnosaUtama;
                $insert_icd9->create_time = date('Y-m-d H:i:s');
                $insert_icd9->create_loginpemakai_id = Yii::app()->user->id;
                $insert_icd9->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
                $insert_icd9->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $insert_icd9->kelompokdiagnosa_id =  $val['kelompokdiagnosa_id'];
                $insert_icd9->ppds_id =  isset($val['ppds_id']) ? $val['ppds_id'] : null;
                $insert_icd9->pegawai_id =  isset($val['pegawai_id']) ? $val['pegawai_id'] : null;
                $insert_icd9->tglmorbiditas =  MyFormatter::formatDateTimeForDb($val['tglmorbiditas']) ?? null;


            //   var_dump($insert_icd9);
            //   die;
                $insert_icd9->save();
                // end RSSP-1815
              }
              //                            }
            } else {
              $attributes = array(
                'pegawai_id' => $val['pegawai_id'],
                'kelompokdiagnosa_id' => $val['kelompokdiagnosa_id']
                
                
              );
              $update = PPPasienMorbiditasT::model()->updateByPk($value['pasienmorbiditas_id'], $attributes);
              if ($update) {
                $is_simpan = true;
                // start RSSP-1815
                $attributesIcd9 = array(
                  'update_time' => date('Y-m-d H:i:s'),
                  'diagnosaicdix_id' => $value['diagnosaicdix_id'],
                  'update_loginpemakai_id' => Yii::app()->user->id
                );
                RJPasienicd9cmT::model()->updateAll($attributesIcd9, 'pasienmorbiditas_id=' . $value['pasienmorbiditas_id']);
                // end RSSP-1815
              }
            }
          }
        }

        //proses update table icd ix
        if (isset($_REQUEST['Pasienicd9cmT'])) {
          $diagnosaicd9 = $_REQUEST['Pasienicd9cmT'];

          $update_ix_form = $this->validasiTabular($diagnosaicd9, $modPendaftaran['pendaftaran_id'], false, (isset($modAdmisi->ruangan_id) ? $modAdmisi->ruangan_id : $modInstalasiPendaftaran->ruangan_id));
          $modDiagnosa = $this->loadModel($pendaftaran_id);
          foreach ($update_ix_form as $valicd) {
            if ($valicd['pasienmorbiditas_id'] != null || $valicd['pasienmorbiditas_id'] != "") {
              $attributes = array(
                'pegawai_id' => $valicd['pegawai_id'],
                'kelompokdiagnosa_id' => $valicd['kelompokdiagnosa_id']
              );
              $update = PPPasienMorbiditasT::model()->updateByPk($valicd['pasienmorbiditas_id'], $attributes);
              if ($update) {
                $is_simpan = true;
                if (!empty($valicd['pasienicd9cm_id'])) {
                  $attributesIcd9 = array(
                    'update_time' => date('Y-m-d H:i:s'),
                    'diagnosaicdix_id' => $valicd['diagnosaicdix_id'],
                    'update_loginpemakai_id' => Yii::app()->user->id
                  );
                  RJPasienicd9cmT::model()->updateAll($attributesIcd9, 'pasienicd9cm_id=' . $valicd['pasienicd9cm_id']);
                }
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
        }else{
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

        if ($is_create) {
          if ($is_insert || $is_insert) {
            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data berhasil disimpan" );

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
              $criteria->select = 't.*, pasienmorbiditas_t.tglmorbiditas, pasienmorbiditas_t.pegawai_id, pasienmorbiditas_t.kelompokdiagnosa_id, pasienmorbiditas_t.ruangan_id';
              $criteria->join = 'JOIN pasienmorbiditas_t ON pasienmorbiditas_t.pasienmorbiditas_id = t.pasienmorbiditas_id';
            }
            $model_ix = Pasienicd9cmT::model()->findAll($criteria);

            $model = $this->loadModel($pendaftaran_id);
            $modDiagnosa = new PPDiagnosaM('searchDiagnosis');
            $modDiagnosaix = new DiagnosaicdixM();

            $this->redirect(array('index', 'status' => 1, 'pendaftaran_id' => $pendaftaran_id, 'sukses' => 1));
          } else {
            Yii::app()->user->setFlash('danger', "Data tidak berhasil disimpan");
          }
        } else {
          if ($is_simpan) {
            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data berhasil update");

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
              $criteria->select = 't.*, pasienmorbiditas_t.tglmorbiditas, pasienmorbiditas_t.pegawai_id, pasienmorbiditas_t.kelompokdiagnosa_id, pasienmorbiditas_t.ruangan_id';
              $criteria->join = 'JOIN pasienmorbiditas_t ON pasienmorbiditas_t.pasienmorbiditas_id = t.pasienmorbiditas_id';
            }
            $model_ix = Pasienicd9cmT::model()->findAll($criteria);

            $model = $this->loadModel($pendaftaran_id);
            $modDiagnosa = new PPDiagnosaM('searchDiagnosis');
            $modDiagnosaix = new DiagnosaicdixM();

            $this->redirect(array('index', 'status' => 1, 'pendaftaran_id' => $pendaftaran_id));
          } else {
            Yii::app()->user->setFlash('danger', "Data tidak berhasil update");
          }
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

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
    $id = (isset($_POST['pasienmorbiditas_id']) ? $_POST['pasienmorbiditas_id'] : null);

    $transaction = Yii::app()->db->beginTransaction();
    $remove = PPPasienMorbiditasT::model()->deleteByPk($id);
    $hapusix = Pasienicd9cmT::model()->deleteAllByAttributes(array('pasienmorbiditas_id' => $id));
    if ($remove) {
      $transaction->commit();
      $delete = 'ok';
    } else {
      $transaction->rollback();
    }
    echo CJSON::encode(array('status' => $delete));
  }

  public function actionHapusDiagnosaix()
  {
    $delete = 'false';
    $id = (isset($_POST['pasienicd9cm_id']) ? $_POST['pasienicd9cm_id'] : null);

    $transaction = Yii::app()->db->beginTransaction();
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
    $criteria->addCondition('diagnosaicdix_id IS NULL');
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
      $modPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
      $modDiagnosa = PPPasienMorbiditasT::model()->findAllByAttributes(['pendaftaran_id' => $pendaftaran_id]);
      $modDiagnosaIX = Pasienicd9cmT::model()->findAllByAttributes(['pendaftaran_id' => $pendaftaran_id]);

      $data['result'] = $this->renderPartial($this->path_view . '_viewDetailDiagnosa', array('modDiagnosa' => $modDiagnosa, 'modPendaftaran' => $modPendaftaran, 'modDiagnosaIX' => $modDiagnosaIX), true);

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
}