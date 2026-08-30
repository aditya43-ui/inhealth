<?php
Yii::import('gudangFarmasi.models.*');
Yii::import('gudangFarmasi.controllers.InformasiPemesananObatAlkesKeluarController');
class InformasiPemesananObatAlkesKeluarROController extends InformasiPemesananObatAlkesKeluarController
{
  /**
   * menampilkan url print karna setiap modul berbeda
   */
  public function getUrlPrint()
  {
    return Yii::app()->createUrl('gudangFarmasi/pemesananObatAlkes/print');
  }
}
