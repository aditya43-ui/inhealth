<?php

/**
 * controller dimodifikasi karena ada perubahan layout 
 * BMB-166
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            <http://.com>
 * @package         application.modules.sistemAdministrator
 * @subpackage      controllers
 * 
 */
class SupplierMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.supplierM.';

  public $successSaveSupplier = false;

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $this->render($this->path_view . 'view', array(
      'model' => $this->loadModel($id),
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}

    $model = new SASupplierM;
    $modObatSupplier = new SAObatsupplierM;
    $module = Yii::app()->controller->module->id;
    if ($module == 'gudangUmum') {
      $model->supplier_jenis = Params::SUPPLIER_JENIS_UMUM;
    } else {
      $model->supplier_jenis = Params::SUPPLIER_JENIS_FARMASI;
    }
    $model->supplier_kode = '-- Otomatis --';
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SASupplierM'])) {
      $cekObatAlkes = 0;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['SASupplierM'];
        // $model->supplier_kode = MyGenerator::kodeSupplier();
        // IHS-3722
        $model->supplier_kode = MyGenerator::kodeSupplierNew();

        if ($model->validate()) { //Jika Data Untuk Model Supplier Valid
          if ($model->save()) { //Jika Model Supplier Sudah Disimpan
            $this->successSaveSupplier = true;
            $jumlahObatAlkes = 0;
            if (isset($_POST['obatalkes_id'])) {
              $jumlahObatAlkes = count((array)$_POST['obatalkes_id']);
              $idSupplier = $model->supplier_id;
              for ($i = 0; $i <= $jumlahObatAlkes; $i++) :
                $modObatSupplier = new SAObatsupplierM;
                $modObatSupplier->supplier_id = $idSupplier;
                $modObatSupplier->obatalkes_id = $_POST['obatalkes_id'][$i];
                if ($modObatSupplier->validate()) { //Jika Data ObatSupplierM Valid
                  if ($modObatSupplier->save()) { //Jika ObatSupplierM Sudah Berhasil Disimpan
                    $cekObatAlkes++;
                  } else {
                    Yii::app()->user->setFlash('error', "Data Obat Supplier Gagal Disimpan");
                  }
                }
              endfor;
            }
          } else { //JIka Model Supplier Gagal Disimpan
            Yii::app()->user->setFlash('error', "Data Supplier Gagal Disimpan");
          }
        } else { //Jika Data Supplier Tidak Valid
          Yii::app()->user->setFlash('error', "Data Supplier Tidak Valid");
        }

        if ($this->successSaveSupplier && ($cekObatAlkes == $jumlahObatAlkes)) {

          $transaction->commit();
          Yii::app()->user->setFlash('success', 'Data ' . $model->supplier_nama . ' berhasil disimpan');
          $this->redirect(array('admin', 'id' => 1));
        } else {
          Yii::app()->user->setFlash('error', "Data Suplier dan Obat Supplier Gagal Disimpan");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }
    // untuk default latitude & longitude (location-picker)
    $modPropinsi = PropinsiM::model()->findByPk(Yii::app()->user->getState('propinsi_id'));
    $latitude = $modPropinsi->latitude;
    $longitude = $modPropinsi->longitude;

    $this->render($this->path_view . 'create', array(
      'model' => $model, 'modObatSupplier' => $modObatSupplier, 'latitude' => $latitude, 'longitude' => $longitude
    ));
  }

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = $this->loadModel($id);
    $modObatSupplier = SAObatsupplierM::model()->findAll('supplier_id=' . $id . '');
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SASupplierM'])) {
      if (isset($_POST['SASupplierM'])) {
        $cekObatAlkes = 0;
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $model->attributes = $_POST['SASupplierM'];
          if ($model->validate()) { //Jika Data Untuk Model Supplier Valid
            if ($model->save()) { //Jika Model Supplier Sudah Disimpan
              $idSupplier = $model->supplier_id;
              //$hapusObatSupplier=SAObatsupplierM::model()->deleteAll('supplier_id='.$idSupplier.''); 
              $this->successSaveSupplier = true;
              $jumlahObatAlkes = 0;
              if (isset($_POST['obatalkes_id'])) {
                $jumlahObatAlkes = count((array)$_POST['obatalkes_id']);
                for ($i = 0; $i <= $jumlahObatAlkes; $i++) :
                  $modObatSupplier = new SAObatsupplierM;
                  $modObatSupplier->supplier_id = $idSupplier;
                  $modObatSupplier->obatalkes_id = $_POST['obatalkes_id'][$i];
                  if ($modObatSupplier->validate()) { //Jika Data ObatSupplierM Valid
                    if ($modObatSupplier->save()) { //Jika ObatSupplierM Sudah Berhasil Disimpan
                      $cekObatAlkes++;
                    } else {
                      Yii::app()->user->setFlash('error', "Data Obat Supplier Gagal Disimpan");
                    }
                  }
                endfor;
              }
            } else { //JIka Model Supplier Gagal Disimpan
              Yii::app()->user->setFlash('error', "Data Supplier Gagal Disimpan");
            }
          } else { //Jika Data Supplier Tidak Valid
            Yii::app()->user->setFlash('error', "Data Supplier Tidak Valid");
          }

          if ($this->successSaveSupplier && ($cekObatAlkes == $jumlahObatAlkes)) {
            $transaction->commit();
            Yii::app()->user->setFlash('success', 'Data ' . $model->supplier_nama . ' berhasil disimpan');
            $this->redirect(array('admin', 'id' => 1));
          } else {
            Yii::app()->user->setFlash('error', "Data Suplier dan Obat Supplier Gagal Disimpan");
          }
        } catch (Exception $exc) {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
        }
      }
    }
    // untuk default latitude & longitude (location-picker)
    $modPropinsi = PropinsiM::model()->findByPk(Yii::app()->user->getState('propinsi_id'));
    $latitude = isset($model->latitude) ? $model->latitude : $modPropinsi->latitude;
    $longitude = isset($model->longitude) ? $model->longitude : $modPropinsi->longitude;
    $this->render($this->path_view . 'update', array(
      'model' => $model, 'modObatSupplier' => $modObatSupplier, 'latitude' => $latitude, 'longitude' => $longitude
    ));
  }


  public function actionGetKabupatendrNamaPropinsi($encode = false, $namaModel = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      if ($namaModel == '' && $attr !== '') {
        $propinsi_nama = $_POST["$attr"];
      } elseif ($namaModel !== '' && $attr !== '') {
        $propinsi_nama = $_POST["$namaModel"]["$attr"];
      }
      $propinsi = PropinsiM::model()->findByAttributes(array('propinsi_nama' => $propinsi_nama));
      $propinsi_id = $propinsi->propinsi_id;
      if (empty($propinsi)) {
        $propinsi_id = $propinsi_nama;
      }
      $kabupaten = KabupatenM::model()->findAll("propinsi_id='$propinsi_id' ORDER BY kabupaten_nama asc");
      $kabupaten = CHtml::listData($kabupaten, 'kabupaten_nama', 'kabupaten_nama');

      if ($encode) {
        echo CJSON::encode($kabupaten);
      } else {
        if (empty($kabupaten)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          foreach ($kabupaten as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('SASupplierM');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin($id = '')
  {


    $model = new SASupplierM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SASupplierM'])) {
      $model->attributes = $_GET['SASupplierM'];
    }
    $this->render($this->path_view . 'admin', array(
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
    $model = SASupplierM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'gfsupplier-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionDelete()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    if (Yii::app()->request->isPostRequest) {
      $id = $_POST['id'];
      $this->loadModel($id)->delete();
      if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(array(
          'status' => 'proses_form',
          'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
        ));
        exit;
      }

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   *Mengubah status aktif
   * @param type $id 
   */
  public function actionRemoveTemporary()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //                    SAPropinsiM::model()->updateByPk($id, array('propinsi_aktif'=>false));
    //                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));


    $id = $_POST['id'];
    if (isset($_POST['id'])) {
      $update = SASupplierM::model()->updateByPk($id, array('supplier_aktif' => false));
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
   * Mengaktifkan status tidak aktif (false)
   * @param type $id
   */
  public function actionActiveTemporary()
  {
    $id = $_POST['id'];
    if (isset($_POST['id'])) {
      //					   $update = SASupplierM::model()->updateByPk(array('supplier_aktif'=>false), $id);
      $update = SASupplierM::model()->updateByPk($id, array('supplier_aktif' => true));
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

  public function actionPrint()
  {
    $model = new SASupplierM;
    $model->attributes = $_REQUEST['SASupplierM'];
    $judulLaporan = 'Data Supplier';
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

      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      // $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
      // $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 45, 30, 15, 15);

      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '-' . date("Y/m/d") . '.pdf', 'I');
    }
  }
}
