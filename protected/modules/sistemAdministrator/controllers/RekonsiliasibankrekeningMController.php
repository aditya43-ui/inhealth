<?php

class RekonsiliasibankrekeningMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/iframe';
  public $defaultAction = 'admin';
  public $path_view = 'sistemAdministrator.views.rekonsiliasibankrekeningM.';

  /**
   * Menampilkan detail data.
   * @param integer $id the ID of the model to be displayed
   */
  public function actionView($id)
  {
    $model = SARekonsiliasibankrekeningM::model()->findByAttributes(array('jenisrekonsiliasibank_id' => $id));

    $this->render($this->path_view . 'view', array(
      'model' => $model,
    ));
  }

  /**
   * Membuat dan menyimpan data baru.
   */
  public function actionCreate()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = new SARekonsiliasibankrekeningM();
    $modDetails = array();
    if (isset($_POST['SARekonsiliasibankrekeningM'])) {
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $success = true;
        $modDetails = $this->validasiTabular($_POST['SARekonsiliasibankrekeningM']);
        foreach ($modDetails as $i => $data) {
          if ($data->rekonsiliasibankrekening_id > 0) {
            if ($data->update()) {
              $success = true;
            } else {
              $success = false;
            }
          } else {
            if ($data->save()) {
              $success = true;
            } else {
              $success = false;
            }
          }
        }
        if ($success == true) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', 'Data berhasil disimpan.');
          $this->redirect(array('admin', 'id' => '1'));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
      }
    }

    $this->render($this->path_view . 'create', array(
      'model' => $model, 'modDetails' => $modDetails,
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


    if (isset($_POST['SARekonsiliasibankrekeningM'])) {
      $model->attributes = $_POST['SARekonsiliasibankrekeningM'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', 'Data berhasil disimpan.');
        $this->redirect(array($this->path_view . 'view', 'id' => $model->rekonsiliasibankrekening_id));
      } else {
        Yii::app()->user->setFlash('error', "Data gagal disimpan ");
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
      //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
      $model = SARekonsiliasibankrekeningM::model()->deleteAllByAttributes(array('jenisrekonsiliasibank_id' => $id));

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
    $dataProvider = new CActiveDataProvider('SARekonsiliasibankrekeningM');
    $this->render($this->path_view . 'index', array(
      'dataProvider' => $dataProvider,
    ));
  }

  /**
   * Pengaturan data.
   */
  public function actionAdmin()
  {
    $model = new SARekonsiliasibankrekeningM();
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
    $model = SARekonsiliasibankrekeningM::model()->findByPk($id);
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
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'akrekonsiliasibankrekening-m-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   * Mencetak data
   */
  public function actionPrint()
  {
    $model = new SARekonsiliasibankrekeningM;
    $model->attributes = $_REQUEST['SARekonsiliasibankrekeningM'];
    $judulLaporan = 'Data Rekonsiliasi Bank Rekening';

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
      ////$mpdf->useOddEven = 2;

      $mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 30, 15, 15);
      $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
      $mpdf->WriteHTML($stylesheet, 1);

      $mpdf->WriteHTML($this->renderPartial($this->path_view . 'Print', array('model' => $model, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
      $mpdf->Output($judulLaporan . '-' . date('Y/m/d') . '.pdf', 'I');
    }
  }

  protected function validasiTabular($data)
  {
    sort($data['rekening']);
    foreach ($data['rekening'] as $i => $row) {
      if ($row['rekening5_id'] > 0) {
        $modDetails[$i] = new SARekonsiliasibankrekeningM();
        $modDetails[$i]->attributes = $row;
        //                    $modDetails[$i]->rekening1_id = $row['rekening1_id'];
        //                    $modDetails[$i]->rekening2_id = $row['rekening2_id'];
        //                    $modDetails[$i]->rekening3_id = $row['rekening3_id'];
        //                    $modDetails[$i]->rekening4_id = $row['rekening4_id'];
        $modDetails[$i]->rekening5_id = $row['rekening5_id'];
        //                    $modDetails[$i]->saldonormal = $row['saldonormal'];
        $modDetails[$i]->jenisrekonsiliasibank_id = $_POST['SARekonsiliasibankrekeningM']['jenisrekonsiliasibank_id'];

        $modDetails[$i]->validate();
      }
    }
    return $modDetails;
  }

  public function actionUbahRekeningDebit($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $this->layout = '//layouts/iframe';
    $model = SARekonsiliasibankrekeningM::model()->findByPk($id);
    $modPengeluaran = SAJenisrekonsiliasibankM::model()->findByPk($model->jenisrekonsiliasibank_id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SARekonsiliasibankrekeningM'])) {
      $model->attributes = $_POST['SARekonsiliasibankrekeningM'];
      $view = 'UbahRekeningDebit';

      $update = SARekonsiliasibankrekeningM::model()->updateByPk($id, array('rekening5_id' => $_POST['SARekonsiliasibankrekeningM']['rekening5_id']));
      if ($update) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        if (isset($_GET['frame']) && !empty($_GET['idPengeluaran'])) {
          $this->redirect(array(((isset($view)) ? $view : 'UbahRekeningDebit'), 'id' => $model->rekonsiliasibankrekening_id, 'frame' => $_GET['frame'], 'idPengeluaran' => $_GET['idPengeluaran']));
        } else {
          $this->redirect(array(((isset($view)) ? $view : 'admin'), 'id' => $model->rekonsiliasibankrekening_id));
        }
      }
    }

    $this->render(((isset($view)) ? $view : $this->path_view . '_ubahRekeningDebit'), array(
      'model' => $model,
      'modPengeluaran' => $modPengeluaran
    ));
  }

  public function actionUbahRekeningKredit($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $this->layout = '//layouts/iframe';
    $model = SARekonsiliasibankrekeningM::model()->findByPk($id);
    $modPengeluaran = SAJenisrekonsiliasibankM::model()->findByPk($model->jenisrekonsiliasibank_id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['SARekonsiliasibankrekeningM'])) {
      $model->attributes = $_POST['SARekonsiliasibankrekeningM'];
      $view = 'UbahRekeningKredit';

      $update = SARekonsiliasibankrekeningM::model()->updateByPk($id, array('rekening5_id' => $_POST['SARekonsiliasibankrekeningM']['rekening5_id']));
      if ($update) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        if (isset($_GET['frame']) && !empty($_GET['idPengeluaran'])) {
          $this->redirect(array(((isset($view)) ? $view : 'UbahRekeningKredit'), 'id' => $model->rekonsiliasibankrekening_id, 'frame' => $_GET['frame'], 'idPengeluaran' => $_GET['idPengeluaran']));
        } else {
          $this->redirect(array(((isset($view)) ? $view : 'admin'), 'id' => $model->rekonsiliasibankrekening_id));
        }
      }
    }

    $this->render(((isset($view)) ? $view : $this->path_view . '_ubahRekeningKredit'), array(
      'model' => $model,
      'modPengeluaran' => $modPengeluaran
    ));
  }

  /* Jurnal Pengeluaran */

  public function actionGetRekeningEditKreditRekonBank()
  {
    if (Yii::app()->request->isAjaxRequest) {
      //              $rekening1_id =$_POST['rekening1_id'];
      //              $rekening2_id =$_POST['rekening2_id'];
      //              $rekening3_id =$_POST['rekening3_id'];
      //              $rekening4_id =$_POST['rekening4_id'];
      $rekening5_id = $_POST['rekening5_id'];
      $jenisrekonsiliasibank_id = $_POST['jenisrekonsiliasibank_id'];
      $rekonsiliasibankrekening_id = $_POST['rekonsiliasibankrekening_id'];
      //              $saldonormal =$_POST['saldonormal'];

      $update = SARekonsiliasibankrekeningM::model()->updateByPk($rekonsiliasibankrekening_id, array('rekening5_id' => $rekening5_id));
      if ($update) {
        $data['pesan'] = '<div class="flash-success">Ubah Data Rekening <b></b> Berhasil  Disimpan </div>';
      } else {
        $data['pesan'] = '<div class="flash-error">Ubah Data Rekening <b></b> Gagal  Disimpan </div>';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionGetRekeningEditDebitRekonBank()
  {
    if (Yii::app()->request->isAjaxRequest) {
      //              $rekening1_id =$_POST['rekening1_id'];
      //              $rekening2_id =$_POST['rekening2_id'];
      //              $rekening3_id =$_POST['rekening3_id'];
      //              $rekening4_id =$_POST['rekening4_id'];
      $rekening5_id = $_POST['rekening5_id'];
      $jenisrekonsiliasibank_id = $_POST['jenisrekonsiliasibank_id'];
      $rekonsiliasibankrekening_id = $_POST['rekonsiliasibankrekening_id'];
      //              $saldonormal =$_POST['saldonormal'];

      $update = SARekonsiliasibankrekeningM::model()->updateByPk($rekonsiliasibankrekening_id, array('rekening5_id' => $rekening5_id));
      if ($update) {
        $data['pesan'] = '<div class="flash-success">Ubah Data Rekening <b></b> Berhasil  Disimpan </div>';
      } else {
        $data['pesan'] = '<div class="flash-error">Ubah Data Rekening <b></b> Gagal  Disimpan </div>';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /* end jurnal pengeluaran */
}
