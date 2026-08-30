<?php

class KelaspelayananMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';

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
  public function actionCreateRuangan()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                                             
    $model = new KelasruanganM;
    if (isset($_POST['KelasruanganM'])) {

      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlahRuangan = count((array)$_POST['ruangan_id']);
        $kelasPelayanan_id = $_POST['KelasruanganM']['kelaspelayanan_id'];
        $hapuskelasRuangan = KelasruanganM::model()->deleteAll('kelaspelayanan_id=' . $kelasPelayanan_id . '');
        for ($i = 0; $i <= $jumlahRuangan; $i++) {
          $modKasusRuangan = new KelasruanganM;
          $modKasusRuangan->ruangan_id = (isset($_POST['ruangan_id'][$i]) ? $_POST['ruangan_id'][$i] : null);
          $modKasusRuangan->kelaspelayanan_id = $kelasPelayanan_id;
          $modKasusRuangan->save();
        }

        Yii::app()->user->setFlash('success', "Data Ruangan Dan Kelas Ruangan Berhasil Disimpan");
        $transaction->commit();
        $this->redirect(array('admin'));
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Ruangan Dan Kelas Ruangan Gagal Disimpan");
      }
    }
    $this->render('createRuangan', array(
      'model' => $model
    ));
  }

  public function actionCreate()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                                             
    $model = new PPKelaspelayananM;

    // Uncomment the following line if AJAX validation is needed



    if (isset($_POST['PPKelaspelayananM'])) {

      $valid = true;
      foreach ($_POST['PPKelaspelayananM'] as $i => $item) {
        //                         echo "rizky";
        //                    exit;
        if (is_integer($i)) {
          $model = new PPKelaspelayananM;
          if (isset($_POST['PPKelaspelayananM'][$i]))
            $model->attributes = $_POST['PPKelaspelayananM'][$i];
          $model->jeniskelas_id = $_POST['PPKelaspelayananM']['jeniskelas_id'];
          $model->kelaspelayanan_aktif = true;
          $valid = $model->validate() && $valid;
          if ($valid) {
            $model->save();
            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
            $this->redirect(array('admin'));
          } else {
            Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data tidak valid.');
          }
        }
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
    $modRuangan = KelasruanganM::model()->findAll('kelaspelayanan_id=' . $id . '');
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['PPKelaspelayananM'])) {
      if (isset($_POST['ruangan_id'])) :
        $jumlahRuangan = count((array)$_POST['ruangan_id']);
      else :
        $jumlahRuangan = 0;
      endif;

      $kelasPelayanan_id = $model->kelaspelayanan_id;
      $hapuskelasRuangan = KelasruanganM::model()->deleteAll('kelaspelayanan_id=' . $kelasPelayanan_id . '');
      $transaction = Yii::app()->db->beginTransaction();
      try {
        if ($jumlahRuangan > 0) {

          for ($i = 0; $i <= $jumlahRuangan; $i++) {
            $modKasusRuangan = new KelasruanganM;
            $modKasusRuangan->ruangan_id = (isset($_POST['ruangan_id'][$i]) ? $_POST['ruangan_id'][$i] : null);
            $modKasusRuangan->kelaspelayanan_id = $kelasPelayanan_id;
            $modKasusRuangan->save();
          }
          $model->attributes = $_POST['PPKelaspelayananM'];
          $model->save();
        }
        Yii::app()->user->setFlash('success', "Data Ruangan Dan Kelas Ruangan Berhasil Disimpan");
        $transaction->commit();
        $this->redirect(array('admin'));
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Ruangan Dan Jenis Kasus Penyakit Gagal Disimpan");
      }
    }

    $this->render('update', array(
      'model' => $model, 'modRuangan' => $modRuangan
    ));
  }

  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  //	public function actionDelete($id)
  //	{
  //		if(Yii::app()->request->isPostRequest)
  //		{
  //			// we only allow deletion via POST request
  //                        //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
  //			$this->loadModel($id)->delete();
  //
  //			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
  //			if(!isset($_GET['ajax']))
  //				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  //		}
  //		else
  //			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
  //	}

  public function actionDelete()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    if (Yii::app()->request->isAjaxRequest) {
      $id = $_POST['id'];
      $status = '';
      $keterangan = '';
      $modKelasPelayanan = PPKelaspelayananM::model()->findByPk($id);
      $modKelasRuangan = PPKelasruanganM::model()->findAllByAttributes(array('kelaspelayanan_id' => $id));
      if (count((array)$modKelasRuangan) > 0) {
        $status = 'proses_form';
        $keterangan = "Data Masih Digunakan pada tabel lain.";
      } else {
        $this->loadModel($id)->delete();
        $status = 'proses_form';
        $keterangan = "Data berhasil dihapus.";
      }
      echo CJSON::encode(array(
        'status' => $status,
        'keterangan' => $keterangan,
      ));
      exit;
    }
  }
  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('PPKelaspelayananM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new PPKelaspelayananM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['PPKelaspelayananM']))
      $model->attributes = $_GET['PPKelaspelayananM'];

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
    $model = PPKelaspelayananM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'ppkelaspelayanan-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   *Mengubah status aktif
   * @param type $id 
   */
  public function actionRemoveTemporary()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //PPKelaspelayananM::model()->updateByPk($id, array('kelaspelayanan_aktif'=>false));
    //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    //			
    $id = $_POST['id'];
    if (isset($_POST['id'])) {
      $update = KelaspelayananM::model()->updateByPk($id, array('kelaspelayanan_aktif' => false));


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
    $model = new PPKelaspelayananM;
    $model->attributes = $_REQUEST['PPKelaspelayananM'];
    $judulLaporan = 'Data Kelas Pelayanan';
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
}
