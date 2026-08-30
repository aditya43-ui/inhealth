<?php
Yii::import('rawatJalan.controllers.KonsulPoliController');
Yii::import('rawatJalan.models.*');
class KonsulPoliMCController extends KonsulPoliController
{
  public $layout = '//layouts/iframe';
  public $defaultAction = 'index';
  protected $path_view = 'rawatJalan.views.konsulPoli.';
  protected $successSave = true;
}
