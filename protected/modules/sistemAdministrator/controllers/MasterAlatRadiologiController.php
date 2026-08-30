<?php
class MasterAlatRadiologiController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'sistemAdministrator.views.masterAlatRadiologi.';
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
  public function getUrlAlatRadiologi()
  {
    return $this->module->id . '/AlatRadiologi/Admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlAlatPemeriksaanRad()
  {
    return $this->module->id . '/AlatPemeriksaanRad/admin';
  }
}
