<?php

class KembalirmTController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'rekamMedis.views.kembalirmT.';

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $this->render('view', array(
      'model' => $this->loadModel($id),
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate()
  {
    $model = new RKKembalirmT;
    // Uncomment the following line if AJAX validation is needed
    if (isset($_POST['RKKembalirmT'])) {
      $model->attributes = $_POST['RKKembalirmT'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->kembalirm_id));
      }
    }

    $this->render('create', array(
      'model' => $model,
    ));
  }

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['RKKembalirmT'])) {
      $model->attributes = $_POST['RKKembalirmT'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->kembalirm_id));
      }
    }

    $this->render('update', array(
      'model' => $model,
    ));
  }

  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id)
  {
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
      $this->loadModel($id)->delete();

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $modPengiriman = new RKPeminjamandokumenrmV('search');
    $modPengiriman->unsetAttributes();  // clear any default values
    $modPengiriman->tgl_rekam_medik = date('Y-m-d H:i:s');
    $modPengiriman->tgl_rekam_medik_akhir = date('Y-m-d H:i:s');
    if (isset($_GET['RKPeminjamandokumenrmV'])) {
      $modPengiriman->attributes = $_GET['RKPeminjamandokumenrmV'];
      $format = new MyFormatter();
      $modPengiriman->tgl_rekam_medik = $format->formatDateTimeForDb($modPengiriman->tgl_rekam_medik);
      $modPengiriman->tgl_rekam_medik_akhir = $format->formatDateTimeForDb($modPengiriman->tgl_rekam_medik_akhir);
    }

    $model = new RKKembalirmT;
    $model->petugaspenerima = Yii::app()->user->name;
    $model->tglkembali = date('Y-m-d H:i:s');

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

    if (isset($_POST['RKKembalirmT'])) {
      $model->attributes = $_POST['RKKembalirmT'];
      $jumlah  = count((array)$_POST['KembalirmT']);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $success = true;
        if (isset($_POST['KembalirmT'])) {
          foreach ($_POST['KembalirmT'] as $i => $dokumen) {
            if (isset($dokumen['cekList'])) {
              if ($dokumen['cekList'] == 1) {
                $models = new RKKembalirmT();
                $models->attributes = $model->attributes;
                $models->dokrekammedis_id = $dokumen['dokrekammedis_id'];
                $models->pasien_id = $dokumen['pasien_id'];
                $models->pendaftaran_id = $dokumen['pendaftaran_id'];
                $models->peminjamanrm_id = $dokumen['peminjamanrm_id'];
                $models->pengirimanrm_id = $dokumen['pengirimanrm_id'];
                if ($dokumen['kelengkapan'] == 1) {
                  $models->lengkapdokumenkembali = true;
                } else {
                  $models->lengkapdokumenkembali = false;
                }
                $models->ruanganasal_id = PengirimanrmT::model()->findByPk($models->pengirimanrm_id)->ruanganpengirim_id;
                if (!$models->save()) {
                  $success = false;
                } else {
                  DokrekammedisM::model()->updateByPk(
                    $models->dokrekammedis_id,
                    array('subrak_id' => $dokumen['subrak_id'], 'lokasirak_id' => $dokumen['lokasirak_id'])
                  );
                  //PendaftaranT::model()->updateByPk($models->pendaftaran_id, array('kembali'))
                  PengirimanrmT::model()->updateByPk($models->pengirimanrm_id, array('kembalirm_id' => $models->kembalirm_id));
                  PeminjamanrmT::model()->updateByPk($models->peminjamanrm_id, array('kembalirm_id' => $models->kembalirm_id));

                  // SMS GATEWAY
                  $loginpemakai = LoginpemakaiK::model()->findByPk($models->create_loginpemakai_id);
                  $modPegawaiPenerima = PegawaiM::model()->findByPk($loginpemakai->pegawai_id);
                  $modPeminjaman = PeminjamanrmT::model()->findByPk($models->peminjamanrm_id);
                  $loginpemakaiPeminjam = LoginpemakaiK::model()->findByPk($modPeminjaman->create_loginpemakai_id);
                  $modPegawaiPeminjam = PegawaiM::model()->findByPk($loginpemakaiPeminjam->pegawai_id);

                  $modDokRekamMedis = $models->dokrekammedis;
                  $modSubRak = $modDokRekamMedis->subrak;
                  $modLokasiRak = $modDokRekamMedis->lokasirak;

                  $sms = new Sms();
                  foreach ($modSmsgateway as $i => $smsgateway) {
                    $isiPesan = $smsgateway->templatesms;

                    $attributes = $modPegawaiPenerima->getAttributes();
                    foreach ($attributes as $attributes => $value) {
                      $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    }
                    $attributes = $modPegawaiPeminjam->getAttributes();
                    foreach ($attributes as $attributes => $value) {
                      $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    }
                    $attributes = $models->getAttributes();
                    foreach ($attributes as $attributes => $value) {
                      $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    }
                    $attributes = $modSubRak->getAttributes();
                    foreach ($attributes as $attributes => $value) {
                      $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    }
                    $attributes = $modLokasiRak->getAttributes();
                    foreach ($attributes as $attributes => $value) {
                      $isiPesan = str_replace("{{" . $attributes . "}}", $value, $isiPesan);
                    }
                    $isiPesan = str_replace("{{hari}}", MyFormatter::getDayName($models->tglkembali), $isiPesan);

                    if ($smsgateway->tujuansms == Params::TUJUANSMS_PEGAWAI_PENERIMA && $smsgateway->statussms) {
                      if (!empty($modPegawaiPenerima->nomobile_pegawai)) {
                        $sms->kirim($modPegawaiPenerima->nomobile_pegawai, $isiPesan);
                      }
                    }
                    if ($smsgateway->tujuansms == Params::TUJUANSMS_PEGAWAI_PEMINJAM && $smsgateway->statussms) {
                      if (!empty($loginpemakaiPeminjam->nomobile_pegawai)) {
                        $sms->kirim($loginpemakaiPeminjam->nomobile_pegawai, $isiPesan);
                      }
                    }
                  }
                  // END SMS GATEWAY

                }
              }
            }
          }
        }
        if ($success == true) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Pengembalian Data Dokumen Rekam Medis berhasil disimpan");
          $this->refresh();
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render('index', array(
      'model' => $model,
      'modPengiriman' => $modPengiriman,
    ));
  }

  public function actionGetPetugasPenerima()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->addCondition('pegawai_aktif is true');
      $criteria->order = 'nama_pegawai';
      $models = PegawaiV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nama_pegawai;
        $returnVal[$i]['value'] = $model->nama_pegawai;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionPenyimpanan()
  {
    $this->pageTitle = Yii::app()->name . " - Penyimpanan Berkas Rekam Medis Baru";
    $modDokRekamMedis = new RKDokrekammedisM;
    if (isset($_POST['Dokumen'])) {
      $transaction = Yii::app()->db->beginTransaction();
      $jumlah = count((array)$_POST['Dokumen']['dokrekammedis_id']);

      try {
        $success = true;
        for ($i = 0; $i < $jumlah; $i++) {
          if (isset($_POST['cekList'][$i])) {
            if ($_POST['cekList'][$i] == 1) {
              RKDokrekammedisM::model()->updateByPk(
                $_POST['Dokumen']['dokrekammedis_id'][$i],
                array('subrak_id' => $_POST['Dokumen']['subrak_id'][$i], 'lokasirak_id' => $_POST['Dokumen']['lokasirak_id'][$i])
              );
            }
          }
        }
        if ($success == true) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Pengiriman Dokumen Rekam Medis berhasil disimpan");
          //						RND-7490
          //						$this->refresh();
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
          $this->refresh();
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        $this->refresh();
      }
    }

    $model = new RKPengirimanrmT('search');
    $model->tgl_rekam_medik = date('Y-m-d');
    $model->tgl_rekam_medik_akhir = date('Y-m-d');
    $model->unsetAttributes();  // clear any default values
    //$modDokRekamMedis->nodokumenrm = MyGenerator::noDokumenRM();
    if (isset($_GET['RKPengirimanrmT'])) {
      $model->attributes = $_GET['RKPengirimanrmT'];
      $format = new MyFormatter();
      $model->tgl_rekam_medik = $format->formatDateTimeForDb($model->tgl_rekam_medik);
      $model->tgl_rekam_medik_akhir = $format->formatDateTimeForDb($model->tgl_rekam_medik_akhir);
    }

    $this->render('penyimpanan', array(
      'model' => $model,
      'modDokRekamMedis' => $modDokRekamMedis,
      //'modPengiriman'=>$modPengiriman,
    ));
  }

  public function actionInformasi()
  {
    $model = new KembalirmT('search');
    $model->unsetAttributes();
    $model->tgl_awal = date('Y-m-d 00:00:00');
    $model->tgl_akhir = date('Y-m-d H:i:s');
    if (isset($_GET['KembalirmT'])) {
      $model->attributes = $_GET['KembalirmT'];
      $format = new MyFormatter();
      $model->tgl_awal  = $format->formatDateTimeForDb($_REQUEST['KembalirmT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['KembalirmT']['tgl_akhir']);
    }
    $this->render($this->path_view . 'informasi', array(
      'model' => $model,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $model = new RKKembalirmT('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['RKKembalirmT']))
      $model->attributes = $_GET['RKKembalirmT'];

    $this->render('admin', array(
      'model' => $model,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = RKKembalirmT::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'rkkembalirm-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   *Mengubah status aktif
   * @param type $id 
   */
  public function actionRemoveTemporary($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
    //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function actionPrint()
  {
    $model = new RKKembalirmT;
    $model->attributes = $_REQUEST['RKKembalirmT'];
    $judulLaporan = 'Data RKKembalirmT';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
  public function actionGetRuanganPasien()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $pendaftaran_id = (isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null);
      $ruangan_id = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
      $instalasi_id = (isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null);
      $pegawai_id = (isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null);

      if (isset($_POST['jeniskasuspenyakit_id'])) {
        $jeniskasuspenyakit_id = (isset($_POST['jeniskasuspenyakit_id']) ? $_POST['jeniskasuspenyakit_id'] : null);
        $jenisKasusPenyakit = '';
        $criteria = new CDbCriteria;
        $criteria->select = 't.ruangan_id, t.jeniskasuspenyakit_id, ruangan_m.ruangan_nama, jeniskasuspenyakit_m.jeniskasuspenyakit_nama,
                                                                        jeniskasuspenyakit_aktif';
        if (!empty($ruangan_id)) {
          $criteria->addCondition("t.ruangan_id = " . $ruangan_id);
        }
        if (!empty($jeniskasuspenyakit_id)) {
          $criteria->addCondition('t.jeniskasuspenyakit_id = ' . $jeniskasuspenyakit_id);
        }
        $criteria->addCondition('jeniskasuspenyakit_m.jeniskasuspenyakit_aktif is true');
        $criteria->join = 'LEFT JOIN ruangan_m on t.ruangan_id = ruangan_m.ruangan_id
                                                                   LEFT JOIN jeniskasuspenyakit_m on t.jeniskasuspenyakit_id = jeniskasuspenyakit_m.jeniskasuspenyakit_id
                                                                        ';
        $dataJenisPenyakit = KasuspenyakitruanganM::model()->findAll($criteria);
        //                $dataJenisPenyakit =KasuspenyakitruanganM::model()->findAll('jeniskasuspenyakit_id='.$jeniskasuspenyakit_id.' AND jeniskasuspenyakit_aktif=TRUE ORDER BY jeniskasuspenyakit_nama');

        foreach ($dataJenisPenyakit as $jenisPenyakit) {
          if ($jenisPenyakit['jeniskasuspenyakit_id'] == $jeniskasuspenyakit_id) {
            $jenisKasusPenyakit .= '<option value="' . $jenisPenyakit['jeniskasuspenyakit_id'] . '" selected="selected">' . $jenisPenyakit['jeniskasuspenyakit_nama'] . '</option>';
          } else {
            $jenisKasusPenyakit .= '<option value="' . $jenisPenyakit['jeniskasuspenyakit_id'] . '">' . $jenisPenyakit['jeniskasuspenyakit_nama'] . '</option>';
          }
        }
        $data['jenisKasusPenyakit'] = $jenisKasusPenyakit;
      }


      if (isset($_POST['pegawai_id'])) {
        $pegawai_id = $_POST['pegawai_id'];
        $ruangan_id = $_POST['ruangan_id'];
        $criteria = new CDbCriteria;
        $criteria->select = 't.ruangan_id, t.pegawai_id, t.nama_pegawai';
        if (!empty($ruangan_id)) {
          $criteria->addCondition("t.ruangan_id = " . $ruangan_id);
        }
        if (!empty($pegawai_id)) {
          $criteria->addCondition('t.pegawai_id = ' . $pegawai_id);
        }
        $dataDokter = DokterV::model()->findAll($criteria);
        //                $dataJenisPenyakit =KasuspenyakitruanganM::model()->findAll('jeniskasuspenyakit_id='.$jeniskasuspenyakit_id.' AND jeniskasuspenyakit_aktif=TRUE ORDER BY jeniskasuspenyakit_nama');
        $dokter = '';
        foreach ($dataDokter as $dokters) {
          if ($dokters['pegawai_id'] == $pegawai_id) {
            $dokter .= '<option value="' . $dokters['pegawai_id'] . '" selected="selected">' . $dokters['nama_pegawai'] . '</option>';
          } else {
            $dokter .= '<option value="' . $dokters['pegawai_id'] . '">' . $dokters['nama_pegawai'] . '</option>';
          }
        }
        $data['dokter'] = $dokter;
      }

      $dropDown = '';
      $dataRuangan = RuanganM::model()->findAll('instalasi_id=' . $instalasi_id . ' AND ruangan_aktif=TRUE ORDER BY ruangan_nama');
      foreach ($dataRuangan as $tampilRuangan) {
        if ($tampilRuangan['ruangan_id'] == $ruangan_id) {
          $dropDown .= '<option value="' . $tampilRuangan['ruangan_id'] . '" selected="selected" onchange="getKasusPenyakit(' . $ruangan_id . ')">' . $tampilRuangan['ruangan_nama'] . '</option>';
        } else {
          $dropDown .= '<option value="' . $tampilRuangan['ruangan_id'] . '" onchange="return getKasusPenyakit(' . $ruangan_id . ')">' . $tampilRuangan['ruangan_nama'] . '</option>';
        }
      }
      $data['dropDown'] = $dropDown;
      $data['totalR'] = count((array)$dataRuangan);
      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
