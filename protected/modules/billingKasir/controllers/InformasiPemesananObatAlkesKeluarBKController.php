<?php
Yii::import('gudangFarmasi.models.*');
Yii::import('gudangFarmasi.controllers.InformasiPemesananObatAlkesKeluarController');
class InformasiPemesananObatAlkesKeluarBKController extends InformasiPemesananObatAlkesKeluarController
{
  /**
   * menampilkan url print karna setiap modul berbeda
   */
  public function getUrlPrint()
  {
    return $this->createUrl('pemesananObatAlkesBK/print');
  }
}
