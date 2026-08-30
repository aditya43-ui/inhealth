<?php
class MasterPerujukPasienController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'sistemAdministrator.views.masterPerujukPasien.';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Master Rujukan / Perujuk Pasien";
    $this->render($this->path_view . 'index');
  }
  /**
   * url untuk tab menu
   * @return string
   */
  public function getUrlAsalRujukan()
  {
    return $this->module->id . "/AsalRujukanM/Admin";
  }
  /**
   * url untuk tab menu
   * @return string
   */
  public function getUrlRujukanDari()
  {
    return $this->module->id . "/RujukandariM/Admin";
  }
  /**
   * url untuk tab menu
   * @return string
   */
  public function getUrlRujukanKeluar()
  {
    return $this->module->id . "/RujukanKeluarM/Admin";
  }
}
