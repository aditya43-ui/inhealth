<?php

class TugasPenggunaController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public $defaultAction = 'admin';

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
  public function actionCreate()
  {
    $model = new SATugaspenggunaK;
    if (isset($_POST['SATugaspenggunaK'])) {

      // var_dump($_POST); die;
      $transaction = Yii::app()->db->beginTransaction();
      try {
        //var_dump($_POST['controller']); die;

        foreach ($_POST['controller'] as $i => $value) {
          foreach ($value as $ii => $cont) {
            if (isset($_POST['action'][$cont])) {
              foreach ($_POST['action'][$cont] as $iii => $act) {
                $cek = SATugaspenggunaK::model()->findByAttributes(array(
                  'peranpengguna_id' => $_POST['SATugaspenggunaK']['peranpengguna_id'],
                  'tugas_nama' => $_POST['SATugaspenggunaK']['tugas_nama'],
                  'controller_nama' => $cont,
                  'modul_id' => $i,
                  'action_nama' => $act
                ));
                if (!$cek) {
                  $model = new SATugaspenggunaK;
                  $model->attributes = $_POST['SATugaspenggunaK'];
                  $model->modul_id = $i;
                  $model->controller_nama = $cont;
                  $model->action_nama = $act;
                  $model->save();
                }
              }
            }
          }
        }

        $transaction->commit();
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('admin'));
      } catch (Exception $exc) {
        $transaction->rollback();
        $model->isNewRecord = true;
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
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
  public function actionUpdate($id, $moduluser_id = null)
  {

    $model = $this->loadModel($id);
    // var_dump($model->attributes); die;
    $data = array();
    $criteria = new CDbCriteria;
    $criteria->select = array('modul_id');
    $criteria->group = 'modul_id';
    if (!empty($model->tugas_nama)) {
      $criteria->addCondition("tugas_nama = '" . $model->tugas_nama . "'");
    }
    if (!empty($moduluser_id)) {
      $criteria->compare('modul_id', $moduluser_id);
    }
    $criteria->order = "modul_id";
    $moduls = SATugaspenggunaK::model()->findAll($criteria);

    $criteria1 = new CDbCriteria;
    $criteria1->select = array('controller_nama', 'modul_id');
    $criteria1->group = 'controller_nama,modul_id';
    if (!empty($model->tugas_nama)) {
      $criteria1->addCondition("tugas_nama = '" . $model->tugas_nama . "'");
    }
    if (!empty($moduluser_id)) {
      $criteria1->compare('modul_id', $moduluser_id);
    }
    $criteria1->order = "controller_nama ASC";
    $controllers = SATugaspenggunaK::model()->findAll($criteria1);

    $criteria2 = new CDbCriteria;
    if (!empty($model->tugas_nama)) {
      $criteria2->addCondition("tugas_nama = '" . $model->tugas_nama . "'");
    }
    if (!empty($moduluser_id)) {
      $criteria2->compare('modul_id', $moduluser_id);
    }
    $criteria2->order = "controller_nama ASC, action_nama ASC";
    $actions = SATugaspenggunaK::model()->findAll($criteria2);

    foreach ($moduls as $i => $modul) {
      $data[$modul->modul->url_modul]['modul_id'] = $modul->modul_id;
      $data[$modul->modul->url_modul]['semua'] = CustomFunction::getControllers($modul->modul->url_modul);
      foreach ($controllers as $j => $controller) {
        if ($modul->modul_id == $controller->modul_id) {
          //  $data[$modul->modul->url_modul]['pilihan'][$controller->controller_nama]=CustomFunction::getActions($controller->controller_nama, $modul->modul->url_modul);
        }
      }
    }

    // var_dump(Yii::app()->user->getState('modul_id')); die;

    if (isset($_POST['SATugaspenggunaK'])) {
      //var_dump($_POST); die;

      $transaction = Yii::app()->db->beginTransaction();
      try {
        $ok = SATugaspenggunaK::model()->deleteAllByAttributes(array(
          'peranpengguna_id' => $_POST['SATugaspenggunaK']['peranpengguna_id'],
          'tugas_nama' => $_POST['SATugaspenggunaK']['tugas_nama'],
          'modul_id' => $moduluser_id,
        ));


        if (isset($_POST['controller'])) {
          foreach ($_POST['controller'] as $i => $value) {
            foreach ($value as $ii => $cont) {

              if (isset($_POST['action'][$cont])) {

                foreach ($_POST['action'][$cont] as $iii => $act) {
                  $cek = SATugaspenggunaK::model()->findByAttributes(
                    array(
                      'peranpengguna_id' => $_POST['SATugaspenggunaK']['peranpengguna_id'],
                      'tugas_nama' => $_POST['SATugaspenggunaK']['tugas_nama'],
                      'controller_nama' => $cont,
                      'modul_id' => $i,
                      'action_nama' => $act
                    )
                  );
                  if (!$cek) {
                    $model = new SATugaspenggunaK;
                    $model->attributes = $_POST['SATugaspenggunaK'];
                    $model->modul_id = $i;
                    $model->controller_nama = $cont;
                    $model->action_nama = $act;
                    $model->save();
                  }
                }
              }
            }
          }
        }

        // var_dump(Yii::app()->user->getState('modul_id')); die;

        Yii::app()->session['modul_id'] = Yii::app()->user->getState('modul_id');

        $transaction->commit();
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        $this->redirect(array('admin', 'modulId' => Yii::app()->user->getState('modul_id')));
      } catch (Exception $exc) {
        $transaction->rollback();
        $model->isNewRecord = true;
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
      }
    }

    $this->render('update', array(
      'model' => $model,
      'moduls' => $moduls,
      'controllers' => $controllers,
      'actions' => $actions,
      'data' => $data,
      'modul_id' => $moduluser_id,
    ));
  }

  /**
   * Memanggil dan Menghapus data.
   * @param integer $id the ID of the model to be deleted
   */
  public function actionDelete($id)
  {
    if (Yii::app()->request->isAjaxRequest) {
      // we only allow deletion via POST request
      $model = SATugaspenggunaK::model()->findByAttributes(array('tugaspengguna_id' => $id));
      $model->delete();

      // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
      if (!isset($_GET['ajax']))
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    } else
      throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
  }

  /**
   * Melihat daftar data.
   */
  public function actionIndex()
  {
    $dataProvider = new CActiveDataProvider('SATugaspenggunaK');
    $this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $model = new SATugaspenggunaK('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SATugaspenggunaK'])) {
      $model->attributes = $_GET['SATugaspenggunaK'];
    }
    $this->render('admin', array(
      'model' => $model,
    ));
  }

  /**
   * Memanggil data dari model.
   * berdasarkan peranpengguna_id
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = SATugaspenggunaK::model()->findByAttributes(array('tugas_nama' => $id));
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'satugaspengguna-k-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }
  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new SATugaspenggunaK;

    //$model->attributes=$_REQUEST['SATugaspenggunaK'];
    if (isset($_GET['SATugaspenggunaK'])) {
      $model->attributes = $_GET['SATugaspenggunaK'];
    }

    $judulLaporan = 'Data Tugas Pengguna';
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
      ////$mpdf->useOddEven = 2;  
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);
      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
      $mpdf->WriteHTML($this->renderPartial('Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '_' . date('Y-m-d') . '.pdf', 'I');
    }
  }


  public function actionGetControllers($encode = false)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $modul_id = (isset($_POST['modul_id']) ? $_POST['modul_id'] : null);
      $namaModul = (isset($_POST['namaModul']) ? $_POST['namaModul'] : null);
      $controllers = CustomFunction::getControllers($namaModul);

      if ($encode) {
        echo CJSON::encode($controllers);
      } else {
        echo "<span id='controller_" . $namaModul . "'>";
        echo CHtml::CheckBox('checkAll_' .  lcfirst($namaModul), '', array(
          'value' => lcfirst($modul_id),
          'onclick' => 'checkAll(this)',
          'checked' => 'checked'
        )) . " Pilih Semua";
        echo "<br>";
        foreach ($controllers as $value => $name) {
          echo CHtml::CheckBox('controller[' . $modul_id . '][]', '', array(
            'value' => lcfirst($value),
            'onclick' => 'tambahAction(this)',
            'modul' => lcfirst($namaModul),
          ));
          echo '&nbsp;' . $name . '<br>';
          // echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
        echo "</span>";
      }
    }
    Yii::app()->end();
  }

  public function actionGetActions($encode = false)
  {
    if (Yii::app()->request->isAjaxRequest) {
      $namaModul = (isset($_POST['namaModul']) ? $_POST['namaModul'] : null);
      $contorllerId = (isset($_POST['namaController']) ? $_POST['namaController'] : null);
      $actions = CustomFunction::getActions($contorllerId, $namaModul);

      if ($encode) {
        echo CJSON::encode($actions);
      } else {
        echo "<span id='action_" . $contorllerId . "' style='border:solid 1px #999; display:block'>";
        echo "Nama Controller : <strong>" . $contorllerId . "</strong><br>";

        echo CHtml::CheckBox('checkAll_' . $contorllerId, '', array(
          'value' => $namaModul,
          'onclick' => 'checkAllAction(this,"' . $contorllerId . '")',
          'checked' => 'checked'
        )) . " Pilih Semua";
        echo "<br>";
        foreach ($actions as $value => $name) {
          echo CHtml::CheckBox('action[' . $contorllerId . '][]', '', array(
            'value' => lcfirst($value),
            'controller' => lcfirst($contorllerId),
          ));
          echo '&nbsp;' . $name . '<br>';
          // echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
        }
        echo "</span>";
      }
    }
    Yii::app()->end();
  }

  public function actionCekPeranPengguna()
  {
    if (Yii::app()->request->isAjaxRequest) {
      $id = (isset($_POST['pengguna']) ? $_POST['pengguna'] : null);
      $data = array();
      $model = SATugaspenggunaK::model()->findByAttributes(array('peranpengguna_id' => $id));
      $data['success'] = !empty($model) ? 1 : 0;
      $data['id'] = isset($model->tugaspengguna_id) ? $model->tugaspengguna_id : '';
      echo CJSON::encode($data);
    }
    Yii::app()->end();
  }
}
