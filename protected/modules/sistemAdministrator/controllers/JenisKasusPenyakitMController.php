<?php

class JenisKasusPenyakitMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.jenisKasusPenyakitM.';

  public function actionCreateRuangan()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                                  
    $model = new KasuspenyakitruanganM;
    if (isset($_POST['KasuspenyakitruanganM'])) {

      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlahRuangan = isset($_POST['ruangan_id']) ? count((array)$_POST['ruangan_id']) : 0;
        $jenisKasusPenyakit_id = $_POST['KasuspenyakitruanganM']['jeniskasuspenyakit_id'];
        //$hapusKasusPenyakitRuangan=KasuspenyakitruanganM::model()->deleteAll('jeniskasuspenyakit_id='.$jenisKasusPenyakit_id.''); 
        for ($i = 0; $i < $jumlahRuangan; $i++) {
          $modKasusPenyakitRuangan = new KasuspenyakitruanganM;
          $modKasusPenyakitRuangan->ruangan_id = $_POST['ruangan_id'][$i];
          $modKasusPenyakitRuangan->jeniskasuspenyakit_id = $jenisKasusPenyakit_id;
          $modKasusPenyakitRuangan->save();
        }
        Yii::app()->user->setFlash('success', "Data Ruangan Dan Jenis Kasus Penyakit Berhasil Disimpan");
        $transaction->commit();
        $this->redirect(array('admin'));
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Ruangan Dan Jenis Kasus Penyakit Gagal Disimpan");
      }
    }
    $this->render($this->path_view . 'createRuangan', array(
      'model' => $model
    ));
  }

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $this->render($this->path_view . 'view', array(
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
    $model = new SAJenisKasusPenyakitM;
    $modRuangan = array();
    if (isset($_GET['id'])) {
      $modRuangan = KasuspenyakitruanganM::model()->findAll('jeniskasuspenyakit_id=' . $_GET['id'] . '');
    }
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SAJenisKasusPenyakitM'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model = new SAJenisKasusPenyakitM;
        $model->attributes = $_POST['SAJenisKasusPenyakitM'];
        $model->jeniskasuspenyakit_aktif = TRUE;

        $jumlahRuangan = isset($_POST['ruangan_id']) ? count((array)$_POST['ruangan_id']) : 0;
        // $jenisKasusPenyakit_id=$model->jeniskasuspenyakit_id;
        // $hapusKasusPenyakitRuangan=KasuspenyakitruanganM::model()->deleteAll('jeniskasuspenyakit_id='.$jenisKasusPenyakit_id.''); 

        if ($model->save()) {

          if ($jumlahRuangan > 0) {
            $dataRuangan = $_POST['ruangan_id'];

            foreach ($dataRuangan as $i => $ruangan) {
              // print_r($model->jeniskasuspenyakit_id);exit();
              $modKasusPenyakitRuangan = new KasuspenyakitruanganM;
              $modKasusPenyakitRuangan->ruangan_id = $ruangan;
              $modKasusPenyakitRuangan->jeniskasuspenyakit_id = $model->jeniskasuspenyakit_id;
              $modKasusPenyakitRuangan->save();
            }
          }
          Yii::app()->user->setFlash('success', "Data Ruangan Dan Jenis Kasus Penyakit Berhasil Disimpan");
          $transaction->commit();
          $this->redirect(array('admin', 'sukses' => 1));
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Ruangan Dan Jenis Kasus Penyakit Gagal Disimpan");
      }
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model, 'modRuangan' => $modRuangan
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
    $model->statusrawat_kemenkes_nama = $model->statusrawat_kemenkes;
    $modRuangan = KasuspenyakitruanganM::model()->findAll('jeniskasuspenyakit_id=' . $id . '');
    // Uncomment the following line if AJAX validation is needed

    if (isset($_POST['SAJenisKasusPenyakitM'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlahRuangan = isset($_POST['ruangan_id']) ? count((array)$_POST['ruangan_id']) : 0;
        $jenisKasusPenyakit_id = $model->jeniskasuspenyakit_id;
        $hapusKasusPenyakitRuangan = KasuspenyakitruanganM::model()->deleteAll('jeniskasuspenyakit_id=' . $jenisKasusPenyakit_id . '');

        if ($jumlahRuangan > 0) {
          $dataRuangan = $_POST['ruangan_id'];
          // for($i=0; $i<$jumlahRuangan; $i++)
          foreach ($dataRuangan as $i => $ruangan) {
            $modKasusPenyakitRuangan = new KasuspenyakitruanganM;
            $modKasusPenyakitRuangan->ruangan_id = $ruangan;
            $modKasusPenyakitRuangan->jeniskasuspenyakit_id = $jenisKasusPenyakit_id;
            $modKasusPenyakitRuangan->save();
          }
        }
        $model->attributes = $_POST['SAJenisKasusPenyakitM'];
        if ($model->save()) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Ruangan Dan Jenis Kasus Penyakit Berhasil Disimpan");
          $this->redirect(array('admin', 'sukses' => 1));
        }
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Ruangan Dan Jenis Kasus Penyakit Gagal Disimpan");
      }
    }

    $this->render($this->path_view . 'update', array(
      'model' => $model, 'modRuangan' => $modRuangan
    ));
  }

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('SAJenisKasusPenyakitM');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new SAJenisKasusPenyakitM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SAJenisKasusPenyakitM']))
      $model->attributes = $_GET['SAJenisKasusPenyakitM'];
      $model->ruangan_id = isset($_GET['SAJenisKasusPenyakitM']['ruangan_id']) ? $_GET['SAJenisKasusPenyakitM']['ruangan_id'] : null;

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
    $model = SAJenisKasusPenyakitM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sajenis-kasus-penyakit-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  public function actionDelete()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    if (Yii::app()->request->isPostRequest) {
      $id = $_POST['id'];
      $modKasusPenyakitDiagnosa = KasuspenyakitdiagnosaM::model()->findAllByAttributes(array('jeniskasuspenyakit_id' => $id));
      if (!empty($modKasusPenyakitDiagnosa)) {
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'warning',
          ));
          exit;
        }
      } else {
        $modKasusPenyakitRuangan = KasuspenyakitruanganM::model()->findAllByAttributes(array('jeniskasuspenyakit_id' => $id));
        if (!empty($modKasusPenyakitRuangan)) {
          KasuspenyakitruanganM::model()->deleteAllByAttributes(array('jeniskasuspenyakit_id' => $id));
        }
        $modKasusPenyakitObat = KasuspenyakitobatM::model()->findAllByAttributes(array('jeniskasuspenyakit_id' => $id));
        if (!empty($modKasusPenyakitObat)) {
          KasuspenyakitobatM::model()->deleteAllByAttributes(array('jeniskasuspenyakit_id' => $id));
        }
        $this->loadModel($id)->delete();
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
          ));
          exit;
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
      $update = SAJenisKasusPenyakitM::model()->updateByPk($id, array('jeniskasuspenyakit_aktif' => false));
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

    $model = new SAJenisKasusPenyakitM;
    $model->attributes = $_REQUEST['SAJenisKasusPenyakitM'];
    $judulLaporan = 'Data Jenis Kasus Penyakit';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {

      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                            //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10, 'is_pdf'=>1), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 70, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
  
    public function actionSetDropdownStatusRawatKemenkes() {
       if (Yii::app()->request->isAjaxRequest) {
            $form = '<option value="">-- Pilih --</option>';
            $bpjs = new BridgingKemenkes();
            $start = 1;
            $limit = 10;
            
            $kemenkesnamastatus  = (isset($_GET['statusrawatkemenkes'])?$_GET['statusrawatkemenkes']:"");
            
            $dataBridging = $bpjs->status_rawat("",$start, $limit);
            $decodeJson = json_decode($dataBridging);

            if(!empty($decodeJson) && count($decodeJson->status_rawat) > 0){
                foreach ($decodeJson->status_rawat as $data){
                    $kode = $data->id_status_rawat;
                    $nama = $data->status;
                    $selected = "";
                    if(!empty($kemenkesnamastatus)){
                        if($kemenkesnamastatus == $kode){
                            $selected = 'selected=selected';
                        }
                    }

                    $form .= 
                    "
                        <option value='".$kode."' ".$selected.">".$nama."</option>
                    ";
                }
            }else{
                 $pesan = "Data tidak ada!";
            }
            

            echo CJSON::encode(array('form' => $form));
            Yii::app()->end();
        }
    }
}
