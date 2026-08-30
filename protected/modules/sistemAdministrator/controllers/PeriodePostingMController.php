<?php

class PeriodePostingMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.periodePostingM.';
  public $path_tips = 'sistemAdministrator.views.tips.';
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
    $model = new SAPeriodepostingM;
    $model->tglperiodeposting_awal = date('d M Y');
    $model->tglperiodeposting_akhir = date('d M Y');

    if (isset($_POST['SAPeriodepostingM'])) {
      $model->attributes = $_POST['SAPeriodepostingM'];
      $model->tglperiodeposting_awal = $format->formatDateTimeForDb($_POST['SAPeriodepostingM']['tglperiodeposting_awal']);
      $model->tglperiodeposting_akhir = $format->formatDateTimeForDb($_POST['SAPeriodepostingM']['tglperiodeposting_akhir']);
      $model->create_time = date('Y-m-d H:i:s');
      $model->create_loginpemakai_id = Yii::app()->user->id;
      $model->create_ruangan = Yii::app()->user->getState('ruangan_id');

      if ($model->save()) {
        Yii::app()->user->setFlash('success', ' Data Periode ' . $model->tglperiodeposting_awal . " Sampai " . $model->tglperiodeposting_akhir . ' berhasil disimpan.');
        $this->redirect(array('admin', 'id' => 1));
      } else {
        Yii::app()->user->setFlash('error', 'Tanggal awal periode posting dan tanggal akhir periode posting tidak boleh diantara tanggal yang sudah ada di pengaturan periode posting!');
        $this->redirect(array('admin', 'id' => 2));
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
    $format = new MyFormatter;
    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SAPeriodepostingM'])) {
      $model->attributes = $_POST['SAPeriodepostingM'];
      $model->tglperiodeposting_awal = $format->formatDateTimeForDb($_POST['SAPeriodepostingM']['tglperiodeposting_awal']);
      $model->tglperiodeposting_akhir = $format->formatDateTimeForDb($_POST['SAPeriodepostingM']['tglperiodeposting_akhir']);

      if ($model->save()) {
        Yii::app()->user->setFlash('success', ' Data Periode ' . $model->tglperiodeposting_awal . " Sampai " . $model->tglperiodeposting_akhir . ' berhasil disimpan.');
        $this->redirect(array('admin', 'id' => 1));
      } else {
        Yii::app()->user->setFlash('error', 'Tanggal awal periode posting dan tanggal akhir periode posting tidak boleh diantara tanggal yang sudah ada di pengaturan periode posting!');
        $this->redirect(array('admin', 'id' => 2));
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
    $id = $_POST['id'];
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      $modBukuBesar = SABukubesarT::model()->findAllByAttributes(array('periodeposting_id' => $id));
      if (!empty($modBukuBesar)) {
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'warning' => TRUE
          ));
          exit;
        }
      } else {
        $this->loadModel($id)->delete();
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
          ));
          exit;
        }
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
      $update = SAPeriodepostingM::model()->updateByPk($id, array('periodeposting_aktif' => false));
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
    $dataProvider = new CActiveDataProvider('SAPeriodepostingM');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin($id = '')
  {

    $model = new SAPeriodepostingM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SAPeriodepostingM'])) {
      $model->attributes = $_GET['SAPeriodepostingM'];
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
    $model = SAPeriodepostingM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'saperiodeposting-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new SAPeriodepostingM('searchPrint');
    $model->unsetAttributes();
    if (isset($_REQUEST['SAPeriodepostingM'])) {
      $model->attributes = $_REQUEST['SAPeriodepostingM'];
    }
    $judulLaporan = 'Data Periode Posting';
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

      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '-' . date('Y/m/d') . '.pdf', 'I');
    }
  }

  /**
   * Memanggil data dari model.
   * @param integer the ID of the model to be loaded
   */
  public function actionCekTanggal()
  {
    $format = new MyFormatter;
    $model = new SAPeriodepostingM;

    $start_date = $format->formatDateTimeForDb($_GET['SAPeriodepostingM']['tglperiodeposting_awal']);
    $end_date = $format->formatDateTimeForDb($_GET['SAPeriodepostingM']['tglperiodeposting_akhir']);
    $check = $model->checkPeriodePosting($start_date, $end_date);
    if ($check['periodeposting_id'] > 0) {
      $data['pesan'] = "Tanggal awal periode posting dan tanggal akhir periode posting tidak boleh diantara tanggal yang sudah ada di pengaturan periode posting!";
    } else {
      $data['pesan'] = "";
    }
    echo json_encode($data);
  }
}
