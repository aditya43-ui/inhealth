<?php
class MasterPemeriksaanHemodialisaController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $path_view = 'hemodialisa.views.masterPemeriksaanHemodialisa.';
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
	public function getUrlJenisTransfusi(){
		return $this->module->id.'/JenistransfusiM/Admin';
	}
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlJenisHD(){
		return $this->module->id.'/JenishdM/admin';
	}
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlJenisDialisat(){
		return $this->module->id.'/JenisdialisatM/admin';
	}
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlAksesVaskular(){
		return $this->module->id.'/AksesvaskularM/Admin';
	}
	
}
