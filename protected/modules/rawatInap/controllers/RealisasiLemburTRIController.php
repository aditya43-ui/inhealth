<?php
Yii::import('kepegawaian.controllers.RealisasiLemburTController');
Yii::import('kepegawaian.models.*');
Yii::import('kepegawaian.views.*');
class RealisasiLemburTRIController extends RealisasiLemburTController
{
    public function actionBuat($id = null, $sukses = '', $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(2239);
        return RealisasiLemburTController::actionBuat($id, $sukses, $linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(2207);
        return RealisasiLemburTController::actionInformasi($linkHalaman);
    }
}
