<?php
Yii::import('kepegawaian.controllers.RealisasiLemburTController');
Yii::import('kepegawaian.models.*');
Yii::import('kepegawaian.views.*');
class RealisasiLemburTPPController extends RealisasiLemburTController
{
    public function actionBuat($id = null, $id_realisasi = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(2235);
        return RealisasiLemburTController::actionBuat($id, $id_realisasi, $linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(2203);
        return RealisasiLemburTController::actionInformasi($linkHalaman);
    }
}
