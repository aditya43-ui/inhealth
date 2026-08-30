<?php

class KenaikanpangkatTController extends MyAuthController
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
    $model = new KPKenaikanpangkatT;
    $modPegawai = new KPPegawaiM;
    $modRealisasi = new RealisasikenpangkatR;
    $modUsulan = new UskenpangkatR;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['KPKenaikanpangkatT'])) {
      $model->attributes = $_POST['KPKenaikanpangkatT'];
      $modUsulan->attributes = $_POST['UskenpangkatR'];
      $modRealisasi = $_POST['RealisasikenpangkatR'];

      //                        echo"<pre>";
      //                        echo print_r($model->attributes);
      //                        echo print_r($modUsulan->attributes);
      //                        echo print_r($modPegawai->attributes);
      //                        echo print_r($modRealisasi->attributes);
      //                        exit();
      //                        $model->jabatan = JabatanM::model()->findByPk($model->jabatan->jabatan_nama);
      //                        $model->jabatan = JabatanM::model()->findByPk($model->jabatan->jabatan_nama);
      if ($model->save()) {
        $modUsulan = new UskenpangkatR;
        $modUsulan->kenaikanpangkat_id = $model->kenaikanpangkat_id;
        $modUsulan->uskenpangkat_masakerjatahun = $_POST['UskenpangkatR']['uskenpangkat_masakerjatahun'];
        $modUsulan->uskenpangkat_masakerjabulan = $_POST['UskenpangkatR']['uskenpangkat_masakerjabulan'];
        $modUsulan->uskenpangkat_gajipokok = $_POST['UskenpangkatR']['uskenpangkat_gajipokok'];
        $modUsulan->uskenpangkat_nosk = $_POST['UskenpangkatR']['uskenpangkat_nosk'];
        $modUsulan->uskenpangkat_tglsk = $_POST['UskenpangkatR']['uskenpangkat_tglsk'];
        if ($modUsulan->save()) {
          $model->uskenpangkat_id = $modUsulan->uskenpangkat_id;
          if ($model->save()) {
            $modPegawai = PegawaiM::model()->findByPk($model->pegawai_id);
            $modPegawai->jabatan_id = $model->jabatan;
            $modPegawai->pangkat_id = $model->pangkat;
            if ($modPegawai->save()) {
              $modRealisasi = new RealisasikenpangkatR;
              $modRealisasi->kenaikanpangkat_id = $model->kenaikanpangkat_id;
              if ($modRealisasi->save()) {
                $model->realisasikenpangkat_id = $modRealisasi->realisasikenpangkat_id;
                $model->save();
              }
            }
          }
        }

        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('create', 'id' => $model->kenaikanpangkat_id));
      }
    }

    $this->render('create', array(
      'model' => $model, 'modPegawai' => $modPegawai, 'modUsulan' => $modUsulan, 'modRealisasi' => $modRealisasi
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


    if (isset($_POST['KPKenaikanpangkatT'])) {
      $model->attributes = $_POST['KPKenaikanpangkatT'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->kenaikanpangkat_id));
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
    $dataProvider = new CActiveDataProvider('KPKenaikanpangkatT');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new KPKenaikanpangkatT('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['KPKenaikanpangkatT']))
      $model->attributes = $_GET['KPKenaikanpangkatT'];

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
    $model = KPKenaikanpangkatT::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'kpkenaikanpangkat-t-form') {
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
    //SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
    //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function actionPrint()
  {
    $model = new KPKenaikanpangkatT;
    $model->attributes = $_REQUEST['KPKenaikanpangkatT'];
    $judulLaporan = 'Data KPKenaikanpangkatT';
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

  public function actionGetTahun()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      if (!empty($_POST['tahun'])) {
        $format = new MyFormatter;
        $tahun = $format->formatDateTimeForDb($_POST['tahun']);
        $dob = $tahun;
        $today = date("Y-m-d");
        list($y, $m, $d) = explode('-', $dob);
        list($ty, $tm, $td) = explode('-', $today);
        if ($td - $d < 0) {
          $day = ($td + 30) - $d;
          $tm--;
        } else {
          $day = $td - $d;
        }
        if ($tm - $m < 0) {
          $month = ($tm + 12) - $m;
          $ty--;
        } else {
          $month = $tm - $m;
        }
        $year = $ty - $y;

        $data['tahun'] = str_pad($year, 2, '0', STR_PAD_LEFT);
        $data['bulan'] = str_pad($month, 2, '0', STR_PAD_LEFT);
        echo json_encode($data);
      }
      Yii::app()->end();
    }
  }
}
