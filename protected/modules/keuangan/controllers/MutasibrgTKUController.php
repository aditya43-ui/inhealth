<?php
Yii::import('gudangUmum.controllers.MutasibrgTController');
Yii::import('gudangUmum.models.*');
class MutasibrgTKUController extends MutasibrgTController
{
    public function actionIndex($id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(199);
        return MutasibrgTController::actionIndex($id, $linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(79);
        return MutasibrgTController::actionInformasi($linkHalaman);
    }
}
