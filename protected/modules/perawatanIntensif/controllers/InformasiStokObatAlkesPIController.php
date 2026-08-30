<?php
Yii::import('gudangFarmasi.models.*');
Yii::import('gudangFarmasi.controllers.InformasiStokObatAlkesController');
class InformasiStokObatAlkesPIController extends InformasiStokObatAlkesController
{
  public $defaultAction = 'index';
  public $path_view = 'gudangFarmasi.views.informasiStokObatAlkes.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Stok Obat Alkes";
    return InformasiStokObatAlkesController::actionIndex();
  }

  /**
   * Mengatur dropdown ruangan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
    return InformasiStokObatAlkesController::actionSetDropdownRuangan($encode, $model_nama, $attr);
  }

  public function actionUbahLokasiObat($obatalkes_id, $ruangan_id)
  {
    return InformasiStokObatAlkesController::actionUbahLokasiObat($obatalkes_id, $ruangan_id);
  }

  /**
   * tombol di tabel
   * @return string
   */
  public function getUrlUbahLokasiRak()
  {
    return $this->module->id . "/" . $this->id . "/ubahLokasiObat";
  }
}
