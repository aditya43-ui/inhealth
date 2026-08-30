<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.MasterAlatLaboratoriumController');

class MasterAlatLaboratoriumLBController extends MasterAlatLaboratoriumController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlAlatLaboratorium(){
		return $this->module->id.'/AlatLaboratoriumLB/Admin';
	}
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlAlatPemeriksaanLab(){
		return $this->module->id.'/AlatPemeriksaanLabLB/admin';
	}
	
}
