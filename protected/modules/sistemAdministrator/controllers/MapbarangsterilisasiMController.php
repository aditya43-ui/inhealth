<?php

class MapbarangsterilisasiMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.mapbarangsterilisasiM.';
  public $path_tips = 'sistemAdministrator.views.tips.';

  /**
   * Menampilkan detail data.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView()
  {
    $id = null;
    if (isset($_GET['id'])) {
      $id = $_GET['id'];
    } else {
      throw new CHttpException(400);
    }

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
    $model = new SAMapbarangsterilisasiM;

    if (isset($_POST['SAMapbarangsterilisasiM'])) {
      $model->attributes = $_POST['SAMapbarangsterilisasiM'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', 'Data ' . $model->barang->barang_nama . ' berhasil disimpan.');
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
  public function actionUpdate()
  {
    if (isset($_GET['id'])) {
      $id = $_GET['id'];
    } else {
      throw new CHttpException(400);
    }

    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SAMapbarangsterilisasiM'])) {
      $model->attributes = $_POST['SAMapbarangsterilisasiM'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', 'Data ' . $model->barang->barang_nama . ' berhasil disimpan.');
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
  public function actionDelete()
  {
    $barang_id = isset($_GET['id']['barang_id']) ? $_GET['id']['barang_id'] : null;
    $peralatansterilisasi_id = isset($_GET['id']['peralatansterilisasi_id']) ? $_GET['id']['peralatansterilisasi_id'] : null;

    if (Yii::app()->request->isPostRequest) {

      // we only allow deletion via POST request
      //			$this->loadModel($id)->delete();
      $model = SAMapbarangsterilisasiM::model()->findByAttributes(array('barang_id' => $barang_id, 'peralatansterilisasi_id' => $peralatansterilisasi_id));
      $model->delete();
      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * Melihat daftar data.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('SAMapbarangsterilisasiM');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $model = new SAMapbarangsterilisasiM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SAMapbarangsterilisasiM'])) {
      $model->attributes = $_GET['SAMapbarangsterilisasiM'];
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
    $model = SAMapbarangsterilisasiM::model()->findByPk($id);

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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sajenis-anastesi-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new SAMapbarangsterilisasiM();
    //$model->attributes = $_REQUEST['SAMapbarangsterilisasiM'];
    $judulLaporan = 'Data Sterilisasi Barang';
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

  public function actionAutoCompletePeralatansterilisasi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(peralatansterilisasi_nama)', strtolower($_GET['term']), true);
      $criteria->addCondition("jenisperalatan = '" . Params::JENIS_PERALATAN_BARANG . "'");
      $criteria->order = 'peralatansterilisasi_nama';
      $criteria->limit = 5;
      $models = SAPeralatansterilisasiM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->peralatansterilisasi_nama;
        $returnVal[$i]['value'] = $model->peralatansterilisasi_nama;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
