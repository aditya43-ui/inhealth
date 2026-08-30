<?php

class KomponenjasaMController extends MyAuthController
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
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}

    $model = new REKomponenjasaM;
    $details = array();
    if (isset($id)) {
      $model = REKomponenjasaM::model()->findByPk($id);
      //                    echo print_r($modPegawai->attributes);
      if (!empty($model)) {
        $model->komponenjasa_id = $id;
        $details = REKomponenjasaM::model()->findAllByAttributes(array('komponenjasa_id' => $id));
      }
    }


    // Uncomment the following line if AJAX validation is needed



    if (isset($_POST['submitKomponenjasa'])) {
      //                    echo '<pre>';
      //                        echo print_r($_POST['REKomponenjasaM']);
      //                        echo '</pre>';
      //                        exit();
      $jml = 0;
      foreach ($_POST['REKomponenjasaM'] as $i => $row) {
        $model = new REKomponenjasaM;
        $model->jenistarif_id = $_POST['REKomponenjasaM']['jenistarif_id'];
        $model->carabayar_id = $_POST['REKomponenjasaM']['carabayar_id'];
        $model->komponentarif_id = $_POST['REKomponenjasaM']['komponentarif_id'];
        $model->attributes = $row;
        if ($model->validate()) {
          if ($model->save()) {
            $jml++;
            Yii::app()->user->setFlash('success', '<strong>Berhasil </strong> Data berhasil disimpan');
            $this->redirect(array('admin', 'sukses' => 1));
          }
        }
      }
      if ($jml == count((array)$_POST['REKomponenjasaM'])) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil </strong> Data berhasil disimpan');
        $this->redirect(array('admin', 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data gagal disimpan');
      }
    }
    $this->render('create', array(
      'model' => $model, 'details' => $details,
    ));
  }

  protected function validasiTabular($datas, $model)
  {
    $komponen = 0;
    foreach ($datas as $i => $data) {
      if (is_array($data)) {
        if (!empty($data['komponenjasa_id'])) {
          $details[$i] = REKomponenjasaM::model()->findByPk($data['komponenjasa_id']);
          $details[$i]->attributes = $data;
        } else {
          $details[$i] = new REKomponenjasaM();
          $details[$i]->attributes = $data;
        }
        //                    echo "<pre>";
        //                    echo print_r($details[$i]->attributes);
        $details[$i]->validate();
      } else {
        if (empty($data)) {
        } else {
          $komponen = $data;
        }
      }
    }
    //            echo print_r($datas);
    //            exit();
    return $details;
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


    if (isset($_POST['KomponenjasaM'])) {
      $model->attributes = $_POST['KomponenjasaM'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('admin', 'sukses' => 1));
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
    $dataProvider = new CActiveDataProvider('KomponenjasaM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin($sukses = '')
  {
    $this->pageTitle = Yii::app()->name . " - Komponen Jasa";
    if ($sukses == 1) :
      Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
    endif;

    $model = new KomponenjasaM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['KomponenjasaM']))
      $model->attributes = $_GET['KomponenjasaM'];

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
    $model = KomponenjasaM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'komponenjasa-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   *Mengubah status aktif
   * @param type $id 
   */
  public function actionRemoveTemporary()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
    //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    $id = $_GET['id'];
    if (isset($_GET['id'])) {

      $update = KomponenjasaM::model()->updateByPk($id, array('komponenjasa_aktif' => false));

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
    $model = new KomponenjasaM;
    $model->attributes = $_REQUEST['KomponenjasaM'];
    $judulLaporan = 'Data Komponen Jasa';
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
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }
}
