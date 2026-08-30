<?php

class NilaipoinController extends MyAuthController
{
  public $path_view = 'sistemAdministrator.views.nilaipoin.';

  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  //public $layout='//layouts/column2';

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
    $model = new NilaipoinM;
    $model->nilaipoin_tgl = date('Y-m-d');
    $model->nilaipoin_tgl_sd = date('Y-m-d');

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['NilaipoinM'])) {
      $ok = true;
      $trans = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['NilaipoinM'];
        $model->nilaipoin_tgl = MyFormatter::formatDateTimeForDb($model->nilaipoin_tgl);
        $model->nilaipoin_tgl_sd = MyFormatter::formatDateTimeForDb($model->nilaipoin_tgl_sd);
        $model->nilaipoin_aktif = true;
        $model->create_time = date('Y-m-d H:i:s');
        $model->create_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
        $ok = $ok && $model->save();


        if ($ok) {
          Yii::app()->user->setFlash('success', "Data " . $model->nilaipoin_nama . " Sukses Disimpan.");
          $trans->commit();
          $this->redirect(array('admin', 'id' => $model->nilaipoin_id));
        } else {
          Yii::app()->user->setFlash('error', "Data Gagal Disimpan.");
          $trans->rollback();
        }
      } catch (Exception $e) {
        Yii::app()->user->setFlash('error', "Data Gagal Disimpan.");
        $trans->rollback();
      }
    }

    $this->render($this->path_view . 'create', array(
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


    if (isset($_POST['NilaipoinM'])) {
      $model->attributes = $_POST['NilaipoinM'];
      $model->nilaipoin_tgl = MyFormatter::formatDateTimeForDb($model->nilaipoin_tgl);
      $model->nilaipoin_tgl_sd = MyFormatter::formatDateTimeForDb($model->nilaipoin_tgl_sd);
      $model->update_time = date('Y-m-d H:i:s');
      $model->update_loginpemakai_id = Yii::app()->user->getState('loginpemakai_id');

      if ($model->save()) {
        Yii::app()->user->setFlash('success', "Data " . $model->nilaipoin_nama . " Sukses Disimpan.");
        $this->redirect(array('view', 'id' => $model->nilaipoin_id));
      } else {
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
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
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('NilaipoinM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $model = new NilaipoinM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['NilaipoinM']))
      $model->attributes = $_GET['NilaipoinM'];

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
    $model = NilaipoinM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'nilaipoin-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   * Mengubah status aktif
   * @param type $id 
   */
  public function actionRemoveTemporary()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //SAPangkatM::model()->updateByPk($id, array('pangkat_aktif'=>false));
    //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    $id = $_POST['id'];
    if (isset($_POST['id'])) {
      $update = NilaipoinM::model()->updateByPk($id, array('nilaipoin_aktif' => false));
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
    $model = new NilaipoinM;
    $model->attributes = $_REQUEST['NilaipoinM'];
    $judulLaporan = 'Data Nilai Poin';
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

      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 45, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }
}
