<?php
Yii::import('laundry.controllers.PengajuanPerawatanTController');
Yii::import('laundry.models.*');
Yii::import('laundry.views.*');
class PengajuanPerawatanGZController extends PengajuanPerawatanTController
{
    public function actionIndex($pengperawatanlinen_id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(3463);
        return PengajuanPerawatanTController::actionIndex($pengperawatanlinen_id, $linkHalaman);
    }
}
