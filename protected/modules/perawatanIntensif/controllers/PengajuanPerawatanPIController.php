<?php
Yii::import('laundry.controllers.PengajuanPerawatanTController');
Yii::import('laundry.models.*');
Yii::import('laundry.views.*');
class PengajuanPerawatanPIController extends PengajuanPerawatanTController
{
  public $layout = '//layouts/column1';
  public $path_view = 'laundry.views.pengajuanPerawatanT.';
  public $pengPeratawan = false;
  public $pengPeratawanDet = true;

  public function actionIndex($pengperawatanlinen_id = null, $a = null)
  {
      $linkHalaman = CustomFunction::getUrlByMenuID(2637);
      return PengajuanPerawatanTController::actionIndex($pengperawatanlinen_id, $linkHalaman);
  }
}
