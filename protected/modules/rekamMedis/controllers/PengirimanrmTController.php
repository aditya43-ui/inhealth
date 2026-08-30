<?php

class PengirimanrmTController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'rekamMedis.views.pengirimanrmT.';

  /**
   * @return array action filters
   */


  /**
   * Specifies the access control rules.
   * This method is used by the 'accessControl' filter.
   * @return array access control rules
   */


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
    $model = new RKPengirimanrmT;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['RKPengirimanrmT'])) {
      $model->attributes = $_POST['RKPengirimanrmT'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->pengirimanrm_id));
      }
    }

    $this->render($this->path_view . 'create', array(
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


    if (isset($_POST['RKPengirimanrmT'])) {
      $model->attributes = $_POST['RKPengirimanrmT'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->pengirimanrm_id));
      }
    }

    $this->render($this->path_view . 'update', array(
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
    $modPengiriman = new RKDokumenpasienrmlamaV('search');
    $modPengiriman->tgl_rekam_medik = date('Y-m-d H:i:s');
    $modPengiriman->tgl_rekam_medik_akhir = date('Y-m-d H:i:s');
    //		$modPengiriman->unsetAttributes();  // clear any default values
    if (isset($_GET['RKDokumenpasienrmlamaV'])) {
      $modPengiriman->attributes = $_GET['RKDokumenpasienrmlamaV'];
      $format = new MyFormatter();
      $modPengiriman->tgl_rekam_medik = $format->formatDateTimeForDb($modPengiriman->tgl_rekam_medik);
      $modPengiriman->tgl_rekam_medik_akhir = $format->formatDateTimeForDb($modPengiriman->tgl_rekam_medik_akhir);
    }
    $model = new RKPengirimanrmT;
    $model->tglpengirimanrm = date('Y-m-d H:i:s');
    $model->petugaspengirim = Yii::app()->user->name;

    if (isset($_POST['RKPengirimanrmT'])) {
      $model->attributes = $_POST['RKPengirimanrmT'];
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $success = true;
        $jumlah = count((array)$_POST['Dokumen']['pasien_id']);
        for ($i = 0; $i < $jumlah; $i++) {
          if (isset($_POST['cekList'][$i])) {
            if ($_POST['cekList'][$i] == 1) {
              $models = new RKPengirimanrmT();
              $models->attributes = $model->attributes;
              if ($_POST['Dokumen']['kelengkapan'][$i] == 1) {
                $models->kelengkapandokumen = true;
              } else {
                $models->kelengkapandokumen = false;
              }
              $models->pasien_id = $_POST['Dokumen']['pasien_id'][$i];
              $models->pendaftaran_id = $_POST['Dokumen']['pendaftaran_id'][$i];
              $models->dokrekammedis_id = $_POST['Dokumen']['dokrekammedis_id'][$i];
              $models->ruangan_id = $_POST['Dokumen']['ruangan_id'][$i];
              $models->nourut_keluar = MyGenerator::noUrutKeluarRM();
              $models->ruanganpengirim_id = Yii::app()->user->getState('ruangan_id');
              $models->peminjamanrm_id = $_POST['Dokumen']['peminjamanrm_id'][$i];
              $models->create_ruangan = Yii::app()->user->getState('ruangan_id');
              $models->tglpengirimanrm = MyFormatter::formatDateTimeForDb($models->tglpengirimanrm);
              $models->create_time = date('Y-m-d H:i:s');
              $models->update_time = date('Y-m-d H:i:s');
              $models->create_loginpemakai_id = Yii::app()->user->id;
              $models->update_loginpemakai_id = Yii::app()->user->id;
              if (!$models->save()) {
                $success = false;
              } else {
                PendaftaranT::model()->updateByPK($models->pendaftaran_id, array('pengirimanrm_id' => $models->pengirimanrm_id));
                PeminjamanrmT::model()->updateByPk($models->peminjamanrm_id, array('pengirimanrm_id' => $models->pengirimanrm_id));
                //PendaftaranT::model()->updateByPK($models->pasien_id, array('pengirimanrm_id'=>$models->pengirimanrm_id));
              }
            }
          }
        }

        if ($success == true) {
          $transaction->commit();
          $this->redirect(array('Index', 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }
    if (empty($models)) {
      $models = null;
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model,
      'models' => $models,
      'modPengiriman' => $modPengiriman,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new RKPengirimanrmT('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['RKPengirimanrmT']))
      $model->attributes = $_GET['RKPengirimanrmT'];

    $this->render($this->path_view . 'admin', array(
      'model' => $model,
    ));
  }

  public function actionInformasi()
  {
    $this->pageTitle = Yii::app()->name . " - Pengiriman Dokumen";
    $format = new MyFormatter();
    $model = new RKInformasipengirimanrmV('search');
    $model->unsetAttributes();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    //$model->instalasipengirim_id = Yii::app()->user->getState('instalasi_id');
    //$model->ruanganpengirim_id = Yii::app()->user->getState('ruangan_id');
    //$model->instalasitujuan_id = null;
    //$model->ruangantujuan_id = null;
    if (isset($_GET['RKInformasipengirimanrmV'])) {
      $model->attributes = $_GET['RKInformasipengirimanrmV'];
      $model->tgl_awal  = $format->formatDateTimeForDb($_GET['RKInformasipengirimanrmV']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['RKInformasipengirimanrmV']['tgl_akhir']);
    }
    $this->render($this->path_view . 'informasi', array(
      'model' => $model,
    ));
  }

  public function actionGetPetugasPengirim()
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
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = RKPengirimanrmT::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'rkpengirimanrm-t-form') {
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
    $model = new RKDokumenpasienrmlamaV;

    $model->attributes = $_REQUEST['RKDokumenpasienrmlamaV'];
    $format = new MyFormatter();
    $model->tgl_rekam_medik = $format->formatDateTimeForDb($model->tgl_rekam_medik);
    $model->tgl_rekam_medik_akhir = $format->formatDateTimeForDb($model->tgl_rekam_medik_akhir);

    $judulLaporan = 'Data Pengiriman Dokumen Rekam Medis';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionGetRuanganTujuanForCheckBox($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = $_POST["$namaModel"]['instalasitujuan_id'];

      if ($encode) {
        echo CJSON::encode($ruangan);
      } else {
        if (empty($instalasi_id)) {
        } else {
          $ruangan = RuanganM::model()->findAll('instalasi_id=' . $instalasi_id . '');
        }
        $ruangan = CHtml::listData($ruangan, 'ruangan_id', 'ruangan_nama');
        echo CHtml::hiddenField('' . $namaModel . '[ruangan_id]');
        $i = 0;
        if (count((array)$ruangan) > 0) {
          foreach ($ruangan as $value => $name) {
            //                        echo '<label class="checkbox">';
            //                        echo CHtml::checkBox(''.$namaModel."[ruangan_id][]", true, array('value'=>$value));
            //                        echo '<label for="'.$namaModel.'_ruangan_id_'.$i.'">'.$name.'</label>';
            //                        echo '</label>';
            $selects[] = $value;
            $i++;
          }
          echo CHtml::checkBoxList('' . $namaModel . "[ruangantujuan_id]", $selects, $ruangan);
        } else {
          echo '<label>Data Tidak Ditemukan</label>';
        }
      }
    }
    Yii::app()->end();
  }

  public function actionGetRuanganPasien()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;
      $dropDown = array();
      $dataRuangan = RuanganM::model()->findAll('instalasi_id=' . $instalasi_id . ' AND ruangan_aktif=TRUE ORDER BY ruangan_nama');

      foreach ($dataRuangan as $tampilRuangan) {
        $dropDown .= '<option value="' . $tampilRuangan['ruangan_id'] . '" selected="selected">' . $tampilRuangan['ruangan_nama'] . '</option>';
      }

      $data['dropDown'] = $dropDown;
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /**
   * Mengatur dropdown ruangan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownRuanganAsal($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = null;
      if ($model_nama !== '' && $attr == '') {
        $instalasi_id = $_POST["$model_nama"]['instalasipengirim_id'];
      } else if ($model_nama == '' && $attr !== '') {
        $instalasi_id = $_POST["$attr"];
      } else if ($model_nama !== '' && $attr !== '') {
        $instalasi_id = $_POST["$model_nama"]["$attr"];
      }
      $models = null;
      $models = CHtml::listData(RuanganM::getRuanganByInstalasi($instalasi_id), 'ruangan_id', 'ruangan_nama');

      if ($encode) {
        echo CJSON::encode($models);
      } else {
        if (count((array)$models) > 1) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } elseif (count((array)$models) == 0) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        }
        if (count((array)$models) > 0) {
          foreach ($models as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }
  public function actionSetDropdownRuanganTujuan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = null;
      if ($model_nama !== '' && $attr == '') {
        $instalasi_id = $_POST["$model_nama"]['instalasitujuan_id'];
      } else if ($model_nama == '' && $attr !== '') {
        $instalasi_id = $_POST["$attr"];
      } else if ($model_nama !== '' && $attr !== '') {
        $instalasi_id = $_POST["$model_nama"]["$attr"];
      }
      $models = null;
      $models = CHtml::listData(RuanganM::getRuanganByInstalasi($instalasi_id), 'ruangan_id', 'ruangan_nama');

      if ($encode) {
        echo CJSON::encode($models);
      } else {
        if (count((array)$models) > 1) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } elseif (count((array)$models) == 0) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        }
        if (count((array)$models) > 0) {
          foreach ($models as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }
}
