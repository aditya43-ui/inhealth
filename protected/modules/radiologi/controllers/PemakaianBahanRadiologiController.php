<?php
Yii::import('laboratorium.controllers.PemakaianBahanController');
Yii::import('laboratorium.models.LBObatalkespasienT');
Yii::import('laboratorium.models.LBObatalkesM');
Yii::import('laboratorium.models.LBHasilPemeriksaanLabT');
Yii::import('laboratorium.models.LBPasienmasukpenunjangT');
Yii::import('laboratorium.models.LBPasienMasukPenunjangV');
class PemakaianBahanRadiologiController extends PemakaianBahanController
{
  public $path_view = "laboratorium.views.pemakaianBahan.";
  public $path_view_bmhp = "laboratorium.views.pemakaianBmhp.";
  public function actionIndex($pasienmasukpenunjang_id = null, $a = null)
  {
      $linkHalaman = CustomFunction::getUrlByMenuID(895);
      return PemakaianBahanController::actionIndex($pasienmasukpenunjang_id, $linkHalaman);
  }
  public function actionInformasi($a = null) {
      $linkHalaman = CustomFunction::getUrlByMenuID(1206);
      return PemakaianBahanController::actionInformasi($linkHalaman);
  }
}
