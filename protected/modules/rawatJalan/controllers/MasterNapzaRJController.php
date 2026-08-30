<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.MasterNapzaController');
class MasterNapzaRJController extends MasterNapzaController
{
  /**
   * url master jenis napza (khusus tab hanya string)
   */
  public function getUrlJenisNapza()
  {
    return $this->module->id . '/jenisnapzaMRJ/admin';
  }
  /**
   * url master napza (khusus tab hanya string)
   */
  public function getUrlNapza()
  {
    return $this->module->id . '/napzaMRJ/admin';
  }
  /**
   * url master detail napza (khusus tab hanya string)
   */
  public function getUrlDetailNapza()
  {
    return $this->module->id . '/detailnapzaMRJ/admin';
  }
}
