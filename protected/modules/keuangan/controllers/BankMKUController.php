<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.BankMController');
class BankMKUController extends BankMController
{
  public $link_bank = 'keuangan/bankMKU';
  public $link_rekening = 'keuangan/rekeningBankKU';
  public $layout = '//layouts/iframe'; //diakses dari tab menu master - master obat
  public $defaultAction = 'admin';
}
