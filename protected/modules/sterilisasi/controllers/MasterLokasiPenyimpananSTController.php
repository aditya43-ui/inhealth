<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.MasterLokasiPenyimpananController');

class MasterLokasiPenyimpananSTController extends MasterLokasiPenyimpananController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'sistemAdministrator.views.masterLokasiPenyimpanan.';
  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Master Penyimpanan";
    $this->render($this->path_view . 'index');
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlLokasiPenyimpanan()
  {
    return $this->module->id . '/LokasiRakST/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlRakPenyimpanan()
  {
    return $this->module->id . '/SubRakST/admin';
  }
}
