<?php
Yii::import('kepegawaian.controllers.RealisasiLemburTController');
Yii::import('kepegawaian.models.*');
Yii::import('kepegawaian.views.*');
class RealisasiLemburTRJController extends RealisasiLemburTController
{
    public function actionBuat($id = null, $id_realisasi = '', $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(2240);
        return RealisasiLemburTController::actionBuat($id, $id_realisasi, $linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(2208);
        return RealisasiLemburTController::actionInformasi($linkHalaman);
    }
}
