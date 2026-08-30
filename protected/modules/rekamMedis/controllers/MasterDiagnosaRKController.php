<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.MasterDiagnosaController');
class MasterDiagnosaRKController extends MasterDiagnosaController
{
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlTabularList()
  {
    return $this->module->id . '/TabularListMRK/Admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlKelompokDiagnosa()
  {
    return $this->module->id . '/kelompokdiagnosaMRK/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlKlasifikasiDiagnosa()
  {
    return $this->module->id . '/klasifikasiDiagnosaRK/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlDTD()
  {
    return $this->module->id . '/dtdMRK/Admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlDiagnosa()
  {
    return $this->module->id . '/diagnosaMRK/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlDiagnosaIX()
  {
    return $this->module->id . '/diagnosaICDIXMRK/admin';
  }
}
