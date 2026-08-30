<?php

class DokrekammedisController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'informasi';

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
    $model = new DokrekammedisM;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['DokrekammedisM'])) {
      $model->attributes = $_POST['DokrekammedisM'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->dokrekammedis_id));
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


    if (isset($_POST['DokrekammedisM'])) {
      $model->attributes = $_POST['DokrekammedisM'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->dokrekammedis_id));
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
    $modDokRekamMedis = new DokrekammedisM;
    $modPengiriman = new RKPengirimanrmT;
    $modPengiriman->tglpengirimanrm = date('Y-m-d H:i:s');
    $modPengiriman->petugaspengirim = Yii::app()->user->name;


    if (isset($_POST['RKPengirimanrmT'])) {
      if (isset($_POST['Dokumen'])) {
        $transaction = Yii::app()->db->beginTransaction();
        $jumlah = count((array)$_POST['Dokumen']['pasien_id']);

        try {
          $success = true;
          for ($i = 0; $i < $jumlah; $i++) {
            if ($_POST['cekList'][$i] == 1) {
              $models = new DokrekammedisM;
              $models->nodokumenrm = MyGenerator::noDokumenRM();
              $models->pasien_id = $_POST['Dokumen']['pasien_id'][$i];
              $models->warnadokrm_id = WarnadokrmM::model()->findByAttributes(array('warnadokrm_kodewarna' => str_replace('#', '', strtolower($_POST['Dokumen']['warnadokrm_id'][$i]))))->warnadokrm_id;
              //$models->subrak_id = $_POST['Dokumen']['subrak_id'][$i];
              //$models->lokasirak_id = $_POST['Dokumen']['lokasirak_id'][$i];
              $models->tglrekammedis = $_POST['Dokumen']['tgl_rekam_medik'][$i];
              $models->tglmasukrak = date('Y-m-d H:i:s');
              $models->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;
              
           
              $models->nomorprimer = substr($_POST['Dokumen']['no_rekam_medik'][$i], 4, 2);
              $models->nomorsekunder = substr($_POST['Dokumen']['no_rekam_medik'][$i], 2, 2);
              $models->nomortertier = substr($_POST['Dokumen']['no_rekam_medik'][$i], 0, 2);
              $models->warnanorm_i = WarnanomorrmM::model()->findByAttributes(array('warnanomorrm_angka' => substr($models->nomorprimer, 0, 1)))->warnanomorrm_id;
              $models->warnanorm_ii = WarnanomorrmM::model()->findByAttributes(array('warnanomorrm_angka' =>  substr($models->nomorprimer, 1, 1)))->warnanomorrm_id;
              if ($models->save()) {
                $modelPengiriman = new RKPengirimanrmT();
                $modelPengiriman->attributes = $_POST['RKPengirimanrmT'];
                $modelPengiriman->dokrekammedis_id = $models->dokrekammedis_id;
                $modelPengiriman->nourut_keluar = MyGenerator::noUrutKeluarRM();
                $modelPengiriman->pasien_id = $models->pasien_id;
                $modelPengiriman->pendaftaran_id = $_POST['Dokumen']['pendaftaran_id'][$i];
                $modelPengiriman->ruangan_id = $_POST['Dokumen']['ruangan_id'][$i];
                $modelPengiriman->ruanganpengirim_id = Yii::app()->user->getState('ruangan_id');
                if ($modelPengiriman->save()) {
                  PasienM::model()->updateByPk($models->pasien_id, array('dokrekammedis_id' => $models->dokrekammedis_id));
                }
              } else {
                $success = false;
              }
            }
          }
          if ($success == true) {
            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data Pengiriman Dokumen Rekam Medis berhasil disimpan");
            $this->refresh();
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
      //                    exit();
      //			$model->attributes=$_POST['DokrekammedisM'];
      //			if($model->save()){
      //                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
      //				$this->redirect(array('view','id'=>$model->dokrekammedis_id));
      //                        }
    }

    $model = new RKDokumenpasienrmbaruV('search');
    $model->unsetAttributes();  // clear any default values
    //$modDokRekamMedis->nodokumenrm = MyGenerator::noDokumenRM();
    if (isset($_GET['RKDokumenpasienrmbaruV']))
      $model->attributes = $_GET['RKDokumenpasienrmbaruV'];

    $model->tgl_rekam_medik = date('Y-m-d H:i:s');
    $model->tgl_rekam_medik_akhir = date('Y-m-d H:i:s');

    $this->render('index', array(
      'model' => $model,
      'modDokRekamMedis' => $modDokRekamMedis,
      'modPengiriman' => $modPengiriman,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new DokrekammedisM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['DokrekammedisM']))
      $model->attributes = $_GET['DokrekammedisM'];

    $this->render('admin', array(
      'model' => $model,
    ));
  }

  public function actionUbahLokasirak()
  {
    $model = new DokrekammedisM;
    if (isset($_POST['DokrekammedisM'])) {
      $model->attributes = $_POST['DokrekammedisM'];
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $attributes = array('lokasirak_id' => $_POST['DokrekammedisM']['lokasirak_id']);
        $save = DokrekammedisM::model()->updateByPk($_POST['DokrekammedisM']['dokrekammedis_id'], $attributes);
        if ($save) {
          $transaction->commit();
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Berhasil merubah data Lokasi Rak.</div>",
          ));
        } else {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
          ));
        }
        exit;
      } catch (Exception $exc) {
        $transaction->rollback();
      }
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo CJSON::encode(array(
        'status' => 'create_form',
        'div' => $this->renderPartial('_ubahLokasiRak', array('model' => $model), true)
      ));
      exit;
    }
  }

  public function actionPasienDokumen()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $idDokRK = $_POST['idpasien'];
      $model = DokrekammedisM::model()->findByPk($idDokRK);

      $modPasien = PasienM::model()->findByPk($model->pasien_id);
      $modLokasirak = LokasirakM::model()->findByPk($model->lokasirak_id);
      $modSubrak = SubrakM::model()->findByPk($model->subrak_id);
      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }

      $returnVal["nama_pasien"] = $modPasien->nama_pasien;
      if (isset($modLokasirak->lokasirak_nama)) {
        $returnVal["lokasirak_nama"] = $modLokasirak->lokasirak_nama;
      }
      if (isset($modSubrak->subrak_nama)) {
        $returnVal["subrak_nama"] = $modSubrak->subrak_nama;
      }
      echo json_encode($returnVal);
      Yii::app()->end();
    }
  }

  public function actionUbahSubrak()
  {
    $model = new DokrekammedisM;
    if (isset($_POST['DokrekammedisM'])) {
      $model->attributes = $_POST['DokrekammedisM'];
      //var_dump($_POST);
      //var_dump($model->attributes); die;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $attributes = array('subrak_id' => $_POST['DokrekammedisM']['subrak_id']);
        $save = DokrekammedisM::model()->updateByPk($_POST['DokrekammedisM']['dokrekammedis_id'], array(
          'subrak_id' => $model->subrak_id,
        ));
        if ($save) {
          $transaction->commit();
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Berhasil merubah data Sub Rak.</div>",
          ));
        } else {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-error'>Data gagal disimpan.</div>",
          ));
        }
        exit;
      } catch (Exception $exc) {
        $transaction->rollback();
      }
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo CJSON::encode(array(
        'status' => 'create_form',
        'div' => $this->renderPartial('_ubahSubRak', array('model' => $model), true)
      ));
      exit;
    }
  }
  public function actionInformasi()
  {
    $this->pageTitle = Yii::app()->name . " - Dokumen Rekam Medis";
    if (isset($_POST['json'])) {
      if (isset($_POST['param'])) {
        call_user_func(array($this, $_POST['f']), $_POST['param']);
      } else {
        call_user_func(array($this, $_POST['f']));
      }
    }

    $model = new RKDokrekammedisM('searchInformasi');
    $model->unsetAttributes();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->ceklis = true;

    if (isset($_GET['RKDokrekammedisM'])) {
      $model->attributes = $_GET['RKDokrekammedisM'];
      $format = new MyFormatter();
      $model->tgl_awal  = $format->formatDateTimeForDb($_GET['RKDokrekammedisM']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RKDokrekammedisM']['tgl_akhir']);
      
     if($_GET['RKDokrekammedisM']['ceklis'] == 0) {
      $model->ceklis = false;
     }
    $model->nama_pasien = $_GET['RKDokrekammedisM']['nama_pasien'];
      
     }
    

    $this->render('informasi', array('model' => $model));
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

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = DokrekammedisM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'ppdokrekammedis-m-form') {
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
    $model = new DokrekammedisM;
    $model->attributes = $_REQUEST['DokrekammedisM'];
    $judulLaporan = 'Data DokrekammedisM';
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

  public function terimaRM($param)
  {
    $modPenerimaanRm = PengirimanrmT::model()->findByPk($param['id']);
    $model = PendaftaranT::model()->findByPk($modPenerimaanRm->pendaftaran_id);
    $modPenerimaanRm->tglterimadokrm = date('Y-m-d H:i:s');
    $modPenerimaanRm->petugaspenerima_id = Yii::app()->user->id;
    $modPenerimaanRm->ruanganpenerima_id = Yii::app()->user->getState('ruangan_id');
    if ($modPenerimaanRm->save()) {
      $model->statusdokrm = 'SUDAH DITERIMA DI ' . strtoupper(Yii::app()->user->getState("ruangan_nama"));
      $model->pengirimanrm_id = $modPenerimaanRm->pengirimanrm_id;
      $model->save();
      $update = true;
      $msg = "Data Dokumen Pasien berhasi diterima.";
    } else {
      $update = false;
      $msg = "Data Dokumen Pasien gagal diterima.";
    }

    echo CJSON::encode(array(
      'update' => $update,
      'msg' => $msg,
    ));

    Yii::app()->end();
  }

  public function ubahWarnaRM($param)
  {
    $dokumen = DokrekammedisM::model()->findByPk($param['id']);
    $warna = WarnadokrmM::model()->findByAttributes(array(
      'warnadokrm_kodewarna' =>  substr($param['val'], 1),
    ));
    DokrekammedisM::model()->updateByPk($dokumen->dokrekammedis_id, array(
      'warnadokrm_id' => $warna->warnadokrm_id,
    ));

    echo CJSON::encode(array(
      'update' => true,
      'msg' => "Warna Dokumen Pasien berhasil Diubah.",
    ));

    Yii::app()->end();
  }
}
