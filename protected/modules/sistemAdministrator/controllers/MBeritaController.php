<?php

class MBeritaController extends MyAuthController
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
    $model = new SAMberitaM;
    $format = new MyFormatter();
    $model->waktutampilberita  = date('Y-m-d H:i:s');
    $model->waktuselesaitampil  = date('Y-m-d H:i:s');

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SAMberitaM'])) {
      $model->attributes = $_POST['SAMberitaM'];
      $model->waktutampilberita  = $format->formatDateTimeForDb($model->waktutampilberita);
      $model->waktuselesaitampil  = $format->formatDateTimeForDb($model->waktuselesaitampil);
      $model->beritaterkait = isset($model->beritaterkait) ? implode(', ', $model->beritaterkait) : "";
      $model->tglbuatberita  = date('Y-m-d H:i:s');
      $model->create_user  = Yii::app()->user->id;
      $model->gambarberita_path = CUploadedFile::getInstance($model, 'gambarberita_path');
      $random = rand(0000000, 9999999);
      $gambar = $random . $model->gambarberita_path;
      if ($model->save()) {
        if (isset($model->gambarberita_path)) {
          $model->gambarberita_path->saveAs(Params::pathBerita() . $gambar);
          $model->gambarberita_path = $gambar;
        }
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        //                $this->redirect(array('view','id'=>$model->mberita_id));
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
    $format = new MyFormatter();

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SAMberitaM'])) {
      $model->attributes = $_POST['SAMberitaM'];
      $model->waktutampilberita  = $format->formatDateTimeForDb($model->waktutampilberita);
      $model->waktuselesaitampil  = $format->formatDateTimeForDb($model->waktuselesaitampil);
      $model->beritaterkait = implode(', ', $model->beritaterkait);
      $model->tglbuatberita  = date('Y-m-d H:i:s');
      $model->create_user  = Yii::app()->user->id;
      $model->gambarberita_path = CUploadedFile::getInstance($model, 'gambarberita_path');
      if ($model->save()) {
        if (isset($model->gambarberita_path)) {
          $model->gambarberita_path->saveAs(Params::pathBerita() . $model->gambarberita_path);
        }
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->mberita_id));
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
    $dataProvider = new CActiveDataProvider('SAMberitaM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $model = new SAMberitaM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SAMberitaM'])) {
      $model->attributes = $_GET['SAMberitaM'];
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
    $model = SAMberitaM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'samberita-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new SAMberitaM;
    $model->attributes = $_REQUEST['SAMberitaM'];
    $judulLaporan = 'Data SAMberitaM';
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
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
