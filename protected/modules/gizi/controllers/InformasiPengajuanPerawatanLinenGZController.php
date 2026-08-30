<?php
Yii::import('laundry.controllers.InformasiPengajuanPerawatanLinenController');
Yii::import('laundry.models.*');
Yii::import('laundry.views.*');
class InformasiPengajuanPerawatanLinenGZController extends InformasiPengajuanPerawatanLinenController
{
    public function actionIndex($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(3462);
        return InformasiPengajuanPerawatanLinenController::actionIndex($linkHalaman);
    }
}
