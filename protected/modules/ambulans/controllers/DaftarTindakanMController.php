
<?php

class DaftarTindakanMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';

  public function actionCreateRuangan()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                                             
    $model = new TindakanruanganM;
    if (isset($_POST['TindakanruanganM'])) {

      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlahRuangan = count((array)$_POST['ruangan_id']);
        $daftarTindakan_id = $_POST['TindakanruanganM']['daftartindakan_id'];
        $hapusTindakanRuangan = TindakanruanganM::model()->deleteAll('daftartindakan_id=' . $daftarTindakan_id . '');
        for ($i = 0; $i <= $jumlahRuangan; $i++) {
          $modTindakanRuangan = new TindakanruanganM;
          $modTindakanRuangan->ruangan_id = $_POST['ruangan_id'][$i];
          $modTindakanRuangan->daftartindakan_id = $daftarTindakan_id;
          $modTindakanRuangan->save();
        }

        Yii::app()->user->setFlash('success', "Data Ruangan Dan Daftar Tindakan Berhasil Disimpan");
        $transaction->commit();
        $this->redirect(array('admin'));
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Ruangan Dan Daftar Tindakan Gagal Disimpan");
      }
    }
    $this->render('createRuangan', array(
      'model' => $model
    ));
  }

  /**
   * Displays a particular model.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $this->render('view', array(
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
    $model = new SADaftarTindakanM;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SADaftarTindakanM'])) {
      $model->attributes = $_POST['SADaftarTindakanM'];
      $model->daftartindakan_aktif = TRUE;
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('admin', 'id' => $model->daftartindakan_id));
      }
    }

    $this->render('create', array(
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
    $modRuangan = TindakanruanganM::model()->findAll('daftartindakan_id=' . $id . '');

    // Uncomment the following line if AJAX validation is needed

    //
    //		if(isset($_POST['SADaftarTindakanM']))
    //		{
    //			$model->attributes=$_POST['SADaftarTindakanM'];
    //			if($model->save()){
    //                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
    //				$this->redirect(array('view','id'=>$model->daftartindakan_id));
    //                        }
    //		}
    //                

    if (isset($_POST['SADaftarTindakanM'])) {

      $jumlahRuangan = count((array)$_POST['ruangan_id']);
      $daftarTindakan_id = $model->daftartindakan_id;
      $hapusTindakanRuangan = TindakanruanganM::model()->deleteAll('daftartindakan_id=' . $daftarTindakan_id . '');
      $transaction = Yii::app()->db->beginTransaction();
      try {
        if ($jumlahRuangan > 0) {

          for ($i = 0; $i <= $jumlahRuangan; $i++) {
            $modTindakanRuangan = new TindakanruanganM;
            $modTindakanRuangan->ruangan_id = $_POST['ruangan_id'][$i];
            $modTindakanRuangan->daftartindakan_id = $daftarTindakan_id;
            $modTindakanRuangan->save();
          }
          $model->attributes = $_POST['SADaftarTindakanM'];
          $model->save();
        }
        Yii::app()->user->setFlash('success', "Data Ruangan Dan Daftar Tindakan Berhasil Disimpan");
        $transaction->commit();
        $this->redirect(array('admin'));
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Ruangan DanDaftar Tindakan Gagal Disimpan");
      }
    }

    $this->render('update', array(
      'model' => $model, 'modRuangan' => $modRuangan
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
      //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}                                         

      // we only allow deletion via POST request
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $hapusTindakanRuangan = TindakanruanganM::model()->deleteAll('daftartindakan_id=' . $id . '');
        $this->loadModel($id)->delete();
        $transaction->commit();
      } catch (Exception $e) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data Ruangan Dan Daftar Tindakan Gagal Dihapus");
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
    $dataProvider = new CActiveDataProvider('SADaftarTindakanM');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Manages all models.
   */
  public function actionAdmin()
  {

    $model = new SADaftarTindakanM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SADaftarTindakanM']))
      $model->attributes = $_GET['SADaftarTindakanM'];

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
    $model = SADaftarTindakanM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sadaftar-tindakan-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   *Mengubah status aktif
   * @param type $id 
   */
  public function actionRemoveTemporary($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    SADaftarTindakanM::model()->updateByPk($id, array('daftartindakan_aktif' => false));
    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function actionPrint()
  {

    $model = new SADaftarTindakanM();
    $model->attributes = $_REQUEST['SADaftarTindakanM()'];
    $judulLaporan = 'Daftar Tindakan';
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
      $mpdf->mirrorMargins = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
