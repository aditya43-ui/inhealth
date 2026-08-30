<?php
Yii::import('rawatJalan.controllers.AnamnesaController');
Yii::import('rawatJalan.models.*');
/**
 * controller utama anamnesa
 * 
 * @package application.modules.rehabMedis
 * @subpackage controllers
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link    <http://piindonesia.co.id>
 */
class AnamnesaTRMController extends AnamnesaController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';
  public $path_view = 'rawatJalan.views.anamnesa.';
}
