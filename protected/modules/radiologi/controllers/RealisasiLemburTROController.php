<?php
Yii::import('kepegawaian.controllers.RealisasiLemburTController');
Yii::import('kepegawaian.models.*');
Yii::import('kepegawaian.views.*');
class RealisasiLemburTROController extends RealisasiLemburTController
{
    public function actionBuat($id = null, $id_realisasi = null, $linkHalaman = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(2237);
        return RealisasiLemburTController::actionBuat($id, $id_realisasi, $linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(2205);
        return RealisasiLemburTController::actionInformasi($linkHalaman);
    }
}
