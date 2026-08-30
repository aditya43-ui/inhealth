<?php

class FormasishiftController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.formasishift.';
  public $path_tips = 'sistemAdministrator.views.tips.';
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
    $model = new SAFormasishiftM;
    $modInstalasi = new SAInstalasiM;
    $instalasiTujuans = CHtml::listData(SAInstalasiM::getInstalasiItems(), 'instalasi_id', 'instalasi_nama');
    $ruanganTujuans = CHtml::listData(SARuanganM::getRuanganByInstalasi($modInstalasi->instalasi_id), 'ruangan_id', 'ruangan_nama');

    if (isset($_POST['SAFormasishiftM'])) {
      foreach ($_POST['SAFormasishiftM'] as $i => $postFormasi) {
        $modFormasi[$i] = new SAFormasishiftM;
        $modFormasi[$i]->attributes = $postFormasi;
        //				$model[$i]->ruangan_id = $postFormasi['ruangan_id'];
        //				$model[$i]->shift_id = $postFormasi['shift_id'];
        //				$model[$i]->jmlformasi = $postFormasi['jmlformasi'];
        $modFormasi[$i]->create_time = date('Y-m-d H:i:s');
        $modFormasi[$i]->create_loginpemakai_id = Yii::app()->user->id;
        $modFormasi[$i]->create_ruangan = Yii::app()->user->getState('ruangan_id');
        if ($modFormasi[$i]->save()) {
          Yii::app()->user->setFlash('success', 'Data berhasil disimpan.');
          //$this->redirect(array('admin'));
        } else {
          Yii::app()->user->setFlash('error', "Data gagal disimpan");
        }
      }
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model,
      'modInstalasi' => $modInstalasi,
      'instalasiTujuans' => $instalasiTujuans,
      'ruanganTujuans' => $ruanganTujuans,
    ));
  }

  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
    if (Yii::app()->request->isAjaxRequest) {
      $instalasi_id = null;
      if ($model_nama !== '' && $attr == '') {
        $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
      } else if ($model_nama == '' && $attr !== '') {
        $instalasi_id = $_POST["$attr"];
      } else if ($model_nama !== '' && $attr !== '') {
        $instalasi_id = $_POST["$model_nama"]["$attr"];
      }
      $models = null;
      $models = CHtml::listData(SARuanganM::getRuanganByInstalasi($instalasi_id), 'ruangan_id', 'ruangan_nama');

      if ($encode) {
        echo CJSON::encode($models);
      } else {
        echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
        if (count((array)$models) > 0) {
          foreach ($models as $value => $name) {
            echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
          }
        }
      }
    }
    Yii::app()->end();
  }

  public function actionSetFormFormasiShift()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $ruangan_id = $_POST['ruangan_id'];
      $shift_id = $_POST['shift_id'];
      $jmlformasi = $_POST['jmlformasi'];
      $form = "";
      $pesan = "";
      $model = new SAFormasishiftM();
      //$create_ruangan = Yii::app()->user->getState('ruangan_id');
      $modRuangan = RuanganM::model()->findByPk($ruangan_id);
      $modShift = ShiftM::model()->findByPk($shift_id);

      $model->ruangan_nama = $modRuangan->ruangan_nama;
      $model->shift_nama = $modShift->shift_nama;
      $model->ruangan_id = $ruangan_id;
      $model->shift_id = $shift_id;
      $model->jmlformasi = $jmlformasi;
      $form .= $this->renderPartial($this->path_view . '_rowFormasi', array('model' => $model), true);

      echo CJSON::encode(array('status' => 'create_form', 'form' => $form, 'pesan' => $pesan));
      Yii::app()->end();
    }
  }

  /**
   * Memanggil dan Mengubah sebagian data.
   * @param integer $id the ID of the model to be updated
   */
  public function actionUpdate($id)
  {
    $model = $this->loadModel($id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SAFormasishiftM'])) {
      $model->attributes = $_POST['SAFormasishiftM'];
      $model->update_time = date('Y-m-d H:i:s');
      if ($model->save()) {
        Yii::app()->user->setFlash('success', 'Data berhasil disimpan.');
        $this->redirect(array('admin'));
      } else {
        Yii::app()->user->setFlash('error', "Data gagal disimpan");
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
      $model->formasishift_aktif = 0;
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
    $dataProvider = new CActiveDataProvider('SAFormasishiftM');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $model = new SAFormasishiftM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SAFormasishiftM'])) {
      $model->attributes = $_GET['SAFormasishiftM'];
      $model->shift_nama = isset($_GET['SAFormasishiftM']['shift_nama']) ? $_GET['SAFormasishiftM']['shift_nama'] : null;
      $model->ruangan_nama = isset($_GET['SAFormasishiftM']['ruangan_nama']) ? $_GET['SAFormasishiftM']['ruangan_nama'] : null;
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
    $model = SAFormasishiftM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'saformasishift-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new SAFormasishiftM;
    $model->attributes = $_REQUEST['SAFormasishiftM'];
    $judulLaporan = 'Laporan Data Formasi Shift';
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
