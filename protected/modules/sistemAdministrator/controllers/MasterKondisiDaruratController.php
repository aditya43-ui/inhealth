<?php

class MasterKondisiDaruratController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'sistemAdministrator.views.masterKondisiDarurat.';

  public function actionIndex()
  {
    $this->render($this->path_view . '/index');
  }

  /**
   * url untuk tab menu
   * @return string
   */
  public function getUrlKeadaanMasuk()
  {
    return $this->module->id . "/KeadaanMasukM/Admin";
  }
  /**
   * url untuk tab menu
   * @return string
   */
  public function getUrlTransportasi()
  {
    return $this->module->id . "/TransportasiM/Admin";
  }
  /**
   * url untuk tab menu
   * @return string
   */
  public function getUrlTriase()
  {
    return $this->module->id . "/TriaseM/Admin";
  }
  /**
   * url untuk tab menu
   * @return string
   */
  public function getUrlKondisiPulang()
  {
    return $this->module->id . "/KondisiPulangM/Admin";
  }
  /**
   * url untuk tab menu
   * @return string
   */
  public function getUrlCaraKeluar()
  {
    return $this->module->id . "/CaraKeluarM/Admin";
  }
}
