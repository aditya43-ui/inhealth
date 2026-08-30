<?php

class PemeriksaanLabController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  //	public $layout='//layouts/column1';
  public $layout = '//layouts/iframe'; //diakses dari : sistemAdministrator/MasterPemeriksaanLaboratorium
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.pemeriksaanLab.';

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
    $model = new SAPemeriksaanlabM;
    $modJns = JenispemeriksaanlabM::model()->findByPk($model->pemeriksaanlab_id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SAPemeriksaanlabM'])) {
      $model->attributes = $_POST['SAPemeriksaanlabM'];
      $model->subjenis_pemeriksaanlab_id = $_POST['SAPemeriksaanlabM']['subjenis_pemeriksaanlab_id'];
      $model->kode_unik = $_POST['SAPemeriksaanlabM']['kode_unik'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', "Data " . $model->pemeriksaanlab_nama . " berhasil disimpan");
        $this->redirect(array('view', 'id' => $model->pemeriksaanlab_id));
      } else {
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
      }
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model,
      'modJns' => $modJns,
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

    if (isset($_POST['SAPemeriksaanlabM'])) {
      $model->attributes = $_POST['SAPemeriksaanlabM'];
      $model->subjenis_pemeriksaanlab_id = $_POST['SAPemeriksaanlabM']['subjenis_pemeriksaanlab_id'];
      $model->kode_unik = $_POST['SAPemeriksaanlabM']['kode_unik'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', "Data " . $model->pemeriksaanlab_nama . " berhasil disimpan");
        $this->redirect(array('view', 'id' => $model->pemeriksaanlab_id));
      } else {
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
      }
    }

    $this->render($this->path_view . 'update', array(
      'model' => $model,
    ));
  }

  public function actionAutocompleteTindakan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
      $criteria->addCondition("daftartindakan_aktif IS TRUE");
      $criteria->order = 'daftartindakan_nama';
      $criteria->limit = 10;
      $models = DaftartindakanM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->daftartindakan_nama;
        $returnVal[$i]['value'] = $model->daftartindakan_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }


  public function actionAutocompleteKodeUnik()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $criteria = new CDbCriteria();
      $criteria->compare('LOWER(kode_unik)', strtolower($_GET['term']), true);
      $criteria->addCondition("pemeriksaanlab_aktif IS TRUE");
      $criteria->order = 'kode_unik';
      $criteria->limit = 10;
      $models = PemeriksaanlabM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->kode_unik;
        $returnVal[$i]['value'] = $model->kode_unik;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
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

      if (isset($_GET['add'])) :
        $model->pemeriksaanlab_aktif = true;
      else :
        $model->pemeriksaanlab_aktif = false;
      endif;

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
    $dataProvider = new CActiveDataProvider('SAPemeriksaanlabM');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $model = new SAPemeriksaanlabM('search');
    $model->unsetAttributes();  // clear any default values
    $model->pemeriksaanlab_aktif = true;
    if (isset($_GET['SAPemeriksaanlabM'])) {
      $model->attributes = $_GET['SAPemeriksaanlabM'];
      $model->daftartindakan_nama = $_GET['SAPemeriksaanlabM']['daftartindakan_nama'];
      $model->subjenis_pemeriksaanlab_id = $_GET['SAPemeriksaanlabM']['subjenis_pemeriksaanlab_id'];
      $model->kode_unik = $_GET['SAPemeriksaanlabM']['kode_unik'];
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
    $model = SAPemeriksaanlabM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sapemeriksaanlab-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new SAPemeriksaanlabM;
    $model->attributes = $_REQUEST['SAPemeriksaanlabM'];
    $judulLaporan = 'Data Pemeriksaan Lab';
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

  public function actionSetJenisKelompok()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $form = "";
      $pesan = "";
      $jenispemeriksaanlab_id = isset($_POST['jenispemeriksaanlab_id']) ? $_POST['jenispemeriksaanlab_id'] : null;

      $dataDetail = JenispemeriksaanlabM::model()->findByPK($jenispemeriksaanlab_id);

      if (!empty($dataDetail)) {
        
            // $form = $dataDetail->jenispemeriksaanlab_id;
            $form = strtoupper($dataDetail->jenispemeriksaanlab_kelompok);

      } else {
        $pesan = 'Data tidak ditemukan';
      }

      echo CJSON::encode(array('form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }
}
