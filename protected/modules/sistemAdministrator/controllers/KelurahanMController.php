<?php

class KelurahanMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.kelurahanM.';
  public $path_tips = 'sistemAdministrator.views.tips.';

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
    $model = new SAKelurahanM;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SAKelurahanM'])) {
      $trans = Yii::app()->db->beginTransaction();
      $valid = true;

      foreach ($_POST['SAKelurahanM'] as $i => $item) {
        if (is_integer($i)) {
          $model = new SAKelurahanM;
          if (isset($_POST['SAKelurahanM'][$i]))
            $model->attributes = $_POST['SAKelurahanM'][$i];
          $model->kecamatan_id = $_POST['SAKelurahanM']['kecamatan_id'];
          $model->kelurahan_aktif = true;
          $valid = $model->validate() && $valid;
          var_dump($valid);
          if ($valid)
            $valid &= $model->save();
        }
      }

      if ($valid) {
        $trans->commit();
        Yii::app()->user->setFlash('success', "Data " . $model->kelurahan_nama . " berhasil disimpan");
        $this->redirect(array('admin', 'sukses' => 1));
      } else {
        $trans->rollback();
        Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data tidak valid.');
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


    if (isset($_POST['SAKelurahanM'])) {
      $model->attributes = $_POST['SAKelurahanM'];
      $model->kelurahan_aktif = $_POST['SAKelurahanM']['kelurahan_aktif'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', "Data " . $model->kelurahan_nama . " berhasil disimpan");
        $this->redirect(array('admin', 'id' => $model->kelurahan_id, 'sukses' => 1));
      } else {
      }
    }

    $this->render($this->path_view . 'update', array(
      'model' => $model,
    ));
  }

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('SAKelurahanM');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $this->pageTitle = Yii::app()->name . " - Kelurahan";
    $model = new SAKelurahanM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SAKelurahanM']))
      $model->attributes = $_GET['SAKelurahanM'];

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
    $model = SAKelurahanM::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(401, 'The requested page does not exist.');
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sakelurahan-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionDynamicKabupaten()
  {
    $data = KabupatenM::model()->findAll('propinsi_id=:prop_id', array(':prop_id' => (int) $_POST['propinsi'],), array('order' => 'kabupaten_nama'));

    $data = CHtml::listData($data, 'kabupaten_id', 'kabupaten_nama');

    if (empty($data)) {
      echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
    } else {
      echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      foreach ($data as $value => $name) {
        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
    }
  }

  public function actionDynamicKecamatan()
  {
    $data = KecamatanM::model()->findAll('kabupaten_id=:kab_id', array(':kab_id' => (int) $_POST['kabupaten'],), array('order' => 'kabupaten_nama'));

    $data = CHtml::listData($data, 'kecamatan_id', 'kecamatan_nama');

    if (empty($data)) {
      echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
    } else {
      echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
      foreach ($data as $value => $name) {
        echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }
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
        exit();
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
      $update = SAKelurahanM::model()->updateByPk($id, array('kelurahan_aktif' => false));
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

    $model = new SAKelurahanM;
    $model->unsetAttributes();  // clear any default values

    $model->attributes = $_REQUEST['SAKelurahanM'];
    if (isset($_GET['SAKelurahanM']))
      $model->attributes = $_GET['SAKelurahanM'];
    $judulLaporan = ' Data Kelurahan';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {

      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                            //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 45, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  /**
   * menambah kelurahan dari tombol "+" (Dialog Box)
   */
  public function actionAddKelurahan()
  {
    $modelKel = new KelurahanM;

    if (isset($_POST['KelurahanM'])) {
      $modelKel->attributes = $_POST['KelurahanM'];
      $modelKel->kelurahan_aktif = true;
      if ($modelKel->save()) {
        $data = KelurahanM::model()->findAllByAttributes(array('kecamatan_id' => $_POST['KelurahanM']['kecamatan_id']), array('order' => 'kelurahan_nama'));
        $data = CHtml::listData($data, 'kelurahan_id', 'kelurahan_nama');

        if (empty($data)) {
          $kelurahanOption = CHtml::tag('option', array('value' => ''), CHtml::encode('-Pilih-'), true);
        } else {
          $kelurahanOption = CHtml::tag('option', array('value' => ''), CHtml::encode('-Pilih-'), true);
          foreach ($data as $value => $name) {
            $kelurahanOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }

        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Kelurahan <b>" . $_POST['KelurahanM']['kelurahan_nama'] . "</b> berhasil ditambahkan </div>",
            'kelurahan' => $kelurahanOption,
          ));
          exit;
        }
      }
    }

    if (Yii::app()->request->isAjaxRequest) {
      echo CJSON::encode(array(
        'status' => 'create_form',
        'div' => $this->renderPartial('_formAddKelurahan', array('model' => $modelKel,), true)
      ));
      exit;
    }
  }

  public function actionGetListKecamatan()
  {
    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
      $data = KecamatanM::model()->findAllByAttributes(array('kabupaten_id' => $_POST['idKab'], 'kecamatan_id' => $_POST['idKec'],), array('order' => 'kecamatan_nama'));
      $data = CHtml::listData($data, 'kecamatan_id', 'kecamatan_nama');

      foreach ($data as $value => $name) {
        if ($value == $_POST['idKec'])
          $kecamatanOption .= CHtml::tag('option', array('value' => $value, 'selected' => true), CHtml::encode($name), true);
        else
          $kecamatanOption .= CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
      }

      $dataList['listKecamatan'] = $kecamatanOption;

      echo json_encode($dataList);
      Yii::app()->end();
    }
  }
}
