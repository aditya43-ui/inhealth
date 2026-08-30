<?php
Yii::import('kepegawaian.controllers.RealisasiLemburTController');
Yii::import('kepegawaian.models.*');
Yii::import('kepegawaian.views.*');
class RealisasiLemburTPIController extends RealisasiLemburTController
{
    public function actionBuat($id = null, $id_realisasi = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(3371);
        return RealisasiLemburTController::actionBuat($id, $id_realisasi, $linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(3369);
        return RealisasiLemburTController::actionInformasi($linkHalaman);
    }
}
