<?php
Yii::import('pendaftaranPenjadwalan.models.*');
/**
 * digunakan sebagai url utama untuk mengelola transaksi diagnosa ix
 * @author Elham Budianto <elhambudianto1@gmail.com>
 * @package application.modules.rawatJalan
 * @subpackage controllers
 */
class DiagnosaIXController extends MyAuthController
{
  //    public $path_view = 'pendaftaranPenjadwalan.views.verifikasiDiagnosa.';
  public $path_view = 'rawatJalan.views.diagnosaIX.';

  /**
   * Menampilkan transaksi diagnosa ix
   * @param type $pendaftaran_id
   */
  public function actionIndex($pendaftaran_id)
  {
    $this->layout = '//layouts/iframe';
    $model = $this->loadModel($pendaftaran_id);
    $modUraian = new PPPasienMorbiditasT();
    $modUraianIx = new PPPasienMorbiditasIx();
    $modInstalasiPendaftaran = RJPendaftaranT::model()->findByPk($pendaftaran_id);
    //        $menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
    $instalasi = $modInstalasiPendaftaran->instalasi_id;

    $rjid = array();

    foreach (Params::grupInstalasiRJID() as $rj) {
      $rjid[$rj] = $rj;
    }

    if ($instalasi == Params::INSTALASI_ID_RJ || isset($rjid[$instalasi])) {
      $modPendaftaran = PPInfoKunjunganRJV::model()->findByPk($pendaftaran_id);
    } elseif ($instalasi == Params::INSTALASI_ID_RD) {
      $modPendaftaran = PPInfoKunjunganRDV::model()->findByPk($pendaftaran_id);
    } elseif ($instalasi == Params::INSTALASI_ID_RI) {
      $modPendaftaran = PPInfoKunjunganRIV::model()->findByPk($pendaftaran_id);
    } elseif (Yii::app()->user->getState('instalasi_id') == Params::INSTALASI_ID_RM) {
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    } else {
      $modPendaftaran = PPPasienmasukpenunjangV::model()->findByAttributes(array(
        'pendaftaran_id' => $pendaftaran_id
      ));
    }

    if (empty($modPendaftaran)) {
      $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    }


    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);

    $criteria = new CDbCriteria;
    if (!empty($pendaftaran_id)) {
      $criteria->addCondition("t.pendaftaran_id = " . $pendaftaran_id);
      //$criteria->select = 't.*, pasienmorbiditas_t.tglmorbiditas, pasienmorbiditas_t.pegawai_id, pasienmorbiditas_t.kelompokdiagnosa_id, pasienmorbiditas_t.ruangan_id';
      $criteria->select = 't.*, pasienmorbiditas_t.tglmorbiditas, t.pegawai_id, t.kelompokdiagnosa_id, pasienmorbiditas_t.ruangan_id';
      $criteria->join = 'JOIN pasienmorbiditas_t ON pasienmorbiditas_t.pasienmorbiditas_id = t.pasienmorbiditas_id';
      $criteria->order = 't.kelompokdiagnosa_id ASC';
    }
    $model_ix = Pasienicd9cmT::model()->findAll($criteria);

    $modDiagnosa = new PPDiagnosaM('searchDiagnosis');
    $modDiagnosaix = new DiagnosaicdixM();

    if (isset($_REQUEST['PPPasienMorbiditasT'])) {
      $diagnosax = $_REQUEST['PPPasienMorbiditasT'];
      $insert_form = $this->validasiTabular($diagnosax, $modPendaftaran['pendaftaran_id']);

      $transaction = Yii::app()->db->beginTransaction();
      try {
        $is_simpan = false;
        $is_create = false;
        $is_insert = false;
        $is_diagnosaUtama = null;
        $x = 0;
        foreach ($insert_form as $val) {
          if (empty($val['pasienmorbiditas_id'] )) {
            $is_create = true;
            $insert = new PPPasienMorbiditasT();
            $insert->attributes = $val;
            $golUmur = $this->cekGolonganUmur($modPendaftaran->golonganumur_id);
            $insert->kelompokumur_id = $modPasien->kelompokumur_id;
            $insert->golonganumur_id = $modPendaftaran->golonganumur_id;
            $insert->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
            $insert->ruangan_id = Yii::app()->user->getState('ruangan_id');
            //                        $insert->kasusdiagnosa = $this->getKasusDiagnosa($modPendaftaran->pasien_id, $val['diagnosa_id']);
            $insert->kasusdiagnosa = (!empty($val['kasusdiagnosa'])?$val['kasusdiagnosa']:'');
            $insert->pasien_id = $modPendaftaran->pasien_id;
            $insert->pendaftaran_id = $modPendaftaran->pendaftaran_id;
            $insert->pegawai_id = $val['pegawai_id'];
            $insert->ket_diagnosa = (!empty($val['ket_diagnosa'])?$val['ket_diagnosa']:'');
            $insert->$golUmur = 1;
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

        if (isset($_REQUEST['PPPasienMorbiditasix'])) {
          $diagnosaix = $_REQUEST['PPPasienMorbiditasix'];
          $insert_ix_form = $this->validasiTabular($diagnosaix, $modPendaftaran['pendaftaran_id'], false);

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
              //
              //                            $golUmur = $this->cekGolonganUmur($modPendaftaran->golonganumur_id);
              //                            $insert_ix->kelompokumur_id = $modPasien->kelompokumur_id;
              //                            $insert_ix->golonganumur_id = $modPendaftaran->golonganumur_id;
              //                            $insert_ix->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
              //                            $insert_ix->ruangan_id = Yii::app()->user->getState('ruangan_id');
              //                                    $insert_ix->kasusdiagnosa = $this->getKasusDiagnosa($modPendaftaran->pasien_id, $val['diagnosa_id']);
              //                            $insert_ix->kasusdiagnosa = $this->getKasusDiagnosa($modPendaftaran->pasien_id, $insert_ix->diagnosa_id);
              //                            $insert_ix->pasien_id = $modPendaftaran->pasien_id;
              //                            $insert_ix->pendaftaran_id = $modPendaftaran->pendaftaran_id;
              //                            $insert_ix->$golUmur = 1;

              //                            if($insert_ix->save())
              //                            {
              //if (!empty($is_diagnosaUtama)) {
              $is_insert = true;
              // start RSSP-1815
              $insert_icd9 = new RJPasienicd9cmT();
              $insert_icd9->pasienadmisi_id = isset($modPendaftaran->pasienadmisi_id) ? $modPendaftaran->pasienadmisi_id : null;
              $insert_icd9->pendaftaran_id = $modPendaftaran->pendaftaran_id;
              $insert_icd9->diagnosaicdix_id = $value['diagnosaicdix_id'];
              //                                $insert_icd9->pasienmorbiditas_id = $insert_ix->pasienmorbiditas_id;
              $insert_icd9->pasienmorbiditas_id = $is_diagnosaUtama;
              $insert_icd9->kelompokdiagnosa_id = $value['kelompokdiagnosa_id'];
              $insert_icd9->pegawai_id = $value['pegawai_id'];
              $insert_icd9->create_time = date('Y-m-d H:i:s');
              $insert_icd9->create_loginpemakai_id = Yii::app()->user->id;
              $insert_icd9->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
              $insert_icd9->save();
              // end RSSP-1815
              //}
              //                            }
            } else {
              $attributes = array(
                'pegawai_id' => $value['pegawai_id'],
                //                                'diagnosaicdix_id' => $value['diagnosaicdix_id'],
                'kelompokdiagnosa_id' => $value['kelompokdiagnosa_id']
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
          $update_ix_form = $this->validasiTabular($diagnosaicd9, $modPendaftaran['pendaftaran_id'], false);
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

        if ($is_create) {

          if ($is_insert) {
            $up = RJPendaftaranT::model()->findByPk($pendaftaran_id);
            $up->statusperiksa = Params::STATUSPERIKSA_SUDAH_DIPERIKSA;
            $up->save();

            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data berhasil disimpan");

            $criteria = new CDbCriteria;
            if (!empty($pendaftaran_id)) {
              $criteria->addCondition("t.pendaftaran_id = " . $pendaftaran_id);
              //$criteria->select = 't.*, pasienmorbiditas_t.tglmorbiditas, pasienmorbiditas_t.pegawai_id, pasienmorbiditas_t.kelompokdiagnosa_id, pasienmorbiditas_t.ruangan_id';
              $criteria->select = 't.*, pasienmorbiditas_t.tglmorbiditas, t.pegawai_id, t.kelompokdiagnosa_id, pasienmorbiditas_t.ruangan_id';
              $criteria->join = 'JOIN pasienmorbiditas_t ON pasienmorbiditas_t.pasienmorbiditas_id = t.pasienmorbiditas_id';
              $criteria->order = 't.kelompokdiagnosa_id ASC';
            }
            $model_ix = Pasienicd9cmT::model()->findAll($criteria);

            $model = $this->loadModel($pendaftaran_id);
            $modDiagnosa = new PPDiagnosaM('searchDiagnosis');
            $modDiagnosaix = new DiagnosaicdixM();
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('danger', "Data tidak berhasil disimpan");
          }
        } else {
          if ($is_simpan) {
            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data berhasil update");

            $criteria = new CDbCriteria;
            if (!empty($pendaftaran_id)) {
              $criteria->addCondition("t.pendaftaran_id = " . $pendaftaran_id);
              //$criteria->select = 't.*, pasienmorbiditas_t.tglmorbiditas, pasienmorbiditas_t.pegawai_id, pasienmorbiditas_t.kelompokdiagnosa_id, pasienmorbiditas_t.ruangan_id';
              $criteria->select = 't.*, pasienmorbiditas_t.tglmorbiditas, t.pegawai_id, t.kelompokdiagnosa_id, pasienmorbiditas_t.ruangan_id';
              $criteria->join = 'JOIN pasienmorbiditas_t ON pasienmorbiditas_t.pasienmorbiditas_id = t.pasienmorbiditas_id';
              $criteria->order = 't.kelompokdiagnosa_id ASC';
            }
            $model_ix = Pasienicd9cmT::model()->findAll($criteria);

            $model = $this->loadModel($pendaftaran_id);
            $modDiagnosa = new PPDiagnosaM('searchDiagnosis');
            $modDiagnosaix = new DiagnosaicdixM();
          } else {
            $transaction->rollback();
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
      )
    );
  }

  /**
   * Mendapatkan data diagnosa x
   * @param type $term
   * @param type $param
   */
  public function actionGetDiagnosaixM($term = "", $param = "")
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria;
      $returnVal = array();

      if ($param == "kode") {
        $criteria->compare('LOWER(diagnosaicdix_kode)', strtolower($term), true);
      } elseif ($param == "nama") {
        $criteria->compare('LOWER(diagnosaicdix_nama)', strtolower($term), true);
      } elseif ($param == "lainnya") {
        $criteria->compare('LOWER(diagnosaicdix_namalainnya)', strtolower($term), true);
      } elseif ($param == "mixed") {
        $criteria->addCondition(
          ""
            . "(lower(diagnosaicdix_kode) ilike '%" . $term . "%' or "
            . "lower(diagnosaicdix_nama) ilike '%" . $term . "%' or "
            . " lower(diagnosaicdix_namalainnya) ilike '%" . $term . "%'"
            . ")"
        );
      }

      $criteria->order = 'diagnosaicdix_nama';
      $criteria->addCondition("diagnosaicdix_aktif = true");
      $models = DiagnosaicdixM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = ($param == "lainnya" ? $model->diagnosaicdix_kode . ' - ' . $model->diagnosaicdix_namalainnya : $model->diagnosaicdix_kode . ' - ' . $model->diagnosaicdix_nama);
        $returnVal[$i]['value'] = $model->diagnosaicdix_id;
      }
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * Mendapatkan data diagnosa
   * @param type $term
   * @param type $param
   */
  public function actionGetDiagnosaM($term = "", $param = "")
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria;
      $returnVal = array();

      if ($param == "kode") {
        $criteria->compare('LOWER(diagnosa_kode)', strtolower($term), true);
      } elseif ($param == "nama") {
        $criteria->compare('LOWER(diagnosa_nama)', strtolower($term), true);
      } elseif ($param == "lainnya") {
        $criteria->compare('LOWER(diagnosa_namalainnya)', strtolower($term), true);
      } elseif ($param == "mixed") {
        $criteria->addCondition(
          ""
            . "(lower(diagnosa_kode) ilike '%" . $term . "%' or "
            . "lower(diagnosa_nama) ilike '%" . $term . "%' or "
            . " lower(diagnosa_namalainnya) ilike '%" . $term . "%'"
            . ")"
        );
      }

      $criteria->order = 'diagnosa_kode, diagnosa_nama';
      $criteria->addCondition("diagnosa_aktif = true");
      $models = DiagnosaM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = ($param == "lainnya" ? $model->diagnosa_kode . ' - ' . $model->diagnosa_namalainnya : $model->diagnosa_kode . ' - ' . $model->diagnosa_nama);
        $returnVal[$i]['value'] = $model->diagnosa_id;
      }
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * Fungsi untuk memvalidasi data diagnosa pasien
   * @param type $params
   * @param type $pendaftaran_id
   * @param type $is_diagnosa
   */
  protected function validasiTabular($params, $pendaftaran_id, $is_diagnosa = true)
  {
    $result = array();
    foreach ($params as $i => $val) {
      if (empty($val['pasienmorbiditas_id'])) {
        if ($is_diagnosa) {
          $attributes = array(
            'pasienmorbiditas_id'=> empty($val['pasienmorbiditas_id'])? NULL: $val['pasienmorbiditas_id'],
            'pendaftaran_id' => $pendaftaran_id,
            'diagnosa_id' => empty($val['diagnosa_id'])? NULL: $val['diagnosa_id'] ,
            'diagnosaicdix_id' => null,
            'ruangan_id' => Yii::app()->user->getState('ruangan_id'),
            'statusdiagnosapasien' => (!empty($val['statusdiagnosapasien']) ? $val['statusdiagnosapasien'] : ""),
            'ket_diagnosa' => (!empty($val['ket_diagnosa'])? $val['ket_diagnosa'] : ""),
          );
        } else {
          $attributes = array(
            'pasienmorbiditas_id'=> empty($val['pasienmorbiditas_id'])? NULL: $val['pasienmorbiditas_id'],
            'pendaftaran_id' => $pendaftaran_id,
            'diagnosaicdix_id' => $val['diagnosaicdix_id'],
            'ruangan_id' => $ruangan_id,
            'statusdiagnosapasien' => (!empty($val['statusdiagnosapasien']) ? $val['statusdiagnosapasien'] : ""),
            'ket_diagnosa' => $val['ket_diagnosa']
          );
        }
        //                if($i == 0){
        //                    echo "<pre>";
        //                    print_r($_POST);
        //
        //                    echo "<pre>";
        //                    print_r($val);
        //                    exit;
        //                }
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

  /**
   * Fungsi untuk menghapus diagnosa x
   */
  public function actionHapusDiagnosax()
  {
    $delete = 'false';
    $id = (isset($_POST['pasienmorbiditas_id']) ? $_POST['pasienmorbiditas_id'] : null);
    $remove = PPPasienMorbiditasT::model()->findByPk($id);
    $pendaftaran_id = $remove->pendaftaran_id;
    $remove->delete();

    $transaction = Yii::app()->db->beginTransaction();
    $hapusix = Pasienicd9cmT::model()->deleteAllByAttributes(array('pasienmorbiditas_id' => $id));
    if ($remove) {

      $cekMorbidi = PPPasienMorbiditasT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')));

      if (empty($cekMorbidi)) {
        $up = RJPendaftaranT::model()->findByPk($pendaftaran_id);
        $up->statusperiksa = Params::STATUSPERIKSA_SEDANG_PERIKSA;
        $up->save();
      }

      $transaction->commit();
      $delete = 'ok';
    } else {
      $transaction->rollback();
    }
    echo CJSON::encode(array('status' => $delete));
  }

  /**
   * Fungsi untuk menghapus diagnosa ix
   */
  public function actionHapusDiagnosaix()
  {
    $delete = 'false';
    $id = (isset($_POST['pasienicd9cm_id']) ? $_POST['pasienicd9cm_id'] : null);


    $transaction = Yii::app()->db->beginTransaction();
    $remove = Pasienicd9cmT::model()->findByPk($id);
    $pendaftaran_id = $remove->pendaftaran_id;
    $remove->delete();
    if ($remove) {

      $cekMorbidi = PPPasienMorbiditasT::model()->findByAttributes(array('pendaftaran_id' => $pendaftaran_id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')));

      if (empty($cekMorbidi)) {
        $up = RJPendaftaranT::model()->findByPk($pendaftaran_id);
        $up->statusperiksa = Params::STATUSPERIKSA_SEDANG_PERIKSA;
        $up->save();
      }

      $transaction->commit();
      $delete = 'ok';
    } else {
      $transaction->rollback();
    }
    echo CJSON::encode(array('status' => $delete));
  }

  /**
   * Load model Pasien Morbiditas
   * @param type $pendaftaran_id
   */
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
    if ($model === null) {
      throw new CHttpException(404, 'The requested page does not exist.');
    }
    return $model;
  }

  /**
   * Untuk mendapatkan kasus diagnosa pasien
   * @param type $pasien_id
   * @param type $idDiagnosa
   */
  protected function getKasusDiagnosa($pasien_id, $idDiagnosa)
  {
    $modMorbiditas = PasienmorbiditasT::model()->findByAttributes(array('pasien_id' => $pasien_id, 'diagnosa_id' => $idDiagnosa));
    if (!empty($modMorbiditas)) {
      return Params::KASUSDIAGNOSA_KASUS_LAMA;
    } else {
      return Params::KASUSDIAGNOSA_KASUS_BARU;
    }
  }

  /**
   * Untuk cek golongan umur
   * @param type $idGolonganUmur
   */
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
