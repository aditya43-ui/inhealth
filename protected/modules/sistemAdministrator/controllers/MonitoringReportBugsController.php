<?php

class MonitoringReportBugsController extends MyAuthController
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
  public function actionCreate()
  {
    $format = new MyFormatter();
    $model = new SAReportbugsR;
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
      $ip_client = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $ip_client = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
      $ip_client = $_SERVER['REMOTE_ADDR'];
    }
    if (isset(Yii::app()->user->id)) {
      $model->create_login_id = Yii::app()->user->id;
      $model->create_login_nama = Yii::app()->user->getState('nama_pemakai');
      $model->create_pegawai_id = Yii::app()->user->getState('pegawai_id');
      $model->create_instalasi_id = Yii::app()->user->getState('instalasi_id');
      $model->create_ruangan_id = Yii::app()->user->getState('ruangan_id');
      $model->create_modul_id = $_SESSION['modul_id'];
    } else {
      $model->create_login_nama = "mobile";
    }
    $model->create_hostname_pc = $ip_client;
    $model->create_browser_pc = $_SERVER['HTTP_USER_AGENT'];
    $model->create_datetime = date("Y-m-d H:i:s");

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SAReportbugsR'])) {
      $model->attributes = $_POST['SAReportbugsR'];
      $model->create_datetime = $format->formatDateTimeForDb($model->create_datetime);
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('admin', 'id' => $model->reportbugs_id));
      }
    }

    $this->render('create', array(
      'model' => $model,
    ));
  }

  /**
   * Memanggil dan Mengubah sebagian data.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    $format = new MyFormatter();
    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SAReportbugsR'])) {
      $model->attributes = $_POST['SAReportbugsR'];
      $model->create_datetime = $format->formatDateTimeForDb($model->create_datetime);
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('admin', 'id' => $model->reportbugs_id));
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
  public function actionDelete($id)
  {
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      $this->loadModel($id)->delete();

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
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
    $dataProvider = new CActiveDataProvider('SAReportbugsR');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $this->pageTitle = Yii::app()->name . " - Monitoring Error Dan Bugs";
    $model = new SAReportbugsR('search');
    $model->unsetAttributes();  // clear any default values
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    $model->create_datetime = $model->tgl_awal . ' s/d ' . $model->tgl_akhir;
    if (isset($_GET['SAReportbugsR'])) {
      $model->attributes = $_GET['SAReportbugsR'];
      $model->tgl_awal = isset($_GET['SAReportbugsR']['tgl_awal']) ? MyFormatter::formatDateTimeForDb($_GET['SAReportbugsR']['tgl_awal']) . ' 00:00:00' : '';
      $model->tgl_akhir = isset($_GET['SAReportbugsR']['tgl_akhir']) ? MyFormatter::formatDateTimeForDb($_GET['SAReportbugsR']['tgl_akhir']) . ' 23:59:59' : '';
      $model->create_datetime = $model->tgl_awal . ' s/d ' . $model->tgl_akhir;
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
    $model = SAReportbugsR::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sareportbugs-r-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new SAReportbugsR;
    $model->attributes = $_REQUEST['SAReportbugsR'];
    $judulLaporan = 'Data Monitoring Error dan Bugs';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }
}
