<?php

class VerifikasiDiagnosaController extends MyAuthController
{
  public $path_view = 'pendaftaranPenjadwalan.views.verifikasiDiagnosa.';

  public function actionIndex($id)
  {
    $this->layout = '//layouts/iframe';

    $modUraian = new PPPasienMorbiditasT();
    $modUraianIx = new PPPasienMorbiditasIx();
    $verifikasi = new VerifikasidiagnosaT;
    $verifikasi->pendaftaran_id = $id;
    $verifikasi->petugasverifikasi_id = Yii::app()->user->getState('pegawai_id');
    $verifikasi->ruangan_id = Yii::app()->user->getState('ruangan_id');
    $verifikasi->log_perubahan = array();
    $verifikasi->log_penghapusan = array();

    // mendapatkan verifikasidiagnosa terbaru untuk mengambil penyebab kematian
    $getDataVerifikasi = VerifikasidiagnosaT::model()->findByAttributes(['pendaftaran_id' => $id], ['order' => 'tgl_verifikasi Desc']);

    if(!empty($getDataVerifikasi)) {
      $verifikasi->penyebabkematian = $getDataVerifikasi->penyebabkematian;
    }
    
    $modResume = new ResumemedisR();
    $riwayatDiagnosaICDX = [];
    $riwayatDiagnosaICD9 = [];
    $riwayatDiagnosaKematian = [];
    $riwayatObatAlkesPasien = [];

    $menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
    if ($menu == 'RJ') {
      $modPendaftaran = PPInfoKunjunganRJV::model()->findByPk($id);

      // mengambil data resumemedis terbaru dari instalasi rawat inap
      $modResume = $this->getDataResume($id, [Params::INSTALASI_ID_RJ]);
      // echo '<pre>';var_dump($modResume);die;
      if(!empty($modResume)) {
        $modResume->diagnosamasuk = $modPendaftaran->diagnosamasuk;
        $modResume->pegawaipengisi_nama = $modResume->pegawaipengisi->namaLengkap;

        $riwayatDiagnosaICDX = $this->getDataDiagnosa10($modResume->resumemedis_id);
        $riwayatDiagnosaICD9 = $this->getDataDiagnosa9($modResume->resumemedis_id);
        $riwayatDiagnosaKematian = $this->getDiagnosaKematian($id);
        $riwayatObatAlkesPasien = $this->getDataObatDiberikan($modResume->resumemedis_id);
      }

    } else if ($menu == 'RD') {
      $modPendaftaran = PPInfoKunjunganRDV::model()->findByPk($id);

      // mengambil data resumemedis terbaru dari instalasi rawat darurat
      $modResume = $this->getDataResume($id, [Params::INSTALASI_ID_RD]);
      if(!empty($modResume)) {
        $modResume->diagnosamasuk = $modPendaftaran->diagnosamasuk;
        $modResume->pegawaipengisi_nama = $modResume->pegawaipengisi->namaLengkap;

        $riwayatDiagnosaICDX = $this->getDataDiagnosa10($modResume->resumemedis_id);
        $riwayatDiagnosaICD9 = $this->getDataDiagnosa9($modResume->resumemedis_id);
        $riwayatDiagnosaKematian = $this->getDiagnosaKematian($id);
        $riwayatObatAlkesPasien = $this->getDataObatDiberikan($modResume->resumemedis_id);
      }

    } else if ($menu == 'RI') {
      $modPendaftaran = PPInfoKunjunganRIV::model()->findByPk($id);

      // mengambil data resumemedis terbaru dari instalasi rawat inap
      $modResume = $this->getDataResume($id, Params::INSTALASI_ID_RI_ARR);
      // echo '<pre>';var_dump($modResume);die;
      if(!empty($modResume)) {
        $modResume->diagnosamasuk = $modPendaftaran->diagnosamasuk;
        $modResume->pegawaipengisi_nama = $modResume->pegawaipengisi->namaLengkap;

        $riwayatDiagnosaICDX = $this->getDataDiagnosa10($modResume->resumemedis_id);
        $riwayatDiagnosaICD9 = $this->getDataDiagnosa9($modResume->resumemedis_id);
        $riwayatDiagnosaKematian = $this->getDiagnosaKematian($id);
        $riwayatObatAlkesPasien = $this->getDataObatDiberikan($modResume->resumemedis_id);
      }
      $verifikasi->pasienadmisi_id = $modPendaftaran->pasienadmisi_id;

    } else if ($menu == 'VK') {
      $modPendaftaran = PPInfoKunjunganPersalinanV::model()->findByPk($id);
    }else if($menu == 'HD'){
      $modPendaftaran = PPInfoKunjunganHDV::model()->findByPk($id);
    }
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

    $criteria = new CDbCriteria;
    if (!empty($id)) {
      $criteria->addCondition("t.pendaftaran_id = " . $id);
      if($menu == 'RI') {
        if(!empty($modPendaftaran->pasienadmisi_id)) {
          $criteria->addCondition('t.pasienadmisi_id=' . $modPendaftaran->pasienadmisi_id);
        }
      } else {
        $criteria->addCondition('t.pasienadmisi_id is null');
      }
      $criteria->select = 't.*, pasienmorbiditas_r.tglmorbiditas, pasienmorbiditas_r.pegawai_id, pasienmorbiditas_r.ruangan_id';
      $criteria->join = 'JOIN pasienmorbiditas_r ON pasienmorbiditas_r.pasienmorbiditas_id = t.pasienmorbiditas_id';
      $criteria->addCondition('t.is_verifikasidiagnosa = True');
    }
    $model_ix = Pasienicd9cmR::model()->findAll($criteria);


    $model = $this->loadModel($id, $menu, $modPendaftaran->pasienadmisi_id);

    // echo "<pre>";
    // var_dump($model_ix, $criteria);die;
    

    $modDiagnosa = new PPDiagnosaM('searchDiagnosis');
    $modDiagnosaix = new DiagnosaicdixM();

    if (isset($_POST['VerifikasidiagnosaT'])) {
      $verifikasi->attributes = $_POST['VerifikasidiagnosaT'];
      $verifikasi->tgl_verifikasi = date('Y-m-d H:i:s');
      $verifikasi->penyebabkematian = isset($_POST['VerifikasidiagnosaT']['penyebabkematian']) ? $_POST['VerifikasidiagnosaT']['penyebabkematian'] : '';
    }

    
    if (isset($_REQUEST['PPPasienMorbiditasT']) || isset($_REQUEST['PasienmorbiditasR'])) {
      $transaction = Yii::app()->db->beginTransaction();
      PasienmorbiditasT::model()->deleteAllByAttributes(array('pendaftaran_id'=> $modPendaftaran['pendaftaran_id']));
      $diagnosax = isset($_REQUEST['PPPasienMorbiditasT']) ? $_REQUEST['PPPasienMorbiditasT'] : $_REQUEST['PasienmorbiditasR'] ;
      $insert_form = $this->validasiTabular($diagnosax, $modPendaftaran['pendaftaran_id']);
      
      try {
        $is_simpan = false;
        $is_create = false;
        $is_insert = false;
        $is_diagnosaUtama = null;
        $x = 0;
        
        
        foreach ($insert_form as $val) {
          
          if (empty($val['pasienmorbiditas_id'] )) {
            // var_dump($val);die;
            $is_create = true;
            $insert = new PPPasienMorbiditasT();
            $insert->attributes = $val;
            $insert->tglmorbiditas = MyFormatter::formatDateTimeForDb($val['tglmorbiditas']);
            $golUmur = $this->cekGolonganUmur($modPendaftaran->golonganumur_id);
            $insert->kelompokumur_id = $modPasien->kelompokumur_id;
            $insert->golonganumur_id = $modPendaftaran->golonganumur_id;
            $insert->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
            $insert->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $insert->kasusdiagnosa = $this->getKasusDiagnosa($modPendaftaran->pasien_id, $val['diagnosa_id']);
            $insert->pasien_id = $modPendaftaran->pasien_id;
            $insert->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $insert->$golUmur = 1;
            if($menu == 'RI') {
              $insert->pasienadmisi_id = $modPendaftaran->pasienadmisi_id ?? null;
            }
            if ($insert->save()) {
              $this->tambahLogSimpan($verifikasi, $insert);
              PasienmorbiditasR::model()->catat($insert, true);
              $is_insert = true;

              if ($val['kelompokdiagnosa_id'] == 2) {
                $is_diagnosaUtama = $insert->pasienmorbiditas_id;
              }
            }
          } else {
            $attributes = array(
              'tglmorbiditas' => MyFormatter::formatDateTimeForDb($val['tglmorbiditas']),
              'pegawai_id' => $val['pegawai_id'],
              'diagnosa_id' => $val['diagnosa_id'],
              'kelompokdiagnosa_id' => $val['kelompokdiagnosa_id'],
              'ket_diagnosa' => $val['ket_diagnosa']

            );
            $update_sebelum = PasienMorbiditasR::model()->findByAttributes(array('pasienmorbiditas_id'=>$val['pasienmorbiditas_id']));
            $update_sebelum->attributes = $attributes;

            $update =$update_sebelum->update();
            
            if ($update) {
              $is_simpan = true;
              $this->tambahLogUpdate($verifikasi, $attributes, $update_sebelum);
              // $update_sebelum->attributes = $attributes;

              $attributes = array(
                'tglmorbiditas' => MyFormatter::formatDateTimeForDb($val['tglmorbiditas']),
                'pegawai_id' => $val['pegawai_id'],
                'diagnosa_id' => $val['diagnosa_id'],
                'kelompokdiagnosa_id' => $val['kelompokdiagnosa_id'],
                'ket_diagnosa' => $val['ket_diagnosa'],
                'is_verifikasidiagnosa'=> True

              );
              $cek_pasienmorbitas_r = PasienmorbiditasR::model()->findByAttributes(array('pasienmorbiditas_id' => $val['pasienmorbiditas_id'], 'is_verifikasidiagnosa' => true));

              if (!empty($cek_pasienmorbitas_r)) {
                PasienmorbiditasR::model()->deleteAllByAttributes(array('pasienmorbiditas_id' => $val['pasienmorbiditas_id'], 'is_verifikasidiagnosa' => true));
              }

              // PasienmorbiditasR::model()->updateByPk($val['pasienmorbiditas_id'], $attributes);
              // var_dump($update_sebelum->attributes); die;
              PasienmorbiditasR::model()->catat($update_sebelum, true);

              PasienmorbiditasR::model()->catatTransaksi($update_sebelum);

              if ($val['kelompokdiagnosa_id'] == 2) {
                $is_diagnosaUtama = $val['pasienmorbiditas_id'];
              }
            }
          }
          $x++;
        }

        
        
        if (isset($_REQUEST['PPPasienMorbiditasix']) ) {

          Pasienicd9cmT::model()->deleteAllByAttributes(array('pendaftaran_id' => $modPendaftaran['pendaftaran_id']));
          $diagnosaix = $_REQUEST['PPPasienMorbiditasix'];
          // echo '<pre>';var_dump($diagnosaix);die;
          $insert_ix_form = $this->validasiTabular($diagnosaix, $modPendaftaran['pendaftaran_id'], false);
          // echo "<pre>";
          // var_dump($_POST);die;
          $modDiagnosa = $this->loadModel($id);
          foreach ($insert_ix_form as $value) {
            if ($value['pasienmorbiditas_id'] == null || $value['pasienmorbiditas_id'] == "") {

              $insert_icd9 = new Pasienicd9cmT();
              $insert_icd9->pasienadmisi_id = isset($modPendaftaran->pasienadmisi_id) ? $modPendaftaran->pasienadmisi_id : null;
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
              $insert_icd9->keterangan =  isset($value['keterangan']) ? $value['keterangan'] : null;
              if($menu == 'RI') {
                $insert->pasienadmisi_id = $modPendaftaran->pasienadmisi_id ?? null;
              }

              if ($insert_icd9->save()) {
                $this->tambahLogSimpan($verifikasi, $insert_icd9);
                $log = Pasienicd9cmR::model()->catat($insert_icd9, true);
                $is_insert = true;
              }
            } else {
              $attributes = array(
                'tglmorbiditas' => MyFormatter::formatDateTimeForDb($value['tglmorbiditas']),
                'pegawai_id' => $value['pegawai_id'],
                'diagnosaicdix_id' => $value['diagnosaicdix_id'],
                'kelompokdiagnosa_id' => $value['kelompokdiagnosa_id']
              );
              $update_sebelum = PasienMorbiditasR::model()->findByAttributes(array('pasienmorbiditas_id' => $value['pasienmorbiditas_id']));
              $update_sebelum->attributes = $attributes;

              $update = $update_sebelum->update();
              
              if ($update) {
                $this->tambahLogUpdate($verifikasi, $attributes, $update_sebelum);
                $attributes = array(
                  'pegawai_id' => $value['pegawai_id'],
                  'kelompokdiagnosa_id' => $value['kelompokdiagnosa_id']
                );
                $modPasienicd9R = Pasienicd9cmR::model()->findAllByAttributes(array('pasienmorbiditas_id'=> $value['pasienmorbiditas_id']));
                if(!empty($modPasienicd9R)){
                  foreach($modPasienicd9R as $items){
                    Pasienicd9cmR::model()->updateByPk($items->pasienicd9cm_id, $attributes);
                  }
                }
                $is_simpan = true;
              }
            }
          }
        }

        
        
        //proses update table icd ix
        if (isset($_REQUEST['Pasienicd9cmT']) || isset($_REQUEST['Pasienicd9cmR'])) {
          Pasienicd9cmT::model()->deleteAllByAttributes(array('pendaftaran_id' => $modPendaftaran['pendaftaran_id']));
          $diagnosaicd9 = isset($_REQUEST['Pasienicd9cmT']) ? $_REQUEST['Pasienicd9cmT'] : $_REQUEST['Pasienicd9cmR'];
          $pendaftaran_id = $modPendaftaran->pendaftaran_id;
          $update_ix_form = $this->validasiTabular($diagnosaicd9, $modPendaftaran['pendaftaran_id'], false);
          $modDiagnosa = $this->loadModel($pendaftaran_id);
          foreach ($update_ix_form as $valicd) {
            if ($valicd['pasienmorbiditas_id'] != null || $valicd['pasienmorbiditas_id'] != "") {
              $attributes = array(
                'pegawai_id' => $valicd['pegawai_id'],
                'kelompokdiagnosa_id' => $valicd['kelompokdiagnosa_id'],
                'pasienicd9cm_id' => $valicd['pasienicd9cm_id'],
                'diagnosaicdix_id' => $valicd['diagnosaicdix_id'],
              );
              // echo '<pre>';var_dump($valicd);die;
              $update_sebelum = PasienMorbiditasR::model()->findByAttributes(array('pasienmorbiditas_id' => $valicd['pasienmorbiditas_id']));
              
              $update_sebelum->attributes = $attributes;

              $update = $update_sebelum->update();
              if ($update) {
                $is_simpan = true;
                if (!empty($valicd['pasienicd9cm_id'])) {
                  $attributesIcd9 = array(
                    'update_time' => date('Y-m-d H:i:s'),
                    'diagnosaicdix_id' => $valicd['diagnosaicdix_id'],
                    'update_loginpemakai_id' => Yii::app()->user->id,
                    'kelompokdiagnosa_id' => $valicd['kelompokdiagnosa_id']
                  );

                  $update_sebelum = Pasienicd9cmR::model()->findByAttributes(array('pasienicd9cm_id' => $valicd['pasienicd9cm_id']));
                  $update_sebelum->attributes = $attributesIcd9;
                  $update = $update_sebelum->update();
                  Pasienicd9cmR::model()->updateAll($attributesIcd9, 'pasienicd9cm_id=' . $valicd['pasienicd9cm_id']);
                  Pasienicd9cmT::model()->updateAll($attributesIcd9, 'pasienicd9cm_id=' . $valicd['pasienicd9cm_id']);
                  $data_update = Pasienicd9cmR::model()->findByAttributes(array('pasienicd9cm_id' => $valicd['pasienicd9cm_id']));
                  if (!empty($data_update)) {
                    $cek_pasienmorbitas_r = Pasienicd9cmR::model()->findByAttributes(array('pasienicd9cm_id' => $valicd['pasienicd9cm_id'], 'is_verifikasidiagnosa' => true));

                    if (!empty($cek_pasienmorbitas_r)) {
                      Pasienicd9cmR::model()->deleteAllByAttributes(array('pasienicd9cm_id' => $valicd['pasienicd9cm_id'], 'is_verifikasidiagnosa' => true));
                    }
                    Pasienicd9cmR::model()->catat($data_update, true);

                    Pasienicd9cmR::model()->catatTransaksi($data_update);
                  }
                }
              }
            }
          }
        }


        if(isset($_POST['Diagnosa'])) {

            foreach ($_POST['Diagnosa'] as $ii => $data) {
              if($data['mortalitas_id'] == '') {
                // tambahan di verifikasi diagnosa
                $insert = new MortalitasR();
                $insert->tanggal = date('Y-m-d H:i:s');
                $insert->diagnosa_id = $data['diagnosa_id'];
                $insert->diagnosa_nama = $data['diagnosa_nama'];
                $insert->jumlah = 1;
                $insert->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $insert->created_by = Yii::app()->user->getState('loginpemakai_id');
                $insert->created_time = date('Y-m-d H:i:s');
                $insert->ruangan_id = Yii::app()->user->getState('ruangan_id');
                $insert->pegawai_id = Yii::app()->user->getState('pegawai_id');
                $insert->is_verifikasidiagnosa = true;
                if ($insert->save()) {
                    
                }
                
              } else {
                // update
                $insert = MortalitasR::model()->findByPk($data['mortalitas_id']);
                if(!empty($insert)) {
                  $insert->is_verifikasidiagnosa = true;
                  $insert->update();
                }
              }
            }
            // echo '<pre>';var_dump($insert->save(), $insert->getErrors());
        }
        


        $verifikasi->log_perubahan = CJSON::encode($verifikasi->log_perubahan);
        $verifikasi->log_penghapusan = CJSON::encode($verifikasi->log_penghapusan);
        $verifikasi->save();




        // die;

        if ($is_create) {
          
          if ($is_insert && $is_insert) {
            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data berhasil disimpan");

            $criteria = new CDbCriteria;
            if (!empty($id)) {
              $criteria->addCondition("t.pendaftaran_id = " . $id);
              $criteria->select = 't.*, pasienmorbiditas_r.tglmorbiditas, pasienmorbiditas_r.pegawai_id, pasienmorbiditas_r.kelompokdiagnosa_id, pasienmorbiditas_r.ruangan_id';
              $criteria->join = 'JOIN pasienmorbiditas_r ON pasienmorbiditas_r.pasienmorbiditas_id = t.pasienmorbiditas_id';
              $criteria->addCondition('t.is_verifikasidiagnosa = True');
            }
            $model_ix = Pasienicd9cmR::model()->findAll($criteria);
            // $criteria->addCondition('diagnosaicdix_id IS NOT NULL');
            // $model_ix = PPPasienMorbiditasIx::model()->findAll($criteria);

            $model = $this->loadModel($id);
            $modDiagnosa = new PPDiagnosaM('searchDiagnosis');
            $modDiagnosaix = new DiagnosaicdixM();
          } else {
            Yii::app()->user->setFlash('danger', "Data tidak berhasil disimpan");
          }
        } else {
          if ($is_simpan) {
            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data berhasil update");

            $criteria = new CDbCriteria;
            if (!empty($id)) {
              $criteria->addCondition("t.pendaftaran_id = " . $id);
              $criteria->select = 't.*, pasienmorbiditas_r.tglmorbiditas, pasienmorbiditas_r.pegawai_id, pasienmorbiditas_r.kelompokdiagnosa_id, pasienmorbiditas_r.ruangan_id';
              $criteria->join = 'JOIN pasienmorbiditas_r ON pasienmorbiditas_r.pasienmorbiditas_id = t.pasienmorbiditas_id';
              $criteria->addCondition('t.is_verifikasidiagnosa = True');
            }
            $model_ix = Pasienicd9cmR::model()->findAll($criteria);
            // $model_ix = Pasienicd9cmR::model()->findAll($criteria);

            $model = $this->loadModel($id);
            $modDiagnosa = new PPDiagnosaM('searchDiagnosis');
            $modDiagnosaix = new DiagnosaicdixM();
          } else {
            Yii::app()->user->setFlash('danger', "Data tidak berhasil update");
          }
        }
      } catch (Exception $exc) {
        var_dump($exc->getMessage(), $exc->getTraceAsString());die;
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $modRiwayat = new PasienMorbiditasT();
    $modRiwayat->pasien_id = $modPasien->pasien_id;

    $modRiwayatResume = new ResumemedisR();
    $modRiwayatResume->pendaftaran_id = $modPendaftaran->pendaftaran_id;

    $riwayatMortalitas = MortalitasR::model()->findAll('pendaftaran_id = '. $modPendaftaran->pendaftaran_id . ' and is_verifikasidiagnosa is true');

    // untuk pencegahan error ketika data resume medis null
    if(empty($modResume)) {
      $modResume = new ResumemedisR();
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
        'verifikasi' => $verifikasi,
        'modRiwayat' => $modRiwayat,
        'modRiwayatResume' => $modRiwayatResume,
        'riwayatMortalitas' => $riwayatMortalitas,
        'modResume' => $modResume,
        'riwayatDiagnosaICDX' => $riwayatDiagnosaICDX,
        'riwayatDiagnosaICD9' => $riwayatDiagnosaICD9,
        'riwayatDiagnosaKematian' => $riwayatDiagnosaKematian,
        'riwayatObatAlkesPasien' => $riwayatObatAlkesPasien
      )
    );
  }

  function getDataResume($pendaftaran_id, $arr_instalasi) {
    $criteria = new CDbCriteria();
    $criteria->join = 'JOIN ruangan_m r on r.ruangan_id = t.create_ruangan';
    $criteria->addCondition('pendaftaran_id=' . $pendaftaran_id);
    $criteria->addInCondition('r.instalasi_id', $arr_instalasi);
    $criteria->order = 'tglresume desc';
    $modResume = ResumemedisR::model()->find($criteria);
    return $modResume;
  }

  function getDataDiagnosa10($resumemedis_id) {
      //diagnosa icd-x
      $riwayatDiagnosaICDX = ResumemedisMorbiditasR::model()->findAllByAttributes(['resumemedis_id' => $resumemedis_id]);
      return $riwayatDiagnosaICDX;
  }

  function getDataDiagnosa9($resumemedis_id) {
      //diagnosa icd-x
      $riwayatDiagnosa9 = ResumemedisIcd9R::model()->findAllByAttributes(['resumemedis_id' => $resumemedis_id]);
      return $riwayatDiagnosa9;
  }

  function getDiagnosaKematian($pendaftaran_id) {
    $riwayatDiagnosaKematian = MortalitasR::model()->findAll("pendaftaran_id = " . $pendaftaran_id . " and is_verifikasidiagnosa = false");

    return $riwayatDiagnosaKematian;
  }

  function getDataObatDiberikan($resumemedis_id) {
    $riwayatObat = ResumemedisObatR::model()->findAllByAttributes(['resumemedis_id' => $resumemedis_id]);
    return $riwayatObat;
  }

  function actionSetDetailResume() {
    $resumemedis_id = $_GET['resumemedis_id'];
    $pendaftaran_id = $_GET['pendaftaran_id'];

    $data['status'] = 0;
    $modResume = ResumemedisR::model()->findByPk($resumemedis_id);
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);

    if(!empty($modResume) && !empty($modPendaftaran)) {
      $data['status'] = 1;

      $modResume->diagnosamasuk = $modPendaftaran->diagnosamasuk;
      $modResume->pegawaipengisi_nama = $modResume->pegawaipengisi->namaLengkap;

      $riwayatDiagnosaICDX = $this->getDataDiagnosa10($modResume->resumemedis_id);
      $riwayatDiagnosaICD9 = $this->getDataDiagnosa9($modResume->resumemedis_id);
      $riwayatDiagnosaKematian = $this->getDiagnosaKematian($pendaftaran_id);
      $riwayatObatAlkesPasien = $this->getDataObatDiberikan($modResume->resumemedis_id);

      $data['html'] = $this->renderPartial($this->path_view . '_formDetailResume', [
                          'modResume' => $modResume,
                          'riwayatDiagnosaICDX' => $riwayatDiagnosaICDX,
                          'riwayatDiagnosaICD9' => $riwayatDiagnosaICD9,
                          'riwayatDiagnosaKematian' => $riwayatDiagnosaKematian,
                          'riwayatObatAlkesPasien' => $riwayatObatAlkesPasien
                      ], true);
    }

    echo json_encode($data);

  }

  function actionAddRowDiagnosa() {
      $jumlahtr = $_POST['jumlahtr'];
      $diagnosa_id = $_POST['diagnosa_id'];
      $diagnosa_kode = $_POST['diagnosa_kode'];
      $diagnosa_nama = $_POST['diagnosa_nama'];
      $diagnosa_namalainnya = $_POST['diagnosa_namalainnya'];

      $data['html'] = $this->renderPartial($this->path_view . '_rowDiagnosaKematian', [
          'jumlahtr' => $jumlahtr,
          'diagnosa_id' => $diagnosa_id,
          'diagnosa_nama' => $diagnosa_nama,
          'diagnosa_kode' => $diagnosa_kode,
          'diagnosa_namalainnya' => $diagnosa_namalainnya,
          'mortalitas_id' => ''
      ], true);

      echo json_encode($data);

  }

  function actionHapusDiagnosaKematian() {
    $mortalitas_id = $_POST['mortalitas_id'];

    MortalitasR::model()->deleteByPk($mortalitas_id);

    echo json_encode(['status' => 1]);
  }

  protected function tambahLogSimpan(&$verifikasi, $insert)
  {

    $arr = $verifikasi->log_perubahan;

    $arr[] = array(
      "tipe" => "insert",
      "tglmorbiditas_sebelum" => null,
      "tglmorbiditas_sesudah" => $insert->tglmorbiditas ?? null,
      "diagnosa_id_sebelum" => null,
      "diagnosa_id_sesudah" => $insert->diagnosa_id ?? null,
      "diagnosaicdix_id_sebelum" => null,
      "diagnosaicdix_id_sesudah" => $insert->diagnosaicdix_id ?? null,
      "pegawai_id_sebelum" => null,
      "pegawai_id_sesudah" => $insert->pegawai_id ?? null,
      "kelompokdiagnosa_sebelum" => null,
      "kelompokdiagnosa_sesudah" => $insert->kelompokdiagnosa_id ?? null,
    );

    $verifikasi->log_perubahan = $arr;



  }

  protected function tambahLogUpdate($verifikasi, $attributes, $update_sebelum)
  {
    if (!empty($update_sebelum)) {

      $arr = $verifikasi->log_perubahan;

      $arr[] = array(
        "tipe" => "update",
        "tglmorbiditas_sebelum" => $update_sebelum->tglmorbiditas,
        "tglmorbiditas_sesudah" => $attributes['tglmorbiditas'],
        "diagnosa_id_sebelum" => $update_sebelum->diagnosa_id,
        "diagnosa_id_sesudah" => empty($attributes['diagnosa_id']) ? null : $attributes['diagnosa_id'],
        "diagnosaicdix_id_sebelum" => $update_sebelum->diagnosaicdix_id,
        "diagnosaicdix_id_sesudah" => empty($attributes['diagnosaicdix_id']) ? null : $attributes['diagnosaicdix_id'],
        "pegawai_id_sebelum" => $update_sebelum->pegawai_id,
        "pegawai_id_sesudah" => $attributes['pegawai_id'],
        "kelompokdiagnosa_sebelum" => $update_sebelum->kelompokdiagnosa_id,
        "kelompokdiagnosa_sesudah" => $attributes['kelompokdiagnosa_id'],
      );
      $verifikasi->log_perubahan = $arr;
    } else {

      $arr = $verifikasi->log_penghapusan;
      if (!isset($attributes['diagnosa_id'])) {
        $attributes['diagnosa_id'] = null;
      }
      if (!isset($attributes['diagnosaicdix_id'])) {
        $attributes['diagnosaicdix_id'] = null;
      }

      $arr[] = $attributes;

      $verifikasi->log_penghapusan = $arr;
    }
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
        $criteria->compare('LOWER(diagnosaicdix_nama)', strtolower($_GET['term']), true);
      }

      if ($_GET['param'] == "lainnya") {
        $criteria->compare('LOWER(diagnosaicdix_namalainnya)', strtolower($_GET['term']), true);
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
        $criteria->compare('LOWER(diagnosa_nama)', strtolower($_GET['term']), true);
      }

      if ($_GET['param'] == "lainnya") {
        $criteria->compare('LOWER(diagnosa_namalainnya)', strtolower($_GET['term']), true);
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

  protected function validasiTabular($params, $pendaftaran_id, $is_diagnosa = true)
  {
    $result = array();
    // echo "<pre>";
    // var_dump($params);
    // die;
    foreach ($params as $i => $val) {
      if (empty($val['pasienmorbiditas_id'])) {
        if ($is_diagnosa) {
          $attributes = array(
            'pendaftaran_id' => $pendaftaran_id,
            'diagnosa_id' =>empty($val['diagnosa_id'])? NULL: $val['diagnosa_id'],
            // 'ket_diagnosa' => $val['ket_diagnosa'] 
          );
        } else {
          $attributes = array(
            'pendaftaran_id' => $pendaftaran_id,
            'diagnosaicdix_id' => $val['diagnosaicdix_id'],
            // 'ket_diagnosa' => $val['ket_diagnosa']
          );
        }
        $model = PPPasienMorbiditasT::model()->findByAttributes($attributes);
        if (!$model) {
          $result[] = $val;
        }
      } else {
        $result[] = $val;
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
    $removeR = PasienmorbiditasR::model()->deleteAllByAttributes(['pasienmorbiditas_id' => $id]);
    if ($remove || $removeR) {
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
    $removeR = Pasienicd9cmR::model()->deleteAllByAttributes(['pasienicd9cm_id' => $id]);
    if ($remove || $removeR) {
      $transaction->commit();
      $delete = 'ok';
    } else {
      $transaction->rollback();
    }
    echo CJSON::encode(array('status' => $delete));
  }

  public function actionAjaxDetailDiagnosa()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pasienmorbiditas_id = $_POST['pasienmorbiditas_id'];
      $pendaftaran_id = $_POST['pendaftaran_id'];
      $modPendaftaran = PPPendaftaranT::model()->findByPk($pendaftaran_id);
      $modDiagnosa = PPPasienMorbiditasT::model()->findAllByAttributes(['pendaftaran_id' => $pendaftaran_id]);
      $modDiagnosaIX = Pasienicd9cmT::model()->findAllByAttributes(['pendaftaran_id' => $pendaftaran_id]);

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
        'order'=>'create_time asc'
      ]);
      $modDiagnosaIX = Pasienicd9cmR::model()->findAllByAttributes(['pendaftaran_id' => $pendaftaran_id], [
        'order'=>'create_time asc'
      ]);

      $data['result'] = $this->renderPartial($this->path_view . '_viewDetailRiwayatDiagnosa', array('modDiagnosa' => $modDiagnosa, 'modPendaftaran' => $modPendaftaran, 'modDiagnosaIX' => $modDiagnosaIX), true);

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function loadModel($id, $menu = null, $pasienadmisi_id = null)
  {
    $criteria = new CDbCriteria;
    if (!empty($id)) {
      $criteria->addCondition("pendaftaran_id = " . $id);
    }
    if(!empty($menu) && !empty($pasienadmisi_id)) {
      $criteria->addCondition("pasienadmisi_id = " . $pasienadmisi_id);
    } else {
      $criteria->addCondition('t.pasienadmisi_id is null');
    }
    // $criteria->addCondition('diagnosaicdix_id IS NULL');
    $criteria->addCondition('is_verifikasidiagnosa = True');
    $model = PasienmorbiditasR::model()->findAll($criteria);
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
    $modMorbiditas = PasienmorbiditasT::model()->findByAttributes(array('pasien_id' => $pasien_id, 'diagnosa_id' => empty($idDiagnosa)?NULL: $idDiagnosa));
    if (!empty($modMorbiditas))
      return Params::KASUSDIAGNOSA_KASUS_LAMA;
    else
      return Params::KASUSDIAGNOSA_KASUS_BARU;
  }

  private function cekGolonganUmur($idGolonganUmur)
  {
    switch ($idGolonganUmur) {
      case 1:
        return 'umur_0_28hr';
      case 2:
        return 'umur_28hr_1thn';
      case 3:
        return 'umur_1_4thn';
      case 4:
        return 'umur_5_14thn';
      case 5:
        return 'umur_15_24thn';
      case 6:
        return 'umur_25_44thn';
      case 7:
        return 'umur_45_64thn';
      case 8:
        return 'umur_65';

      default:
        break;
    }
  }
}
