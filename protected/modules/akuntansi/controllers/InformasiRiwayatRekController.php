<?php

class InformasiRiwayatRekController extends MyAuthController
{

  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'akuntansi.views.informasiRiwayatRek.';
  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $this->render($this->path_view . 'index');
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlRek1()
  {
    return $this->module->id . '/RiwayatRekening1/Index';
  }

  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlRek2()
  {
    return $this->module->id . '/RiwayatRekening2/Index';
  }

  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlRek3()
  {
    return $this->module->id . '/RiwayatRekening3/Index';
  }

  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlRek4()
  {
    return $this->module->id . '/RiwayatRekening4/Index';
  }

  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlRek5()
  {
    return $this->module->id . '/RiwayatRekening5/Index';
  }

  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlTipeRek()
  {
    return $this->module->id . '/RiwayatTipeRekening/Index';
  }

  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlKelRek()
  {
    return $this->module->id . '/RiwayatKelRekening/Index';
  }
}
