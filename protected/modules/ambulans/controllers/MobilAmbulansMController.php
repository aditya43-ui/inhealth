<?php

class MobilAmbulansMController extends MyAuthController
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
    $model = new MobilambulansM;
    $model->mobilambulans_kode = MyGenerator::kodeMobilAmbulans();
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['MobilambulansM'])) {
      $model->attributes = $_POST['MobilambulansM'];
      if (empty($_POST['MobilambulansM']['kmterakhirkend'])) {
        $model->kmterakhirkend = 0;
      }
      //                        echo "<pre>";
      //                        print_r($model->attributes);
      //                        exit;
      if ($model->save()) {
        $model->isNewRecord = FALSE;
        Yii::app()->user->setFlash('success', "Data Ambulan nomor " . $model->mobilambulans_kode . " Berhasil Disimpan");
        $this->redirect(array('admin', 'id' => $model->mobilambulans_id));
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
    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['MobilambulansM'])) {
      $model->attributes = $_POST['MobilambulansM'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', "Data Ambulan nomor " . $model->mobilambulans_kode . " Berhasil Disimpan");
        $this->redirect(array('admin', 'id' => $model->mobilambulans_id));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan.");
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
    $dataProvider = new CActiveDataProvider('MobilambulansM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $model = new MobilambulansM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['MobilambulansM'])) {
      $model->attributes = $_GET['MobilambulansM'];
    }
    $this->pageTitle = Yii::app()->name . " - Mobil Ambulans";
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
    $model = MobilambulansM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'mobil-ambulans-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionPrint()
  {

    $model = new MobilambulansM;
    $model->attributes = $_REQUEST['MobilambulansM'];
    if (isset($_GET['MobilambulansM']))
      $model->attributes = $_GET['MobilambulansM'];
    $judulLaporan = 'Data Mobil Ambulans';
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
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionRemoveTemporary($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    MobilambulansM::model()->updateByPk($id, array('mobilambulans_aktif' => false));
    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function actionAutocompleteBarang()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $barang_nama = isset($_GET['term']) ? $_GET['term'] : null;
      $criteria = new CDbCriteria();
      $criteria->addCondition('subsubkelompok_id = 475');
      $criteria->compare('LOWER(barang_nama)', strtolower($barang_nama), true);
      $criteria->limit = 5;
      $models = AMBarangM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->barang_nama;
        $returnVal[$i]['value'] = $model->barang_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
