<?php

class RekeningPenerimaanController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $pathJenisPenerimaan = 'akuntansi.views.jurnalRekPenerimaan.';

  public function actionCreate()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = new AKJnsPenerimaanRekM();
    $modDetails = array();

    if (isset($_POST['AKJnsPenerimaanRekM'])) {
      if (count((array)$_POST['AKJnsPenerimaanRekM']) > 0) {
        $modDetails = $this->validasiTabular($_POST['AKJnsPenerimaanRekM']);
      }
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $success = true;
        $modDetails = $this->validasiTabular($_POST['AKJnsPenerimaanRekM']);
        foreach ($modDetails as $i => $data) {
          if ($data->jnspenerimaanrek_id > 0) {
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
      if ($row['rekening1_id'] > 0) {
        $modDetails[$i] = new AKJnsPenerimaanRekM();
        $modDetails[$i]->attributes = $row;
        //				$modDetails[$i]->rekening1_id = $row['rekening1_id'];
        //				$modDetails[$i]->rekening2_id = $row['rekening2_id'];
        //				$modDetails[$i]->rekening3_id = $row['rekening3_id'];
        //				$modDetails[$i]->rekening4_id = $row['rekening4_id'];
        $modDetails[$i]->rekening5_id = $row['rekening5_id'];
        $modDetails[$i]->debitkredit = $row['rekening5_nb'];
        $modDetails[$i]->jenispenerimaan_id = $_POST['AKJnsPenerimaanRekM']['jenispenerimaan_id'];
        $modDetails[$i]->validate();
      }
    }
    return $modDetails;
  }

  public function actionAdmin($id = '')
  {

    $model = new AKJenispenerimaanM;
    if ($id == 1) :
      $this->redirect(Yii::app()->createUrl('akuntansi/jurnalRekPenerimaan/admin&id=1'));
    else :
      $this->redirect(Yii::app()->createUrl('akuntansi/jurnalRekPenerimaan/admin'));
    endif;
  }

  public function actionUbahRekeningDebit($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $this->layout = '//layouts/iframe';
    $model = AKJnsPenerimaanRekM::model()->findByPk($id);
    $modPenerimaan = AKJenispenerimaanM::model()->findByPk($model->jenispenerimaan_id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['AKJnsPenerimaanRekM'])) {
      $model->attributes = $_POST['AKJnsPenerimaanRekM'];
      $view = 'UbahRekeningDebit';

      $update = AKJnsPenerimaanRekM::model()->updateByPk($id, array(
        'rekening5_id' => $_POST['AKJnsPenerimaanRekM']['rekening5_id'],
        'rekening4_id' => $_POST['AKJnsPenerimaanRekM']['rekening4_id'],
        'rekening3_id' => $_POST['AKJnsPenerimaanRekM']['rekening3_id'],
        'rekening2_id' => $_POST['AKJnsPenerimaanRekM']['rekening2_id'],
        'rekening1_id' => $_POST['AKJnsPenerimaanRekM']['rekening1_id']
      ));
      if ($update) {
        Yii::app()->user->setFlash('success', 'Data berhasil disimpan.');
        if (isset($_GET['frame']) && !empty($_GET['idPenerimaan'])) {
          $this->redirect(array(((isset($view)) ? $view : 'UbahRekeningDebit'), 'id' => $model->jnspenerimaanrek_id, 'frame' => $_GET['frame'], 'idPenerimaan' => $_GET['idPenerimaan']));
        } else {
          $this->redirect(array(((isset($view)) ? $view : 'admin'), 'id' => $model->jenispenerimaan_id));
        }
      }
    }

    $this->render(((isset($view)) ? $view : '_ubahRekeningDebit'), array(
      'model' => $model,
      'modPenerimaan' => $modPenerimaan
    ));
  }

  public function actionUbahRekeningKredit($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $this->layout = '//layouts/iframe';
    $model = AKJnsPenerimaanRekM::model()->findByPk($id);
    $modPenerimaan = AKJenispenerimaanM::model()->findByPk($model->jenispenerimaan_id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['AKJnsPenerimaanRekM'])) {
      $model->attributes = $_POST['AKJnsPenerimaanRekM'];
      $view = 'UbahRekeningKredit';

      $update = AKJnsPenerimaanRekM::model()->updateByPk($id, array(
        'rekening5_id' => $_POST['AKJnsPenerimaanRekM']['rekening5_id'],
        'rekening4_id' => $_POST['AKJnsPenerimaanRekM']['rekening4_id'],
        'rekening3_id' => $_POST['AKJnsPenerimaanRekM']['rekening3_id'],
        'rekening2_id' => $_POST['AKJnsPenerimaanRekM']['rekening2_id'],
        'rekening1_id' => $_POST['AKJnsPenerimaanRekM']['rekening1_id']
      ));
      if ($update) {
        Yii::app()->user->setFlash('success', 'Data berhasil disimpan.');
        if (isset($_GET['frame']) && !empty($_GET['idPenerimaan'])) {
          $this->redirect(array(((isset($view)) ? $view : 'UbahRekeningKredit'), 'id' => $model->jnspenerimaanrek_id, 'frame' => $_GET['frame'], 'idPenerimaan' => $_GET['idPenerimaan']));
        } else {
          $this->redirect(array(((isset($view)) ? $view : 'admin'), 'id' => $model->jenispenerimaan_id));
        }
      }
    }

    $this->render(((isset($view)) ? $view : '_ubahRekeningKredit'), array(
      'model' => $model,
      'modPenerimaan' => $modPenerimaan
    ));
  }

  /* jurnal rek penerimaan */

  public function actionGetRekeningEditKreditPenerimaan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      //              $rekening1_id =$_POST['rekening1_id'];
      //              $rekening2_id =$_POST['rekening2_id'];
      //              $rekening3_id =$_POST['rekening3_id'];
      //              $rekening4_id =$_POST['rekening4_id'];
      $rekening5_id = $_POST['rekening5_id'];
      $jenispenerimaan_id = $_POST['jenispenerimaan_id'];
      $jnspenerimaanrek_id = $_POST['jnspenerimaanrek_id'];
      //              $saldonormal =$_POST['saldonormal'];

      $update = AKJnsPenerimaanRekM::model()->updateByPk($jnspenerimaanrek_id, array('rekening5_id' => $rekening5_id));
      if ($update) {
        $data['pesan'] = '<div class="flash-success">Ubah Data Rekening <b></b> Berhasil  Disimpan </div>';
      } else {
        $data['pesan'] = '<div class="flash-error">Ubah Data Rekening <b></b> Gagal  Disimpan </div>';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  public function actionGetRekeningEditDebitPenerimaan()
  {
    if (Yii::app()->request->isAjaxRequest) {
      //              $rekening1_id =$_POST['rekening1_id'];
      //              $rekening2_id =$_POST['rekening2_id'];
      //              $rekening3_id =$_POST['rekening3_id'];
      //              $rekening4_id =$_POST['rekening4_id'];
      $rekening5_id = $_POST['rekening5_id'];
      $jenispenerimaan_id = $_POST['jenispenerimaan_id'];
      $jnspenerimaanrek_id = $_POST['jnspenerimaanrek_id'];
      //              $saldonormal =$_POST['saldonormal'];

      $update = AKJnsPenerimaanRekM::model()->updateByPk($jnspenerimaanrek_id, array('rekening5_id' => $rekening5_id));
      if ($update) {
        $data['pesan'] = '<div class="flash-success">Ubah Data Rekening <b></b> Berhasil  Disimpan </div>';
      } else {
        $data['pesan'] = '<div class="flash-error">Ubah Data Rekening <b></b> Gagal  Disimpan </div>';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }

  /* end jurnal rek penerimaan */
}
