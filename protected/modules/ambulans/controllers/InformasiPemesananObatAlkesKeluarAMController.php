<?php

Yii::import('gudangFarmasi.models.*');
Yii::import('gudangFarmasi.controllers.InformasiPemesananObatAlkesKeluarController');

class InformasiPemesananObatAlkesKeluarAMController extends InformasiPemesananObatAlkesKeluarController
{
  public $defaultAction = 'index';
  public $path_view = 'gudangFarmasi.views.informasiPemesananObatAlkesKeluar.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pemesanan Obat Alkes Keluar";
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
    return $this->createUrl('pemesananObatAlkesAM/print');
  }

  /**
   * 
   * Utuk batal pemesanan obat
   */
  public function actionBatalPemesananObat()
  {
    return InformasiPemesananObatAlkesKeluarController::actionBatalPemesananObat();
  }
}
