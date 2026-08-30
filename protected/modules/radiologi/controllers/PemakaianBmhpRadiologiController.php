<?php
Yii::import('laboratorium.controllers.PemakaianBmhpController');
Yii::import('laboratorium.models.LBObatalkespasienT');
Yii::import('laboratorium.models.LBObatalkesM');
Yii::import('laboratorium.models.LBHasilPemeriksaanLabT');
Yii::import('laboratorium.models.LBPasienmasukpenunjangT');
Yii::import('laboratorium.models.LBPasienMasukPenunjangV');
class PemakaianBmhpRadiologiController extends PemakaianBmhpController
{
  public $path_view = "laboratorium.views.pemakaianBmhp.";
  //    public $obatalkespasientersimpan = true; //dilooping
}
