<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.LookupMController');
class LookupMSTController extends LookupMController
{
  public function actionView($id)
  {
    return LookupMController::actionView($id);
  }

  public function actionCreate()
  {
    return LookupMController::actionCreate();
  }

  public function actionUpdate($id)
  {
    return LookupMController::actionUpdate($id);
  }

  public function actionIndex()
  {
    return LookupMController::actionIndex();
  }

  public function actionAdmin()
  {
    return LookupMController::actionAdmin();
  }

  public function loadModel($id)
  {
    return LookupMController::loadModel($id);
  }

  public function actionNonActive($id)
  {
    return LookupMController::actionNonActive($id);
  }

  protected function performAjaxValidation($model)
  {
    return LookupMController::performAjaxValidation($model);
  }

  public function actionPrint()
  {
    return LookupMController::actionPrint();
  }
}
