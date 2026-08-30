<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.SubkelompokMController');
class SubkelompokMSTController extends SubkelompokMController
{
  public function actionView($id)
  {
    return SubkelompokMController::actionView($id);
  }

  public function actionCreate()
  {
    return SubkelompokMController::actionCreate();
  }

  public function actionUpdate($id)
  {
    return SubkelompokMController::actionUpdate($id);
  }

  public function actionIndex()
  {
    return SubkelompokMController::actionIndex();
  }

  public function actionAdmin()
  {
    return SubkelompokMController::actionAdmin();
  }

  public function loadModel($id)
  {
    return SubkelompokMController::loadModel($id);
  }

  protected function performAjaxValidation($model)
  {
    return SubkelompokMController::performAjaxValidation($model);
  }

  public function actionDelete()
  {
    return SubkelompokMController::actionDelete();
  }

  public function actionRemoveTemporary()
  {
    return SubkelompokMController::actionRemoveTemporary();
  }

  public function actionPrint()
  {
    return SubkelompokMController::actionPrint();
  }

  public function actionAutocompleteKelompok()
  {
    return SubkelompokMController::actionAutocompleteKelompok();
  }
}
