<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.SubsubkelompokMController');
class SubsubkelompokMSTController extends SubsubkelompokMController
{
  public function actionView($id)
  {
    return SubsubkelompokMController::actionView($id);
  }

  public function actionCreate()
  {
    return SubsubkelompokMController::actionCreate();
  }

  public function actionUpdate($id)
  {
    return SubsubkelompokMController::actionUpdate($id);
  }

  public function actionDelete()
  {
    return SubsubkelompokMController::actionDelete();
  }

  public function actionNonActive($id)
  {
    return SubsubkelompokMController::actionNonActive($id);
  }

  public function actionRemoveTemporary()
  {
    return SubsubkelompokMController::actionRemoveTemporary();
  }

  public function actionIndex()
  {
    return SubsubkelompokMController::actionIndex();
  }

  public function actionAdmin()
  {
    return SubsubkelompokMController::actionAdmin();
  }

  public function loadModel($id)
  {
    return SubsubkelompokMController::loadModel($id);
  }

  protected function performAjaxValidation($model)
  {
    return SubsubkelompokMController::performAjaxValidation($model);
  }

  public function actionPrint()
  {
    return SubsubkelompokMController::actionPrint();
  }

  public function actionAutocompleteSubKelompok()
  {
    return SubsubkelompokMController::actionAutocompleteSubKelompok();
  }
}
