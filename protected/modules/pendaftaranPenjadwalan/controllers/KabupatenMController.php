<?php

class KabupatenMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
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
    $model = new PPKabupatenM;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['PPKabupatenM']) && isset($_POST['PPKabupatenM']['propinsi_id'])) {
      $trans = Yii::app()->db->beginTransaction();
      $valid = true;

      try {
        foreach ($_POST['PPKabupatenM'] as $i => $item) {
          if (is_integer($i)) {
            $model = new PPKabupatenM;
            $model->attributes = $item;
            $model->propinsi_id = $_POST['PPKabupatenM']['propinsi_id'];
            $model->kabupaten_aktif = true;

            $valid = $model->validate() && $valid;
            if ($valid) {
              $valid = $valid && $model->save();
            } else {
              $valid = false;
            }
          }
        }

        if ($valid) {
          $trans->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('admin'));
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data tidak valid.');
          $this->redirect(array('create'));
        }
      } catch (Exception $ex) {
        $trans->rollback();
        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data tidak valid.');
        $this->redirect(array('create'));
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
    $model->kodekabupaten_kemenkes_nama = $model->kodekabupaten_kemenkes;
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['PPKabupatenM'])) {
      $model->attributes = $_POST['PPKabupatenM'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('admin', 'id' => $model->kabupaten_id));
      }
    }

    $this->render('update', array(
      'model' => $model,
    ));
  }

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('PPKabupatenM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new PPKabupatenM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['PPKabupatenM']))
      $model->attributes = $_GET['PPKabupatenM'];

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
    $model = PPKabupatenM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'ppkabupaten-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionDelete()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    if (Yii::app()->request->isPostRequest) {
      $id = $_POST['id'];
      $kecamatan = PPKecamatanM::model()->findByAttributes(array('kabupaten_id' => $id));
      if ($kecamatan) {
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
   * Mengubah status aktif
   * @param type $id 
   */
  public function actionRemoveTemporary()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //                    SAPropinsiM::model()->updateByPk($id, array('propinsi_aktif'=>false));
    //                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));


    $id = $_POST['id'];
    if (isset($_POST['id'])) {
      $update = PPKabupatenM::model()->updateByPk($id, array('kabupaten_aktif' => false));
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
    $model = new PPKabupatenM;
    $model->attributes = $_REQUEST['PPKabupatenM'];
    $judulLaporan = 'Data Kabupaten';
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

  public function actionValidcode()
  {
    $kabupaten = $_POST['kabupaten_nama'];
    $kabupaten1 = KabupatenM::model()->findAll('kabupaten_nama=:vkabupaten', array(
      ':vkabupaten' => $kabupaten,
    ));
    foreach ($kabupaten1 as $a) {
      echo $kabupaten . ' Tidak boleh kosong';
    }
  }
  
    public function actionSetDropdownKabupatenKemenkes() {

        if (Yii::app()->request->isAjaxRequest) {
            $form = '<option value="">-- Pilih --</option>';
            $bpjs = new BridgingKemenkes();
            $start = 1;
            $limit = 10;

            $propinsi = $_POST['propinsi_id'];
            $kemenkesnamakota  = (isset($_POST['kemenkesnamakota'])?$_POST['kemenkesnamakota']:"");

            $propinsiMod = PropinsiM::model()->findByPk($propinsi);

            if(isset($propinsiMod)){
                
                if(!empty($propinsiMod->kodepropinsi_kemenkes)){
                    $query = "propinsi/".$propinsiMod->kodepropinsi_kemenkes;
                    $dataBridging = $bpjs->Kabupaten($query, $start, $limit);
                    $decodeJson = json_decode($dataBridging);

                    if(count($decodeJson->kabupaten) > 0){
                        foreach ($decodeJson->kabupaten as $data){
                            $kode = $data->kode;
                            $nama = $data->nama;
                            $selected = "";
                            if(!empty($kemenkesnamakota)){
                                if($kemenkesnamakota == $kode){
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
                }else{
                     $pesan = "Data tidak ada!";
                }
            }else{
                $pesan = "Data tidak ada!";
            }
            echo CJSON::encode(array('form' => $form));
            Yii::app()->end();
        }
    }

}
