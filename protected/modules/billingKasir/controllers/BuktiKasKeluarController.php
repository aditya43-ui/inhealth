<?php

class BuktiKasKeluarController extends MyAuthController
{
  public $defaultAction = 'InformasiKasKeluar';

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

  public function actionIndex()
  {
    if (Yii::app()->user->isGuest) {
      $this->redirect(Yii::app()->createUrl('site/login'));
    }

    $this->render(
      'index',
      array()
    );
  }

  public function actionInformasiKasKeluar()
  {
    $modKasKeluar = new BKTandabuktibayarT();
    $this->render(
      'informasiKas',
      array()
    );
  }
}
