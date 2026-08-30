<?php

class LoginpemakaiKController extends MyAuthController
{
  public $ruangantersimpan = true; //looping
  public $modultersimpan = true; //looping

  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $sqlRuangan = "SELECT 
                    ruangan_m.ruangan_id, 
                    ruangan_m.instalasi_id, 
                    ruangan_m.ruangan_nama, 
                    instalasi_m.instalasi_nama ,
                    instalasi_m.instalasi_aktif,
                    ruangan_m.ruangan_aktif
                  FROM 
                    public.instalasi_m, 
                    public.ruangan_m, 
                    public.ruanganpemakai_k
                  WHERE 
                    ruangan_m.instalasi_id = instalasi_m.instalasi_id AND
                    ruanganpemakai_k.ruangan_id = ruangan_m.ruangan_id AND ruanganpemakai_k.loginpemakai_id = $id 
                  ORDER BY instalasi_m.instalasi_nama asc";
    $sqlModul = "SELECT 
                  moduluser_k.modul_id, 
                  moduluser_k.loginpemakai_id, 
                  modul_k.modul_nama
                FROM 
                  public.modul_k, 
                  public.moduluser_k
                WHERE 
                  moduluser_k.modul_id = modul_k.modul_id AND moduluser_k.loginpemakai_id = $id
                ORDER BY modul_k.modul_nama asc";
    $this->render('view', array(
      'model' => $this->loadModel($id),
      'modRuanganPemakai' => Yii::app()->db->createCommand($sqlRuangan)->queryAll(),
      'modModulPemakai' => Yii::app()->db->createCommand($sqlModul)->queryAll(),
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $format = new MyFormatter();
    $model = new LoginpemakaiK;
    $model->jenispemakai = 'pegawai';
    $model->nama_pemakai = '';
    $simpanRuangan = '';
    $simpanModul = '';
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['LoginpemakaiK'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['LoginpemakaiK'];
        $model->katakunci_pemakai = $model->new_password;
        $model->ruangan = (isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null);
        $model->modul = (isset($_POST['modul_id']) ? $_POST['modul_id'] : null);
        $model->jenispemakai = (isset($_POST['LoginpemakaiK']['jenispemakai']) ? $_POST['LoginpemakaiK']['jenispemakai'] : null);
        $model->ppds_id = (isset($_POST['LoginpemakaiK']['ppds_id']) ? $_POST['LoginpemakaiK']['ppds_id'] : null);
        $model->loginpemakai_aktif = TRUE;
        $model->statuslogin = FALSE;
        $model->lastlogin = $format->formatDateTimeForDb($model->lastlogin);
        $model->tglpembuatanlogin = $format->formatDateTimeForDb($model->tglpembuatanlogin);
        $model->tglupdatelogin = $format->formatDateTimeForDb($model->tglupdatelogin);
        $model->waktuterakhiraktifitas = $format->formatDateTimeForDb($model->waktuterakhiraktifitas);
        if ($_POST['LoginpemakaiK']['jenispemakai'] == 'pegawai') {
          $model->pasien_id = null;
        } else {
          $model->pegawai_id = null;
        }
        $model->waktuterakhiraktifitas = date("Y-m-d H:i:s");
        $model->setScenario('insert');

        if ($model->save()) {
          if ($_POST['LoginpemakaiK']['jenispemakai'] == 'pegawai') {
            $simpanRuangan = $this->insertRuanganPemakai($model);
            $simpanModul = $this->insertModulPemakai($model);

            if (!empty($model->pegawai_id)) {
              $logNull = SAPegawaiM::model()->findByAttributes(array('loginpemakai_id' => $model->loginpemakai_id));
              if (!empty($logNull)) {
                $logNull->loginpemakai_id = null;
                $logNull->save();
              }

              $peg = SAPegawaiM::model()->updateByPk($model->pegawai_id, array('loginpemakai_id' => $model->loginpemakai_id));
            }
          } else {
            if (!empty($model->pasien_id)) {
              $logNull = SAPasienM::model()->findByAttributes(array('loginpemakai_id' => $model->loginpemakai_id));
              if (!empty($logNull)) {
                $logNull->loginpemakai_id = null;
                $logNull->save();
              }

              $peg = SAPasienM::model()->updateByPk($model->pasien_id, array('loginpemakai_id' => $model->loginpemakai_id));
            }
          }
          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('admin', 'id' => $model->loginpemakai_id, 'modul_id' => Params::MODUL_ID_SISADMIN));
        }
      } catch (Exception $e) {

        echo '<pre>'; var_dump($e); die;
        //echo $e->getMessage();die;
        $transaction->rollback();
        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
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
    $format = new MyFormatter();
    $model = $this->loadModel($id);
    $model->jenispemakai = 'pegawai';

    $modRuanganPemakai = $this->loadRuanganLogin($id);
    $modModulPemakai = $this->loadModulLogin($id);

    $model->nama_pegawai = isset($model->pegawai_id) ? $model->pegawai->NamaLengkap : null;
    $model->nama_pasien = isset($model->pasien_id) ? $model->pasien->nama_pasien : null;

    if (isset($_POST['LoginpemakaiK'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['LoginpemakaiK'];
        $model->ppds_id = (isset($_POST['LoginpemakaiK']['ppds_id']) ? $_POST['LoginpemakaiK']['ppds_id'] : null);
        $model->lastlogin = $format->formatDateTimeForDb($model->lastlogin);
        // $model->tglpembuatanlogin = $format->formatDateTimeForDb($model->tglpembuatanlogin);
        $model->tglupdatelogin = $format->formatDateTimeForDb($model->tglupdatelogin);
        $model->waktuterakhiraktifitas = $format->formatDateTimeForDb($model->waktuterakhiraktifitas);
        $model->old_password = $model->katakunci_pemakai;
        if ($_POST['LoginpemakaiK']['jenispemakai'] == 'pegawai') {
          $model->pasien_id = null;
        } else {
          $model->pegawai_id = null;
        }
        // if a new password has been entered
        if (!empty($model->new_password) || !empty($model->new_password_repeat) || !empty($model->old_password)) {
          $model->setScenario('changePassword2');
        } else {
          $model->setScenario('update');
        }
        if ($model->validate()) {
          $model->lastlogin = date('Y-m-d h:i:s');
          // $model->tglpembuatanlogin = date('Y-m-d h:i:s');
          if ($model->new_password !== '' && $model->old_password !== '') {
            if ($model->katakunci_pemakai == $model->old_password) {
              $model->katakunci_pemakai = $model->encrypt($model->new_password);
            } else {
              Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Password yang Anda inputkan tidak sesuai dengan database.');
              $this->redirect(array('update', 'id' => $model->loginpemakai_id));
            }
          }
          $this->deleteRuanganLogin($id);
          $this->deleteModulLogin($id);
          $this->insertRuanganPemakai($model);
          $this->insertModulPemakai($model);
          if ($model->update() && $this->ruangantersimpan && $this->modultersimpan) {
            if ($_POST['LoginpemakaiK']['jenispemakai'] == 'pegawai') {
              if (!empty($model->pegawai_id)) {

                $logNull = SAPegawaiM::model()->findByAttributes(array('loginpemakai_id' => $model->loginpemakai_id));
                if (!empty($logNull)) {
                  $logNull->loginpemakai_id = null;
                  $logNull->save();
                }

                $peg = SAPegawaiM::model()->updateByPk($model->pegawai_id, array('loginpemakai_id' => $model->loginpemakai_id));
              } else {
                $logNull = SAPegawaiM::model()->findByAttributes(array('loginpemakai_id' => $model->loginpemakai_id));
                if (!empty($logNull)) {
                  $logNull->loginpemakai_id = null;
                  $logNull->save();
                }
              }
            } else {
              if (!empty($model->pasien_id)) {
                $logNull = SAPasienM::model()->findByAttributes(array('loginpemakai_id' => $model->loginpemakai_id));
                if (!empty($logNull)) {
                  $logNull->loginpemakai_id = null;
                  $logNull->save();
                }

                $peg = SAPasienM::model()->updateByPk($model->pasien_id, array('loginpemakai_id' => $model->loginpemakai_id));
              } else {
                $logNull = SAPegawaiM::model()->findByAttributes(array('loginpemakai_id' => $model->loginpemakai_id));
                if (!empty($logNull)) {
                  $logNull->loginpemakai_id = null;
                  $logNull->save();
                }
              }
            }
            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
            // $this->redirect(array('view','id'=>$model->loginpemakai_id)
            $transaction->commit();
            $this->redirect(array('admin', 'id' => $model->loginpemakai_id, 'modul_id' => Params::MODUL_ID_SISADMIN));
          } else {
            Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data Gagal Disimpan.' . CHtml::errorSummary($model));
            //$this->redirect(array('admin','id'=>$model->loginpemakai_id));
          }
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render('update', array(
      'model' => $model,
      'modRuanganPemakai' => $modRuanganPemakai,
      'modModulPemakai' => $modModulPemakai,
    ));
  }

  /**
   * klon data pemakai
   */
  public function actionKlon($id)
  {
    $this->layout = '//layouts/iframe';
    $model = $this->loadModel($id);
    $models = new LoginpemakaiK();
    if (empty($model->pegawai_id)) {
      $nama = PasienM::model()->findByAttributes(array('pasien_id' => $model->pasien_id));
      if (isset($_POST['LoginpemakaiK'])) {
        $this->klonLoginPemakai($_POST['LoginpemakaiK'], $model);
      }
    } else {
      $nama = PegawaiM::model()->findByAttributes(array('pegawai_id' => $model->pegawai_id));
      if (isset($_POST['LoginpemakaiK'])) {
        $this->klonLoginPemakai($_POST['LoginpemakaiK'], $model);
      }
    }

    $this->render('_formklon', array(
      'model' => $model,
      'nama' => $nama,
      'models' => $models
    ));
  }

  public function klonLoginPemakai($post, $modLogin)
  {
    $trans = Yii::app()->db->beginTransaction();
    $ok = true;

    try {
      $model = new LoginpemakaiK("insert");
      $model->attributes = $modLogin->attributes;
      $model->attributes = $post;

      $model->new_password = $post['new_password'];
      $model->new_password_repeat = $post['new_password'];
      $model->katakunci_pemakai = $post['new_password'];
      $model->lastlogin = null;
      $model->statuslogin = false;
      $model->ruanganaktifitas = null;
      $model->waktuterakhiraktifitas = date('Y-m-d H:i:s');
      $model->photouser = null;
      $model->tglpembuatanlogin = date('Y-m-d');
      $model->create_time = date('Y-m-d H:i:s');
      $model->create_loginpemakai_id = Yii::app()->user->id;
      $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $model->setScenario('insert');


      // var_dump($model->attributes);


      if ($model->validate()) {
        $ok = $ok && $model->save();
        $model->rehashPassword($post['new_password']);
      } else {
        $ok = false;
      }

      // clone ruangan
      $ruangan = RuanganpemakaiK::model()->findAllByAttributes(array(
        'loginpemakai_id' => $modLogin->loginpemakai_id,
      ));
      foreach ($ruangan as $item) {
        $mod = new RuanganpemakaiK();
        $mod->attributes = $item->attributes;
        $mod->loginpemakai_id = $model->loginpemakai_id;

        $ok = $ok && $mod->save();
      }

      // clone modul
      $modul = ModuluserK::model()->findAllByAttributes(array(
        'loginpemakai_id' => $modLogin->loginpemakai_id,
      ));
      foreach ($modul as $item) {
        $mod = new ModuluserK();
        $mod->attributes = $item->attributes;
        $mod->loginpemakai_id = $model->loginpemakai_id;

        $ok = $ok && $mod->save();
      }

      // clone akses pemakai
      $akses = AksespenggunaK::model()->findAllByAttributes(array(
        'loginpemakai_id' => $modLogin->loginpemakai_id,
      ));
      foreach ($akses as $item) {
        $mod = new AksespenggunaK();
        $mod->attributes = $item->attributes;
        $mod->tugas_nama = $item->tugas_nama;
        $mod->loginpemakai_id = $model->loginpemakai_id;
        $mod->create_time = $model->create_time;
        $mod->create_loginpemakai_id = $model->create_loginpemakai_id;
        $mod->create_ruangan = $model->loginpemakai_id;

        if ($mod->validate()) {
          $ok = $ok && $mod->save();
        } else {
          $ok = false;
        }

        // var_dump($mod->attributes);
      }


      if ($ok) {
        $trans->commit();
        Yii::app()->user->setFlash('success', "Pemakai berhasil di-klon.");
      } else {
        $trans->rollback();
        Yii::app()->user->setFlash('error', "Pemakai gagal di-klon.");
      }
    } catch (Exception $ex) {
      $trans->rollback();
      Yii::app()->user->setFlash('error', "Pemakai gagal di-klon." . MyExceptionMessage::getMessage($ex, true));
    }
  }

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('LoginpemakaiK');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $this->pageTitle = Yii::app()->name . " - Login Pemakai";
    $model = new LoginpemakaiK('search');
    $model2  = new PegawaiM('search');
    $model3  = new PpdsM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['LoginpemakaiK'])) {
      $model->attributes = $_GET['LoginpemakaiK'];
      $model->nama_pegawai= $_GET['LoginpemakaiK']['nama_pegawai'];
      $model->ppds_nama= $_GET['LoginpemakaiK']['nama_pegawai'];
      $model->is_ppds = $_GET['LoginpemakaiK']['is_ppds'];

    }

    $this->render('admin', array(
      'model' => $model,
      'model2'=> $model2,
      'model3' => $model3
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = LoginpemakaiK::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'loginpemakai-k-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   * Menghapus ruangan-ruangan berdasarkan loginpemakai_id di ruanganpemakai_k
   * @param type $loginId 
   */
  public function deleteRuanganLogin($loginId)
  {
    $result = RuanganpemakaiK::model()->deleteAllByAttributes(array('loginpemakai_id' => $loginId));
  }

  /**
   * Mengambil nilai dari ruanganpemakai_k berdasarkan loginpemakai_id
   * @param type $loginId
   * @return $result array() 
   */
  public function loadRuanganLogin($loginId)
  {
    $result = RuanganpemakaiK::model()->findAllByAttributes(array('loginpemakai_id' => $loginId));
    return $result;
  }

  /**
   * Menyimpan data ke tabel ruanganpemakai_k
   * @param type $status
   */
  public function insertRuanganPemakai($model)
  {
    $ruangan = new RuanganpemakaiK;
    if (isset($_POST['ruangan_id'])) {
      $hitung = count((array)$_POST['ruangan_id']);
      if ($hitung < 1) {
        return $status = TRUE;
      } //kondisi apabila tidak ada inputan di emultiselect
      for ($i = 0; $i < $hitung; $i++) {
        $ruangan = new RuanganpemakaiK;
        $ruangan->loginpemakai_id = $model->loginpemakai_id;
        $ruangan->ruangan_id = $_POST['ruangan_id'][$i];
        if ($ruangan->save()) {
          $this->ruangantersimpan &= true;
        } else {
          $this->ruangantersimpan &= false;
        }
      }
    }

    return $ruangan;
  }

  /**
   * Menghapus modul-modul berdasarkan loginpemakai_id di moduluser_k
   * @param type $loginId 
   */
  public function deleteModulLogin($loginId)
  {
    $result = ModuluserK::model()->deleteAllByAttributes(array('loginpemakai_id' => $loginId));
  }

  /**
   * Mengambil nilai dari moduluser_k berdasarkan loginpemakai_id
   * @param type $loginId
   * @return $result array() 
   */
  public function loadModulLogin($loginId)
  {
    $result = ModuluserK::model()->findAllByAttributes(array('loginpemakai_id' => $loginId));
    return $result;
  }

  /**
   * Menyimpan data ke tabel moduluser_k
   * @param type $status
   */
  public function insertModulPemakai($model)
  {
    $modul = new ModuluserK;
    if (isset($_POST['modul_id'])) {
      $hitung = count((array)$_POST['modul_id']);
      if ($hitung < 1) {
        return $status = TRUE;
      } //kondisi apabila tidak ada inputan di emultiselect
      for ($i = 0; $i < $hitung; $i++) {
        $modul = new ModuluserK;
        $modul->loginpemakai_id = $model->loginpemakai_id;
        $modul->modul_id = $_POST['modul_id'][$i];
        if ($modul->save()) {
          $this->modultersimpan &= true;
        } else {
          $this->modultersimpan &= false;
        }
      }
    }

    return $modul;
  }

  public function actionDelete()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    if (Yii::app()->request->isPostRequest) {
      // try {
   
      // } catch (Exception $e) {


      //   // CustomFunction::saveError($e);
      //   throw $e;
      //   var_dump($model);die;                                                
      //   echo CJSON::encode(array(
      //     'status' => 'gagal_form',
      //     'pesan' => "Data Gagal Dihapus",
      //   ));
      // }
      $ok = false;
      $id = $_POST['id'];
      // $ok = $ok && $this->loadModel($id)->delete();
        $model = $this->loadModel($id);
        $deletemodul = false;
        $deletemodpeg = false;
        $deletepeg = false;
        $deleteruangpemakai = false;
        // // $delete = false;

        if ($model) {

            $modulk = ModuluserK::model()->findAllByAttributes(array(
              'loginpemakai_id' =>$model->loginpemakai_id
            ));
            if(count($modulk) > 0){
             
              ModuluserK::model()->deleteAllByAttributes(array(
                'loginpemakai_id' =>$model->loginpemakai_id
              ));
              $deletemodul = true;
            } else{
              $deletemodul = true;
            }
            $modPeg = PegawaiM::model()->findByAttributes(array('loginpemakai_id' => $model->loginpemakai_id));
            if ($modPeg) {
                $modPeg->loginpemakai_id = null;
                $modPeg->save();
                $deletemodpeg = true;
            }else{
              $deletemodpeg = true;
            }
            $updatePeg = PegawaiM::model()->findAllByAttributes(array(
              'update_loginpemakai_id' =>$model->loginpemakai_id
            ));
            if(count($updatePeg) > 0){
              foreach ($updatePeg as $peg) {
                $peg->update_loginpemakai_id = 1;
                $peg->save();
                $deletepeg = true;
              }
            }else{
              $deletepeg = true;
            }

            $ruangpemakai = RuanganpemakaiK::model()->findAllByAttributes(array(
              'loginpemakai_id' =>$model->loginpemakai_id
            ));
            if(count($ruangpemakai) > 0){
             
              RuanganpemakaiK::model()->deleteAllByAttributes(array(
                'loginpemakai_id' =>$model->loginpemakai_id
              ));
              $deleteruangpemakai = true;
            } else{
              $deleteruangpemakai = true;
            }
          
     
            NotifikasiR::model()->deleteAllByAttributes(array(
              'create_loginpemakai_id' =>$model->loginpemakai_id
            ));
            NotifikasiR::model()->deleteAllByAttributes(array(
              'update_loginpemakai_id' =>$model->loginpemakai_id
            ));
            if($deletemodul&&$deletemodpeg&&$deletepeg&&$deleteruangpemakai){
              // var_dump('asdasdasdasd');die;
              $model->delete();
              $ok = true;
            }
          }
      //if (Yii::app()->request->isAjaxRequest)
      //{
      if ($ok) {
        echo CJSON::encode(array(
          'status' => 'proses_form',
          'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
        ));
      } else {
        echo CJSON::encode(array(
          'status' => 'gagal_form',
          'pesan' => "Data Gagal Dihapus",
        ));
      }
      ///  exit;
      //}
      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      //if(!isset($_GET['ajax']))
      ////	$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
      //exit;                       
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * Mengubah status aktif
   * @param type $id 
   */
  public function actionRemoveTemporary()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //                    SAPropinsiM::model()->updateByPk($id, array('propinsi_aktif'=>false));
    //                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));


    $id = $_POST['id'];
    if (isset($_POST['id'])) {
      $update = LoginpemakaiK::model()->updateByPk($id, array('loginpemakai_aktif' => false));
      if ($update) {
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
          ));
          exit;
        }
      }
    } else {
      if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(array(
          'status' => 'proses_form',
        ));
        exit;
      }
    }
  }

  public function actionPrint()
  {
    $model = new LoginpemakaiK;

    if (isset($_GET['LoginpemakaiK'])) {
      $model->attributes = $_GET['LoginpemakaiK'];
    }
    $judulLaporan = ' Data Pemakai';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {

      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                            //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      ////$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  /**
   * fungsi untuk mengganti password login pemakai
   * @param type $id integer
   */
  /* public function actionGantiPassword($id){
      $model = $this->loadModel($id);
      $prevUrl = Yii::app()->request->getUrlReferrer();
      $format = new MyFormatter();
      if(isset ($_POST['LoginpemakaiK'])){
      $model->attributes=$_POST['LoginpemakaiK'];
      $model->old_password = $_POST['LoginpemakaiK']['old_password'];
      $model->setScenario('changePassword');
      $model->lastlogin = date('Y-m-d');
      $model->tglupdatelogin = date('Y-m-d');
      $model->loginpemakai_update = 1;
      $model->tglpembuatanlogin = empty($model->tglpembuatanlogin) ? null : $format->formatDateTimeForDb($model->tglpembuatanlogin);
      if ($model->validate())
      {
      if ($model->new_password !== '' && $model->old_password !=='')
      {
      if($model->katakunci_pemakai == $model->encrypt($model->old_password)){
      $model->katakunci_pemakai = $model->encrypt($model->new_password);
      }else{
      Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Password yang Anda inputkan tidak sesuai dengan database.');
      $this->redirect(array('GantiPassword','id'=>$model->loginpemakai_id));
      }
      }
      if($model->update())
      {
      Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Password berhasil disimpan.');
      $this->redirect($_POST['prevUrl']);
      }
      else
      {
      Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data Gagal Disimpan.');
      $this->redirect(array('GantiPassword','id'=>$model->loginpemakai_id));
      }
      }
      }
      $this->render('gantiPassword',array(
      'model'=>$model,'prevUrl'=>$prevUrl,
      ));


      } */
  public function actionGantiPassword($id = '')
  {
    if (empty($id))
      $id = Yii::app()->user->id;

    //echo $_SESSION['username'];
    //echo Yii::app()->user->name;
    //echo Yii::app()->session['instalasi_id'];
    //echo Yii::app()->user->getState('instalasi_id');
    $model = $this->loadModel($id);
    $prevUrl = Yii::app()->request->getUrlReferrer();
    if (isset($_POST['LoginpemakaiK'])) {
      $trans = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['LoginpemakaiK'];
        $model->old_password = $_POST['LoginpemakaiK']['old_password'];

        if ($model->cekPassword3($model->old_password)) {
          $model->katakunci_pemakai = $model->encrypt($model->new_password);

          // var_dump($model->attributes);
          $model->update(array('katakunci_pemakai'));
          $trans->commit();
          Yii::app()->user->setFlash('success', 'Password berhasil di ubah.');
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', 'Kata Kunci Lama Salah');
        }
      } catch (Exception $e) {
        $trans->rollback();
        Yii::app()->user->setFlash('error', 'Data Gagal Disimpan');
      }
      //$model->setScenario('changePassword');
      /* if ($model->validate())
              {
              if ($model->new_password !== '' && $model->old_password !=='')
              {
              if($model->katakunci_pemakai == $model->encrypt($model->old_password)){
              $model->katakunci_pemakai = $model->encrypt($model->new_password);
              $model->loginpemakai_update = Yii::app()->user->getState('loginpemakai_id');
              }else{
              Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Password yang Anda inputkan tidak sesuai dengan database.');
              $this->redirect(array('GantiPassword','id'=>$model->loginpemakai_id));
              }
              }
              if($model->save()())
              {
              Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Password berhasil disimpan.');
              //$this->redirect($_POST['prevUrl']);
              }
              else
              {
              Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data Gagal Disimpan.');
              $this->redirect(array('GantiPassword','id'=>$model->loginpemakai_id));
              }
              } */
    }
    $this->render('gantiPassword', array(
      'model' => $model, 'prevUrl' => $prevUrl,
    ));
  }

  public function actionAutoCompletePegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->addCondition('loginpemakai_id is null');
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = PegawaiM::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = trim($model->namaLengkap);
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionAutocompletePasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pasien';
      $criteria->limit = 5;
      $models = PasienM::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->no_rekam_medik . ' - ' . $model->nama_pasien;
        $returnVal[$i]['value'] = $model->nama_pasien;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionCekVerifikasiPeg()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pegawai_id = (isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null);
      $verif = (isset($_POST['verif']) ? $_POST['verif'] : null);
      $status = (isset($_POST['status']) ? $_POST['status'] : null);
      $pasien_id = (isset($_POST['pasien_id']) ? $_POST['pasien_id'] : null);
      $data = '';
      $data['status'] = $verif;

      if ($status == 'pegawai') {
        $cek = SAPegawaiM::model()->findByPk($pegawai_id);

        if (!empty($cek)) {
          if (!empty($cek->alamatemail)) {
            $data['verif_status_e'] = 'email';
            $data['verif_e'] = 1;
          } else {
            $data['verif_status_e'] = 'email';
            $data['verif_e'] = 0;
          }

          if (!empty($cek->nomobile_pegawai)) {
            $data['verif_status_p'] = 'phone';
            $data['verif_p'] = 1;
          } else {
            $data['verif_status_p'] = 'phone';
            $data['verif_p'] = 0;
          }

          $data['sukses'] = 1;
        }
      } elseif ($status == 'pasien') {
        $cek = SAPasienM::model()->findByPk($pasien_id);

        if (!empty($cek)) {
          if (!empty($cek->alamatemail)) {
            $data['verif_status_e'] = 'email';
            $data['verif_e'] = 1;
          } else {
            $data['verif_status_e'] = 'email';
            $data['verif_e'] = 0;
          }

          if (!empty($cek->no_mobile_pasien)) {
            $data['verif_status_p'] = 'phone';
            $data['verif_p'] = 1;
          } else {
            $data['verif_status_p'] = 'phone';
            $data['verif_p'] = 0;
          }

          $data['sukses'] = 1;
        }
      }

      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }
}
