<?php
Yii::import('sistemAdministrator.controllers.LoginpemakaiKController');
class LoginPemakaiFrameController extends LoginpemakaiKController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */

  public $layout = '//layouts/iframe'; //karna biasanya di akses dari home
  public $defaultAction = 'gantiPassword';

  /**
   * @return array action filters
   */
  public function filters()
  {
    return array(
      'accessControl', // perform access control for CRUD operations
    );
  }

  /**
   * Specifies the access control rules.
   * This method is used by the 'accessControl' filter.
   * @return array access control rules
   */
  public function accessRules()
  {
    return array(
      array(
        'allow', // allow authenticated user to perform 'create' and 'update' actions
        'actions' => array($this->action->id),
        'users' => array('@'),
      ),
      array(
        'deny',  // deny all users
        'users' => array('*'),
      ),
    );
  }
}
