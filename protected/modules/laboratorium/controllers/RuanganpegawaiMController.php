<?php

class RuanganpegawaiMController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'laboratorium.views.ruanganpegawaiM.';

  public function actionIndex()
  {
    $this->render('index');
  }

  public function actionAdmin()
  {
    $model = new RuanganpegawaiM('search');
    $model->unsetAttributes();
    if (isset($_GET['RuanganpegawaiM']))
      $model->attributes = $_GET['RuanganpegawaiM'];
    $this->render($this->path_view . 'admin', array('model' => $model));
  }

  public function actionCreate()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))
    // {
    //     throw new CHttpException(401,'mds','You are probihited to access this page. Contact Super Administrator');
    // }
    $model = new RuanganpegawaiM;
    $ruangansession = Yii::app()->user->ruangan_id;
    if (isset($_POST['pegawai_id'])) {
      $modDetails = $this->validasiTabular($_POST['pegawai_id']);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlah = 0;
        for ($i = 0; $i < count((array)$_POST['pegawai_id']); $i++) {
          $model = new RuanganpegawaiM;
          $model->ruangan_id = $ruangansession;
          $model->pegawai_id = $_POST['pegawai_id'][$i];
          if ($model->save()) {;
            $jumlah++;
          }
        }
        if ($jumlah == count((array)$_POST['pegawai_id'])) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil</strong> Data Berhasil disimpan');
          $this->redirect(array('admin'));
        } else {
          $transaction->rollback();
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('Error', '<strong>Gagal</strong> Data gagal disimpan' . MyExceptionMessage::getMessage($ex));
      }
    }
    $this->render($this->path_view . 'create', array('model' => $model));
  }

  protected function validasiTabular($data)
  {
    foreach ($data as $i => $row) {
      $modDetails[$i] = new RuanganpegawaiM;
      $modDetails[$i]->instalasi_id = Yii::app()->user->instalasi_id;
      $modDetails[$i]->ruangan_id = Yii::app()->user->ruangan_id;
      $modDetails[$i]->pegawai_id = $row;
      $modDetails[$i]->validate();
    }

    return $modDetails;
  }

  public function actionUpdate()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))
    // {
    //     throw new CHttpException(401,'mds','You are probihited to access this page. Contact Super Administrator');
    // }
    $model = new RuanganpegawaiM;
    $ruangansession = Yii::app()->user->ruangan_id;
    if (isset($_POST['pegawai_id'])) {
      $modDetails = $this->validasiTabular($_POST['pegawai_id']);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlah = 0;
        for ($i = 0; $i < count((array)$_POST['pegawai_id']); $i++) {
          $model = new RuanganpegawaiM;
          $model->ruangan_id = $ruangansession;
          $model->pegawai_id = $_POST['pegawai_id'][$i];
          if ($model->save()) {;
            $jumlah++;
          }
        }
        if ($jumlah == count((array)$_POST['pegawai_id'])) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil</strong> Data Berhasil disimpan');
          $this->redirect(array('admin'));
        } else {
          $transaction->rollback();
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('Error', '<strong>Gagal</strong> Data gagal disimpan' . MyExceptionMessage::getMessage($ex));
      }
    }
    $this->render($this->path_view . 'update', array('model' => $model));
  }

  public function actionDelete($id, $pegawai)
  {
    $this->loadModel($id, $pegawai)->delete();
    if (!isset($_GET['ajax']))
      $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function actionView($id)
  {
    $this->render($this->path_view . 'view', array(
      'model' => $this->loadModel($id),
    ));
  }

  public function loadModel($id, $pegawai = null)
  {
    if (empty($pegawai)) {
      $model = RuanganpegawaiM::model()->findByAttributes(array('ruangan_id' => $id));
    } else {
      $model = RuanganpegawaiM::model()->findByAttributes(array('ruangan_id' => $id, 'pegawai_id' => $pegawai));
    }
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  public function actionPrint()
  {
    $model = new RuanganpegawaiM;
    //                    $model->attributes=$_REQUEST['RuanganpegawaiM'];
    $judulLaporan = 'Data Pegawai Ruangan';
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
      //                        //$mpdf->useOddEven = 2;  
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 40, 30, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
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
