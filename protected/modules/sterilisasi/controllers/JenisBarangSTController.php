<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.JenisBarangController');
class JenisBarangSTController extends JenisBarangController
{
  public function actionView($id)
  {
    return JenisBarangController::actionView($id);
  }

  public function actionCreate()
  {
    return JenisBarangController::actionCreate();
  }

  public function actionUpdate($id)
  {
    return JenisBarangController::actionUpdate($id);
  }

  public function actionDelete($id)
  {
    return JenisBarangController::actionDelete($id);
  }

  public function actionNonActive($id)
  {
    return JenisBarangController::actionNonActive($id);
  }

  public function actionIndex()
  {
    return JenisBarangController::actionIndex();
  }

  public function actionAdmin()
  {
    return JenisBarangController::actionAdmin();
  }

  public function loadModel($id)
  {
    return JenisBarangController::loadModel($id);
  }

  protected function performAjaxValidation($model)
  {
    return JenisBarangController::performAjaxValidation($model);
  }

  public function actionPrint()
  {
    return JenisBarangController::actionPrint();
  }
}
