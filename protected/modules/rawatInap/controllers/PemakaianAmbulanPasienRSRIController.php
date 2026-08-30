<?php
Yii::import('ambulans.controllers.PemakaianAmbulanPasienRSController');
Yii::import('ambulans.models.*');
class PemakaianAmbulanPasienRSRIController extends PemakaianAmbulanPasienRSController
{
  public $defaultAction = 'pemesanan';
  public $regix = 'RSRI';
}
