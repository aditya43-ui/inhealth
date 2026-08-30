<?php

class KonfiganggaranKController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.konfiganggaranK.';

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
    $format = new MyFormatter;
    $model = new SAKonfiganggaranK;

    if (isset($_POST['SAKonfiganggaranK'])) {
      $model->attributes = $_POST['SAKonfiganggaranK'];
      $model->tglanggaran = $format->formatDateTimeForDb($_POST['SAKonfiganggaranK']['tglanggaran']);
      $model->sd_tglanggaran = $format->formatDateTimeForDb($_POST['SAKonfiganggaranK']['sd_tglanggaran']);
      $model->tglrencanaanggaran = $format->formatDateTimeForDb($_POST['SAKonfiganggaranK']['tglrencanaanggaran']);
      $model->sd_tglrencanaanggaran = $format->formatDateTimeForDb($_POST['SAKonfiganggaranK']['sd_tglrencanaanggaran']);
      $model->tglrevisianggaran = $format->formatDateTimeForDb($_POST['SAKonfiganggaranK']['tglrevisianggaran']);
      $model->sd_tglrevisianggaran = $format->formatDateTimeForDb($_POST['SAKonfiganggaranK']['sd_tglrevisianggaran']);
      //			$model->isclosing_anggaran = 0;
      $model->create_time = date("Y-m-d");
      $model->create_loginpemakai_id = Yii::app()->user->id;
      $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('admin', 'sukses' => 1));
      }
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model,
      'format' => $format,
    ));
  }

  /**
   * Memanggil dan Mengubah sebagian data.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    $format = new MyFormatter;
    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SAKonfiganggaranK'])) {
      $model->attributes = $_POST['SAKonfiganggaranK'];
      $model->tglanggaran = $format->formatDateTimeForDb($_POST['SAKonfiganggaranK']['tglanggaran']);
      $model->sd_tglanggaran = $format->formatDateTimeForDb($_POST['SAKonfiganggaranK']['sd_tglanggaran']);
      $model->tglrencanaanggaran = $format->formatDateTimeForDb($_POST['SAKonfiganggaranK']['tglrencanaanggaran']);
      $model->sd_tglrencanaanggaran = $format->formatDateTimeForDb($_POST['SAKonfiganggaranK']['sd_tglrencanaanggaran']);
      $model->tglrevisianggaran = $format->formatDateTimeForDb($_POST['SAKonfiganggaranK']['tglrevisianggaran']);
      $model->sd_tglrevisianggaran = $format->formatDateTimeForDb($_POST['SAKonfiganggaranK']['sd_tglrevisianggaran']);
      $model->update_time = date("Y-m-d");
      //			$model->isclosing_anggaran = 0;
      $model->update_loginpemakai_id = Yii::app()->user->id;
      $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('admin', 'id' => $model->konfiganggaran_id, 'sukses' => 1));
      }
    }

    $this->render($this->path_view . 'update', array(
      'model' => $model,
      'format' => $format
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
      $id = $_POST['id'];
      $this->loadModel($id)->delete();
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
  public function actionNonActive()
  {
    $id = $_POST['id'];
    if (isset($_POST['id'])) {
      $update = SAKonfiganggaranK::model()->updateByPk($id, array('isclosing_anggaran' => false));
      if ($update) {
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
          ));
          exit;
        }
      }
    } else {
      if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(array(
          'status' => 'proses_form',
        ));
        exit;
      }
    }
  }

  /**
   * Memanggil dan mengaktifkan status 
   */
  public function actionActive()
  {
    $id = $_POST['id'];
    if (isset($_POST['id'])) {
      $update = SAKonfiganggaranK::model()->updateByPk($id, array('isclosing_anggaran' => true));
      if ($update) {
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
          ));
          exit;
        }
      }
    } else {
      if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(array(
          'status' => 'proses_form',
        ));
        exit;
      }
    }
  }

  /**
   * Melihat daftar data.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('SAKonfiganggaranK');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin($sukses = '')
  {
    if ($sukses == 1) {
      Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
    }
    $format = new MyFormatter;
    $model = new SAKonfiganggaranK('search');
    $model->unsetAttributes();  // clear any default values
    $model->isclosing_anggaran = 0;
    //$model->tglanggaran=  date('Y M d');
    //$model->sd_tglanggaran=  date('Y M d');
    if (isset($_GET['SAKonfiganggaranK'])) {
      $model->attributes = $_GET['SAKonfiganggaranK'];
      $model->tglanggaran = $format->formatDateTimeForDb($_REQUEST['SAKonfiganggaranK']['tglanggaran']);
      $model->sd_tglanggaran = $format->formatDateTimeForDb($_REQUEST['SAKonfiganggaranK']['sd_tglanggaran']);
    }
    $this->render($this->path_view . 'admin', array(
      'model' => $model,
      'format' => $format,
    ));
  }

  /**
   * Memanggil data dari model.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = SAKonfiganggaranK::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'agkonfiganggaran-k-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new SAKonfiganggaranK;
    $model->attributes = $_REQUEST['SAKonfiganggaranK'];
    $judulLaporan = 'Data Periode Anggaran';
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
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '-' . date('Y/m/d') . '.pdf', 'I');
    }
  }
}
