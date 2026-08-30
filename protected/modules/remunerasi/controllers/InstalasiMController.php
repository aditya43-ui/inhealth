<?php

class InstalasiMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';

  public function actionView($id)
  {
    $this->render('view', array(
      'model' => $this->loadModel($id),
    ));
  }
  public function actionCreate()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                                  
    $model = new SAInstalasiM();
    $modRiwayatRuanganR = new SARiwayatRuanganR();
    $modRiwayatRuanganR->tglpenetapanruangan = date('Y-m-d');
    $format = new MyFormatter();

    if (isset($_POST['SAInstalasiM'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modRiwayatRuanganR->attributes = $_POST['SARiwayatRuanganR'];
        $modRiwayatRuanganR->tglpenetapanruangan = $format->formatDateTimeForDb($_REQUEST['SARiwayatRuanganR']['tglpenetapanruangan']);
        $modRiwayatRuanganR->save();
        $model->attributes = $_POST['SAInstalasiM'];
        $model->instalasi_adakamar = $_POST['SAInstalasiM']['instalasi_adakamar'];
        $model->instalasi_image = CUploadedFile::getInstance($model, 'instalasi_image');
        $model->riwayatruangan_id = $modRiwayatRuanganR->riwayatruangan_id;

        $gambar = $model->instalasi_image;
        $random = rand(000000, 999999);
        if (!empty($model->instalasi_image)) //Klo User Memasukan Logo
        {
          $model->instalasi_image = $random . $model->instalasi_image;

          Yii::import("ext.EPhpThumb.EPhpThumb");

          $thumb = new EPhpThumb();
          $thumb->init(); //this is needed

          $fullImgName = $model->instalasi_image;
          $fullImgSource = Params::pathInstalasiDirectory() . $fullImgName;
          $fullThumbSource = Params::pathInstalasiTumbsDirectory() . 'kecil_' . $fullImgName;

          $model->instalasi_image = $fullImgName;

          if ($model->save()) {
            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
            $gambar->saveAs($fullImgSource);
            $thumb->create($fullImgSource)
              ->resize(200, 200)
              ->save($fullThumbSource);
          } else {
            Yii::app()->user->setFlash('error', 'Logo <strong>Gagal!</strong>  disimpan.');
          }
        } else {
          if ($model->save()) {
            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          }
        }

        $transaction->commit();
        $this->redirect(array('admin', 'id' => $model->instalasi_id));
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render('create', array(
      'model' => $model, 'modRiwayatRuanganR' => $modRiwayatRuanganR
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
    $temLogo = $model->instalasi_image;
    $modRiwayatRuanganR = SARiwayatRuanganR::model()->findByPk($model->riwayatruangan_id);
    $format = new MyFormatter();

    if (isset($_POST['SAInstalasiM'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modRiwayatRuanganR->attributes = $_POST['SARiwayatRuanganR'];
        $modRiwayatRuanganR->tglpenetapanruangan = $format->formatDateTimeForDb($_REQUEST['SARiwayatRuanganR']['tglpenetapanruangan']);
        $modRiwayatRuanganR->save();
        $model->attributes = $_POST['SAInstalasiM'];
        $model->instalasi_adakamar = $_POST['SAInstalasiM']['instalasi_adakamar'];
        $model->instalasi_image = CUploadedFile::getInstance($model, 'instalasi_image');
        $model->riwayatruangan_id = $modRiwayatRuanganR->riwayatruangan_id;

        $gambar = $model->instalasi_image;
        $random = rand(000000, 999999);
        if (!empty($model->instalasi_image)) //Klo User Memasukan Logo
        {
          $model->instalasi_image = $random . $model->instalasi_image;

          Yii::import("ext.EPhpThumb.EPhpThumb");

          $thumb = new EPhpThumb();
          $thumb->init(); //this is needed

          $fullImgName = $model->instalasi_image;
          $fullImgSource = Params::pathInstalasiDirectory() . $fullImgName;
          $fullThumbSource = Params::pathInstalasiTumbsDirectory() . 'kecil_' . $fullImgName;

          $model->instalasi_image = $fullImgName;

          if ($model->save()) {
            if (!empty($temLogo)) {
              unlink(Params::pathInstalasiDirectory() . $temLogo);
              unlink(Params::pathInstalasiTumbsDirectory() . 'kecil_' . $temLogo);
            }
            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
            $gambar->saveAs($fullImgSource);
            $thumb->create($fullImgSource)
              ->resize(200, 200)
              ->save($fullThumbSource);
          } else {
            Yii::app()->user->setFlash('error', 'Logo <strong>Gagal!</strong>  disimpan.');
          }
        } else {
          if ($model->save()) {
            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          }
        }

        $transaction->commit();
        $this->redirect(array('admin', 'id' => $model->instalasi_id));
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render('update', array(
      'model' => $model, 'modRiwayatRuanganR' => $modRiwayatRuanganR
    ));
  }

  public function actionUpdateaktifasi()
  {
    $this->pageTitle = Yii::app()->name . " - Instalasi";
    $model = new InstalasiM;
    if (isset($_POST['submitInstalasi'])) {
      InstalasiM::model()->updateAll(array('instalasi_aktif' => false));
      if (isset($_POST['instalasi_nonaktif'])) {
        foreach ($_POST['instalasi_nonaktif'] as $instalasi => $id) {
          InstalasiM::model()->updateByPk($id, array('instalasi_aktif' => true));
        }
      }
      Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
    }
    $this->render('updateaktifasi', array('model' => $model));
  }

  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id)
  {
    if (Yii::app()->request->isPostRequest) {
      //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                   
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model = InstalasiM::model()->findByPk($id);
        $temLogo = $model->instalasi_image;
        $hapusInstalasi = InstalasiM::model()->deleteByPk($id);
        $hapusRiwayatRuangan = SARiwayatRuanganR::model()->deleteByPk($model->riwayatruangan_id);

        if (!empty($temLogo)) {
          unlink(Params::urlInstalasiDirectory() . $temLogo);
          unlink(Params::urlInstalasiTumbsDirectory() . $temLogo);
        }
        $transaction->commit();
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }
    // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
    else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('SAInstalasiM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new SAInstalasiM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SAInstalasiM']))
      $model->attributes = $_GET['SAInstalasiM'];

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
    $model = SAInstalasiM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sainstalasi-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionRemoveTemporary($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                         
    SAInstalasiM::model()->updateByPk($id, array('instalasi_aktif' => false));
    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */


  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */

  public function actionPrint()
  {

    $model = new SAInstalasiM;
    $model->attributes = $_REQUEST['SAInstalasiM'];
    $judulLaporan = 'Data Instalasi';
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
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
