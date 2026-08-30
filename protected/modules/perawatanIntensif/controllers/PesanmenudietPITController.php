<?php
Yii::import('gizi.controllers.PesanmenudietTController');
Yii::import('gizi.models.*');
class PesanmenudietPITController extends PesanmenudietTController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  protected $path_view = 'gizi.views.pesanmenudietT.';

  public function actionIndex($id = null, $a = null)
  {
      $linkHalaman = CustomFunction::getUrlByMenuID(3362);
      return PesanmenudietTController::actionIndex($id, $linkHalaman);
  }
  public function actionInformasiPasien($a = null)
  {
      $linkHalaman = CustomFunction::getUrlByMenuID(2603);
      return PesanmenudietTController::actionInformasiPasien($linkHalaman);
  }
}
