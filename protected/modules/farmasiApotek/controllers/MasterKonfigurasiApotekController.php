<?php
class MasterKonfigurasiApotekController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'farmasiApotek.views.masterKonfigurasiApotek.';
  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Konfigurasi Apotek";
    $this->render($this->path_view . 'index');
  }
  /**
   * url master signa obat (khusus tab hanya string)
   */
  public function getUrlSignaObat()
  {
    return $this->module->id . '/signaObat/admin';
  }
  /**
   * url master sediaan obat racikan (khusus tab hanya string)
   */
  public function getUrlSediaanObatRacikan()
  {
    return $this->module->id . '/sediaanObatRacikan/admin';
  }
}
