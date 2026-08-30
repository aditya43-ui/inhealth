<?php

class JenisAlatSterilisasiController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public function getLayoutJenisAlatSterilisasiIframe()
  {
    if (Yii::app()->session['modul_id'] == 87) { //modul Sterilisasi RSPMC-498
      $layout = '//layouts/iframe';
    }
    return $layout;
  }
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.jenisAlatSterilisasi.';

  /**
   * Menampilkan detail data.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $this->layout = $this->getLayoutJenisAlatSterilisasiIframe();
    $model = $this->loadModel($id);
    $this->render($this->path_view . 'view', array(
      'model' => $model,
    ));
  }

  /**
   * Membuat dan menyimpan data baru.
   */
  public function actionCreate()
  {
    $this->layout = $this->getLayoutJenisAlatSterilisasiIframe();
    $model = new SAJenisalatsterilisasiM;

    if (isset($_POST['SAJenisalatsterilisasiM'])) {
      $model->attributes = $_POST['SAJenisalatsterilisasiM'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', 'Data ' . $model->jenisalatmedis_nama . ' berhasil disimpan.');
        $this->redirect(array('admin'));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan.");
      }
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model,
    ));
  }

  /**
   * Memanggil dan Mengubah sebagian data.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    $this->layout = $this->getLayoutJenisAlatSterilisasiIframe();
    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SAJenisalatsterilisasiM'])) {
      $model->attributes = $_POST['SAJenisalatsterilisasiM'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', 'Data ' . $model->jenisalatmedis_nama . ' berhasil disimpan.');
        $this->redirect(array('admin'));
      } else {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan.");
      }
    }

    $this->render($this->path_view . 'update', array(
      'model' => $model,
    ));
  }

  /**
   * Memanggil dan Menghapus data.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id)
  {
    $this->layout = $this->getLayoutJenisAlatSterilisasiIframe();
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
    $this->layout = $this->getLayoutJenisAlatSterilisasiIframe();
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
    $this->layout = $this->getLayoutJenisAlatSterilisasiIframe();
    $dataProvider = new CActiveDataProvider('SAJenisalatsterilisasiM');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $this->layout = $this->getLayoutJenisAlatSterilisasiIframe();

    $model = new SAJenisalatsterilisasiM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SAJenisalatsterilisasiM'])) {
      $model->attributes = $_GET['SAJenisalatsterilisasiM'];
    }
    $this->render($this->path_view . 'admin', array(
      'model' => $model,
    ));
  }

  /**
   * Memanggil data dari model.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = SAJenisalatsterilisasiM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sajenisalatsterilisasi-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new SAJenisalatsterilisasiM;
    $model->attributes = $_REQUEST['SAJenisalatsterilisasiM'];
    $judulLaporan = 'Data Jenis Alat Sterilisasi';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);

      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 45, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
