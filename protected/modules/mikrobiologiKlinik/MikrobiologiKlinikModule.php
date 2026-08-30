<?php
/**
 * digunakan untuk akses modul mikrobiologi klinik
 * RSST-5079
 * @package modules 
 * @author M Iqbal Laksana <iqbal.laksana@piindonesia.co.id> 
 * @version     2.0.0
 * @link    <http://172.9.1.15/simpp/docs/>
 * @link    <http://piindonesia.co.id>
 */
class MikrobiologiKlinikModule extends CWebModule
{
        public $defaultController = 'moduleDashboardMK';
    
        public $kelompokMenu = array();
        public $menu = array();
        
        /**
         * digunakan untuk iniassi awal ketika akses modul ini
         */
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'mikrobiologiKlinik.models.*',
			'mikrobiologiKlinik.components.*',
		));
        if(!empty($_REQUEST['modul_id']))
			Yii::app()->session['modul_id'] = $_REQUEST['modul_id']; 
	}
	public function beforeControllerAction($controller, $action) {
        if (parent::beforeControllerAction($controller, $action)) {

            // this method is called before any module controller action is performed
            // you may place customized code here
            //if ( strtolower(Yii::app()->controller->id) ==  strtolower('ModuleDashboardNeonDua')){
            if ($controller->layout != '//layouts/iframe') {
                $controller->layout = '//layouts/mainNeonSidebar';
            }
            //	}
            $this->kelompokMenu = KelompokmenuK::model()->findAllAktif();
            $this->menu = MenumodulK::model()->findAllAktif(array('modulk.modul_id' => Yii::app()->session['modul_id']));
            return true;
        } else
            return false;
    }

}
