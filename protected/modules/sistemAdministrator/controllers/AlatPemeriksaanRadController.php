<?php

class AlatPemeriksaanRadController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.alatPemeriksaanRad.';

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

    $model = new PemeriksaanmapalatradM;
    $modDetails = array();
    if (isset($_POST['pemeriksaanrad_id'])) {
      $modDetails = $this->validasiTabular($_POST['pemeriksaanrad_id']);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlah = 0;
        for ($i = 0; $i < count((array)$_POST['pemeriksaanrad_id']); $i++) {
          $model = new PemeriksaanmapalatradM;
          $model->pemeriksaanalatrad_id = $_POST['pemeriksaanalatrad_id'][$i];
          $model->pemeriksaanrad_id = $_POST['pemeriksaanrad_id'][$i];
          if ($model->save()) {;
            $jumlah++;
          }
        }
        if ($jumlah == count((array)$_POST['pemeriksaanrad_id'])) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil</strong> Data Berhasil disimpan');
          $this->redirect(array('admin'));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('Error', '<strong>Gagal</strong> Data gagal disimpan');
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('Error', '<strong>Gagal</strong> Data gagal disimpan' . MyExceptionMessage::getMessage($ex));
      }
    }
    $this->render($this->path_view . 'create', array('model' => $model, 'modDetails' => $modDetails));
  }

  protected function validasiTabular($data)
  {
    foreach ($data as $i => $row) {
      $modDetails[$i] = new PemeriksaanmapalatradM;
      $modDetails[$i]->pemeriksaanalatrad_id = $row;
      $modDetails[$i]->pemeriksaanrad_id = $row;
      $modDetails[$i]->validate();
    }

    return $modDetails;
  }


  /**
   * Memanggil dan Mengubah sebagian data.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SAPemeriksaanmapalatradM'])) {
      $model->attributes = $_POST['SAPemeriksaanmapalatradM'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array($this->path_view . 'view', 'id' => $model->pemeriksaanalatrad_id));
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
    $id = $_GET['id'];
    $this->loadModel($id['pemeriksaanalatrad_id'], $id['pemeriksaanrad_id'])->delete();
    if (!isset($_GET['ajax']))
      $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
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
    $dataProvider = new CActiveDataProvider('SAPemeriksaanmapalatradM');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  public function actionAutocompletePemeriksaanAlatRad()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $returnVal = array();
      $term = isset($_GET['term']) ? $_GET['term'] : null;
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(pemeriksaanalatrad_nama)', strtolower($term), true);
      $criteria->addCondition('pemeriksaanalatrad_aktif = TRUE');
      $criteria->limit = 5;
      $models = PemeriksaanalatradM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->pemeriksaanalatrad_kode . ' - ' . $model->pemeriksaanalatrad_nama;
        $returnVal[$i]['value'] = $model->pemeriksaanalatrad_id;
      }

      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $model = new SAPemeriksaanmapalatradM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SAPemeriksaanmapalatradM'])) {
      $model->attributes = $_GET['SAPemeriksaanmapalatradM'];
      $model->pemeriksaanalatrad_nama = isset($_GET['SAPemeriksaanmapalatradM']['pemeriksaanalatrad_nama']) ? $_GET['SAPemeriksaanmapalatradM']['pemeriksaanalatrad_nama'] : null;
      $model->pemeriksaanrad_nama = isset($_GET['SAPemeriksaanmapalatradM']['pemeriksaanrad_nama']) ? $_GET['SAPemeriksaanmapalatradM']['pemeriksaanrad_nama'] : null;
    }
    $this->render($this->path_view . 'admin', array(
      'model' => $model,
    ));
  }

  /**
   * Memanggil data dari model.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id, $pemeriksaanrad_id = null)
  {
    if (empty($pemeriksaanrad_id)) {
      $model = SAPemeriksaanmapalatradM::model()->findByAttributes(array('pemeriksaanalatrad_id' => $id));
    } else {
      $model = SAPemeriksaanmapalatradM::model()->findByAttributes(array('pemeriksaanalatrad_id' => $id, 'pemeriksaanrad_id' => $pemeriksaanrad_id));
    }
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sapemeriksaanmapalatrad-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new SAPemeriksaanmapalatradM;
    $model->attributes = $_REQUEST['SAPemeriksaanmapalatradM'];
    $model->pemeriksaanalatrad_nama = isset($_GET['SAPemeriksaanmapalatradM']['pemeriksaanalatrad_nama']) ? $_GET['SAPemeriksaanmapalatradM']['pemeriksaanalatrad_nama'] : null;
    $model->pemeriksaanrad_nama = isset($_GET['SAPemeriksaanmapalatradM']['pemeriksaanrad_nama']) ? $_GET['SAPemeriksaanmapalatradM']['pemeriksaanrad_nama'] : null;
    $judulLaporan = 'Data Alat Pemeriksaan Radiologi';
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

  public function actionPemeriksaanmapalatrad()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $pemeriksaanalatrad_id = $_POST['pemeriksaanalatrad_id'];
      $pemeriksaanrad_id = $_POST['pemeriksaanrad_id'];
      $modpemeriksaanalatrad = SAPemeriksaanalatradM::model()->findByPK($pemeriksaanalatrad_id);
      $modpemeriksaanrad = PemeriksaanradM::model()->findByPK($pemeriksaanrad_id);

      $tr = "<tr>";
      $tr .= "<td>"
        . CHtml::hiddenField('pemeriksaanalatrad_id[]', $pemeriksaanalatrad_id, array('readonly' => true))
        . $modpemeriksaanalatrad->pemeriksaanalatrad_nama . "</td>";
      $tr .= "<td>"
        . CHtml::hiddenField('pemeriksaanrad_id[]', $pemeriksaanrad_id, array('readonly' => true))
        . $modpemeriksaanrad->pemeriksaanrad_nama . "</td>";
      $tr .= "<td>" . CHtml::link("<i class='icon-remove'></i>", '#', array('onclick' => 'hapusBaris(this); return false;')) . "</td>";
      $tr .= "</tr>";

      $data['tr'] = $tr;
      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
