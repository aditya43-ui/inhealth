<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.MasterAlatRadiologiController');
class MasterAlatRadiologiROController extends MasterAlatRadiologiController
{
  public function getUrlAlatRadiologi()
  {
    return $this->module->id . '/AlatRadiologiRO/Admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlAlatPemeriksaanRad()
  {
    return $this->module->id . '/AlatPemeriksaanRadRO/admin';
  }
}
