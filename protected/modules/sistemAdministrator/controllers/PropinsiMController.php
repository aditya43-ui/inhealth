<?php

class PropinsiMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';

  public function beforeAction($action)
  {
    return parent::beforeAction($action);
  }
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
    $model = new SAPropinsiM;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SAPropinsiM'])) {
      $model->attributes = $_POST['SAPropinsiM'];
      if (is_null($model->propinsi_aktif)) {
        $model->propinsi_aktif = TRUE;
      }
      if ($model->save()) {
        Yii::app()->user->setFlash('success', 'Data ' . $model->propinsi_nama . ' berhasil disimpan.');
        //$this->redirect(array('view','id'=>$model->propinsi_id));
        $this->redirect(array('admin'));
      } else {
        Yii::app()->user->setFlash('error', 'Data gagal disimpan');
      }
    }
    // untuk default latitude & longitude location picker
    $modPropinsi = PropinsiM::model()->findByPk(Yii::app()->user->getstate('propinsi_id'));
    $latitude  = $modPropinsi->latitude;
    $longitude = $modPropinsi->longitude;
    $this->render('create', array(
      'model' => $model, 'latitude' => $latitude, 'longitude' => $longitude,
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


    if (isset($_POST['SAPropinsiM'])) {
      $model->attributes = $_POST['SAPropinsiM'];
      $model->propinsi_aktif = $_POST['SAPropinsiM']['propinsi_aktif'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', 'Data ' . $model->propinsi_nama . ' berhasil disimpan.');
        //$this->redirect(array('view','id'=>$model->propinsi_id));
        $this->redirect(array('admin'));
      } else {
        Yii::app()->user->setFlash('error', 'Data gagal disimpan');
      }
    }
    // untuk default latitude & longitude (location-picker)
    $modPropinsi = PropinsiM::model()->findByPk(Yii::app()->user->getState('propinsi_id'));
    $latitude = isset($model->latitude) ? $model->latitude : $modPropinsi->latitude;
    $longitude = isset($model->longitude) ? $model->longitude : $modPropinsi->longitude;
    $this->render('update', array(
      'model' => $model, 'longitude' => $longitude, 'latitude' => $latitude
    ));
  }


  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('SAPropinsiM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new SAPropinsiM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SAPropinsiM']))
      $model->attributes = $_GET['SAPropinsiM'];

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
    $model = SAPropinsiM::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(401, 'The requested page does not exist.');
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sapropinsi-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionDelete()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    if (Yii::app()->request->isPostRequest) {
      $id = $_POST['id'];
      $kabupaten = KabupatenM::model()->findByAttributes(array('propinsi_id' => $id));
      if ($kabupaten) {
        echo CJSON::encode(array(
          'status' => 'error',
        ));
        exit();
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
   *Mengubah status aktif
   * @param type $id 
   */
  public function actionRemoveTemporary()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //                    SAPropinsiM::model()->updateByPk($id, array('propinsi_aktif'=>false));
    //                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));


    $id = $_POST['id'];
    if (isset($_POST['id'])) {
      $update = SAPropinsiM::model()->updateByPk($id, array('propinsi_aktif' => false));
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

    $model = new SAPropinsiM;
    $model->attributes = $_REQUEST['SAPropinsiM'];
    $judulLaporan = 'Data Propinsi';
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
   * menambah propinsi dari tombol "+" (Dialog Box)
   */
  public function actionAddPropinsi()
  {
    $modelPropinsi = new PropinsiM;

    if (isset($_POST['PropinsiM'])) {
      $modelPropinsi->attributes = $_POST['PropinsiM'];
      if ($modelPropinsi->save()) {
        $data = PropinsiM::model()->findAll(array('order' => 'propinsi_nama'));
        $data = CHtml::listData($data, 'propinsi_id', 'propinsi_nama');

        if (empty($data)) {
          $propinsiOption = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $propinsiOption = CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($data as $value => $name) {
            $propinsiOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Propinsi <b>" . $_POST['PropinsiM']['propinsi_nama'] . "</b> berhasil ditambahkan </div>",
            'propinsi' => $propinsiOption,
          ));
          exit;
        }
      }
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo CJSON::encode(array(
        'status' => 'create_form',
        'div' => $this->renderPartial('_formAddPropinsi', array('modelPropinsi' => $modelPropinsi), true)
      ));
      exit;
    }
  }
}
