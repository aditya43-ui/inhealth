<?php

class SmsgatewayMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';


  public $path_view = 'sistemAdministrator.views.smsgatewayM.';

  /**
   * Menampilkan detail data.
   * @param integer $id the ID of the model to be displayed
   */
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
    $model = new SASmsgatewayM;

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SASmsgatewayM'])) {
      $model->attributes = $_POST['SASmsgatewayM'];
      $model->modaction = $_POST['modaction'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('admin', 'id' => $model->smsgateway_id));
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

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SASmsgatewayM'])) {
      $model->attributes = $_POST['SASmsgatewayM'];
      $model->modaction = $_POST['modaction'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('admin', 'id' => $model->smsgateway_id));
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
      $model->statussms = false;
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
    $dataProvider = new CActiveDataProvider('SASmsgatewayM');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $model = new SASmsgatewayM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SASmsgatewayM'])) {
      $model->attributes = $_GET['SASmsgatewayM'];
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
    $model = SASmsgatewayM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'sasmsgateway-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new SASmsgatewayM;
    $model->attributes = $_REQUEST['SASmsgatewayM'];
    $judulLaporan = 'Data SASmsgatewayM';
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
      //$mpdf->useOddEven = 2;
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output();
    }
  }

  public function actionGetControllers($encode = false)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modul_id = $_POST['SASmsgatewayM']['modul_id'];
      $namaModul = ModulK::model()->findByPk($modul_id)->url_modul;
      $controllers = Yii::app()->metadata->getControllers($namaModul);

      if ($encode) {
        echo CJSON::encode($controllers);
      } else {
        foreach ($controllers as $value => $name) {
          echo CHtml::tag('option', array('value' => $name), CHtml::encode($name), true);
        }
      }
    }
    Yii::app()->end();
  }

  public function actionGetActions($encode = false)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modul_id = $_POST['SASmsgatewayM']['modul_id'];
      $namaModul = ModulK::model()->findByPk($modul_id)->url_modul;
      $controllerId = $_POST['SASmsgatewayM']['modcontroller'];
      $actions = Yii::app()->metadata->getActions(ucfirst($controllerId), $namaModul);

      if ($encode) {
        echo CJSON::encode($actions);
      } else {
        foreach ($actions as $value => $name) {
          echo CHtml::tag('option', array('value' => $name), CHtml::encode($name), true);
        }
      }
    }
    Yii::app()->end();
  }

  public function actionAutocompleteGetActions()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modul_id = $_GET['modul'];
      $namaModul = ModulK::model()->findByPk($modul_id)->url_modul;
      $controllerId = $_GET['controller'];
      $namaaction = isset($_GET['term']) ? $_GET['term'] : null;
      $actions = Yii::app()->metadata->getActions(ucfirst($controllerId), $namaModul);

      $return = array();
      if (count((array)$actions) > 0) {
        foreach ($actions as $i => $action) {
          if (strpos(strtolower('#' . $action), strtolower($namaaction)) > 0) {
            array_push($return, $action);
          }
        }
      }
      echo CJSON::encode($return);
    }
    Yii::app()->end();
  }
}
