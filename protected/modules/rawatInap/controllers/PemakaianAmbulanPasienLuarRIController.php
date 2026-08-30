<?php
Yii::import('ambulans.controllers.PemakaianAmbulanPasienLuarController');
Yii::import('ambulans.models.*');
class PemakaianAmbulanPasienLuarRIController extends PemakaianAmbulanPasienLuarController
{
  public $defaultAction = 'pemesanan';
  public $regix = 'RSRI';
}
