<?php

class JenisPenilaianController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  // public $layout = '//layouts/iframe';
  public $layout='//layouts/column1';
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
    $model = new KPJenispenilaianM;
    $model->jenispenilaian_aktif = 1;
    $model->bobot_penilaian = 0;
    if (isset($_POST['KPJenispenilaianM'])) {
      $model->attributes = $_POST['KPJenispenilaianM'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', 'Data ' . $model->jenispenilaian_nama . ' berhasil disimpan.');
        $this->redirect(array('admin', 'id' => $model->jenispenilaian_id));
      } else {
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
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

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['KPJenispenilaianM'])) {
      $model->attributes = $_POST['KPJenispenilaianM'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', 'Data ' . $model->jenispenilaian_nama . ' berhasil disimpan.');
        $this->redirect(array('admin', 'id' => $model->jenispenilaian_id));
      } else {
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
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
      $model->jenispenilaian_aktif = 0;
      if ($model->save()) {
        $data['sukses'] = 1;
      }
      echo CJSON::encode($data);
    }
  }

  /**
   * Melihat daftar data.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('KPJenispenilaianM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $this->pageTitle = Yii::app()->name . " - Jenis Penilaian";
    $model = new KPJenispenilaianM('search');
    $model->unsetAttributes();  // clear any default values
    //$model->jenispenilaian_aktif=1;
    if (isset($_GET['KPJenispenilaianM'])) {
      $model->attributes = $_GET['KPJenispenilaianM'];
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
    $model = KPJenispenilaianM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'kpjenispenilaian-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new KPJenispenilaianM;
    $model->attributes = $_REQUEST['KPJenispenilaianM'];
    $judulLaporan = 'Data Jenis Penilaian';
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

      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 45, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }

  public function actionCheckPersentasiBobotNilai()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $bobotnilai = isset($_POST['bobot_penilaian']) ? $_POST['bobot_penilaian'] : 0;
      $nilai = 0;
      $status = "success";

      $models = KPJenispenilaianM::model()->findAll();
      foreach ($models as $i => $model) {
        $dataNilai = $model->bobot_penilaian;
        if (!isset($model->bobot_penilaian)) {
          $dataNilai = 0;
        }

        $nilai = $dataNilai + $nilai;
      }

      $nilaibobot = $nilai + $bobotnilai;
      if ($nilaibobot > 100) {
        $status = "error";
      }
      echo CJSON::encode(array('status' => $status, 'nilai' => $nilaibobot));
    }
    Yii::app()->end();
  }
}
