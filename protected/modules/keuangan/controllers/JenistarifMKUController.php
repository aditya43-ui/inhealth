<?php

/**
 *       - controller ini untuk extends ke controller sistem administrator
 *       @author		M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 *       @website	<piindonesia.co.id>
 */

Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.JenistarifMController');
class JenistarifMKUController extends JenistarifMController
{
  //public $layout = '//layouts/iframe';
  public $init = "KU";
}
