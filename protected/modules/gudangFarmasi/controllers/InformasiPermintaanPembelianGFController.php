<?php
Yii::import('gudangFarmasi.models.*');
Yii::import('gudangFarmasi.controllers.InformasiPermintaanPembelianController');
class InformasiPermintaanPembelianGFController extends InformasiPermintaanPembelianController
{
  public $path_permintaan = 'PermintaanPembelianGF';
  public $path_penerimaan = 'PenerimaanBarangGF';
  public function actionIndex($a = null)
  {
      $linkHalaman = CustomFunction::getUrlByMenuID(1065);
      return InformasiPermintaanPembelianController::actionIndex($linkHalaman);
  }
}
