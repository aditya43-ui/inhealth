<?php
Yii::import('gudangUmum.models.*');
Yii::import('gudangUmum.controllers.PesanbarangTController');
/**
 * Extend transaksi dan informasi pesan barang dari modul gudang umum
 * @author Aida Rahmawati <aidarahmawati@.com>
 * @package application.modules.informasi
 * @subpackage controllers
 */
class PesanbarangTINController extends PesanbarangTController
{
    public function actionIndex($id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(3193);
        return PesanbarangTController::actionIndex($id, $linkHalaman);
    }
    public function actionInformasi($a = null) {
        $linkHalaman = CustomFunction::getUrlByMenuID(3192);
        return PesanbarangTController::actionInformasi($linkHalaman);
    }
}
