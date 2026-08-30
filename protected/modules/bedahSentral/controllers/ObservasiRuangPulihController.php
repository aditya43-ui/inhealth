<?php

class ObservasiRuangPulihController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public $defaultAction = 'create';

  /**
   * Menampilkan detail data.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $model = $this->loadModel($id);
    $this->render('view', array(
      'model' => $model,
    ));
  }

  /**
   * Membuat dan menyimpan data baru.
   */
  public function actionCreate($pasienmasukpenunjang_id, $id = null)
  {
    $pulih = PasienruangpulihT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    if (empty($pulih)) {
      echo "Harus dilakukan transaksi Masuk Ruang Pulih";
      Yii::app()->end();
    }

    $penunjang = PasienmasukpenunjangV::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    $model = null;

    if (!empty($id)) {
      $model = ObservasiruangpulihT::model()->findByPk($id);
      $model->suhubadan = number_format($model->suhubadan, 2, ",", "");
      $model->mualmuntah_status = $model->mualmuntah_status ? "+" : "-";
      $model->perdarahan_status = $model->perdarahan_status ? "+" : "-";
    }

    if (empty($model)) {
      $model = new ObservasiruangpulihT;
      $model->pasien_id = $penunjang->pasien_id;
      $model->pendaftaran_id = $penunjang->pendaftaran_id;
      $model->pasienadmisi_id = $penunjang->pasienadmisi_id;
      $model->pasienmasukpenunjang_id = $penunjang->pasienmasukpenunjang_id;
      $model->genPemeriksaan();
    }



    if (isset($_POST['ObservasiruangpulihT'])) {
      $model->attributes = $_POST['ObservasiruangpulihT'];

      $model->mualmuntah_status = $model->mualmuntah_status == "+";
      $model->perdarahan_status = $model->perdarahan_status == "+";

      // var_dump($model->attributes); die;

      if ($model->isNewRecord) {
        $model->create_time = date('Y-m-d H:i:s');
        $model->create_loginpemakai_id = Yii::app()->user->id;
        $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
      }
      $model->update_time = date('Y-m-d H:i:s');
      $model->update_loginpemakai_id = Yii::app()->user->id;




      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('create', 'pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id));
      }
    }

    $this->render('create', array(
      'model' => $model,
    ));
  }

  /**
   * Memanggil dan Mengubah sebagian data.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['ObservasiruangpulihT'])) {
      $model->attributes = $_POST['ObservasiruangpulihT'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->observasiruangpulih_id));
      }
    }

    $this->render('update', array(
      'model' => $model,
    ));
  }

  /**
   * Memanggil dan Menghapus data.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete()
  {
    if (Yii::app()->request->isPostRequest) {

      $trans = Yii::app()->db->beginTransaction();
      $ok = 1;
      $msg = "Data Observasi berhasil dihapus";


      try {
        $mod = $this->loadModel($_POST['id']);
        $pasienmasukpenunjang_id = $mod->pasienmasukpenunjang_id;
        $mod->delete();

        $list = ObservasiruangpulihT::model()->findAllByAttributes(array(
          'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
        ), array(
          'order' => 'pemeriksaanke asc',
        ));

        foreach ($list as $idx => $item) {
          $item->pemeriksaanke = $idx + 1;
          $item->save();
        }

        $trans->commit();
      } catch (Exception $ex) {
        $trans->rollback();
        $ok = 0;
        $msg = "Data Observasi gagal dihapus. " . $ex->getMessage();
      }


      echo CJSON::encode(array(
        'ok' => $ok,
        'msg' => $msg
      ));
    }
    Yii::app()->end();
  }

  /**
   * Memanggil dan menonaktifkan status 
   */
  public function actionNonActive($id)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['sukses'] = 0;
      $model = $this->loadModel($id);
      // set non-active this
      // example: 
      // $model->modelaktif = false;
      // if($model->save()){
      //	$data['sukses'] = 1;
      // }
      echo CJSON::encode($data);
    }
  }

  /**
   * Melihat daftar data.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('ObservasiruangpulihT');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $model = new ObservasiruangpulihT('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['ObservasiruangpulihT'])) {
      $model->attributes = $_GET['ObservasiruangpulihT'];
    }
    $this->render('admin', array(
      'model' => $model,
    ));
  }

  /**
   * Memanggil data dari model.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = ObservasiruangpulihT::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'observasiruangpulih-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new ObservasiruangpulihT;
    $model->attributes = $_REQUEST['ObservasiruangpulihT'];
    $judulLaporan = 'Data ObservasiruangpulihT';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }
}
