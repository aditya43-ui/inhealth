<?php
Yii::import('sistemAdministrator.controllers.MasterKondisiDaruratController');
Yii::import('sistemAdministrator.models.*');
class MasterKondisiDaruratRDController extends MasterKondisiDaruratController
{

  /**
   * url untuk tab menu
   * @return string
   */
  public function getUrlKeadaanMasuk()
  {
    return $this->module->id . "/KeadaanMasukMRD/Admin";
  }
  /**
   * url untuk tab menu
   * @return string
   */
  public function getUrlTransportasi()
  {
    return $this->module->id . "/TransportasiMRD/Admin";
  }
  /**
   * url untuk tab menu
   * @return string
   */
  public function getUrlTriase()
  {
    return $this->module->id . "/TriaseMRD/Admin";
  }
  /**
   * url untuk tab menu
   * @return string
   */
  public function getUrlKondisiPulang()
  {
    return $this->module->id . "/KondisiPulangMRD/Admin";
  }
  /**
   * url untuk tab menu
   * @return string
   */
  public function getUrlCaraKeluar()
  {
    return $this->module->id . "/CaraKeluarMRD/Admin";
  }
}
