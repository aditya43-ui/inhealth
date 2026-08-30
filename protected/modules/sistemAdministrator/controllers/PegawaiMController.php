<?php

class PegawaiMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  //public $layout='//layouts/column1'; //karna biasanya di akses dari home
  public $defaultAction = 'admin';
  public $path_view = "rawatJalan.views.pegawaiM.";
  public $path_tips = "rawatJalan.views.tips.";
  public $init = 'SA';

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

  public function actionViewUser($id = '', $sukses = '', $frame = '')
  {

    if ($sukses == 1) :
      Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
    endif;

    $tugasnama = array();

    if (!empty(Yii::app()->user->getState('pegawai_id'))) {
      $model = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
      $modPemakai = LoginpemakaiK::model()->findByPk(Yii::app()->user->getState('loginpemakai_id'));
      $modRole = AksespenggunaK::model()->findByAttributes(array('loginpemakai_id' => Yii::app()->user->getState('loginpemakai_id')));
      $modRoleAll = AksespenggunaK::model()->findAllByAttributes(array('loginpemakai_id' => Yii::app()->user->getState('loginpemakai_id')));

      foreach ($modRoleAll as $all) {
        $tugas[] = $all->tugas_nama;
      }

      if (!empty($modRole)) {
        $cri =  new CDbCriteria();
        $cri->select = " m.modul_nama ";
        $cri->join = " JOIN modul_k m ON m.modul_id = t.modul_id ";
        $cri->addCondition("peranpengguna_id = '" . $modRole->peranpengguna_id . "' ");
        $cri->addInCondition("tugas_nama", $tugas);
        $cri->group = " m.modul_nama ";
        $modModule = TugaspenggunaK::model()->findAll($cri);
      } else {
          $modModule = array();
      }
    } else {
      if (Params::cekAkses(Yii::app()->user->getState('peranpengguna_id'))) {
        $model = new PegawaiM;
        $modPemakai = LoginpemakaiK::model()->findByPk(Yii::app()->user->getState('loginpemakai_id'));
        $modRole = AksespenggunaK::model()->findByAttributes(array('loginpemakai_id' => Yii::app()->user->getState('loginpemakai_id')));
        $modRoleAll = AksespenggunaK::model()->findAllByAttributes(array('loginpemakai_id' => Yii::app()->user->getState('loginpemakai_id')));

        foreach ($modRoleAll as $all) {
          $tugas[] = $all->tugas_nama;
        }

        $cri =  new CDbCriteria();
        $cri->select = " m.modul_nama ";
        $cri->join = " JOIN modul_k m ON m.modul_id = t.modul_id ";
        $cri->addCondition("peranpengguna_id = '" . $modRole->peranpengguna_id . "' ");
        $cri->addInCondition("tugas_nama", $tugas);
        $cri->group = " m.modul_nama ";
        $modModule = TugaspenggunaK::model()->findAll($cri);
      }
    }

    $this->render('sistemAdministrator.views.pegawaiM.viewUserNeon', array(
      'model' => $model,
      'modPemakai' => $modPemakai,
      'modRole' => $modRole,
      'modRoleAll' => $modRoleAll,
      'modModule' => $modModule,
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = new SAPegawaiM;
    $modRuanganPegawai = new RuanganpegawaiM;
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SAPegawaiM'])) {
      $model->attributes = $_POST['SAPegawaiM'];
      $model->profilrs_id = Params::getDefaultProfilRS();


      if ($_POST['caraAmbilPhoto'] == 'file') //Jika User Mengambil photo pegawai dengan cara upload file
      {

        $model->pegawai_aktif = true;
        //   $model->profilrs_id=Params::getDefaultProfilRS();
        $model->photopegawai = CUploadedFile::getInstance($model, 'photopegawai');
        $gambar = $model->photopegawai;
        $random = rand(000000, 999999);

        if (!empty($model->photopegawai)) //Klo User Memasukan Logo
        {

          $model->photopegawai = $random . $model->photopegawai;

          Yii::import("ext.EPhpThumb.EPhpThumb");

          $thumb = new EPhpThumb();
          $thumb->init(); //this is needed

          $fullImgName = $model->photopegawai;
          $fullImgSource = Params::pathPegawaiDirectory() . $fullImgName;
          $fullThumbSource = Params::pathPegawaiTumbsDirectory() . 'kecil_' . $fullImgName;
        }
      }
      $model->create_time = date('Y-m-d');
      $model->create_loginpemakai_id = Yii::app()->user->id;
      $model->create_ruangan = Yii::app()->user->ruangan_id;
      if ($model->validate()) {
        $format = new MyFormatter();
        if (!empty($model->tgl_lahirpegawai)) {
          $model->tgl_lahirpegawai = $format->formatDateTimeForDb($model->tgl_lahirpegawai);
        } else {
          $model->tgl_lahirpegawai = date('Y-m-d');
        }

        $model->kategoripegawai = '';

        if ($model->save()) {
          if (!empty($model->photopegawai)) {
            $gambar->saveAs($fullImgSource);

            $thumb->create($fullImgSource)
              ->resize(200, 200)
              ->save($fullThumbSource);
          }
          if ($model->validate()) {
            if ($model->save()) {
              $jumlahRuanganPegawai = isset($_POST['ruangan_id']) ? count((array)$_POST['ruangan_id']) : 0;
              $pegawai_id = $model->pegawai_id;
              //                            $hapusRuanganPegawai =  RuanganpegawaiM::model()->deleteAll('pegawai_id='.$pegawai_id.'');
              for ($i = 0; $i < $jumlahRuanganPegawai; $i++) {
                $modRuanganPegawai = new RuanganpegawaiM;
                $modRuanganPegawai->ruangan_id = $_POST['ruangan_id'][$i];
                $modRuanganPegawai->pegawai_id = $pegawai_id;
                $modRuanganPegawai->save();
              }
              Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
              $this->redirect(array('admin', 'id' => $model->pegawai_id));
              // Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
              // $this->redirect(array('admin','id'=>$model->pegawai_id));
            }
          }
        }
      }
    }
    $this->render('create', array(
      'model' => $model, 'modRuanganPegawai' => $modRuanganPegawai
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
    $modRuanganPegawai = RuanganpegawaiM::model()->findAll('pegawai_id=' . $id . '');
    $temLogo = $model->photopegawai;
    $format = new MyFormatter();
    if (isset($_POST['SAPegawaiM'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $random = rand(0000000, 9999999);
        $model->attributes = $_POST['SAPegawaiM'];
        $model->profilrs_id = Params::getDefaultProfilRS();
        $model->update_time = date('Y-m-d');
        $model->update_loginpemakai_id = Yii::app()->user->id;
        if (!empty($_POST['SAPegawaiM']['tgl_lahirpegawai'])) {
          $model->tgl_lahirpegawai = $format->formatDateTimeForDb($model->tgl_lahirpegawai);
        } else {
          $model->tgl_lahirpegawai = null;
        }

        if (!empty($_POST['SAPegawaiM']['tglditerima'])) {
          $model->tglditerima = $format->formatDateTimeForDb($model->tglditerima);
        } else {
          $model->tglditerima = null;
        }

        $model->pegawai_aktif = true;
        $model->photopegawai = CUploadedFile::getInstance($model, 'photopegawai');
        $gambar = $model->photopegawai;
        if (isset($model->photopegawai)) {
          if ($_POST['caraAmbilPhoto'] == 'file') //Jika User Mengambil photo pegawai dengan cara upload file
          {
            if (!empty($model->photopegawai)) //Klo User Memasukan Logo
            {
              $model->photopegawai = $random . $model->photopegawai;
              Yii::import("ext.EPhpThumb.EPhpThumb");
              $thumb = new EPhpThumb();
              $thumb->init(); //this is needed
              $fullImgName = $model->photopegawai;
              $fullImgSource = Params::pathPegawaiDirectory() . $fullImgName;
              $fullThumbSource = Params::pathPegawaiTumbsDirectory() . 'kecil_' . $fullImgName;
              //                                    if($model->save())
              if ($model->update()) {
                if (!empty($temLogo)) {
                  if (file_exists(Params::pathPegawaiDirectory() . $temLogo)) {
                    unlink(Params::pathPegawaiDirectory() . $temLogo);
                  }
                  if (file_exists(Params::pathIconModulThumbsDirectory() . 'kecil_' . $temLogo)) {
                    unlink(Params::pathIconModulThumbsDirectory() . 'kecil_' . $temLogo);
                  }
                }
                $gambar->saveAs($fullImgSource);
                $thumb->create($fullImgSource)
                  ->resize(200, 200)
                  ->save($fullThumbSource);
              } else {
                Yii::app()->user->setFlash('error', 'Data <strong>Gagal!</strong>  disimpan.');
              }
            } else {
              $model->photopegawai = $model->photopegawai;
            }
          } else {
            ////Jika user Memasukan Photo Dari Webcam
            if (!empty($temLogo)) {
              if (!empty($temLogo)) {
                if (file_exists(Params::pathPegawaiDirectory() . $temLogo)) {
                  unlink(Params::pathPegawaiDirectory() . $temLogo);
                }
                if (file_exists(Params::pathIconModulThumbsDirectory() . 'kecil_' . $temLogo)) {
                  unlink(Params::pathIconModulThumbsDirectory() . 'kecil_' . $temLogo);
                }
              }
            }
            $model->update();
          }
        } else {
          $model->photopegawai = $temLogo;
        }

        if (!empty($_POST['ruangan_id']))
          $jumlahRuanganPegawai = count((array)$_POST['ruangan_id']);
        else
          $jumlahRuanganPegawai = 0;
        $pegawai_id = $model->pegawai_id;
        $hapusRuanganPegawai =  RuanganpegawaiM::model()->deleteAll('pegawai_id=' . $pegawai_id . '');
        for ($i = 0; $i < $jumlahRuanganPegawai; $i++) {
          $modRuanganPegawai = new RuanganpegawaiM;
          $modRuanganPegawai->ruangan_id = $_POST['ruangan_id'][$i];
          $modRuanganPegawai->pegawai_id = $pegawai_id;
          $modRuanganPegawai->save();
        }
        // $gelardepan = LookupM::model()->findByPk($model->gelardepan);
        // $model->gelardepan = $gelardepan->lookup_name;
        $model->update(); // update data 
        $transaction->commit();
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan !');
        $this->redirect(array('admin', 'id' => $model->pegawai_id));
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render('update', array(
      'model' => $model, 'modRuanganPegawai' => $modRuanganPegawai, 'format' => $format
    ));
  }
  public function actionUpdateUser($id = '', $frame = '')
  {
    if ($frame == 'frame') :
      $this->layout = '//layouts/iframe';
    endif;

    $loginpemakai = Yii::app()->user->id;
    $criteria = new CDbCriteria;
    $criteria->addCondition('loginpemakai_id = ' . $loginpemakai);
    $pegawai = LoginpemakaiK::model()->find($criteria);
    if (empty($id)) {
      $id = $pegawai->pegawai_id;
    }
    $model = $this->loadModel($id);
    $modRuanganPegawai = RuanganpegawaiM::model()->findAll('pegawai_id=' . $id . '');
    $temLogo = $model->photopegawai;

    $format = new MyFormatter();
    if (isset($_POST['SAPegawaiM'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $random = $model->nomorindukpegawai;
        $model->attributes = $_POST['SAPegawaiM'];
        $model->profilrs_id = Params::getDefaultProfilRS();
        $model->update_time = date('Y-m-d');
        $model->update_loginpemakai_id = Yii::app()->user->id;
        if (!empty($_POST['SAPegawaiM']['tgl_lahirpegawai'])) {
          $model->tgl_lahirpegawai = $format->formatDateTimeForDb($model->tgl_lahirpegawai);
        } else {
          $model->tgl_lahirpegawai = null;
        }

        if (!empty($_POST['SAPegawaiM']['tglditerima'])) {
          $model->tglditerima = $format->formatDateTimeForDb($model->tglditerima);
        } else {
          $model->tglditerima = null;
        }

        $model->pegawai_aktif = true;
        $model->photopegawai = CUploadedFile::getInstance($model, 'photopegawai');
        $gambar = $model->photopegawai;
        if (isset($model->photopegawai)) {
          if ($_POST['caraAmbilPhoto'] == 'file') //Jika User Mengambil photo pegawai dengan cara upload file
          {
            if (!empty($model->photopegawai)) //Klo User Memasukan Logo
            {
              $model->photopegawai = $random . '.' . $model->photopegawai->getExtensionName(); //.$model->photopegawai
              Yii::import("ext.EPhpThumb.EPhpThumb");
              $thumb = new EPhpThumb();
              $thumb->init(); //this is needed
              $fullImgName = $model->photopegawai;
              $fullImgSource = Params::pathPegawaiDirectory() . $fullImgName;
              $fullThumbSource = Params::pathPegawaiTumbsDirectory() . 'kecil_' . $fullImgName;
              //                                    if($model->save())
              if ($model->update()) {
                if (!empty($temLogo)) {
                  if (file_exists(Params::pathPegawaiDirectory() . $temLogo)) {
                    unlink(Params::pathPegawaiDirectory() . $temLogo);
                  }
                  if (file_exists(Params::pathIconModulThumbsDirectory() . 'kecil_' . $temLogo)) {
                    unlink(Params::pathIconModulThumbsDirectory() . 'kecil_' . $temLogo);
                  }
                }
                $gambar->saveAs($fullImgSource);
                $thumb->create($fullImgSource)
                  ->resize(200, 200)
                  ->save($fullThumbSource);
              } else {
                Yii::app()->user->setFlash('error', 'Data <strong>Gagal!</strong>  disimpan.');
              }
            } else {
              $model->photopegawai = $model->photopegawai;
            }
          } else {
            ////Jika user Memasukan Photo Dari Webcam
            if (!empty($temLogo)) {
              if (!empty($temLogo)) {
                if (file_exists(Params::pathPegawaiDirectory() . $temLogo)) {
                  unlink(Params::pathPegawaiDirectory() . $temLogo);
                }
                if (file_exists(Params::pathIconModulThumbsDirectory() . 'kecil_' . $temLogo)) {
                  unlink(Params::pathIconModulThumbsDirectory() . 'kecil_' . $temLogo);
                }
              }
            }
            $model->update();
          }
        } else {
          $model->photopegawai = $temLogo;
        }

        /*if(!empty($_POST['ruangan_id']))
						$jumlahRuanganPegawai = count((array)$_POST['ruangan_id']);
					else
						$jumlahRuanganPegawai = 0;
						$pegawai_id=$model->pegawai_id;
						$hapusRuanganPegawai=  RuanganpegawaiM::model()->deleteAll('pegawai_id='.$pegawai_id.''); 
						for($i=0; $i<$jumlahRuanganPegawai; $i++)
						{
							$modRuanganPegawai = new RuanganpegawaiM;
							$modRuanganPegawai->ruangan_id=isset($_POST['ruangan_id'][$i]) ? $_POST['ruangan_id'][$i] : null;
							$modRuanganPegawai->pegawai_id=$pegawai_id;
							$modRuanganPegawai->save();
						}*/
        // $gelardepan = LookupM::model()->findByPk($model->gelardepan);
        // $model->gelardepan = $gelardepan->lookup_name;
        $model->update(); // update data 
        $transaction->commit();
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan !');
        $this->redirect(array('viewUser', 'sukses' => 1, 'frame' => $frame));
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($e, true));
      }
    }

    $this->render('updateUser', array(
      'model' => $model, 'modRuanganPegawai' => $modRuanganPegawai, 'format' => $format
    ));
  }

  public function actionProfilKlinik()
  {
    $loginpemakai_id = Yii::app()->user->id;
    $criteria = new CDbCriteria;
    $criteria->compare('loginpemakai_id', $loginpemakai_id);
    $pegawai = LoginpemakaiK::model()->find($criteria);
    if (empty($idPegawai))
      $idPegawai = $pegawai->pegawai_id;

    $this->render('kepegawaian.views.pegawaiM._viewprofilKlinik', array(
      'model' => $this->loadModel($idPegawai),
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
    $dataProvider = new CActiveDataProvider('SAPegawaiM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new SAPegawaiM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SAPegawaiM'])) {
      $model->attributes = $_GET['SAPegawaiM'];
      $model->ruangan_id = $_GET['SAPegawaiM']['ruangan_id'];
    }

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
    $model = SAPegawaiM::model()->findByPk($id);

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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sapegawai-m-form') {
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
    if (Yii::app()->request->isAjaxRequest) {
      $data['sukses'] = 0;
      $model = $this->loadModel($id);
      $model->pegawai_aktif = false;
      if ($model->save()) {
        $data['sukses'] = 1;
      }
      echo CJSON::encode($data);
    }
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //		SAPegawaiM::model()->updateByPk($id, array('pegawai_aktif'=>false));
    //		$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function actionUnremoveTemporary($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    SAPegawaiM::model()->updateByPk($id, array('pegawai_aktif' => true));
    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function actionPrint()
  {
    $model = new SAPegawaiM;
    $model->attributes = $_REQUEST['SAPegawaiM'];
    $judulLaporan = 'Data Pegawai';
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


  /**
   * Mengatur dropdown kabupaten
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownKabupaten($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {

      $modPegawai = new SAPegawaiM;
      if ($model_nama !== '' && $attr == '') {
        $propinsi_id = $_POST["$model_nama"]['propinsi_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $propinsi_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $propinsi_id = $_POST["$model_nama"]["$attr"];
      }
      $kabupaten = null;
      if ($propinsi_id) {
        $kabupaten = $modPegawai->getKabupatenItems($propinsi_id);

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
      $modPegawai = new SAPegawaiM;
      if ($model_nama !== '' && $attr == '') {
        $kabupaten_id = $_POST["$model_nama"]['kabupaten_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $kabupaten_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $kabupaten_id = $_POST["$model_nama"]["$attr"];
      }
      $kecamatan = null;
      if ($kabupaten_id) {
        $kecamatan = $modPegawai->getKecamatanItems($kabupaten_id);
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
      $modPegawai = new SAPegawaiM;
      if ($model_nama !== '' && $attr == '') {
        $kecamatan_id = $_POST["$model_nama"]['kecamatan_id'];
      } elseif ($model_nama == '' && $attr !== '') {
        $kecamatan_id = $_POST["$attr"];
      } elseif ($model_nama !== '' && $attr !== '') {
        $kecamatan_id = $_POST["$model_nama"]["$attr"];
      }
      $kelurahan = null;
      if ($kecamatan_id) {
        $kelurahan = $modPegawai->getKelurahanItems($kecamatan_id);
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
}
