<?php
class MasterNapzaController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'sistemAdministrator.views.masterNapza.';
  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $this->render($this->path_view . 'index');
  }
  /**
   * url master jenis napza (khusus tab hanya string)
   */
  public function getUrlJenisNapza()
  {
    return $this->module->id . '/jenisnapzaM/admin';
  }
  /**
   * url master napza (khusus tab hanya string)
   */
  public function getUrlNapza()
  {
    return $this->module->id . '/napzaM/admin';
  }
  /**
   * url master detail napza (khusus tab hanya string)
   */
  public function getUrlDetailNapza()
  {
    return $this->module->id . '/detailnapzaM/admin';
  }
}
