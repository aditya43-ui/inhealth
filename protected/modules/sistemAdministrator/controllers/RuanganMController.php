<?php

/**
 * Digunakan untuk mengakses halaman Master Ruangan
 * @author  Deni Hamdani <denihamdani@piindonesia.co.id>
 * @package application.modules.sistemAdministrator
 * @subpackage controllers
 */
class RuanganMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';

  /**
   * Fungsi menambah pegawai ruangan
   */

   public function actionAddTindakan()
   {
     if (Yii::app()->request->isAjaxRequest) {
       $daftartindakan_id = isset($_POST['daftartindakan_id']) ? $_POST['daftartindakan_id'] : null;
       $daftartindakan_nama = isset($_POST['daftartindakan_nama']) ? $_POST['daftartindakan_nama'] : null;
      $i=0;
       $det = new SADaftarTindakanM();
       $det->daftartindakan_id = $daftartindakan_id;
       $det->daftartindakan_nama = $daftartindakan_nama;
 
       $sukses = 1;
       $tr = $this->renderPartial("_formTindakan", array('det' => $det, 'i' => 0), true);
       echo json_encode(array('tr' => $tr, 'suskes' => $sukses));
     }
   }

   public function actionAddPegawai()
   {
     if (Yii::app()->request->isAjaxRequest) {
       $pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null;
       $nama_pegawai = isset($_POST['nama_pegawai']) ? $_POST['nama_pegawai'] : null;
 
       $det = new SAPegawaiM();
       $det->pegawai_id = $pegawai_id;
       $det->nama_pegawai = $nama_pegawai;
 
       $sukses = 1;
       $tr = $this->renderPartial("_formPegawai", array('det' => $det, 'i' => 0), true);
 
       echo json_encode(array('tr' => $tr, 'suskes' => $sukses));
     }
   }


   public function actionCreatePegawaiRuangan()
  {
    $model = new RuanganpegawaiM;
    if (isset($_POST['RuanganpegawaiM'])) {

      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlahRuanganPegawai = isset($_POST['pegawai_id']) ? count((array)$_POST['pegawai_id']) : 0;
        $ruangan_id = $_POST['RuanganpegawaiM']['ruangan_id'];
        $hapusTindakanRuangan = RuanganpegawaiM::model()->deleteAll('ruangan_id=' . $ruangan_id . '');
        for ($i = 0; $i < $jumlahRuanganPegawai; $i++) {
          $modRuanganPegawai = new RuanganpegawaiM;
          $modRuanganPegawai->ruangan_id = $ruangan_id;
          $modRuanganPegawai->pegawai_id = $_POST['pegawai_id'][$i];
          $modRuanganPegawai->save();
        }

        Yii::app()->user->setFlash('success', "Data Ruangan Dan Pegawai Berhasil Disimpan");
        $transaction->commit();
        $this->redirect(array('admin'));
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Ruangan Dan Pegawai Gagal Disimpan");
      }
    }
    $this->render('createRuanganPegawai', array(
      'model' => $model
    ));
  }

  /**
   * Fungsi untuk menambah daftar tindakan ruangan
   */
  public function actionCreateDaftarTindakan()
  {
    $model = new TindakanruanganM;
    if (isset($_POST['TindakanruanganM'])) {

      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlahTindakanRuangan = isset($_POST['daftartindakan_id']) ? count((array)$_POST['daftartindakan_id']) : 0;
        $ruangan_id = $_POST['TindakanruanganM']['ruangan_id'];
        $hapusTindakanRuangan = TindakanruanganM::model()->deleteAll('ruangan_id=' . $ruangan_id . '');
        for ($i = 0; $i <= $jumlahTindakanRuangan; $i++) {
          $modTindakanRuangan = new TindakanruanganM;
          $modTindakanRuangan->ruangan_id = $ruangan_id;
          $modTindakanRuangan->daftartindakan_id = $_POST['daftartindakan_id'][$i];
          $modTindakanRuangan->save();
        }

        Yii::app()->user->setFlash('success', "Data Ruangan Dan Kelas Ruangan Berhasil Disimpan");
        $transaction->commit();
        $this->redirect(array('admin'));
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Ruangan Dan Kelas Ruangan Gagal Disimpan");
      }
    }
    $this->render('createTindakanRuangan', array(
      'model' => $model
    ));
  }

  /**
   * Fungsi untuk menambah kelas ruangan
   */
  public function actionCreateKelasRuangan()
  {
    $model = new KelasruanganM;
    if (isset($_POST['KelasruanganM'])) {

      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlahKelasPelayanan = isset($_POST['kelaspelayanan_id']) ? count((array)$_POST['kelaspelayanan_id']) : 0;
        $ruangan_id = $_POST['KelasruanganM']['ruangan_id'];
        $hapuskelasRuangan = KelasruanganM::model()->deleteAll('ruangan_id=' . $ruangan_id . '');
        for ($i = 0; $i <= $jumlahKelasPelayanan; $i++) {
          $modKasusRuangan = new KelasruanganM;
          $modKasusRuangan->ruangan_id = $ruangan_id;
          $modKasusRuangan->kelaspelayanan_id = $_POST['kelaspelayanan_id'][$i];
          $modKasusRuangan->save();
        }

        Yii::app()->user->setFlash('success', "Data Ruangan Dan Kelas Ruangan Berhasil Disimpan");
        $transaction->commit();
        $this->redirect(array('admin'));
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Ruangan Dan Kelas Ruangan Gagal Disimpan");
      }
    }
    $this->render('createKelasRuangan', array(
      'model' => $model
    ));
  }

  /**
   * Fungsi untuk menambah jenis kasus penyakit ruangan
   */
  public function actionCreateJenisKasusPenyakit()
  {
    $model = new KasuspenyakitruanganM;
    if (isset($_POST['KasuspenyakitruanganM'])) {

      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlahJenisKasusPenyakit = isset($_POST['jeniskasuspenyakit_id']) ? count((array)$_POST['jeniskasuspenyakit_id']) : 0;
        $ruangan_id = $_POST['KasuspenyakitruanganM']['ruangan_id'];
        $hapusKasusPenyakitRuangan = KasuspenyakitruanganM::model()->deleteAll('ruangan_id=' . $ruangan_id . '');
        for ($i = 0; $i <= $jumlahJenisKasusPenyakit; $i++) {
          $modKasusRuangan = new KasuspenyakitruanganM;
          $modKasusRuangan->ruangan_id = $ruangan_id;
          $modKasusRuangan->jeniskasuspenyakit_id = $_POST['jeniskasuspenyakit_id'][$i];
          $modKasusRuangan->save();
        }

        Yii::app()->user->setFlash('success', "Data Ruangan Dan Jenis Kasus Penyakit Berhasil Disimpan");
        $transaction->commit();
        $this->redirect(array('admin'));
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Ruangan Dan Jenis Kasus Penyakit Gagal Disimpan");
      }
    }
    $this->render('createJenisKasusPenyakit', array(
      'model' => $model
    ));
  }

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $modKasusPenyakitRuangan = array();
    $this->render('view', array(
      'model' => $this->loadModel($id),
      'modKasusPenyakitRuangan' => $modKasusPenyakitRuangan,
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate()
  {
    $model = new SARuanganM;
    $modRiwayatRuangan = new SARiwayatRuanganR;

    // Uncomment the following line if AJAX validation is needed

    if (isset($_POST['SARuanganM'])) {
      $ok = true;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $modRiwayatRuangan = new SARiwayatRuanganR;
        $modRiwayatRuangan->attributes = $_POST['SARiwayatRuanganR'];
        $modRiwayatRuangan->save();
        $valid = true;
        foreach ($_POST['SARuanganM'] as $i => $postDetail) {
          $model = new SARuanganM;
          $model->attributes = $postDetail;
          $model->instalasi_id = $_POST['instalasi_id'];
          $model->ruangan_image = 'a';
          $model->riwayatruangan_id = $modRiwayatRuangan->riwayatruangan_id;

          if (!empty(CUploadedFile::getInstance($model, '[' . $i . ']ruangan_image'))) {
            $model->ruangan_image = CUploadedFile::getInstance($model, '[' . $i . ']ruangan_image');
            $gambar = $model->ruangan_image;
            Yii::import("ext.EPhpThumb.EPhpThumb");
            $thumb = new EPhpThumb();
            $thumb->init(); //this is needed
            $random = rand(0000000, 9999999);
            $fullImgName = str_replace(' ', '_', strtolower(date('dmY_s') . $random . $gambar));
            $fullImgSource = Params::pathRuanganDirectory() . $fullImgName;
            $fullThumbSource = Params::pathRuanganTumbsDirectory() . 'kecil_' . $fullImgName;
            $model->ruangan_image = $fullImgName;
          }

          if ($model->validate()) {
            if (!empty($gambar)) {
              $ok = $ok && $gambar->saveAs($fullImgSource) && $thumb->create($fullImgSource)->resize(200, 200)->save($fullThumbSource);
            }
            $ok = $ok && $model->save();
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan " . CHtml::errorSummary($model));
            $this->redirect(array('create'));
          }
        }
        $transaction->commit();
        Yii::app()->user->setFlash('success', "Data " . $model->ruangan_nama . " berhasil disimpan");
        $this->redirect(array('admin', 'id' => $model->ruangan_id));
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data Gagal disimpan' . MyExceptionMessage::getMessage($exc, true) . '');
        $this->redirect(array('create'));
      }
    }


    $this->render('create', array(
      'model' => $model, 'modRiwayatRuangan' => $modRiwayatRuangan
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
    $modKasusPenyakitRuangan = KasuspenyakitruanganM::model()->findAll('ruangan_id=' . $id . '');
    $modKelasRuangan = KelasruanganM::model()->findAll('ruangan_id=' . $id . '');
    $modTindakanRuangan = TindakanruanganM::model()->findAll('ruangan_id=' . $id . '');
    $modRuanganPegawai = RuanganpegawaiM::model()->findAll('ruangan_id=' . $id . '');
    $modRiwayatRuangan = RiwayatruanganR::model()->findByPk($model->riwayatruangan_id);
// echo '<pre>';var_dump($_POST);die;
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SARuanganM'])) {
      // echo '<pre>';var_dump($_POST);die;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['SARuanganM'];
        if (!empty($_POST['SARuanganM'])) {
          $random = rand(0000000, 9999999);
          $model->ruangan_image = CUploadedFile::getInstance($model, 'ruangan_image');
          $gambar = $model->ruangan_image;
          $model->ruangan_image = $random . $model->ruangan_image;
          Yii::import("ext.EPhpThumb.EPhpThumb");
          $thumb = new EPhpThumb();
          $thumb->init(); //this is needed
          $fullImgName = $model->ruangan_image;
          $fullImgSource = Params::pathRuanganDirectory() . $fullImgName;
          $fullThumbSource = Params::pathRuanganTumbsDirectory() . 'kecil_' . $fullImgName;
          $model->ruangan_image = $fullImgName;
          //var_dump($model->ruangan_image);die;
        }
        $model->save();

        //var_dump($model->getErrors());die;

        $jumlahKelasPelayanan = isset($_POST['kelaspelayanan_id']) ? count((array)$_POST['kelaspelayanan_id']) : 0;
        $jumlahJenisKasusPenyakit = isset($_POST['jeniskasuspenyakit_id']) ? count((array)$_POST['jeniskasuspenyakit_id']) : 0;
        $jumlahDaftarTindakan = isset($_POST['SADaftarTindakanM']['tindakan']) ? count((array)$_POST['SADaftarTindakanM']['tindakan']) : 0;
        $jumlahRuanganPegawai = isset($_POST['pegawai_id']) ? count((array)$_POST['pegawai_id']) : 0;


        $ruangan_id = $model->ruangan_id;
        $hapusKasusPenyakitRuangan = KasuspenyakitruanganM::model()->deleteAll('ruangan_id=' . $ruangan_id . '');
        $hapuskelasRuangan = KelasruanganM::model()->deleteAll('ruangan_id=' . $ruangan_id . '');
        // $hapusTindakanRuangan = TindakanruanganM::model()->deleteAll('ruangan_id=' . $ruangan_id . '');
        $hapusRuanganPegawai = RuanganpegawaiM::model()->deleteAll('ruangan_id=' . $ruangan_id . '');

        // print_r($_POST['jeniskasuspenyakit_id']); exit();

        $dataKelasPelayanan = isset($_POST['kelaspelayanan_id']) ? $_POST['kelaspelayanan_id'] : 0;
        $dataJenisKasusPenyakit = isset($_POST['jeniskasuspenyakit_id']) ? $_POST['jeniskasuspenyakit_id'] : 0;
        $dataDaftarTindakan = isset($_POST['daftartindakan_id']) ? $_POST['daftartindakan_id'] : 0;
        $dataRuanganPegawai = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : 0;
// echo "<pre>";var_dump($jumlahDaftarTindakan);die();
        if ($jumlahJenisKasusPenyakit > 0) {
          // for($i=0; $i<$jumlahJenisKasusPenyakit; $i++)
          foreach ($dataJenisKasusPenyakit as $i => $jeniskasuspenyakit) {
            $modKasusRuangan = new KasuspenyakitruanganM;
            $modKasusRuangan->ruangan_id = $ruangan_id;
            $modKasusRuangan->jeniskasuspenyakit_id = $jeniskasuspenyakit;
            $modKasusRuangan->save();
          }
        }

        if ($jumlahKelasPelayanan > 0) {
          // for($i=0; $i<$jumlahKelasPelayanan; $i++)
          foreach ($dataKelasPelayanan as $i => $kelaspelayanan) {
            $modKasusRuangan = new KelasruanganM;
            $modKasusRuangan->ruangan_id = $ruangan_id;
            $modKasusRuangan->kelaspelayanan_id = $kelaspelayanan;
            $modKasusRuangan->save();
          }
        }

       // var_dump($_POST); die;
  

        if (isset($_POST['daftartindakan_id']) && count($_POST['daftartindakan_id']) > 0) {
          foreach ($_POST['daftartindakan_id'] as $i => $daftartindakan_id) {
            $modTindakanRuangan = new TindakanruanganM;
            $modTindakanRuangan->ruangan_id = $ruangan_id;
            $modTindakanRuangan->daftartindakan_id = $daftartindakan_id;
            $modTindakanRuangan->save();
        
          }
        }

        if (isset($_POST['pegawai_id']) && count((array)$_POST['pegawai_id']) > 0) {

          // for($j=0; $j<$jumlahRuanganPegawai; $j++)
          foreach ($_POST['pegawai_id'] as $i => $pegawai_id) {
            $modRuanganPegawai = new RuanganpegawaiM;
            $modRuanganPegawai->ruangan_id = $ruangan_id;
            $modRuanganPegawai->pegawai_id = $pegawai_id;
            $modRuanganPegawai->save();
          }
        }
 


        if (!empty($model->ruangan_image)) { //Klo User Memasukan Logo
          if ($model->save()) {
            //var_dump($model->getErrors());die;
            if (!empty($gambar)) {
              $gambar->saveAs($fullImgSource);
              $thumb->create($fullImgSource)
                ->resize(200, 200)
                ->save($fullThumbSource);
            }
            Yii::app()->user->setFlash('success', "Data " . $model->ruangan_nama . " berhasil disimpan");
            $transaction->commit();
            $this->redirect(array('admin'));
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data Ruangan Dan Jenis Kasus Penyakit Gagal Disimpan<br/>" . CHtml::errorSummary($model));
            $this->redirect(array('update', 'id' => $id));
          }
        } else { //Klo User Tidak Memasukan Logo
          if ($model->save()) {

            Yii::app()->user->setFlash('success', "Data " . $model->ruangan_nama . " berhasil disimpan");
            $transaction->commit();
            $this->redirect(array('admin'));
          } else {
            $transaction->rollback();
            Yii::app()->user->setFlash('error', "Data Ruangan Dan Jenis Kasus Penyakit Gagal Disimpan" . CHtml::errorSummary($model));
            $this->redirect(array('update', 'id' => $id));
          }
        }
      } catch (Exception $e) {

      var_dump($e); die;


        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Ruangan Dan Jenis Kasus Penyakit Gagal Disimpan");
      }
    }

    $this->render('update', array(
      'model' => $model,
      'modKasusPenyakitRuangan' => $modKasusPenyakitRuangan,
      'modKelasRuangan' => $modKelasRuangan,
      'modTindakanRuangan' => $modTindakanRuangan,
      'modRuanganPegawai' => $modRuanganPegawai,
      'modRiwayatRuangan' => $modRiwayatRuangan
    ));
  }





  
  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('SARuanganM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $this->pageTitle = Yii::app()->name . " - Ruangan";
    $model = new SARuanganM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SARuanganM']))
      $model->attributes = $_GET['SARuanganM'];

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
    $model = SARuanganM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'saruangan-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   * Fungsi untuk menghapus data
   * @throws CHttpException
   */
  public function actionDelete()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    if (Yii::app()->request->isPostRequest) {
      $id = $_POST['id'];


      KasuspenyakitruanganM::model()->deleteAll('ruangan_id=' . $id . '');
      KelasruanganM::model()->deleteAll('ruangan_id=' . $id . '');
      TindakanruanganM::model()->deleteAll('ruangan_id=' . $id . '');
      RuanganpegawaiM::model()->deleteAll('ruangan_id=' . $id . '');

      $this->loadModel($id)->delete();
      if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(
          array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
          )
        );
        exit;
      }

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax'])) {
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
      }
    } else {
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
  }

  /**
   * Mengubah status aktif menjadi nonaktif
   *
   * @param type $id
   */
  public function actionRemoveTemporary()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //                    SAPropinsiM::model()->updateByPk($id, array('propinsi_aktif'=>false));
    //                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));


    $id = $_POST['id'];
    if (isset($_POST['id'])) {
      $update = SARuanganM::model()->updateByPk($id, array('ruangan_aktif' => false));
      if ($update) {
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(
            array(
              'status' => 'proses_form',
            )
          );
          exit;
        }
      }
    } else {
      if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(
          array(
            'status' => 'proses_form',
          )
        );
        exit;
      }
    }
  }

  /**
   * Fungsi untuk cetak data
   */
  public function actionPrint()
  {
    $model = new SARuanganM();
    $model->attributes = $_REQUEST['SARuanganM'];
    $judulLaporan = 'Laporan Ruangan';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      Yii::app()->bootstrap->coreCss = false;
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
   * Fungsi untuk menampilkan riwayat ruangan
   */
  public function actionGetRiwayatRuangan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = $_POST['instalasi_id'];
      $sql = "SELECT 
				 riwayatruangan_r.tglpenetapanruangan, 
				 riwayatruangan_r.nopenetapanruangan, 
				 riwayatruangan_r.tentangpenetapan, 
				 instalasi_m.instalasi_id, 
				 instalasi_m.instalasi_nama
			   FROM 
				 public.instalasi_m, 
				 public.riwayatruangan_r
			   WHERE 
				 instalasi_m.riwayatruangan_id = riwayatruangan_r.riwayatruangan_id
				 AND instalasi_m.instalasi_id=" . $instalasi_id . "";
      $riwayatRuangan = Yii::app()->db->createCommand($sql)->query();
      foreach ($riwayatRuangan as $tampil) :
        $data['tglpenetapanruangan'] = $tampil['tglpenetapanruangan'];
        $data['nopenetapanruangan'] = $tampil['nopenetapanruangan'];
        $data['tentangpenetapan'] = $tampil['tentangpenetapan'];

      endforeach;

      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionBpjsInterface()
	{
            if(Yii::app()->getRequest()->getIsAjaxRequest()) {
                if(empty( $_GET['param'] ) OR $_GET['param'] === ''){
                        die('param can\'not empty value');
                }else{
                        $param = $_GET['param'];
                }

                $bpjs = new BpjsVklaim();

                switch ($param) {
                        case '1':
                                $query = $_GET['query'];
                                $query = explode(" ",$query);
                                $query = $query[0];
                                print_r( $bpjs->search_poli($query) );
                                break;
                        default:
                                die('error number, please check your parameter option');
                                break;
                }
                Yii::app()->end();
            }
	}
	
  public function actionSetFormPoli()
  {
      if(Yii::app()->request->isAjaxRequest) { 
        $poliList = $_POST['poliList'];
        $form = '';
        $pesan = '';
            if(count($poliList) > 0){
                foreach($poliList AS $i => $poli){
                    $kdPoli = $poli['kode'];
                    $nmPoli = $poli['nama'];
                    $form .= "<tr>" .
                        "<td>".
                        CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("rel"=>"tooltip","title"=>"Pilih","class"=>"btn_small",
                              "id"=>"pilihkarcis",
                              "onClick"=>"getNamaPoli(\"$kdPoli\");
                                          return false;"
                              )).
                        "</td>".
                        "<td>".
                        $kdPoli.
                        "</td>".
                        "<td>".
                        $nmPoli.
                        "</td>".
                      "</tr>";
                }
            }else{
                $pesan = "Data tidak ada!";
            }
            
            echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan));
            Yii::app()->end(); 
        }
    }
  

  public function actionGetKodeBpjs()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $mod = new BpjsVklaim();
            $query = $_GET['query'];
            $dataInhealth = $mod->search_poli($query);
           
            $form = "";
            $decodeJson  = json_decode($dataInhealth);
            // echo CJSON::encode($decodeJson->metaData);die;

            if(!empty($decodeJson)){
                $no = 0;
                // foreach ($decodeJson as $data){
                  if($decodeJson->metaData->code == "200"){
                    if (count($decodeJson->response->poli)>0){
                        for ($i=0; $i < count($decodeJson->response->poli); $i++) { 
                          $no++;
                          $kodepoli = $decodeJson->response->poli[$i]->kode;
                          // echo CJSON::encode($kodepoli);
      
                          $form .= "<tr>" .
                              "<td>".
                              CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("rel"=>"tooltip","title"=>"Pilih","class"=>"btn_small",
                                    "id"=>"pilihkarcis",
                                    "onClick"=>"getNamaPoli(\"$kodepoli\");
                                                return false;"
                                    )).
                              "</td>".
                              // "<td>".
                              //   $no.
                              // "</td>".
                              "<td>".
                              $decodeJson->response->poli[$i]->kode.
                              "</td>".
                              "<td>".
                              $decodeJson->response->poli[$i]->nama.
                              "</td>".
                            "</tr>";
                        }
                    }

                  }
                   
                // }
            }
            
            echo CJSON::encode(array('form'=>$form));
            Yii::app()->end(); 
        }
    }
}
