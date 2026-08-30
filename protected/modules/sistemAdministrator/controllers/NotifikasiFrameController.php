<?php
Yii::import('sistemAdministrator.controllers.NotifikasiRController');
class NotifikasiFrameController extends NotifikasiRController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */

  public $layout = '//layouts/iframe'; //karna biasanya di akses dari home
  public $defaultAction = 'admin';

  public function actionAdmin()
  {
    $model = new SANofitikasiR('searchFrame');
    $model->tglnotifikasi = date("Y-m-d");
    $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
    $model->lamahrnotif = null;
    if (isset($_GET['SANofitikasiR'])) {
      $model->attributes = $_GET['SANofitikasiR'];
      $model->tglnotifikasi = isset($model->tglnotifikasi) ? MyFormatter::formatDateTimeForDb($model->tglnotifikasi) : null;
    }
    $this->render('admin', array(
      'model' => $model,
    ));
  }

  public function actionView($id)
  {
    $model = $this->loadModel($id);
    $model->isread = true;
    $model->save();
    $this->render('view', array(
      'model' => $model,
    ));
  }
}
