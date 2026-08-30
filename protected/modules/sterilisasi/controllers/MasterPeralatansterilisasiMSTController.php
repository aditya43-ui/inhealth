<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.MasterPeralatansterilisasiMController');

class MasterPeralatansterilisasiMSTController extends MasterPeralatansterilisasiMController
{
  public function getUrlPeralatanSterilisasi()
  {
    return $this->module->id . '/PeralatansterilisasiMST/Admin';
  }

  public function getUrlMapBarangSterilisasi()
  {
    return $this->module->id . '/MapbarangsterilisasiMST/Admin';
  }

  public function getUrlMapAlkesSterilisasi()
  {
    return $this->module->id . '/MapalkessterilisasiMST/Admin';
  }

  public function getUrlMapLinenSterilisasi()
  {
    return $this->module->id . '/MaplinensterilisasiMST/Admin';
  }
}
