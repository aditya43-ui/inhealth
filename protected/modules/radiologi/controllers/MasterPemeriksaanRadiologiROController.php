<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.MasterPemeriksaanRadiologiController');
class MasterPemeriksaanRadiologiROController extends MasterPemeriksaanRadiologiController
{
   /**
   * untuk url tab menu
   */
  public function getUrlPemeriksaanRad()
  {
    return "radiologi/pemeriksaanRadM/admin";
  }

  // untuk sub jenis pemeriksaan rad
  public function getUrlSubJenisPemeriksaanRad()
  {
    return $this->module->id . "/SubJenisPemeriksaanRadM/Admin";
  }
}
