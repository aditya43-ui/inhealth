<?php
Yii::import('gudangFarmasi.models.*');
Yii::import('gudangFarmasi.controllers.InformasiMutasiKeluarController');
class InformasiMutasiKeluarSTController extends InformasiMutasiKeluarController
{
  public $defaultAction = 'index';
  public $path_view = 'gudangFarmasi.views.informasiMutasiKeluar.';

  public function actionIndex()
  {
    return InformasiMutasiKeluarController::actionIndex();
  }

  /**
   * Mengatur dropdown ruangan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
    return InformasiMutasiKeluarController::actionSetDropdownRuangan($encode, $model_nama, $attr);
  }

  /**
   * membatalkan transaksi mutasi
   */
  public function actionBatalMutasi()
  {
    return InformasiMutasiKeluarController::actionBatalMutasi();
  }
}
