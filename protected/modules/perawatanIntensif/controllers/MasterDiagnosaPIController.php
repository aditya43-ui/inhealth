<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.MasterDiagnosaController');
class MasterDiagnosaPIController extends MasterDiagnosaController
{
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlTabularList()
  {
    return $this->module->id . '/TabularListMPI/Admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlKelompokDiagnosa()
  {
    return $this->module->id . '/kelompokdiagnosaMPI/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlKlasifikasiDiagnosa()
  {
    return $this->module->id . '/klasifikasiDiagnosaPI/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlDTD()
  {
    return $this->module->id . '/dtdMPI/Admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlDiagnosa()
  {
    return $this->module->id . '/diagnosaMPI/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlDiagnosaIX()
  {
    return $this->module->id . '/diagnosaICDIXMPI/admin';
  }
}
