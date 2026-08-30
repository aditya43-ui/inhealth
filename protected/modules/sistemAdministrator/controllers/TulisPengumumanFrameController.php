<?php
Yii::import('sistemAdministrator.controllers.PengumumanController');
class TulisPengumumanFrameController extends PengumumanController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */

  public $layout = '//layouts/iframe'; //karna biasanya di akses dari home
  public $defaultAction = 'admin';
}
