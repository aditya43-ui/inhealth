<?php
class AlatSterilisasiSTController extends MyAuthController
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
    $this->pageTitle = Yii::app()->name . " - Alat Sterilisasi";
    $this->render('index');
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrljenisAlatSterilisasi()
  {
    return $this->module->id . '/jenisAlatSterilisasiST/admin';
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlmasterAlatSterilisasi()
  {
    return $this->module->id . '/masterAlatSterilisasiST/admin';
  }
}
