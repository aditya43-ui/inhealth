<?php
Yii::import('kepegawaian.controllers.RealisasiLemburTController');
Yii::import('kepegawaian.models.*');
Yii::import('kepegawaian.views.*');
class RealisasiLemburTRDController extends RealisasiLemburTController
{
    public function actionBuat($id = null, $sukses = '', $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(2238);
        return RealisasiLemburTController::actionBuat($id, $sukses, $linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(2206);
        return RealisasiLemburTController::actionInformasi($linkHalaman);
    }
}
