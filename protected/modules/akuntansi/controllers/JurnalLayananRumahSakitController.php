<?php
class JurnalLayananRumahSakitController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'akuntansi.views.jurnalLayananRumahSakit.';

  public function actionIndex()
  {
    $this->render($this->path_view . 'index', array());
  }

  public function getUrlJurnalPiutang()
  {
    return $this->module->id . '/JurnalLayananPiutangPasien/index';
  }
}
