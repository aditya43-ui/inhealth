<?php
Yii::import("sistemAdministrator.controllers.MasterAnestesiController");
Yii::import("sistemAdministrator.models.*");
class MasterAnestesiATController extends MasterAnestesiController
{
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlJenisAnestesi(){
		return $this->module->id.'/JenisAnestesiAT/Admin';
	}
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlAnestesi(){
		return $this->module->id.'/AnestesiAT/admin';
	}
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlTipeAnestesi(){
		return $this->module->id.'/TipeAnestesiAT/admin';
	}
}
