<?php
Yii::import('laundry.controllers.InformasiPengajuanPerawatanLinenController');
Yii::import('laundry.models.*');
Yii::import('laundry.views.*');
class InformasiPengajuanPerawatanLinenRMController extends InformasiPengajuanPerawatanLinenController
{
    public function actionIndex($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(2704);
        return InformasiPengajuanPerawatanLinenController::actionIndex($linkHalaman);
    }
}
