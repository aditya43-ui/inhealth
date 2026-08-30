<?php
Yii::import('gudangUmum.controllers.PesanbarangTController');
Yii::import('gudangUmum.models.*');
Yii::import('gudangUmum.views.pesanbarangT');
/**
 * 
 * controller transaksi pesan barang
 *
 * @package      application.modules.mcu
 * @subpackage   controllers
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */
class PesanbarangTMCController extends PesanbarangTController
{
    public function actionIndex($id = null, $a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(2987);
        return PesanbarangTController::actionIndex($id, $linkHalaman);
    }
    public function actionInformasi($a = null)
    {
        $linkHalaman = CustomFunction::getUrlByMenuID(2988);
        return PesanbarangTController::actionInformasi($linkHalaman);
    }
}
