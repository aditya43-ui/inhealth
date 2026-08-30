<?php

class RegistrasiScanController extends MyAuthController
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
    $model = new KPRegistrasifingerprint();
    $modPegawai = new KPPegawaiM();
    // Uncomment the following line if AJAX validation is needed

    $modDetails = array();
    $model->pegawai_id = 0;
    if (Yii::app()->request->isAjaxRequest) {
      if (isset($_GET['idAlat']) && !isset($_GET['disconnect'])) {
        AlatfingerM::model()->updateAll(array('alat_aktif' => false));
        $idAlat = $_GET['idAlat'];
        $value = AlatfingerM::model()->updateByPk($idAlat, array('alat_aktif' => true));
        $result['success'] = $value;
        $result['data'] = AlatfingerM::model()->findByPk($idAlat)->attributes;
        $result['connection'] = $this->cekConnection($result['data']['ipfinger']);
        $result['time'] = date('d M Y');
        echo json_encode($result);
        Yii::app()->end();
      } else if (isset($_GET['idAlat']) && isset($_GET['disconnect'])) {
        $value = AlatfingerM::model()->updateAll(array('alat_aktif' => false));
        $result['success'] = true;
        echo json_encode($result);
        Yii::app()->end();
      }
    }

    if (isset($_GET['KPRegistrasifingerprint'])) {
      $model->unsetAttributes();
      $model->attributes = $_GET['KPRegistrasifingerprint'];
      $model->jabatansampai = $_GET['KPRegistrasifingerprint']['jabatansampai'];
      $model->nipsampai = $_GET['KPRegistrasifingerprint']['nipsampai'];
      $model->namasampai = $_GET['KPRegistrasifingerprint']['namasampai'];
      $model->kelompoksampai = $_GET['KPRegistrasifingerprint']['kelompoksampai'];
      $model->alatfinger_id = $_GET['KPRegistrasifingerprint']['alatfinger_id'];
    }



    if (isset($_POST['KPRegistrasifingerprint']) && isset($_POST['id_alat_finger'])) {
      $idAlatFinger = $_POST['id_alat_finger'];
      $modAlat = AlatfingerM::model()->findByPk($idAlatFinger);

      $mips = new MIPS();
      $mips->ip_address = $modAlat->ipfinger;
      $mips->pass = $modAlat->keyfinger;

      $nama_perangkat = $modAlat->namaalat . " (" . $modAlat->ipfinger . ")";

      // var_dump($nama_perangkat); die;

      $pegawai_gagal_list = array();
      /* filter data array yang kosong */

      try {

        //                            var_dump($_POST); die;


        if (isset($_POST['KPRegistrasifingerprint']['register_foto'])) {
          foreach ($_POST['KPRegistrasifingerprint']['register_foto'] as $pegawai_id => $detail) {

            if (!isset($detail['gambar']) || $detail['ceklis'] == 0) {
              continue;
            }

            $photo_pegawai = $detail['gambar'];


            if (!file_exists(Params::pathPegawaiDirectory() . $photo_pegawai)) {
              continue;
            }

            $peg = PegawaiM::model()->findByPk($pegawai_id);

            // ubah file gambar menjadi format base64
            $data_img = file_get_contents(Params::pathPegawaiDirectory() . $photo_pegawai);
            $str_img = base64_encode($data_img);

            $id_peg = str_pad($peg->pegawai_id, 6, "0", STR_PAD_LEFT);

            $person = array(
              'age' => $peg->umurTahun,
              'name' => $peg->nama_pegawai,
              'prescription' => date('Y-m-d H:i') . ", " . date('Y-m-d H:i', strtotime('now + 20 years')),
              'sex' => $peg->jeniskelamin == 'LAKI-LAKI' ? 0 : 1,
              'type' => MIPS::REG_PEGAWAI,
              'vipID' => "2" . $id_peg,
              'welCome' => '',
              'idCard' => "2" . $id_peg,
              'card' => "2" . $id_peg,
              'wn' => '',
              'imgBase64' => $str_img
            );

            //                                    var_dump($person); die;

            $response = $mips->register($person);

            //                                    var_dump($response); die;

            if ($response['success'] == true) {

              $finger = PegawaifingerM::model()->findByAttributes(array(
                'pegawai_id' => $pegawai_id,
                'alatfinger_id' => $modAlat->alatfinger_id,
              ));


              if (empty($finger)) {

                $finger = new PegawaifingerM();
                $finger->pegawai_id = $pegawai_id;
                $finger->alatfinger_id = $modAlat->alatfinger_id;
                $finger->save();
              }
            } else {
              $pegawai_gagal_list[] = $peg->namaLengkap;
            }
          }
        }


        if (count((array)$pegawai_gagal_list) > 0) {
          $str = "<ul>";

          foreach ($pegawai_gagal_list as $item) {
            $str .= "<li>" . $item . "</li>";
          }

          $str .= "</ul>";
          Yii::app()->user->setFlash('warning', "Sebagian data pegawai berhasil dikirim ke perangkat " . $nama_perangkat . ", namun data Pegawai yang gagal disimpan ke perangkat :<br/>" . $str);
        } else {
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data pegawai berhasil disimpan ke perangkat  ' . $nama_perangkat . '.');
        }


        // $this->refresh();
        //foreach ($_POST['KPRegistrasifingerprint'])
      } catch (Exception $ex) {
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
      }
    }

    $this->render('create', array(
      'model' => $model, 'modDetails' => $modDetails, 'modPegawai' => $modPegawai
    ));
  }

  private function connection($ip)
  {
    // $result = false;
    //if (fsockopen($ip, "4370", $errno, $errstr, 1)){
    return fsockopen($ip, "4370", $errno, $errstr, 1);
    //}
    //return $result;
  }

  private function cekConnection($ip)
  {
    $result = false;
    //if (fsockopen($ip, "4370", $errno, $errstr, 1)){
    $result = true;
    //}
    return $result;
  }

  protected function insertData($model, $IP, $Key)
  {
    //            $IP = Params::IP_FINGER_PRINT;
    //            $Key = Params::KEY_FINGER_PRINT;
    $Connect = $this->connection($IP);
    if ($Connect) {
      // var_dump($Response=fgets($Connect)); die;
      $soap_request = "<SetUserInfo><ArgComKey Xsi:type=\"xsd:integer\">" . $Key . "</ArgComKey><Arg>
                        <PIN>" . $model->nofingerprint . "</ PIN>
                        <Name>" . $model->nama_pegawai . "</Name>
                        </Arg></SetUserInfo>";
      $newLine = "\r\n";
      fputs($Connect, "POST /iWsService HTTP/1.0" . $newLine);
      fputs($Connect, "Content-Type: text/xml" . $newLine);
      fputs($Connect, "Content-Length: " . strlen($soap_request) . $newLine . $newLine);
      fputs($Connect, $soap_request . $newLine);
      $buffer = "";



      while ($Response = fgets($Connect)) {
        $buffer = $buffer . $Response;
      }
      // die;

      //var_dump($buffer); die;

      $buffer = $this->ParseData($buffer, "<Information>", "</Information>");

      //var_dump($buffer); die;

      if ($buffer == 'Successfully!') {
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  protected function deleteData($model)
  {
    $IP = Params::IP_FINGER_PRINT;
    $Key = Params::KEY_FINGER_PRINT;
    $Connect = fsockopen($IP, "80", $errno, $errstr, 1);
    if ($Connect) {
      $soap_request = "<SetUserInfo><ArgComKey Xsi:type=\"xsd:integer\">" . $Key . "</ArgComKey><Arg>
                        <PIN>" . $model->no_fingerprint . "</ PIN>
                        <Name>" . $model->nama_pegawai . "</Name>
                        </Arg></SetUserInfo>";
      $newLine = "\r\n";
      fputs($Connect, "POST /iWsService HTTP/1.0" . $newLine);
      fputs($Connect, "Content-Type: text/xml" . $newLine);
      fputs($Connect, "Content-Length: " . strlen($soap_request) . $newLine . $newLine);
      fputs($Connect, $soap_request . $newLine);
      $buffer = "";
      while ($Response = fgets($Connect, 1024)) {
        $buffer = $buffer . $Response;
      }
      $buffer = $this->ParseData($buffer, "<Information>", "</Information>");
      if ($buffer == 'Successfully!') {
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  protected function getData($model)
  {
    $IP = Params::IP_FINGER_PRINT;
    $Key = Params::KEY_FINGER_PRINT;
    $Connect = fsockopen($IP, "80", $errno, $errstr, 1);
    if ($Connect) {
      $soap_request = "<GetUserInfo><ArgComKey Xsi:type=\"xsd:integer\">" . $Key . "</ArgComKey><Arg><PIN>All</PIN></Arg></GetUserInfo>";
      $newLine = "\r\n";
      fputs($Connect, "POST /iWsService HTTP/1.0" . $newLine);
      fputs($Connect, "Content-Type: text/xml" . $newLine);
      fputs($Connect, "Content-Length: " . strlen($soap_request) . $newLine . $newLine);
      fputs($Connect, $soap_request . $newLine);
      $buffer = "";
      while ($Response = fgets($Connect, 1024)) {
        $buffer = $buffer . $Response;
      }

      $buffer = $this->ParseData($buffer, "<GetUserInfoResponse>", "</GetUserInfoResponse>");
      echo $buffer;
    } else {
      return false;
    }
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

  protected function validasiTabular($data)
  {
    foreach ($data as $i => $row) {
      $modDetails[$i] = KPRegistrasifingerprint::model()->findByPk($i);
      $modDetails[$i]->nofingerprint = $row;
      $modDetails[$i]->validate();
    }
    return $modDetails;
  }

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = PegawaiM::model()->findByPk($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['KPRegistrasifingerprint'])) {
      $model->attributes = $_POST['KPRegistrasifingerprint'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->pegawai_id));
      }
    }

    $this->render('_edit', array(
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
    $dataProvider = new CActiveDataProvider('KPPengangkatanpnsT');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new KPRegistrasifingerprint('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['KPRegistrasifingerprint']))
      $model->attributes = $_GET['KPRegistrasifingerprint'];

    $this->render('admin', array(
      'model' => $model,
    ));
  }

  public function actionInformasi()
  {

    $model = new KPRegistrasifingerprint('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['KPRegistrasifingerprint']))
      $model->attributes = $_GET['KPRegistrasifingerprint'];

    $this->render('informasi', array(
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
    $model = KPRegistrasifingerprint::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'kppengangkatanpns-t-form') {
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
    $model = new KPPengangkatanpnsT;

    $model->attributes = $_REQUEST['KPPengangkatanpnsT'];

    $judulLaporan = 'Data KPPengangkatanpnsT';

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


  public function actionInformasiPrint()
  {
    $model = new KPRegistrasifingerprint('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['KPRegistrasifingerprint']))
      $model->attributes = $_GET['KPRegistrasifingerprint'];
    $judulLaporan = 'Data Registrasi Fingerprint';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Printinformasi', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Printinformasi', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Printinformasi', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionGetFingerUser()
  {
    if (Yii::app()->request->isAjaxRequest) {

      if (isset($_GET['idAlat'])) {
        $data = AlatfingerM::model()->findByPk($_GET['idAlat'])->attributes;
        $alatfinger_id = $data['alatfinger_id'];
        $Connect = $this->connection($data['ipfinger']);
        $key = $data['keyfinger'];
        if ($Connect) {
          $soap_request = "<GetUserInfo><ArgComKey xsi:type=\"xsd:integer\">" . $key . "</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetUserInfo>";
          $newLine = "\r\n";
          fputs($Connect, "POST /iWsService HTTP/1.0" . $newLine);
          fputs($Connect, "Content-Type: text/xml" . $newLine);
          fputs($Connect, "Content-Length: " . strlen($soap_request) . $newLine . $newLine);
          fputs($Connect, $soap_request . $newLine);
          $buffer = "";
          while ($Response = fgets($Connect, 1024)) {
            $buffer = $buffer . $Response;
          }
          $buffer = $this->ParseData($buffer, "<GetUserInfoResponse>", "</GetUserInfoResponse>");
          $buffer = explode("\r\n", $buffer);

          $result = array();
          for ($a = 0; $a < count((array)$buffer); $a++) {
            $data = $this->ParseData($buffer[$a], "<Row>", "</Row>");
            $hasil = $this->ParseData($data, "<PIN>", "</PIN>");
            if (!empty($hasil)) {
              $result[$a]['no'] = $a;
              $result[$a]['pin'] = $this->ParseData($data, "<PIN2>", "</PIN2>");
              $result[$a]['name'] = $this->ParseData($data, "<Name>", "</Name>");
              /*
                                $cek_id = KPRegistrasifingerprint::model()->findByAttributes(
                                    array(
                                        'nama_pegawai'=>$result[$a]['name']
                                    )
                                );
                                if($cek_id)
                                {
                                    $finger = new NofingeralatM();
                                    $finger->pegawai_id = $cek_id['pegawai_id'];
                                    $finger->alatfinger_id = $alatfinger_id;
                                    $finger->tglregistrasifinger = date('Y-m-d H:i:s');;
                                    $finger->nofinger = $result[$a]['pin'];
                                    $finger->create_time = date('Y-m-d H:i:s');;
                                    $finger->create_loginpemakai_id = Yii::app()->user->id;
                                    $finger->create_ruangan = Yii::app()->user->getState('ruangan_id');;
                                    if(!$finger->save())
                                    {
                                        print_r($finger->getErrors());
                                    }
                                }
                                 * 
                                 */
            }
          }
          $form = '';
          foreach ($result as $val) {
            $form .= '<tr><td>' . $val['no'] . '</td><td>' . $val['pin'] . '</td><td>' . $val['name'] . '</td></tr>';
          }

          $rec = array(
            'status' => ($result > 0 ? 1 : 0),
            'form' => $form
          );
          echo json_encode($rec);
        }
      }
      Yii::app()->end();
    }
  }
}
