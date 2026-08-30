<?php
class DashboardController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $defaultAction = 'index';

  public function actionIndex()
  {
    $this->pageTitle = Yii::app()->name . " - Dashboard Informasi";
    $modMenu = MenumodulK::model()->findAllAktif(array('modulk.modul_id' => Yii::app()->session['modul_id']));
    $this->render('index', array('modMenu' => $modMenu));
  }
}
