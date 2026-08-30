<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.MasterBarangController');
class MasterBarangGUController extends MasterBarangController
{
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlGolongan()
  {
    return $this->module->id . '/GolonganMGU/Admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlKelompok()
  {
    return $this->module->id . '/KelompokMGU/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlSubKelompok()
  {
    return $this->module->id . '/SubkelompokMGU/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlBidang()
  {
    return $this->module->id . '/BidangMGU/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlSatuanBarang()
  {
    return $this->module->id . '/lookupMGU/admin';
  }

  public function getUrlJenisBarang()
  {
    return $this->module->id . '/jenisbarangMGU/admin';
  }

  public function getUrlSubSubKelompok()
  {
    return $this->module->id . '/SubsubkelompokMGU/admin';
  }
}
