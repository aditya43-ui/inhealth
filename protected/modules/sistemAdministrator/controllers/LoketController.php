<?php

class LoketController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.loket.';
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
    $model = new SALoketM;
    $model->bukaloketantrian = '07:00:00';
    $model->estimasiantrian = 30;

    if (isset($_POST['SALoketM'])) {
      $model->attributes = $_POST['SALoketM'];
      $model->ispendaftaran = $_POST['SALoketM']['ispendaftaran'] == 1;
      $model->iskasir = $_POST['SALoketM']['iskasir'] == 1;
      $model->is_farmasi = $_POST['SALoketM']['is_farmasi'] == 1;
      $model->is_penunjang = $_POST['SALoketM']['is_penunjang'] == 1;
      $model->loket_aktif = $_POST['SALoketM']['loket_aktif'] == 1;
      $model->loket_singkatan = trim($model->loket_singkatan);
      
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('admin'));
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


    if (isset($_POST['SALoketM'])) {
      $model->attributes = $_POST['SALoketM'];
      $model->ispendaftaran = $_POST['SALoketM']['ispendaftaran'] == 1;
      $model->iskasir = $_POST['SALoketM']['iskasir'] == 1;
      $model->is_penunjang = $_POST['SALoketM']['is_penunjang'] == 1;
      $model->loket_aktif = $_POST['SALoketM']['loket_aktif'] == 1;
      $model->is_farmasi = $_POST['SALoketM']['is_farmasi'] == 1;
      $model->loket_singkatan = trim($model->loket_singkatan);

      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('admin'));
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
      $model->loket_aktif = 0;
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
    $dataProvider = new CActiveDataProvider('SALoketM');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $model = new SALoketM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SALoketM'])) {
      $model->attributes = $_GET['SALoketM'];
    }
    $this->render($this->path_view . 'admin', array(
      'model' => $model,
    ));
  }

  public function actionAutocompleteCarabayar()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(carabayar_nama)', strtolower($_GET['term']), true);
      $criteria->addCondition("carabayar_aktif IS TRUE");
      $criteria->order = 'carabayar_nama';
      $criteria->limit = 10;
      $models = CarabayarM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->carabayar_nama;
        $returnVal[$i]['value'] = $model->carabayar_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  /**
   * Memanggil data dari model.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = SALoketM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'saloket-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new SALoketM;
    $model->attributes = $_REQUEST['SALoketM'];
    $judulLaporan = 'Data Loket';
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
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }
}
