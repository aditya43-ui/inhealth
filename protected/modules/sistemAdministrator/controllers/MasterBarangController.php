<?php

class MasterBarangController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'sistemAdministrator.views.masterBarang.';
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
  public function getUrlGolongan()
  {
    return $this->module->id . '/GolonganM/Admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlKelompok()
  {
    return $this->module->id . '/KelompokM/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlSubKelompok()
  {
    return $this->module->id . '/SubkelompokM/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlBidang()
  {
    return $this->module->id . '/BidangM/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlSatuanBarang()
  {
    return $this->module->id . '/lookupM/admin';
  }

  public function getUrlJenisBarang()
  {
    return $this->module->id . '/jenisbarangM/admin';
  }

  public function getSubSubkelompok()
  {
    return $this->module->id . '/SubsubkelompokM/admin';
  }
}
