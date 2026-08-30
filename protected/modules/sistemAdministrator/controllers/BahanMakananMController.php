<?php

class BahanMakananMController extends MyAuthController
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
    $model = new BahanmakananM;
    $models = new ZatBahanMakananM;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['BahanmakananM'])) {
      $model->attributes = $_POST['BahanmakananM'];
      $model->save();
      if (isset($_POST['zatgizi_id'])) {
        for ($i = 0; $i < count((array)$_POST['zatgizi_id']); $i++) {
          $models = new ZatBahanMakananM;
          $idZatgizi = $_POST['zatgizi_id'][$i];
          // $Kandunganbahan = $_POST['kandunganbahan'][$idZatgizi];
          $models->zatgizi_id = $_POST['zatgizi_id'][$i];
          $models->bahanmakanan_id = $model->bahanmakanan_id;
          $models->kandunganbahan = $_POST['kandunganbahan'][$idZatgizi];
          if ($models->validate())
            $models->save();
        }
      }
      Yii::app()->user->setFlash('success', '<strong>Berhasil!!</strong> Data berhasil disimpan.');
      $this->redirect(array('admin'));
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
    $model = BahanmakananM::model()->findByPK($id);
    $zatgizi = array();
    $modZatBahanMakananM = ZatBahanMakananM::model()->findAllByAttributes(array('bahanmakanan_id' => $model->bahanmakanan_id));
    foreach ($modZatBahanMakananM as $i => $zat) {
      $zatgizi[$zat->zatgizi_id] = $zat->kandunganbahan;
      $models = ZatBahanMakananM::model()->findByPK($zatgizi[$zat->zatbahanmakan_id]);
    }

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['BahanmakananM'])) {
      $model->attributes = $_POST['BahanmakananM'];
      $model->save();
      if (isset($_POST['zatbahanmakan_id'])) {

        for ($i = 0; $i < count((array)$_POST['zatbahanmakan_id']); $i++) {
          $models =  ZatBahanMakananM::model()->findByPK($_POST['zatbahanmakan_id'][$i]);
          $idZatgizi = $_POST['zatbahanmakan_id'][$i];
          // $Kandunganbahan = $_POST['kandunganbahan'][$idZatgizi];
          $models->kandunganbahan = $_POST['kandunganbahan'][$idZatgizi];
          $models->save();
        }
      }
      if ($model->save())
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
      $this->redirect(array('admin', 'id' => $model->bahanmakanan_id));
    }

    $this->render('update', array(
      'model' => $model,
      'modZatBahanMakananM' => $modZatBahanMakananM,
      'zatgizi' => $zatgizi,
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
    $dataProvider = new CActiveDataProvider('BahanmakananM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $model = new BahanmakananM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['BahanmakananM']))
      $model->attributes = $_GET['BahanmakananM'];

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
    $model = BahanmakananM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'bahan-makanan-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionPrint()
  {

    $model = new BahanmakananM('searchPrint');
    $model->unsetAttributes();  // clear any default values
    $judulLaporan = 'Data Bahan Makanan';
    if (isset($_GET['BahanmakananM']))
      $model->attributes = $_GET['BahanmakananM'];
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
