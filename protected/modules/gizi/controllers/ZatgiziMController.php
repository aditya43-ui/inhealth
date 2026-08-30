<?php

class ZatgiziMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $this->layout = '//layouts/iframe';
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
    $this->layout = '//layouts/iframe';
    $model = new ZatgiziM;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['ZatgiziM'])) {
      $model->attributes = $_POST['ZatgiziM'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', 'Data ' . $model->zatgizi_nama . ' berhasil disimpan.');
        $this->redirect(array('admin', 'tab' => 'frame'));
      } else {
        Yii::app()->user->setFlash("error", "Data Gagal Disimpan");
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
    $this->layout = '//layouts/iframe';
    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['ZatgiziM'])) {
      $model->attributes = $_POST['ZatgiziM'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', 'Data ' . $model->zatgizi_nama . ' berhasil disimpan.');
        $this->redirect(array('admin', 'tab' => 'frame'));
      } else {
        Yii::app()->user->setFlash("error", "Data Gagal Disimpan");
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
    $this->pageTitle = Yii::app()->name . " - Jenis Diet";
    $dataProvider = new CActiveDataProvider('ZatgiziM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    if (!isset($_GET['tab'])) :
      //$this->layout = '//layouts/column1';    
      $this->redirect($this->createUrl('/gizi/ZatgiziM&modul_id', array('modul_id' => Yii::app()->session['modul_id'])));
    else :
      $this->layout = '//layouts/iframe';
    endif;

    $model = new ZatgiziM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['ZatgiziM']))
      $model->attributes = $_GET['ZatgiziM'];

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
    $model = ZatgiziM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'zatgizi-m-form') {
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
      $diet = DietM::model()->findByAttributes(array('zatgizi_id' => $id));
      $zatmenudiet = ZatMenuDietM::model()->findByAttributes(array('zatgizi_id' => $id));
      if ($diet || $zatmenudiet) {
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
      $update = GZZatgiziM::model()->updateByPk($id, array('zatgizi_aktif' => false));
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
   *Mengubah status aktif
   * @param type $id 
   */
  public function actionPrint()
  {

    $model = new ZatgiziM;
    $model->attributes = $_REQUEST['ZatgiziM'];
    if (isset($_GET['ZatgiziM']))
      $model->attributes = $_GET['ZatgiziM'];
    $judulLaporan = 'Data Zat Gizi';
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
      $mpdf->Output($judulLaporan . '-' . date('Y/m/d') . '.pdf', 'I');
    }
  }
}
