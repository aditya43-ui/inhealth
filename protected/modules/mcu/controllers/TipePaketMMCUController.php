<?php
Yii::import('sistemAdministrator.controllers.TipePaketMController');
Yii::import('sistemAdministrator.models.*');
class TipePaketMMCUController extends TipePaketMController
{
  public $layout = "//layouts/mainNeonSidebar";

  public function actionView($id)
  {
    return TipePaketMController::actionView($id);
  }

  public function actionCreate()
  {
    return TipePaketMController::actionCreate();
  }

  public function actionUpdate($id)
  {
    return TipePaketMController::actionUpdate($id);
  }

  public function actionDelete($id)
  {
    return TipePaketMController::actionDelete($id);
  }

  public function actionIndex()
  {
    return TipePaketMController::actionIndex();
  }

  public function actionAdmin()
  {
    $this->pageTitle = Yii::app()->name . " - Tipe Paket";
    return TipePaketMController::actionAdmin();
  }

  public function loadModel($id)
  {
    return TipePaketMController::loadModel($id);
  }

  protected function performAjaxValidation($model)
  {
    return TipePaketMController::performAjaxValidation($model);
  }

  public function actionRemoveTemporary($id)
  {
    return TipePaketMController::actionRemoveTemporary($id);
  }

  public function actionPrint()
  {
    return TipePaketMController::actionPrint();
  }
}
