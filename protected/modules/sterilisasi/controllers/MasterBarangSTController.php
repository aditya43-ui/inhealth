<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.MasterBarangController');
class MasterBarangSTController extends MasterBarangController
{

  public function actionIndex()
  {
    return MasterBarangController::actionIndex();
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlGolongan()
  {
    return $this->module->id . '/GolonganMST/Admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlKelompok()
  {
    return $this->module->id . '/KelompokMST/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlSubKelompok()
  {
    return $this->module->id . '/SubkelompokMST/admin';
  }

  public function getUrlSubSubKelompok()
  {
    return $this->module->id . '/SubsubkelompokMST/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlBidang()
  {
    return $this->module->id . '/BidangMST/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlSatuanBarang()
  {
    return $this->module->id . '/lookupMST/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlJenisBarang()
  {
    return $this->module->id . '/jenisBarangST/admin';
  }
}
