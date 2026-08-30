<?php

/**
 * Admin master PTKP
 * 
 * @author      Deni Hamdani <denihamdani@piindonesia.co.id>
 * @package     application.modules.sistemAdministrator
 * @subpackage  controllers
 * @category    controller
 */
class PtkpMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.ptkpM.';
  public $path_view_tab = 'sistemAdministrator.views.ptkpM.';
  public $hasTab = false;

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function init()
  {
    parent::init();
    if ($this->hasTab) {
      $this->layout = '//layouts/iframe';
    }
  }

  /**
   * Melihat detail PTKP
   * @param integer $id
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
    $model = new SAPtkpM;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SAPtkpM'])) {
      $model->attributes = $_POST['SAPtkpM'];
      $model->tglberlaku = MyFormatter::formatDateTimeForDb($model->tglberlaku);

      $model->berlaku = true;
      $model->jmltanggunan = MyFormatter::formatRupiahForDB($model->jmltanggunan);
      $model->wajibpajak_thn = MyFormatter::formatRupiahForDB($model->wajibpajak_thn);
      $model->wajibpajak_bln = MyFormatter::formatRupiahForDB($model->wajibpajak_bln);

      if ($model->save()) {
        Yii::app()->user->setFlash('success', 'Data ' . $model->statusperkawinan . ' berhasil disimpan.');
        if ($this->hasTab) {
          $this->redirect(array('admin', 'id' => $model->ptkp_id));
        } else {
          $this->redirect(array('admin', 'sukses' => 1));
        }
      } else {
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
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
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                                                        
    $model = $this->loadModel($id);
    $model->wajibpajak_thn = MyFormatter::formatNumberForPrint($model->wajibpajak_thn);
    $model->wajibpajak_bln = MyFormatter::formatNumberForPrint($model->wajibpajak_bln);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SAPtkpM'])) {
      $model->attributes = $_POST['SAPtkpM'];

      $model->jmltanggunan = MyFormatter::formatRupiahForDB($model->jmltanggunan);
      $model->wajibpajak_thn = MyFormatter::formatRupiahForDB($model->wajibpajak_thn);
      $model->wajibpajak_bln = MyFormatter::formatRupiahForDB($model->wajibpajak_bln);


      $model->berlaku = true;

      if ($model->save()) {
        Yii::app()->user->setFlash('success', 'Data ' . $model->statusperkawinan . ' berhasil disimpan.');
        if ($this->hasTab) {
          $this->redirect(array('admin', 'id' => $model->ptkp_id));
        } else {
          $this->redirect(array('admin', 'sukses' => 1));
        }
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
    /* if (Yii::app()->request->isPostRequest) {
          // we only allow deletion via POST request
          //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
          $this->loadModel($id)->delete();

          // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
          if (!isset($_GET['ajax']))
          $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
          } else
          throw new CHttpExeption(400, 'Invalid request. Please do not repeat this request again.'); */
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
    $dataProvider = new CActiveDataProvider('SAPtkpM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin($sukses = '')
  {

    //        if ($sukses == 1) {
    //            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
    //        }
    $model = new SAPtkpM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SAPtkpM']))
      $model->attributes = $_GET['SAPtkpM'];

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
    $model = SAPtkpM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'ptkp-m-form') {
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
    //SAPtkpM::model()->updateByPk($id, array('berlaku' => false));
    //$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    $id = $_POST['id'];
    if (isset($_POST['id'])) {
      $update = SAPtkpM::model()->updateByPk($id, array('berlaku' => false));
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
   * Printout Master PTKP
   */
  public function actionPrint()
  {
    $model = new SAPtkpM;
    $model->attributes = $_REQUEST['SAPtkpM'];
    $judulLaporan = 'Data PTKP';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');      //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');         //Posisi L->Landscape,P->Portait
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
