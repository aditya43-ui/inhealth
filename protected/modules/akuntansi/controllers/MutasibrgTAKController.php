<?php
Yii::import('gudangUmum.controllers.MutasibrgTController');
Yii::import('gudangUmum.models.*');
class MutasibrgTAKController extends MutasibrgTController
{
    public function actionIndex($id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(175);
        return MutasibrgTController::actionIndex($id, $linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(71);
        return MutasibrgTController::actionInformasi($linkHalaman);
    }
}
