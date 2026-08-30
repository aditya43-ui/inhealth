<?php
Yii::import('pengadaan.controllers.RencanaKebBarangController');
Yii::import('pengadaan.models.*');
class RencanaKebBarangGUController extends RencanaKebBarangController
{
    public function actionIndex($renkebbarang_id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(622);
        return RencanaKebBarangController::actionIndex($renkebbarang_id, $linkHalaman);
    }
}
