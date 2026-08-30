<?php

class IndexingMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public $defaultAction = 'admin';

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $this->render('view', array(
      'model' => $this->loadModel($id),
      'det' =>  IndexingdefM::model()->findAllByAttributes(array('indexing_id' => $id)),
    ));
  }

  /**
   * Creates a new model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   */
  public function actionCreate()
  {
    $model = new IndexingM;
    $model->indexing_step = null;
    // Uncomment the following line if AJAX validation is needed
    $det = array();
    if (isset($_POST['IndexingM'])) {
      $trans = Yii::app()->db->beginTransaction();
      $ok = true;
      $model->attributes = $_POST['IndexingM'];

      $model->indexing_nilai = ($model->indexing_step * 1 / $model->indexing_totbobot);

      // var_dump($_POST, $model->attributes, $model->validate(), $model->errors); die;

      if ($model->validate()) {
        $ok = $ok && $model->save();
      } else $ok = false;

      if (isset($_POST['detail'])) {
        foreach ($_POST['detail']['nama_bobot'] as $idx => $item) {
          $det[$idx] = new IndexingdefM;
          $det[$idx]->indexing_id = $model->indexing_id;
          $det[$idx]->indexingdef_nama = $_POST['detail']['nama_bobot'][$idx];
          $det[$idx]->bobot = $_POST['detail']['nilai_bobot'][$idx];

          if ($det[$idx]->validate()) {
            $ok = $ok && $det[$idx]->save();
          }
        }
      }

      // var_dump($ok); die;

      if ($ok) {
        $trans->commit();
        Yii::app()->user->setFlash('success', '<storng>Berhasil</strong> Data berhasil disimpan');
        $this->redirect(array('admin', 'id' => $model->indexing_id));
      } else {
        $trans->rollback();
        Yii::app()->user->setFlash('error', '<storng>Error</strong> Data gagal disimpan');
        $this->redirect(array('create'));
      }
      /*
			if($model->save()){
				foreach ($_POST['detail']['nama_bobot'] as $idx=>$item) {
					
				}
                Yii::app()->user->setFlash('success','<storng>Berhasil</strong> Data berhasil disimpan');
                $this->redirect(array('admin','id'=>$model->indexing_id));
            } */
    } /*
		if(isset($_POST['IndexingM']))
		{
			$model->attributes=$_POST['IndexingM'];
			if($model->save()){
                                Yii::app()->user->setFlash('success','<storng>Berhasil</strong> Data berhasil disimpan');
				$this->redirect(array('admin','id'=>$model->indexing_id));
                        }
		}
		 * 
		 */

    $this->render('create', array(
      'model' => $model,
      'det' => $det
    ));
  }

  public function actionRemoveTemporary()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    // IndexingM::model()->updateByPk($id, array('indexing_aktif'=>false));
    // $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));

    $id = $_GET['id'];
    if (isset($_GET['id'])) {

      $update = IndexingM::model()->updateByPk($id, array('indexing_aktif' => false));

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
   * Updates a particular model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    $model = $this->loadModel($id);
    $det = array();
    if (empty($model->indexing_offset)) $model->indexing_offset = 0;
    if (empty($model->indexing_totbobot)) $model->indexing_totbobot = 1;
    if (empty($model->indexing_step)) $model->indexing_step = 0;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['IndexingM'])) {
      $trans = Yii::app()->db->beginTransaction();
      $ok = true;
      $model->attributes = $_POST['IndexingM'];

      $model->indexing_nilai = ($model->indexing_step * 1 / $model->indexing_totbobot);

      // var_dump($_POST, $model->attributes, $model->validate(), $model->errors); die;

      if ($model->validate()) {
        $ok = $ok && $model->save();
      } else $ok = false;

      IndexingdefM::model()->deleteAllByAttributes(array(
        'indexing_id' => $model->indexing_id,
      ));

      if (isset($_POST['detail'])) {
        foreach ($_POST['detail']['nama_bobot'] as $idx => $item) {
          $det[$idx] = new IndexingdefM;
          $det[$idx]->indexing_id = $model->indexing_id;
          $det[$idx]->indexingdef_nama = $_POST['detail']['nama_bobot'][$idx];
          $det[$idx]->bobot = $_POST['detail']['nilai_bobot'][$idx];

          if ($det[$idx]->validate()) {
            $ok = $ok && $det[$idx]->save();
          }
        }
      }

      // var_dump($ok); die;

      if ($ok) {
        $trans->commit();
        Yii::app()->user->setFlash('success', '<storng>Berhasil</strong> Data berhasil disimpan');
        $this->redirect(array('admin', 'id' => $model->indexing_id));
      } else {
        $trans->rollback();
        Yii::app()->user->setFlash('error', '<storng>Error</strong> Data gagal disimpan');
        $this->redirect(array('update', 'id' => $model->indexing_id));
      }
      /*
			if($model->save()){
				foreach ($_POST['detail']['nama_bobot'] as $idx=>$item) {
					
				}
                Yii::app()->user->setFlash('success','<storng>Berhasil</strong> Data berhasil disimpan');
                $this->redirect(array('admin','id'=>$model->indexing_id));
            } */
    }

    $model->indexing_nilai = MyFormatter::formatNumberForPrint($model->indexing_nilai, 2);
    $det = IndexingdefM::model()->findAllByAttributes(array(
      'indexing_id' => $id,
    ));

    $this->render('update', array(
      'model' => $model,
      'det' => $det,
    ));
  }

  /**
   * Deletes a particular model.
   * If deletion is successful, the browser will be redirected to the 'admin' page.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id)
  {
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      IndexingdefM::model()->deleteAllByAttributes(array(
        'indexing_id' => $id,
      ));
      $this->loadModel($id)->delete();

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
    $dataProvider = new CActiveDataProvider('IndexingM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {
    $model = new IndexingM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['IndexingM']))
      $model->attributes = $_GET['IndexingM'];

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
    $model = IndexingM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'indexing-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionPrint()
  {

    $model = new IndexingM;
    $model->attributes = $_REQUEST['IndexingM'];
    $judulLaporan = ' Data Indexing';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {

      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas');                            //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }
}
