<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.MasterPenyimpananController');

class MasterPenyimpananLDController extends MasterPenyimpananController
{

  public function getUrlLokasiPenyimpanan()
  {
    return $this->module->id . '/LokasiPenyimpananLD/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlRakPenyimpanan()
  {
    return $this->module->id . '/RakPenyimpananLD/admin';
  }
}
