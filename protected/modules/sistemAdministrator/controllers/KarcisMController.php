<?php

class KarcisMController extends MyAuthController
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
    $model = new KarcisM;
    $modlook = new SALookupM;
    $model->statuspasien = 1;


    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['KarcisM'])) {
      //$transaction = Yii::app()->db->beginTransaction();

      $model->attributes = $_POST['KarcisM'];
      $model->daftartindakan_id = $_POST['KarcisM']['daftartindakan_id'];
      $model->ruangan_id = $_POST['KarcisM']['ruangan_id'];
      $model->karcis_nama = $_POST['KarcisM']['karcis_nama'];
      $model->karcis_namalainnya = $_POST['KarcisM']['karcis_namalainnya'];
      $model->statuspasien = $_POST['KarcisM']['StatusPasien'];
      if ($_POST['KarcisM']['StatusPasien'] == 'PENGUNJUNG BARU') {
        $model->pasienbaru_karcis = TRUE;
      } else {
        $model->pasienbaru_karcis = FALSE;
      }
      //                        echo "<pre>";
      //                        print_r($model->attributes);
      //                        exit;

      if ($model->save()) {
        Yii::app()->user->setFlash('success', "Data " . $model->karcis_nama . " berhasil disimpan");
        $this->redirect(array('admin', 'id' => $model->karcis_id));
      } else {
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
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
 
    
 
     if (isset($_POST['KarcisM'])) {
       $model->attributes = $_POST['KarcisM'];
       $model->asalrujukan_id = $_POST['KarcisM']['asalrujukan_id'];
       $model->ruangan_id = $_POST['KarcisM']['ruangan_id'];
       $model->daftartindakan_id = $_POST['KarcisM']['daftartindakan_id'];
       
      // $model->jenistarif_id = $_POST['KarcisM']['jenistarif_id'];
     //  $model->daftartindakan_nama = $_POST['KarcisM']['daftartindakan_nama'];
 
       //var_dump ($model); die;
       if ($model->save()) {
         Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data ' . $model->karcis_nama . ' berhasil disimpan.');
 
         $this->redirect(array('admin', 'sukses' => 1));
       } else {
         Yii::app()->user->setFlash('error', 'Data Gagal Disimpan');
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
    $dataProvider = new CActiveDataProvider('KarcisM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $this->pageTitle = Yii::app()->name . " - Karcis";
    $model = new KarcisM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['KarcisM']))
      $model->attributes = $_GET['KarcisM'];

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
    $model = KarcisM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sakarcis-m-form') {
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
    if (Yii::app()->request->isAjaxRequest) {
      $data['sukses'] = 0;
      $model = $this->loadModel($id);
      $model->karcis_aktif = false;
      if ($model->save()) {
        $data['sukses'] = 1;
      }
      echo CJSON::encode($data);
    }
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //                KarcisM::model()->updateByPk($id, array('karcis_aktif'=>false));
    //                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function actionPrint()
  {
    $model = new KarcisM;
    $model->attributes = $_REQUEST['KarcisM'];
    $judulLaporan = 'Data Karcis';
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
      $mpdf->Output();
    }
  }
}
