<?php

/**
 *       - digunakan sebagai url utama untuk mengelola master grup layanan
 *       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 *       @website	<piindonesia.co.id>
 *     	
 */

class MasterLayananController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'keuangan.views.masterGrupPelayanan.';
  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Grup Layanan Kasir";
    $this->render($this->path_view . 'index');
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlGrupLayanan()
  {
    return $this->module->id . '/grupLayanan/Admin';
  }

  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlGrupLayananKasir()
  {
    return $this->module->id . '/grupLayananKasir/Admin';
  }

  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlGrupLayananKasirOa()
  {
    return $this->module->id . '/grupLayananKasirOa/admin';
  }
}
