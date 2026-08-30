<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.MasterDiagnosaController');
class MasterDiagnosaRJController extends MasterDiagnosaController
{
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlTabularList()
  {
    return $this->module->id . '/TabularListMRJ/Admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlKelompokDiagnosa()
  {
    return $this->module->id . '/kelompokdiagnosaMRJ/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlKlasifikasiDiagnosa()
  {
    return $this->module->id . '/klasifikasiDiagnosaRJ/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlDTD()
  {
    return $this->module->id . '/dtdMRJ/Admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlDiagnosa()
  {
    return $this->module->id . '/diagnosaMRJ/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlDiagnosaIX()
  {
    return $this->module->id . '/diagnosaICDIXMRJ/admin';
  }
}
