<?php

class ModulKController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';

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
    $model = new SAModulK;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SAModulK'])) {
      $model->attributes = $_POST['SAModulK'];
      $instance = CUploadedFile::getInstance($model, 'icon_modul');

      if ($instance) {
        Yii::import("ext.EPhpThumb.EPhpThumb");

        $thumb = new EPhpThumb();
        $thumb->init(); //this is needed

        $fullImgName = str_replace('.'.$instance->getExtensionName(), '',$instance->getName()).'.' . $instance->getExtensionName();
        $fullImgSource = Params::pathIconModulDirectory() . $fullImgName;
        $fullThumbSource = Params::pathIconModulThumbsDirectory() . $fullImgName;

        $model->icon_modul = $fullImgName;

        if ($model->save()) {
          $instance->saveAs($fullImgSource);
          //chain functions
          $thumb->create($fullImgSource)
            ->resize(24, 24)
            ->save($fullThumbSource);
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('admin', 'id' => $model->modul_id));
        }
      } else {
        if ($model->save()) {
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('admin', 'id' => $model->modul_id));
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
    $tempIcon = $model->icon_modul;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SAModulK'])) {
      $instance = CUploadedFile::getInstance($model, 'icon_modul');
      // var_dump();die;
      if ($instance) {
        Yii::import("ext.EPhpThumb.EPhpThumb");

        $Objthumb = new EPhpThumb();
        $Objthumb->init(); //this is needed

        $fullImgName = str_replace('.'.$instance->getExtensionName(), '',$instance->getName()).'.' . $instance->getExtensionName();
        $fullImgSource = Params::pathIconModulDirectory() . $fullImgName;
        $fullThumbSource = Params::pathIconModulThumbsDirectory() . $fullImgName;

        $image = Params::pathIconModulDirectory() . $model->icon_modul;
        $thumb = Params::pathIconModulThumbsDirectory() . $model->icon_modul;

        $removeFile = true;
        if (!empty($tempIcon)) {
          if (file_exists($image))
            if (!(unlink($image) && unlink($thumb)))
              $removeFile = false;
        }

        if ($removeFile) {
          $model->icon_modul = $fullImgName;
          $model->icon_modul = $fullImgName;

          if ($model->save()) {
            $instance->saveAs($fullImgSource);
            $Objthumb->create($fullImgSource)
              ->resize(24, 24)
              ->save($fullThumbSource);

            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
            $this->redirect(array('admin', 'id' => $model->modul_id));
          }
        }
      }

      $model->attributes = $_POST['SAModulK'];
      $model->icon_modul = $tempIcon;
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('admin', 'id' => $model->modul_id));
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
  public function actionDelete()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    if (Yii::app()->request->isPostRequest) {
      $id = $_POST['id'];
      $menu = MenumodulK::model()->findByAttributes(array('modul_id' => $id));
      if ($menu) {
        throw new CHttpException(400, 'Maaf data ini tidak bisa dihapus dikarenakan digunakan pada table lain.');
      } else {
        $this->loadModel($id)->delete();
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
          ));
          exit;
        }
      }

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * Deletes Temporary a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionRemoveTemporary()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //                    SAPropinsiM::model()->updateByPk($id, array('propinsi_aktif'=>false));
    //                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));


    $id = $_POST['id'];
    if (isset($_POST['id'])) {
      $update = SAModulK::model()->updateByPk($id, array('modul_aktif' => false));
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

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('SAModulK');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $this->pageTitle = Yii::app()->name . " - Modul";
    $model = new SAModulK('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SAModulK']))
      $model->attributes = $_GET['SAModulK'];

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
    $model = SAModulK::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'samodul-k-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionPrint()
  {
    $model = new SAModulK;
    $model->attributes = $_REQUEST['SAModulK'];
    $judulLaporan = 'Data Modul';
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
      ////$mpdf->useOddEven = 2;  
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
