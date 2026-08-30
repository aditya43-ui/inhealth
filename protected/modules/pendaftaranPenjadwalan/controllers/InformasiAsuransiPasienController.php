<?php

class InformasiAsuransiPasienController extends MyAuthController
{
  public $layout = '//layouts/column1';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Asuransi Pasien";
    $modAsuransi = new PPInformasiasuransipasienV;
    $modAsuransi->asuransipasien_aktif = true;

    if (isset($_REQUEST['PPInformasiasuransipasienV'])) {
      $modAsuransi->attributes = $_REQUEST['PPInformasiasuransipasienV'];
    }
    $this->render('index', array(
      'modAsuransi' => $modAsuransi
    ));
  }

  public function actionView($id)
  {
    if (isset($_GET['frame'])) {
      $this->layout = '//layouts/iframe';
    }
    $this->render('view', array(
      'model' => $this->loadModel($id),
    ));
  }

  public function loadModel($id)
  {
    $model = PPAsuransipasienM::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   *Mengubah status menjadi non-aktif
   * @param type $id 
   */
  public function actionNonaktifTemporary()
  {
    $id = $_POST['id'];
    if (isset($_POST['id'])) {
      $update = PPAsuransipasienM::model()->updateByPk($id, array('asuransipasien_aktif' => false));
      if ($update) {
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
          ));
          exit;
        }
      }
    } else {
      if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(array(
          'status' => 'proses_form',
        ));
        exit;
      }
    }
  }

  /**
   *Mengubah status menjadi aktif
   * @param type $id 
   */
  public function actionAktifTemporary()
  {
    $id = $_POST['id'];
    if (isset($_POST['id'])) {
      $update = PPAsuransipasienM::model()->updateByPk($id, array('asuransipasien_aktif' => true));
      if ($update) {
        if (Yii::app()->request->isAjaxRequest) {
          echo CJSON::encode(array(
            'status' => 'proses_form',
          ));
          exit;
        }
      }
    } else {
      if (Yii::app()->request->isAjaxRequest) {
        echo CJSON::encode(array(
          'status' => 'proses_form',
        ));
        exit;
      }
    }
  }
}
