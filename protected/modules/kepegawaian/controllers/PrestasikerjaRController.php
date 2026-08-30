<?php

class PrestasikerjaRController extends MyAuthController
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

    $model = new KPPrestasikerjaR;
    $modPegawai = new KPPegawaiM;
    $details = array();
    if (isset($id)) {
      $modPegawai = KPPegawaiM::model()->findByPk($id);
      //                    echo print_r($modPegawai->attributes);
      if (!empty($modPegawai)) {
        $model->pegawai_id = $id;
        $ordernourut = array('order' => 'nourutprestasi ASC');
        $details = KPPrestasikerjaR::model()->findAllByAttributes(array('pegawai_id' => $id), $ordernourut);
      }
    }


    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['KPPrestasikerjaR'])) {
      $model->attributes = $_POST['KPPrestasikerjaR'];
      $model->pegawai_id = $_POST['KPPrestasikerjaR']['pegawai_id'];
      $modPegawai->attributes = $_POST['KPPrestasikerjaR'];
      //                        echo "<pre>";
      //                        echo print_r($_POST['KPSusunankelM']);
      //                        exit();
      $details = $this->validasiTabular($_POST['KPPrestasikerjaR'], $modPegawai);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlah = count((array)$details);
        $tersimpan = 0;
        foreach ($details as $i => $row) {
          if ($row->save()) {
            $tersimpan++;
          }
        }

        if (($tersimpan > 0) && ($tersimpan == $jumlah)) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('create', 'id' => $model->pegawai_id));
        } else {
          throw new Exception('Data tidak valid');
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', 'Data Gagal Disimpan ' . MyExceptionMessage::getMessage($ex, true));
      }
    }

    $this->render('create', array(
      'model' => $model, 'modPegawai' => $modPegawai, 'details' => $details,
    ));
  }

  protected function validasiTabular($datas, $model)
  {
    $pegawai = 0;
    foreach ($datas as $i => $data) {
      if (is_array($data)) {
        if (!empty($data['prestasikerja_id'])) {
          $details[$i] = KPPrestasikerjaR::model()->findByPk($data['prestasikerja_id']);
          $details[$i]->attributes = $data;
          $pegawai = $data['pegawai_id'];
        } else {
          $details[$i] = new KPPrestasikerjaR();
          $details[$i]->attributes = $data;
          $details[$i]->pegawai_id = $pegawai;
        }
        //                    echo "<pre>";
        //                    echo print_r($details[$i]->attributes);
        $details[$i]->validate();
      } else {
        if (empty($data)) {
        } else {
          $pegawai = $data;
        }
      }
    }
    //            echo print_r($datas);
    //            exit();
    return $details;
  }
  public function actiondeletePrestasi($id)
  {
    $model = new KPPrestasikerjaR;
    if ($model->deleteByPK($id)) {
      $this->redirect(array('create'));
    }
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


    if (isset($_POST['KPPrestasikerjaR'])) {
      $model->attributes = $_POST['KPPrestasikerjaR'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->prestasikerja_id));
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
    $dataProvider = new CActiveDataProvider('KPPrestasikerjaR');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new KPPrestasikerjaR('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['KPPrestasikerjaR']))
      $model->attributes = $_GET['KPPrestasikerjaR'];

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
    $model = KPPrestasikerjaR::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'kpprestasikerja-r-form') {
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
    $model = new KPPrestasikerjaR;
    $model->attributes = $_REQUEST['KPPrestasikerjaR'];
    $judulLaporan = 'Data KPPrestasikerjaR';
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
