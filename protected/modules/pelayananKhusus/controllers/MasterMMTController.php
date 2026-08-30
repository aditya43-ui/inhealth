<?php
class MasterMMTController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'index';
	public $path_view = 'rehabMedis.views.masterMMT.';
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
	public function getUrlPemeriksaanFisikGerakDasar(){
		return $this->module->id.'/PemeriksaanFisikGerakDasarM/Admin';
	}
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlFungsiGerakDasarSinistra(){
		return $this->module->id.'/FungsiGerakDasarSinistraM/admin';
	}

}
