<?php

class FormulaObatKronisController extends MyAuthController {

    // public $path_view = 'farmasiApotek.views.formulaObatKronis.';
    public $layout = '//layouts/column1';
    public $defaultAction = 'admin';


    public function actionView($id)
    {
      $this->render('view', array(
        'model' => $this->loadModel($id),
      ));
    }
    public function actionAdmin($sukses = '')
    {
      $this->pageTitle = Yii::app()->name . " - Formula Obat Kronis";
      $model = new FormulaobatkronisM();
      $model->unsetAttributes();
      if (isset($_GET['FormulaobatkronisM'])) {
        $model->attributes = $_GET['FormulaobatkronisM'];
        $model->jumlahobat = isset($_GET['FormulaobatkronisM']['jumlahobat']) ? $_GET['FormulaobatkronisM']['jumlahobat'] : '';
        $model->is_aktif = isset($_GET['FormulaobatkronisM']['is_aktif']) ? $_GET['FormulaobatkronisM']['is_aktif'] : '';
        
//                  echo '<pre>';var_dump($model->attributes); die();

      }
  
      $this->render('admin', array('model' => $model));
    }


    /**
     * create formula obat krinis
     */
    public function actionCreate($formulaobatkronis_id=null)
  {
    $model = new FormulaobatkronisM;
      if(!empty($formulaobatkronis_id)){
        $model = FormulaobatkronisM::model()->findByPk($formulaobatkronis_id);
      }
      
  
    if (isset($_POST['FormulaobatkronisM'])) {
                            //  echo print_r($_POST['FormulaobatkronisM']);
                            //  exit();
      $transaction = Yii::app()->db->beginTransaction();
      try {
       $model = new FormulaobatkronisM;
       $model->attributes = $_POST['FormulaobatkronisM'];
       $model->is_aktif = true;
       $model->create_time = date('Y-m-d H:i:s');
       $model->create_loginpemakai_id = Yii::app()->user->id;
       $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        if ($model->validate()) {
        $model->save();
          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil</strong> Data Berhasil disimpan');
       $this->redirect(array('admin','formulaobatkronis_id'=>$model->formulaobatkronis_id,'sukses'=>1));
        } else {
          $transaction->rollback();
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data gagal disimpan' . MyExceptionMessage::getMessage($ex));
      }
    }
    $this->render('create', array('model' => $model));
  }

 /**
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    $model = $this->loadModel($id);
    if (isset($_POST['FormulaobatkronisM'])) {
        if($_POST['FormulaobatkronisM']['is_aktif'] == 1){
            $model->is_aktif = true;
        }else{
            $model->is_aktif = false;
        }
      $model->attributes = $_POST['FormulaobatkronisM'];
      $model->update_time = date('Y-m-d H:i:s');
      $model->update_loginpemakai_id = Yii::app()->user->id;
   
      if ($model->save()) {
        Yii::app()->user->setFlash('success', "Data  berhasil diupdate");
       $this->redirect(array('admin','formulaobatkronis_id'=>$model->formulaobatkronis_id,'sukses'=>1));
      } else {
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
      }
    }

    $this->render('update', array(
      'model' => $model,
    ));
  }
  /**
   * Mengubah status aktif
   * @param type $id 
   */
  public function actionRemoveTemporary()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //                    SAPropinsiM::model()->updateByPk($id, array('propinsi_aktif'=>false));
    //                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));


    $id = $_POST['id'];
    if (isset($_POST['id'])) {
      $update = FormulaobatkronisM::model()->updateByPk($id, array('is_aktif' => false));
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
   * delete data
   */


  public function actionDelete()
  {
    $id = $_POST['id'];
    if (isset($_POST['id'])) {
      $delete = $this->loadModel($id)->delete();
      if ($delete) {
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
   * print
   */

  public function actionPrint()
  {
    $model = new FormulaobatkronisM;
    $model->attributes = $_REQUEST['FormulaobatkronisM'];
    $judulLaporan = 'Data Formulir Obat Krinis';
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
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '-' . date('Y-m-d') . '.pdf', 'I');
    }
  }

 /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = FormulaobatkronisM::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  

}