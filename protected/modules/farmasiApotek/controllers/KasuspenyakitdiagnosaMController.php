<?php

class KasuspenyakitdiagnosaMController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';

  public function actionIndex()
  {
    $this->render('index');
  }

  public function actionAdmin()
  {
    $model = new KasuspenyakitdiagnosaM('search');
    $model->unsetAttributes();
    if (isset($_GET['KasuspenyakitdiagnosaM']))
      $model->attributes = $_GET['KasuspenyakitdiagnosaM'];
    $this->render('admin', array('model' => $model));
  }

  public function actionCreate()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))
    // {
    //     throw new CHttpException(401,Yii::t('mds','You are probihited to access this page. Contact Super Administrator'));
    // }
    $model = new KasuspenyakitdiagnosaM;
    if (isset($_POST['KasuspenyakitdiagnosaM'])) {
      //                        echo $_POST['KasuspenyakitdiagnosaM'][0]['jeniskasuspenyakit'];
      //                        echo print_r($_POST['KasuspenyakitdiagnosaM']);
      //                        exit();
      $modDetails = $this->validasiTabular($model, $_POST['KasuspenyakitdiagnosaM']);
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $jumlah = 0;
        foreach ($_POST['KasuspenyakitdiagnosaM'] as $j => $row) {
          $model = new KasuspenyakitdiagnosaM();
          $model->attributes = $row;
          if ($model->save()) {
            $jumlah++;
          }
        }
        if ($jumlah == count((array)$_POST['KasuspenyakitdiagnosaM'])) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', '<strong>Berhasil</strong> Data Berhasil disimpan');
          $this->redirect(array('admin'));
        } else {
          $transaction->rollback();
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', '<strong>Gagal</strong> Data gagal disimpan' . MyExceptionMessage::getMessage($ex));
      }
    }
    $this->render('create', array('model' => $model, 'modDetails' => $modDetails));
  }

  protected function validasiTabular($model, $data)
  {
    foreach ($data as $i => $row) {
      $modDetails[$i] = new KasuspenyakitdiagnosaM;
      $modDetails[$i]->attributes = $row;
      $modDetails[$i]->validate();
    }
    return $modDetails;
  }

  public function actionUpdate()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE))
    // {
    //     throw new CHttpException(401,Yii::t('mds','You are probihited to access this page. Contact Super Administrator'));
    // }
    $model = new KasuspenyakitdiagnosaM;
    if (isset($_POST['KasuspenyakitdiagnosaM'])) {
      for ($i = 0; $i < count((array)$_POST['jeniskasuspenyakit_id']); $i++) {
        $model = new KasuspenyakitdiagnosaM;
        $jeniskasuspenyakit_id = $_POST['jeniskasuspenyakit_id'][$i];
        $model->jeniskasuspenyakit_id = $jeniskasuspenyakit_id;
        $model->diagnosa_id = $_POST['diagnosa_id'][$jeniskasuspenyakit_id];
        $model->save();
      }
      if ($model->save())
        Yii::app()->user->setFlash('success', '<strong>Berhasil</strong>Data Berhasil disimpan');
      $this->redirect(array('admin'));
    }
    $this->render('update', array('model' => $model));
  }

  public function actionDelete($jeniskasuspenyakit_id, $diagnosa)
  {
    $this->loadModel($jeniskasuspenyakit_id, $diagnosa)->delete();
    if (!isset($_GET['ajax']))
      $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
  }

  public function actionView($id)
  {
    $this->render('view', array(
      'model' => $this->loadModel($id),
    ));
  }

  public function loadModel($id, $diagnosa = null)
  {
    if (empty($diagnosa)) {
      $model = KasuspenyakitdiagnosaM::model()->findByAttributes(array('jeniskasuspenyakit_id' => $id));
    } else {
      $model = KasuspenyakitdiagnosaM::model()->findByAttributes(array('jeniskasuspenyakit_id' => $id, 'diagnosa_id' => $diagnosa));
    }
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  public function actionPrint()
  {
    $model = new KasuspenyakitdiagnosaM;
    $model->attributes = $_REQUEST['KasuspenyakitdiagnosaM'];
    $judulLaporan = 'Data Diagnosa Kasus Penyakit';
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
}
