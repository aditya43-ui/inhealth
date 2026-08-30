<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.MasterPerujukPasienController');

class MasterPerujukPasienPPController extends MasterPerujukPasienController
{
  /**
   * url untuk tab menu
   * @return string
   */
  public function getUrlAsalRujukan()
  {
    return $this->module->id . "/AsalRujukanMPP/Admin";
  }
  /**
   * url untuk tab menu
   * @return string
   */
  public function getUrlRujukanDari()
  {
    return $this->module->id . "/RujukandariMPP/Admin";
  }
  /**
   * url untuk tab menu
   * @return string
   */
  public function getUrlRujukanKeluar()
  {
    return $this->module->id . "/RujukanKeluarMPP/Admin";
  }
}
