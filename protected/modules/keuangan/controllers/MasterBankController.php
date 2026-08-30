<?php

class MasterBankController extends MyAuthController
{
  public $layout = '//layouts/column1';
  public $defaultAction = 'index';
  public $path_view = 'keuangan.views.masterBank.';
  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Bank";
    $this->render($this->path_view . 'index');
  }
  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlBank()
  {
    return $this->module->id . '/BankMKU/Admin';
  }

  /**
   * url untuk tab menu
   * @return type
   */
  public function getUrlBankLookup()
  {
    return $this->module->id . '/BankLookup/Admin';
  }
}
