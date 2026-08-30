<?php
Yii::import('laundry.controllers.KehilanganLinenController');
Yii::import('laundry.models.*');
Yii::import('laundry.views.*');
class KehilanganLinenROController extends KehilanganLinenController
{
    public function actionIndex($id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(3431);
        return KehilanganLinenController::actionIndex($id, $linkHalaman);
    }
}
