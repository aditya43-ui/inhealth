<?php

class PhoneBookController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  // public $layout = '//layouts/main';
  public $defaultAction = 'index';

  /**
   * Lists all models.
   */
  public function actionIndex()
  {
    $this->render('index');
  }
}
