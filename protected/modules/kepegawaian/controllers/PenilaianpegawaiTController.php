<?php

class PenilaianpegawaiTController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  protected $path_view = 'kepegawaian.views.penilaianpegawaiT.';

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

    $model = new KPPenilaianpegawaiT;
    $model->tglpenilaian = date('Y-m-d H:i:s');
    $model->periodepenilaian = date('Y-m-d H:i:s');
    $model->sampaidengan = date('Y-m-d H:i:s');
    $model->kejujuran = 0;
    $model->ketaatan = 0;
    $model->jumlahpenilaian = 0;
    $model->nilairatapenilaian = 0;
    $model->performanceindex = 0;
    $model->kesetiaan = 0;
    $model->prestasikerja = 0;
    $model->tanggungjawab = 0;
    $model->kerjasama = 0;
    $model->prakarsa = 0;
    $model->kepemimpinan = 0;
    $modPegawai = new KPRegistrasifingerprint;

    if (!empty($id)) {
      $modPegawai = KPPegawaiM::model()->findByPk($id);
      $modPegawai->jabatan_id = (isset($modPegawai->jabatan_id) ? $modPegawai->jabatan_id : null);
      $modPegawai->jabatan_nama = (isset($modPegawai->jabatan_id) ? $modPegawai->jabatan->jabatan_nama : "-");
      $modPegawai->pangkat_id = (isset($modPegawai->pangkat_id) ? $modPegawai->pangkat_id : null);
      $modPegawai->pangkat_nama = (isset($modPegawai->pangkat_id) ? $modPegawai->pangkat->pangkat_nama : "-");
      $modPegawai->kelompokpegawai_id = (isset($modPegawai->kelompokpegawai_id) ? $modPegawai->kelompokpegawai_id : null);
      $modPegawai->kelompokpegawai_nama = (isset($modPegawai->kelompokpegawai_id) ? $modPegawai->kelompokpegawai->kelompokpegawai_nama : "-");
      $modPegawai->pendidikan_id = (isset($modPegawai->pendidikan_id) ? $modPegawai->pendidikan_id : null);
      $modPegawai->pendidikan_nama = (isset($modPegawai->pendidikan_id) ? $modPegawai->pendidikan->pendidikan_nama : "-");

      $model = PenilaianpegawaiT::model()->find('pegawai_id = ' . $modPegawai->pegawai_id . ' ORDER BY penilaianpegawai_id DESC');
    }

    if (isset($_POST['KPPenilaianpegawaiT'])) {
      $model->attributes = $_POST['KPPenilaianpegawaiT'];
      $model->pegawai_id = $_POST['KPRegistrasifingerprint']['pegawai_id'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', 'Data ' . $model->pegawai->nama_pegawai . ' berhasil disimpan.');
        // $this->refresh();
        $this->redirect(array('create', 'id' => $model->pegawai_id, 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
      }
    }

    $this->render('create', array(
      'modPegawai' => $modPegawai,
      'model' => $model,
      'namapegawai' => ''
    ));
  }

  public function actionPenilaian($id)
  {
    if (!empty($id)) {
      $modPegawai = KPPegawaiM::model()->findByPk($id);
      $modPegawai->jabatan_id = (isset($modPegawai->jabatan_id) ? $modPegawai->jabatan_id : null);
      $modPegawai->jabatan_nama = (isset($modPegawai->jabatan_id) ? $modPegawai->jabatan->jabatan_nama : "-");
      $modPegawai->pangkat_id = (isset($modPegawai->pangkat_id) ? $modPegawai->pangkat_id : null);
      $modPegawai->pangkat_nama = (isset($modPegawai->pangkat_id) ? $modPegawai->pangkat->pangkat_nama : "-");
      $modPegawai->kelompokpegawai_id = (isset($modPegawai->kelompokpegawai_id) ? $modPegawai->kelompokpegawai_id : null);
      $modPegawai->kelompokpegawai_nama = (isset($modPegawai->kelompokpegawai_id) ? $modPegawai->kelompokpegawai->kelompokpegawai_nama : "-");
      $modPegawai->pendidikan_id = (isset($modPegawai->pendidikan_id) ? $modPegawai->pendidikan_id : null);
      $modPegawai->pendidikan_nama = (isset($modPegawai->pendidikan_id) ? $modPegawai->pendidikan->pendidikan_nama : "-");

      $model = PenilaianpegawaiT::model()->find('pegawai_id = ' . $modPegawai->pegawai_id . ' ORDER BY penilaianpegawai_id DESC');
    }

    if (empty($model)) {
      $model = new PenilaianpegawaiT;
      $model->tglpenilaian = date('d M Y H:i:s');
      $model->periodepenilaian = date('d M Y H:i:s');
      $model->sampaidengan = date('d M Y H:i:s');
      //                $model->kejujuran = 0;
      //                $model->ketaatan = 0;
      $model->jumlahpenilaian = 0;
      $model->nilairatapenilaian = 0;
      $model->performanceindex = 0;
      //                $model->kesetiaan = 0;
      //                $model->prestasikerja = 0;
      //                $model->tanggungjawab = 0;
      //                $model->kerjasama = 0;
      //                $model->prakarsa = 0;
      //                $model->kepemimpinan = 0;

      if (isset($_POST['PenilaianpegawaiT'])) {
        $model->attributes = $_POST['PenilaianpegawaiT'];
        $model->pegawai_id = $_POST['KPPegawaiM']['pegawai_id'];


        $format = new MyFormatter();
        $model->tglpenilaian = $format->formatDateTimeForDb($_POST['PenilaianpegawaiT']['tglpenilaian']);
        $model->periodepenilaian = $format->formatDateTimeForDb($_POST['PenilaianpegawaiT']['periodepenilaian']);
        $model->sampaidengan = $format->formatDateTimeForDb($_POST['PenilaianpegawaiT']['sampaidengan']);
        $model->tanggal_keberatanpegawai = $format->formatDateTimeForDb($_POST['PenilaianpegawaiT']['tanggal_keberatanpegawai']);
        $model->tanggal_tanggapanpejabat = $format->formatDateTimeForDb($_POST['PenilaianpegawaiT']['tanggal_tanggapanpejabat']);
        $model->tanggal_keputusanatasan = $format->formatDateTimeForDb($_POST['PenilaianpegawaiT']['tanggal_keputusanatasan']);
        $model->diterimatanggalpegawai = $format->formatDateTimeForDb($_POST['PenilaianpegawaiT']['diterimatanggalpegawai']);
        $model->diterimatanggalatasan = $format->formatDateTimeForDb($_POST['PenilaianpegawaiT']['diterimatanggalatasan']);


        if ($model->save()) {
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('penilaian', 'id' => $model->pegawai_id, 'sukses' => 1));
        } else {
          Yii::app()->user->setFlash('error', '<strong>Gagal !</strong> Data gagal disimpan.');
        }
      }
    } else {
      if (isset($_POST['PenilaianpegawaiT'])) {
        $model->attributes = $_POST['PenilaianpegawaiT'];


        $format = new MyFormatter();
        $model->tglpenilaian = $format->formatDateTimeForDb($_POST['PenilaianpegawaiT']['tglpenilaian']);
        $model->periodepenilaian = $format->formatDateTimeForDb($_POST['PenilaianpegawaiT']['periodepenilaian']);
        $model->sampaidengan = $format->formatDateTimeForDb($_POST['PenilaianpegawaiT']['sampaidengan']);
        $model->tanggal_keberatanpegawai = $format->formatDateTimeForDb($_POST['PenilaianpegawaiT']['tanggal_keberatanpegawai']);
        $model->tanggal_tanggapanpejabat = $format->formatDateTimeForDb($_POST['PenilaianpegawaiT']['tanggal_tanggapanpejabat']);
        $model->tanggal_keputusanatasan = $format->formatDateTimeForDb($_POST['PenilaianpegawaiT']['tanggal_keputusanatasan']);
        $model->diterimatanggalpegawai = $format->formatDateTimeForDb($_POST['PenilaianpegawaiT']['diterimatanggalpegawai']);
        $model->diterimatanggalatasan = $format->formatDateTimeForDb($_POST['PenilaianpegawaiT']['diterimatanggalatasan']);


        if ($model->save()) {
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('penilaian', 'id' => $model->pegawai_id, 'sukses' => 1));
        } else {
          Yii::app()->user->setFlash('error', '<strong>Gagal !</strong> Data gagal disimpan.');
        }
      }
    }


    $this->render('create', array(
      'modPegawai' => $modPegawai,
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

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['KPPenilaianpegawaiT'])) {
      $model->attributes = $_POST['KPPenilaianpegawaiT'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->refresh();
        //				$this->redirect(array('create'));
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
    $dataProvider = new CActiveDataProvider('KPPenilaianpegawaiT');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new KPPenilaianpegawaiT('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['KPPenilaianpegawaiT']))
      $model->attributes = $_GET['KPPenilaianpegawaiT'];

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
    $model = KPPenilaianpegawaiT::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'kppenilaianpegawai-t-form') {
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


  public function actionGetDataPegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data = PegawaiM::model()->findByAttributes(array('pegawai_id' => $_POST['idPegawai']));
      $post = array(
        'nomorindukpegawai' => $data->nomorindukpegawai,
        'pegawai_id' => $data->pegawai_id,
        'nama_pegawai' => $data->nama_pegawai,
        'tempatlahir_pegawai' => $data->tempatlahir_pegawai,
        'tgl_lahirpegawai' => $data->tgl_lahirpegawai,
        'jabatan_id' => (isset($data->jabatan->jabatan_id) ? $data->jabatan->jabatan_id : ''),
        'jabatan_nama' => (isset($data->jabatan->jabatan_nama) ? $data->jabatan->jabatan_nama : ''),
        'pangkat_id' => (isset($data->pangkat->pangkat_id) ? $data->pangkat->pangkat_id : ''),
        'pangkat_nama' => (isset($data->pangkat->pangkat_nama) ? $data->pangkat->pangkat_nama : ''),
        'kategoripegawai' => $data->kategoripegawai,
        'kategoripegawaiasal' => $data->kategoripegawaiasal,
        'kelompokpegawai_id' => (isset($data->kelompokpegawai->kelompokpegawai_id) ? $data->kelompokpegawai->kelompokpegawai_id : ''),
        'kelompokpegawai_nama' => (isset($data->kelompokpegawai->kelompokpegawai_nama) ? $data->kelompokpegawai->kelompokpegawai_nama : ''),
        'pendidikan_id' => (isset($data->pendidikan->pendidikan_id) ? $data->pendidikan->pendidikan_id : ''),
        'pendidikan_nama' => (isset($data->pendidikan->pendidikan_nama) ? $data->pendidikan->pendidikan_nama : ''),
        'jeniskelamin' => $data->jeniskelamin,
        'statusperkawinan' => $data->statusperkawinan,
        'alamat_pegawai' => $data->alamat_pegawai,
        'photopegawai' => (!is_null($data->photopegawai) ? $data->photopegawai : ''),
      );
      echo CJSON::encode($post);
      Yii::app()->end();
    }
  }

  public function actionPrint()
  {
    $model = new KPPenilaianpegawaiT;
    $model->attributes = $_REQUEST['KPPenilaianpegawaiT'];
    $judulLaporan = 'Data KPPenilaianpegawaiT';
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

  public function actionGetPegawai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = PegawaiM::model()->findAll($criteria);

      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nama_pegawai;
        $returnVal[$i]['value'] = $model->pegawai_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionPegawairiwayat()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nama_pegawai';
      $criteria->limit = 5;
      $models = PegawaiM::model()->findAll($criteria);

      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nomorindukpegawai . ' - ' . $model->nama_pegawai . ' - ' . $model->jeniskelamin;
        $returnVal[$i]['nama_pegawai'] = $model->nama_pegawai;
        $returnVal[$i]['value'] = $model->pegawai_id;
        $returnVal[$i]['jabatan_nama'] = (isset($model->jabatan->jabatan_nama) ? $model->jabatan->jabatan_nama : '-');
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionPegawairiwayatNip()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nomorindukpegawai)', strtolower($_GET['term']), true);
      $criteria->order = 'nomorindukpegawai';
      $criteria->limit = 5;
      $models = PegawaiM::model()->findAll($criteria);

      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nomorindukpegawai . ' - ' . $model->nama_pegawai . ' - ' . $model->jeniskelamin;
        $returnVal[$i]['nama_pegawai'] = $model->nama_pegawai;
        $returnVal[$i]['value'] = $model->pegawai_id;
        $returnVal[$i]['jabatan_nama'] = (isset($model->jabatan->jabatan_nama) ? $model->jabatan->jabatan_nama : '-');
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }


  public function actionPrintDetailPenilaian($penilaianpegawai_id = null)
  {
    $model = PenilaianpegawaiT::model()->findByPk($penilaianpegawai_id);
    $modelpegawai = PegawaiM::model()->findByPk($model->pegawai_id);
    if (isset($_REQUEST['KPRegistrasifingerprint'])) {
      $modelpegawai->attributes = $_REQUEST['KPRegistrasifingerprint'];
      $modelpegawai->pegawai_id = $_REQUEST['KPRegistrasifingerprint']['pegawai_id'];
      if ($_REQUEST['KPRegistrasifingerprint']['pangkat_id'] == "") {
        $modelpegawai->pangkat_id = 0;
      }
      if ($_REQUEST['KPRegistrasifingerprint']['jabatan_id'] == "") {
        $modelpegawai->jabatan_id = 0;
      }
      if ($_REQUEST['KPRegistrasifingerprint']['pendidikan_id'] == "") {
        $modelpegawai->pendidikan_id = 0;
      }
    }
    if (empty($model)) {
      $model = new PenilaianpegawaiT;
    }

    $judulLaporan = 'Penilaian Pegawai';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'PrintPenilaian', array('model' => $model, 'modelpegawai' => $modelpegawai, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'PrintPenilaian', array('model' => $model, 'modelpegawai' => $modelpegawai, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'PrintPenilaian', array('model' => $model, 'modelpegawai' => $modelpegawai, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
