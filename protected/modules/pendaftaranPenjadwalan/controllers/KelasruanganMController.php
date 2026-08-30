<?php

class KelasruanganMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';

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
    $model = new PPKelasruanganM;
    $modPelayanan = KelaspelayananM::model()->findAll();
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['PPKelasruanganM'])) {

      $transaction = Yii::app()->db->beginTransaction();
      try {

        if (isset($_POST['kelaspelayanan_id'])) :
          $jumlahRuangan = count((array)$_POST['kelaspelayanan_id']);
        else :
          $jumlahRuangan = 0;
        endif;

        $ruangan_id = $_POST['PPKelasruanganM']['ruangan_id'];
        $hapuskelasRuangan = KelasruanganM::model()->deleteAll('ruangan_id=' . $ruangan_id . '');
        for ($i = 0; $i <= $jumlahRuangan - 1; $i++) {
          $modKasusRuangan = new KelasruanganM;
          $modKasusRuangan->ruangan_id = $ruangan_id;
          $modKasusRuangan->kelaspelayanan_id = $_POST['kelaspelayanan_id'][$i];
          $modKasusRuangan->save();
        }
        Yii::app()->user->setFlash('success', "Data Kelas Ruangan Berhasil Disimpan");
        $transaction->commit();
        $this->redirect(array('admin'));
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Kelas Ruangan Gagal Disimpan");
      }
    }

    $this->render('create', array(
      'model' => $model, 'modPelayanan' => $modPelayanan,
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
    $modPelayanan = KelasruanganM::model()->findAll('ruangan_id =' . $id);


    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['PPRuanganM'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        if (isset($_POST['kelaspelayanan_id'])) :
          $jumlahRuangan = count((array)$_POST['kelaspelayanan_id']);
        else :
          $jumlahRuangan = 0;
        endif;

        $ruangan_id = $_POST['PPRuanganM']['ruangan_id'];
        $hapuskelasRuangan = KelasruanganM::model()->deleteAll('ruangan_id=' . $ruangan_id . '');
        for ($i = 0; $i <= $jumlahRuangan; $i++) {
          $modKasusRuangan = new KelasruanganM;
          $modKasusRuangan->ruangan_id = $ruangan_id;
          $modKasusRuangan->kelaspelayanan_id = (isset($_POST['kelaspelayanan_id'][$i]) ? $_POST['kelaspelayanan_id'][$i] : null);
          $modKasusRuangan->save();
        }

        Yii::app()->user->setFlash('success', "Data Kelas Ruangan Berhasil Disimpan");
        $transaction->commit();
        $this->redirect(array('admin'));
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Kelas Ruangan Gagal Disimpan");
      }
    }

    $this->render('update', array(
      'model' => $model, 'modPelayanan' => $modPelayanan,
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
      var_dump($id);
      $hapuskelasRuangan = KelasruanganM::model()->deleteAll('ruangan_id=' . $id . '');

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
    $dataProvider = new CActiveDataProvider('PPRuanganM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new PPRuanganM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['PPRuanganM']))
      $model->attributes = $_GET['PPRuanganM'];

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
    $model = PPRuanganM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'ppruangan-m-form') {
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
    $model = new PPRuanganM;
    $model->attributes = $_REQUEST['PPRuanganM'];
    $judulLaporan = 'Data Ruangan';
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
