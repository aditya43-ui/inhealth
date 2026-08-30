<?php
Yii::import('gudangUmum.models.*');
Yii::import('gudangUmum.controllers.InfoPemakaianBarangController');
/**
 * Extend Informasi Pemakaian Barang dari Modul Gudang Umum
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.informasi
 * @subpackage controllers
 */
class InfoPemakaianBarangINController extends InfoPemakaianBarangController
{
    public function actionIndex($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(3196);
        return InfoPemakaianBarangController::actionIndex($linkHalaman);
    }
}
