<?php

/**
 * tabulasi:
 * - nilai rujukan
 * - jenis pemeriksaan
 * - pemeriksaan lab
 * - Detail pemeriksaan
 */
class MasterPemeriksaanRadiologiController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'sistemAdministrator.views.masterPemeriksaanRadiologi.';
  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Pemeriksaan Radiologi";
    $this->render($this->path_view . 'index');
  }
  /**
   * untuk url tab menu
   */
  public function getUrlPemeriksaanRad()
  {
    return "radiologi/PemeriksaanRadM/Admin";
  }

  // untuk sub jenis pemeriksaan rad
  public function getUrlSubJenisPemeriksaanRad()
  {
    return "radiologi/SubJenisPemeriksaanRadM/Admin";
  }
}
