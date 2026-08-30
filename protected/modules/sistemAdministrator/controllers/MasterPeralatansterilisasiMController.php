<?php
class MasterPeralatansterilisasiMController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'sistemAdministrator.views.masterPeralatansterilisasiM.';
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
  public function getUrlPeralatanSterilisasi()
  {
    return $this->module->id . '/PeralatansterilisasiM/Admin';
  }

  public function getUrlMapBarangSterilisasi()
  {
    return $this->module->id . '/mapbarangsterilisasiM/Admin';
  }
  public function getUrlMapAlkesSterilisasi()
  {
    return $this->module->id . '/mapalkessterilisasiM/Admin';
  }
  public function getUrlMapLinenSterilisasi()
  {
    return $this->module->id . '/maplinensterilisasiM/Admin';
  }
}
