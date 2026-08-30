<?php

Yii::import('gudangFarmasi.models.*');
Yii::import('gudangFarmasi.controllers.InformasiPemesananObatAlkesKeluarController');

class InformasiPemesananObatAlkesKeluarBDController extends InformasiPemesananObatAlkesKeluarController
{
  public $defaultAction = 'index';
  public $path_view = 'gudangFarmasi.views.informasiPemesananObatAlkesKeluar.';

  public function actionIndex()
  {
    return InformasiPemesananObatAlkesKeluarController::actionIndex();
  }

  /**
   * Mengatur dropdown ruangan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
    return InformasiPemesananObatAlkesKeluarController::actionSetDropdownRuangan($encode, $model_nama, $attr);
  }

  /**
   * menampilkan url print karna setiap modul berbeda
   */
  public function getUrlPrint()
  {
    return $this->createUrl('pemesananObatAlkesBD/print');
  }

  /**
   * Untuk batal pemesanana obat
   */
  public function actionBatalPemesananObat()
  {
    return InformasiPemesananObatAlkesKeluarController::actionBatalPemesananObat();
  }
}
