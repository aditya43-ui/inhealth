<?php

class ReturDetailController extends MyAuthController
{
  /**
   * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   * using two-column layout. See 'protected/views/layouts/column2.php'.
   */
  public $layout = '//layouts/column1';
  public $defaultAction = 'admin';

  /**
   * Manages all models.
   */
  public function actionSearch()
  {
    $model = new GFReturDetailT('searchGudangFarmasi');
    $format = new MyFormatter();
    $model->tgl_awal = date('Y-m-d');
    $model->tgl_akhir = date('Y-m-d');
    //		$model->unsetAttributes();  // clear any default values
    if (isset($_GET['GFReturDetailT'])) {
      $model->attributes = $_GET['GFReturDetailT'];
      $model->tgl_awal  = $format->formatDateTimeForDb($_REQUEST['GFReturDetailT']['tgl_awal']);
      $model->tgl_akhir = $format->formatDateTimeForDb($_REQUEST['GFReturDetailT']['tgl_akhir']);
      $model->namaObat = $_GET['GFReturDetailT']['namaObat'];
      $model->noRetur = $_GET['GFReturDetailT']['noRetur'];
      $model->noFaktur = $_GET['GFReturDetailT']['noFaktur'];
    }

    $this->render('search', array(
      'format' => $format,
      'model' => $model,
    ));
  }

  /**
   * Returns the data model based on the primary key given in the GET variable.
   * If the data model is not found, an HTTP exception will be raised.
   * @param integer the ID of the model to be loaded
   */
  public function loadModel($id)
  {
    $model = GFReturDetailT::model()->findByPk($id);
    if ($model === null)
      throw new CHttpException(404, 'The requested page does not exist.');
    return $model;
  }

  /**
   * Performs the AJAX validation.
   * @param CModel the model to be validated
   */
  protected function performAjaxValidation($model)
  {
    if (isset($_POST['ajax']) && $_POST['ajax'] === 'gfretur-detail-t-form') {
      echo CActiveForm::validate($model);
      Yii::app()->end();
    }
  }

  /**
   *Mengubah status aktif
   * @param type $id 
   */
}
