<?php

class RegistrasifingerprintController extends MyAuthController
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
      //var_dump($_POST); die;
      $idAlatFinger = $_POST['id_alat_finger'];
      $modAlat = AlatfingerM::model()->findByPk($idAlatFinger);

      /* filter data array yang kosong */
      $data = array_filter($_POST['KPRegistrasifingerprint'], 'strlen');
      if (count((array)$data) > 0) {
        $key = array_keys($data);
        $model->pegawai_id = $key;
        $modDetails = $this->validasiTabular($data);
        /*
                            $fingerHistori->create_time
                            $fingerHistori->update_time
                             * 
                             */


        $transaction = Yii::app()->db->beginTransaction();

        //var_dump($modDetails); die;

        try {
          $jumlah = 0;
          foreach ($modDetails as $i => $v) {
            /*
                                    $cek_id = KPRegistrasifingerprint::model()->findByAttributes(
                                        array(
                                            'nofingerprint'=>$v->nofingerprint
                                        )
                                    );
                                    */

            // var_dump($idAlatFinger." : ".$v->nofingerprint); die;

            $cek_id = NofingeralatM::model()->findByAttributes(
              array(
                'alatfinger_id' => $idAlatFinger,
                'nofinger' => $v->nofingerprint
              )
            );

            if (empty($cek_id) || empty($cek_id->pegawai_id)) {
              $fingerHistori = new KPNofingeralatM;
              $fingerHistori->create_loginpemakai_id = Yii::app()->user->id;
              $fingerHistori->update_loginpemakai_id = Yii::app()->user->id;
              $fingerHistori->alatfinger_id = $modAlat->alatfinger_id;
              $fingerHistori->create_ruangan = Yii::app()->user->getState('ruangan_id');
              $fingerHistori->pegawai_id = $v->pegawai_id;
              $fingerHistori->tglregistrasifinger = date('Y-m-d H:i:s');
              $fingerHistori->nofinger = $v->nofingerprint;
              $fingerHistori->save();

              $update = KPRegistrasifingerprint::model()->updateByPk(
                $v->pegawai_id,
                array(
                  //'nofingerprint'=>$v->nofingerprint,
                  'update_time' => date('Y-m-d')
                )
              );

              if ($update) {
                $jumlah++;
              }
            } else {
              throw new Exception('No. Finger telah terdaftar coba cek ulang');
            }
          }

          if (($jumlah > 0) && (count((array)$modDetails) == $jumlah)) {
            $jumlah = 0;
            foreach ($modDetails as $i => $v) {
              if ($this->insertData($v, $modAlat->ipfinger, $modAlat->keyfinger)) {
                $finger = new NofingeralatM();
                $finger->pegawai_id = $v->pegawai_id;
                $finger->alatfinger_id = $modAlat->alatfinger_id;
                $finger->tglregistrasifinger = date('Y-m-d H:i:s');;
                $finger->nofinger = $v->nofingerprint;
                $finger->create_time = date('Y-m-d H:i:s');;
                $finger->create_loginpemakai_id = Yii::app()->user->id;
                $finger->create_ruangan = Yii::app()->user->getState('ruangan_id');;
                $finger->save();
                $jumlah++;
              } else {
                throw new Exception('Gagal disimpan ke alat');
              }
            }
            if ($jumlah == count((array)$modDetails)) {
              $transaction->commit();

              Yii::app()->user->setFlash('success', 'Data berhasil disimpan.');
              $this->refresh();
            } else {
              Yii::app()->user->setFlash('error', "Data Gagal Disimpan.");
            }
          } else {
            Yii::app()->user->setFlash('error', "Data Gagal Disimpan.");
          }
        } catch (Exception $ex) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
        }
      }
      //                        echo '<pre>';
      //                        echo print_r($data);
      //                                    exit();
      //                        $model->unsetAttributes();
      //			$model->attributes=$_POST['KPRegistrasifingerprint'];
      //			if($model->save()){
      //                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
      //				$this->redirect(array('create'));
      //                        }
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
    if (fsockopen($ip, "4370", $errno, $errstr, 1)) {
      $result = true;
    }
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
    $this->pageTitle = Yii::app()->name . " - Finger Print";
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
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 45, 30, 15, 15);
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
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 45, 30, 15, 15);
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
