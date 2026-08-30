
<?php

class PasiennapzaTController extends MyAuthController
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

    $model = new RJPasiennapzaT;
    $modNapza = new LookupM;
    $modPasien = new RJInfokunjunganrjV();
    $modPeriksaFisik = new RJPemeriksaanFisikT();
    $modAnamnesa = new RJAnamnesaT();

    $model->tglperiksanapza = date('Y-m-d H:i:s');
    $modPasien->tgl_awal = date('Y-m-d 00:00:00');
    $modPasien->tgl_akhir = date('Y-m-d 23:59:59');
    $modPasien->ruangan_id = Yii::app()->user->getState('ruangan_id');

    $criteria = new CDbCriteria();
    $criteria->select = 'pendaftaran_id';
    $criteria->addCondition('ruangan_id = ' . Yii::app()->user->getState('ruangan_id'));
    $pendaftaran = PendaftaranT::model()->findAll($criteria);
    $jmlKunjungan = count((array)$pendaftaran);
    $model->jml_kunjungan = $jmlKunjungan;

    if (!empty($id)) {
      $model = RJPasiennapzaT::model()->findByPk($id);
      $model->paramedis_nama = (isset($model->paramedis->NamaLengkap) ? $model->paramedis->NamaLengkap : null);
      $model->jml_kunjungan = $model->kunjunganke;
      $modPasien = RJInfokunjunganrjV::model()->findByAttributes(array('pendaftaran_id' => $model->pendaftaran_id));
    }
    // $criteria = new CDbCriteria();
    // $criteria->select="lookup_id";
    // $lookup = LookupM::modMetodenapza()->findAll($criteria);
    // $napza = $lookup."where lookup_type like '%metodenapza%'";

    if (isset($_POST['RJPasiennapzaT'])) {
      $model->attributes = $_POST['RJPasiennapzaT'];
      $model->kunjunganke = $_POST['RJPasiennapzaT']['jml_kunjungan'];
      $model->dokter_id = $_POST['RJPasiennapzaT']['pegawai_id'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('create', 'id' => $model->pasiennapza_id));
      }
    }

    $this->render('create', array(
      'model' => $model,
      'modPasien' => $modPasien,
      'modPeriksaFisik' => $modPeriksaFisik,
      'modAnamnesa' => $modAnamnesa
    ));
  }

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {

    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['RJPasiennapzaT'])) {
      $model->attributes = $_POST['RJPasiennapzaT'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->pasiennapza_id));
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
    $dataProvider = new CActiveDataProvider('RJPasiennapzaT');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new RJPasiennapzaT('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['RJPasiennapzaT']))
      $model->attributes = $_GET['RJPasiennapzaT'];

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
    $model = RJPasiennapzaT::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'rjpasiennapza-t-form') {
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
    $model = new RJPasiennapzaT;
    $model->attributes = $_REQUEST['RJPasiennapzaT'];
    $judulLaporan = 'Data RJPasiennapzaT';
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

  /**
   * Mengurai data kunjungan berdasarkan:
   * - pendaftaran_id
   * - pasienadmisi_id
   * - no_pendaftaran
   * - no_rekam_medik
   * @throws CHttpException
   */
  public function actionGetDataKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $pendaftaran_id = isset($_POST['pendaftaran_id']) ? $_POST['pendaftaran_id'] : null;
      $no_pendaftaran = isset($_POST['no_pendaftaran']) ? $_POST['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_POST['no_rekam_medik']) ? $_POST['no_rekam_medik'] : null;
      $returnVal = array();
      $criteria = new CDbCriteria();
      if (!empty($pendaftaran_id)) {
        $criteria->addCondition("pendaftaran_id = " . $pendaftaran_id);
      }
      $criteria->compare('LOWER(no_pendaftaran)', strtolower(trim($no_pendaftaran)));
      $criteria->compare('LOWER(no_rekam_medik)', strtolower(trim($no_rekam_medik)));
      $model = RJInfokunjunganrjV::model()->find($criteria);

      $attributes = $model->attributeNames();
      foreach ($attributes as $j => $attribute) {
        $returnVal["$attribute"] = $model->$attribute;
      }
      if (!empty($model->pasienadmisi_id)) { //replace dgn admisi
        $returnVal["instalasi_id"] = $model->instalasiadmisi_id;
        $returnVal["ruangan_id"] = $model->ruanganadmisi_id;
        $returnVal["kelaspelayanan_id"] = $model->kelaspelayananadmisi_id;
        $returnVal["carabayar_id"] = $model->carabayaradmisi_id;
        $returnVal["penjamin_id"] = $model->penjaminadmisi_id;
        $returnVal["ruangan_nama"] = $model->ruanganadmisi_nama;
        $returnVal["kelaspelayanan_nama"] = $model->kelaspelayananadmisi_nama;
        $returnVal["carabayar_nama"] = $model->carabayaradmisi_nama;
        $returnVal["penjamin_nama"] = $model->penjaminadmisi_nama;
      }
      $returnVal["tanggal_lahir"] = $format->formatDateTimeForUser($model->tanggal_lahir);
      $returnVal["tgl_pendaftaran"] = $format->formatDateTimeForUser($model->tgl_pendaftaran);
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
  /**
   * untuk menampilkan data kunjungan dari autocomplete
   * - no_pendaftaran
   * - no_rekam_medik
   * - nama_pasien
   */
  public function actionAutocompleteKunjungan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $no_pendaftaran = isset($_GET['no_pendaftaran']) ? $_GET['no_pendaftaran'] : null;
      $no_rekam_medik = isset($_GET['no_rekam_medik']) ? $_GET['no_rekam_medik'] : null;
      $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(no_pendaftaran)', strtolower($no_pendaftaran), true);
      $criteria->compare('LOWER(no_rekam_medik)', strtolower($no_rekam_medik), true);
      $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
      $criteria->order = 'no_pendaftaran, no_rekam_medik, nama_pasien';
      $criteria->limit = 5;
      $models = RJInfokunjunganrjV::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->no_pendaftaran . ' - ' . $model->no_rekam_medik . ' - ' . $model->nama_pasien . (!empty($model->nama_bin) ? "(" . $model->nama_bin . ")" : "");
        $returnVal[$i]['value'] = $model->no_pendaftaran;
        $returnVal[$i]['pasienadmisi_id'] = isset($model->pasienadmisi_id) ? $model->pasienadmisi_id : '';
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
  /**
   * untuk autocomplete dokter
   */
  public function actionAutocompleteDokter()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      if (isset($_GET['term'])) {
        $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      }
      $criteria->order = 'nama_pegawai';
      if (isset($_GET['idPegawai'])) {
        if (!empty($_GET['idPegawai'])) {
          $criteria->addCondition("pegawai_id = " . $_GET['idPegawai']);
        }
      }
      $criteria->limit = 5;
      $models = DokterpegawaiV::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
        $returnVal[$i]['paramedis_nama'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
        $returnVal[$i]['paramedis_id'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * untuk autocomplete dokter
   */
  public function actionAutocompleteParamedis()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      if (isset($_GET['term'])) {
        $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      }
      $criteria->order = 'nama_pegawai';
      if (isset($_GET['idPegawai'])) {
        if (!empty($_GET['idPegawai'])) {
          $criteria->addCondition("pegawai_id = " . $_GET['idPegawai']);
        }
      }
      $criteria->limit = 5;
      $models = PegawaiV::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
        $returnVal[$i]['value'] = $model->pegawai_id;
        $returnVal[$i]['paramedis_nama'] = $model->gelardepan . " " . $model->nama_pegawai . ", " . $model->gelarbelakang_nama;
        $returnVal[$i]['paramedis_id'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
