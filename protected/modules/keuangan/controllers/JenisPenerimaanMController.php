<?php

class JenisPenerimaanMController extends MyAuthController
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
    $model = new KUJenispenerimaanM;
    $model->jenispenerimaan_aktif = true;
    $model->persenpph_22 = $model->persenpph_23 = 0;
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['KUJenispenerimaanM'])) {
      $model->attributes = $_POST['KUJenispenerimaanM'];

      if (empty($model->persenpph_22)) {
        $model->persenpph_22 = 0;
      }
      if (empty($model->persenpph_23)) {
        $model->persenpph_23 = 0;
      }

      $model->persenpph_22 = MyFormatter::formatRupiahForDB($model->persenpph_22);
      $model->persenpph_23 = MyFormatter::formatRupiahForDB($model->persenpph_23);
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('admin', 'sukses' => 1));
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
    $model = $this->loadModel($id);

    $model->persenpph_22 = str_replace(".", ",", $model->persenpph_22);
    $model->persenpph_23 = str_replace(".", ",", $model->persenpph_23);

    if (isset($_POST['KUJenispenerimaanM'])) {
      $model->attributes = $_POST['KUJenispenerimaanM'];

      if (empty($model->persenpph_22)) {
        $model->persenpph_22 = 0;
      }
      if (empty($model->persenpph_23)) {
        $model->persenpph_23 = 0;
      }

      $model->persenpph_22 = MyFormatter::formatRupiahForDB($model->persenpph_22);
      $model->persenpph_23 = MyFormatter::formatRupiahForDB($model->persenpph_23);

      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('admin', 'sukses' => 1));
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
    $dataProvider = new CActiveDataProvider('KUJenispenerimaanM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin($sukses = '')
  {
    if ($sukses == 1) :
      Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
    endif;

    $model = new KUJenispenerimaanM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['KUJenispenerimaanM']))
      $model->attributes = $_GET['KUJenispenerimaanM'];

    $this->pageTitle = Yii::app()->name . " - Penerimaan Umum";
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
    $model = KUJenispenerimaanM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sajenis-kelas-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  public function actionDelete()
  {
    if (Yii::app()->request->isPostRequest) {
      $id = $_POST['id'];
      $modPenerimaanUmum = PenerimaanumumT::model()->findAllByAttributes(array('jenispenerimaan_id' => $id));
      if ($modPenerimaanUmum) {
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'warning' => true,
            'pesan' => "Data ini sedang digunakan di table : penerimaanumum_t",
          ));
          exit;
        }
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
      $update = KUJenispenerimaanM::model()->updateByPk($id, array('jenispenerimaan_aktif' => false));
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

    $model = new KUJenispenerimaanM;
    $model->attributes = $_REQUEST['KUJenispenerimaanM'];
    $judulLaporan = 'Jenis Penerimaan Umum';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = 'A4'; //Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = 'L'; //Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }
}
