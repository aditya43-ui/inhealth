<?php
Yii::import('sistemAdministrator.controllers.PengumumanController');
class PengumumanFrameController extends PengumumanController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */

  public $layout = '//layouts/iframe'; //karna biasanya di akses dari home
  public $defaultAction = 'admin';

  public function actionAdmin()
  {
    $model = new SAPengumuman('searchTabel');
    $model->unsetAttributes();  // clear any default values
    if (isset($_GET['SAPengumuman'])) {
      $model->attributes = $_GET['SAPengumuman'];
    }
    $this->render('admin', array(
      'model' => $model,
    ));
  }

  public function actionView($id)
  {
    $model = $this->loadModel($id);
    $this->render('view', array(
      'model' => $model,
    ));
  }
}
