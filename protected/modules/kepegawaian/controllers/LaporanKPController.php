<?php
Yii::import('keuangan.models.*');
Yii::import("penggajian.models.*");
Yii::import("billingKasir.models.*");
Yii::import('penggajian.controllers.LaporanController');
class LaporanKPController extends LaporanController
{
  public $path_view_ku = 'keuangan.views.laporanKu.';
  public $init = 'KUKP';
}
