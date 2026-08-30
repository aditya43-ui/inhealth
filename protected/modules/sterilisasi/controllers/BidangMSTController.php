<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.BidangMController');
class BidangMSTController extends BidangMController
{
  public function actionView($id)
  {
    return BidangMController::actionView($id);
  }

  public function actionCreate()
  {
    return BidangMController::actionCreate();
  }

  public function actionUpdate($id)
  {
    return BidangMController::actionUpdate($id);
  }

  public function actionIndex()
  {
    return BidangMController::actionIndex();
  }

  public function actionAdmin()
  {
    return BidangMController::actionAdmin();
  }

  public function loadModel($id)
  {
    return BidangMController::loadModel($id);
  }

  protected function performAjaxValidation($model)
  {
    return BidangMController::performAjaxValidation($model);
  }

  public function actionDelete()
  {
    return BidangMController::actionDelete();
  }

  public function actionRemoveTemporary()
  {
    return BidangMController::actionRemoveTemporary();
  }

  public function actionPrint()
  {
    return BidangMController::actionPrint();
  }

  public function actionAutocompleteGolongan()
  {
    return BidangMController::actionAutocompleteGolongan();
  }
}
