<?php
class MasterAnestesiController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $path_view = 'sistemAdministrator.views.masterAnestesi.';
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
	public function getUrlJenisAnestesi(){
		return $this->module->id.'/JenisAnestesi/Admin';
	}
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlAnestesi(){
		return $this->module->id.'/Anestesi/admin';
	}
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlTipeAnestesi(){
		return $this->module->id.'/TipeAnestesi/admin';
	}
}
