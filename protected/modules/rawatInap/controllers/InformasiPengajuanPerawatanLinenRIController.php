<?php
Yii::import('laundry.controllers.InformasiPengajuanPerawatanLinenController');
Yii::import('laundry.models.*');
Yii::import('laundry.views.*');
class InformasiPengajuanPerawatanLinenRIController extends InformasiPengajuanPerawatanLinenController
{
    public function actionIndex($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(1732);
        return InformasiPengajuanPerawatanLinenController::actionIndex($linkHalaman);
    }
}
