<?php
Yii::import("pengadaan.controllers.RencanaKebutuhanController");
Yii::import("pengadaan.models.*");
class RencanaKebutuhanGFController extends RencanaKebutuhanController
{
    public function actionIndex($rencanakebfarmasi_id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(557);
        return RencanaKebutuhanController::actionIndex($rencanakebfarmasi_id, $linkHalaman);
    }
}
