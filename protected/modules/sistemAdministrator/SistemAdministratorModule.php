<?php

class SistemAdministratorModule extends CWebModule
{
        //public $defaultController = 'moduleDashboardSA';
		public $defaultController = 'moduleDashboardDua';
		
        public $kelompokMenu = array();
        public $menu = array();

        public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'sistemAdministrator.models.*',
			'sistemAdministrator.components.*',   
			

//			'application.modules.pengaturanPemakai.models.*',
//			'application.modules.pengaturanPemakai.components.*',
//			'laboratorium.controllers.*',
//			'laboratorium.views.*',
//			'laboratorium.models.*',
//			'bedahSentral.controllers.*',
//			'bedahSentral.views.*',
//			'bedahSentral.models.*',
		));
                
                if(!empty($_REQUEST['modul_id']))
                    Yii::app()->session['modul_id'] = $_REQUEST['modul_id']; 
                if(!empty($_REQUEST['kelMenu']))
                    Yii::app()->session['kelMenu'] = $_REQUEST['kelMenu']; 
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			if (!in_array($controller->layout, array('//layouts/iframe', '//layouts/iframeB'))) {
								$controller->layout = '//layouts/mainNeonSidebar';
							}
			
			if(isset(Yii::app()->session['modul_id'])){
				//if(Yii::app()->session['modul_id'] != 1){ //jika bukan modul sis admin
					$this->kelompokMenu = KelompokmenuK::model()->findAllAktif();
					$this->menu = MenumodulK::model()->findAllAktif(array('modulk.modul_id'=>Yii::app()->session['modul_id']));
				//}
			}

			return true;
		}
		else
			return false;
	}
}