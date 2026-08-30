<?php

Yii::import('sterilisasi.models.*');
Yii::import('sterilisasi.controllers.InformasiPenerimaanPeralatanLinenSterilController');

class InformasiPenerimaanPeralatanLinenSterilPIController extends InformasiPenerimaanPeralatanLinenSterilController
{
  public $path_view = 'sterilisasi.views.informasiPenerimaanPeralatanLinenSteril.';

  public function actionIndex()
  {
    return InformasiPenerimaanPeralatanLinenSterilController::actionIndex();
  }

  public function actionDetail($terimaperlinensteril_id = null)
  {
    return InformasiPenerimaanPeralatanLinenSterilController::actionDetail($terimaperlinensteril_id);
  }

  /**
   * Mengatur dropdown ruangan
   * @param type $encode jika = true maka return array jika false maka set Dropdown 
   * @param type $model_nama
   * @param type $attr
   */
  public function actionSetDropdownRuangan($encode = false, $model_nama = '', $attr = '')
  {
    return InformasiPenerimaanPeralatanLinenSterilController::actionSetDropdownRuangan($encode, $model_nama, $attr);
  }

  public function actionBatalPenerimaan($id)
  {
    return InformasiPenerimaanPeralatanLinenSterilController::actionBatalPenerimaan($id);
  }

  public function actionPrintDetail($terimaperlinensteril_id)
  {
    return InformasiPenerimaanPeralatanLinenSterilController::actionPrintDetail($terimaperlinensteril_id);
  }
}
