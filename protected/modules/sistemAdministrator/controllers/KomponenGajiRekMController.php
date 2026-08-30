<?php

class KomponenGajiRekMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.komponenGajiRekM.';

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
    $model = new SAKomponengajirekM;

    if (isset($_POST['SAKomponengajirekM'])) {
      $model->attributes = $_POST['SAKomponengajirekM'];
      $model->komponengaji_id = $_POST['SAKomponengajirekM']['komponengaji_id'];
      $model->rekening5_id = $_POST['SAKomponengajirekM']['rekening5_id'];
      $model->debitkredit = $_POST['SAKomponengajirekM']['debitkredit'];
      if ($_POST['SAKomponengajirekM']['ispenggajian'] == 1) {
        $model->ispenggajian = true;
        $model->ispembayarangaji = false;
      }
      if ($_POST['SAKomponengajirekM']['ispembayarangaji'] == 1) {
        $model->ispenggajian = false;
        $model->ispembayarangaji = true;
      }
      if ($model->save()) {
        Yii::app()->user->setFlash('success', 'Data ' . $model->komponengaji->komponengaji_nama . ' berhasil disimpan.');
        $this->redirect(array('admin', 'id' => $model->komponengajirek_id));
      } else {
        Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
        $this->redirect(array('admin', 'id' => $model->komponengajirek_id));
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
    $kg = KomponengajiM::model()->findByPk($model->komponengaji_id);
    $rk = Rekening5M::model()->findByPk($model->rekening5_id);

    $model->komponengaji_nama = $kg->komponengaji_nama;
    $model->nmrekening5 = $rk->nmrekening5;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SAKomponengajirekM'])) {
      $model->attributes = $_POST['SAKomponengajirekM'];
      $model->komponengaji_id = $_POST['SAKomponengajirekM']['komponengaji_id'];
      $model->rekening5_id = $_POST['SAKomponengajirekM']['rekening5_id'];
      $model->debitkredit = $_POST['SAKomponengajirekM']['debitkredit'];
      if ($_POST['SAKomponengajirekM']['ispenggajian'] == 1) {
        $model->ispenggajian = true;
        $model->ispembayarangaji = false;
      }
      if ($_POST['SAKomponengajirekM']['ispembayarangaji'] == 1) {
        $model->ispenggajian = false;
        $model->ispembayarangaji = true;
      }
      if ($model->save()) {
        Yii::app()->user->setFlash('success', 'Data ' . $model->komponengaji->komponengaji_nama . ' berhasil disimpan.');
        $this->redirect(array('admin', 'id' => $model->komponengajirek_id));
      } else {
        Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
        $this->redirect(array('admin', 'id' => $model->komponengajirek_id));
      }
    }

    $this->render($this->path_view . 'update', array(
      'model' => $model,
    ));
  }

  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete()
  {
    if (Yii::app()->request->isAjaxRequest) {
      // we only allow deletion via POST request
      $transaction = Yii::app()->db->beginTransaction();
      try {
        SAKomponengajirekM::model()->deleteAllByAttributes(array('komponengajirek_id' => $_GET['id']));
        $transaction->commit();
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Gagal Dihapus");
      }
      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax'])) {
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
      }
    } else {
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
  }

  /**
   * Melihat daftar data.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('SAKomponengajirekM');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $model = new SAKomponengajirekM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SAKomponengajirekM'])) {
      $model->attributes = $_GET['SAKomponengajirekM'];
      $model->debitkredit = isset($_GET['SAKomponengajirekM']['debitkredit']) ? $_GET['SAKomponengajirekM']['debitkredit'] : NULL;
      $model->komponengaji_nama = isset($_GET['SAKomponengajirekM']['komponengaji_nama']) ? $_GET['SAKomponengajirekM']['komponengaji_nama'] : NULL;
      $model->nmrekening5 = isset($_GET['SAKomponengajirekM']['nmrekening5']) ? $_GET['SAKomponengajirekM']['nmrekening5'] : NULL;
      $model->rekening = isset($_GET['SAKomponengajirekM']['rekening']) ? $_GET['SAKomponengajirekM']['rekening'] : NULL;
      $model->komponen_gaji = isset($_GET['SAKomponengajirekM']['komponen_gaji']) ? $_GET['SAKomponengajirekM']['komponen_gaji'] : NULL;
      $model->ispenggajian = isset($_GET['SAKomponengajirekM']['ispenggajian']) ? $_GET['SAKomponengajirekM']['ispenggajian'] : NULL;
      $model->ispembayarangaji = isset($_GET['SAKomponengajirekM']['ispembayarangaji']) ? $_GET['SAKomponengajirekM']['ispembayarangaji'] : NULL;
      $model->jenis = isset($_GET['jenis']) ? $_GET['jenis'] : NULL;
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
    $model = SAKomponengajirekM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sakompgajirek-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new SAKomponengajirekM('searchPrint');
    $model->unsetAttributes();
    if (isset($_REQUEST['SAKomponengajirekM'])) {
      $model->attributes = $_REQUEST['SAKomponengajirekM'];
    }
    $judulLaporan = 'Data Rekening Column';
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

  public function actionRekeningAkuntansi()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      //                $criteria->compare('LOWER(nmrincianobyek)', strtolower($_GET['term']), true);
      $term = strtolower(trim($_GET['term']));

      $condition = "LOWER(nmrekening5) LIKE '%" . $term . "%' OR LOWER(nmrekening4) LIKE '%" . $term . "%' OR LOWER(nmrekening3) LIKE '%" . $term . "%'";
      if (isset($_GET['id_jenis_rek'])) {
        $condition = "(LOWER(nmrekening5) LIKE '%" . $term . "%' OR LOWER(nmrekening4) LIKE '%" . $term . "%' OR LOWER(nmrekening3) LIKE '%" . $term . "%') AND (rekening5_nb = 'D' OR rekening4_nb = 'D' OR rekening3_nb = 'D')";
        if ($_GET['id_jenis_rek'] == 'Kredit') {
          $condition = "(LOWER(nmrekening5) LIKE '%" . $term . "%' OR LOWER(nmrekening4) LIKE '%" . $term . "%' OR LOWER(nmrekening3) LIKE '%" . $term . "%') AND (rekening5_nb = 'K' OR rekening4_nb = 'K' OR rekening3_nb = 'K')";
        }
      }

      $criteria->addCondition($condition);
      $criteria->order = 'nmrekening5';
      $models = RekeningakuntansiV::model()->findAll($criteria);
      $returnVal = array();
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        if (isset($model->rincianobyek_id)) {
          $kode_rekening = $model->kdrekening1 . "-" . $model->kdrekening2 . "-" . $model->kdrekening3 . "-" . $model->kdrekening4 . "-" . $model->kdrekening5;
          $nama_rekening = $model->nmrekening5;
        } else {
          if (isset($model->obyek_id)) {
            $kode_rekening = $model->kdrekening1 . "-" . $model->kdrekening2 . "-" . $model->kdrekening3 . "-" . $model->kdrekening4;
            $nama_rekening = $model->nmrekening4;
          } else {
            $kode_rekening = $model->kdrekening1 . "-" . $model->kdrekening2 . "-" . $model->kdrekening3;
            $nama_rekening = $model->nmrekening3;
          }
        }
        $returnVal[$i]['label'] = $kode_rekening . '-' . $nama_rekening;
        $returnVal[$i]['value'] = $nama_rekening;
      }
      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionKomponenGaji()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $term = isset($_GET['term']) ? $_GET['term'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(komponengaji_nama)', strtolower($term), true);
      $criteria->compare('LOWER(komponengaji_kode)', strtolower($term), true, 'OR');
      $criteria->order = 'komponengaji_nama';
      $criteria->limit = 5;

      $models = SAKomponengajiM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->komponengaji_kode . " " . $model->komponengaji_nama;
        $returnVal[$i]['value'] = $model->komponengaji_nama;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }
}
