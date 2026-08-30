<?php
Yii::import('laundry.controllers.InformasiPengajuanPerawatanLinenController');
Yii::import('laundry.models.*');
Yii::import('laundry.views.*');
class InformasiPengajuanPerawatanLinenSTController extends InformasiPengajuanPerawatanLinenController
{
    public function actionIndex($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(3454);
        return InformasiPengajuanPerawatanLinenController::actionIndex($linkHalaman);
    }
}
