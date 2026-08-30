<?php
class ImplementasikeperawatanMController extends MyAuthController
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
    $model = new ImplementasikeperawatanM;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['ImplementasikeperawatanM'])) {

      $valid = true;
      foreach ($_POST['ImplementasikeperawatanM'] as $i => $item) {
        if (is_integer($i)) {
          $model = new ImplementasikeperawatanM;
          if (isset($_POST['ImplementasikeperawatanM'][$i]))

            $model->attributes = $_POST['ImplementasikeperawatanM'][$i];
          //$model->lookup_id = $_POST['LookupM']['lookup_id'];
          //$model->diagnosakeperawatan_kode = $_POST['DiagnosakeperawatanM']['diagnosakeperawatan_kode'];
          $model->diagnosakeperawatan_id = $_POST['ImplementasikeperawatanM']['diagnosakeperawatan_id'];
          $valid = $model->validate() && $valid;
          echo $i;
          if ($valid) {
            $model->save();
            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          } else {
            Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data tidak valid.');
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
    $model = $this->loadModel($id);
    $modImplementasiKeperawatan = SAImplementasikeperawatanM::model()->findAllByAttributes(array('diagnosakeperawatan_id' => $model->diagnosakeperawatan_id));

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SAImplementasikeperawatanM'])) {
      //                        echo count((array)$_POST['SAImplementasikeperawatanM']);
      //                        exit();
      $valid = true;
      foreach ($_POST['SAImplementasikeperawatanM'] as $i => $item) {
        if (is_integer($i)) {
          if (!empty($_POST['SAImplementasikeperawatanM'][$i]['implementasikeperawatan_id'])) {
            $model = SAImplementasikeperawatanM::model()->findByPk($_POST['SAImplementasikeperawatanM'][$i]['implementasikeperawatan_id']);
            $model->implementasikeperawatan_id = $_POST['SAImplementasikeperawatanM'][$i]['implementasikeperawatan_id'];
          } else {
            $model = new SAImplementasikeperawatanM;
          }
          if (isset($_POST['SAImplementasikeperawatanM'][$i]))
            if ($_POST['SAImplementasikeperawatanM']['diagnosakeperawatan_id'] == 0) {
              $_POST['SAImplementasikeperawatanM']['diagnosakeperawatan_id'] = null;
            }
          $model->attributes = $_POST['SAImplementasikeperawatanM'][$i];

          if ((!empty($_POST['SAImplementasikeperawatanM']['diagnosakeperawatan_id'])) || (($_POST['SAImplementasikeperawatanM']['diagnosakeperawatan_id']) != 0)) {
            SAImplementasikeperawatanM::model()->deleteByPk($_POST['SAImplementasikeperawatanM']['diagnosakeperawatan_id']);
            $model->diagnosakeperawatan_id = $_POST['SAImplementasikeperawatanM']['diagnosakeperawatan_id'];
          }
          if (!empty($_POST['SAImplementasikeperawatanM'][$i]['rencanakeperawatan_id'])) {
            $model->rencanakeperawatan_id = $_POST['SAImplementasikeperawatanM'][$i]['rencanakeperawatan_id'];
          }


          //$model->lookup_id = $_POST['LookupM']['lookup_id'];
          $model->implementasikeperawatan_kode = $_POST['SAImplementasikeperawatanM'][$i]['implementasikeperawatan_kode'];
          // $model->lookup_aktif = true;
          $valid = $model->validate() && $valid;

          if ($valid) {

            $model->save();
            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          } else {
            Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data tidak valid.');
          }
        }
      }
      $this->redirect(array('admin'));
    }

    $this->render('update', array(
      'model' => $model,
      'modImplementasiKeperawatan' => $modImplementasiKeperawatan,
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
    $dataProvider = new CActiveDataProvider('SAImplementasikeperawatanM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,

    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new SAImplementasikeperawatanM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SAImplementasikeperawatanM']))
      $model->attributes = $_GET['SAImplementasikeperawatanM'];

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
    $model = SAImplementasikeperawatanM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'saimplementasikeperawatan-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   *Mengubah status aktif
   * @param type $id 
   */
  public function actionRemoveTemporary($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    SAImplementasikeperawatanM::model()->updateByPk($id, array('iskolaborasiimplementasi' => false));
    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function actionPrint()
  {

    $model = new ImplementasikeperawatanM;
    $model->attributes = $_REQUEST['ImplementasikeperawatanM'];
    $judulLaporan = 'Data Implementasi Keperawatan';
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
