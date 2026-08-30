<?php

class AlternatifDxController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public $defaultAction = 'admin';
  public $simpan = true;
  public $path_view = 'sistemAdministrator.views.alternatifDx.';

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
    $model = new SAAlternatifdxM();
    $modDetail = new SAAlternatifdxM;
    if (isset($_POST['SAAlternatifdxM'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $model->attributes = $_POST['SAAlternatifdxM'];

        $this->simpanBatasDetail($_POST['SAAlternatifdxM']['diagnosakep_id'], $_POST['SAAlternatifdxM']);

        if ($this->simpan) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil</strong> Data Berhasil disimpan');
          $this->redirect(array('admin', 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!');
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!' . MyExceptionMessage::getMessage($exc));
      }
    }
    $this->render($this->path_view . 'create', array(
      'model' => $model,
      'modDetail' => $modDetail
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
    $modDetail = new SAAlternatifdxM;
    if (isset($_POST['SAAlternatifdxM'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $this->simpanBatasDetail($_POST['SAAlternatifdxM']['diagnosakep_id'], $_POST['SAAlternatifdxM']);

        if ($this->simpan) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil</strong> Data Berhasil disimpan');
          $this->redirect(array('admin', 'sukses' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!');
        }
      } catch (Exception $exc) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal disimpan!' . MyExceptionMessage::getMessage($exc));
      }
    }

    $this->render($this->path_view . 'update', array(
      'model' => $model,
      'modDetail' => $modDetail
    ));
  }

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('SAAlternatifdxM');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $model = new SAAlternatifdxM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SAAlternatifdxM'])) {
      $model->attributes = $_GET['SAAlternatifdxM'];
      $model->diagnosakep_nama = isset($_GET['SAAlternatifdxM']['diagnosakep_nama']) ? $_GET['SAAlternatifdxM']['diagnosakep_nama'] : NULL;
      $model->aktif = isset($_GET['aktif']) ? $_GET['aktif'] : NULL;
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

    $model = SAAlternatifdxM::model()->findBySql('SELECT alternatifdx_m.*,diagnosakep_m.diagnosakep_nama
			FROM alternatifdx_m
			JOIN diagnosakep_m ON diagnosakep_m.diagnosakep_id = alternatifdx_m.diagnosakep_id
			WHERE alternatifdx_m.alternatifdx_id =' . $id);

    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'salookup-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function simpanBatas($post)
  {
    $model = new SAAlternatifdxM;
    $model->attributes = $post;

    if (!$model->save()) {
      $this->simpan &= false;
    }
  }

  public function simpanBatasDetail($diagnosakep_id, $post)
  {
    foreach ($post as $i => $row) {
      if (is_numeric($i)) {
        $batkar = SAAlternatifdxM::model()->findByAttributes(array('diagnosakep_id' => $diagnosakep_id, 'alternatifdx_nama' => $row['alternatifdx_nama']));
        if (!empty($batkar) || !empty($row['alternatifdx_id'])) {
          SAAlternatifdxM::model()->updateByPk($row['alternatifdx_id'], array(
            'alternatifdx_nama' => $row['alternatifdx_nama'],
            'alternatifdx_aktif' => $row['alternatifdx_aktif']
          ));
          $this->simpan &= true;
        } else {
          $model = new SAAlternatifdxM;
          $model->attributes = $row;
          $model->diagnosakep_id = $diagnosakep_id;
          $model->alternatifdx_nama = $row['alternatifdx_nama'];
          $model->alternatifdx_aktif = $row['alternatifdx_aktif'];
          if (!$model->save()) {
            $this->simpan &= false;
          }
        }
      }
    }
  }

  public function actionPrint()
  {
    $model = new SAAlternatifdxM;
    $model->attributes = $_REQUEST['SAAlternatifdxM'];
    $judulLaporan = 'Data Alternatif Diagnosa';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');   //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');   //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionGetLookup($diagnosakep_id)
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $model = new SAAlternatifdxM();
      $batkar = SAAlternatifdxM::model()->findByAttributes(array('diagnosakep_id' => $diagnosakep_id));
      $data['form'] = "";
      $models = $this->loadModelByType($diagnosakep_id);
      if (count((array)$models) > 0) {
        foreach ($models as $i => $model) {
          $data['form'] .= $this->renderPartial($this->path_view . '_rowLookup', array('model' => $model), true);
        }
      } else {
        $data['form'] .= $this->renderPartial($this->path_view . '_rowLookup', array('model' => $model), true);
      }
      echo CJSON::encode($data);
      Yii::app()->end();
    }
  }

  private function loadModelByType($diagnosakep_id)
  {
    $model = SAAlternatifdxM::model()->findAllByAttributes(array('diagnosakep_id' => $diagnosakep_id), array('order' => 'alternatifdx_id'));
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  public function actionDelete()
  {
    if (Yii::app()->request->isPostRequest) {
      $id = $_POST['id'];
      SAAlternatifdxM::model()->deleteByPk($id);
      if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(array(
          'status' => 'proses_form',
          'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
        ));
        exit;
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
   * Mengubah status aktif
   * @param type $id 
   */
  public function actionremoveTemporary()
  {
    $id = $_POST['id'];
    if (isset($_POST['id'])) {
      $update = SAAlternatifdxM::model()->updateByPk($id, array('alternatifdx_aktif' => false));
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
}
