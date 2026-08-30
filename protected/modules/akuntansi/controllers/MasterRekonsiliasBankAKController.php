<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.MasterRekonsiliasBankController');
class MasterRekonsiliasBankAKController extends MasterRekonsiliasBankController
{
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlRekonBank()
  {
    return $this->module->id . '/jenisrekonsiliasibankAK/Admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlBankRekening()
  {
    return $this->module->id . '/RekonsiliasibankrekeningMAK/admin';
  }
}
