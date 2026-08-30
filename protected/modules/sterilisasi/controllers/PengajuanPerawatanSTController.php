<?php
Yii::import('laundry.controllers.PengajuanPerawatanTController');
Yii::import('laundry.models.*');
Yii::import('laundry.views.*');
class PengajuanPerawatanSTController extends PengajuanPerawatanTController
{
    public function actionIndex($pengperawatanlinen_id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(3455);
        return PengajuanPerawatanTController::actionIndex($pengperawatanlinen_id, $linkHalaman);
    }
}
