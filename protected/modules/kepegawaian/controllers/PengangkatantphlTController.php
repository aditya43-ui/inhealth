<?php

class PengangkatantphlTController extends MyAuthController
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
  public function actionCreate($id = null)
  {
    $format = new MyFormatter();
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    if (!empty($id)) {
      $model = KPPengangkatantphlT::model()->findByPk($id);
      if (!empty($model)) {
        $modPegawai = KPPegawaiM::model()->findByPk($model->pegawai_id);
      } else {
        unset($model);
      }
    } else {
      $model = new KPPengangkatantphlT;
      $modPegawai = new KPPegawaiM;
      $model->pengangkatantphl_noperjanjian = MyGenerator::noPerjanjian();
      $modPegawai->profilrs_id = Params::getDefaultProfilRS();
    }

    if ((isset($_POST['KPPengangkatantphlT'])) && (is_null($id))) {

      $model->attributes = $_POST['KPPengangkatantphlT'];
      $modPegawai->attributes = $_POST['KPPegawaiM'];

      $model->pengangkatantphl_tmt = $format->formatDateTimeForDb($_POST['KPPengangkatantphlT']['pengangkatantphl_tmt']);
      $model->pengangkatantphl_tglsk = $format->formatDateTimeForDb($_POST['KPPengangkatantphlT']['pengangkatantphl_tglsk']);
      $model->pengangkatantphl_tmtsk = $format->formatDateTimeForDb($_POST['KPPengangkatantphlT']['pengangkatantphl_tmtsk']);
      $modPegawai->tgl_lahirpegawai = $format->formatDateTimeForDb($_POST['KPPegawaiM']['tgl_lahirpegawai']);
      $modPegawai->tglditerima = $format->formatDateTimeForDb($_POST['KPPegawaiM']['tglditerima']);


      $transaction = Yii::app()->db->beginTransaction();
      try {
        if ($_POST['caraAmbilPhoto'] == 'file') //Jika User Mengambil photo pegawai dengan cara upload file
        {

          $modPegawai->pegawai_aktif = true;
          $modPegawai->photopegawai = CUploadedFile::getInstance($modPegawai, 'photopegawai');
          $gambar = $modPegawai->photopegawai;
          $random = rand(000000, 999999);

          if (!empty($modPegawai->photopegawai)) //Klo User Memasukan Logo
          {

            $modPegawai->photopegawai = $random . $modPegawai->photopegawai;

            Yii::import("ext.EPhpThumb.EPhpThumb");

            $thumb = new EPhpThumb();
            $thumb->init(); //this is needed

            $fullImgName = $modPegawai->photopegawai;
            $fullImgSource = Params::pathPegawaiDirectory() . $fullImgName;
            $fullThumbSource = Params::pathPegawaiTumbsDirectory() . 'kecil_' . $fullImgName;
          }
        }

        if ($modPegawai->validate()) {
          if ($modPegawai->save()) {
            if (!empty($modPegawai->photopegawai)) {
              $gambar->saveAs($fullImgSource);

              $thumb->create($fullImgSource)
                ->resize(200, 200)
                ->save($fullThumbSource);
            }
            $model->pegawai_id = $modPegawai->pegawai_id;
            if ($model->validate()) {
              if ($model->save()) {
                $transaction->commit();
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                $this->redirect(array('create', 'id' => $model->pengangkatantphl_id));
              }
            }
          }
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
      }
    }

    $this->render('create', array(
      'model' => $model, 'modPegawai' => $modPegawai,
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


    if (isset($_POST['KPPengangkatantphlT'])) {
      $model->attributes = $_POST['KPPengangkatantphlT'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->pengangkatantphl_id));
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
    $dataProvider = new CActiveDataProvider('KPPengangkatantphlT');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new KPPengangkatantphlT('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['KPPengangkatantphlT']))
      $model->attributes = $_GET['KPPengangkatantphlT'];

    $this->render('admin', array(
      'model' => $model,
    ));
  }

  public function actionInformasi()
  {
    $model = new KPPengangkatantphlT('search');
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->unsetAttributes();  // clear any default values

    if (isset($_GET['KPPengangkatantphlT'])) {
      $model->attributes = $_GET['KPPengangkatantphlT'];
      $format = new MyFormatter();
      $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
      $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
    }

    $this->render('informasi', array(
      'model' => $model,
    ));
  }

  public function actionDetail($pengangkatantphl_id = null, $pegawai_id = null)
  {
    $this->layout = '//layouts/iframe';
    $model = KPPengangkatantphlT::model()->findByPk($pengangkatantphl_id);
    $modPegawai = KPPegawaiM::model()->findByPk($model->pegawai_id);

    $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
    $judulLaporan = 'Data Pengangkatan TPHL Pegawai';
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
    } else if ($caraPrint == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('detailTphl', array(
        'model' => $model,
        'modPegawai' => $modPegawai, 'caraPrint' => $caraPrint, 'judulLaporan' => $judulLaporan
      ), true));
      $mpdf->Output();
    }

    $this->render('detailTphl', array(
      'model' => $model,
      'modPegawai' => $modPegawai,
      'caraPrint' => $caraPrint,
      'judulLaporan' => $judulLaporan
    ));
  }


  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = KPPengangkatantphlT::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'kppengangkatantphl-t-form') {
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
    $model = KPPengangkatantphlT::model()->findByPk($_GET['id']);
    if (isset($_GET['KPPengangkatantphlT'])) {
      $model->attributes = $_REQUEST['KPPengangkatantphlT'];
    }
    $judulLaporan = 'Data Pengangkatan Tenaga Pekerja Harian Lepas';
    $modPegawai = KPRegistrasifingerprint::model()->findByPk($model->pegawai_id);
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('_print', array('model' => $model, 'modPegawai' => $modPegawai, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
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
