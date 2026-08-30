<?php

class SupplierMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $successSaveSupplier = false;

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
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = new GZSupplierM;
    $modObatSupplier = new GZObatSupplierM;
    $model->supplier_jenis = Params::SUPPLIER_JENIS_GIZI;
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['GZSupplierM'])) {
      $cekObatAlkes = 0;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['GZSupplierM'];

        $propinsi_nama = '';
        $kabupaten_nama = '';
        $supplier_id = null;
        $kabupaten_id = null;

        if (!empty($_POST['GZSupplierM']['supplier_propinsi'])) {
          $propinsi = PropinsiM::model()->findByPk($_POST['GZSupplierM']['supplier_propinsi']);
          $propinsi_nama = $propinsi->propinsi_nama;
          $supplier_id = $propinsi->propinsi_id;
        }
        if (!empty($_POST['GZSupplierM']['supplier_kabupaten'])) {
          $kabupaten = KabupatenM::model()->findByPk($_POST['GZSupplierM']['supplier_kabupaten']);
          $kabupaten_nama = $kabupaten->kabupaten_nama;
          $kabupaten_id = $kabupaten->kabupaten_id;
        }

        //                            $cek = $_POST['GZSupplierM']['supplier_propinsi'];
        //                                if ($cek != ''):                                                                        
        //                                    $propinsi = PropinsiM::model()->findByPk($_POST['GZSupplierM']['supplier_propinsi']);    
        //                                    $propinsi_nama = $propinsi->propinsi_nama;
        //                                                                        
        //                                    if (!empty($_POST['GZSupplierM']['supplier_kabupaten'])){
        //                                        $kabupaten = KabupatenM::model()->findByPk($_POST['GZSupplierM']['supplier_kabupaten']);
        //                                        $kabupaten_nama = $kabupaten->kabupaten_nama;
        //                                    }
        //                                endif;

        $model->propinsi_id = $supplier_id;
        $model->supplier_propinsi = $propinsi_nama;
        $model->kabupaten_id = $kabupaten_id;
        $model->supplier_kabupaten = $kabupaten_nama;


        if ($model->validate()) { //Jika Data Untuk Model Supplier Valid
          if ($model->save()) { //Jika Model Supplier Sudah Disimpan
            $this->successSaveSupplier = true;
            if (isset($_POST['obatalkes_id'])) {
              $jumlahObatAlkes = count((array)$_POST['obatalkes_id']);
            } else {
              $jumlahObatAlkes = 0;
            }
            $idSupplier = $model->supplier_id;
            for ($i = 0; $i <= $jumlahObatAlkes; $i++) :
              $modObatSupplier = new GZObatSupplierM;
              $modObatSupplier->supplier_id = $idSupplier;
              if (isset($_POST['obatalkes_id'])) {
                $modObatSupplier->obatalkes_id = $_POST['obatalkes_id'][$i];
              }
              if ($modObatSupplier->validate()) { //Jika Data ObatSupplierM Valid
                if ($modObatSupplier->save()) { //Jika ObatSupplierM Sudah Berhasil Disimpan
                  $cekObatAlkes++;
                } else {
                  Yii::app()->user->setFlash('error', "Data Obat Supplier Gagal Disimpan");
                }
              }
            endfor;
          } else { //JIka Model Supplier Gagal Disimpan
            Yii::app()->user->setFlash('error', "Data Supplier Gagal Disimpan");
          }
        } else { //Jika Data Supplier Tidak Valid
          Yii::app()->user->setFlash('error', "Data Supplier Tidak Valid");
        }
        if ($this->successSaveSupplier && ($cekObatAlkes == $jumlahObatAlkes)) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', "Data Suplier dan Obat Supplier " . $model->supplier_nama . " Berhasil Disimpan");
          $this->redirect(array('admin', 'id' => 1));
        } else {
          Yii::app()->user->setFlash('error', "Data Suplier dan Obat Supplier Gagal Disimpan");
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render('create', array(
      'model' => $model, 'modObatSupplier' => $modObatSupplier
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
    $modObatSupplier = GZObatSupplierM::model()->findAll('supplier_id=' . $id . '');
    // Uncomment the following line if AJAX validation is needed

    $propinsi = PropinsiM::model()->find("propinsi_nama = '" . $model->supplier_propinsi . "'");
    $kabupaten = KabupatenM::model()->find("kabupaten_nama = '" . $model->supplier_kabupaten . "'");

    $propinsi_id = $model->supplier_propinsi;
    $kabupaten_id = $model->supplier_kabupaten;

    if (isset($propinsi)) :
      $model->propinsi_id = $propinsi->propinsi_id;
    endif;

    if (isset($kabupaten)) :
      $model->kabupaten_id = $kabupaten->kabupaten_id;
    endif;

    //$model->supplier_propinsi = isset($model->supplier_propinsi) ?  $propinsi->propinsi_id : "";
    //$model->supplier_kabupaten = isset($model->supplier_propinsi) ? $kabupaten->kabupaten_id : "";
    if (isset($_POST['GZSupplierM'])) {
      if (isset($_POST['GZSupplierM'])) {
        $cekObatAlkes = 0;
        $transaction = Yii::app()->db->beginTransaction();
        try {
          $model->attributes = $_POST['GZSupplierM'];
          //$propinsi = PropinsiM::model()->findByPk($_POST['GZSupplierM']['supplier_propinsi']);
          //$model->supplier_propinsi = isset($_POST['GZSupplierM']['supplier_propinsi']) ?  $propinsi->propinsi_nama : "";
          //$model->supplier_kabupaten = isset($_POST['GZSupplierM']['supplier_kabupaten']) ? KabupatenM::model()->findByPk($_POST['GZSupplierM']['supplier_kabupaten'])->kabupaten_nama : "";
          $propinsi_nama = '';
          $kabupaten_nama = '';
          $supplier_id = null;
          $kabupaten_id = null;

          if (!empty($_POST['GZSupplierM']['supplier_propinsi'])) {
            $propinsi = PropinsiM::model()->findByPk($_POST['GZSupplierM']['supplier_propinsi']);
            $propinsi_nama = $propinsi->propinsi_nama;
            $supplier_id = $propinsi->propinsi_id;
          }
          if (!empty($_POST['GZSupplierM']['supplier_kabupaten'])) {
            $kabupaten = KabupatenM::model()->findByPk($_POST['GZSupplierM']['supplier_kabupaten']);
            $kabupaten_nama = $kabupaten->kabupaten_nama;
            $kabupaten_id = $kabupaten->kabupaten_id;
          }
          //                                    $cek = $_POST['GZSupplierM']['supplier_propinsi'];
          //                                        if ($cek != ''):                                                                        
          //                                    $propinsi = PropinsiM::model()->findByPk($_POST['GZSupplierM']['supplier_propinsi']);    
          //                                    $propinsi_nama = $propinsi->propinsi_nama;
          //                                                                        
          //                                    if (!empty($_POST['GZSupplierM']['supplier_kabupaten'])){
          //                                        $kabupaten = KabupatenM::model()->findByPk($_POST['GZSupplierM']['supplier_kabupaten']);
          //                                        $kabupaten_nama = $kabupaten->kabupaten_nama;
          //                                    }
          //                                endif;

          //                                $model->propinsi_id =     isset($_POST['GZSupplierM']['supplier_propinsi']) ?  $propinsi->propinsi_id : "";                                
          //                                $model->supplier_propinsi = isset($_POST['GZSupplierM']['supplier_propinsi']) ?  $propinsi_nama : "";                                
          //                                $model->kabupaten_id =     !empty($_POST['GZSupplierM']['supplier_kabupaten']) ?  $kabupaten->kabupaten_id : "";
          //                                $model->supplier_kabupaten = isset($_POST['GZSupplierM']['supplier_kabupaten']) ? $kabupaten_nama : "";

          $model->propinsi_id = $supplier_id;
          $model->supplier_propinsi = $propinsi_nama;
          $model->kabupaten_id = $kabupaten_id;
          $model->supplier_kabupaten = $kabupaten_nama;

          if ($model->validate()) { //Jika Data Untuk Model Supplier Valid
            if ($model->save()) { //Jika Model Supplier Sudah Disimpan
              $idSupplier = $model->supplier_id;
              $hapusObatSupplier = GZObatSupplierM::model()->deleteAll('supplier_id=' . $idSupplier . '');
              $this->successSaveSupplier = true;
              if (isset($_POST['obatalkes_id'])) {
                $jumlahObatAlkes = count((array)$_POST['obatalkes_id']);
              } else {
                $jumlahObatAlkes = 0;
              }
              for ($i = 0; $i <= $jumlahObatAlkes; $i++) :
                $modObatSupplier = new GZObatSupplierM;
                $modObatSupplier->supplier_id = $idSupplier;
                if (isset($_POST['obatalkes_id'])) {
                  $modObatSupplier->obatalkes_id = $_POST['obatalkes_id'][$i];
                }
                if ($modObatSupplier->validate()) { //Jika Data ObatSupplierM Valid
                  if ($modObatSupplier->save()) { //Jika ObatSupplierM Sudah Berhasil Disimpan
                    $cekObatAlkes++;
                  } else {
                    Yii::app()->user->setFlash('error', "Data Obat Supplier Gagal Disimpan");
                  }
                }
              endfor;
            } else { //JIka Model Supplier Gagal Disimpan
              Yii::app()->user->setFlash('error', "Data Supplier Gagal Disimpan");
            }
          } else { //Jika Data Supplier Tidak Valid
            Yii::app()->user->setFlash('error', "Data Supplier Tidak Valid");
          }

          if ($this->successSaveSupplier && ($cekObatAlkes == $jumlahObatAlkes)) {
            $transaction->commit();
            Yii::app()->user->setFlash('success', "Data Suplier dan Obat Supplier " . $model->supplier_nama . " Berhasil Disimpan");
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

    $this->render('update', array(
      'model' => $model, 'modObatSupplier' => $modObatSupplier
    ));
  }

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('GZSupplierM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin($id = '')
  {
    $this->pageTitle = Yii::app()->name . " - Supplier";
    $model = new GZSupplierM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['GZSupplierM']))
      $model->attributes = $_GET['GZSupplierM'];

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
    $model = GZSupplierM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'gzsupplier-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    if (Yii::app()->request->isPostRequest) {
      //$hapusObatSupplier=GZObatSupplierM::model()->deleteAll('supplier_id='.$id.'');
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
      $update = GZSupplierM::model()->updateByPk($id, array('supplier_aktif' => false));
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
    $model = new GZSupplierM;
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['GZSupplierM']))
      $model->attributes = $_GET['GZSupplierM'];
    $model->attributes = $_REQUEST['GZSupplierM'];
    $judulLaporan = 'Data Supplier';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);

      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 45, 30, 15, 15);

      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '-' . date('Y/m-d') . '.pdf', 'I');
    }
  }

  /**
   * Mengatur dropdown kabupaten
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownKabupaten($encode = false, $namaModel = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $propinsi_id = $_POST["$namaModel"]['supplier_propinsi'];
      if ($encode) {
        echo CJSON::encode($kabupaten);
      } else {
        if (empty($propinsi_id)) {
          echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        } else {
          $kabupaten = KabupatenM::model()->findAllByAttributes(array('propinsi_id' => $propinsi_id, 'kabupaten_aktif' => true), array('order' => 'kabupaten_nama ASC'));
          if (count((array)$kabupaten) > 1) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          } elseif (count((array)$kabupaten) == 0) {
            echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
          }
          $kabupaten = CHtml::listData($kabupaten, 'kabupaten_id', 'kabupaten_nama');
          foreach ($kabupaten as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }
}
