<?php

class JamkerjaMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $IP = Params::IP_FINGER_PRINT;
  public $Key = Params::KEY_FINGER_PRINT;

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
    $model = new KPPresensiT;
    $model->tglpresensi = date('Y-m-d H:i:s');
    $modPegawai = new KPRegistrasifingerprint();

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['KPPresensiT'])) {
      $format = new MyFormatter();
      $model->attributes = $_POST['KPPresensiT'];
      $modPegawai = KPRegistrasifingerprint::model()->findByPk($_POST['KPRegistrasifingerprint']['pegawai_id']);
      $model->pegawai_id = $_POST['KPRegistrasifingerprint']['pegawai_id'];
      $model->no_fingerprint = $_POST['KPRegistrasifingerprint']['nofingerprint'];
      $model->tglpresensi = $format->formatDateTimeForDb($_POST['KPPresensiT']['tglpresensi']);

      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('create'));
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


    if (isset($_POST['KPPresensiT'])) {
      $model->attributes = $_POST['KPPresensiT'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->presensi_id));
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
    $dataProvider = new CActiveDataProvider('KPPresensiT');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new KPPresensiT('search');
    $model->tglpresensi = date('Y-m-d 00:00:00');
    $model->tglpresensi_akhir = date('Y-m-d 23:59:59');
    //		$model->unsetAttributes();  // clear any default values
    if (isset($_GET['KPPresensiT'])) {
      $model->attributes = $_GET['KPPresensiT'];
      $format = new MyFormatter();
      $model->tglpresensi = $format->formatDateTimeForDb($_GET['KPPresensiT']['tglpresensi']);
      $model->tglpresensi_akhir = $format->formatDateTimeForDb($_GET['KPPresensiT']['tglpresensi_akhir']);
    }

    $this->render('admin', array(
      'model' => $model,
    ));
  }

  public function actionAmbilData()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $result = $this->retrieveData();
      if (is_array($result)) {
        $insert = $this->insertPerdetik($result);
        if ($insert == true) {
          $this->deleteAllData();
        }
        echo $insert;
      } else {
        echo true;
      }

      Yii::app()->end();
    }
  }

  protected function retrieveData()
  {

    $Connect = fsockopen($this->IP, "80", $errno, $errstr, 1);

    if ($Connect) {
      $soap_request = "<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">" . $this->Key . "</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
      $newLine = "\r\n";
      fputs($Connect, "POST /iWsService HTTP/1.0" . $newLine);
      fputs($Connect, "Content-Type: text/xml" . $newLine);
      fputs($Connect, "Content-Length: " . strlen($soap_request) . $newLine . $newLine);
      fputs($Connect, $soap_request . $newLine);
      $buffer = "";
      while ($Response = fgets($Connect, 1024)) {
        $buffer = $buffer . $Response;
      }
      $buffer = $this->ParseData($buffer, "<GetAttLogResponse>", "</GetAttLogResponse>");
      $buffer = explode("\r\n", $buffer);

      $result = array();
      for ($a = 0; $a < count((array)$buffer); $a++) {
        $data = $this->ParseData($buffer[$a], "<Row>", "</Row>");
        $hasil = $this->ParseData($data, "<PIN>", "</PIN>");
        if (!empty($hasil)) {
          $result[$a]['pin'] = $this->ParseData($data, "<PIN>", "</PIN>");
          $result[$a]['date'] = $this->ParseData($data, "<DateTime>", "</DateTime>");
          $result[$a]['verified'] = $this->ParseData($data, "<Verified>", "</Verified>");
          $result[$a]['status'] = $this->ParseData($data, "<Status>", "</Status>");
        }
      }
      if (count((array)$result) == 0) {
        $result = false;
      }
      return $result;
    } else {
      return false;
    }
  }

  protected function insertPerdetik($result)
  {
    //            $data = $this->retrieveData();
    if (count((array)$result) > 0) {
      $transaction = Yii::app()->db->beginTransaction();
      $user_id = Yii::app()->user->id;
      try {
        $counter = 0;
        $jumlah = 0;
        foreach ($result as $i => $row) {
          $pegawai = PegawaiM::model()->findByAttributes(array('nofingerprint' => $row['pin']));
          if (!empty($pegawai)) {

            $jumlah++;
            $model = new PresensiT();
            $model->tglpresensi = $row['date'];
            $model->no_fingerprint = $row['pin'];
            $model->statusscan_id = $row['status'] + 1;
            //                            $model->verifikasi = $row['verified'];
            $model->pegawai_id = $pegawai->pegawai_id;
            $model->create_time = date('Y-m-d H:i:s');
            $model->statuskehadiran_id = 1;
            $model->create_loginpemakai_id = $user_id;
            if ($model->save()) {
              $counter++;
            } else {
              throw new Exception('Presensi gagal disimpan');
            }
          } else {
            throw new Exception('Pegawai dengan no finger print tidak ditemukan');
          }
        }
        if (($jumlah == $counter) && ($counter != 0)) {
          $transaction->commit();
          return true;
        } else {
          throw new Exception("Jumlah yang di save tidak sesuai");
        }
      } catch (Exception $ex) {
        echo $ex->getMessage();
      }
    }
  }

  protected function deleteAllData()
  {
    $Connect = fsockopen($this->IP, "80", $errno, $errstr, 1);
    if ($Connect) {
      $soap_request = "<ClearData><ArgComKey xsi:type=\"xsd:integer\">" . $this->Key . "</ArgComKey><Arg><Value xsi:type=\"xsd:integer\">3</Value></Arg></ClearData>";
      $newLine = "\r\n";
      fputs($Connect, "POST /iWsService HTTP/1.0" . $newLine);
      fputs($Connect, "Content-Type: text/xml" . $newLine);
      fputs($Connect, "Content-Length: " . strlen($soap_request) . $newLine . $newLine);
      fputs($Connect, $soap_request . $newLine);
      $buffer = "";
      while ($Response = fgets($Connect, 1024)) {
        $buffer = $buffer . $Response;
      }
    } else
      echo "Koneksi Gagal";

    $buffer = $this->ParseData($buffer, "<Information>", "</Information>");

    echo $buffer;
  }

  protected function ParseData($data, $p1, $p2)
  {
    $data = " " . $data;
    $hasil = "";
    $awal = strpos($data, $p1);
    if ($awal != "") {
      $akhir = strpos(strstr($data, $p1), $p2);
      if ($akhir != "") {
        $hasil = substr($data, $awal + strlen($p1), $akhir - strlen($p1));
      }
    }
    return $hasil;
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = KPPresensiT::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'kppresensi-t-form') {
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
    $model = new KPPresensiT('search');
    $format = new MyFormatter();
    $model->attributes = $_GET['KPPresensiT'];
    $model->tglpresensi = $format->formatDateTimeForDb($_GET['KPPresensiT']['tglpresensi']);
    $model->tglpresensi_akhir = $format->formatDateTimeForDb($_GET['KPPresensiT']['tglpresensi_akhir']);

    $judulLaporan = 'Data Presensi';
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
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
