<?php

Yii::import('gudangFarmasi.models.*');
Yii::import('gudangFarmasi.controllers.MutasiObatAlkesController');

class MutasiObatAlkesBDController extends MutasiObatAlkesController
{

  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'gudangFarmasi.views.mutasiObatAlkes.';
  public $mutasidetailtersimpan = true; //looping
  public $stokobatalkestersimpan = true; //looping

  /**
   * Membuat dan menyimpan data baru.
   */

  public function actionIndex($mutasioaruangan_id = null, $pesanobatalkes_id = null)
  {
    return MutasiObatAlkesController::actionIndex($mutasioaruangan_id, $pesanobatalkes_id);
  }

  public function actionAutocompletePegawaiMengetahui()
  {
    return MutasiObatAlkesController::actionAutocompletePegawaiMengetahui();
  }

  /**
   * menampilkan obat
   * @return row table 
   */
  public function actionSetFormMutasiDetail()
  {
    return MutasiObatAlkesController::actionSetFormMutasiDetail();
  }

  /**
   * Mengatur dropdown ruangan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
    return MutasiObatAlkesController::actionSetDropdownRuangan($encode, $model_nama, $attr);
  }

  public function actionAutocompleteObatAlkes()
  {
    return MutasiObatAlkesController::actionAutocompleteObatAlkes();
  }

  /**
   * untuk print data rencana kebutuhan farmasi
   */
  public function actionPrint($mutasioaruangan_id, $caraprint = null)
  {
    return MutasiObatAlkesController::actionPrint($mutasioaruangan_id, $caraprint);
  }

  public function actionHapusDetailMutasi()
  {
    return MutasiObatAlkesController::actionHapusDetailMutasi();
  }
}
