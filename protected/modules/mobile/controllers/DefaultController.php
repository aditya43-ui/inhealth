<?php
ini_set('memory_limit', '128M');
class DefaultController extends MyAuthController
{
    public $layout = "//layouts/iframe";
	public function actionIndex()
	{
		$this->render('index');
	}
}