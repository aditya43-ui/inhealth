<?php

class DietMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
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
    $model = new DietM;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['DietM'])) {
      if (isset($_POST['zatgizi_id'])) {
        for ($i = 0; $i < count((array)$_POST['zatgizi_id']); $i++) {
          $model = new DietM;
          $idZatgizi = $_POST['zatgizi_id'][$i];
          // $dietKandungan = $_POST['diet_kandungan'][$idZatgizi];
          if (isset($_POST['DietM']['diet_id'])) {
            $model->diet_id = $_POST['DietM']['diet_id'];
          }
          $model->tipediet_id = $_POST['DietM']['tipediet_id'];
          $model->jenisdiet_id = $_POST['DietM']['jenisdiet_id'];
          $model->zatgizi_id = $_POST['zatgizi_id'][$i];

          $model->diet_kandungan = str_replace(",", ".", $_POST['diet_kandungan'][$idZatgizi]);
          // var_dump($model);die;
          if ($model->save()) {
            Yii::app()->user->setFlash('success', 'Data berhasil disimpan.');
          } else {
            Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
          }
        }
        if ($model->validate()) {
          Yii::app()->user->setFlash('success', 'Data berhasil disimpan.');
        } else {
          Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
        }
        $this->redirect(array('admin'));
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
    $model->diet_kandungan = str_replace('.', ',', $model->diet_kandungan);
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['DietM'])) {
      $model->attributes = $_POST['DietM'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', 'Data ' . $model->tipediet->tipediet_nama . ' berhasil disimpan.');
        $this->redirect(array('admin'));
      } else {
        Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
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
    $dataProvider = new CActiveDataProvider('DietM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $model = new DietM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['DietM']))
      $model->attributes = $_GET['DietM'];

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
    $model = DietM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'diet-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  public function actionPrint()
  {

    $model = new GZDietM;
    $model->attributes = $_REQUEST['DietM'];
    $model->attributes = $_REQUEST['DietM'];
    $model->attributes = $_REQUEST['DietM'];
    if (isset($_GET['DietM']))
      $model->attributes = $_GET['DietM'];
    $judulLaporan = 'Data Diet';
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
