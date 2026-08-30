<?php

class DataAkhirAnestesiController extends MyAuthController
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
  public function actionCreate($pasienmasukpenunjang_id)
  {

    $penunjang = PasienmasukpenunjangV::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    $rencana = RencanaoperasiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));


    $anestesi = PasienanastesiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    $model = DataakhiranastesiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id,
    ));

    if (empty($model)) {
      $model = new DataakhiranastesiT;

      $model->pendaftaran_id = $penunjang->pendaftaran_id;
      $model->pasien_id = $penunjang->pasien_id;
      $model->pasienadmisi_id = empty($penunjang->pasienadmisi_id) ? $penunjang->pasienadmisi_id : null ;
      $model->pasienmasukpenunjang_id = $penunjang->pasienmasukpenunjang_id;
      $model->rencanaoperasi_id = null; //$penunjang->rencanaoperasi_id;
    }

    $status = StatusduranteroperasiT::model()->findByAttributes(array(
      'pasienmasukpenunjang_id' => $pasienmasukpenunjang_id
    ));

    if (empty($status)) {
      $status = new StatusduranteroperasiT();
      $status->pasien_id = $penunjang->pasien_id;
      $status->pendaftaran_id = $penunjang->pendaftaran_id;
      $status->pasienadmisi_id = empty($penunjang->pasienadmisi_id) ? $penunjang->pasienadmisi_id : null;
      $status->pasienmasukpenunjang_id = $penunjang->pasienmasukpenunjang_id;
      
    }

    if ($model->isNewRecord) {

      if (!empty($status->jam_mulaianestesi) && !empty($status->jam_selesaianestesi)) {

        $time_awal = strtotime($status->jam_mulaianestesi);
        $time_selesai = strtotime($status->jam_selesaianestesi);

        if ($time_awal > $time_selesai) {
          $time_selesai += 24 * 3600;
        }

        $selisih = ($time_selesai - $time_awal);
        $jam = floor($selisih / 3600);
        $menit = floor($selisih / 60) % 60;
        $detik = $selisih % 60;

        $model->lama_anastesi = "${jam} jam ${menit} menit ${detik} detik";
      }

      if (!empty($status->jam_mulaitindakanbedah) && !empty($status->jam_selesaitindakanbedah)) {

        $time_awal = strtotime($status->jam_mulaitindakanbedah);
        $time_selesai = strtotime($status->jam_selesaitindakanbedah);

        if ($time_awal > $time_selesai) {
          $time_selesai += 24 * 3600;
        }

        $selisih = ($time_selesai - $time_awal);
        $jam = floor($selisih / 3600);
        $menit = floor($selisih / 60) % 60;
        $detik = $selisih % 60;

        $model->lama_pembedahan = "${jam} jam ${menit} menit ${detik} detik";
      }
    }


    if (isset($_POST['DataakhiranastesiT'])) {
      $model->attributes = $_POST['DataakhiranastesiT'];
      // var_dump($model->attributes);die;
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
      'status' => $status,
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


    if (isset($_POST['DataakhiranastesiT'])) {
      $model->attributes = $_POST['DataakhiranastesiT'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->dataakhiranastesi_id));
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
  public function actionDelete($id)
  {
    if (Yii::app()->request->isPostRequest) {
      // we only allow deletion via POST request
      $this->loadModel($id)->delete();

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
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
    $dataProvider = new CActiveDataProvider('DataakhiranastesiT');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $model = new DataakhiranastesiT('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['DataakhiranastesiT'])) {
      $model->attributes = $_GET['DataakhiranastesiT'];
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
    $model = DataakhiranastesiT::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'dataakhiranastesi-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new DataakhiranastesiT;
    $model->attributes = $_REQUEST['DataakhiranastesiT'];
    $judulLaporan = 'Data DataakhiranastesiT';
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
