<?php

class KelasruanganMController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';

  public function actionIndex()
  {
    $this->render('index');
  }

  public function actionAdmin()
  {
    $model = new KelasruanganM('search');
    $model->unsetAttributes();
    if (isset($_GET['KelasruanganM']))
      $model->attributes = $_GET['KelasruanganM'];
    $this->render('admin', array('model' => $model));
  }

  public function actionCreate()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))
    //    {throw new CHttpException(401,Yii::t('mds','You are probihited to access this page. Contact Super Administrator'));}
    $model = new KelasruanganM;
    if (isset($_POST['kelaspelayanan_id'])) {
      $modDetails = $this->validasiTabular($_POST['kelaspelayanan_id']);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlah = 0;
        for ($i = 0; $i < count((array)$_POST['kelaspelayanan_id']); $i++) {
          $model = new KelasruanganM;
          $model->ruangan_id = $_POST['ruanganid'];
          $model->kelaspelayanan_id = $_POST['kelaspelayanan_id'][$i];
          if ($model->save()) {
            $jumlah++;
          }
        }
        if ($jumlah == count((array)$_POST['kelaspelayanan_id'])) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', 'Data Berhasil disimpan');
          $this->redirect(array('admin'));
        } else {
          $transaction->rollback();
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', 'Data Gagal disimpan' . MyExceptionMessage::getMessage($ex));
      }
      //                                        Yii::app()->user->setFlash('success','<strong>Berhasil</strong>Data Berhasil disimpan');
      //                                        $this->redirect(array('admin'));
    }
    $this->render('create', array('model' => $model, 'modDetails' => $modDetails));
  }

  protected function validasiTabular($data)
  {
    foreach ($data as $i => $row) {
      $modDetails[$i] = new KelasruanganM;
      $modDetails[$i]->ruangan_id = Yii::app()->user->ruangan_id;
      $modDetails[$i]->kelaspelayanan_id = $row;
      $modDetails[$i]->validate();
    }
    return $modDetails;
  }

  public function actionUpdate($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))
    //    {throw new CHttpException(401,Yii::t('mds','You are probihited to access this page. Contact Super Administrator'));}
    $model = new KelasruanganM;
    if (isset($_POST['kelaspelayanan_id'])) {
      $modDetails = $this->validasiTabular($_POST['kelaspelayanan_id']);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlah = 0;
        for ($i = 0; $i < count((array)$_POST['kelaspelayanan_id']); $i++) {
          $model = new KelasruanganM;
          $model->ruangan_id = $_POST['ruanganid'];
          $model->kelaspelayanan_id = $_POST['kelaspelayanan_id'][$i];
          if ($model->save()) {
            $jumlah++;
          }
        }
        if ($jumlah == count((array)$_POST['kelaspelayanan_id'])) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', 'Data Berhasil disimpan');
          $this->redirect(array('admin'));
        } else {
          $transaction->rollback();
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', 'Data Gagal disimpan' . MyExceptionMessage::getMessage($ex));
      }
      //                                        Yii::app()->user->setFlash('success','<strong>Berhasil</strong>Data Berhasil disimpan');
      //                                        $this->redirect(array('admin'));
    }
    $this->render('update', array('model' => $model, 'modDetails' => $modDetails));
  }

  public function actionDelete($ruangan_id, $kelaspelayanan_id)
  {
    $this->loadModel($ruangan_id, $kelaspelayanan_id)->delete();
    if (!isset($_GET['ajax']))
      $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function actionView($id)
  {
    $this->render('view', array(
      'model' => $this->loadModel($id),
    ));
  }

  public function loadModel($id, $kelaspelayanan = null)
  {
    if (empty($kelaspelayanan)) {
      $model = KelasruanganM::model()->findByAttributes(array('ruangan_id' => $id));
    } else {
      $model = KelasruanganM::model()->findByAttributes(array('ruangan_id' => $id, 'kelaspelayanan_id' => $kelaspelayanan));
    }
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  public function actionPrint()
  {
    $model = new KelasruanganM;
    $model->attributes = $_REQUEST['KelasruanganM'];
    $judulLaporan = 'Data Kelas Ruangan';
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
      $mpdf->Output();
    }
  }


  // Uncomment the following methods and override them if needed
  /*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
