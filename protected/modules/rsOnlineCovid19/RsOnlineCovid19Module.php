<?php

class RsOnlineCovid19Module extends CWebModule
{
    public $defaultController = 'ModuleDashboardROC';

    public $kelompokMenu = array();
    public $menu = array();
        
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'rsOnlineCovid19.models.*',
			'rsOnlineCovid19.components.*',
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
                                if(empty(Yii::app()->session['mobileview'])){
                                    $controller->layout = '//layouts/mainNeonSidebar';
                                    
                                }else{
                                    $controller->layout = '//layouts/mainNeonSidebar_mobile';
                                }
                            }
                        $this->kelompokMenu = KelompokmenuK::model()->findAllAktif();
                        $this->menu = MenumodulK::model()->findAllAktif(array('modulk.modul_id'=>Yii::app()->session['modul_id']));
			return true;
		}
		else
			return false;
	}
}
