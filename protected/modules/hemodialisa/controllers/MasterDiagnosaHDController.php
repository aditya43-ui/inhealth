<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.MasterDiagnosaController');
class MasterDiagnosaHDController extends MasterDiagnosaController
{
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlTabularList(){
		return $this->module->id.'/TabularListMHD/Admin';
	}
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlKelompokDiagnosa(){
		return $this->module->id.'/kelompokdiagnosaMHD/admin';
	}
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlKlasifikasiDiagnosa(){
		return $this->module->id.'/klasifikasiDiagnosaHD/admin';
	}
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlDTD(){
		return $this->module->id.'/dtdMHD/Admin';
	}
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlDiagnosa(){
		return $this->module->id.'/diagnosaMHD/admin';
	}
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlDiagnosaIX(){
		return $this->module->id.'/diagnosaICDIXMHD/admin';
	}
}