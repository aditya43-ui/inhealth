<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.GolonganMController');
class GolonganMSTController extends GolonganMController
{
  public function actionView($id)
  {
    return GolonganMController::actionView($id);
  }

  public function actionCreate()
  {
    return GolonganMController::actionCreate();
  }

  public function actionUpdate($id)
  {
    return GolonganMController::actionUpdate($id);
  }

  public function actionIndex()
  {
    return GolonganMController::actionIndex();
  }

  public function actionAdmin()
  {
    return GolonganMController::actionAdmin();
  }

  public function loadModel($id)
  {
    return GolonganMController::loadModel($id);
  }

  protected function performAjaxValidation($model)
  {
    return GolonganMController::performAjaxValidation($model);
  }

  public function actionDelete()
  {
    return GolonganMController::actionDelete();
  }

  public function actionRemoveTemporary()
  {
    return GolonganMController::actionRemoveTemporary();
  }

  public function actionPrint()
  {
    return GolonganMController::actionPrint();
  }
}
