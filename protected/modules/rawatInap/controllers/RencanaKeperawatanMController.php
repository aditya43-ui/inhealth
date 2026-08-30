<?php
class RencanaKeperawatanMController extends MyAuthController
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
    $model = new RencanakeperawatanM;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['RencanakeperawatanM'])) {
      $valid = true;
      $jmlhsave = 0;
      foreach ($_POST['RencanakeperawatanM'] as $data => $item) {
        $model = new RencanakeperawatanM;
        $model->attributes = $item;
        //$model->lookup_id = $_POST['LookupM']['lookup_id'];
        //                                                    $model->diagnosakeperawatan_kode = $_POST['DiagnosakeperawatanM']['diagnosakeperawatan_kode'];
        $model->diagnosakeperawatan_id = $_POST['diagnosakeperawatan_id'];
        if ($model->save()) {
          $jmlhsave++;
        }
      }
      if ($jmlhsave == count((array)$_POST['RencanakeperawatanM'])) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil</strong> Data berhasil disimpan');
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
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = $this->loadModel($id);
    $modRencanaKeperawatan = RencanaKeperawatanM::model()->findAllByAttributes(array('diagnosakeperawatan_id' => $model->diagnosakeperawatan_id));
    $modDiagnosakeperawatan = RIDiagnosakeperawatanM::model()->findByPk($model->diagnosakeperawatan_id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['RIRencanakeperawatanM'])) {
      // echo '<pre>'; print_r($_POST['RIRencanakeperawatanM']);
      // exit();
      $valid = true;
      foreach ($_POST['RencanakeperawatanM'] as $i => $item) {
        if (is_integer($i)) {

          if (!empty($_POST['RencanakeperawatanM'][$i]['rencanakeperawatan_id'])) {
            $model = RencanakeperawatanM::model()->findByPk($_POST['RencanakeperawatanM'][$i]['rencanakeperawatan_id']);
            //                                        $model->diagnosakeperawatan_id = $_POST['SARencanakeperawatanM'][$i]['diagnosakeperawatan_id'];
          } else {
            $model = new RencanakeperawatanM;
          }
          //                                if(isset($_POST['SARencanakeperawatanM'][$i]))
          //                                    if ($_POST['SARencanakeperawatanM']['diagnosakeperawatan_id'] == 0){
          //                                        $_POST['SARencanakeperawatanM']['diagnosakeperawatan_id'] = null;
          //                                    }
          //                                    $model->attributes=$_POST['RIRencanakeperawatanM'][$i];
          //                                    if ((!empty($_POST['RIRencanakeperawatanM']['diagnosakeperawatan_id']))||(($_POST['RIRencanakeperawatanM']['diagnosakeperawatan_id']) != 0)){
          //                                        RencanakeperawatanM::model()->deleteByPk($_POST['RIRencanakeperawatanM'][$i]['diagnosakeperawatan_id']);

          if (isset($_POST['RencanakeperawatanM'][$i]))
            // if ($_POST['RIRencanakeperawatanM']['diagnosakeperawatan_id'] == 0){
            //     $_POST['RIRencanakeperawatanM']['diagnosakeperawatan_id'] = null;
            // }
            if (empty($_POST['RencanakeperawatanM'][$i]['rencanakeperawatan_id'])) {
              $model = new RencanakeperawatanM;
              $model->attributes = $_POST['RencanakeperawatanM'][$i];
            } else {
              //                                        echo 'b';
              $model = RencanakeperawatanM::model()->findByPk($_POST['RencanakeperawatanM'][$i]['rencanakeperawatan_id']);
              $model->attributes = $_POST['RencanakeperawatanM'][$i];
            }

          if (!empty($model->diagnosakeperawatan_id)) {
            RencanakeperawatanM::model()->deleteByPk($model->diagnosakeperawatan_id);

            $model->diagnosakeperawatan_id = $model->diagnosakeperawatan_id;
          }
          if (!empty($_POST['rencanakeperawatan_id'][$i]['rencanakeperawatan_id'])) {
            $model->rencanakeperawatan_id = $_POST['rencanakeperawatan_id'][$i]['rencanakeperawatan_id'];
          }
          //$model->lookup_id = $_POST['LookupM']['lookup_id'];
          $model->rencana_kode = $_POST['RencanakeperawatanM'][$i]['rencana_kode'];
          // $model->lookup_aktif = true;
          //                                    echo '<pre>';
          //                                    echo print_r($_POST['RIRencanakeperawatanM'][$i]);
          //                                    echo '<pre>';
          $valid = $model->validate() && $valid;
          echo $i;
          if ($valid) {
            $model->save();
            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          } else {
            Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data tidak valid.');
          }
        } else {
          Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data tidak valid.');
        }
      }
      $this->redirect(array('admin'));
    }

    $this->render('update', array(
      'model' => $model,
      'modRencanaKeperawatan' => $modRencanaKeperawatan,
      'modDiagnosakeperawatan' => $modDiagnosakeperawatan,
    ));
  }

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('RIRencanakeperawatanM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new RIRencanaKeperawatanM('searchData');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['RIRencanakeperawatanM']))
      $model->attributes = $_GET['RIRencanakeperawatanM'];

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
    $model = RIRencanakeperawatanM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sarencana-keperawatan-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionDelete()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    if (Yii::app()->request->isPostRequest) {
      $id = $_POST['id'];
      $implementasiKeperawatan = ImplementasikeperawatanM::model()->findByAttributes(array('rencanakeperawatan_id' => $id));
      if ($implementasiKeperawatan) {
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
          exit();
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
      $update = RencanakeperawatanM::model()->updateByPk($id, array('iskolaborasiintervensi' => false));
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

    $model = new RencanakeperawatanM;
    $model->attributes = $_REQUEST['RencanakeperawatanM'];
    $judulLaporan = 'Laporan Rencana Keperawatan';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {

      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                            //Posisi L->Landscape,P->Portait
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
