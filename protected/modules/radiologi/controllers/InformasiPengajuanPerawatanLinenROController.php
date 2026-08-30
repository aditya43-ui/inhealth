<?php
Yii::import('laundry.controllers.InformasiPengajuanPerawatanLinenController');
Yii::import('laundry.models.*');
Yii::import('laundry.views.*');
class InformasiPengajuanPerawatanLinenROController extends InformasiPengajuanPerawatanLinenController
{
    public function actionIndex($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(3428);
        return InformasiPengajuanPerawatanLinenController::actionIndex($linkHalaman);
    }
}
