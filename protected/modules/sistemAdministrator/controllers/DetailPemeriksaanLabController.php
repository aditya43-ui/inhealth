<?php

class DetailPemeriksaanLabController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  //	public $layout='//layouts/column1';
  public $layout = '//layouts/iframe'; //diakses dari : sistemAdministrator/MasterPemeriksaanLaboratorium
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.detailPemeriksaanLab.';

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
   * Membuat dan menyimpan data baru / mengubah data lama.
   * id untuk load pemeriksaanlab_m (ajax)
   */
  public function actionIndex($id = null)
  {

    // Uncomment the following line if AJAX validation is needed

    $model = new SAPemeriksaanlabdetM;
    if (!empty($id)) {
      $model->pemeriksaanlab_id = $id;
    }
    if (isset($_POST['SAPemeriksaanlabdetM'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $sukses = true;
        $error = "";
        $posts = $_POST['SAPemeriksaanlabdetM'];
        if (count((array)$posts) > 0) {
          foreach ($posts as $i => $detail) {
            $model = new SAPemeriksaanlabdetM;
            if (!empty($detail['pemeriksaanlabdet_id'])) {
              $model = SAPemeriksaanlabdetM::model()->findByPk($detail['pemeriksaanlabdet_id']);
            }
            $model->attributes = $detail;
            if ($model->save()) {
              $sukses &= true;
            } else {
              $sukses = false;
              $error .= CHtml::errorSummary($model);
            }
          }
        }
        if ($sukses) {
          $transaction->commit();
          $this->redirect(array('admin', 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', 'Data gagal disimpan.<br>' . $error);
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('success', 'Data gagal disimpan.' . $exc->getMessage());
      }
    }

    $this->render($this->path_view . 'index', array(
      'model' => $model,
    ));
  }

  /**
   * menampilkan data pemeriksaan lab
   */
  public function actionAutocompletePemeriksaanLab()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $term = isset($_GET['term']) ? $_GET['term'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(pemeriksaanlab_nama)', strtolower($term), true);
      $criteria->addCondition('pemeriksaanlab_aktif = TRUE');
      $criteria->limit = 5;
      $models = PemeriksaanlabM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->pemeriksaanlab_kode . ' - ' . $model->pemeriksaanlab_nama;
        $returnVal[$i]['value'] = $model->pemeriksaanlab_id;
      }

      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  /**
   * menampilkan pemeriksaan lab det yg sudah pernah di inputkan
   */
  public function actionGetPemeriksaanLabDet()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $model = new SAPemeriksaanlabdetM;
      $data['form'] = "";
      $models = $this->loadModels($_POST['pemeriksaanlab_id']);
      if (count((array)$models) > 0) {
        foreach ($models as $i => $model) {
          $data['form'] .= $this->renderPartial($this->path_view . '_rowPemeriksaanLabDet', array('model' => $model), true);
        }
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    }
  }
  /**
   * set pemeriksaan lab det yg baru
   */
  public function actionSetFormPemeriksaanLabDet()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $model = new SAPemeriksaanlabdetM;
      if (isset($_POST['pemeriksaanlabdet_id'])) {
        if (!empty($_POST['pemeriksaanlabdet_id'])) {
          $model = SAPemeriksaanlabdetM::model()->findByPk($_POST['pemeriksaanlabdet_id']);
        }
      }
      $model->pemeriksaanlab_id = $_POST['pemeriksaanlab_id'];
      $model->nilairujukan_id = $_POST['nilairujukan_id'];
      $data['form'] = $this->renderPartial($this->path_view . '_rowPemeriksaanLabDet', array('model' => $model), true);
      echo CJSON::encode($data);
      Yii::app()->end();
    }
  }
  /**
   * Memanggil dan Menghapus data.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id)
  {
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      $data['sukses'] = 0;
      $data['pesan'] = "Data gagal dihapus!";
      $transaction = Yii::app()->db->beginTransaction();
      try {
        if ($this->loadModel($id)->delete()) {
          $data['sukses'] = 1;
          $data['pesan'] = "Data berhasil dihapus!";
          $transaction->commit();
        } else {
          $transaction->rollback();
          $data['sukses'] = 0;
          $data['pesan'] = "Data gagal dihapus karna sudah digunakan di tabel lain!";
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        $data['sukses'] = 0;
        $data['pesan'] = "Data gagal dihapus karna sudah digunakan di tabel lain!";
      }
      echo CJSON::encode($data);
      Yii::app()->end();

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $model = new SAPemeriksaanlabdetM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SAPemeriksaanlabdetM'])) {
      $model->attributes = $_GET['SAPemeriksaanlabdetM'];
      $model->pemeriksaanlab_nama = $_GET['SAPemeriksaanlabdetM']['pemeriksaanlab_nama'];
      $model->kelompokdet = $_GET['SAPemeriksaanlabdetM']['kelompokdet'];
      $model->namapemeriksaandet = $_GET['SAPemeriksaanlabdetM']['namapemeriksaandet'];
      $model->nilairujukan_jeniskelamin = $_GET['SAPemeriksaanlabdetM']['nilairujukan_jeniskelamin'];
      $model->nilairujukan_nama = $_GET['SAPemeriksaanlabdetM']['nilairujukan_nama'];
      $model->nilairujukan_min = $_GET['SAPemeriksaanlabdetM']['nilairujukan_min'];
      $model->nilairujukan_max = $_GET['SAPemeriksaanlabdetM']['nilairujukan_max'];
      $model->nilairujukan_satuan = $_GET['SAPemeriksaanlabdetM']['nilairujukan_satuan'];
      if (isset($_GET['SAPemeriksaanlabdetM']['kelkumurhasillab_id'])) {
        $model->kelkumurhasillab_id = $_GET['SAPemeriksaanlabdetM']['kelkumurhasillab_id'];
      }
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
    $model = SAPemeriksaanlabdetM::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }
  /**
   * Memanggil data dari model berdasarkan pemeriksaanlab_id.
   * @param integer the ID of the model to be loaded
   */
  public function loadModels($pemeriksaanlab_id)
  {
    $model = SAPemeriksaanlabdetM::model()->findAllByAttributes(array('pemeriksaanlab_id' => $pemeriksaanlab_id), array('order' => 'pemeriksaanlabdet_nourut'));
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sapemeriksaanlabdet-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new SAPemeriksaanlabdetM;
    $model->attributes = $_REQUEST['SAPemeriksaanlabdetM'];
    $model->pemeriksaanlab_nama = $_REQUEST['SAPemeriksaanlabdetM']['pemeriksaanlab_nama'];
    $model->kelompokdet = $_REQUEST['SAPemeriksaanlabdetM']['kelompokdet'];
    $model->namapemeriksaandet = $_REQUEST['SAPemeriksaanlabdetM']['namapemeriksaandet'];
    $model->nilairujukan_jeniskelamin = $_REQUEST['SAPemeriksaanlabdetM']['nilairujukan_jeniskelamin'];
    $model->nilairujukan_nama = $_REQUEST['SAPemeriksaanlabdetM']['nilairujukan_nama'];
    $model->nilairujukan_min = $_REQUEST['SAPemeriksaanlabdetM']['nilairujukan_min'];
    $model->nilairujukan_max = $_REQUEST['SAPemeriksaanlabdetM']['nilairujukan_max'];
    $model->nilairujukan_satuan = $_REQUEST['SAPemeriksaanlabdetM']['nilairujukan_satuan'];
    if (isset($_GET['SAPemeriksaanlabdetM']['kelkumurhasillab_id'])) {
      $model->kelkumurhasillab_id = $_REQUEST['SAPemeriksaanlabdetM']['kelkumurhasillab_id'];
    }
    $judulLaporan = 'Data Pemeriksaan Labdet';
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
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }
}
