<?php
Yii::import('gudangFarmasi.controllers.PermintaanPembelianController');
Yii::import('gudangFarmasi.models.*');
class PermintaanPembelianGFController extends PermintaanPembelianController
{
  public function actionIndex($permintaanpembelian_id = null, $rencana_id = null, $penawaran_id = null, $a = null)
  {
      $linkHalaman = CustomFunction::getUrlByMenuID(1067);
      return PermintaanPembelianController::actionIndex($permintaanpembelian_id, $rencana_id, $penawaran_id, $linkHalaman);
  }
}
