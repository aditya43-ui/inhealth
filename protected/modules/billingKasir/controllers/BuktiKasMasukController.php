<?php

class BuktiKasMasukController extends MyAuthController
{
  public $defaultAction = 'InformasiKasMasuk';

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

  public function actionInformasiKasMAsuk()
  {
    $model = new BKTandabuktibayarT();
    $model->tgl_awal = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_awal, 'yyyy-MM-dd hh:mm:ss'), 'medium', 'medium');
    $model->tgl_akhir = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($model->tgl_awal, 'yyyy-MM-dd hh:mm:ss'), 'medium', 'medium');
    $action_url = Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/' . Yii::app()->controller->action->id);
    $this->render(
      'informasiKas',
      array(
        'model' => $model,
        'action_url' => $action_url
      )
    );
  }
}
