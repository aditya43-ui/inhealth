<?php

class SettingPrintController extends MyAuthController
{
  public function actionIndex()
  {
    if (Yii::app()->user->isGuest)
      $this->redirect(Yii::app()->homeUrl);

    if (isset($_POST['print'])) {
      Yii::app()->user->setState('ukuran_kertas', $_POST['print']['ukuranKertas']);
      Yii::app()->user->setState('posisi_kertas', $_POST['print']['posisiKertas']);
      Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
    }
    $this->render('index');
  }

  // Uncomment the following methods and override them if needed
  /*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
