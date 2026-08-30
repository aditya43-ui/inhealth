<?php

class JenisFormLabDetController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  //	public $layout='//layouts/column1';
  public $layout = '//layouts/iframe'; //diakses dari: sistemAdministrator/MasterPemeriksaanLaboratorium
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.jenisFormLabDet.';

  /**
   * Menampilkan detail data.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
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
    $model = new JenisformdetM;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['JenisformdetM'])) {
      $model->attributes = $_POST['JenisformdetM'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', "Data " . $model->jenisform_nama . " berhasil disimpan");
        $this->redirect(array('view', 'id' => $model->formlab_id));
      } else {
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
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
    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed

    if (isset($_POST['JenisformdetM'])) {
      $model->attributes = $_POST['JenisformdetM'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', 'Data ' . $model->formlab_id . ' berhasil disimpan.');
        $this->redirect(array('admin', 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
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
  public function actionDelete()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    if (Yii::app()->request->isPostRequest) {
      $id = $_POST['id'] ?? $_POST['formlab_id'];

      JenisformdetM::model()->deleteByPk($id);

      if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(array(
          'status' => 'proses_form',
          'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
        ));
        exit;
      }

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * Memanggil dan menonaktifkan status 
   */
  // public function actionNonActive($id)
  // {
  //   if (Yii::app()->request->isAjaxRequest) {
  //     $data['sukses'] = 0;
  //     $model = $this->loadModel($id);

  //     if (isset($_GET['add'])) :
  //       $model->jenispemeriksaanlab_aktif = true;
  //     else :
  //       $model->jenispemeriksaanlab_aktif = false;
  //     endif;

  //     if ($model->save()) {
  //       $data['sukses'] = 1;
  //     }
  //     echo CJSON::encode($data);
  //   }
  // }

  /**
   * Melihat daftar data.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('JenisformdetM');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $model = new JenisformdetM('search');
    $model->unsetAttributes();  // clear any default values
  
    if (isset($_GET['JenisformdetM'])) {
      $model->attributes = $_GET['JenisformdetM'];
      $model->pemeriksaanlab_nama = $_GET['JenisformdetM']['pemeriksaanlab_nama'];
      $model->pemeriksaanlab_kode = $_GET['JenisformdetM']['pemeriksaanlab_kode'] ?? null;
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
    $model = JenisformdetM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sajenisformdetlab-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new JenisformdetM;
    $model->attributes = $_REQUEST['JenisformdetM'];
    $judulLaporan = 'Data Jenis Form Detail';
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
      ////$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 45, 30, 15, 15);

      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionSimpanDetail() {
    if (!Yii::app()->request->isAjaxRequest) {
      Yii::app()->end();
    }

    $ok = 1;
    $msg = "Detail Jenis Form berhasil Disimpan";

    $model = new JenisformdetM;
    $model->attributes = $_POST['JenisformdetM'];

    if (!$model->save()) {
      $ok = 0;
      $msg = "Detail Jenis Form gagal Disimpan";
    }

    echo CJSON::encode(array(
      'ok'=>$ok,
      'msg'=>$msg,
    ));

  }
}
