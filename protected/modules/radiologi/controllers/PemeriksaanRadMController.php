<?php

class PemeriksaanRadMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public $defaultAction = 'admin';
  public $path_view = 'radiologi.views.pemeriksaanRadM.';

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
    $model = new ROPemeriksaanRadM;
    $modReferensiHasil = new ROReferensiHasilRadM;
    $modRefDet = new ROReferensihasildetM;

    if (isset($_POST['ROPemeriksaanRadM'])) {
      $ok = true;
      $trans = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['ROPemeriksaanRadM'];
        $model->daftartindakan_id = $_POST['daftartindakan_id'];
        $model->is_adareferensihasil = $_POST['ROPemeriksaanRadM']['is_adareferensihasil'];
        $validModel = $model->validate();
        if (isset($_POST['ROReferensiHasilRadM']) && $model->is_adareferensihasil == 1) {
          $modReferensiHasil->attributes = $_POST['ROReferensiHasilRadM'];
          $validReferensi = $modReferensiHasil->validate();
        } else {
          $validReferensi = false;
        }
        if ($validModel) {
          $ok = $ok && $model->save();
          if ($validReferensi == true) {
            $modReferensiHasil->pemeriksaanrad_id = $model->pemeriksaanrad_id;
            $modReferensiHasil->save();
            $ok = $ok && $modReferensiHasil->save();

            if ($ok) {
              if ($modReferensiHasil->refhasilrad_banyak == true) {
                if (isset($_POST['ROReferensihasildetM'])) {
                  foreach ($_POST['ROReferensihasildetM'] as $key => $val) {
                    if ($_POST['ROReferensihasildetM'][$key]['refhasildet_aktif'] == true) {
                      $modRefDet = new ROReferensihasildetM;
                      $modRefDet->attributes = $_POST['ROReferensihasildetM'][$key];
                      $modRefDet->refhasilrad_id = $modReferensiHasil->refhasilrad_id;
                      $ok = $ok && $modRefDet->save();
                    }
                    // var_dump($modRefDet->getErrors());
                  }
                  //die;
                }
              }
            }
          }

          // var_dump($ok, $modReferensiHasil->attributes, $modReferensiHasil->errors); die;



          if ($ok) {
            $trans->commit();
            Yii::app()->user->setFlash('success', "Data Pemeriksaan " . $model->pemeriksaanrad_nama . " berhasil disimpan");
            $this->redirect(array('admin', 'id' => $model->pemeriksaanrad_id, 'sukses' => 1));
          } else {
            Yii::app()->user->setFlash('error', 'Data gagal disimpan');
            $trans->rollback();
          }
        }
      } catch (Exception $e) {
        echo $e->getMessage();die;
        Yii::app()->user->setFlash('error', 'Data gagal disimpan. '.$e->getMessage());
        $trans->rollback();
      }
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model,
      'modReferensiHasil' => $modReferensiHasil,
      'modRefDet' => $modRefDet
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
    $modRefDet = new ROReferensihasildetM;

    $modReferensiHasil = ROReferensiHasilRadM::model()->findByAttributes(array('pemeriksaanrad_id' => $model->pemeriksaanrad_id, 'refhasilrad_aktif' => true));
    if (!empty($modReferensiHasil)) {
      $modReferensiHasil->pemeriksaanrad_id = $modReferensiHasil->pemeriksaanrad_id;
      $modReferensiHasil->refhasilrad_kode = $modReferensiHasil->refhasilrad_kode;
      $model->is_adareferensihasil = 1;
    } else {
      $modReferensiHasil = new ROReferensiHasilRadM;
    }

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['ROPemeriksaanRadM'])) {
      $ok = true;
      $trans = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['ROPemeriksaanRadM'];
        $model->is_adareferensihasil = $_POST['ROPemeriksaanRadM']['is_adareferensihasil'];

        //$validModel = $model->validate();
        $ok = $ok && $model->save();
        if ($ok) {

          //var_dump($model->is_adareferensihasil); die;

          if ($model->is_adareferensihasil == 1) {

            $modReferensiHasil = null;
            if (isset($_POST['ROReferensiHasilRadM']['refhasilrad_id'])) {
              $modReferensiHasil = ROReferensiHasilRadM::model()->findByPk($_POST['ROReferensiHasilRadM']['refhasilrad_id']);
            }
            if (empty($modReferensiHasil)) {
              $modReferensiHasil = new ROReferensiHasilRadM;
            }
            $modReferensiHasil->attributes = $_POST['ROReferensiHasilRadM'];
            $modReferensiHasil->pemeriksaanrad_id = $model->pemeriksaanrad_id;

            $ok = $ok && $modReferensiHasil->save();
            // var_dump($modReferensiHasil->attributes, $modReferensiHasil->errors); die;
            //var_dump($modReferensiHasil->save());die;
            if ($ok) {

              if ($modReferensiHasil->refhasilrad_banyak == true) {
                if (isset($_POST['ROReferensihasildetM'])) {
                  foreach ($_POST['ROReferensihasildetM'] as $key => $val) {
                    if (empty($_POST['ROReferensihasildetM'][$key]['refhasildet_id'])) {
                      $modRefDet = new ROReferensihasildetM;
                      $modRefDet->attributes = $_POST['ROReferensihasildetM'][$key];
                      $modRefDet->refhasilrad_id = $modReferensiHasil->refhasilrad_id;

                      $ok = $ok && $modRefDet->save();
                    } else {

                      $modRefDet = ROReferensihasildetM::model()->findByPk($_POST['ROReferensihasildetM'][$key]['refhasildet_id']);
                      $modRefDet->attributes = $_POST['ROReferensihasildetM'][$key];
                      $modRefDet->refhasilrad_id = $modReferensiHasil->refhasilrad_id;

                      $ok = $ok && $modRefDet->save();
                    }
                    //var_dump($modRefDet->getErrors());
                  }
                  //die;
                }
              }
            }
          }
          //die;
          if ($ok) {
            $trans->commit();
            Yii::app()->user->setFlash('success', "Data Pemeriksaan " . $model->pemeriksaanrad_nama . " berhasil disimpan");
            $this->redirect(array('admin', 'id' => $model->pemeriksaanrad_id, 'sukses' => 1));
          } else {
            Yii::app()->user->setFlash('error', ' Data gagal disimpan');
            $trans->rollback();
          }
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
      'modReferensiHasil' => $modReferensiHasil,
      'modRefDet' => $modRefDet
    ));
  }

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('ROPemeriksaanRadM');
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
    $model = new ROPemeriksaanRadM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['ROPemeriksaanRadM'])) {
      $model->attributes = $_GET['ROPemeriksaanRadM'];
      $model->jenispemeriksaanrad_nama = isset($_GET['ROPemeriksaanRadM']['jenispemeriksaanrad_nama']) ? $_GET['ROPemeriksaanRadM']['jenispemeriksaanrad_nama'] : null;
      $model->daftartindakan_nama = isset($_GET['ROPemeriksaanRadM']['daftartindakan_nama']) ? $_GET['ROPemeriksaanRadM']['daftartindakan_nama'] : null;
      $model->subjenis_pemeriksaanrad_id = isset($_GET['ROPemeriksaanRadM']['subjenis_pemeriksaanrad_id']) ? $_GET['ROPemeriksaanRadM']['subjenis_pemeriksaanrad_id'] : null;
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
    $model = ROPemeriksaanRadM::model()->findByPk($id);
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
        $model->pemeriksaanrad_aktif = 1;
      else :
        $model->pemeriksaanrad_aktif = 0;
      endif;

      if ($model->save()) {
        $data['sukses'] = 1;
      }
      echo CJSON::encode($data);
    }
  }

  public function actionPrint()
  {
    $model = new ROPemeriksaanRadM;
    if (isset($_REQUEST['ROPemeriksaanRadM'])) {
      $model->attributes = $_REQUEST['ROPemeriksaanRadM'];
      $model->subjenis_pemeriksaanrad_id = isset($_GET['ROPemeriksaanRadM']['subjenis_pemeriksaanrad_id']) ? $_GET['ROPemeriksaanRadM']['subjenis_pemeriksaanrad_id'] : null;
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
