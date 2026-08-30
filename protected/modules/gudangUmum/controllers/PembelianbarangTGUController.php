<?php
Yii::import('pengadaan.models.*');
Yii::import('pengadaan.controllers.PembelianbarangTController');
class PembelianbarangTGUController extends PembelianbarangTController
{
  public $path_permintaan = 'PembelianbarangTGU';
	public function actionIndex($id = null, $rencana_id = null, $linkHalaman = null)
  {
      $linkHalaman = CustomFunction::getUrlByMenuID(1948);
      return PembelianbarangTController::actionIndex($id, $rencana_id, $linkHalaman);
  }
  public function actionInformasi($a = null) {
      $linkHalaman = CustomFunction::getUrlByMenuID(2099);
      return PembelianbarangTController::actionInformasi($linkHalaman);
  }
}
