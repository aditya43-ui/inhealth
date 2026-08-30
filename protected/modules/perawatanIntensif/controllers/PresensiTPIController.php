<?php
Yii::import('kepegawaian.controllers.PresensiTController');
Yii::import('kepegawaian.models.*');
class PresensiTPIController extends PresensiTController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';
  public $IP = Params::IP_FINGER_PRINT;
  public $Key = Params::KEY_FINGER_PRINT;

  public function actionInformasiPresensiProfil()
  {
    return PresensiTController::actionInformasiPresensiProfil();
  }
}
