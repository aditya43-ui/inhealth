<?php

class RekeningPengeluaranController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'create';
  public $pathJenisPengeluaran = 'akuntansi.views.jurnalRekPengeluaran.';

  public function actionCreate()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = new AKJnsPengeluaranRekM();
    $modDetails = array();
    if (isset($_POST['AKJnsPengeluaranRekM'])) {
      if (count((array)$_POST['AKJnsPengeluaranRekM']) > 0) {
        $modDetails = $this->validasiTabular($_POST['AKJnsPengeluaranRekM']);
      }
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $success = true;
        $modDetails = $this->validasiTabular($_POST['AKJnsPengeluaranRekM']);
        foreach ($modDetails as $i => $data) {
          if ($data->jnspengeluaranrek_id > 0) {
            if ($data->update()) {
              $success = true;
            } else {
              $success = false;
            }
          } else {
            $data->save();
          }
        }
        if ($success == true) {
          $transaction->commit();
          Yii::app()->user->setFlash('success', 'Data berhasil disimpan.');
          $this->redirect(array('admin', 'id' => 1));
        } else {
          $transaction->rollback();
          Yii::app()->user->setFlash('error', "Data gagal disimpan ");
        }
      } catch (Exception $ex) {
        $transaction->rollback();
        Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($ex, true));
      }
    }

    $this->render('create', array(
      'model' => $model, 'modDetails' => $modDetails,
    ));
  }

  protected function validasiTabular($data)
  {
    sort($data['rekening']);
    foreach ($data['rekening'] as $i => $row) {
      if ($row['rekening5_id'] > 0) {
        $modDetails[$i] = new AKJnsPengeluaranRekM();
        $modDetails[$i]->attributes = $row;
        //                    $modDetails[$i]->rekening1_id = $row['rekening1_id'];
        //                    $modDetails[$i]->rekening2_id = $row['rekening2_id'];
        //                    $modDetails[$i]->rekening3_id = $row['rekening3_id'];
        //                    $modDetails[$i]->rekening4_id = $row['rekening4_id'];
        $modDetails[$i]->rekening5_id = $row['rekening5_id'];
        $modDetails[$i]->debitkredit = $row['rekening5_nb'];
        $modDetails[$i]->jenispengeluaran_id = $_POST['AKJnsPengeluaranRekM']['jenispengeluaran_id'];

        $modDetails[$i]->validate();
      }
    }
    return $modDetails;
  }

  public function actionAdmin($id = '')
  {
    if ($id == 1) :
      $this->redirect(Yii::app()->createUrl('akuntansi/jurnalRekPengeluaran/admin&id=1'));
    else :
      $this->redirect(Yii::app()->createUrl('akuntansi/jurnalRekPengeluaran/admin'));
    endif;
    $model = new AKJenispengeluaranM;
  }

  public function actionUbahRekeningDebit($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $this->layout = '//layouts/iframe';
    $model = AKJnsPengeluaranRekM::model()->findByPk($id);
    $modPengeluaran = AKJenispengeluaranM::model()->findByPk($model->jenispengeluaran_id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['AKJnsPenerimaanRekM'])) {
      $model->attributes = $_POST['AKJnsPenerimaanRekM'];
      $view = 'UbahRekeningKredit';

      $update = AKJnsPengeluaranRekM::model()->updateByPk($id, array('rekening5_id' => $_POST['AKJnsPengeluaranRekM']['rekening5_id']));
      if ($update) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        if (isset($_GET['frame']) && !empty($_GET['idPengeluaran'])) {
          $this->redirect(array(((isset($view)) ? $view : 'UbahRekeningKredit'), 'id' => $model->jnspengeluaranrek_id, 'frame' => $_GET['frame'], 'idPengeluaran' => $_GET['idPengeluaran']));
        } else {
          $this->redirect(array(((isset($view)) ? $view : 'admin'), 'id' => $model->jenispengeluaranrek_id));
        }
      }
    }

    $this->render(((isset($view)) ? $view : '_ubahRekeningDebit'), array(
      'model' => $model,
      'modPengeluaran' => $modPengeluaran
    ));
  }
  public function actionUbahRekeningKredit($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $this->layout = '//layouts/iframe';
    $model = AKJnsPengeluaranRekM::model()->findByPk($id);
    $modPengeluaran = AKJenispengeluaranM::model()->findByPk($model->jenispengeluaran_id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['AKJnsPenerimaanRekM'])) {
      $model->attributes = $_POST['AKJnsPenerimaanRekM'];
      $view = 'UbahRekeningKredit';

      $update = AKJnsPengeluaranRekM::model()->updateByPk($id, array('rekening5_id' => $_POST['AKJnsPengeluaranRekM']['rekening5_id']));
      if ($update) {
        Yii::app()->user->setFlash('success', 'Data berhasil disimpan.');
        if (isset($_GET['frame']) && !empty($_GET['idPengeluaran'])) {
          $this->redirect(array(((isset($view)) ? $view : 'UbahRekeningKredit'), 'id' => $model->jnspengeluaranrek_id, 'frame' => $_GET['frame'], 'idPengeluaran' => $_GET['idPengeluaran']));
        } else {
          $this->redirect(array(((isset($view)) ? $view : 'admin'), 'id' => $model->jenispengeluaranrek_id));
        }
      }
    }

    $this->render(((isset($view)) ? $view : '_ubahRekeningKredit'), array(
      'model' => $model,
      'modPengeluaran' => $modPengeluaran
    ));
  }

  /* Jurnal Pengeluaran */
  public function actionGetRekeningEditKreditPengeluaran()
  {
    if (Yii::app()->request->isAjaxRequest) {
      //              $rekening1_id =$_POST['rekening1_id'];
      //              $rekening2_id =$_POST['rekening2_id'];
      //              $rekening3_id =$_POST['rekening3_id'];
      //              $rekening4_id =$_POST['rekening4_id'];
      $rekening5_id = $_POST['rekening5_id'];
      $jenispengeluaran_id = $_POST['jenispengeluaran_id'];
      $jnspengeluaranrek_id = $_POST['jnspengeluaranrek_id'];
      //              $saldonormal =$_POST['saldonormal'];

      $update =  AKJnsPengeluaranRekM::model()->updateByPk($jnspengeluaranrek_id, array('rekening5_id' => $rekening5_id));
      if ($update) {
        $data['pesan'] = '<div class="flash-success">Ubah Data Rekening <b></b> Berhasil  Disimpan </div>';
      } else {
        $data['pesan'] = '<div class="flash-error">Ubah Data Rekening <b></b> Gagal  Disimpan </div>';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionGetRekeningEditDebitPengeluaran()
  {
    if (Yii::app()->request->isAjaxRequest) {
      //              $rekening1_id =$_POST['rekening1_id'];
      //              $rekening2_id =$_POST['rekening2_id'];
      //              $rekening3_id =$_POST['rekening3_id'];
      //              $rekening4_id =$_POST['rekening4_id'];
      $rekening5_id = $_POST['rekening5_id'];
      $jenispengeluaran_id = $_POST['jenispengeluaran_id'];
      $jnspengeluaranrek_id = $_POST['jnspengeluaranrek_id'];
      //              $saldonormal =$_POST['saldonormal'];

      $update =  AKJnsPengeluaranRekM::model()->updateByPk($jnspengeluaranrek_id, array('rekening5_id' => $rekening5_id));
      if ($update) {
        $data['pesan'] = '<div class="flash-success">Ubah Data Rekening <b></b> Berhasil  Disimpan </div>';
      } else {
        $data['pesan'] = '<div class="flash-error">Ubah Data Rekening <b></b> Gagal  Disimpan </div>';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }
  /*end jurnal pengeluaran */
}
