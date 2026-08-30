<?php

class AntrianModule extends CWebModule
{
//	public $defaultController = 'tampilAntrian';
//	public $defaultController = 'tampilAntrian2';

	public $kelompokMenu = array();
	public $menu = array();

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'antrian.controllers.*',
			'antrian.models.*',
			'antrian.components.*',
		));
                 if(!empty($_REQUEST['modul_id']))
                    Yii::app()->session['modul_id'] = $_REQUEST['modul_id']; 
	}
        
        public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			
//			$modul_id = $_GET['modul_id'];
                        $this->kelompokMenu = KelompokmenuK::model()->findAllAktif();
			//$this->menu = MenumodulK::model()->findAllAktif(array('modulk.modul_id'=>Yii::app()->session['modul_id']));
			$this->menu = MenumodulK::model()->findAllAktif(array('modulk.modul_id'=>76));
			
			//$this->beforeControllerActionAdditional($controller, $action);
			
			return true;
		}
		else
			return false;
	}
}
