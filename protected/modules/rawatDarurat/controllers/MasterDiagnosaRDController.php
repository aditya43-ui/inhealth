<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.MasterDiagnosaController');
class MasterDiagnosaRDController extends MasterDiagnosaController
{
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlTabularList()
  {
    return $this->module->id . '/TabularListMRD/Admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlKelompokDiagnosa()
  {
    return $this->module->id . '/kelompokdiagnosaMRD/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlKlasifikasiDiagnosa()
  {
    return $this->module->id . '/klasifikasiDiagnosaRD/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlDTD()
  {
    return $this->module->id . '/dtdMRD/Admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlDiagnosa()
  {
    return $this->module->id . '/diagnosaMRD/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlDiagnosaIX()
  {
    return $this->module->id . '/diagnosaICDIXMRD/admin';
  }
}
