<?php

class GambarTubuhController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.gambarTubuh.';

  /**
   * Menampilkan detail data.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $this->layout = '//layouts/iframe';
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
    $this->layout = '//layouts/iframe';
    $model = new SAGambartubuhM;

    if (isset($_POST['SAGambartubuhM'])) {
      $model->attributes = $_POST['SAGambartubuhM'];

      $instance = CUploadedFile::getInstance($model, 'nama_file_gbr');

      if ($instance) {
        Yii::import("ext.EPhpThumb.EPhpThumb");

        $thumb = new EPhpThumb();
        $thumb->init(); //this is needed

        $fullImgName = time() . '_image.' . $instance->getExtensionName();
        $fullImgSource = Params::pathAnatomiTubuhDirectory() . $fullImgName;
        $fullThumbSource = Params::pathAnatomiTubuhThumbsDirectory() . $fullImgName;
        $image_info = getimagesize($_FILES['SAGambartubuhM']['tmp_name']['nama_file_gbr']);

        $model->nama_file_gbr = $fullImgName;
        $model->path_gambar = $fullImgSource;
        $model->gambar_resolusi_x = $image_info[0];
        $model->gambar_resolusi_y = $image_info[1];
        $model->gambar_create = date('Y-m-d H:i:s');

        if ($model->save()) {
          $instance->saveAs($fullImgSource);
          //chain functions
          $thumb->create($fullImgSource)
            ->resize(24, 24)
            ->save($fullThumbSource);
          Yii::app()->user->setFlash('success', "Data " . $model->nama_gambar . " berhasil disimpan");
          $this->redirect(array('view', 'id' => $model->gambartubuh_id));
        }
      } else {
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
        $this->redirect(array('admin'));
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
    $this->layout = '//layouts/iframe';
    $model = $this->loadModel($id);
    $model->temp_nama = $model->nama_file_gbr;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SAGambartubuhM'])) {
      $model->attributes = $_POST['SAGambartubuhM'];
      $temLogo = $model->temp_nama;
      $model->nama_file_gbr = $temLogo;

      if (!empty($_FILES['SAGambartubuhM']['tmp_name']['nama_file_gbr'])) {
        $instance = CUploadedFile::getInstance($model, 'nama_file_gbr');
        if ($instance) {
          Yii::import("ext.EPhpThumb.EPhpThumb");

          $thumb = new EPhpThumb();
          $thumb->init(); //this is needed

          $fullImgName = time() . '_image.' . $instance->getExtensionName();
          $fullImgSource = Params::pathAnatomiTubuhDirectory() . $fullImgName;
          $fullThumbSource = Params::pathAnatomiTubuhThumbsDirectory() . $fullImgName;
          $image_info = getimagesize($_FILES['SAGambartubuhM']['tmp_name']['nama_file_gbr']);


          if (!empty($temLogo)) {
            if (file_exists(Params::pathAnatomiTubuhDirectory() . $temLogo)) {
              unlink(Params::pathAnatomiTubuhDirectory() . $temLogo);
            }
            if (file_exists(Params::pathAnatomiTubuhThumbsDirectory() . $temLogo)) {
              unlink(Params::pathAnatomiTubuhThumbsDirectory() . $temLogo);
            }
          }

          $model->nama_file_gbr = $fullImgName;
          $model->path_gambar = $fullImgSource;
          $model->gambar_resolusi_x = $image_info[0];
          $model->gambar_resolusi_y = $image_info[1];
          $model->gambar_update = date('Y-m-d H:i:s');
          if ($model->save()) {


            $instance->saveAs($fullImgSource);
            //chain functions
            $thumb->create($fullImgSource)
              ->resize(24, 24)
              ->save($fullThumbSource);
            Yii::app()->user->setFlash('success', "Data " . $model->nama_gambar . " berhasil disimpan");
            $this->redirect(array('view', 'id' => $model->gambartubuh_id));
          }
        } else {
          Yii::app()->user->setFlash('error', "Data gagal disimpan");
          $this->redirect(array('update', 'id' => $model->gambartubuh_id));
        }
      } else {
        if ($model->save()) {
          Yii::app()->user->setFlash('success', "Data " . $model->nama_gambar . " berhasil disimpan");
          $this->redirect(array('view', 'id' => $model->gambartubuh_id));
        }
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
      $model = $this->loadModel($id);
      if (file_exists(Params::pathAnatomiTubuhDirectory() . $model->nama_file_gbr)) {
        unlink(Params::pathAnatomiTubuhDirectory() . $model->nama_file_gbr);
      }
      if (file_exists(Params::pathAnatomiTubuhThumbsDirectory() . $model->nama_file_gbr)) {
        unlink(Params::pathAnatomiTubuhThumbsDirectory() . $model->nama_file_gbr);
      }
      $model->delete();

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
      $model->gambartubuh_aktif = false;
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
    $this->layout = '//layouts/iframe';
    $dataProvider = new CActiveDataProvider('SAGambartubuhM');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $this->layout = '//layouts/iframe';
    $model = new SAGambartubuhM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SAGambartubuhM'])) {
      $model->attributes = $_GET['SAGambartubuhM'];
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
    $model = SAGambartubuhM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sagambartubuh-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new SAGambartubuhM;
    $model->attributes = $_REQUEST['SAGambartubuhM'];
    $judulLaporan = 'Data Gambar Tubuh';
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
