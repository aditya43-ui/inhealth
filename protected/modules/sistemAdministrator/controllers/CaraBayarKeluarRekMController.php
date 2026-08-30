<?php

/**
 * Master Cara Pembayaran Keluar
 * 
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * @package application.modules.sistemAdministrator
 * @subpackage controllers
 * @category controller
 */
class CaraBayarKeluarRekMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.caraBayarKeluarRek.';

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
    $model = new SACarabayarkeluarrekM;

    if (isset($_POST['SACarabayarkeluarrekM'])) {
      $model->attributes = $_POST['SACarabayarkeluarrekM'];
      $model->carabayarkeluar = $_POST['SACarabayarkeluarrekM']['carabayarkeluar'];
      $model->rekening5_id = $_POST['SACarabayarkeluarrekM']['rekening5_id'];
      $model->debitkredit = $_POST['SACarabayarkeluarrekM']['debitkredit'];

      if ($model->save()) {
        Yii::app()->user->setFlash('success', 'Data ' . $model->carabayarkeluar . ' berhasil disimpan.');
        $this->redirect(array('admin', 'id' => $model->carabayarkeluarrek_id));
      } else {
        Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
        $this->redirect(array('admin', 'id' => $model->carabayarkeluarrek_id));
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

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SACarabayarkeluarrekM'])) {
      $model->attributes = $_POST['SACarabayarkeluarrekM'];
      $model->carabayarkeluar = $_POST['SACarabayarkeluarrekM']['carabayarkeluar'];
      $model->rekening5_id = $_POST['SACarabayarkeluarrekM']['rekening5_id'];
      $model->debitkredit = $_POST['SACarabayarkeluarrekM']['debitkredit'];

      if ($model->save()) {
        Yii::app()->user->setFlash('success', 'Data ' . $model->carabayarkeluar . ' berhasil disimpan.');
        $this->redirect(array('admin', 'id' => $model->carabayarkeluarrek_id));
      } else {
        Yii::app()->user->setFlash('error', 'Data gagal disimpan.');
        $this->redirect(array('admin', 'id' => $model->carabayarkeluarrek_id));
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
        SACarabayarkeluarrekM::model()->deleteAllByAttributes(array('carabayarkeluarrek_id' => $_GET['id']));
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
    $dataProvider = new CActiveDataProvider('SACarabayarkeluarrekM');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $model = new SACarabayarkeluarrekM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SACarabayarkeluarrekM'])) {
      $model->attributes = $_GET['SACarabayarkeluarrekM'];
      $model->debitkredit = isset($_GET['debitkredit']) ? $_GET['debitkredit'] : NULL;
      $model->rekening = isset($_GET['SACarabayarkeluarrekM']['rekening']) ? $_GET['SACarabayarkeluarrekM']['rekening'] : NULL;
      $model->nmrekening5 = isset($_GET['SACarabayarkeluarrekM']['nmrekening5']) ? $_GET['SACarabayarkeluarrekM']['nmrekening5'] : NULL;
      $model->debkre = isset($_GET['SACarabayarkeluarrekM']['debitkredit']) ? $_GET['SACarabayarkeluarrekM']['debitkredit'] : NULL;
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
    $model = SACarabayarkeluarrekM::model()->findByPk($id);
    if (!empty($model->rekening5_id)) {
      $rek = Rekening5M::model()->findByPk($model->rekening5_id);
      if (!empty($rek)) {
        $model->nmrekening5 = $rek->nmrekening5;
      }
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sarekeningcolumn-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new SACarabayarkeluarrekM('searchPrint');
    $model->unsetAttributes();
    if (isset($_REQUEST['SACarabayarkeluarrekM'])) {
      $model->attributes = $_REQUEST['SACarabayarkeluarrekM'];
    }
    $judulLaporan = 'Data Rekening Jenis Penjamin Keluar';
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
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  /**
   * Autocomplete Rekening Akuntansi
   */
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
      $criteria->limit = 5;
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
}
