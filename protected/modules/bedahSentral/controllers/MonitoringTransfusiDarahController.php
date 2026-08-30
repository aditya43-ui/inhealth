<?php

class MonitoringTransfusiDarahController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';

  /**
   * Menampilkan detail data.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $model = $this->loadModel($id);
    $this->render('view', array(
      'model' => $model,
    ));
  }

  /**
   * Membuat dan menyimpan data baru.
   */
  public function actionCreate($pendaftaran_id, $pasienmasukpenunjang_id = null, $id = null)
  {

    $daftar = PendaftaranT::model()->findByPk($pendaftaran_id);

    $model = null;

    if (!empty($id)) {
      $model = MonitoringtransfusidarahT::model()->findByPk($id);
    }

    if (empty($model)) {
      $model = new MonitoringtransfusidarahT;
      $model->pendaftaran_id = $daftar->pendaftaran_id;
      $model->pasien_id = $daftar->pasien_id;
      $model->pasienadmisi_id = $daftar->pasienadmisi_id;
      $model->pasienmasukpenunjang_id = $pasienmasukpenunjang_id;
    }

    $model->monitoring_tanggal = empty($model->monitoring_tanggal) ? null : MyFormatter::formatDateTimeForUser($model->monitoring_tanggal);
    $model->isi_kantongdarah = empty($model->isi_kantongdarah) ? null : number_format($model->isi_kantongdarah, 2, ",", "");
    $model->ttv_suhutubuh = empty($model->isi_kantongdarah) ? null : number_format($model->ttv_suhutubuh, 2, ",", "");

    $model->nama_kantong = "";
    if (!empty($model->stokkantongdarah_id)) {
      $stok = StokkantongdarahT::model()->findByPk($model->stokkantongdarah_id);
      if (!empty($stok)) {
        $jenis = JeniskantongdarahM::model()->findByPk($stok->jeniskantongdarah_id);

        if (!empty($jenis)) {
          $model->nama_kantong .= $jenis->nama_jenis;
        }

        $komponen = KomponendarahM::model()->findByPk($stok->komponendarah_id);

        if (!empty($komponen)) {
          $model->nama_kantong .= " - " . $komponen->namaKomponenLengkap;
        }

        $model->nama_kantong .= " - " . $stok->golongan_darah . " " . $stok->rhesus;
      }
    }


    $riwayat = MonitoringtransfusidarahT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
      'ruanganmonitoring_id' => Yii::app()->user->getState('ruangan_id')
    ), array(
      'order' => 'monitoring_tanggal, monitoring_jam'
    ));

    if (isset($_POST['MonitoringtransfusidarahT'])) {
      $model->attributes = $_POST['MonitoringtransfusidarahT'];
      $model->ruanganmonitoring_id = Yii::app()->user->getState('ruangan_id');
      $model->monitoring_tanggal = empty($model->monitoring_tanggal) ? null : MyFormatter::formatDateTimeForDB($model->monitoring_tanggal);

      if ($model->isNewRecord) {
        $model->create_time = date('Y-m-d H:i:s');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
      }
      $model->update_time = date('Y-m-d H:i:s');
      $model->update_loginpemakai_id = Yii::app()->user->id;

      //            var_dump($model->attributes); die;

      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('create', 'pendaftaran_id' => $model->pendaftaran_id, 'pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id));
      }
    }

    $this->render('create', array(
      'model' => $model,
      'daftar' => $daftar,
      'riwayat' => $riwayat,
    ));
  }

  /**
   * Memanggil dan Mengubah sebagian data.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['MonitoringtransfusidarahT'])) {
      $model->attributes = $_POST['MonitoringtransfusidarahT'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->monitoringtransfusidarah_id));
      }
    }

    $this->render('update', array(
      'model' => $model,
    ));
  }

  /**
   * Memanggil dan Menghapus data.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete()
  {
    $ok = 1;
    $msg = "Data berhasil dihapus";
    if (Yii::app()->request->isAjaxRequest) {
      // we only allow deletion via POST request
      try {
        $id = $_POST['id'];
        $this->loadModel($id)->delete();
      } catch (Exception $ex) {
        $ok = 0;
        $msg = "Data gagal dihapus.<br/>" . $ex->getMessage();
      }

      echo CJSON::encode(array(
        'ok' => $ok, 'msg' => $msg,
      ));
    }
  }

  /**
   * Memanggil dan menonaktifkan status 
   */
  public function actionNonActive($id)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['sukses'] = 0;
      $model = $this->loadModel($id);
      // set non-active this
      // example: 
      // $model->modelaktif = false;
      // if($model->save()){
      //	$data['sukses'] = 1;
      // }
      echo CJSON::encode($data);
    }
  }

  /**
   * Melihat daftar data.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('MonitoringtransfusidarahT');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $model = new MonitoringtransfusidarahT('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['MonitoringtransfusidarahT'])) {
      $model->attributes = $_GET['MonitoringtransfusidarahT'];
    }
    $this->render('admin', array(
      'model' => $model,
    ));
  }

  /**
   * Memanggil data dari model.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = MonitoringtransfusidarahT::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'monitoringtransfusidarah-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   * Mencetak data
   */
  public function actionPrint($pendaftaran_id, $caraPrint = 'PRINT')
  {

    $daftar = PendaftaranT::model()->findByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
    ));

    $riwayat = MonitoringtransfusidarahT::model()->findAllByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
      'ruanganmonitoring_id' => Yii::app()->user->getState('ruangan_id'),
    ), array(
      'order' => 'monitoring_tanggal, monitoring_jam'
    ));


    $permintaan = PermintaandarahT::model()->findByAttributes(array(
      'pendaftaran_id' => $pendaftaran_id,
      'create_ruangan' => Yii::app()->user->getState('ruangan_id')
    ), array(
      'order' => 'permintaandarah_id desc',
    ));

    $judulLaporan = 'MONITORING PEMBERIAN TRANSFUSI DARAH';

    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('permintaan' => $permintaan, 'riwayat' => $riwayat, 'daftar' => $daftar, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('permintaan' => $permintaan, 'riwayat' => $riwayat, 'daftar' => $daftar, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      // //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('permintaan' => $permintaan, 'riwayat' => $riwayat, 'daftar' => $daftar, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
