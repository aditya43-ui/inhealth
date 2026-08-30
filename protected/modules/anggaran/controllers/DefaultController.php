<?php

class DefaultController extends MyAuthController
{
	public function actionIndex()
	{
		$this->render('index');
	}
}