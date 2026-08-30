<?php
Yii::import('penggajian.models.*');
Yii::import('kepegawaian.models.*');
Yii::import('kepegawaian.controllers.PesangonpegTController');
class PesangonpegTGJController extends PesangonpegTController
{
    public function actionCreate($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(3337);
        return PesangonpegTController::actionCreate($linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(3336);
        return PesangonpegTController::actionInformasi($linkHalaman);
    }
}
