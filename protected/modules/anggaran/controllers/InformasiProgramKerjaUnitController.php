<?php

class InformasiProgramKerjaUnitController extends MyAuthController
{
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	
	public function actionIndex()
	{
		$model = new AGInformasiprogramkerjaunitV();
		
		if(isset($_GET['AGInformasiprogramkerjaunitV'])){
			$model->attributes = $_GET['AGInformasiprogramkerjaunitV'];
		}
		$this->render('index',array(
									'model'=>$model,
							));
	}
	
}