<?php
Yii::import('gudangUmum.controllers.MutasibrgTController');
Yii::import('gudangUmum.models.*');
class MutasibrgTPPController extends MutasibrgTController
{
    public function actionIndex($id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(138);
        return MutasibrgTController::actionIndex($id, $linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(60);
        return MutasibrgTController::actionInformasi($linkHalaman);
    }
}
