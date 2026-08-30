<?php
class GrupLayananKasirOaController extends MyAuthController
{
  public $layout = '//layouts/iframe'; //diakses dari tab menu master - master obat
  public $defaultAction = 'admin';

  public $path_view = 'keuangan.views.grupLayananKasirOa.';

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
    $model = new KUGrouplayanankasiroaM();
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['KUGrouplayanankasiroaM'])) {
      $ok = true;
      $trans = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['KUGrouplayanankasiroaM'];

        $ok = $ok && $model->save();

        if ($ok) {
          $trans->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('admin'));
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
        }
      } catch (Exception $e) {
        //echo $e->getMessage();
        $trans->rollback();
        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
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
    $model->jenisobatalkes_nama = $model->jenisobatalkes->jenisobatalkes_nama;
    $model->grouplayanan_nama =  $model->grouplayanan->grouplayanan_nama;

    // Uncomment the following line if AJAX validation is needed		
    if (isset($_POST['KUGrouplayanankasiroaM'])) {
      $ok = true;
      $trans = Yii::app()->db->beginTransaction();
      try {

        $model->attributes = $_POST['KUGrouplayanankasiroaM'];


        $ok = $ok && $model->save();
        if ($ok) {
          $trans->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('admin'));
        } else {
          $trans->rollback();
          Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
        }
      } catch (Exception $e) {
        $trans->rollback();
        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan.');
      }
    }
    $this->render($this->path_view . 'update', array(
      'model' => $model,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new KUGrouplayanankasiroaM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['KUGrouplayanankasiroaM'])) {
      $model->attributes = $_GET['KUGrouplayanankasiroaM'];
      $model->grouplayanan_nama = isset($_GET['KUGrouplayanankasiroaM']['grouplayanan_nama']) ? $_GET['KUGrouplayanankasiroaM']['grouplayanan_nama'] : null;
      $model->jenisobatalkes_nama = isset($_GET['KUGrouplayanankasiroaM']['jenisobatalkes_nama']) ? $_GET['KUGrouplayanankasiroaM']['jenisobatalkes_nama'] : null;
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
    $model = KUGrouplayanankasiroaM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'gfgenerik-m-form') {
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


  public function actionPrint()
  {
    $model = new KUGrouplayanankasiroaM;
    $model->attributes = $_REQUEST['KUGrouplayanankasiroaM'];
    $judulLaporan = 'Data Grup Layanan Kasir Obat dan Alkes';
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
      $mpdf->Output($judulLaporan . '-' . date("Y/m/d") . '.pdf', 'I');
    }
  }
}
