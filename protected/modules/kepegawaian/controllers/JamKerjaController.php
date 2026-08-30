<?php
class JamKerjaController extends MyAuthController
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
    $model = new KPJamkerjaM;

    // Uncomment the following line if AJAX validation is needed
    $model->jamkerja_aktif = true;

    if (isset($_POST['KPJamkerjaM'])) {
      $model->attributes = $_POST['KPJamkerjaM'];

      $model->jamisitrahat = !empty($_POST['KPJamkerjaM']['jamisitrahat']) ? $_POST['KPJamkerjaM']['jamisitrahat'] : null;
      $model->jammasukistirahat = !empty($_POST['KPJamkerjaM']['jammasukistirahat']) ? $_POST['KPJamkerjaM']['jammasukistirahat'] : null;
      $model->jammulaiscanmasuk = !empty($_POST['KPJamkerjaM']['jammulaiscanmasuk']) ? $_POST['KPJamkerjaM']['jammulaiscanmasuk'] : null;
      $model->jamakhirscanmasuk = !empty($_POST['KPJamkerjaM']['jamakhirscanmasuk']) ? $_POST['KPJamkerjaM']['jamakhirscanmasuk'] : null;
      $model->jammulaiscanplng = !empty($_POST['KPJamkerjaM']['jammulaiscanplng']) ? $_POST['KPJamkerjaM']['jammulaiscanplng'] : null;
      $model->jamakhirscanplng = !empty($_POST['KPJamkerjaM']['jamakhirscanplng']) ? $_POST['KPJamkerjaM']['jamakhirscanplng'] : null;
      $model->toleransiterlambat = !empty($_POST['KPJamkerjaM']['toleransiterlambat']) ? $_POST['KPJamkerjaM']['toleransiterlambat'] : null;
      $model->toleransiplgcpt = !empty($_POST['KPJamkerjaM']['toleransiplgcpt']) ? $_POST['KPJamkerjaM']['toleransiplgcpt'] : null;
      $model->toleransiplgcpt = !empty($_POST['KPJamkerjaM']['toleransiplgcpt']) ? $_POST['KPJamkerjaM']['toleransiplgcpt'] : null;

      if ($model->save()) {
        Yii::app()->user->setFlash('success', ' Data ' . $model->jamkerja_nama . ' berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->jamkerja_id));
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


    if (isset($_POST['KPJamkerjaM'])) {
      $model->attributes = $_POST['KPJamkerjaM'];
      $model->jamisitrahat = !empty($_POST['KPJamkerjaM']['jamisitrahat']) ? $_POST['KPJamkerjaM']['jamisitrahat'] : null;
      $model->jammasukistirahat = !empty($_POST['KPJamkerjaM']['jammasukistirahat']) ? $_POST['KPJamkerjaM']['jammasukistirahat'] : null;
      $model->jammulaiscanmasuk = !empty($_POST['KPJamkerjaM']['jammulaiscanmasuk']) ? $_POST['KPJamkerjaM']['jammulaiscanmasuk'] : null;
      $model->jamakhirscanmasuk = !empty($_POST['KPJamkerjaM']['jamakhirscanmasuk']) ? $_POST['KPJamkerjaM']['jamakhirscanmasuk'] : null;
      $model->jammulaiscanplng = !empty($_POST['KPJamkerjaM']['jammulaiscanplng']) ? $_POST['KPJamkerjaM']['jammulaiscanplng'] : null;
      $model->jamakhirscanplng = !empty($_POST['KPJamkerjaM']['jamakhirscanplng']) ? $_POST['KPJamkerjaM']['jamakhirscanplng'] : null;
      $model->toleransiterlambat = !empty($_POST['KPJamkerjaM']['toleransiterlambat']) ? $_POST['KPJamkerjaM']['toleransiterlambat'] : null;
      $model->toleransiplgcpt = !empty($_POST['KPJamkerjaM']['toleransiplgcpt']) ? $_POST['KPJamkerjaM']['toleransiplgcpt'] : null;
      $model->toleransiplgcpt = !empty($_POST['KPJamkerjaM']['toleransiplgcpt']) ? $_POST['KPJamkerjaM']['toleransiplgcpt'] : null;
      if ($model->save()) {
        Yii::app()->user->setFlash('success', ' Data ' . $model->jamkerja_nama . ' berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->jamkerja_id));
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
  public function actionNonActive($id)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['sukses'] = 0;
      $model = $this->loadModel($id);
      // set non-active this
      // example: 
      $model->jamkerja_aktif = 0;
      if ($model->save()) {
        $data['sukses'] = 1;
      }
      echo CJSON::encode($data);
    }
  }

  public function actionRemoveTemporary()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //                    SAPropinsiM::model()->updateByPk($id, array('propinsi_aktif'=>false));
    //                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));


    $id = $_POST['id'];
    if (isset($_POST['id'])) {
      $update = JamkerjaM::model()->updateByPk($id, array('jamkerja_aktif' => false));
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
    $dataProvider = new CActiveDataProvider('KPJamkerjaM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $model = new KPJamkerjaM('search');
    $model->unsetAttributes();  // clear any default values
    $model->jamkerja_aktif = 1;
    if (isset($_GET['KPJamkerjaM'])) {
      $model->attributes = $_GET['KPJamkerjaM'];
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
    $model = KPJamkerjaM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'kpjamkerja-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new KPJamkerjaM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['KPJamkerjaM'])) {
      $model->attributes = $_GET['KPJamkerjaM'];
    }
    $judulLaporan = 'Data Jam Kerja';
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
}
