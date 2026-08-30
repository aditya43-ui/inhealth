<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.MasterDiagnosaKeperawatanController');
class MasterDiagnosaKeperawatanASController extends MasterDiagnosaKeperawatanController
{
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlDiagnosaKep(){
		return $this->module->id.'/DiagnosakepMAS/Admin';
	}
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlBatasKarakteristik(){
		return $this->module->id.'/BatasKarakteristikAS/admin';
	}
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlFaktorRisiko(){
		return $this->module->id.'/FaktorRisikoAS/admin';
	}
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlFaktorHub(){
		return $this->module->id.'/FaktorHubAS/admin';
	}
	
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlTujuan(){
		return $this->module->id.'/TujuanAS/admin';
	}
	
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlKriteriaHasil(){
		return $this->module->id.'/KriteriaHasilAS/admin';
	}
	
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlTandaGejala(){
		return $this->module->id.'/TandaGejalaAS/admin';
	}
	
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlIntervensi(){
		return $this->module->id.'/IntervensiAS/admin';
	}
	
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlAlternatifDx(){
		return $this->module->id.'/AlternatifDxAS/admin';
	}
}
