<?php
class MasterEtiologiController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $path_view = 'hemodialisa.views.masterEtiologi.';
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->render($this->path_view.'index');
	}
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlEtiologi(){
		return $this->module->id.'/EtiologiM/Admin';
	}
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlPenyertaEtiologi(){
		return $this->module->id.'/PenyertaetiologiM/admin';
	}
	
}
