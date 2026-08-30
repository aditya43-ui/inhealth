<?php
Yii::import('kepegawaian.controllers.RealisasiLemburTController');
Yii::import('kepegawaian.models.*');
Yii::import('kepegawaian.views.*');
class RealisasiLemburTGFController extends RealisasiLemburTController
{
    public $modul_sk = 'GF';
    public function actionBuat($id = null, $sukses = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(2231);
        return RealisasiLemburTController::actionBuat($id, $sukses, $linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(2199);
        return RealisasiLemburTController::actionInformasi($linkHalaman);
    }
}
