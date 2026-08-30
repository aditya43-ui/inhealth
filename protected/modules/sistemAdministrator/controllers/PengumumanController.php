<?php

class PengumumanController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $view_path = 'sistemAdministrator.views.pengumuman.';
  // public $layout='//layouts/iframe'; //karna biasanya di akses dari home
  public $defaultAction = 'admin';

  /**
   * Menampilkan detail data.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $model = $this->loadModel($id);
    $this->render($this->view_path . 'view', array(
      'model' => $model,
    ));
  }

  /**
   * Membuat dan menyimpan data baru.
   */
  public function actionCreate()
  {
    $model = new SAPengumuman;
    $model->status_publish = TRUE;
    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SAPengumuman'])) {
      $model->attributes = $_POST['SAPengumuman'];
      $model->create_time = date("Y-m-d H:i:s");
      $model->create_loginpemakai_id = Yii::app()->user->id;
      $model->publish_loginpemakai_id = Yii::app()->user->id;
      $model->dokumen = CUploadedFile::getInstance($model, 'dokumen');
      $dokumenUpload = $model->dokumen;
      $locationDok = "";
      if(!empty($model->dokumen)){
        $random = rand(000000, 999999);
        $model->dokumen = $random . $model->dokumen;
        $locationDok = Params::pathDokumenPengumumanDirectory() . $model->dokumen;
      }

      if ($model->save()) {
        if (!empty($locationDok)) {
          $dokumenUpload->saveAs($locationDok);
        }

        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->pengumuman_id));
      }
    }

    $this->render($this->view_path . 'create', array(
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


    if (isset($_POST['SAPengumuman'])) {
      $model->attributes = $_POST['SAPengumuman'];
      // echo "<pre>"; print_r($model->attributes); exit();
      $model->update_time = date("Y-m-d H:i:s");
      $model->create_time = MyFormatter::formatDateTimeForDb($model->create_time);
      $model->update_loginpemakai_id = Yii::app()->user->id;
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('view', 'id' => $model->pengumuman_id));
      }
    }

    $this->render($this->view_path . 'update', array(
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
    // we only allow deletion via POST request
    $model = $this->loadModel($id);
    // set non-active this
    // example: 
    // $model->modelaktif = false;
    // $model->save();
    Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil di non-aktif kan.');
    $this->render($this->view_path . 'admin', array(
      'model' => $model,
    ));
  }

  /**
   * Melihat daftar data.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('SAPengumuman');
    $this->render($this->view_path . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $model = new SAPengumuman('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SAPengumuman'])) {
      $model->attributes = $_GET['SAPengumuman'];
    }
    $this->render($this->view_path . 'admin', array(
      'model' => $model,
    ));
  }

  /**
   * Memanggil data dari model.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = SAPengumuman::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sapengumuman-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  public function actionDownload($pengumuman_id) {
    $model = Pengumuman::model()->findByAttributes(array('pengumuman_id'=>$pengumuman_id));
    
    $file = Params::pathDokumenPengumumanDirectory().$model->dokumen;
    
    if (file_exists($file)) {
  
        header('Content-Description: File Transfer');
        header('Content-Type: '.mime_content_type($file));
        header('Content-Disposition: attachment; filename="'.basename($file).'"');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
        exit;
    }
  }
  
}
