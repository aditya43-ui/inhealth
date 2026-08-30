<?php

class SubsubkelompokMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.subsubkelompokM.';
  public $path_tips = 'sistemAdministrator.views.tips.';

  /**
   * @return array action filters
   */
  public function filters()
  {
    return array(
      'accessControl', // perform access control for CRUD operations
    );
  }

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
    $model = new SASubsubkelompokM;

    // Uncomment the following line if AJAX validation is needed
    // $this->performAjaxValidation($model);

    if (isset($_POST['SASubsubkelompokM'])) {
      $model->attributes = $_POST['SASubsubkelompokM'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('admin', 'id' => $model->subsubkelompok_id));
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
    $model->temp_subkel_id = $model->subkelompok_id;
    $model->temp_kode_subsubkel = $model->subsubkelompok_kode;

    // Uncomment the following line if AJAX validation is needed
    // $this->performAjaxValidation($model);

    if (isset($_POST['SASubsubkelompokM'])) {
      $model->attributes = $_POST['SASubsubkelompokM'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('admin', 'id' => $model->subsubkelompok_id));
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


  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('SASubsubkelompokM');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $model = new SASubsubkelompokM('search');
    $model->unsetAttributes();  // clear any default values
    $model->dropdown_bidang = $model->getBidang();
    $model->dropdown_kelompok = $model->getKelompok();
    $model->dropdown_subkelompok = $model->getSubKelompok();

    if (isset($_GET['SASubsubkelompokM'])) {
      $model->attributes = $_GET['SASubsubkelompokM'];
      $model->golongan_id = !empty($_GET['SASubsubkelompokM']['golongan_id']) ? $_GET['SASubsubkelompokM']['golongan_id'] : null;
      $model->bidang_id = !empty($_GET['SASubsubkelompokM']['bidang_id']) ? $_GET['SASubsubkelompokM']['bidang_id'] : null;
      $model->kelompok_id = !empty($_GET['SASubsubkelompokM']['kelompok_id']) ? $_GET['SASubsubkelompokM']['kelompok_id'] : null;
      $model->dropdown_bidang = $model->getBidang();
      $model->dropdown_kelompok = $model->getKelompok();
      $model->dropdown_subkelompok = $model->getSubKelompok();
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
    $model =  SASubsubkelompokM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'subsubkelompok-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionDelete()
  {
    if (Yii::app()->request->isPostRequest) {
      $id = $_POST['id'];
      $bidang = BarangM::model()->findByAttributes(array('subsubkelompok_id' => $id));
      if ($bidang) {
        echo CJSON::encode(array(
          'status' => 'gagal_form',
          'div' => "<div class='flash-alert'>Maaf data ini tidak bisa dihapus dikarenakan digunakan pada table lain..</div>",
        ));
        exit;
        throw new CHttpException(400, 'Maaf data ini tidak bisa dihapus dikarenakan digunakan pada table lain.');
      } else {
        $this->loadModel($id)->delete();
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
            'div' => "<div class='flash-success'>Data berhasil dihapus.</div>",
          ));
          exit;
        }
      }

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    /*if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');*/
  }

  public function actionRemoveTemporary()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    //                    SAPropinsiM::model()->updateByPk($id, array('propinsi_aktif'=>false));
    //                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));

    $id = $_POST['id'];
    if (isset($_POST['id'])) {
      $update = SASubsubkelompokM::model()->updateByPk($id, array('subsubkelompok_aktif' => false));
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
    $model = new SASubsubkelompokM;
    $model->attributes = $_REQUEST['SASubsubkelompokM'];
    $judulLaporan = 'Data Sub SUb Kelompok';
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

  public function actionKodeSubSubKelompok()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $subkelompok_id = !empty($_POST['subkelompok_id']) ? $_POST['subkelompok_id'] : null;
      $data = array();
      if (!empty($subkelompok_id)) {
        $kodeSubKelompok = SASubkelompokM::model()->findByPk($subkelompok_id)->subkelompok_kode;

        $kodeBaru = MyGenerator::kodeSubSubKelompok($kodeSubKelompok);

        $data['sukses'] = 'kodebaru';
        $data['kodebaru'] = $kodeBaru;
      } else {
        $data['sukses'] = 'kosong';
        $data['kodebaru'] = '';
      }

      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
