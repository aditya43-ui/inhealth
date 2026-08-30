<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.MasterShiftController');
class MasterShiftKPController extends MasterShiftController
{
  public function getUrlShift()
  {
    return $this->module->id . '/ShiftKP/Admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlFormasiShift()
  {
    return $this->module->id . '/FormasishiftKP/admin';
  }
}
