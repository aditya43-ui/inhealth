<?php
Yii::import('pengadaan.controllers.InformasiRencKebBarangController');
Yii::import('pengadaan.models.*');
class InformasiRencKebBarangGUController extends InformasiRencKebBarangController
{
    //put your code here
    public $controllerPembelian = "PembelianbarangTGU";
    public $path_rencana = 'RencanaKebBarangGU';
    public function actionIndex($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(588);
        return InformasiRencKebBarangController::actionIndex($linkHalaman);
    }
}
