<?php
Yii::import('pendaftaranPenjadwalan.models.*');
class DiagnosaTPINewController extends MyAuthController
{
  public $path_view = 'perawatanIntensif.views.diagnosaTPINew.';

  public function actionIndex($pendaftaran_id, $pasienadmisi_id = null)
  {
    $this->layout = '//layouts/iframe';
    $modAdmisi = null;
    if (!empty($pasienadmisi_id)) {
      $modAdmisi = PasienadmisiT::model()->findByPk($pasienadmisi_id);
    }

    $model = $this->loadModel($pendaftaran_id);
    // echo '<pre>';print_r($model);die;
    $modUraian = new PPPasienMorbiditasT();
    $modUraian->pegawai_id = Yii::app()->user->getState('pegawai_id');
    $modUraianIx = new PPPasienMorbiditasIx();
    $modInstalasiPendaftaran = PPPendaftaranT::model()->findByPk($pendaftaran_id);
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
    // }

    $modPendaftaran = PPPendaftaranT::model()->findByPk($pendaftaran_id);
    
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);


    //        $criteria=new CDbCriteria;
    //		if(!empty($pendaftaran_id)){
    //			$criteria->addCondition("pendaftaran_id = ".$pendaftaran_id); 			
    //		}
    //        $criteria->addCondition('diagnosaicdix_id IS NOT NULL');
    //        $model_ix = PPPasienMorbiditasIx::model()->findAll($criteria);
    $criteria = new CDbCriteria;
    if (!empty($pendaftaran_id)) {
      $criteria->addCondition("t.pendaftaran_id = " . $pendaftaran_id);
      $criteria->select = 't.*, pasienmorbiditas_t.tglmorbiditas, pasienmorbiditas_t.pegawai_id, pasienmorbiditas_t.kelompokdiagnosa_id, pasienmorbiditas_t.ruangan_id,pasienmorbiditas_t.ppds_id';
      $criteria->join = 'JOIN pasienmorbiditas_t ON pasienmorbiditas_t.pasienmorbiditas_id = t.pasienmorbiditas_id';
    }
    $model_ix = Pasienicd9cmT::model()->findAll($criteria);

    $modDiagnosa = new PPDiagnosaM('searchDiagnosis');
    $modDiagnosaix = new DiagnosaicdixM();

    if (isset($_REQUEST['PPPasienMorbiditasT'])) {
      
      $diagnosax = $_REQUEST['PPPasienMorbiditasT'];
      // echo '<pre>'; print_r($_REQUEST);die;
      $insert_form = $this->validasiTabular($diagnosax, $modPendaftaran['pendaftaran_id'], true, (isset($modAdmisi->ruangan_id) ? $modAdmisi->ruangan_id : $modInstalasiPendaftaran->ruangan_id));

      $transaction = Yii::app()->db->beginTransaction();
      try {
        $is_simpan = false;
        $is_create = false;
        $is_insert = false;
        $is_diagnosaUtama = null;
        $x = 0;
        // echo '<pre>'; print_r($insert_form);die;
        foreach ($insert_form as $val) {
          if (empty($val['pasienmorbiditas_id'] )) {
            $is_create = true;
            $insert = new PPPasienMorbiditasT();
            $insert->attributes = $val;
            $golUmur = $this->cekGolonganUmur($modPendaftaran->golonganumur_id);
            $insert->kelompokumur_id = $modPasien->kelompokumur_id;
            $insert->golonganumur_id = $modPendaftaran->golonganumur_id;
            $insert->ppds_id = $modPendaftaran->ppds_id;
            $insert->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
            $insert->ruangan_id = Yii::app()->user->getState('ruangan_id');
            
            
            if (!empty($modAdmisi)) {
              $insert->ruangan_id = (isset($modAdmisi->ruangan_id) ? $modAdmisi->ruangan_id : $modInstalasiPendaftaran->ruangan_id);
            }
            //                        $insert->kasusdiagnosa = $this->getKasusDiagnosa($modPendaftaran->pasien_id, $val['diagnosa_id']);
            $insert->kasusdiagnosa = (!empty($val['kasusdiagnosa'])?$val['kasusdiagnosa']:'');
            $insert->pasien_id = $modPendaftaran->pasien_id;
            $insert->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $insert->$golUmur = 1;
            $insert->ket_diagnosa = (!empty($val['ket_diagnosa'])?$val['ket_diagnosa']:'');
            // echo "<pre>";
            // var_dump($insert);die;
            if ($insert->save()) {
              $is_insert = true;
              if ($val['kelompokdiagnosa_id'] == 2) {
                $is_diagnosaUtama = $insert->pasienmorbiditas_id;
              }
            }
          } else {
            $attributes = array(
              'pegawai_id' => $val['pegawai_id'],
              'diagnosa_id' => (!empty($val['diagnosa_id'])?$val['diagnosa_id']:''),
              'kelompokdiagnosa_id' => $val['kelompokdiagnosa_id'],
              'ppds_id'=> $val['kelompokdiagnosa_id'],
              'ket_diagnosa' => $val['ket_diagnosa']
            );
            $update = PPPasienMorbiditasT::model()->updateByPk($val['pasienmorbiditas_id'], $attributes);
            if ($update) {
              $is_simpan = true;
              if ($val['kelompokdiagnosa_id'] == 2) {
                $is_diagnosaUtama = $val['pasienmorbiditas_id'];
              }
            }
          }
          $x++;
        }

        if (isset($_REQUEST['PPPasienMorbiditasIx'])) {
          //					echo "<pre>";
          //					print_r($_POST);
          //					exit;
          $diagnosaix = $_REQUEST['PPPasienMorbiditasIx'];
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
                $insert_icd9 = new Pasienicd9cmT();
                $insert_icd9->pasienadmisi_id = isset($modPendaftaran->pasienadmisi_id) ? $modPendaftaran->pasienadmisi_id : null;
                $insert_icd9->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                $insert_icd9->diagnosaicdix_id = $value['diagnosaicdix_id'];
                //								$insert_icd9->pasienmorbiditas_id = $insert_ix->pasienmorbiditas_id;
                $insert_icd9->pasienmorbiditas_id = $is_diagnosaUtama;
                $insert_icd9->create_time = date('Y-m-d H:i:s');
                $insert_icd9->create_loginpemakai_id = Yii::app()->user->id;
                $insert_icd9->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
                $insert_icd9->save();
                // end RSSP-1815
              }
              //                            }
            } else {
              $attributes = array(
                'pegawai_id' => $value['pegawai_id'],
                //                                'diagnosaicdix_id' => $value['diagnosaicdix_id'],
                'kelompokdiagnosa_id' => $value['kelompokdiagnosa_id'],
                'ppds_id' => $value['ppds_id'],
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
                Pasienicd9cmT::model()->updateAll($attributesIcd9, 'pasienmorbiditas_id=' . $value['pasienmorbiditas_id']);
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
                  Pasienicd9cmT::model()->updateAll($attributesIcd9, 'pasienicd9cm_id=' . $valicd['pasienicd9cm_id']);
                }
              }
            }
          }
        }

        if ($is_create) {
          if ($is_insert || $is_insert) {
            
            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data berhasil disimpan");

            //                        $criteria=new CDbCriteria;
            //						if(!empty($pendaftaran_id)){
            //							$criteria->addCondition("pendaftaran_id = ".$pendaftaran_id); 			
            //						}
            //                        $criteria->addCondition('diagnosaicdix_id IS NOT NULL');
            //                        $model_ix = PPPasienMorbiditasIx::model()->findAll($criteria);
            $criteria = new CDbCriteria;
            if (!empty($pendaftaran_id)) {
              $criteria->addCondition("t.pendaftaran_id = " . $pendaftaran_id);
              $criteria->select = 't.*, pasienmorbiditas_t.tglmorbiditas, pasienmorbiditas_t.pegawai_id, pasienmorbiditas_t.kelompokdiagnosa_id, pasienmorbiditas_t.ruangan_id, pasienmorbiditas_t.ppds_id';
              $criteria->join = 'JOIN pasienmorbiditas_t ON pasienmorbiditas_t.pasienmorbiditas_id = t.pasienmorbiditas_id';
            }
            $model_ix = Pasienicd9cmT::model()->findAll($criteria);

            $model = $this->loadModel($pendaftaran_id);
            $modDiagnosa = new PPDiagnosaM('searchDiagnosis');
            $modDiagnosaix = new DiagnosaicdixM();
          } else {
            Yii::app()->user->setFlash('danger', "Data tidak berhasil disimpan");
          }
        } else {
          if ($is_simpan) {
            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data berhasil update");

            //                        $criteria=new CDbCriteria;
            //						if(!empty($pendaftaran_id)){
            //							$criteria->addCondition("pendaftaran_id = ".$pendaftaran_id); 			
            //						}
            //                        $criteria->addCondition('diagnosaicdix_id IS NOT NULL');
            //                        $model_ix = PPPasienMorbiditasIx::model()->findAll($criteria);
            $criteria = new CDbCriteria;
            if (!empty($pendaftaran_id)) {
              $criteria->addCondition("t.pendaftaran_id = " . $pendaftaran_id);
              $criteria->select = 't.*, pasienmorbiditas_t.tglmorbiditas, pasienmorbiditas_t.pegawai_id, pasienmorbiditas_t.kelompokdiagnosa_id, pasienmorbiditas_t.ruangan_id,pasienmorbiditas_t.ppds_id';
              $criteria->join = 'JOIN pasienmorbiditas_t ON pasienmorbiditas_t.pasienmorbiditas_id = t.pasienmorbiditas_id';
            }
            $model_ix = Pasienicd9cmT::model()->findAll($criteria);

            $model = $this->loadModel($pendaftaran_id);
            $modDiagnosa = new PPDiagnosaM('searchDiagnosis');
            $modDiagnosaix = new DiagnosaicdixM();
          } else {
            Yii::app()->user->setFlash('danger', "Data tidak berhasil update");
          }
        }
      } catch (Exception $exc) {
        var_dump($exc->getMessage());die;
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }
    // echo '<pre>';
    // var_dump(count((array)$model));die;
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

  protected function validasiTabular($params, $pendaftaran_id, $is_diagnosa = true, $ruangan_id = null)
  {
    
    $result = array();
    // echo '<pre>'; print_r($params);die;
    foreach ($params as $i => $val) {
      // var_dump($val);die;
      if (empty($val['pasienmorbiditas_id'])) {
        if ($is_diagnosa) {
          $attributes = array(
            'pasienmorbiditas_id'=> empty($val['pasienmorbiditas_id'])? NULL: $val['pasienmorbiditas_id'],
            'pendaftaran_id' => $pendaftaran_id,
            'diagnosa_id' => empty($val['diagnosa_id'])? NULL: $val['diagnosa_id'] ,
            'diagnosaicdix_id' => null,
            'ruangan_id' => $ruangan_id,
            'statusdiagnosapasien' => (!empty($val['statusdiagnosapasien']) ? $val['statusdiagnosapasien'] : ""),
            'ket_diagnosa' => (!empty($val['ket_diagnosa'])? $val['ket_diagnosa'] : ""),
          );
        } else {
          $attributes = array(
            'pasienmorbiditas_id'=> empty($val['pasienmorbiditas_id'])? NULL: $val['pasienmorbiditas_id'],
            'pendaftaran_id' => $pendaftaran_id,
            'diagnosaicdix_id' => empty($val['diagnosacdix_id'])? NULL: $val['diagnosacdix_id'] ,
            'ruangan_id' => $ruangan_id,
            'statusdiagnosapasien' => (!empty($val['statusdiagnosapasien']) ? $val['statusdiagnosapasien'] : ""),
            'ket_diagnosa' => empty($val['ket_diagnosa']) ? null : $val['ket_diagnosa']
          );
        }
        //				if($i == 0){
        //					echo "<pre>";
        //					print_r($_POST);
        //					
        //					echo "<pre>";
        //					print_r($val);
        //					exit;
        //				}
        $model = PPPasienMorbiditasT::model()->findByAttributes($attributes);

        if (!$model) {
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
}
