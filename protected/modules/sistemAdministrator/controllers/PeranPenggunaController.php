<?php

class PeranPenggunaController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
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
    $model = new SAPeranpenggunaK;
    $model->peranpengguna_aktif = true;
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SAPeranpenggunaK'])) {
      $model->attributes = $_POST['SAPeranpenggunaK'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->peranpengguna_id));
      }
    }

    $this->render('create', array(
      'model' => $model,
    ));
  }

  /*
	 * menambah data klon
	 */
  public function actionKlon($id)
  {
    $model = $this->loadModel($id);
    $models = new SAPeranpenggunaK;

    if (isset($_POST['SAPeranpenggunaK'])) {
      $models->attributes = $_POST['SAPeranpenggunaK'];
      $models->peranpenggunanama = $_POST['SAPeranpenggunaK']['peranpenggunanama'];
      $models->peranpenggunanamalain = $_POST['SAPeranpenggunaK']['peranpenggunanamalain'];
      $models->peranpengguna_aktif = 't';
      if ($models->peranpenggunanama == $model->peranpenggunanama || $models->peranpenggunanamalain == $model->peranpenggunanamalain) {
        Yii::app()->user->setFlash('danger', '<strong>Gagal Simpan !</strong> Data tidak boleh sama dengan yang asli.');
      } else {
        $models->save();
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
      }
    }

    $this->render('_klonform', array(
      'model' => $model,
      'models' => $models,
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


    if (isset($_POST['SAPeranpenggunaK'])) {
      $model->attributes = $_POST['SAPeranpenggunaK'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->peranpengguna_id));
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
    // we only allow deletion via POST request
    $model = $this->loadModel($id);
    // set non-active this
    // example: 
    // $model->modelaktif = false;
    // $model->save();
    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil di non-aktif kan.');
    $this->render('view', array(
      'model' => $model,
    ));
  }

  /**
   * Melihat daftar data.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('SAPeranpenggunaK');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $model = new SAPeranpenggunaK('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SAPeranpenggunaK'])) {
      $model->attributes = $_GET['SAPeranpenggunaK'];
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
    $model = SAPeranpenggunaK::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'saperanpengguna-k-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new SAPeranpenggunaK;

    // $model->attributes=$_REQUEST['SAPeranpenggunaK'];
    if (isset($_GET['SAPeranpenggunaK'])) {
      $model->attributes = $_GET['SAPeranpenggunaK'];
    }

    $judulLaporan = 'Data Peran Pengguna';
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
      ////$mpdf->useOddEven = 2;  
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
      // $mpdf->Output();
    }
  }
}
