<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.MasterDiagnosaController');
class MasterDiagnosaRIController extends MasterDiagnosaController
{
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlTabularList()
  {
    return $this->module->id . '/TabularListMRI/Admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlKelompokDiagnosa()
  {
    return $this->module->id . '/kelompokdiagnosaMRI/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlKlasifikasiDiagnosa()
  {
    return $this->module->id . '/klasifikasiDiagnosaRI/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlDTD()
  {
    return $this->module->id . '/dtdMRI/Admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlDiagnosa()
  {
    return $this->module->id . '/diagnosaMRI/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlDiagnosaIX()
  {
    return $this->module->id . '/diagnosaICDIXMRI/admin';
  }
}
