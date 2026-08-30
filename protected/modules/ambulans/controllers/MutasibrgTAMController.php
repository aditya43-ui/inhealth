<?php
Yii::import('gudangUmum.models.*');
Yii::import('gudangUmum.controllers.MutasibrgTController');
class MutasibrgTAMController extends MutasibrgTController
{
    public function actionIndex($id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(2570);
        return MutasibrgTController::actionIndex($id, $linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(2587);
        return MutasibrgTController::actionInformasi($linkHalaman);
    }
}
