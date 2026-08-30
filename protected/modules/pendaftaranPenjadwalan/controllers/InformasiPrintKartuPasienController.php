<?php

class InformasiPrintKartuPasienController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';

  public function actionView($id)
  {
    $this->render('view', array(
      'model' => $this->loadModel($id),
    ));
  }

  public function actionCreate()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = new PPInformasiprintkartupasienR;

    if (isset($_POST['PPInformasiprintkartupasienR'])) {
      $model->attributes = $_POST['PPInformasiprintkartupasienR'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->pendaftaran_id));
      }
    }

    $this->render('create', array(
      'model' => $model,
    ));
  }

  public function actionUpdate()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    if (Yii::app()->request->isAjaxRequest) {
      $id = isset($_POST['kartupasien_id']) ? $_POST['kartupasien_id'] : null;
      $model = $this->loadModel($id);

      //            if(isset($_POST['PPInformasiprintkartupasienR']))
      //            {
      //                    $model->attributes=$_POST['PPInformasiprintkartupasienR'];
      $model->update_time = date('Y-m-d H:i:s');
      $model->update_loginpemakai_id = Yii::app()->user->getState('pegawai_id');
      $model->statusprintkartu = true;
      if ($model->save()) {
        //                            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        //                            $this->redirect(array('view','id'=>$model->pendaftaran_id));
      }
      //            }

      //            $this->render('update',array(
      //                    'model'=>$model,
      //            ));
      Yii::app()->end();
    }
  }

  public function actionDelete($id)
  {
    if (Yii::app()->request->isPostRequest) {
      //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
      $this->loadModel($id)->delete();

      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  public function actionAdmin()
  {
    $dataProvider = new CActiveDataProvider('PPInformasiprintkartupasienR');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Cetak Kartu Pasien";
    $format = new MyFormatter();
    $model = new PPInformasiprintkartupasienR('search');
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');

    if (isset($_GET['PPInformasiprintkartupasienR'])) {
      $model->attributes = $_GET['PPInformasiprintkartupasienR'];
      $model->no_rekam_medik = $_GET['PPInformasiprintkartupasienR']['no_rekam_medik'];
      $model->nama_pasien = $_GET['PPInformasiprintkartupasienR']['nama_pasien'];
      $model->alamat_pasien = $_GET['PPInformasiprintkartupasienR']['alamat_pasien'];
      // $model->no_pendaftaran = $_GET['PPInformasiprintkartupasienR']['no_pendaftaran'];
      // $model->rt = $_GET['PPInformasiprintkartupasienR']['rt'];
      // $model->rw = $_GET['PPInformasiprintkartupasienR']['rw'];

      $model->tgl_awal = $format->formatDateTimeForDb($_GET['PPInformasiprintkartupasienR']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PPInformasiprintkartupasienR']['tgl_akhir']);
    }

    $this->render('index', array(
      'model' => $model, 'format' => $format
    ));
  }

  public function loadModel($id)
  {
    $model = PPInformasiprintkartupasienR::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'ppinformasiprintkartupasien-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionRemoveTemporary($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
  }

  public function actionPrint()
  {
    $model = new PPInformasiprintkartupasienR;
    $model->attributes = $_REQUEST['PPInformasiprintkartupasienR'];
    $judulLaporan = 'Data PPInformasiprintkartupasienR';
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
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  /**
   * print kartu pasien
   * @param type $pasien_id
   */
  public function actionPrintKartuPasien($pasien_id)
  {
    $this->layout = '//layouts/printWindows';
    $modPasien = PasienM::model()->findByPk($pasien_id);
    $judul_print = 'Kartu Pasien';
    $this->render(
      'printKartuPasien',
      array(
        'modPasien' => $modPasien,
        'judul_print' => $judul_print
      )
    );
  }
}
