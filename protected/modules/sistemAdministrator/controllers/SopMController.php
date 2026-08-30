<?php

class SopMController extends MyAuthController {

    public $layout = '//layouts/iframe';
    public $defaultAction = 'admin';
    public $path_view = 'sistemAdministrator.views.sopM.';

    public function actionView($id)
    {
        $model = $this->loadModel($id);
        $this->render($this->path_view . 'view', array(
        'model' => $model,
        ));
    }

  /**
   * Membuat dan menyimpan data baru.
   */
  public function actionCreate()
  {
    $model = new SopM();
    $temLogo = null;

    if (isset($_POST['SopM'])) {
      $model->attributes = $_POST['SopM'];
      $model->sop_aktif = true;
      $model->sop_tglterbit = (!empty($model->sop_tglterbit)?MyFormatter::formatDateTimeForDb($model->sop_tglterbit):null);
      $model->sop_tglrevisi = (!empty($model->sop_tglrevisi)?MyFormatter::formatDateTimeForDb($model->sop_tglrevisi):null);
      $model->create_time = date('Y-m-d H:i:s');
      $model->create_loginpemakai_id = Yii::app()->user->getState("loginpemakai_id");
      $model->create_ruangan = Yii::app()->user->getState("ruangan_id");
      
        if (empty(CUploadedFile::getInstance($model, 'sop_image'))) {
            $model->sop_image = $temLogo;
        } else {
            $random = rand(0000000, 9999999);
            $model->sop_image = CUploadedFile::getInstance($model, 'sop_image');
            
            $gambar = $model->sop_image;
            
            if (isset($model->sop_image) && ($model->sop_image != $temLogo)) {
                $model->sop_image = $random . $model->sop_image;
                $model->sop_image = $random . $model->sop_image;

                Yii::import("ext.EPhpThumb.EPhpThumb");

                $fullImgName = $model->sop_image;
                $fullImgSource = Params::pathSopDirectory() . $fullImgName;

                if (!isset($model->logo_rumahsakit)) {
                    $model->logo_rumahsakit = $temLogo;
                } else {
                    $model->logo_rumahsakit = $fullImgName;
                }
                $gambar->saveAs($fullImgSource);

            }
            
        }

      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('admin', 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', 'Data Gagal Disimpan');
      }
    }

    $this->render($this->path_view . 'create', array(
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
    $temLogo = $model->sop_image;

    if (isset($_POST['SopM'])) {
      $model->attributes = $_POST['SopM'];
      $model->update_time = date('Y-m-d H:i:s');
      $model->update_loginpemakai_id = Yii::app()->user->getState("loginpemakai_id");
      $model->create_ruangan = Yii::app()->user->getState("ruangan_id");


      if (empty(CUploadedFile::getInstance($model, 'sop_image'))) {
        $model->sop_image = $temLogo;
    } else {
        $random = rand(0000000, 9999999);
        $model->sop_image = CUploadedFile::getInstance($model, 'sop_image');
        
        $gambar = $model->sop_image;
        
        if (isset($model->sop_image) && ($model->sop_image != $temLogo)) {
            $model->sop_image = $random . $model->sop_image;
            $model->sop_image = $random . $model->sop_image;

            Yii::import("ext.EPhpThumb.EPhpThumb");

            $fullImgName = $model->sop_image;
            $fullImgSource = Params::pathSopDirectory() . $fullImgName;

            if (!isset($model->logo_rumahsakit)) {
                $model->logo_rumahsakit = $temLogo;
            } else {
                $model->logo_rumahsakit = $fullImgName;
            }
            $gambar->saveAs($fullImgSource);
        }
    }

      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');

        $this->redirect(array('admin', 'sukses' => 1));
      } else {
        Yii::app()->user->setFlash('error', 'Data Gagal Disimpan');
      }
    }

    $this->render($this->path_view . 'update', array(
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
      $model->sop_aktif = false;
      if ($model->save()) {
        $data['sukses'] = 1;
      }      
      echo CJSON::encode($data);
    }
  }

  public function actionActive($id)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $data['sukses'] = 0;
      $model = $this->loadModel($id);
      // set non-active this
      // example: 
      $model->sop_aktif = true;
      if ($model->save()) {
        $data['sukses'] = 1;
      }
      echo CJSON::encode($data);
    }
  }

  /**
   * Melihat daftar data.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('SopM');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $this->pageTitle = Yii::app()->name . " - Sop";
    $model = new SopM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SopM'])) {
      $model->attributes = $_GET['SopM'];
    }
    $this->render($this->path_view . 'admin', array(
      'model' => $model,
    ));
  }

  /**
   * Memanggil data dari model.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = SopM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sop-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new SopM;

    if (isset($_GET['SopM'])) {
        $model->attributes = $_GET['SopM'];
    }

    $judulLaporan = 'Data SOP';
    $caraPrint = $_REQUEST['caraPrint'];
    if ($caraPrint == 'PRINT') {
      $this->layout = '//layouts/printWindows';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($caraPrint == 'EXCEL') {
      $this->layout = '//layouts/printExcel';
      $this->render($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
    } else if ($_REQUEST['caraPrint'] == 'PDF') {
      $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
      $posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
      $mpdf = new MyPDF60('', $ukuranKertasPDF);

      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/prinout.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->SetHTMLHeader($this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' => $judulLaporan, 'periode' => "", 'colspan' => 10), true));
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 45, 30, 15, 15);

      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }

}
