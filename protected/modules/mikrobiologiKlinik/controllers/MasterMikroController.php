<?php
class MasterMikroController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'mikrobiologiKlinik.views.masterMikro.';
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
  public function getUrlPemeriksaanmikro()
  {
    return $this->module->id . '/PemeriksaanMikro/Admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlJenisMikro()
  {
    return $this->module->id . '/JenisMikroM/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
 
}
