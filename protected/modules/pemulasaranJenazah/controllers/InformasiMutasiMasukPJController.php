<?php

Yii::import('gudangFarmasi.models.*');
Yii::import('gudangFarmasi.controllers.InformasiMutasiMasukController');

class InformasiMutasiMasukPJController extends InformasiMutasiMasukController
{
  public $defaultAction = 'index';
  public $path_view = 'gudangFarmasi.views.informasiMutasiMasuk.';
  public $terimamutasidetailtersimpan = true;
  public $stokobatalkestersimpan = true;

  public function actionIndex()
  {
    return InformasiMutasiMasukController::actionIndex();
  }

  /**
   * Mengatur dropdown ruangan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
    return InformasiMutasiMasukController::actionSetDropdownRuangan($encode, $model_nama, $attr);
  }

  /**
   * untuk print detail mutasi
   */
  public function actionPrint($mutasioaruangan_id, $caraprint = null)
  {
    return InformasiMutasiMasukController::actionPrint($mutasioaruangan_id, $caraprint);
  }

  public function actionTerimaMutasi($terimamutasi_id = null, $mutasioaruangan_id = null)
  {
    return InformasiMutasiMasukController::actionTerimaMutasi($terimamutasi_id, $mutasioaruangan_id);
  }

  public function actionAutocompletePegawaiMengetahui()
  {
    return InformasiMutasiMasukController::actionAutocompletePegawaiMengetahui();
  }

  public function actionAutocompletePegawaiPenerima()
  {
    return InformasiMutasiMasukController::actionAutocompletePegawaiPenerima();
  }

  /**
   * untuk print detail terima mutasi
   */
  public function actionPrintTerimaMutasi($terimamutasi_id, $caraprint = null)
  {
    return InformasiMutasiMasukController::actionPrintTerimaMutasi($terimamutasi_id, $caraprint);
  }

  public function actionBatalMutasiDetail()
  {
    return InformasiMutasiMasukController::actionBatalMutasiDetail();
  }
}
