<?php

class MobileModule extends CWebModule
{
    public $defaultController = 'default';
        
    public function init()
    {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application

        // import the module-level models and components
        $this->setImport(array(
                'mobile.models.*',
			
                'mobile.components.*',
                'mobile.controllers.MyMobileAuthController',
        ));

        if(!empty($_REQUEST['modul_id']))
            Yii::app()->session['modul_id'] = $_REQUEST['modul_id'];
    }
//    public function beforeControllerAction($controller, $action) {
//        Yii::app()->errorHandler->errorAction='admin/default/error';
//    }
}
