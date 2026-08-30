<?php

Yii::import('gudangFarmasi.models.*');
Yii::import('gudangFarmasi.controllers.PemesananObatAlkesController');

class PemesananObatAlkesAMController extends PemesananObatAlkesController
{
  public $defaultAction = 'index';
  public $path_view = 'gudangFarmasi.views.pemesananObatAlkes.';
  public $pesanobatalkestersimpan = true;

  public function actionIndex($pesanobatalkes_id = null)
  {
    $this->pageTitle = Yii::app()->name . " - Pemesanan Obat Alkes";
    return PemesananObatAlkesController::actionIndex($pesanobatalkes_id);
  }

  /**
   * Mengatur dropdown ruangan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
    return PemesananObatAlkesController::actionSetDropdownRuangan($encode, $model_nama, $attr);
  }

  public function actionSetFormDetailPemesanan()
  {
    return PemesananObatAlkesController::actionSetFormDetailPemesanan();
  }

  /**
   * untuk print data pemesanan obat alkes
   */
  public function actionPrint($pesanobatalkes_id, $caraprint = null)
  {
    return PemesananObatAlkesController::actionPrint($pesanobatalkes_id, $caraprint);
  }

  public function actionAutocompletePegawai()
  {
    return PemesananObatAlkesController::actionAutocompletePegawai();
  }

  /**
   * untuk form tambah obat alkes
   * di copy dari laboratorium/pemakaianBmhpController
   */
  public function actionAutocompleteObatAlkes()
  {
    return PemesananObatAlkesController::actionAutocompleteObatAlkes();
  }
}
