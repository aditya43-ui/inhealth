<?php
class WaterTreatmentController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */	
	public $defaultAction = 'index';
	public $path_view = 'hemodialisa.views.waterTreatment.';
        
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->render($this->path_view.'index');
	}
        
        /**
	 * url untuk tab menu chlorine
	 * @return type
	 */
	public function getUrlChlorine(){
		return $this->module->id.'/chlorine/admin';
	}
        
        /**
	 * url untuk tab menu hardness
	 * @return type
	 */
	public function getUrlHardness(){
		return $this->module->id.'/hardness/admin';
	}
        
         /**
	 * url untuk tab menu tds
	 * @return type
	 */
	public function getUrlTds(){
		return $this->module->id.'/totalDisolveSolids/admin';
	}
        
        /**
	 * url untuk tab menu tps
	 * @return type
	 */
	public function getUrlTps(){
		return $this->module->id.'/totalProductCapacity/admin';
	}
        
	/**
	 * url untuk tab menu brine tank
	 * @return type
	 */
	public function getUrlBrineTank(){
		return $this->module->id.'/brineTank/admin';
	}	
}
