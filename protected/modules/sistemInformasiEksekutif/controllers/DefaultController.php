<?php

class DefaultController extends MyAuthController
{
        public $layout='//layouts/column1';
	public function actionIndex()
	{
            $menus = MenumodulK::model()->findAllAktif(array('modulk.modul_id'=>Yii::app()->session['modul_id'],'t.kelmenu_id'=>62)); //62 = kelmenu_id "dashboard"
            $this->render('index', array(
                'menus'=>$menus,
            ));
	}
}