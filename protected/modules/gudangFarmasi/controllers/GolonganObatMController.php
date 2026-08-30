<?php

class GolonganObatMController extends MyAuthController
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
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                                             
    $model = new LookupM;
    $model->lookup_type = 'obatalkes_golongan';
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['LookupM'])) {

      $valid = true;
      foreach ($_POST['LookupM'] as $i => $item) {
        if (is_integer($i)) {
          $model = new LookupM;
          if (isset($_POST['LookupM'][$i]))
            $model->attributes = $_POST['LookupM'][$i];
          //$model->lookup_id = $_POST['LookupM']['lookup_id'];
          $model->lookup_type = $_POST['LookupM']['lookup_type'];
          $model->lookup_aktif = true;
          $valid = $model->validate() && $valid;
          echo $i;
          if ($valid) {
            $model->save();
            Yii::app()->user->setFlash('success', 'Data ' . $model->lookup_name . ' berhasil disimpan');
          } else {
            Yii::app()->user->setFlash('error', 'Data gagal disimpan');
          }
        }
      }
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
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                                                        
    $model = LookupM::model()->findByPk($id);
    $model->lookup_type = "obatalkes_golongan";

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['LookupM'])) {
      $model->attributes = $_POST['LookupM'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', 'Data ' . $model->lookup_name . ' berhasil disimpan');
        $this->redirect(array('admin', 'id' => $model->lookup_id));
      } else {
        Yii::app()->user->setFlash('error', 'Data gagal disimpan');
      }

      //                          $valid=true;
      //                        foreach($_POST['ObatAlkesGolongan'] as $i=>$item)
      //                        {
      //                            if(is_integer($i)) {
      //                                $model=new LookupM;
      //                                if(isset($_POST['ObatAlkesGolongan'][$i]))
      //                                    if ($_POST['ObatAlkesGolongan'][$i]['lookup_id'] == 0){
      //                                        $_POST['ObatAlkesGolongan'][$i]['lookup_id'] = null;
      //                                    }
      //                                    $model->attributes=$_POST['ObatAlkesGolongan'][$i];
      //                                    if ((!empty($_POST['ObatAlkesGolongan'][$i]['lookup_id']))||(($_POST['ObatAlkesGolongan'][$i]['lookup_id']) != 0)){
      //                                        LookupM::model()->deleteByPk($_POST['ObatAlkesGolongan'][$i]['lookup_id']);
      //                                        $model->lookup_id = $_POST['ObatAlkesGolongan'][$i]['lookup_id'];
      //                                    }
      //                                    
      //                                    //$model->lookup_id = $_POST['LookupM']['lookup_id'];
      //                                    $model->lookup_type = $_POST['ObatAlkesGolongan']['lookup_type'];
      //                                    $model->lookup_aktif = true;
      //                                    $valid=$model->validate() && $valid;
      //                                    echo $i;
      //                                if($valid) {
      //                                    $model->save();
      //                                        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
      //                                } else {
      //                                        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data tidak valid.');
      //                                }
      //                            }
      //                        }
      //                        $this->redirect(array('admin'));
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
    // $model->lookup_type = ObatAlkesGolongan::namaType();
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
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
    $dataProvider = new CActiveDataProvider('LookupM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $model = new ObatAlkesGolongan('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['ObatAlkesGolongan']))
      $model->attributes = $_GET['ObatAlkesGolongan'];

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
    $model = LookupM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'kategoriobat-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   * Mengubah status aktif
   * @param type $id 
   */
  public function actionRemoveTemporary($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    LookupM::model()->updateByPk($id, array('lookup_aktif' => false));
    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function actionPrint()
  {
    $model = new ObatAlkesGolongan;
    $model->attributes = $_REQUEST['ObatAlkesGolongan'];
    $judulLaporan = 'Data Lookup';
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
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 45, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
