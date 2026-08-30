<?php

class KonfigkoperasiKController extends MyAuthController
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
    $model = new KonfigkoperasiK;

    $model->persjasasimpanan = 0;
    $model->persjasapinjaman = 0;
    $model->persdanapengurus = 0;
    $model->persdanakaryawan = 0;
    $model->persdanapendidikan = 0;
    $model->persdanasosial = 0;
    $model->persdanacadangan = 0;


    if (isset($_POST['KonfigkoperasiK'])) {
      $model->attributes = $_POST['KonfigkoperasiK'];

      $model->validate();

      if ($model->validate() && $model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('admin'));
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
    $model = $this->loadModel($id);

    $model->persjasasimpanan = MyFormatter::formatNumberForPrint($model->persjasasimpanan, 2);
    $model->persjasapinjaman = MyFormatter::formatNumberForPrint($model->persjasapinjaman, 2);
    $model->persdanapengurus = MyFormatter::formatNumberForPrint($model->persdanapengurus, 2);
    $model->persdanakaryawan = MyFormatter::formatNumberForPrint($model->persdanakaryawan, 2);
    $model->persdanapendidikan = MyFormatter::formatNumberForPrint($model->persdanapendidikan, 2);
    $model->persdanasosial = MyFormatter::formatNumberForPrint($model->persdanasosial, 2);
    $model->persdanacadangan = MyFormatter::formatNumberForPrint($model->persdanacadangan, 2);

    $model->persbiayaprovisasi = MyFormatter::formatNumberForPrint($model->persbiayaprovisasi, 2);
    $model->persjasadeposito = MyFormatter::formatNumberForPrint($model->persjasadeposito, 2);

    $model->pimpinan_nama = empty($model->pimpinankoperasi_id) ? null : $model->pimpinan->nama_pegawai;
    $model->pengurus_nama = empty($model->penguruskoperasi_id) ? null : $model->pengurus->nama_pegawai;
    $model->bendahara_nama = empty($model->bendaharakoperasi_id) ? null : $model->bendahara->nama_pegawai;
    $model->bendahara_rs_nama = empty($model->bendaharars_id) ? null : $model->bendahara_rs->nama_pegawai;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['KonfigkoperasiK'])) {
      $model->attributes = $_POST['KonfigkoperasiK'];

      $model->validate();

      if ($model->validate() && $model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('admin'));
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
    $dataProvider = new CActiveDataProvider('KonfigkoperasiK');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $model = new KonfigkoperasiK('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['KonfigkoperasiK'])) {
      $model->attributes = $_GET['KonfigkoperasiK'];
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
    $model = KonfigkoperasiK::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'konfigkoperasi-k-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new KonfigkoperasiK;
    $model->attributes = $_REQUEST['KonfigkoperasiK'];
    $judulLaporan = 'Data KonfigkoperasiK';
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
      $mpdf->Output();
    }
  }
}
