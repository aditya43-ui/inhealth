<?php
Yii::import('kepegawaian.controllers.RealisasiLemburTController');
Yii::import('kepegawaian.models.*');
Yii::import('kepegawaian.views.*');
class RealisasiLemburTBSController extends RealisasiLemburTController
{
    public $modul_sk = 'BS';
    public function actionBuat($id = null, $id_realisasi = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(2227);
        return RealisasiLemburTController::actionBuat($id, $id_realisasi, $linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(2195);
        return RealisasiLemburTController::actionInformasi($linkHalaman);
    }
}
