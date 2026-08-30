<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.MasterPerujukPasienController');

class MasterPerujukPasienLBController extends MasterPerujukPasienController
{
	/**
	 * url untuk tab menu
	 * @return string
	 */
	public function getUrlAsalRujukan(){
		return $this->module->id."/AsalRujukanMLB/Admin";
	}
	/**
	 * url untuk tab menu
	 * @return string
	 */
	public function getUrlRujukanDari(){
		return $this->module->id."/RujukandariMLB/Admin";
	}
	/**
	 * url untuk tab menu
	 * @return string
	 */
	public function getUrlRujukanKeluar(){
		return $this->module->id."/RujukanKeluarMLB/Admin";
	}
}
