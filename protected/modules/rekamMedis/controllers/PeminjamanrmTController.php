<?php

class PeminjamanrmTController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'rekamMedis.views.peminjamanrmT.';

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
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = new RKPeminjamanrmT;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['RKPeminjamanrmT'])) {
      $model->attributes = $_POST['RKPeminjamanrmT'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->peminjamanrm_id));
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
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['RKPeminjamanrmT'])) {
      $model->attributes = $_POST['RKPeminjamanrmT'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->peminjamanrm_id));
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
    $format = new MyFormatter();
    $model = new RKPeminjamanrmT;
    $modDokumenPasienLama = new RKDokumenpasienrmlamaV('searchPeminjaman');
    // Uncomment the following line if AJAX validation is needed


    $model->tglpeminjamanrm = date('Y-m-d H:i:s');
    $modDokumenPasienLama->tgl_awal = date('Y-m-d');
    $modDokumenPasienLama->tgl_akhir = date('Y-m-d');
    $model->namapeminjam = Yii::app()->user->name;
    if (isset($_GET['RKDokumenpasienrmlamaV'])) {
      $modDokumenPasienLama->attributes = $_GET['RKDokumenpasienrmlamaV'];
      $modDokumenPasienLama->tgl_awal = $format->formatDateTimeForDb($_GET['RKDokumenpasienrmlamaV']['tgl_awal']);
      $modDokumenPasienLama->tgl_akhir = $format->formatDateTimeForDb($_GET['RKDokumenpasienrmlamaV']['tgl_akhir']);
      //					echo "<pre>";
      //					print_r($modDokumenPasienLama->tgl_awal);
      //					print_r($modDokumenPasienLama->tgl_akhir);
      //					exit;
    }

    if (isset($_POST['RKPeminjamanrmT'])) {

      $model->attributes = $_POST['RKPeminjamanrmT'];
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $success = true;
        $jumlah = count((array)$_POST['cekList']);
        for ($i = 0; $i < $jumlah; $i++) {
          if (isset($_POST['cekList'][$i]) == 1) {
            $models = new RKPeminjamanrmT();

            $models->attributes = $model->attributes;
            //$models->warnadokrm_id = WarnadokrmM::model()->findByAttributes(array('warnadokrm_kodewarna'=> str_replace('#','',strtolower($_POST['Dokumen']['warnadokrm_id'][$i]))))->warnadokrm_id;
            $models->pasien_id = $_POST['Dokumen']['pasien_id'][$i];
            $models->pendaftaran_id = $_POST['Dokumen']['pendaftaran_id'][$i];
            $models->dokrekammedis_id = $_POST['Dokumen']['dokrekammedis_id'][$i];
            $models->ruangan_id = $_POST['Dokumen']['ruangan_id'][$i];
            $models->nourut_pinjam = MyGenerator::noUrutPinjamRM();

            if (!$models->save()) {
              $success &= false;
            } else {
              PendaftaranT::model()->updateByPK($models->pendaftaran_id, array('peminjamanrm_id' => $models->peminjamanrm_id, 'pengiriman_id' => null));
              if (isset($model->printArray)) {
                $model->printArray = explode(',', $model->printArray);
                $this->updatePrint($model->printArray);
              }

              //PendaftaranT::model()->updateByPK($models->pasien_id, array('peminjamanrm_id'=>$models->peminjamanrm_id, 'pengiriman_id'=>null));
            }
          }
        }
        if ($success == true) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Peminjaman Dokumen Rekam Medis berhasil disimpan");
          // $this->refresh();
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
      'format' => $format,
      'model' => $model,
      'modDokumenPasienLama' => $modDokumenPasienLama,
    ));
  }

  public function actionPeminjaman($id = null)
  {
    if (isset($id)) {
      $model = RKPeminjamanrmT::model()->findByPk($id);
      $modRekamMedis = RKDokrekammedisM::model()->with('pasien')->findByPk($model->dokrekammedis_id);
      $model->no_rekam_medik = $modRekamMedis->pasien->no_rekam_medik;
      $model->nama_pasien = $modRekamMedis->pasien->nama_pasien;
      $model->jenis_kelamin = $modRekamMedis->pasien->jeniskelamin;
      $model->tanggal_lahir = $modRekamMedis->pasien->tanggal_lahir;
    } else {
      $model = new RKPeminjamanrmT;
      $model->namapeminjam = Yii::app()->user->name;
      $model->nourut_pinjam = MyGenerator::noUrutPinjamRM();
      $model->tglpeminjamanrm = date('Y-m-d H:i:s');
    }


    if (isset($_POST['RKPeminjamanrmT'])) {
      $model->attributes = $_POST['RKPeminjamanrmT'];
      $model->tglpeminjamanrm = !empty($_POST['RKPeminjamanrmT']['tglpeminjamanrm']) ? MyFormatter::formatDateTimeForDb($_POST['RKPeminjamanrmT']['tglpeminjamanrm']) : null;
      $model->tglakandikembalikan = !empty($_POST['RKPeminjamanrmT']['tglakandikembalikan']) ? MyFormatter::formatDateTimeForDb($_POST['RKPeminjamanrmT']['tglakandikembalikan']) : null;
      $model->create_time = date("Y-m-d H:i:s");
      $model->create_loginpemakai_id = Yii::app()->user->id;
      $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        PendaftaranT::model()->updateByPk($model->pendaftaran_id, array('pengirimanrm_id' => null, 'peminjamanrm_id' => $model->peminjamanrm_id));
        $this->redirect(array('peminjaman', 'id' => $model->peminjamanrm_id));
        //$this->refresh();
      }
    }

    $this->render('peminjaman', array(
      'model' => $model
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new RKPeminjamanrmT('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['RKPeminjamanrmT']))
      $model->attributes = $_GET['RKPeminjamanrmT'];

    $this->render('admin', array(
      'model' => $model,
    ));
  }

  public function actionInformasi()
  {
    $this->pageTitle = Yii::app()->name . " - Peminjaman Dokumen";
    $model = new RKInformasipeminjamanrmV('searchInformasi');
    $model->unsetAttributes();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['RKInformasipeminjamanrmV'])) {
      $format = new MyFormatter();
      $model->attributes = $_GET['RKInformasipeminjamanrmV'];
      $model->tgl_awal  = $format->formatDateTimeForDb($_GET['RKInformasipeminjamanrmV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RKInformasipeminjamanrmV']['tgl_akhir']);
    }
    $this->render($this->path_view . 'informasi', array(
      'model' => $model,
    ));
  }

  public function actionGetNamaPeminjam()
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
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = RKPeminjamanrmT::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  public function actionGetRuanganForCheckBox($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = $_POST["$namaModel"]['instalasi_id'];
      if ($encode) {
        echo CJSON::encode($ruangan);
      } else {
        if (empty($instalasi_id)) {
          $ruangan = RuanganM::model()->findAll('instalasi_id=9999');
        } else {
          $ruangan = RuanganM::model()->findAll('instalasi_id=' . $instalasi_id . '');
        }
        $ruangan = CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama');
        echo CHtml::hiddenField('' . $namaModel . '[ruangan_id]');
        $i = 0;
        if (count((array)$ruangan) > 0) {
          echo "<div style='margin-left:0px;'>" . CHtml::checkBox('checkAllRuangan', true, array(
            'onkeypress' => "return $(this).focusNextInputField(event)",
            'class' => 'checkbox-column', 'onclick' => 'checkAll()', 'checked' => 'checked'
          )) . "Pilih Semua";
          echo "</div><br>";
          foreach ($ruangan as $value => $name) {

            //                        echo '<label class="checkbox">';
            //                        echo CHtml::checkBox(''.$namaModel."[ruangan_id][]", true, array('value'=>$value));
            //                        echo '<label for="'.$namaModel.'_ruangan_id_'.$i.'">'.$name.'</label>';
            //                        echo '</label>';
            $selects[] = $value;
            $i++;
          }
          echo CHtml::checkBoxList('' . $namaModel . "[ruangan_id]", $selects, $ruangan);
        } else {
          echo '<label>Data Tidak Ditemukan</label>';
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'rkpeminjamanrm-t-form') {
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
    $model = new RKDokumenpasienrmlamaV();
    $model->attributes = $_REQUEST['RKDokumenpasienrmlamaV'];
    $model->pendaftaran_id = explode(',', $_REQUEST['RKDokumenpasienrmlamaV']['printArray']);

    $judulLaporan = 'Data Dokumen Rekam Medis';
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

    $this->updatePrint($model->pendaftaran_id);
  }

  public function actionPrintPeminjaman($id)
  {
    $this->layout = '//layouts/printWindows';
    $modPeminjaman = RKPeminjamanrmT::model()->with('dokrekammedis')->findByPk($id);
    RKPeminjamanrmT::model()->updateByPk($id, array('printpeminjaman' => true));
    $model = PasienM::model()->findByPk($modPeminjaman->dokrekammedis->pasien_id);
    $judulLaporan = "Peminjaman Dokumen Rekam Medis";
    $this->render('printKartu', array('modPasien' => $model, 'modPinjam' => $modPeminjaman, 'judulLaporan' => $judulLaporan));
  }

  protected function updatePrint($data = null)
  {
    if (isset($data)) {
      $jumlah = count((array)$data);
      for ($i = 0; $i < $jumlah; $i++) {
        RKPeminjamanrmT::model()->updateAll(array('printpeminjaman' => TRUE), 'pendaftaran_id = ' . $data[$i]);
      }
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
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  //-- RekamMedis -- 
  //Get Daftar Pasien Lama untuk Peminjaman
  public function actionPasienLamauntukPeminjaman()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['term']), true);
      $criteria->addCondition('peminjamanrm_id is null or (peminjamanrm_id is not null and kembalirm_id is not null)');
      $criteria->order = 'no_rekam_medik';
      $models = DokumenpasienrmlamaV::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->no_rekam_medik . ' - ' . $model->nama_pasien;
        $returnVal[$i]['value'] = $model->no_rekam_medik;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionLoginPemakai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pemakai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pemakai';
      $models = LoginpemakaiK::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nama_pemakai;
        $returnVal[$i]['value'] = $model->loginpemakai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actiongetRuanganByInstalasi()
  {
  }
}
