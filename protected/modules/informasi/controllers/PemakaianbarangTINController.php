<?php
Yii::import('gudangUmum.models.*');
Yii::import('gudangUmum.controllers.PemakaianbarangTController');
/**
 * Extend Transaksi Pemakaian Barang dari Modul Gudang Umum
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.informasi
 * @subpackage controllers
 */
class PemakaianbarangTINController extends PemakaianbarangTController
{
    public function actionIndex($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(3195);
        return PemakaianbarangTController::actionIndex($linkHalaman);
    }
}
