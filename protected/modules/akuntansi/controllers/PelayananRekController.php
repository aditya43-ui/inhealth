<?php
class PelayananRekController extends MyAuthController
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
  public function actionView($id, $ruangan_id)
  {
    if (!empty($ruangan_id)) {
      $model = PelayananrekM::model()->findByAttributes(array('daftartindakan_id' => $id, 'ruangan_id' => $ruangan_id));
    } else {
      $model = PelayananrekM::model()->findByAttributes(array('daftartindakan_id' => $id));
    }

    $this->render('view', array(
      'model' => $model,
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = new PelayananrekM();

    $modTindakanRuangan = new TindakanruanganM;

    if (isset($_GET['TindakanruanganM'])) {
      $modTindakanRuangan->attributes = $_GET['TindakanruanganM'];
      $modTindakanRuangan->kategoritindakan_id = isset($_GET['TindakanruanganM']['kategoritindakan_id']) ? $_GET['TindakanruanganM']['kategoritindakan_id'] : null;
      $modTindakanRuangan->kategoritindakan_nama = $_GET['kategoritindakan_nama'];
      $modTindakanRuangan->daftartindakan_kode = $_GET['daftartindakan_kode'];
      $modTindakanRuangan->daftartindakan_nama = $_GET['nama_pelayanan'];
      $modTindakanRuangan->ruangan_nama = $_GET['TindakanruanganM']['ruangan_nama'];
      // var_dump($_GET['nama_pelayanan']);
      // exit;
    }

    if (isset($_POST['PelayananrekM']) && isset($_POST['AKTindakanRuanganM'])) {
      $rekening = $_POST['PelayananrekM'];
      $ruangan = $_POST['AKTindakanRuanganM'];

      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modDetails = $this->validasiTabular($rekening, $ruangan);
        foreach ($modDetails as $j => $data) {
          $komponentarif_id = $this->getKomponenTarif($data->daftartindakan_id);
          if ($komponentarif_id) {
            $data->komponentarif_id = $komponentarif_id;
            if ($data->save()) {
              $berhasil = true;
            } else {
              $berhasil = false;
            }
          } else {
            $pesan = "tindakan " . '"' . $data->daftartindakan->daftartindakan_nama . '"' . " tidak memiliki tarif";
            $berhasil = false;
          }
        }
        if ($berhasil == true) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('admin', 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan, " . $pesan);
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }


    $this->render('create', array(
      'model' => $model, 'modTindakanRuangan' => $modTindakanRuangan
    ));
  }

  protected function validasiTabular($data1, $data2)
  {
    $x = 0;
    $xx = 0;
    foreach ($data1['rekening'] as $i => $row) {
      foreach ($data2['tindakan'] as $key => $datas) {
        if (count((array)$datas) > 1) { // jika kondisi ruangan sama
          foreach ($datas as $iii => $vvv) {
            $modDetails[$xx] = new PelayananrekM;
            $modDetails[$xx]->attributes = $row;
            $modDetails[$xx]->ruangan_id = $key;
            $modDetails[$xx]->rekening1_id     = $row['rekening_id1'];
            $modDetails[$xx]->rekening2_id     = $row['rekening_id2'];
            $modDetails[$xx]->rekening3_id     = $row['rekening_id3'];
            $modDetails[$xx]->rekening4_id     = $row['rekening_id4'];
            $modDetails[$xx]->rekening5_id     = $row['rekening_id5'];
            $modDetails[$xx]->saldonormal     = $row['saldonormal'];
            $modDetails[$xx]->jnspelayanan     = $data1['jnspelayanan'];
            $modDetails[$xx]->validate();
            $modDetails[$xx]->daftartindakan_id = $iii;
            $xx++;
            $x++;
          }
        } else {
          $modDetails[$x] = new PelayananrekM;
          $modDetails[$x]->attributes = $row;
          $modDetails[$x]->ruangan_id = $key;
          $modDetails[$x]->rekening1_id     = $row['rekening_id1'];
          $modDetails[$x]->rekening2_id     = $row['rekening_id2'];
          $modDetails[$x]->rekening3_id     = $row['rekening_id3'];
          $modDetails[$x]->rekening4_id     = $row['rekening_id4'];
          $modDetails[$x]->rekening5_id     = $row['rekening_id5'];
          $modDetails[$x]->saldonormal     = $row['saldonormal'];
          $modDetails[$x]->jnspelayanan     = $data1['jnspelayanan'];
          $modDetails[$x]->validate();

          foreach ($datas as $tindakan_id => $tind_id) {
            $modDetails[$x]->daftartindakan_id   = $tindakan_id;
          }
        }
        $x++;
      }
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
    $model = AKPenjaminpasienM::model()->findByPk($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['AKPenjaminpasienM'])) {
      $model->attributes = $_POST['AKPenjaminpasienM'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('admin', 'id' => $model->penjamin_id));
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
  public function actionDelete($id, $ruangan_id)
  {
    // var_dump($ruangan_id);
    // exit;	
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
      //$model=AKPenjaminpasienM::model()->findByPk($id)->delete();
      if (!empty($ruangan_id)) {
        $model = AKPelayananRekM::model()->deleteAll('daftartindakan_id=:daftartindakan_id AND ruangan_id=:ruangan_id', array(':daftartindakan_id' => $id, ':ruangan_id' => $ruangan_id));
      } else {
        $model = AKPelayananRekM::model()->deleteAll('daftartindakan_id=:daftartindakan_id', array(':daftartindakan_id' => $id));
      }

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
    $dataProvider = new CActiveDataProvider('AKPenjaminpasienM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new AKPelayananRekM();
    $model->unsetAttributes();

    if (isset($_GET['AKPelayananRekM'])) {
      $model->attributes = $_GET['AKPelayananRekM'];
      $model->ruanganNama = $_GET['AKPelayananRekM']['ruanganNama'];
      $model->daftartindakan_nama = $_GET['AKPelayananRekM']['daftartindakan_nama'];
      $model->rekDebit = $_GET['AKPelayananRekM']['rekDebit'];
      $model->rekKredit = $_GET['AKPelayananRekM']['rekKredit'];
    }

    $this->render('admin', array(
      'model' => $model,
    ));
  }

  public function actionUbahRekeningDebit($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $this->layout = '//layouts/iframe';
    $model = PelayananrekM::model()->findByPk($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['PelayananrekM'])) {
      $model->attributes = $_POST['PelayananrekM'];
      $view = 'UbahRekeningDebit';

      $update = PelayananrekM::model()->updateByPk($id, array(
        'rekening5_id' => $_POST['PelayananrekM']['rekening5_id'],
        'rekening4_id' => $_POST['PelayananrekM']['rekening4_id'],
        'rekening3_id' => $_POST['PelayananrekM']['rekening3_id'],
        'rekening2_id' => $_POST['PelayananrekM']['rekening2_id'],
        'rekening1_id' => $_POST['PelayananrekM']['rekening1_id']
      ));
      if ($update) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        if (isset($_GET['frame']) && !empty($_GET['idPenerimaan'])) {
          $this->redirect(array(((isset($view)) ? $view : 'UbahRekeningDebit'), 'id' => $model->jnspenerimaanrek_id, 'frame' => $_GET['frame'], 'idPenerimaan' => $_GET['idPenerimaan']));
        } else {
          $this->redirect(array(((isset($view)) ? $view : 'admin'), 'id' => $model->jenispenerimaan_id));
        }
      }
    }

    $this->render(((isset($view)) ? $view : '_ubahRekeningDebit'), array(
      'model' => $model,
    ));
  }

  public function actionUbahRekeningKredit($id)
  {
    //				$this->layout = '//layouts/iframe';
    //                $model= PelayananrekM::model()->findByPk($id);
    //                if(!empty($model->rekening1_id)){ $rek1 = $model->rekening1_id; } else { $rek1=''; }
    //                if(!empty($model->rekening2_id)){ $rek2 = $model->rekening2_id; } else { $rek2=''; }
    //                if(!empty($model->rekening3_id)){ $rek3 = $model->rekening3_id; } else { $rek3=''; }
    //                if(!empty($model->rekening4_id)){ $rek4 = $model->rekening4_id; } else { $rek4=''; }
    //                if(!empty($model->rekening5_id)){ $rek5 = $model->rekening5_id; } else { $rek5=''; }
    //                $rekDebit = RekeningakuntansiV::model()->findByAttributes(array('struktur_id'=>$rek1, 'kelompok_id'=>$rek2, 'jenis_id'=>$rek3, 'obyek_id'=>$rek4, 'rincianobyek_id'=>$rek5));
    //                $model->rekeningnama = $rekDebit->nmobyek;
    //
    //		$this->render('_ubahRekeningKredit',array(
    //			'model'=>$model,
    //                        'modPenjamin'=>$modPenjamin
    //		));
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $this->layout = '//layouts/iframe';
    $model = PelayananrekM::model()->findByPk($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['PelayananrekM'])) {
      $model->attributes = $_POST['PelayananrekM'];
      $view = 'UbahRekeningKredit';

      $update = PelayananrekM::model()->updateByPk($id, array(
        'rekening5_id' => $_POST['PelayananrekM']['rekening5_id'],
        'rekening4_id' => $_POST['PelayananrekM']['rekening4_id'],
        'rekening3_id' => $_POST['PelayananrekM']['rekening3_id'],
        'rekening2_id' => $_POST['PelayananrekM']['rekening2_id'],
        'rekening1_id' => $_POST['PelayananrekM']['rekening1_id']
      ));
      if ($update) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        if (isset($_GET['frame']) && !empty($_GET['idPenerimaan'])) {
          $this->redirect(array(((isset($view)) ? $view : 'UbahRekeningKredit'), 'id' => $model->jnspenerimaanrek_id, 'frame' => $_GET['frame'], 'idPenerimaan' => $_GET['idPenerimaan']));
        } else {
          $this->redirect(array(((isset($view)) ? $view : 'admin'), 'id' => $model->jenispenerimaan_id));
        }
      }
    }

    $this->render(((isset($view)) ? $view : '_ubahRekeningKredit'), array(
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
    $model = AKPenjaminpasienM::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  public function loadDelete($id)
  {
    $model = AKPenjaminpasienM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'penjaminpasien-m-form') {
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
    AKPenjaminpasienM::model()->updateByPk($id, array('penjamin_aktif ' => false));
    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function actionPrint()
  {
    $model = new AKPelayananRekM;
    if (isset($_REQUEST['AKPelayananRekM'])) {
      $model->attributes = $_REQUEST['AKPelayananRekM'];
    }
    $judulLaporan = 'Data Pelayanan Rekening ';
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

  function getKomponenTarif($daftartindakan_id)
  {
    $modKomponenTarif = TariftindakanM::model()->findByAttributes(array('daftartindakan_id' => $daftartindakan_id));
    if (!empty($modKomponenTarif)) {
      return $modKomponenTarif->komponentarif_id;
    } else {
      return false;
    }
  }

  public function actionGetRekeningEditDebitPelayananRek()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $rekening1_id = $_POST['rekening1_id'];
      $rekening2_id = $_POST['rekening2_id'];
      $rekening3_id = $_POST['rekening3_id'];
      $rekening4_id = $_POST['rekening4_id'];
      $rekening5_id = $_POST['rekening5_id'];

      $pelayananrek_id = $_POST['pelayananrek_id'];

      $update = AKPelayananRekM::model()->updateByPk($pelayananrek_id, array(
        'rekening1_id' => $rekening1_id,
        'rekening2_id' => $rekening2_id,
        'rekening3_id' => $rekening3_id,
        'rekening4_id' => $rekening4_id,
        'rekening5_id' => $rekening5_id
      ));
      if ($update) {
        $data['pesan'] = '<div class="flash-success">Ubah Data Rekening <b></b> Berhasil  Disimpan </div>';
      } else {
        $data['pesan'] = '<div class="flash-error">Ubah Data Rekening <b></b> Gagal  Disimpan </div>';
      }

      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
