<?php

class InformasiPasienAnestesiController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $path_view='anestesi.views.informasiPasienAnestesi.';
	public $path_tips='anestesi.views.tips.';


	public function actionIndex()
	{
		$model = new ATInformasipasienanestesiV('searchInformasiPasien');
		$model->unsetAttributes();
		$model->tgl_awal = date('d M Y H:i:s');
		$model->tgl_akhir = date('d M Y H:i:s');
		
		if(isset($_GET['ATInformasipasienanestesiV'])){
			$model->attributes = $_GET['ATInformasipasienanestesiV'];
			$format = new MyFormatter();
			$model->tgl_awal  = $format->formatDateTimeForDb($_GET['ATInformasipasienanestesiV']['tgl_awal']);
			$model->tgl_akhir = $format->formatDateTimeForDb($_GET['ATInformasipasienanestesiV']['tgl_akhir']);
		}

		if (Yii::app()->request->isAjaxRequest) {
			echo $this->renderPartial('_tablePasien', array('model'=>$model));
		}else{
			$this->render('index',array('model'=>$model));
		}
	}
}
