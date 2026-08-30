<?php
Yii::import('kepegawaian.controllers.RealisasiLemburTController');
Yii::import('kepegawaian.models.*');
Yii::import('kepegawaian.views.*');
class RealisasiLemburTSTController extends RealisasiLemburTController
{
    public function actionBuat($id = null, $sukses = '', $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(3395);
        return RealisasiLemburTController::actionBuat($id, $sukses, $linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(3394);
        return RealisasiLemburTController::actionInformasi($linkHalaman);
    }
}
