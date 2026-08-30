<?php
Yii::import('ambulans.controllers.PemesananAmbulansPasienRSController');
Yii::import('ambulans.models.*');
/**
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * @website	<.com>
 * @package application.modules.persalinan
 * @subpackage controllers
 */
class PemesananAmbulansPasienRSPSController extends PemesananAmbulansPasienRSController
{
  public $defaultAction = 'pemesanan';
  public function actionIndex($a = null)
  {
      $linkHalaman = CustomFunction::getUrlByMenuID(3331);
      return PemesananAmbulansPasienRSController::actionIndex($linkHalaman);
  }
}
