
<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.KodespkMController');
class KodespkMADController extends KodespkMController
{
    public $layout = '//layouts/column1';
    public $defaultAction = 'admin';
    public $path_view = 'sistemAdministrator.views.kodespkM.';
    
    public function actionView($id)
    {
        return KodespkMController::actionView($id);
    }
    
    public function actionCreate()
    {
        return KodespkMController::actionCreate();
    }
    
    public function actionUpdate($id)
    {
        return KodespkMController::actionUpdate($id);
    }
    
    public function actionDelete($id)
    {
        return KodespkMController::actionDelete($id);
    }
    
    public function actionNonActive($id)
    {
        return KodespkMController::actionNonActive($id);
    }
    
    public function actionIndex()
    {
        return KodespkMController::actionIndex();
    }
    
    public function actionAdmin()
    {
        return KodespkMController::actionAdmin();
    }
    
    public function actionPrint()
    {
        return KodespkMController::actionPrint();
    }
}
