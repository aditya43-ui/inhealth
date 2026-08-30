<?php
class MasterPenyimpananController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'sistemAdministrator.views.masterPenyimpanan.';
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
  public function getUrlLokasiPenyimpanan()
  {
    return $this->module->id . '/LokasiPenyimpanan/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlRakPenyimpanan()
  {
    return $this->module->id . '/RakPenyimpanan/admin';
  }
}
