<?php
Yii::import('gudangUmum.controllers.MutasibrgTController');
Yii::import('gudangUmum.models.*');
class MutasibrgTRKController extends MutasibrgTController
{
    public function actionIndex($id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(142);
        return MutasibrgTController::actionIndex($id, $linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(67);
        return MutasibrgTController::actionInformasi($linkHalaman);
    }
}
