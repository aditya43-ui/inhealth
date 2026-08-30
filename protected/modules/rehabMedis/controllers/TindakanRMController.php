<?php

/**
 * digunakan untuk perbaikan tampilan modul rehab medis
 * BMB-198
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 * @package         application.modules.rehabMedis
 * @subpackage      controllers
 * 
 */
class TindakanRMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $this->render('view', array(
      'model' => $this->loadModel($id),
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate()
  {
    $model = new RMTindakanrmM;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['RMTindakanrmM'])) {
      $model->attributes = $_POST['RMTindakanrmM'];
      //$model->daftartindakan_id=$_POST['daftartindakan_id'];
      $model->tindakanrm_aktif = true;
      if ($model->save()) {
        Yii::app()->user->setFlash('success', 'Data ' . $model->tindakanrm_nama . ' berhasil disimpan.');
        $this->redirect(array('admin', 'id' => $model->tindakanrm_id));
      } else {
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
      }
    }

    $this->render('create', array(
      'model' => $model,
    ));
  }

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['RMTindakanrmM'])) {
      $_POST['RMTindakanrmM']['jenistindakanrm_id'] = $model->jenistindakanrm_id;
      $_POST['RMTindakanrmM']['daftartindakan_id'] = $model->daftartindakan_id;
      $model->attributes = $_POST['RMTindakanrmM'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', 'Data ' . $model->tindakanrm_nama . ' berhasil disimpan.');
        $this->redirect(array('admin', 'id' => $model->tindakanrm_id));
      } else {
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
      }
    }

    $this->render('update', array(
      'model' => $model,
    ));
  }

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('RMTindakanrmM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $this->pageTitle = Yii::app()->name . " - Tindakan Rehabilitasi Medis";
    $model = new RMTindakanrmM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['RMTindakanrmM'])) {
      $model->attributes = $_GET['RMTindakanrmM'];
      $model->daftartindakan_nama = $_GET['RMTindakanrmM']['daftartindakan_nama'];
    }

    $this->render('admin', array(
      'model' => $model,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = RMTindakanrmM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'rmtindakanrm-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   * digunakan untuk fungsi delete
   * @throws CHttpException menampilkan pemberitahuan jika ada kesalahan proses delete
   */
  public function actionDelete()
  {
    if (Yii::app()->request->isPostRequest) {
      $id = $_POST['id'];
      $this->loadModel($id)->delete();
      if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(array(
          'status' => 'proses_form',
          'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
        ));
        exit();
      }

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * Mengubah status aktif
   * @param type $id 
   */
  public function actionRemoveTemporary()
  {
    $id = $_POST['id'];
    if (isset($_POST['id'])) {
      $update = RMTindakanrmM::model()->updateByPk($id, array('tindakanrm_aktif' => false));
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
   * digunakan untuk cetak laporan
   */
  public function actionPrint()
  {
    $model = new RMTindakanrmM;
    $model->attributes = $_REQUEST['RMTindakanrmM'];
    $judulLaporan = 'Data RMTindakanrmM';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {

      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                            //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  /**
   * digunakan sebagai autocomplete daftar tindakan
   * @throws CHttpException menampilkan pemberitahuan jika ada kesalahan proses 
   */
  public function actionAutocompleteDaftarTindakan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $format = new MyFormatter();
      $returnVal = array();
      $daftartindakan_nama = isset($_GET['daftartindakan_nama']) ? $_GET['daftartindakan_nama'] : null;
      $criteria = new CDbCriteria();
      $criteria->with = array('perdatarif', 'jenistarif', 'komponentarif', 'daftartindakan', 'kelaspelayanan');
      $criteria->compare('LOWER(daftartindakan.daftartindakan_nama)', strtolower($daftartindakan_nama), true);
      $criteria->limit = 5;
      $models = RMTarifTindakanM::model()->findAll($criteria);
      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->daftartindakan->daftartindakan_nama . " - " . $model->kelaspelayanan->kelaspelayanan_nama . " - " . $model->harga_tariftindakan;
        $returnVal[$i]['value'] = $model->daftartindakan_id;
      }

      echo CJSON::encode($returnVal);
    } else
      throw new CHttpException(403, 'Tidak dapat mengurai data');
    Yii::app()->end();
  }
}
