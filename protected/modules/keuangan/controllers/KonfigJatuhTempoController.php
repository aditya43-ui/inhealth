<?php
Yii::import('sistemAdministrator.controllers.KonfigsystemKController');
Yii::import('sistemAdministrator.models.*');
class KonfigJatuhTempoController extends KonfigsystemKController
{
  public function actionIndex($id = null)
  {
    if ($id == null) {
      $id = 1;
    }
    $model = $this->loadModel($id);

    if (isset($_POST['SAKonfigsystemK'])) {
      $model->attributes = $_POST['SAKonfigsystemK'];
      $model->jatuhtempoklaim = $_POST['SAKonfigsystemK']['jatuhtempoklaim'];
      $model->jatuhtempotagihan = $_POST['SAKonfigsystemK']['jatuhtempotagihan'];
      if ($model->save()) {
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
      }
    }

    $this->pageTitle = Yii::app()->name . " - Konfigurasi Jatuh Tempo";
    $this->render('index', array(
      'model' => $model,
    ));
  }
}
