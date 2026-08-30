<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.MasterPerujukPasienController');

class MasterPerujukPasienBDController extends MasterPerujukPasienController
{
  /**
   * url untuk tab menu
   * @return string
   */
  public function getUrlAsalRujukan()
  {
    return $this->module->id . "/AsalRujukanMBD/Admin";
  }
  /**
   * url untuk tab menu
   * @return string
   */
  public function getUrlRujukanDari()
  {
    return $this->module->id . "/RujukandariMBD/Admin";
  }
  /**
   * url untuk tab menu
   * @return string
   */
  public function getUrlRujukanKeluar()
  {
    return $this->module->id . "/RujukanKeluarMBD/Admin";
  }
}
