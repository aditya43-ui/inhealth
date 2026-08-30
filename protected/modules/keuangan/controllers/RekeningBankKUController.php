<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.RekeningBankController');
class RekeningBankKUController extends RekeningBankController
{
  public $link_bank = 'keuangan/bankMKU';
  public $link_rekening = 'keuangan/rekeningBankKU';
}
