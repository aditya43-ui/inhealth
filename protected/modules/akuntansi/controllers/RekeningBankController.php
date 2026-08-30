<?php

class RekeningBankController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'create';
  public $path_view = 'akuntansi.views.rekeningBank.';

  public function actionCreate()
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $model = new AKBankRekM();
    $modDetails = array();
    if (isset($_POST['AKBankRekM'])) {
      if (count((array)$_POST['AKBankRekM']) > 0) {
        $modDetails = $this->validasiTabular($_POST['AKBankRekM']);
      }
      $transaction = Yii::app()->db->beginTransaction();
      try {
        $success = true;
        $modDetails = $this->validasiTabular($_POST['AKBankRekM']);
        foreach ($modDetails as $i => $data) {
          if ($data->bankrek_id > 0) {
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
          Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
          $this->redirect(array('create', 'id' => '1'));
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

  protected function validasiTabular($data)
  {
    sort($data['rekening']);
    foreach ($data['rekening'] as $i => $row) {
      if ($row['rekening5_id'] > 0) {
        $modDetails[$i] = new AKBankRekM();
        $modDetails[$i]->attributes = $row;
        //                    $modDetails[$i]->rekening1_id = $row['rekening1_id'];
        //                    $modDetails[$i]->rekening2_id = $row['rekening2_id'];
        //                    $modDetails[$i]->rekening3_id = $row['rekening3_id'];
        //                    $modDetails[$i]->rekening4_id = $row['rekening4_id'];
        $modDetails[$i]->rekening5_id = $row['rekening5_id'];
        //                    $modDetails[$i]->saldonormal = $row['saldonormal'];
        $modDetails[$i]->bank_id = $_POST['AKBankRekM']['bank_id'];
        $modDetails[$i]->validate();
      }
    }
    return $modDetails;
  }

  public function actionAdmin()
  {

    $model = new AKBankRekM('search');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['AKBankRekM'])) {
      $model->attributes = $_GET['AKBankRekM'];
    }

    $this->render('admin', array(
      'model' => $model,
    ));
  }

  public function actionUbahRekeningDebit($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $this->layout = '//layouts/iframe';
    $model = AKBankRekM::model()->findByPk($id);
    $modBank = AKBankM::model()->findByPk($model->bank_id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['AKJnsPenerimaanRekM'])) {
      $model->attributes = $_POST['AKJnsPenerimaanRekM'];
      $view = 'UbahRekeningKredit';

      $update = AKBankRekM::model()->updateByPk($id, array('rekening5_id' => $_POST['AKBankRekM']['rekening5_id']));
      if ($update) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        if (isset($_GET['frame']) && !empty($_GET['idBank'])) {
          $this->redirect(array(((isset($view)) ? $view : 'UbahRekeningKredit'), 'id' => $model->bankrek_id, 'frame' => $_GET['frame'], 'idBank' => $_GET['idBank']));
        } else {
          $this->redirect(array(((isset($view)) ? $view : 'admin'), 'id' => $model->bank_id));
        }
      }
    }

    $this->render($this->path_view . ((isset($view)) ? $view : '_ubahRekeningKredit'), array(
      'model' => $model,
      'modBank' => $modBank
    ));
  }

  public function actionUbahRekeningKredit($id)
  {
    //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
    $this->layout = '//layouts/iframe';
    $model = AKBankRekM::model()->findByPk($id);
    $modBank = AKBankM::model()->findByPk($model->bank_id);

    // Uncomment the following line if AJAX validation is needed


    if (isset($_POST['AKJnsPenerimaanRekM'])) {
      $model->attributes = $_POST['AKJnsPenerimaanRekM'];
      $view = 'UbahRekeningKredit';

      $update = AKBankRekM::model()->updateByPk($id, array('rekening5_id' => $_POST['AKBankRekM']['rekening5_id']));
      if ($update) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
        if (isset($_GET['frame']) && !empty($_GET['idBank'])) {
          $this->redirect(array(((isset($view)) ? $view : 'UbahRekeningKredit'), 'id' => $model->bankrek_id, 'frame' => $_GET['frame'], 'idBank' => $_GET['idBank']));
        } else {
          $this->redirect(array(((isset($view)) ? $view : 'admin'), 'id' => $model->bank_id));
        }
      }
    }

    $this->render($this->path_view . ((isset($view)) ? $view : '_ubahRekeningKredit'), array(
      'model' => $model,
      'modBank' => $modBank
    ));
  }

  public function actionGetRekeningEditKreditBank()
  {
    if (Yii::app()->request->isAjaxRequest) {

      $rekening5_id = $_POST['rekening5_id'];
      $bank_id = $_POST['bank_id'];
      $bankrek_id = $_POST['bankrek_id'];

      $update = AKBankRekM::model()->updateByPk($bankrek_id, array('rekening5_id' => $rekening5_id));
      if ($update) {
        $data['pesan'] = '<div class="flash-success">Ubah Data Rekening <b></b> Berhasil  Disimpan </div>';
      } else {
        $data['pesan'] = '<div class="flash-error">Ubah Data Rekening <b></b> Gagal  Disimpan </div>';
      }
      echo json_encode($data);
      Yii::app()->end();
    }
  }
}
