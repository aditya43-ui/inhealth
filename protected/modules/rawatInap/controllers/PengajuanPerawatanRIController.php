<?php
Yii::import('laundry.controllers.PengajuanPerawatanTController');
Yii::import('laundry.models.*');
Yii::import('laundry.views.*');
class PengajuanPerawatanRIController extends PengajuanPerawatanTController
{
    public function actionIndex($pengperawatanlinen_id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(3412);
        return PengajuanPerawatanTController::actionIndex($pengperawatanlinen_id, $linkHalaman);
    }
}
