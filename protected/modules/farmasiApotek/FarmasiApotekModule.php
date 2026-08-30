<?php

class FarmasiApotekModule extends CWebModule
{
        public $defaultController = 'moduleDashboardFA';
    
        public $kelompokMenu = array();
        public $menu = array();
        
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'farmasiApotek.models.*',
			'farmasiApotek.components.*',
			'farmasiApotek.controllers.*',
//                        RND-8181
//                        'gudangUmum.controllers.PesanbarangTController',
//                        'gudangUmum.controllers.MutasibrgTController',
//                        'gudangUmum.models.*',
//                        'gudangFarmasi.models.*',
//                        'gudangFarmasi.views.*',
		));
                
                if(!empty($_REQUEST['modul_id']))
                    Yii::app()->session['modul_id'] = $_REQUEST['modul_id']; 
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
                    if ($controller->layout != '//layouts/iframe'){
								$controller->layout = '//layouts/mainNeonSidebar';
							}
                        $this->kelompokMenu = KelompokmenuK::model()->findAllAktif();
                        $this->menu = MenumodulK::model()->findAllAktif(array('modulk.modul_id'=>Yii::app()->session['modul_id']));
			return true;
		}
		else
			return false;
	}
}
