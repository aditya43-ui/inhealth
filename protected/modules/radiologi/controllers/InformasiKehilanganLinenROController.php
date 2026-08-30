<?php
Yii::import('laundry.controllers.InformasiKehilanganLinenController');
Yii::import('laundry.models.*');
Yii::import('laundry.views.*');
class InformasiKehilanganLinenROController extends InformasiKehilanganLinenController
{
    public function actionIndex($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(3430);
        return InformasiKehilanganLinenController::actionIndex($linkHalaman);
    }
}
