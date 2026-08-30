<?php
Yii::import('gudangUmum.controllers.MutasibrgTController');
Yii::import('gudangUmum.models.*');
class MutasibrgTKPController extends MutasibrgTController
{
    public function actionIndex($id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(188);
        return MutasibrgTController::actionIndex($id, $linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(76);
        return MutasibrgTController::actionInformasi($linkHalaman);
    }
}
