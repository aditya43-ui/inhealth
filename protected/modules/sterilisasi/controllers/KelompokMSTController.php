<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.KelompokMController');
class KelompokMSTController extends KelompokMController
{
  public function actionView($id)
  {
    return KelompokMController::actionView($id);
  }

  public function actionCreate()
  {
    return KelompokMController::actionCreate();
  }

  public function actionUpdate($id)
  {
    return KelompokMController::actionUpdate($id);
  }

  public function actionIndex()
  {
    return KelompokMController::actionIndex();
  }

  public function actionAdmin()
  {
    return KelompokMController::actionAdmin();
  }

  public function loadModel($id)
  {
    return KelompokMController::loadModel($id);
  }

  protected function performAjaxValidation($model)
  {
    return KelompokMController::performAjaxValidation($model);
  }

  public function actionDelete($id)
  {
    return KelompokMController::actionDelete($id);
  }

  public function actionRemoveTemporary()
  {
    return KelompokMController::actionRemoveTemporary();
  }

  public function actionPrint()
  {
    return KelompokMController::actionPrint();
  }

  public function actionAutocompleteBidang()
  {
    return KelompokMController::actionAutocompleteBidang();
  }
}
