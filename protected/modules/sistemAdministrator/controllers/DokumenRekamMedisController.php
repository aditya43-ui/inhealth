<?php

class DokumenRekamMedisController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.dokumenRekamMedis.';

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
  public function actionCreate($pasien_id = null, $tipe = null)
  {
    $format = new MyFormatter();
    $model = new SADokrekammedisM;
    $model->nodokumenrm = '-- Otomatis --';

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SADokrekammedisM'])) {
      $model->attributes = $_POST['SADokrekammedisM'];
      $model->nodokumenrm = MyGenerator::noDokumenRM();
      $model->tglrekammedis = $format->formatDateTimeForDb($_POST['SADokrekammedisM']['tglrekammedis']);
      $model->tglmasukrak = $format->formatDateTimeForDb($_POST['SADokrekammedisM']['tglmasukrak']);
      $model->tglkeluarakhir = $format->formatDateTimeForDb($_POST['SADokrekammedisM']['tglkeluarakhir']);
      $model->tglmasukakhir = $format->formatDateTimeForDb($_POST['SADokrekammedisM']['tglmasukakhir']);
      $model->tgl_in_aktif = $format->formatDateTimeForDb($_POST['SADokrekammedisM']['tgl_in_aktif']);
      $model->tglpemusnahan = $format->formatDateTimeForDb($_POST['SADokrekammedisM']['tglpemusnahan']);
      $model->create_time = $format->formatDateTimeForDb($model->create_time);
      $model->create_loginpemakai_id = Yii::app()->user->id;
      $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
      $model->statusrekammedis = Params::STATUSREKAMMEDIS_AKTIF;
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('create', 'id' => $model->dokrekammedis_id));
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


    if (isset($_POST['SADokrekammedisM'])) {
      $model->attributes = $_POST['SADokrekammedisM'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->dokrekammedis_id));
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
  public function actionDelete($dokrekammedis_id, $pasien_id)
  {
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      $this->loadModel($dokrekammedis_id, $pasien_id)->delete();

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
    $dataProvider = new CActiveDataProvider('SADokrekammedisM');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $model = new SADokrekammedisM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SADokrekammedisM'])) {
      $model->attributes = $_GET['SADokrekammedisM'];
      $model->namapasien = $_GET['SADokrekammedisM']['namapasien'];
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
    $model = SADokrekammedisM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sadokrekammedis-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new SADokrekammedisM;
    $model->attributes = $_REQUEST['SADokrekammedisM'];
    $judulLaporan = 'Data Dokumen Rekam Medis';
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
      $mpdf->Output();
    }
  }
  /**
   * autocomplete nama pasien
   */
  public function actionAutocompleteNamaPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $nama_pasien = isset($_GET['nama_pasien']) ? $_GET['nama_pasien'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(nama_pasien)', strtolower($nama_pasien), true);
      $criteria->order = 'nama_pasien';
      $criteria->limit = 5;

      $models = PasienM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->nama_pasien;
        $returnVal[$i]['value'] = $model->nama_pasien;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
