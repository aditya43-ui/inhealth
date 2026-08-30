<?php

class JenistarifMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.jenistarifM.';
  public $init = '';

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
    $model = new SAJenisTarifM;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SAJenisTarifM'])) {
      $trans = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['SAJenisTarifM'];

        //var_dump($_POST['SAJenisTarifM']['penjamin']);die;

        if ($model->save()) {
          $ok = true;
          if (isset($_POST['SAJenisTarifM']['penjamin'])) {
            foreach ($_POST['SAJenisTarifM']['penjamin'] as $dt) {
              $tarifPen = new JenistarifpenjaminM;
              $tarifPen->jenistarif_id = $model->jenistarif_id;
              $tarifPen->penjamin_id = $dt['penjamin_id'];

              $ok = $ok && $tarifPen->save();
            }
          }

          if ($ok) {
            $trans->commit();
            Yii::app()->user->setFlash('success', "Data " . $model->jenistarif_nama . " berhasil disimpan");
            $this->redirect(array('admin', 'id' => $model->jenistarif_id));
          } else {
            $trans->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan");
          }
        }
      } catch (Exception $e) {
        $trans->rollback();
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

    // Uncomment the following line if AJAX validation is needed
    $loadJnsTrfPen = JenistarifpenjaminM::model()->findAllByAttributes(array('jenistarif_id' => $id));

    if (isset($_POST['SAJenisTarifM'])) {
      $trans = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['SAJenisTarifM'];
        if ($model->save()) {

          $ok = true;

          //var_dump($_POST['SAJenisTarifM']);die;
          if (isset($_POST['SAJenisTarifM']['penjamin'])) {
            $del = JenistarifpenjaminM::model()->deleteAll("jenistarif_id = :p1 ", array(':p1' => $model->jenistarif_id));

            foreach ($_POST['SAJenisTarifM']['penjamin'] as $dt) {
              $tarifPen = new JenistarifpenjaminM;
              $tarifPen->jenistarif_id = $model->jenistarif_id;
              $tarifPen->penjamin_id = $dt['penjamin_id'];

              $ok = $ok && $tarifPen->save();
            }
          } else {
            $del = JenistarifpenjaminM::model()->deleteAll("jenistarif_id = :p1 ", array(':p1' => $model->jenistarif_id));
          }

          if ($ok) {
            $trans->commit();
            Yii::app()->user->setFlash('success', "Data " . $model->jenistarif_nama . " berhasil disimpan");
            $this->redirect(array('admin', 'id' => $model->jenistarif_id));
          } else {
            $trans->rollback();
            Yii::app()->user->setFlash('error', "Data gagal disimpan");
          }
        }
      } catch (Exception $e) {
        echo $e->getMessage();
        $trans->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
      }
    }

    $this->render($this->path_view . 'update', array(
      'model' => $model,
      'loadJnsTrfPen' => $loadJnsTrfPen
    ));
  }

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('SAJenisTarifM');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new SAJenisTarifM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SAJenisTarifM']))
      $model->attributes = $_GET['SAJenisTarifM'];

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
    $model = SAJenisTarifM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sajenis-tarif-m-form') {
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
      $update = SAJenisTarifM::model()->updateByPk($id, array('jenistarif_aktif' => false));
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
    $model = new SAJenisTarifM;
    $model->attributes = $_REQUEST['SAJenisTarifM'];
    $judulLaporan = 'Data Jenis Tarif';
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
      ////$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $formatkonten = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/formatkertasmpdf/A4.css');
      $mpdf->WriteHTML($formatkonten, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 45, 30, 15, 15);

      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionAddPenjaminPasien()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $penjamin_id = isset($_POST['id']) ? $_POST['id'] : null;
      $penjamin_nama = isset($_POST['nama']) ? $_POST['nama'] : null;

      $det = new SAJenisTarifM();
      $det->penjamin_id = $penjamin_id;
      $det->penjamin_nama = $penjamin_nama;

      $sukses = 1;
      $tr = $this->renderPartial($this->path_view . "_formPenjamin", array('det' => $det, 'i' => 0), true);

      echo json_encode(array('tr' => $tr, 'suskes' => $sukses));
    }
  }
}
