<?php
class MasterDiagnosaKeperawatanController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'sistemAdministrator.views.masterDiagnosaKeperawatan.';
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
  public function getUrlDiagnosaKep()
  {
    return $this->module->id . '/DiagnosakepM/Admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlBatasKarakteristik()
  {
    return $this->module->id . '/BatasKarakteristik/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlFaktorRisiko()
  {
    return $this->module->id . '/FaktorRisiko/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlFaktorHub()
  {
    return $this->module->id . '/FaktorHub/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlTujuan()
  {
    return $this->module->id . '/Tujuan/admin';
  }

  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlKriteriaHasil()
  {
    return $this->module->id . '/KriteriaHasil/admin';
  }

  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlTandaGejala()
  {
    return $this->module->id . '/TandaGejala/admin';
  }

  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlIntervensi()
  {
    return $this->module->id . '/Intervensi/admin';
  }

  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlAlternatifDx()
  {
    return $this->module->id . '/AlternatifDx/admin';
  }
}
