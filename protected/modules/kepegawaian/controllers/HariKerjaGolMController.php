<?php

class HariKerjaGolMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';

  /**
   * @return array action filters
   */
  public function filters()
  {
    return array(
      'accessControl', // perform access control for CRUD operations
    );
  }

  /**
   * Specifies the access control rules.
   * This method is used by the 'accessControl' filter.
   * @return array access control rules
   */
  public function accessRules()
  {
    return array(
      array(
        'allow', // allow all users to perform 'index' and 'view' actions
        'actions' => array('index', 'view'),
        'users' => array('@'),
      ),
      array(
        'allow', // allow authenticated user to perform 'create' and 'update' actions
        'actions' => array('create', 'update', 'print'),
        'users' => array('@'),
      ),
      array(
        'allow', // allow admin user to perform 'admin' and 'delete' actions
        'actions' => array('admin', 'delete', 'RemoveTemporary'),
        'users' => array('@'),
      ),
      array(
        'deny', // deny all users
        'users' => array('*'),
      ),
    );
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
    $model = new KPHariKerjaGolM;
    //$model->periodeharikerjaawl = MyFormatter::formatDateTimeForUser(date('Y-m-d'));
    //$model->periodehariakhir = MyFormatter::formatDateTimeForUser(date('Y-m-d'));
    //$model->periodeharikerjaakhir = MyFormatter::formatDateTimeForUser(date('Y-m-d'));
    // Uncomment the following line if AJAX validation is needed
    // $this->performAjaxValidation($model);

    if (isset($_POST['KPHariKerjaGolM'])) {
      $model->attributes = $_POST['KPHariKerjaGolM'];
      //$model->periodeharikerjaawl = MyFormatter::formatDateTimeForDb($model->periodeharikerjaawl);
      //$model->periodehariakhir = MyFormatter::formatDateTimeForDb($model->periodehariakhir);
      //$model->periodeharikerjaakhir = MyFormatter::formatDateTimeForDb($model->periodeharikerjaakhir);
      //$model->periodeharikerjaawl = MyFormatter::formatDateTimeForDb($model->periodeharikerjaawl);
      //$model->periodehariakhir = MyFormatter::formatDateTimeForDb($model->periodehariakhir);
      //$model->periodeharikerjaakhir = MyFormatter::formatDateTimeForDb($model->periodeharikerjaakhir);
      $model->harikerjagol_aktif = true;

      if ($model->save()) {
        Yii::app()->user->setFlash('success', 'Data ' . $model->kelompokpegawai->kelompokpegawai_nama . ' berhasil disimpan.');
        $this->redirect(array('admin', 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan.");
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
    //$model->periodeharikerjaawl = MyFormatter::formatDateTimeForUser($model->periodeharikerjaawl);
    //$model->periodehariakhir = MyFormatter::formatDateTimeForUser($model->periodehariakhir);
    //$model->periodeharikerjaakhir = MyFormatter::formatDateTimeForUser($model->periodeharikerjaakhir);
    // Uncomment the following line if AJAX validation is needed
    // $this->performAjaxValidation($model);

    if (isset($_POST['KPHariKerjaGolM'])) {
      $model->attributes = $_POST['KPHariKerjaGolM'];
      //$model->periodeharikerjaawl = MyFormatter::formatDateTimeForDb($model->periodeharikerjaawl);
      //$model->periodehariakhir = MyFormatter::formatDateTimeForDb($model->periodehariakhir);
      //$model->periodeharikerjaakhir = MyFormatter::formatDateTimeForDb($model->periodeharikerjaakhir);
      if ($model->save()) {
        Yii::app()->user->setFlash('success', 'Data ' . $model->kelompokpegawai->kelompokpegawai_nama . ' berhasil disimpan.');
        $this->redirect(array('admin', 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan.");
      }
    }

    $this->render('update', array(
      'model' => $model,
    ));
  }

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('KPHariKerjaGolM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin($sukses = '')
  {
    $this->pageTitle = Yii::app()->name . " - Hari Kerja Pegawai";
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                                                 
    $model = new KPHariKerjaGolM('search');

    $model->unsetAttributes();  // clear any default values

    if (isset($_GET['KPHariKerjaGolM'])) {
      $model->attributes = $_GET['KPHariKerjaGolM'];
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
    $model = KPHariKerjaGolM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sagelar-belakang-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
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
      $this->loadModel($id)->delete();
      if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(array(
          'status' => 'proses_form',
          'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
        ));
        exit;
      }

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * Mengubah status aktif
   * @param type $id 
   */
  public function actionRemoveTemporary($id = null)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //                    SAPropinsiM::model()->updateByPk($id, array('propinsi_aktif'=>false));
    //                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));

    if (isset($_POST['id'])) {
      $id = $_POST['id'];
    }

    if (!empty($id)) {
      $update = KPHariKerjaGolM::model()->updateByPk($id, array('harikerjagol_aktif' => false));
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
    $model = new KPHariKerjaGolM;
    $model->attributes = $_REQUEST['KPHariKerjaGolM'];
    $judulLaporan = 'Data Hari Golongan Kerja';
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
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 45, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }
}
