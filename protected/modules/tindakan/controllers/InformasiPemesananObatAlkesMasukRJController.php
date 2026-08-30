<?php
Yii::import('gudangFarmasi.models.*');
Yii::import('gudangFarmasi.controllers.InformasiPemesananObatAlkesMasukController');
class InformasiPemesananObatAlkesMasukRJController extends InformasiPemesananObatAlkesMasukController
{
  /**
   * menampilkan url print karna setiap modul berbeda
   */
  public function getUrlPrint()
  {
    return $this->createUrl('pemesananObatAlkesRJ/print');
  }
  /**
   * menampilkan url action transaksi mutasi karna setiap modul berbeda
   */
  public function getUrlMutasi()
  {
    return $this->createUrl("MutasiObatAlkesRJ/Index");
  }
}
