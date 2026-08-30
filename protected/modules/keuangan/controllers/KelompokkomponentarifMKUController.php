<?php

/**
 *       - controller ini untuk extends ke controller sistem administrator
 *       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 *       @website	<piindonesia.co.id>
 */

Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.KelompokkomponentarifMController');
class KelompokkomponentarifMKUController extends KelompokkomponentarifMController
{
  //public $layout = '//layouts/iframe';
  public $init = "KU";
}
