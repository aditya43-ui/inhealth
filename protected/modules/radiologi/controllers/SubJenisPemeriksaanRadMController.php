<?php

class SubJenisPemeriksaanRadMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public $defaultAction = 'admin';
  public $path_view = 'radiologi.views.subJenisPemeriksaanRadM.';

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
    $model = new SubjenisPemeriksaanradM;

    if (isset($_POST['SubjenisPemeriksaanradM'])) {
      $ok = true;
      $trans = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['SubjenisPemeriksaanradM'];
        $ok = $ok && $model->save();

        if ($ok) {
            $trans->commit();
            Yii::app()->user->setFlash('success', "Data Pemeriksaan " . $model->subjenis_pemeriksaanrad_nama . " berhasil disimpan");
            $this->redirect(array('admin', 'id' => $model->subjenis_pemeriksaanrad_id, 'sukses' => 1));
          } else {
            Yii::app()->user->setFlash('error', ' Data gagal disimpan');
            $trans->rollback();
          }

      } catch (Exception $e) {
        echo $e->getMessage();die;
        Yii::app()->user->setFlash('error', ' Data gagal disimpan');
        $trans->rollback();
      }
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model
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

    if (isset($_POST['SubjenisPemeriksaanradM'])) {
      $ok = true;
      $trans = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['SubjenisPemeriksaanradM'];
        $ok = $ok && $model->save();

        if ($ok) {
            $trans->commit();
            Yii::app()->user->setFlash('success', "Data Pemeriksaan " . $model->subjenis_pemeriksaanrad_nama . " berhasil disimpan");
            $this->redirect(array('admin', 'id' => $model->subjenis_pemeriksaanrad_id, 'sukses' => 1));
          } else {
            Yii::app()->user->setFlash('error', ' Data gagal disimpan');
            $trans->rollback();
          }

      } catch (Exception $e) {
        //echo $e->getMessage();die;
        Yii::app()->user->setFlash('error', ' Data gagal disimpan');
        $trans->rollback();
      }
    }

    $this->render($this->path_view . 'update', array(
      'model' => $model,
    ));
  }

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('SubjenisPemeriksaanradM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

    /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $this->pageTitle = Yii::app()->name . " - Pemeriksaan Radiologi";
    $model = new SubjenisPemeriksaanradM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SubjenisPemeriksaanradM'])) {
      $model->attributes = $_GET['SubjenisPemeriksaanradM'];
    }
    $this->render($this->path_view . 'admin', array(
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
    $model = SubjenisPemeriksaanradM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sapemeriksaan-rad-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionDelete($id)
  {
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      $this->loadModel($id)->delete();

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * Memanggil dan menonaktifkan status
   */
  public function actionNonActive($id)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['sukses'] = 0;
      $model = $this->loadModel($id);
      // set non-active this
      // example:
      if (isset($_GET['add'])) :
        $model->subjenis_aktif = 1;
      else :
        $model->subjenis_aktif = 0;
      endif;

      if ($model->save()) {
        $data['sukses'] = 1;
      }
      echo CJSON::encode($data);
    }
  }

  public function actionPrint()
  {
    $model = new SubjenisPemeriksaanradM;
    if (isset($_REQUEST['SubjenisPemeriksaanradM'])) {
      $model->attributes = $_REQUEST['SubjenisPemeriksaanradM'];
    }
    $judulLaporan = 'Data Pemeriksaan Radiologi';
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
      ////$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 45, 30, 15, 15);

      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }
}
