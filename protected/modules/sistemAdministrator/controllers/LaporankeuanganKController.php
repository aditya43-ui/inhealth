<?php

class LaporankeuanganKController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.laporanKeuanganK.';

  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('LaporankeuanganK');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  public function actionAdmin($sukses = '')
  {
    if ($sukses == 1) :
      Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
    endif;

    $model = new LaporankeuanganK('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['LaporankeuanganK'])){
      $model->attributes = $_GET['LaporankeuanganK'];
      $model->menu_nama = $_GET['LaporankeuanganK']['menu_nama'];
    }

    $this->render($this->path_view . 'admin', array(
      'model' => $model,
    ));
  }

  public function actionCreate()
  {
    $model = new LaporankeuanganK;

    if (isset($_POST['LaporankeuanganK'])) {
      $model->attributes = $_POST['LaporankeuanganK'];
      
      $arrLevel = array();

      if (!empty($_POST['Levelrek'])) {
          foreach ($_POST['Levelrek'] as $dataLevel) {
              if (isset($dataLevel['ischeck']) && $dataLevel['ischeck'] == 1) {
                  $arrLevel[] = $dataLevel['lv'];
              }
          }
      }

      if (!empty($arrLevel)) {
        $model->levelrek = implode(',',$arrLevel);
      }

      if ($model->save()) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('admin', 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
      }
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model,
    ));
  }


  public function actionAutocompleteMenu()
  {
    if (Yii::app()->request->isAjaxRequest) {
      if (!isset($_GET['term'])) {
        $_GET['term'] = null;
      }

      $returnVal = array();
      $criteria = new CDbCriteria();
      
      $criteria->compare('LOWER(menu_nama)', strtolower($_GET['term']), true);
      $criteria->addCondition('modul_id = 26 and kelmenu_id = 35 and modul_aktif = true');
      $criteria->order = 't.menu_nama';
      $criteria->limit = 5;
      $models = MenuModulK::model()->findAll($criteria);

      foreach ($models as $i => $model) {
        $attributes = $model->attributeNames();
        foreach ($attributes as $j => $attribute) {
          $returnVal[$i]["$attribute"] = $model->$attribute;
        }
        $returnVal[$i]['label'] = $model->menu_nama;
        $returnVal[$i]['value'] = $model->menu_id;
      }

      echo CJSON::encode($returnVal);
    }
    Yii::app()->end();
  }

  public function actionUpdate($id)
  {
    $model = $this->loadModel($id);
    $model->menu_nama = (!empty($model->menu)?$model->menu->menu_nama:"");

    if (isset($_POST['LaporankeuanganK'])) {
      $model->attributes = $_POST['LaporankeuanganK'];
      
      $arrLevel = array();

      if (!empty($_POST['Levelrek'])) {
          foreach ($_POST['Levelrek'] as $dataLevel) {
              if (isset($dataLevel['ischeck']) && $dataLevel['ischeck'] == 1) {
                  $arrLevel[] = $dataLevel['lv'];
              }
          }
      }

      if (!empty($arrLevel)) {
        $model->levelrek = implode(',',$arrLevel);
      }

      if ($model->save()) {
        Yii::app()->user->setFlash('success', "Data berhasil disimpan");
        $this->redirect(array('admin', 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
      }
    }

    $this->render($this->path_view . 'update', array(
      'model' => $model,
    ));
  }



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
  

  /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  

  /**
   * Lists all models.
   */
  

  /**
   * Manages all models.
   */
  

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = LaporankeuanganK::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'saasalaset-m-form') {
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
      $update = SAAsalasetM::model()->updateByPk($id, array('asalaset_aktif' => false));
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
    $model = new LaporankeuanganK;
    if (isset($_GET['LaporankeuanganK'])){
      $model->attributes = $_GET['LaporankeuanganK'];
      $model->menu_nama = $_GET['LaporankeuanganK']['menu_nama'];
    }

    $judulLaporan = 'RINCIAN KONFIGURASI LAPORAN KEUANGAN';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
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
